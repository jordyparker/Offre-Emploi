<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 29/06/2015
 * Time: 15:11
 */

namespace Projet\Model;
use Projet\Auth\DBAuth;
use Projet\Database\User;

class App {
    private static $db;
    private static $auth;
    private static $scripts = [];
    private static $styles = [];
    private static $title = 'Bienvenue chez jobAlert';
    private static $userss = ' | jobAlert';
    private static $naviation = 'Accueil';
    private static $breadcumb = '';
    const DB_NAME = 'offreemploi';
    const DB_USER = 'root';
    const DB_PASS = '';
    const DB_HOST = 'localhost';

    public static function getBreadcumb(){
        return self::$breadcumb;
    }

    public static function setBreadcumb($bread){
        $home = "<li id='nav-home'><a href='/'><i class='fa fa-home'></i> Accueil</a></li>";
        self::$breadcumb = $home.$bread;
    }

    public static function getDb() {
        if(self::$db === null){
            self::$db = new Database(self::DB_NAME,self::DB_USER,self::DB_PASS,self::DB_HOST);
        }
        return self::$db;
    }

    public static function getDBAuth(){
        if(self::$auth === null){
            self::$auth = new DBAuth(Session::getInstance());
        }
        return self::$auth;
    }

    public static function deleteSession(){
        unset($_SESSION);
    }

    public static function interdit(){
        self::redirect(self::url('login'));
    }

    public static function error(){
        self::redirect(self::url('error'));
    }

    /**
     * @return mixed
     */
    public static function getScripts() {
        return self::$scripts;
    }

    public static function addScript($script, $isSource = false, $isDefault = false){
        if ($isSource){
            if($isDefault){
                self::$scripts['default'][] = '<script src="'.ROOT_SITE.$script.'" type="text/javascript"></script>'."\r\n";
            }else{
                $root = (strpos($script,"http") !== false)?"":ROOT_SITE;
                self::$scripts['source'][] = '<script src="'.$root.$script.'" type="text/javascript"></script>'."\r\n";
            }
        }else{
            self::$scripts['script'][] = '<script type="text/javascript">$(document).ready(function(){'.$script.'});</script>'."\r\n";
        }
    }

    /**
     * @return array
     */
    public static function getStyles(){
        return self::$styles;
    }

    public static function addStyle($style, $isSource = false, $isDefault = false){
        if($isSource){
            if($isDefault){
                self::$styles['default'][] = '<link href="'.ROOT_SITE.$style.'" rel="stylesheet" type="text/css" media="all">'."\r\n";
            }else{
                $root = (strpos($style,"http") !== false)?"":ROOT_SITE;
                self::$styles['source'][] = '<link href="'.$root.$style.'" rel="stylesheet" type="text/css" media="all">'."\r\n";
            }
        }else{
            self::$styles['script'][] = '<style type="text/css">'.$style.'</style>'."\r\n";
        }
    }
    
    /**
     * @return mixed
     */
    public static function getTitle() {
        return self::$title.self::$userss;
    }

    /**
     * @param mixed $title
     */
    public static function setTitle($title) {
        self::$title = $title;
    }

    /**
     * @return mixed
     */
    public static function getNavigation() {
        return self::$naviation;
    }

    /**
     * @param mixed $title
     */
    public static function setNavigation($nav) {
        self::$naviation = $nav;
    }

    /*
     * fonction qui redirge vers la page passée en paramètre
     */
    public static function redirect($page){
        header("location: $page");
        exit();
    }
    /*
     * fonction qui retourne la salutation
     */
    public static function salutation(){
        $date = date('H');
        if (($date <=23 && $date > 21)||$date==0){
            $message = "Bonne nuit";
        }elseif ($date == 12){
            $message = "Bon midi";
        }elseif ($date > 12 && $date < 17){
            $message = "Bonne après midi";
        }elseif ($date >= 17 && $date <= 21){
            $message = "Bonsoir";
        }else{
            $message = "Bonjour";
        }
        return $message." ";
    }
    /*
     * fonction qui ajoute index.php à une url
     */
    public static function url($url){
        return ROOT_URL.$url;
    }
    /*
     * fonction qui donne le path avec separateur pour le web
     */
    public static function webSeparator($path = null){
        $id = self::getDBAuth()->user();
        $user = User::find($id);
        if ($path != null){
            return $path;
        }else{
            if ($user->type_user == 1 ){
                $root = 'Public/images/user-icon.png';
            }elseif ($user->type_user == 2){
                $root = 'Public/images/user-medecin.jpg';
            }else{
                $root = 'Public/images/user-centre.jpg';
            }
            return $root;
        }
    }
    /*
     * restriction des pages en fonction del'authentification
     */
    public function restrictPages(){
        $id = self::getDBAuth()->user();
        $user = User::find($id);
    }

    public static function isUserHasPrivilege($nomPrivilege){
        $idUser = self::getDBAuth()->user();
        $privilege = Privilege::byUser($idUser);
        if($privilege){
            return in_array($nomPrivilege,explode(',',$privilege->intitule));
        }
        return false;
    }

} 