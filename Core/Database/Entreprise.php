<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 14/05/2019
 * Time: 12:07
 */

namespace Projet\Database;


use Projet\Model\Table;
use function Projet\var_die;

class Entreprise extends Table
{
    protected static $table = 'entreprise';

    public static function save($nom,$lieu,$numero,$site,$email,$password,$domaineActivite,$ville,$adresse,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET nom = :nom,lieu = :lieu,numero = :numero,
            siteweb = :siteweb,email = :email,password = :password,domaineactivite = :domaineActivite,ville = :ville,adresse = :adresse';
        $baseParam = [':nom' => strtoupper($nom),':lieu' => ucwords($lieu),':numero' => $numero,':siteweb' => $site,
            ':email' => $email,':password' => $password,':domaineActivite' => ucwords($domaineActivite),':ville' => ucwords($ville),':adresse' => $adresse];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function find($id){
        $sql = static::selectString().' WHERE id = :id';
        return self::query($sql,[':id'=>$id],true);
    }

    public static function findNom($nom){
        $sql = 'SELECT id FROM'.self::getTable().' WHERE nom = :nom';
        return self::query($sql,[':nom'=>'%'.$nom.'%'],true);
    }
    public static function findE($nom){
        $sql = static::selectString().' WHERE nom = :nom';
        return self::query($sql,[':nom'=>$nom],true);
    }

    public static function byEmail($email){
        $sql = self::selectString() . ' WHERE email = :email';
        $param = [':email' => $email];
        return self::query($sql, $param,true);
    }
    public static function byName($nom){
        $sql = self::selectString() . ' WHERE nom = :nom';
        $param = [':nom' => $nom];
        return self::query($sql, $param,true);
    }

    public static function setPassword($code, $date,$id){
        $sql = 'UPDATE '.self::getTable().' SET password = :code, updated_at = :date WHERE id = :id ';
        $param = [':code'=>sha1($code), ':date'=>$date,':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function countBySearchType($nom=null,$secteurActivite=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($nom)){
            $tNom = ' AND nom = :nom';
            $tab[':nom'] = $nom;
        }else{
            $tNom = '';
        }
        if(isset($secteurActivite)){
            $tsecteurActivite = ' AND domaineActivite = :secteurActivite';
            $tab[':secteurActivite'] = $secteurActivite;
        }else{
            $tsecteurActivite = '';
        }
        if(isset($debut)){
            $tDebut = ' AND DATE(created_at) >= :debut';
            $tab[':debut'] = $debut;
        }else{
            $tDebut = '';
        }
        if(isset($fin)){
            $tFin = ' AND DATE(created_at) <= :fin';
            $tab[':fin'] = $fin;
        }else{
            $tFin = '';
        }
        return self::query($count.$where.$tNom.$tsecteurActivite.$tFin.$tDebut,$tab,true);
    }

    public static function updateparams($npassword,$id){
        $sql = 'UPDATE';
        $baseSql = self::getTable().' SET password = :password WHERE id = :id';
        $baseParam = [':password' => $npassword,':id'=>$id];
        return self::query($sql.$baseSql, $baseParam, true, true);
    }


}