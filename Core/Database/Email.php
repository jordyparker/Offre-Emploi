<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 20/10/2015
 * Time: 20:20
 */

namespace Projet\Database;


use Projet\Model\Table;

class Email extends Table{
    protected static $table = 'email';
    
    //enregistre un contact
    public static function save($email){
        $sql = 'INSERT INTO  '.self::getTable().' SET email = :email';
        $param = [':email'=>$email];
        return self::query($sql,$param,true,true);
    }

    public static function countBySearchType($search=null,$debut=null,$fin=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($search)){
            $tsearch = ' AND email LIKE :search';
            $tab[':search'] = '%'.$search.'%';
        }else{
            $tsearch = '';
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
        return self::query($count.$where.$tsearch.$tDebut.$tFin,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$search=null,$debut=null,$fin=null){
        $limit = ' ORDER BY created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($search)){
            $tsearch = ' AND email LIKE :search';
            $tab[':search'] = '%'.$search.'%';
        }else{
            $tsearch = '';
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
        return self::query(self::selectString().$where.$tsearch.$tDebut.$tFin.$limit,$tab);
    }

}