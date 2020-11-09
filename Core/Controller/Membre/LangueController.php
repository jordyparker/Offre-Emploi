<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 27/05/2019
 * Time: 22:45
 */

namespace Projet\Controller\Membre;


use Projet\Controller\Page\PageController;
use Projet\Database\Langue;
use Projet\Model\App;
use function Projet\var_die;

class LangueController extends PageController
{
    public function add()
    {
        header('content-type: application/json');
        $return = [];
        if (isset($_POST['descriptionl']) && !empty($_POST['descriptionl']) &&isset($_POST['idLang'])) {
            $description = $_POST['descriptionl'];
            $user = App::getDBAuth()->user();
            $id = (int)$_POST['idLang'];
            if (!empty($id)) {
                $lang = Langue::find($id);
                if ($lang) {
                    $pdo = App::getDb()->getPDO();
                    try {
                        $pdo->beginTransaction();
                        Langue::save($description,$user->id,$lang->id);
                        $pdo->commit();
                        $message = "La langue a été modifié avec succès";
                        $return = array("statuts" => 0, "mes" => $message);
                        $this->session->write('success', $message);
                    } catch (Exception $e) {
                        $pdo->rollBack();
                        $erreur = $e->getMessage();
                        $return = array("statuts" => 1, "mes" => $erreur);
                    }
                } else {
                    $return = array("statuts" => 1, "mes" => "La langue que vous souhaitez modifier n'existe pas");
                }
            }else{
                $pdo = App::getDb()->getPDO();
                try {
                    $pdo->beginTransaction();
                    Langue::save($description,$user->id);
                    $message = "La langue a été ajouté avec succès";
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
            $message = "Veuillez remplir le champ avant de soumettre le formulaire";
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }
}