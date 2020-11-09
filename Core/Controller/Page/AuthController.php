<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 15/05/2019
 * Time: 11:56
 */

namespace Projet\Controller\Page;

use Projet\Model\App;

class AuthController extends PageController
{
    public function middleware(){
        if(App::getDBAuth()->isLogged()){
            //App::redirect(App::url("register"));
            $this->session->write("danger","This resource is unavailable in connection mode");
        }
    }

    public function login(){
        $this->middleware();
        $this->render('page.home.login');
    }

    public function register(){
        $this->render('page.home.register');
    }
}