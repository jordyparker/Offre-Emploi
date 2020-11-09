<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 30/07/2015
 * Time: 16:31
 */

namespace Projet\Model;


class Encrypt {

    private static $key = 'JobAlert';

    static function GenerationCle($Texte,$CleDEncryptage)
    {
        $CleDEncryptage = md5($CleDEncryptage);
        $Compteur=0;
        $VariableTemp = "";
        for ($Ctr=0;$Ctr<strlen($Texte);$Ctr++)
        {
            if ($Compteur==strlen($CleDEncryptage))
                $Compteur=0;
            $VariableTemp.= substr($Texte,$Ctr,1) ^ substr($CleDEncryptage,$Compteur,1);
            $Compteur++;
        }
        return $VariableTemp;
    }
    static function crypter($Texte){
        if(!empty($Texte)){
            srand((double)microtime()*1000000);
            $CleDEncryptage = md5(rand(0,32000) );
            $Compteur=0;
            $VariableTemp = "";
            for ($Ctr=0;$Ctr<strlen($Texte);$Ctr++)
            {
                if ($Compteur==strlen($CleDEncryptage))
                    $Compteur=0;
                $VariableTemp.= substr($CleDEncryptage,$Compteur,1).(substr($Texte,$Ctr,1) ^ substr($CleDEncryptage,$Compteur,1) );
                $Compteur++;
            }
            return base64_encode(self::GenerationCle($VariableTemp,self::$key) );
        }else{
            return $Texte;
        }
    }
    static function decrypter($Texte){
        if(!empty($Texte)){
            $Texte = self::GenerationCle(base64_decode($Texte),self::$key);
            $VariableTemp = "";
            for ($Ctr=0;$Ctr<strlen($Texte);$Ctr++)
            {
                $md5 = substr($Texte,$Ctr,1);
                $Ctr++;
                $VariableTemp.= (substr($Texte,$Ctr,1) ^ $md5);
            }
            return $VariableTemp;
        }else{
            return $Texte;
        }
    }

}