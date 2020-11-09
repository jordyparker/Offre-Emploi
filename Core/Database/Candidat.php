<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 14/05/2019
 * Time: 12:06
 */

namespace Projet\Database;


use Projet\Model\Table;

class Candidat extends Table
{
    protected static $table = 'candidat';

    public static function save($nom,$prenom,$date,$sexe,$pays,$ville,$domaineActivite,$numero,
                                $adresse,$email,$password,$situationMatrimonial,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET nom = :nom,prenom = :prenom,date = :date,
            sexe = :sexe,pays = :pays,ville = :ville,domaineActivite = :domaineActivite,numero = :numero,adresse = :adresse,
            email = :email,password = :password,situationMatrimonial = :situationMatrimonial';
        $baseParam = [':nom' => ucwords($nom),':prenom' => ucwords($prenom),':date' => $date,':sexe' => $sexe,
            ':pays' => $pays,':ville' => $ville,':domaineActivite' => $domaineActivite,':numero' => $numero,':adresse' => $adresse,
            ':email' => $email,':numero' => $numero,':password' => $password,':situationMatrimonial' => $situationMatrimonial];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function findNom($nom){
        $sql = 'SELECT id FROM '.self::getTable().' WHERE nom LIKE :nom';
        return self::query($sql,[':nom'=>'%'.$nom.'%'],true);
    }

    public static function update($nom, $prenom, $date,$sexe,$pays,$ville,$domaineActivite,$numero, $adresse,$email,$situationMatrimonial,$root,$id){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET nom = :nom,prenom = :prenom,date = :date,
            sexe = :sexe,pays = :pays,ville = :ville,domaineActivite = :domaineActivite,numero = :numero,adresse = :adresse,
            email = :email,situationMatrimonial = :situationMatrimonial, photo = :root';
        $baseParam = [':nom' => ucwords($nom),':prenom' => ucwords($prenom),':date' => $date,':sexe' => $sexe,
            ':pays' => $pays,':ville' => $ville,':domaineActivite' => $domaineActivite,':numero' => $numero,':adresse' => $adresse,
            ':email' => $email,':numero' => $numero,':situationMatrimonial' => $situationMatrimonial,':root' => $root];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function updatep($nom, $prenom, $date,$sexe,$pays,$ville,$domaineActivite,$numero, $adresse,$email,$password,$situationMatrimonial,$id){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET nom = :nom,prenom = :prenom,date = :date,
            sexe = :sexe,pays = :pays,ville = :ville,domaineActivite = :domaineActivite,numero = :numero,adresse = :adresse,
            email = :email,situationMatrimonial = :situationMatrimonial, password = :password';
        $baseParam = [':nom' => ucwords($nom),':prenom' => ucwords($prenom),':date' => $date,':sexe' => $sexe,
            ':pays' => $pays,':ville' => $ville,':domaineActivite' => $domaineActivite,':numero' => $numero,':adresse' => $adresse,
            ':email' => $email,':numero' => $numero,':situationMatrimonial' => $situationMatrimonial,':password' => $password];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function byEmail($email){
        $sql = self::selectString() . ' WHERE email = :email';
        $param = [':email' => $email];
        return self::query($sql, $param,true);
    }

    public static function byNumero($numero){
        $sql = self::selectString() . ' WHERE numero = :numero';
        $param = [':numero' => $numero];
        return self::query($sql, $param,true);
    }

}