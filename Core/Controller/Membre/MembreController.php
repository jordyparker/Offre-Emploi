<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 15/05/2019
 * Time: 16:48
 */

namespace Projet\Controller\Membre;
use Projet\Auth\DBAuth;
use Projet\Controller\Page\PageController;
use Projet\Database\Candidat;
use Projet\Model\App;
use Projet\Database\Entreprise;
use Projet\Model\Router;


class MembreController extends PageController
{
    protected $user;

    public function __construct(){
        parent::__construct();
        $auth = App::getDBAuth();
        if($auth->isLogged()){
            $user = Entreprise::findE($auth->user()->nom);
            if(!$user)
            {
                $user = Candidat::findC($auth->user()->nom);
            }
            $this->user = $user;
        }else{
            $this->session->write('lastUrlAsked',App::url(Router::getRoute()));
            $this->session->write('warning',"Vous devrez d'abord vous inscrire ou vous connecter");
            App::interdit();
        }
    }

}