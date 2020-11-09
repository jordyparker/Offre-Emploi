<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 23/01/2017
 * Time: 09:19
 */

namespace Projet\Controller\Membre;


use DateTime;
use Projet\Database\Candidat;
use Projet\Controller\Page\PageController;
use Projet\Database\Entreprise;
use Projet\Database\Message;
use Projet\Database\Postuler;
use Projet\Model\App;
use Projet\Model\FileHelper;
use function Projet\thousand;
use function Projet\var_die;

class CandidatController extends PageController
{
    public function save()
    {
        header('content-type: application/json');
        $return = [];
        if (isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['prenom']) && !empty($_POST['prenom'])
            && isset($_POST['sexe']) && !empty($_POST['sexe']) && isset($_POST['date']) && !empty($_POST['date'])
            && isset($_POST['situationMatrimonial']) && !empty($_POST['situationMatrimonial']) && isset($_POST['adresse'])
            && isset($_POST['numero']) && !empty($_POST['numero']) && isset($_POST['ville']) && !empty($_POST['ville'])
            && isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])
            && isset($_POST['confirmpassword']) && !empty($_POST['confirmpassword']) && isset($_POST['domaineActivite'])
            && !empty($_POST['domaineActivite'])) {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $sexe = $_POST['sexe'];
            $date = $_POST['date'];
            $pays = $_POST['pays'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirmpassword'];
            $domaineActivite = $_POST['domaineActivite'];
            $numero = str_replace(' ', '', $_POST['numero']);
            $email = $_POST['email'];
            $situationMatrimonial = $_POST['situationMatrimonial'];
            $adresse = $_POST['adresse'];
            $ville = $_POST['ville'];
            $errorEmail = "Cette adresse email existe déjà, veuillez la changer";
            $errorTel = "Ce numéro de téléphone existe déjà, veuillez la changer";
            $errorPassword = "Les mots de passes doivent être identiques, veuillez le changer";
            $i = 0;
            $bool = true;
            if (Candidat::byEmail($email)) {
                $bool = $errorEmail;
            }
            if (Entreprise::byEmail($email)) {
                $bool = $errorEmail;
            }
            if (Candidat::byNumero($numero)) {
                $bool = $errorTel;
            }
            if ($password != $confirmPassword) {
                $bool = $errorPassword;
            }
            if (is_bool($bool)) {
                $pdo = App::getDb()->getPDO();
                try {
                    $date = new DateTime($date);
                    $pdo->beginTransaction();
                    Candidat::save($nom, $prenom, $date->format(MYSQL_DATE_FORMAT),$sexe,$pays,$ville,$domaineActivite,$numero, $adresse,$email,sha1($password),$situationMatrimonial);
                    $message = "Votre compte a été crée avec succès";
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

    public function update()
    {
        header('content-type: application/json');
        $return = [];
        if (isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['prenom']) && !empty($_POST['prenom'])
            && isset($_POST['sexe']) && !empty($_POST['sexe']) && isset($_POST['date']) && !empty($_POST['date'])
            && isset($_POST['situationMatrimonial']) && !empty($_POST['situationMatrimonial']) && isset($_POST['adresse'])
            && isset($_POST['numero']) && !empty($_POST['numero']) && isset($_POST['ville']) && !empty($_POST['ville'])
            && isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['id']) && !empty($_POST['id'])
            &&isset($_POST['domaineActivite']) && !empty($_POST['domaineActivite'])) {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $sexe = $_POST['sexe'];
            $date = $_POST['date'];
            $pays = $_POST['pays'];
            $domaineActivite = $_POST['domaineActivite'];
            $numero = $_POST['numero'];
            $email = $_POST['email'];
            $situationMatrimonial = $_POST['situationMatrimonial'];
            $adresse = $_POST['adresse'];
            $ville = $_POST['ville'];
            $id = $_POST['id'];
            $i = 0;
            $bool = true;
            if (is_bool($bool)) {
                $pdo = App::getDb()->getPDO();
                $root = ROOT_SITE."assets/imgages/img.jpg";
                if(isset($_FILES['file']['name'])){
                    if(!empty($_FILES['file']['name'])){
                        $extensions_valides = array('jpg','jpeg','png','JPG','JPEG','PNG');
                        $extension_upload = strtolower(  substr(  strrchr($_FILES['file']['name'], '.')  ,1)  );
                        if(in_array($extension_upload,$extensions_valides) && in_array($extension_upload,$extensions_valides) ){
                            if($_FILES['file']['size']<=1000000){
                                $root = FileHelper::moveImage($_FILES['file']['tmp_name'],"assets/images","png","",true);
                                $root = $root?$root:ROOT_SITE."assets/imgages/img.jpg";
                            }
                            else{
                                $erreur =  'Le fichier est troip grand';
                                $return = array("statuts"=>1, "mes"=>$erreur);
                            }
                        }else{
                            $erreur = "Format de d'image incorrect";
                            $return = array("statuts"=>1, "mes"=>$erreur);
                        }
                    }else{
                        $return = array("statuts" => 1, "mes" => "Veuillez entrer une image");
                    }
                }else{
                    $candidat = Candidat::find($id);
                    $root = $candidat->photo;
                }
                try {
                    $pdo->beginTransaction();
                    Candidat::update($nom, $prenom, $date,$sexe,$pays,$ville,$domaineActivite,$numero, $adresse,$email,$situationMatrimonial,$root,$id);
                    $message = "Vos informations ont été modifiées avec succès";
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

    public function delete(){
        header('content-type: application/json');
        $return = [];
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $id = $_POST['id'];
            try{
                $pdo = App::getDb()->getPDO();
                $pdo->beginTransaction();
                Candidat::delete($id);
                if(Postuler::findCa($id))
                {
                    Postuler::delete($id);
                }
                if(Message::findC($id)){
                    Message::deleteC($id);
                }
                $message = "Votre compte a été supprimée avec succès";
                $this->session->write('success',$message);
                $pdo->commit();
                $this->session->delete('dbauth');
                $this->session->delete('type');
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

    public function changePassword(){
        header('content-type: application/json');
        $return = [];
        if (isset($_POST['apassword']) && !empty($_POST['apassword']) && isset($_POST['npassword']) && !empty($_POST['npassword'])
            && isset($_POST['cnpassword']) && !empty($_POST['cnpassword']) && isset($_POST['id']) && !empty($_POST['id'])) {
            $apassword = sha1($_POST['apassword']);
            $npassword = sha1($_POST['npassword']);
            $cnpassword = sha1($_POST['cnpassword']);
            $id = (int)$_POST['id'];
            $candidat = Candidat::find($id);
            $errorPassword = "Mot de passe incorrecte";
            $errorPassword1 = "Les mots de passes doivent êtres identiques";
            $i = 0;
            $bool = true;
            if ($candidat->password != $apassword) {
                $bool = $errorPassword;
            }/*
            if(strlen($npassword) <8 && !preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#',$npassword) )
            {
                $bool = $errorPasswordLen;
            }*/
            if ($npassword != $cnpassword) {
                $bool = $errorPassword1;
            }
            if (is_bool($bool)) {
                $pdo = App::getDb()->getPDO();
                try {
                    $pdo->beginTransaction();
                    Candidat::updateP($candidat->nom, $candidat->prenom, $candidat->date,$candidat->sexe,$candidat->pays,$candidat->ville,$candidat->domaineActivite,$candidat->numero, $candidat->adresse,$candidat->email,$npassword,$candidat->situationMatrimonial,$candidat->id);
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