<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 14/05/2019
 * Time: 12:10
 */

namespace Projet\Database;


use Projet\Model\Table;
use function Projet\var_die;

class Offre extends Table
{
    protected static $table = 'offre';

    public static function save($titre,$description,$categorie,$delais,$lieu,$salaire,$ville,$domaine,$idEntreprise,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET titre = :titre,description = :description,categorie = :categorie,
            delais = :delais,lieu = :lieu,salaire= :salaire,ville= :ville,idEntreprise = :idEntreprise,domaineActivite = :domaine';
        $baseParam = [':titre' => ucwords($titre),':description' => $description,':categorie' => $categorie,':delais' => $delais,
            ':lieu' => $lieu,':salaire' => $salaire,':ville' => $ville,':idEntreprise' => $idEntreprise,':domaine' => $domaine];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function countCategorie($id){
        $count = 'SELECT COUNT(*) FROM  '.self::getTable() .' WHERE domaineActivite = :id';
        $param = [':id' => $id];
        return self::query($count,$param,null,true);
    }

    public static function byTitle($titre){
        $sql = self::selectString() . ' WHERE titre = :titre';
        $param = [':titre' => $titre];
        return self::query($sql, $param,true);
    }

    public static function findTitre($titre){
        $sql = 'SELECT id FROM '.self::getTable().' WHERE titre LIKE :titre';
        return self::query($sql,[':titre'=>'%'.$titre.'%'],true);
    }

    public static function findE($id){
        $sql = 'SELECT id FROM '.self::getTable().' WHERE idEntreprise = :id';
        return self::query($sql,[':id'=>$id],true);
    }
    public static function delete($id){
        $sql = 'DELETE FROM '. self::getTable() .' WHERE id= :id';
        $param =[':id'=>$id];
        return self::query($sql,$param,true,true);
    }


    public static function all(){
        $sql = self::selectString() . ' ORDER BY created_at DESC';
        return self::query($sql,null);
    }

    public static function allLimit(){
        $sql = self::selectString() . ' ORDER BY created_at DESC LIMIT 6';
        return self::query($sql,null);
    }

    public static function countBySearchType($id=null,$titre=null,$lieu=null,$categorie=null,$domaine=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($titre)){
            $ttitre = ' AND (titre LIKE :titre)';
            $tab[':titre'] = '%'.$titre.'%';
        }else{
            $ttitre = '';
        }
        if(isset($lieu)){
            $tlieu = ' AND (lieu LIKE :lieu) OR (ville LIKE :lieu)';
            $tab[':lieu'] = '%'.$lieu.'%';
        }else{
            $tlieu = '';
        }
        if(isset($categorie)){
            $tcat = ' AND (categorie LIKE :categorie)';
            $tab[':categorie'] = '%'.$categorie.'%';
        }else{
            $tcat = '';
        }
        if(isset($domaine)){
            $tdom = ' AND (domaineActivite = :domaine)';
            $tab[':domaine'] = $domaine;
        }else{
            $tdom = '';
        }
        if(isset($id)){
            $tid = ' AND idEntreprise = :id';
            $tab[':id'] = $id;
        }else{
            $tid = '';
        }
        return self::query($count.$where.$ttitre.$tid.$tlieu.$tcat.$tdom,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$id=null,$titre=null,$lieu=null,$categorie=null,$domaine=null){
        $limit = ' ORDER BY created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($titre)){
            $ttitre = ' AND (titre LIKE :titre)';
            $tab[':titre'] = '%'.$titre.'%';
        }else{
            $ttitre = '';
        }
        if(isset($lieu)){
            $tlieu = ' AND (lieu LIKE :lieu) OR (ville LIKE :lieu)';
            $tab[':lieu'] = '%'.$lieu.'%';
        }else{
            $tlieu = '';
        }
        if(isset($categorie)){
            $tcat = ' AND (categorie LIKE :categorie)';
            $tab[':categorie'] = '%'.$categorie.'%';
        }else{
            $tcat = '';
        }
        if(isset($domaine)){
            $tdom = ' AND (domaineActivite = :domaine)';
            $tab[':domaine'] =  $domaine;
        }else{
            $tdom = '';
        }
        if(isset($id)){
            $tid = ' AND idEntreprise = :id';
            $tab[':id'] = $id;
        }else{
            $tid = '';
        }
        return self::query(self::selectString().$where.$tid.$tlieu.$tcat.$ttitre.$tdom.$limit,$tab);
    }


}