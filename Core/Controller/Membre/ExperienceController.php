<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 27/05/2019
 * Time: 22:45
 */

namespace Projet\Controller\Membre;

use DateTime;
use Projet\Controller\Page\PageController;
use Projet\Database\Experience;
use Projet\Model\App;
use function Projet\var_die;

class ExperienceController extends PageController
{
    public function add()
    {
        header('content-type: application/json');
        $return = [];

        if (isset($_POST['nomentreprise']) && !empty($_POST['nomentreprise'])
            &&isset($_POST['dated']) && !empty($_POST['dated'])
            &&isset($_POST['datef']) && !empty($_POST['datef'])
            &&isset($_POST['description']) && !empty($_POST['description'])
            &&isset($_POST['idExp'])) {
            $nom = $_POST['nomentreprise'];
            $dated = $_POST['dated'];
            $datef = $_POST['datef'];
            $description = $_POST['description'];
            $id = (int)$_POST['idExp'];
            $user = App::getDBAuth()->user();
            if (!empty($id)) {
                $exp = Experience::find($id);
                if ($exp) {
                    $pdo = App::getDb()->getPDO();
                    try {
                        $dated = new DateTime($dated);
                        $datef = new DateTime($datef);
                        $pdo->beginTransaction();
                        Experience::save($nom, $dated->format(MYSQL_DATE_FORMAT), $datef->format(MYSQL_DATE_FORMAT), $description,$user->id,$exp->id);
                        $pdo->commit();
                        $message = "L'experience a été modifié avec succès";
                        $return = array("statuts" => 0, "mes" => $message);
                        $this->session->write('success', $message);
                    } catch (Exception $e) {
                        $pdo->rollBack();
                        $erreur = $e->getMessage();
                        $return = array("statuts" => 1, "mes" => $erreur);
                    }
                } else {
                    $return = array("statuts" => 1, "mes" => "L'expérience que vous souhaitez modifiez n'existe pas");
                }
            } else {
                $pdo = App::getDb()->getPDO();
                try {
                    $dated = new DateTime($dated);
                    $datef = new DateTime($datef);
                    $pdo->beginTransaction();
                    Experience::save($nom, $dated->format(MYSQL_DATE_FORMAT), $datef->format(MYSQL_DATE_FORMAT), strip_tags($description), $user->id);
                    $message = "L'expérience a été ajouté avec succès";
                    $this->session->write('success', $message);
                    $pdo->commit();
                    $return = array("statuts" => 0, "mes" => $message);
                } catch (Exception $e) {
                    $pdo->rollBack();
                    $message = $this->error;
                    $return = array("statuts" => 1, "mes" => $message);
                }
            }
        } else {
            $message = "Veuillez remplir tous les champs avant de soumettre le formulaire";
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }
}