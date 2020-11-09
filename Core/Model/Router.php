<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 10/05/2019
 * Time: 16:58
 */

namespace Projet\Model;


class Router
{
    private static function getController($url, $data)
    {
        $request = explode('#', $data[$url]);
        $controller = $request[0];
        $action = $request[1];
        $controller = new $controller();
        $controller->$action();
    }

    public static function call($data)
    {
        $url = explode('?', $_SERVER["REQUEST_URI"]);
        $newUrl = strlen($url[0]) == 1 ? "" : substr($url[0], 1);
        if (array_key_exists($newUrl, $data)) {
            self::getController($newUrl, $data);
        } else {
            App::error();
        }
    }

    public static function getRoute()
    {
        return substr($_SERVER["REQUEST_URI"], 1);
    }
}