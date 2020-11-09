<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 16/07/2015
 * Time: 16:16
 */

namespace Projet\Model;


class Random {

    public static function numero_compte(){
        $year = date('y');
        $day = date('d');
        $month = date('m');
        return self::number(4).$day.self::number(2).$month.self::number(2).$year.self::number(2);
    }

    public static function getNumeroCompte($num,$is=false){
        $one = substr($num,0,4);
        $two = substr($num,4,4);
        $three = substr($num,8,4);
        $four = substr($num,12,4);
        $val = $one.' '.$two.' '.$three.' '.$four;
        return !$is?'<span class="uk-badge badges"><b>'.$val.'<b></span>':'<b>'.$val.'</b>';
    }

    public static function number($length){
        $numbers = "0123456789";
        return substr(str_shuffle(str_repeat($numbers, $length)),0,$length);
    }

    public static function string(){
        $charMaj = self::randString(2,"ABCDEFGHJKLMNPQRSTUVWXYZ");
        $charMin = self::randString(4,"abcdefghijklmnopqrstuvwxyz");
        $number = self::randString(2,"111222333444555666777888999");
        //$letters = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        return $charMaj.$charMin.$number;
    }

    public static function token(){
        $time = time();
        $char = self::randString(2,"ABCDEFGHJKLMNPQRSTUVWXYZ");
        $number = self::randString(5,"11122233344455566677788899900000");
        return $char.$time.$number;
    }

    public static function reference(){
        $day = date('d');
        $second = date('s');
        $heure = date('H');
        $char = self::randString(2,"ACEHRPATEFRMNTE");
        $number = self::randString(4,"111222333444555666777888999");
        return $day.$char.$day.$number.$heure.$second;
    }
    public static function referenceCommande(){
        $day = date('d');
        $month = date('m');
        $year = date('y');
        $char = self::randString(1,"ABCDEFGHJKLMNPQRSTUVWXYZ");
        $time = self::randString(3,time());
        return $day.$char.$month.$year.$time;
    }

    public static function randString($length,$table){
        return substr(str_shuffle(str_repeat($table, $length)),0,$length);
    }

    public static function randLogin($nom,$prenom){
        $nom = StringHelper::str_without_accents(explode(' ',$nom)[0]);
        $prenom = StringHelper::str_without_accents(explode(' ',$prenom)[0]);
        if(strlen($nom)>10)
            $login= $nom;
        elseif(strlen($prenom)>10)
            $login=$prenom;
        else
            $login=$nom.$prenom;
        return $login;
    }
}