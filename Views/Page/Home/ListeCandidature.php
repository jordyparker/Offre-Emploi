<?php

use Projet\Database\Candidat;
use Projet\Database\Message;
use Projet\Database\Offre;
use Projet\Database\Postuler;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\FileHelper;
use Projet\Model\Paginator;
use function Projet\var_die;
use Projet\Model\StringHelper;

$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
$categories = StringHelper::$categorie;
$activites = StringHelper::$secteurActivite;
App::addScript('assets/js/page/message.js',true);
App::addScript('assets/js/page/deleteCandidature.js',true);
if(App::getDBAuth()->isLogged()){
    $user = App::getDBAuth()->user();
}
?>
<section class="ftco-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="<?= App::url('account/listeCandidature') ?>" class="search-job form-row">
                    <input type="hidden" id="id" name="id" <?= (isset($_GET['id'])&&!empty($_GET['id']))?'value="'.$user->id.'"':''; ?>>
                    <div class="form-group col-md-4">
                        <input type="text" placeholder="Chercher par titre offre" class="form-control" id="titre" name="titre" style="border-radius: 0px" <?= (isset($_GET['titre'])&&!empty($_GET['titre']))?'value="'.$_GET['titre'].'"':''; ?>>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" placeholder="Chercher par nom candidat" class="form-control" id="nom" name="nom" style="border-radius: 0px" <?= (isset($_GET['nom'])&&!empty($_GET['nom']))?'value="'.$_GET['nom'].'"':''; ?>>
                    </div>
                    <div class="form-group col-md-12">
                        <button class="btn btn-primary pull-right" style="border-radius: 0px">CHERCHER</button>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <div class="row">
            <a href="<?= App::url('account/listeCandidature?id='.$user->id) ?>"><i class="fa fa-refresh" style="font-size: 20px"><?= ' '?>Refresh</i></a>
            <table class="table table-striped table-responsive-sm">
                <thead style="color:#000000;font-weight: bold">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Nom </th>
                    <th scope="col">Prenom</th>
                    <th scope="col">Age</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Titre Offre</th>
                    <th scope="col">Domaine d'activité</th>
                    <th scope="col">Ville</th>
                    <th scope="col">Statut</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody style="font-size : 14px">
                <?php
                $i=1;
                if(!empty(Postuler::findE($user->id))){
                    if(!empty($postuler)){
                        foreach ($postuler as $ne){
                            $candidat = Candidat::find($ne->idCandidat);
                            $offre = Offre::find($ne->idOffre);?>
                            <tr>
                                <th scope="row"><?= $i ?></th>
                                <th scope="row"><img class="rounded-circle"src="<?= FileHelper::url($candidat->photo) ?>" alt="" style="max-width: 50px;max-height: 50px;"></th>
                                <td><?= $candidat->nom ?></td>
                                <td><?= $candidat->prenom ?></td>
                                <td><?php echo DateParser::calculAge($candidat->date); ?></td>
                                <td><a href="mailto:<?= $candidat->email ?>"><?= $candidat->email ?></a></td>
                                <td><?= $offre->titre ?></td>
                                <td>
                                    <?php foreach ($activites as $key=>$value){
                                        if($key==$candidat->domaineActivite)
                                        {
                                            echo $value;
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?= $candidat->ville?>
                                </td>
                                <td><?php
                                    if($mes = Message::findM($candidat->id,$offre->id)){

                                    ?>
                                        <i class="fa fa-check" style="color:#00cc66;font-size: 20px"></i>
                                <?php
                                    }
                                    else{
                                          ?>
                                        <i class="fa fa-times" style="color:red;font-size:20px"></i>
                                        <?php
                                        }
                                    ?></td>
                                <td>
                                    <a href="<?= App::url('account/listeCandidature/detail?id='.$candidat->id.'&ido='.$offre->id)?>" id="details"><i class="fa fa-question-circle" style="font-size: 20px;color:#157efb"></i></a>
                                    <a href="javascript:void(0)" id="deleteCandidature" data-id="<?= $candidat->id."#".$offre->id ?>" data-url="<?= App::url('account/delete/candidature') ?>"><i class="fa fa-trash" style="font-size: 20px;color:red"></i></a>
                                    <a href="#" id="messageModal" data-idc="<?= $candidat->id ?>" data-ido="<?= $offre->id ?>"><i class="icon icon-envelope" style="font-size: 20px;color:#000000"></i></a>
                                </td>
                            </tr>
                            <?php $i++; }
                    }else{ ?>
                        <td colspan="9" class="uk-width-medium-1-1 uk-text-danger uk-text-center">
                            La liste des candidatures est vide
                        </td>
                    <?php }
                }else{?>
                    <td colspan="9" class="uk-width-medium-1-1 uk-text-danger uk-text-center">
                        Vous n'avez aucune demande d'emploi
                    </td>
                <?php } ?>
                </tbody>
            </table>
            <?php if(!empty($postuler)){ ?>
                <div class="uk-grid col-md-12" data-uk-grid-margin="">
                    <div class="uk-width-medium-1-1">
                        <?= $paginator->paginateTwo(); ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<div class="modal fade" id="modalMessage" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"  style="border-radius: 0">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= App::url('account/listeCandidature/message') ?>" method="post" class="search-job form-row cv" id="addMsg">
                    <input type="hidden" id="idO" name="idO">
                    <input type="hidden" id="idC" name="idC">
                    <div class="form-group col-md-12">
                        <label for="description">Message Response</label>
                        <textarea id="description" class="form-control" name="description"></textarea><br>
                    </div>
                    <div class="form-group col-md-4">
                        <button type="submit" class="btn btn-primary" style="border-radius:0" id="btnSubmit">Envoyez</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

