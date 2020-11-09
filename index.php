<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 09/05/2019
 * Time: 13:41
 */
namespace Projet;
ini_set('display_errors', 1);
date_default_timezone_set("Africa/Douala");
define('ROOT',__DIR__);
define('LANG',__DIR__.'/lang');
define('ROOT_SITE','http://offreemploi.test/Public/');
define('ROOT_URL','http://offreemploi.test/');
define('PATH_FILE',realpath(dirname(__FILE__)));
define('MYSQL_DATETIME_FORMAT','Y-m-d H:i:s');
define('MYSQL_DATE_FORMAT','Y-m-d');
define('DATE_COURANTE',date(MYSQL_DATETIME_FORMAT));
function var_die($value){
	echo '<pre>';
	    var_dump($value);
	echo '</pre>';
	die();
}
function thousand($value){
	return number_format($value,0,',',' ');
}
function is_ajax(){
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

require 'Core/Autoloader.php';
$routes = require 'routes.php';
Autoloader::register();
Model\Router::call($routes);
