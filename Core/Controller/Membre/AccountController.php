<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 15/05/2019
 * Time: 16:46
 */

namespace Projet\Controller\Membre;


use Projet\Database\Candidat;
use Projet\Database\Message;
use Projet\Database\Competence;
use Projet\Database\Entreprise;
use Projet\Database\Experience;
use Projet\Database\Formation;
use Projet\Database\Langue;
use Exception;
use Projet\Database\Offre;
use Projet\Database\Postuler;
use Projet\Model\App;
use function Projet\var_die;

class AccountController extends MembreController
{

    public function account(){
        $user = $this->user;
        $formations = Formation::findC($user->id);
        $experiences = Experience::findE($user->id);
        $competences = Competence::findC($user->id);
        $langues = Langue::findL($user->id);
        $this->render('page.home.account',compact('user','formations','experiences','competences','langues'));
    }

    public function updateCandidat(){
        $this->render('page.home.profilCandidat');
    }
    public function updateEntreprise(){
        $this->render('page.home.profilEntreprise');
    }

    public function cv(){
        $this->render('page.home.monCv');
    }

    public function consulter(){
        if(App::getDBAuth()->isLogged()){
            $user = App::getDBAuth()->user();
            if(Candidat::byEmail($user->email)){
                $nbreParPage = 50;
                if(isset($_GET['titre']) && isset($_GET['id'])){
                    $titre=(!empty($_GET['titre']))? $_GET['titre']:null;
                    $idC=(!empty($_GET['id']))? $_GET['id']:null;
                    $nbre = Postuler::countBySearchType($titre,null,$idC);
                    $nbrePages = ceil($nbre->Total / $nbreParPage);
                    if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                        $pageCourante = $_GET['page'];
                    } else {
                        $pageCourante = 1;
                        $params['page'] = $pageCourante;
                    }
                    $postuler = Postuler::searchType($nbreParPage, $pageCourante,$titre,null,$idC);
                }else{
                    if(isset($_GET['id'])){
                        $id=(!empty($_GET['id']))? $_GET['id']:null;
                        $nbre = Postuler::countBySearchType(null,null,$id);
                        $nbrePages = ceil($nbre->Total / $nbreParPage);
                        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                            $pageCourante = $_GET['page'];
                        } else {
                            $pageCourante = 1;
                            $params['page'] = $pageCourante;
                        }
                        $postuler = Postuler::searchType($nbreParPage,$pageCourante,null,null,$id);
                    }
                }
                $this->render('page.home.consultCandidature',compact('postuler','user','nbrePages'));
            }else{
                $this->session->write('warning',"Seul les candidats peuvent consulter leurs candidatures");
                App::interdit();
            }
        }else{
            $this->session->write('warning',"Vous devrez d'abord vous inscrire ou vous connecter");
            App::interdit();
        }
    }

    public function delete(){
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $data = $_POST['id'];
            $id = explode("#",$data);
            $postuler = Postuler::findDo($id[0],$id[1]);
            try{
                $pdo = App::getDb()->getPDO();
                $pdo->beginTransaction();
                Postuler::deleteC($id[0],$id[1]);
                $message = "Vous avez supprimer la candidature avec succès";
                $this->session->write('success',$message);
                $pdo->commit();
                $return = array("statuts" => 0, "mes" => $message);
            }catch (Exception $e){
                $pdo->rollBack();
                $message = $this->error;
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = $this->error;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function deleteC(){
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['ido']) && !empty($_POST['ido'])){
            $id = $_POST['id'];
            $ido = $_POST['ido'];
            try{
                $pdo = App::getDb()->getPDO();
                $pdo->beginTransaction();
                Postuler::deleteC($id,$ido);
                if(Message::findM($id,$ido)){
                    Message::deleteMe($id,$ido);
                }
                $message = "Vous avez supprimer votre candidature avec succès";
                $this->session->write('success',$message);
                $pdo->commit();
                $return = array("statuts" => 0, "mes" => $message);
            }catch (Exception $e){
                $pdo->rollBack();
                $message = $this->error;
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = $this->error;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function deleteO(){
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $id = $_POST['id'];
            try{
                $pdo = App::getDb()->getPDO();
                $pdo->beginTransaction();
                Offre::delete($id);
                if(Postuler::findO($id))
                {
                    Postuler::deleteOffrePostuler($id);
                }
                if(Message::findMess($id)){
                    Message::deleteO($id);
                }
                $message = "Vous avez supprimer cette emploi avec succès";
                $this->session->write('success',$message);
                $pdo->commit();
                $return = array("statuts" => 0, "mes" => $message);
            }catch (Exception $e){
                $pdo->rollBack();
                $message = $this->error;
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = $this->error;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }
}