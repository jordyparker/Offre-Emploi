<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 27/05/2019
 * Time: 22:45
 */

namespace Projet\Controller\Membre;

use Projet\Controller\Page\PageController;
use Projet\Database\Competence;
use Projet\Model\App;
use function Projet\var_die;

class CompetenceController extends PageController
{
    public function add()
    {
        header('content-type: application/json');
        $return = [];
        if (isset($_POST['nomcompetence']) && !empty($_POST['nomcompetence'])
            &&isset($_POST['pourcentage']) && !empty($_POST['pourcentage'])&&isset($_POST['idCmp'])) {
            $competence = $_POST['nomcompetence'];
            $pourcentage = $_POST['pourcentage'];
            $id = (int) $_POST['idCmp'];
            $user = App::getDBAuth()->user();
            if (!empty($id)) {
                $errorPourcentage = "Veuillez entre une valeur positive";
                $bool = true;
                if ($pourcentage < 0) {
                    $bool = $errorPourcentage;
                }
                if(is_bool($bool))
                {
                    $cmp = Competence::find($id);
                    if ($cmp) {
                        $pdo = App::getDb()->getPDO();
                        try {
                            $pdo->beginTransaction();
                            Competence::save($competence,$pourcentage,$user->id,$cmp->id);
                            $pdo->commit();
                            $message = "La compétence a été modifié avec succès";
                            $return = array("statuts" => 0, "mes" => $message);
                            $this->session->write('success', $message);
                        } catch (Exception $e) {
                            $pdo->rollBack();
                            $erreur = $e->getMessage();
                            $return = array("statuts" => 1, "mes" => $erreur);
                        }
                    } else {
                        $return = array("statuts" => 1, "mes" => "La compétence que vous souhaitez modifiez n'existe pas");
                    }
                }
                else{
                    $return = array("statuts" => 1, "mes" => $bool);
                }
            }else{
                $errorPourcentage = "Veuillez entre une valeur positive";
                $bool = true;
                if ($pourcentage < 0) {
                    $bool = $errorPourcentage;
                }
                if (is_bool($bool)) {
                    $pdo = App::getDb()->getPDO();
                    try {
                        $pdo->beginTransaction();
                        Competence::save($competence,$pourcentage,$user->id);
                        $message = "La compétence a été ajouté avec succès";
                        $this->session->write('success', $message);
                        $pdo->commit();
                        $return = array("statuts" => 0, "mes" => $message);
                    } catch (Exception $e) {
                        $pdo->rollBack();
                        $message = $this->error;
                        $return = array("statuts" => 1, "mes" => $message);
                    }
                }else{
                    $return = array("statuts" => 1, "mes" => $bool);
                }}
        } else {
            $message = "Veuillez remplir tous les champs avant de soumettre le formulaire";
            $return = array("statuts" => 1, "mes" => $message);
        }
        echo json_encode($return);
    }
}