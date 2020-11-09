<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 29/06/2015
 * Time: 15:11
 */

namespace Projet\Model;


class Table {

    protected static $table;

    /*public function __get($key){
        $method = 'get'.ucfirst($key);
        $this->$key = $this->$method();
        return $this->$key;
    }*/

    public static function query($statement, $attributes = null, $one = false, $isO = false){
        if($attributes){
            return App::getDb()->prepare($statement,$attributes,get_called_class(),$one, $isO);
        }else{
            return App::getDb()->query($statement, get_called_class(),$one,$isO);
        }

    }
	public static function lastId(){
		return App::getDb()->lastInsertId();
	}

    protected  static function selectString(){
        return 'SELECT * FROM '.static::getTable();
    }
    protected static function getTable(){
        if(static::$table === null){
            $class = explode('\\',get_called_class());
            static::$table = ucfirst(end($class));
        }
        return static::$table;
    }

    public static function all(){
        return self::query(static::selectString());
    }

    public static function count(){
        return self::query('SELECT COUNT(*) as Total FROM '.self::getTable(),null,true);
    }

    public static function find($id){
        $sql = static::selectString().' WHERE id = :id';
        return self::query($sql,[':id'=>$id],true);
    }

    public static function findC($nom){
        $sql = static::selectString().' WHERE nom = :nom';
        return self::query($sql,[':nom'=>$nom],true);
    }

    public static function delete($id){
        $sql = 'DELETE FROM '. self::getTable() .' WHERE id= :id';
        $param =[':id'=>$id];
        return self::query($sql,$param,true,true);
    }


    public static function deleteE($id){
        $sql = 'DELETE FROM '. self::getTable() .' WHERE idEntreprise = :id';
        $param =[':id'=>$id];
        return self::query($sql,$param,true,true);
    }

    public static function enregistrer($id=null,$fields){
        $sql_parts = [];
        $attributes = [];
        foreach ($fields as $key => $value){
            $sql_parts[] = "$key = ?";
            $attributes[] = $value;
        }
        if (isset($id)){
            return self::query('UPDATE '.self::getTable().' SET '.$sql_parts.' WHERE id = ?',$attributes,true,true);
        }
        return self::query('INSERT INTO '.self::getTable().' SET '.$sql_parts,$attributes,true,true);
    }
}