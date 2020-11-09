<?php


namespace Projet\Database;


use Projet\Model\Table;

class Message extends Table
{
    protected static $table = 'message';

    public static function save($idCandidat,$idOffre,$message,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET idCandidat = :idCandidat,idOffre = :idOffre,message = :message';
        $baseParam = [':idCandidat' => $idCandidat,':idOffre' => $idOffre,':message' => $message];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function findMess($idOffre){
        $sql = 'SELECT * FROM ';
        $baseSql = self::getTable().' WHERE idOffre= :idOffre';
        $baseParam = [':idOffre' => $idOffre];
        return self::query($sql.$baseSql,$baseParam,true);
    }

    public static function findMe($idCandidat,$idOffre){
        $sql = 'SELECT * FROM ';
        $baseSql = self::getTable().' WHERE idOffre= :idOffre AND idCandidat = :id';
        $baseParam = [':idOffre' => $idOffre,':id'=>$idCandidat];
        return self::query($sql.$baseSql,$baseParam,true);
    }

    public static function findM($idCandidat,$idOffre){
        $sql = 'SELECT * FROM ';
        $baseSql = self::getTable().' WHERE idOffre= :idOffre AND idCandidat = :id';
        $baseParam = [':idOffre' => $idOffre,':id'=>$idCandidat];
        return self::query($sql.$baseSql,$baseParam,true);
    }

    public static function findC($idCandidat){
        $sql = 'SELECT * FROM ';
        $baseSql = self::getTable().' WHERE idCandidat = :idCandidat';
        $baseParam = [':idCandidat' => $idCandidat];
        return self::query($sql.$baseSql,$baseParam,true);
    }

    public static function deleteC($id){
        $sql = 'DELETE FROM '. self::getTable() .' WHERE idCandidat = :id';
        $param =[':id'=>$id];
        return self::query($sql,$param,true,true);
    }

    public static function deleteMe($id,$ido){
        $sql = 'DELETE FROM '. self::getTable() .' WHERE idCandidat = :id AND idOffre = :ido';
        $param =[':id'=>$id,':ido'=>$ido];
        return self::query($sql,$param,true,true);
    }

    public static function deleteO($id){
        $sql = 'DELETE FROM '. self::getTable() .' WHERE idOffre = :id';
        $param =[':id'=>$id];
        return self::query($sql,$param,true,true);
    }

    public static function findE($id){
        $sql = 'SELECT id FROM '.self::getTable().' WHERE idEntreprise = :id';
        return self::query($sql,[':id'=>$id],true);
    }
}