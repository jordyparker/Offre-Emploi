<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 27/05/2019
 * Time: 22:45
 */

namespace Projet\Controller\Membre;


use Projet\Controller\Page\PageController;
use Projet\Database\Formation;
use Projet\Model\App;
use function Projet\var_die;


class FormationController extends PageController
{
    public function add()
    {
        header('content-type: application/json');
        $return = [];
        $tab = ["add","edit"];
        if (isset($_POST['etablissement']) && !empty($_POST['etablissement'])
            &&isset($_POST['diplome']) && !empty($_POST['diplome'])
            &&isset($_POST['annee']) && !empty($_POST['annee'])&&isset($_POST['idForm'])) {
            $nom = $_POST['etablissement'];
            $diplome = $_POST['diplome'];
            $annee = $_POST['annee'];
            $id = (int)$_POST['idForm'];
            $user = App::getDBAuth()->user();
            if (!empty($id)) {
                $form = Formation::find($id);
                if ($form) {
                    $pdo = App::getDb()->getPDO();
                    try {
                        $pdo->beginTransaction();
                        Formation::save($nom, $diplome, $annee, $user->id, $form->id);
                        $pdo->commit();
                        $message = "La formation a été modifié avec succès";
                        $return = array("statuts" => 0, "mes" => $message);
                        $this->session->write('success', $message);
                    } catch (Exception $e) {
                        $pdo->rollBack();
                        $erreur = $e->getMessage();
                        $return = array("statuts" => 1, "mes" => $erreur);
                    }
                } else {
                    $return = array("statuts" => 1, "mes" => "La formation que vous souhaitez modifiez n'existe pas");
                }
            } else {
                $pdo = App::getDb()->getPDO();
                try {
                    $pdo->beginTransaction();
                    Formation::save($nom, $diplome, $annee, $user->id);
                    $message = "La formation a été ajouté avec succès";
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