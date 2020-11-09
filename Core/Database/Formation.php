<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 14/05/2019
 * Time: 12:09
 */

namespace Projet\Database;


use Projet\Model\Table;

class Formation extends Table
{
    protected static $table = 'formation';

    public static function save($etablissement,$diplome,$annee,$idCandidat,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET diplome = :diplome,etablissement = :etablissement,annee = :annee,
            idCandidat = :idCandidat';
        $baseParam = [':diplome' => ucwords($diplome),':etablissement' => ucwords($etablissement),':annee' => $annee,':idCandidat' => $idCandidat];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function findC($id){
        $sql = static::selectString().' WHERE idCandidat = :id';
        return self::query($sql,[':id'=>$id]);
    }

}