<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * idProfil: 14/05/2019
 * Time: 12:09
 */

namespace Projet\Database;


use Projet\Model\Table;

class Langue extends Table
{
    protected static $table = 'langue';

    public static function save($langue,$idCandidat,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET langue = :langue,idCandidat = :idCandidat';
        $baseParam = [':langue' => $langue,':idCandidat' => $idCandidat];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function findL($id){
        $sql = static::selectString().' WHERE idCandidat = :id';
        return self::query($sql,[':id'=>$id]);
    }

}