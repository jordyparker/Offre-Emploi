<?php


namespace Projet\Controller\Membre;


use DateTime;
use Projet\Controller\Page\PageController;
use Projet\Database\Candidat;
use Projet\Database\Competence;
use Projet\Database\Entreprise;
use Projet\Database\Experience;
use Projet\Database\Formation;
use Projet\Database\Langue;
use Projet\Database\Message;
use Projet\Database\Offre;
use Projet\Database\Postuler;
use Projet\Model\App;
use Projet\Model\FileHelper;
use function Projet\var_die;

class PostulerController extends PageController
{
    public function jobsingle()
    {
        $this->render("page.home.jobsingle");
    }

    public function index()
    {
        if(App::getDBAuth()->isLogged()){
            $user = App::getDBAuth()->user();
            if(Entreprise::byEmail($user->email)){
                $nbreParPage = 50;
                if(isset($_GET['titre'])&&isset($_GET['nom'])&&isset($_GET['id'])){
                    $nom=(!empty($_GET['nom']))? $_GET['nom']:null;
                    $titre = (!empty($_GET['titre'])) ? $_GET['titre'] : null;
                    $id = (!empty($_GET['id'])) ? $_GET['id'] : null;
                    $nbre = Postuler::countBySearchType($titre,$nom,null,$id);
                    $nbrePages = ceil($nbre->Total / $nbreParPage);
                    if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                        $pageCourante = $_GET['page'];
                    } else {
                        $pageCourante = 1;
                        $params['page'] = $pageCourante;
                    }
                    $postuler = Postuler::searchType($nbreParPage,$pageCourante,$titre,$nom,null,$id);
                }else{
                    if(isset($_GET['id'])){
                        $id=(!empty($_GET['id']))? $_GET['id']:null;
                        $nbre = Postuler::countBySearchType(null,null,null,$id);
                        $nbrePages = ceil($nbre->Total / $nbreParPage);
                        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                            $pageCourante = $_GET['page'];
                        } else {
                            $pageCourante = 1;
                            $params['page'] = $pageCourante;
                        }
                        $postuler = Postuler::searchType($nbreParPage,$pageCourante,null,null,null,$id);
                    }
                }
                $this->render('page.home.ListeCandidature',compact('postuler','user','nbre','nbrePages'));
            }else{
                $this->session->write('warning',"Seul les entreprise peuvent consulter les candidatures");
                App::interdit();
            }
        }else{
            $this->session->write('warning',"Vous devrez d'abord vous inscrire ou vous connecter");
            App::interdit();
        }
    }

    public function detail()
    {
        if(isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['ido']) && !empty($_GET['ido'])){
            $id = (int) $_GET['id'];
            $ido = (int) $_GET['ido'];
            $candidat = Candidat::find($id);
            $formations = Formation::findC($id);
            $competences = Competence::findC($id);
            $langues = Langue::findL($id);
            $experiences = Experience::findE($id);
            $postuler = Postuler::findDo($id,$ido);
            $this->render('page.home.detail',compact('candidat','formations','competences','langues','experiences','postuler'));
        }

    }

    public function add()
    {
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['idC']) && !empty($_POST['idC']) && isset($_POST['idO']) && !empty($_POST['idO'])){
            $idC = (int)$_POST['idC'];
            $idO = (int)$_POST['idO'];
            $candidat = Candidat::find($idC);
            $offre = Offre::find($idO);
            if(Postuler::findPost($idC,$idO) == 0){
                if(isset($_FILES['fileA']['name']) &&isset($_FILES['fileC']['name']) &&!empty($_FILES['fileC']['name']) &&isset($_FILES['fileM']['name'])){
                    $extensions_valides = array('jpg','jpeg','png','JPG','JPEG','PNG','pdf','PDF','docx','DOCX');
                    $extension_uploadA = strtolower(  substr(  strrchr($_FILES['fileA']['name'], '.')  ,1)  )  != '' ? strtolower(  substr(  strrchr($_FILES['fileA']['name'], '.')  ,1)  ) : 'png';
                    $extension_uploadC = strtolower(  substr(  strrchr($_FILES['fileC']['name'], '.')  ,1)  ) != '' ? strtolower(  substr(  strrchr($_FILES['fileC']['name'], '.')  ,1)  ) :'png';
                    $extension_uploadM = strtolower(  substr(  strrchr($_FILES['fileM']['name'], '.')  ,1)  ) != '' ? strtolower(  substr(  strrchr($_FILES['fileM']['name'], '.')  ,1)  ) :'png';
                    if(in_array($extension_uploadA,$extensions_valides) && in_array($extension_uploadM,$extensions_valides)
                        && in_array($extension_uploadC,$extensions_valides)){
                        if($_FILES['fileA']['size']<=1000000 && $_FILES['fileM']['size']<=1000000 && $_FILES['fileC']['size']<=1000000){
                            $rootA = FileHelper::moveImage($_FILES['fileA']['tmp_name'],"assets/images","png","",true);
                            $rootC = FileHelper::moveImage($_FILES['fileC']['tmp_name'],"assets/images","png","",true);
                            $rootM = FileHelper::moveImage($_FILES['fileM']['tmp_name'],"assets/images","png","",true);
                            try {
                                $pdo = App::getDb()->getPDO();
                                $pdo->beginTransaction();
                                $etab = Formation::findC($idC);
                                $cmp = Competence::findC($idC);
                                $exp = Experience::findE($idC);
                                if(!empty($etab) && !empty($cmp) && !empty($exp)){
                                    $date = new DateTime();
                                    if($date->format(MYSQL_DATE_FORMAT) > $offre->delais){
                                        $message = "vous ne pouvez pas postuler à cette offre car la date de délais est passé";
                                        $return = array('statuts' =>1 ,'mes' =>$message);
                                    }else{
                                        Postuler::save($idC,$candidat->nom,$idO,$offre->idEntreprise,$offre->titre,$rootC,$rootM,$rootA);
                                        $message = "Vous avez postuler à cette offre avec success";
                                        $this->session->write('success', $message);
                                        $pdo->commit();
                                        $return = array("statuts" => 0, "mes" => $message);
                                    }
                                }else{
                                    $message = "Veuillez créér votre curriculum vitae avant de postuler à cette offre";
                                    $return = array('statuts' =>1 ,'mes' =>$message);
                                }
                            } catch (Exception $e) {
                                $pdo->rollBack();
                                $message = $this->error;
                                $return = array("statuts" => 1, "mes" => $message);
                            }
                        }
                        else{
                            $erreur =  'Le fichier est troip grand';
                            $return = array("statuts"=>1, "mes"=>$erreur);
                        }
                    }else{
                        $erreur = "Formats d'image demandé (pdf,docx,png,jpg,jgep,jpeg)";
                        $return = array("statuts"=>1, "mes"=>$erreur);
                    }
                }else{
                    $return = array("statuts" => 1, "mes" => "Veuillez entrer une CNI");
                }
            }else{
                $message = "Vous avez déja postuler a cette offre";
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = "Une érreur est apparue, veuillez rechargé et réassayer";
            $return = array("statuts" => 1, "mes" => $message);
        }
       echo json_encode($return);
    }
    public function message()
    {
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['description']) && !empty($_POST['description']) && isset($_POST['idO']) && !empty($_POST['idO']) && isset($_POST['idC']) && !empty($_POST['idC'])){
            $idC = (int)$_POST['idC'];
            $idO = (int)$_POST['idO'];
            $message = $_POST['description'];
            $pdo = App::getDb()->getPDO();
            try {
                $pdo->beginTransaction();
                Message::save($idC,$idO,$message);
                $message = "Le message a été ajouté avec succès";
                $this->session->write('success', $message);
                $pdo->commit();
                $return = array("statuts" => 0, "mes" => $message);
            } catch (Exception $e) {
                $pdo->rollBack();
                $message = $this->error;
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = "Une érreur est apparue, veuillez rechargé et réassayer";
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }
}