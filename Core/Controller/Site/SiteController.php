<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 17/07/2015
 * Time: 13:14
 */

namespace Projet\Controller\Site;

use Projet\Model\Controller;
use Projet\Model\Encrypt;

class SiteController extends Controller {

    protected $template = 'Templates/site';

    public function __construct()
    {   parent::__construct();
        $this->viewPath = 'Views/';
    }
}