<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 17/05/2019
 * Time: 08:01
 */

namespace Projet\Controller\Page;


use Projet\Model\Controller;

class PageController extends Controller
{
    protected $template = 'Templates/default';
    public $empty = "Veuillez remplir tous les champs";

    public function __construct(){
        parent::__construct();
        $this->viewPath = 'Views/';
    }
}