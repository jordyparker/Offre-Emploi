<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 23/01/2017
 * Time: 09:19
 */

namespace Projet\Controller\Error;


class HomeController extends ErrorController {

    public function error(){
        $this->render('page.home.error');
    }

}