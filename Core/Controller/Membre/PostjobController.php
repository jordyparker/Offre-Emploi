<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 19/05/2019
 * Time: 19:26
 */

namespace Projet\Controller\Membre;

use Projet\Controller\Page\PageController;
use Projet\Database\Email;
use Projet\Database\Entreprise;
use DateTime;
use Projet\Database\Offre;
use Projet\Model\App;
use function Projet\var_die;

class PostjobController extends PageController
{
    public function postjob()
    {
        if(App::getDBAuth()->isLogged()){
            $user = App::getDBAuth()->user();
            if(Entreprise::byEmail($user->email)){
                $this->render('page.home.account');
            }
            $this->session->write('warning',"Vous devrez d'abord vous inscrire ou vous connecter");
            App::interdit();
        }else{
            $this->session->write('warning',"Vous devrez d'abord vous inscrire ou vous connecter");
            App::interdit();
        }
    }

    public function index() {
        $nbreParPage = 50;
        if(isset($_GET['titre'])&&isset($_GET['lieu'])&&isset($_GET['categorie'])){
            $titre=(!empty($_GET['titre']))? $_GET['titre']:null;
            $lieu=(!empty($_GET['lieu']))? $_GET['lieu']:null;
            $categorie = (!empty($_GET['categorie'])) ? $_GET['categorie'] : null;
            $nbre = Offre::countBySearchType(null,$titre,$lieu,$categorie);
            $nbrePages = ceil($nbre->Total / $nbreParPage);
            if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                $pageCourante = $_GET['page'];
            } else {
                $pageCourante = 1;
                $params['page'] = $pageCourante;
            }
            $emplois = Offre::searchType($nbreParPage,$pageCourante,null,$titre,$lieu,$categorie);
        }else{
            $nbre = Offre::countBySearchType();
            $nbrePages = ceil($nbre->Total / $nbreParPage);
            if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                $pageCourante = $_GET['page'];
            } else {
                $pageCourante = 1;
                $params['page'] = $pageCourante;
            }
            $emplois = Offre::searchType($nbreParPage,$pageCourante);

        }
        $this->render('page.home.emplois',compact('emplois',"nbre","nbrePages"));
    }

    public function categorie() {
        $nbreParPage = 50;
        if(isset($_GET['titre'])&&isset($_GET['lieu'])&&isset($_GET['categorie'])&&isset($_GET['id'])){
            $titre=(!empty($_GET['titre']))? $_GET['titre']:null;
            $lieu=(!empty($_GET['lieu']))? $_GET['lieu']:null;
            $id=(!empty($_GET['id']))? $_GET['id']:null;
            $categorie = (!empty($_GET['categorie'])) ? $_GET['categorie'] : null;
            $nbre = Offre::countBySearchType(null,$titre,$lieu,$categorie,$id);
            $nbrePages = ceil($nbre->Total / $nbreParPage);
            if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                $pageCourante = $_GET['page'];
            } else {
                $pageCourante = 1;
                $params['page'] = $pageCourante;
            }
            $categorie = Offre::searchType($nbreParPage,$pageCourante,null,$titre,$lieu,$categorie,$id);
        }else{
            if(isset($_GET['id'])){
                $id=(!empty($_GET['id']))? $_GET['id']:null;
                $nbre = Offre::countBySearchType(null,null,null,null,$id);
                $nbrePages = ceil($nbre->Total / $nbreParPage);
                if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                    $pageCourante = $_GET['page'];
                } else {
                    $pageCourante = 1;
                    $params['page'] = $pageCourante;
                }
                $categorie = Offre::searchType($nbreParPage,$pageCourante,null,null,null,null,$id);
            }

        }
        $this->render('page.home.categorie',compact('categorie',"nbre","nbrePages"));
    }

    public function save()
    {
        header('content-type: application/json');
        $return = [];
        $entreprise = App::getDBAuth()->user();
        if (isset($_POST['titre']) && !empty($_POST['titre']) && isset($_POST['categorie']) && !empty($_POST['categorie'])
            && isset($_POST['salaire']) && isset($_POST['lieu']) && !empty($_POST['lieu']) && isset($_POST['domaine']) && !empty($_POST['domaine'])
            && isset($_POST['delais']) && !empty($_POST['delais'])  && isset($_POST['ville']) && !empty($_POST['ville'])
            && isset($_POST['description']) && !empty($_POST['description'])&& isset($_POST['offre'])) {
            $titre = $_POST['titre'];
            $categorie = $_POST['categorie'];
            $salaire =(float) $_POST['salaire'];
            $lieu = $_POST['lieu'];
            $ville = $_POST['ville'];
            $delais = $_POST['delais'];
            $domaine = $_POST['domaine'];
            $id = (int)$_POST['offre'];
            $description = $_POST['description'];
            $idEntreprise = $entreprise->id;
            $errorSalaire = "Le salaire ne doit pas être négatif, veuillez changer";
            $errorTitre = "Vous avez déja posté un emploi avec ce titre, veuillez le changer";
            $i = 0;
            $bool = true;
            if ($salaire < 0) {
                $bool = $errorSalaire;
            }
            if (Offre::findTitre($titre)) {
                $bool = $errorTitre;
            }
            if (!empty($id)) {
                $offre = Offre::find($id);
                if ($offre) {
                    $pdo = App::getDb()->getPDO();
                    try {
                        $date = new DateTime($delais);
                        $pdo->beginTransaction();
                        Offre::save($titre,$description,$categorie,$date->format(MYSQL_DATE_FORMAT),$lieu,$salaire,$ville,$domaine,$idEntreprise,$offre->id);
                        $pdo->commit();
                        $message = "L'emploi a été modifié avec succès";
                        $return = array("statuts" => 0, "mes" => $message);
                        $this->session->write('success', $message);
                    } catch (Exception $e) {
                        $pdo->rollBack();
                        $erreur = $e->getMessage();
                        $return = array("statuts" => 1, "mes" => $erreur);
                    }
                }
            }else{
                if (is_bool($bool)) {
                    $pdo = App::getDb()->getPDO();
                    try {
                        $pdo->beginTransaction();
                        $date = new DateTime($delais);
                        Offre::save($titre,$description,$categorie,$date->format(MYSQL_DATE_FORMAT),$lieu,$salaire,$ville,$domaine,$idEntreprise);
                        $newsletter = Email::all();
                        if(!empty($newsletter))
                        {
                            foreach ($newsletter as $ne){
                                mail($ne->email,"Nouvelle offre d'emploi poster sur JobAlert",$titre."\n".$description);
                            }
                        }
                        $message = "L'emploi a été posté avec succès";
                        $this->session->write('success', $message);
                        $pdo->commit();
                        $return = array("statuts" => 0, "mes" => $message);
                    } catch (Exception $e) {
                        $pdo->rollBack();
                        $message = $this->error;
                        $return = array("statuts" => 1, "mes" => $message);
                    }
                }
                else {
                    $return = array("statuts" => 1, "mes" => $bool);
                }
            }
        } else {
            $message = $this->empty;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function liste()
    {
        if(App::getDBAuth()->isLogged()){
            $user = App::getDBAuth()->user();
            if(Entreprise::byEmail($user->email)){
                $nbreParPage = 50;
                if(isset($_GET['titre']) && isset($_GET['id'])){
                    $titre = (!empty($_GET['titre'])) ? $_GET['titre'] : null;
                    $id = (!empty($_GET['id'])) ? $_GET['id'] : null;
                    $nbre = Offre::countBySearchType($id,$titre);
                    $nbrePages = ceil($nbre->Total / $nbreParPage);
                    if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                        $pageCourante = $_GET['page'];
                    } else {
                        $pageCourante = 1;
                        $params['page'] = $pageCourante;
                    }
                    $offre = Offre::searchType($nbreParPage,$pageCourante,$id,$titre);
                }else{
                    if(isset($_GET['id'])){
                        $id=(!empty($_GET['id']))? $_GET['id']:null;
                        $nbre = Offre::countBySearchType(null,$id);
                        $nbrePages = ceil($nbre->Total / $nbreParPage);
                        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                            $pageCourante = $_GET['page'];
                        } else {
                            $pageCourante = 1;
                            $params['page'] = $pageCourante;
                        }
                        $offre = Offre::searchType($nbreParPage,$pageCourante,$id);
                    }
                }
                $this->render('page.home.listeOffre',compact('offre','user','nbre','nbrePages'));
            }else{
                $this->session->write('warning',"Seul les entreprise peuvent consulter les offres qu'ils ont publiées");
                App::interdit();
            }
        }else{
            $this->session->write('warning',"Vous devrez d'abord vous inscrire ou vous connecter");
            App::interdit();
        }
    }
}