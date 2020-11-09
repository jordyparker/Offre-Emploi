<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 17/07/2015
 * Time: 13:14
 */

namespace Projet\Controller\Site;

use Projet\Auth\DBAuth;
use Projet\Database\Candidat;
use Projet\Database\Entreprise;
use Projet\Database\Offre;
use Projet\Database\Realisation;
use Projet\Model\App;
use Projet\Model\Random;
use function Projet\var_die;

class HomeController extends SiteController {

    public function index() {
        $nbreParPage = 50;
        if(isset($_GET['search'])&&isset($_GET['debut'])&&isset($_GET['end'])){
            $debut=(!empty($_GET['debut']))? $_GET['debut']:null;
            $fin=(!empty($_GET['fin']))? $_GET['fin']:null;
            $search = (!empty($_GET['search'])) ? $_GET['search'] : null;
            $nbre = Offre::countBySearchType($search,$debut,$fin);
            $nbrePages = ceil($nbre->Total / $nbreParPage);
            if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbrePages) {
                $pageCourante = $_GET['page'];
            } else {
                $pageCourante = 1;
                $params['page'] = $pageCourante;
            }
            $emplois = Offre::searchType($nbreParPage,$pageCourante,$search,$debut,$fin);
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
        $offre = Offre::count();
        $candidat = Candidat::count();
        $entreprise = Entreprise::count();
        $this->render('page.home.index',compact('emplois',"nbre","nbrePages","offre","entreprise","candidat"));
    }

    public function error()
    {
        $this->render('page.home.error');
    }

    public function log(){
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['user'])){
            $login = $_POST['email'];
            $password = $_POST['password'];
            $users = $_POST['user'];
            if(!empty($login)&&!empty($password)&&!empty($users)){
                $conMessage = App::getDBAuth()->login($login,sha1($password),$users);
                if(is_bool($conMessage)){
                    $lien = empty($this->session->read('lastUrlAsked'))?App::url('account'):$this->session->read('lastUrlAsked');
                    $this->session->delete('lastUrlAsked');
                    $return = array("statuts" => 0, "direct"=>$lien);
                }else{
                    $return = array("statuts" => 1, "mes" => $conMessage);
                }
            }else{
                $message = "Renseignez tous les champs";
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = "Renseignez tous les champs";
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function resetPassword(){
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['email'])&&!empty($_POST['email'])){
            $email = $_POST['email'];
            $user = Entreprise::byEmail($email);
            if($user){
                $code = Random::string();
                Entreprise::setPassword($code, DATE_COURANTE,$user->id);
                $message = "Vous avez réçu un email au $email, contenant un code de réinitialisation.";
                $emailSend = mail($email,"Réinitialisation du mot de passe", "Hello $user->nom, $code est le nouveau mot de passe pour votre compte.\nJobAlert vous remercie");
                if($emailSend){
                    $return = array("statuts" => 0, "mes" => $message);
                }else{
                    $message = "Une erreur est survenue lors de l'envoie du mail";
                    $return = array("statuts" => 1, "mes" => $message);
                }
            }else{
                $message = "Aucun compte n'est associé à cet email";
                $return = array("statuts" => 1, "mes" => $message);
            }
        }else{
            $message = "Veuillez renseigner votre email";
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function logout(){
        if(App::getDBAuth()->signOut()){
            $this->session->delete('dbauth');
            $this->session->delete('type');
            App::redirect(App::url("login"));
        }
    }
}