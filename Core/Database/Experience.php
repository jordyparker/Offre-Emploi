<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 14/05/2019
 * Time: 12:08
 */

namespace Projet\Database;


use Projet\Model\Table;

class Experience extends Table
{
    protected static $table = 'experience';

    public static function save($nom,$dated,$datef,$description,$idCandidat,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET nomEntreprise = :nom,dated = :dated,datef = :datef,description = :description,
        idCandidat = :idCandidat';
        $baseParam = [':nom' => ucwords($nom),':dated' => $dated,':datef' => $datef,':description' => $description,':idCandidat' => $idCandidat];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function findE($id){
        $sql = static::selectString().' WHERE idCandidat = :id';
        return self::query($sql,[':id'=>$id]);
    }

}