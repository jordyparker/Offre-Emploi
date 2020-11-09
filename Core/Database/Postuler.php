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

class Postuler extends Table
{
    protected static $table = 'postuler';

    public static function save($idCandidat,$nomC,$idOffre,$idEntreprise,$titreO,$rootC,$rootM,$rootA,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET idCandidat = :idCandidat,idEntreprise = :id,nomC = :nomC,idOffre = :idOffre,titreO = :titreO,CNI = :rootC,lettreMotivation = :rootM, autre = :rootA';
        $baseParam = [':idCandidat' => $idCandidat,':idOffre' => $idOffre,':rootC' => $rootC,':rootM' => $rootM,':rootA' => $rootA,':nomC'=>$nomC,':titreO'=>$titreO,':id' => $idEntreprise];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE id = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function deleteC($id,$ido){
        $sql = 'DELETE FROM '. self::getTable() .' WHERE idCandidat = :id AND idOffre = :ido';
        $param =[':id'=>$id,':ido'=>$ido];
        return self::query($sql,$param,true,true);
    }


    public static function deleteOffrePostuler($ido){
        $sql = 'DELETE FROM '. self::getTable() .' WHERE idOffre = :ido';
        $param =[':ido'=>$ido];
        return self::query($sql,$param,true,true);
    }

    public static function delete($id){
        $sql = 'DELETE FROM '. self::getTable() .' WHERE idCandidat = :id';
        $param =[':id'=>$id];
        return self::query($sql,$param,true,true);
    }

    public static function findCa($id){
        $sql = static::selectString().' WHERE idCandidat = :id';
        return self::query($sql,[':id'=>$id],true);
    }
    public static function findDo($id,$ido){
        $sql = static::selectString().' WHERE idCandidat = :id AND idOffre = :idO';
        return self::query($sql,[':id'=>$id,':idO'=>$ido],true);
    }
    public static function findE($id){
        $sql = static::selectString().' WHERE idEntreprise = :id';
        return self::query($sql,[':id'=>$id],true);
    }

    public static function findO($id){
        $sql = static::selectString().' WHERE idOffre = :id';
        return self::query($sql,[':id'=>$id],true);
    }

    public static function findPost($idCandidat,$idOffre){
        $sql = 'SELECT * FROM ';
        $baseSql = self::getTable().' WHERE idOffre= :idOffre AND idCandidat = :idCandidat';
        $baseParam = [':idOffre' => $idOffre,':idCandidat' => $idCandidat];
        return self::query($sql.$baseSql,$baseParam,false,true);
    }

    public static function countBySearchType($titreO=null,$nomC=null,$idC=null,$idE=null,$id=null){
        $count = 'SELECT COUNT(*) AS Total FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($titreO)){
            $ttitre = ' AND titreO LIKE :titreO';
            $tab[':titreO'] = '%'.$titreO.'%';
        }else{
            $ttitre = '';
        }
        if(isset($id)){
            $tid = ' AND idOffre = :id';
            $tab[':id'] = $id;
        }else{
            $tid = '';
        }
        if(isset($idE)){
            $tidE = ' AND idEntreprise = :idE';
            $tab[':idE'] = $idE;
        }else{
            $tidE = '';
        }
        if(isset($nomC)){
            $tnomC = ' AND nomC LIKE :nomC';
            $tab[':nomC'] = '%'.$nomC.'%';
        }else{
            $tnomC = '';
        }
        if(isset($idC)){
            $tIdc = ' AND idCandidat = :id';
            $tab[':id'] = $idC;
        }else{
            $tIdc = '';
        }
        return self::query($count.$where.$tnomC.$ttitre.$tid.$tidE.$tIdc,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$titreO=null,$nomC=null,$idC=null,$idE=null,$id=null){
        $limit = ' ORDER BY created_at DESC';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($id)){
            $tid = ' AND idOffre = :id';
            $tab[':id'] = $id;
        }else{
            $tid = '';
        }
        if(isset($titreO)){
            $ttitre = ' AND titreO LIKE :titreO';
            $tab[':titreO'] = '%'.$titreO.'%';
        }else{
            $ttitre = '';
        }
        if(isset($idE)){
            $tidE = ' AND idEntreprise = :idE';
            $tab[':idE'] = $idE;
        }else{
            $tidE = '';
        }
        if(isset($nomC)){
            $tnomC = ' AND nomC LIKE :nomC';
            $tab[':nomC'] = '%'.$nomC.'%';
        }else{
            $tnomC = '';
        }
        if(isset($idC)){
            $tIdc = ' AND idCandidat = :id';
            $tab[':id'] = $idC;
        }else{
            $tIdc = '';
        }
        return self::query(self::selectString().$where.$ttitre.$tid.$tnomC.$tidE.$tIdc.$limit,$tab);
    }

}