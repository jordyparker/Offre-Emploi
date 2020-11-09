<?php

use Projet\Database\Candidat;
use Projet\Database\Entreprise;
use Projet\Database\Message;
use Projet\Database\Offre;
use Projet\Database\Postuler;
use Projet\Model\App;
use Projet\Model\FileHelper;
use Projet\Model\Paginator;
use Projet\Model\StringHelper;
App::addScript('assets/js/page/deleteC.js',true);
$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
$categories = StringHelper::$categorie;
$activites = StringHelper::$secteurActivite;
$reponse = StringHelper::$reponse;
$user = App::getDBAuth()->user();
?>
<section class="ftco-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <form action="<?= App::url('account/consulterCandidature') ?>" class="search-job form-row" id="search">
                    <input type="hidden" id="id" name="id" <?= (isset($_GET['id'])&&!empty($_GET['id']))?'value="'.$user->id.'"':''; ?>>
                    <div class="form-group col-md-6">
                        <input type="text" placeholder="Chercher par titre offre" class="form-control pull-right" style="border-radius: 0px" id="titre" name="titre" <?= (isset($_GET['titre'])&&!empty($_GET['titre']))?'value="'.$_GET['titre'].'"':''; ?>>
                    </div>
                    <br>
                    <div class="form-group col-md-4">
                        <button class="btn btn-primary pull-right" style="border-radius: 0px" id="btnSubmit">CHERCHER</button>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <div class="row">
            <table class="table table-striped">
                <a href="<?= App::url('account/consulterCandidature?id='.$user->id) ?>"><i class="fa fa-refresh pull-right" style="font-size: 20px"><?=" "?>Refresh</i></a>
                <thead style="color:#000000;font-weight: bold">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Logo</th>
                    <th scope="col">Nom Entreprise</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Téléphone</th>
                    <th scope="col">Ville</th>
                    <th scope="col">Offre</th>
                    <th scope="col">Reponse</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody style="font-size : 14px">
                <?php
                    $i=1;
                    if(!empty(Postuler::findCa($user->id))){
                        if(!empty($postuler)) {
                            foreach ($postuler as $ne) {;
                                if(!empty(Candidat::find($ne->idCandidat)) && !empty($offre = Offre::find($ne->idOffre))){
                                    $candidat = Candidat::find($ne->idCandidat);
                                    $offre = $offre = Offre::find($ne->idOffre);
                                    $msg = Message::findM($candidat->id, $offre->id);
                                    $entreprise = Entreprise::find($offre->idEntreprise); ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <th scope="row"><img src="<?= FileHelper::url($entreprise->logo) ?>" alt=""
                                                             style="max-width: 50px;max-height: 50px"></th>
                                        <td><?= $entreprise->nom ?></td>
                                        <td><a href="mailto:<?= $entreprise->email ?>"><?= $entreprise->email ?></a></td>
                                        <td><?= $entreprise->numero ?></td>
                                        <td>
                                            <?= $entreprise->ville ?>
                                        </td>
                                        <td><?= $offre->titre ?></td>
                                        <td><?php if (!empty($msg)) {
                                                echo $msg->message;
                                            } else {
                                                echo '<span class="badge badge-info text-center"> En Attente</span>';
                                            } ?></td>
                                        <td>
                                            <a href="javascript:void(0)" id="deleteC" data-id="<?= $candidat->id ?>" data-ido="<?= $offre->id ?>" data-url="<?= App::url('account/delete/candidatures') ?>"><i class="fa fa-trash" style="font-size: 20px;color:red"></i></a>
                                        </td>
                                    </tr>
                                    <?php $i++;
                                }
                            }
                        }else{ ?>
                            <td colspan="9" class="uk-width-medium-1-1 uk-text-danger uk-text-center">
                                La liste des candidatures est vide
                            </td>
                        <?php }?>
                    <?php }else{ ?>
                        <td colspan="9" class="uk-width-medium-1-1 uk-text-danger uk-text-center">
                            Vous n'avez postuler à aucun emploi
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


