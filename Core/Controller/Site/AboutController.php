<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 21/05/2019
 * Time: 12:24
 */

namespace Projet\Controller\Site;
use Projet\Controller\Page\PageController;
use Projet\Database\Email;
use Exception;
use Projet\Model\App;
use function Projet\var_die;

class AboutController extends PageController
{
    public function subscribe(){
        header('content-type: application/json');
        if (isset($_POST['email'])&&!empty($_POST['email'])){
            $email = $_POST['email'];
            $pdo = App::getDb()->getPDO();
            try{
                $pdo->beginTransaction();
                Email::save($email);
                $message = "$email a été abonné avec succès à notre Newsletter, vous recevrez régulièrement les nouvelles offres d'emplois";
                $pdo->commit();
                $return = array("statuts"=>0,"mes"=>$message);
            }catch(Exception $e){
                $pdo->rollBack();
                $message = "Une erreur est survenue";
                $return = array("statuts"=>1,"mes"=>$message);
            }
        }else{
            $message = "Veuillez renseigner l'adresse email";
            $return = array("statuts"=>1,"mes"=>$message);
        }
        echo json_encode($return);
    }

    public function contact(){
        $this->render('page.home.contact');
    }

}