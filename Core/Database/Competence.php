<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 14/05/2019
 * Time: 12:08
 */

namespace Projet\Database;


use Projet\Model\Table;

class Competence extends Table
{
    protected static $table = 'competence';

    public static function save($nomCompetence,$pourcentage,$idCandidat,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET nomCompetence = :nomCompetence,pourcentage = :pourcentage,idCandidat = :idCandidat';
        $baseParam = [':nomCompetence' => ucwords($nomCompetence),':pourcentage' => $pourcentage,':idCandidat' => $idCandidat];
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