<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 09/05/2019
 * Time: 13:43
 */


namespace Projet\Auth;


use Projet\Database\Log;
use Projet\Database\User;
use Projet\Model\App;
use Projet\Model\Table;
use function Projet\var_die;


class DBAuth {

    private $session;

    /*
     * Constructeur avec les messages d'options à personnaliser
     */
    public  function __construct($session){
        $this->session = $session;
    }

    /*
     * retourne la session en cours
     */
    public function getSession(){
        return $this->session;
    }

    /**
     * fonction qui permet a un utilisateur de se connecter
     * @param $username
     * @param $password
     * @return boolean
     */
    public function login($login,$password,$type){
        if($type == 1)
        {
            $user = Table::query('SELECT * FROM candidat WHERE email = :login',[':login'=>$login], true);
        }
        elseif($type == 2)
        {
            $user = Table::query('SELECT * FROM entreprise WHERE email = :login',[':login'=>$login], true);
        }
        if($user){
            if($user->password == ($password)){
                $this->session->write('dbauth',$user);
                return true;
            }else{
                return "Votre mot de passe est incorrect";
            }
        }else{
            return "Votre adresse email est incorrecte";
        }
    }

    /**
     * Fonction qui test si un utilisateur est conecte
     * @return bool
     */
    public function isLogged(){
        return isset($_SESSION['dbauth']);
    }

    /**
     * Fonction permettante de se deconecter a l'interface
     */
    public function signOut(){
        $this->session->delete('dbauth');
        $this->session->delete('type');
        return true;
    }
    /*
     * fonction qui retourne le user ou pas
     */
    public function user(){
        if (!$this->isLogged()){
            return false;
        }
        return $_SESSION['dbauth'];
    }

}