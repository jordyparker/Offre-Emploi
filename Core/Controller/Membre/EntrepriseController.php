<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 15/05/2019
 * Time: 16:27
 */

namespace Projet\Controller\Membre;

use Projet\Controller\Page\PageController;
use Projet\Controller\Site\HomeController;
use Projet\Database\Candidat;
use Projet\Database\Entreprise;
use Exception;
use Projet\Database\Message;
use Projet\Database\Offre;
use Projet\Database\Postuler;
use Projet\Model\App;
use function Projet\var_die;

class EntrepriseController extends PageController
{
    public function save()
    {
        header('content-type: application/json');
        $return = [];
        if (isset($_POST['nomE']) && !empty($_POST['nomE']) && isset($_POST['lieuE']) && !empty($_POST['lieuE']) && isset($_POST['adresseE'])
            && isset($_POST['numeroE']) && !empty($_POST['numeroE']) && isset($_POST['siteE']) && isset($_POST['villeE']) && !empty($_POST['villeE'])
            && isset($_POST['emailE']) && !empty($_POST['emailE']) && isset($_POST['passwordE']) && !empty($_POST['passwordE'])
            && isset($_POST['confirmpasswordE']) && !empty($_POST['confirmpasswordE']) && isset($_POST['domaineActiviteE']) && !empty($_POST['domaineActiviteE'])) {
            $nom = $_POST['nomE'];
            $lieu = $_POST['lieuE'];
            $numero = $_POST['numeroE'];
            $adresse = $_POST['adresseE'];
            $site = $_POST['siteE'];
            $email = $_POST['emailE'];
            $ville = $_POST['villeE'];
            $password = $_POST['passwordE'];
            $confirmPassword = $_POST['confirmpasswordE'];
            $domaineActivite = $_POST['domaineActiviteE'];
            $errorName = "Ce nom existe déja, veuillez le changer";
            $errorEmail = "Cette adresse email existe déjà, veuillez la changer";
            $errorPassword = "Les mots de passes doivent être identiques, veuillez les changer";
            $i = 0;
            $bool = true;
            if (Entreprise::byEmail($email)) {
                $bool = $errorEmail;
            }
            if (Candidat::byEmail($email)) {
                $bool = $errorEmail;
            }
            if (Entreprise::byName($nom)) {
                $bool = $errorName;
            }
            if ($password != $confirmPassword) {
                $bool = $errorPassword;
            }
            if (is_bool($bool)) {
                $pdo = App::getDb()->getPDO();
                try {
                    $pdo->beginTransaction();
                    Entreprise::save($nom,$lieu,$numero,$site,$email,sha1($password),$domaineActivite,$ville,$adresse);
                    $message = "Votre compte a été crée avec succès";
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
        } else {
            $message = $this->empty;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }

    public function delete(){
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $id = $_POST['id'];
            try{
                $pdo = App::getDb()->getPDO();
                $pdo->beginTransaction();
                Entreprise::delete($id);
                if(Offre::findE($id))
                {
                    Offre::deleteE($id);
                }
                if(Postuler::findE($id))
                {
                    Postuler::deleteE($id);
                }
                $message = "Votre compte a été supprimée avec succès";
                $this->session->write('success',$message);
                $pdo->commit();
                $this->session->delete('dbauth');
                $this->session->delete('type');
                $return = array("statuts" => 0, "mes" => $message,'redirects' => 'login');
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

    public function changePassword(){
        header('content-type: application/json');
        $return = [];
        if (isset($_POST['apassword']) && !empty($_POST['apassword']) && isset($_POST['npassword']) && !empty($_POST['npassword'])
            && isset($_POST['cnpassword']) && !empty($_POST['cnpassword']) && isset($_POST['id']) && !empty($_POST['id'])) {
            $apassword = sha1($_POST['apassword']);
            $npassword = sha1($_POST['npassword']);
            $cnpassword = sha1($_POST['cnpassword']);
            $id = (int)$_POST['id'];
            $entreprise = Entreprise::find($id);
            $errorPassword = "Mot de passe incorrecte";
            $errorPassword1 = "Les mots de passes doivent êtres identiques";
            $i = 0;
            $bool = true;
            if ($entreprise->password != $apassword) {
                $bool = $errorPassword;
            }
            if ($npassword != $cnpassword) {
                $bool = $errorPassword1;
            }
            if (is_bool($bool)) {
                $pdo = App::getDb()->getPDO();
                try {
                    $pdo->beginTransaction();
                    Entreprise::save($entreprise->nom,$entreprise->lieu,$entreprise->numero,$entreprise->siteweb,$entreprise->email,$npassword,$entreprise->domaineactivite,$entreprise->ville,$entreprise->adresse,$entreprise->id);
                    $message = "Votre mot de passe a été modifié avec succès";
                    $this->session->write('success', $message);
                    $pdo->commit();
                    $return = array("statuts" => 0, "mes" => $message);
                } catch (Exception $e) {
                    $pdo->rollBack();
                    $message = $this->error;
                    $return = array("statuts" => 1, "mes" => $message);
                }
            } else {
                $return = array("statuts" => 1, "mes" => $bool);
            }
        } else {
            $message = $this->empty;
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }


}