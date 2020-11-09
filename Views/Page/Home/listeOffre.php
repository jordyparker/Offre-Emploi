<?php

use Projet\Database\Candidat;
use Projet\Database\Entreprise;
use Projet\Database\Message;
use Projet\Database\Offre;
use Projet\Database\Postuler;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\FileHelper;
use Projet\Model\Paginator;
use function Projet\var_die;
use Projet\Model\StringHelper;
App::addScript('assets/js/page/editJob.js',true);
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
                <form action="<?= App::url('account/listeOffre') ?>" class="search-job form-row" id="search">
                    <input type="hidden" id="id" name="id" <?= (isset($_GET['id'])&&!empty($_GET['id']))?'value="'.$user->id.'"':''; ?>>
                    <div class="form-group col-md-6">
                        <input type="text" placeholder="Chercher par titre emploi" class="form-control pull-right" style="border-radius: 0px" id="titre" name="titre" <?= (isset($_GET['titre'])&&!empty($_GET['titre']))?'value="'.$_GET['titre'].'"':''; ?>>
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
            <table class="table table-striped table-responsive-sm">
                <a href="<?= App::url('account/listeOffre?id='.$user->id) ?>"><i class="fa fa-refresh pull-right" style="font-size: 20px"><?=" "?>Refresh</i></a>
                <thead style="color:#000000;font-weight: bold">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Titre</th>
                    <th scope="col">Categorie</th>
                    <th scope="col">Secteur d'activité</th>
                    <th scope="col">Delais</th>
                    <th scope="col">Lieu</th>
                    <th scope="col">Ville</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody style="font-size : 14px">
                    <?php
                    $i=1;
                    if(!empty(Offre::findE($user->id))){
                        if(!empty($offre)) {
                            foreach ($offre as $ne) {?>
                                <tr>
                                    <th scope="row"><?= $i ?></th>
                                    <td><?= $ne->titre ?></td>
                                    <td>
                                        <?php foreach($categories as $key=>$value){
                                            if($ne->categorie == $key)
                                            {
                                                echo $value;
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php foreach($activites as $key=>$value){
                                            if($ne->domaineActivite == $key)
                                            {
                                                echo $value;
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td><?= DateParser::DateConviviale($ne->delais) ?></td>
                                    <td><?= $ne->lieu ?></td>
                                    <td>
                                        <?= $ne->ville?>
                                    </td>
                                    <td>
                                        <a id="editJob" data-titre="<?= $ne->titre ?>" data-ido="<?= $ne->id ?>" data-categorie="<?= $ne->categorie ?>" data-domaine="<?= $ne->domaineActivite?>" data-description="<?= $ne->description ?>"  data-delais="<?= $ne->delais ?>"  data-lieu="<?= $ne->lieu ?>"  data-salaire="<?= $ne->salaire==0?'':$ne->salaire ?>"  data-ville="<?= $ne->ville ?>" data-url="<?= App::url('account/listeOffre') ?>"><i class="fa fa-edit" style="font-size: 20px;color:black"></i></a>
                                        <a id="deleteJob" data-id="<?= $ne->id ?>" data-url="<?= App::url('account/delete/offre') ?>"><i class="fa fa-trash" style="font-size: 20px;color:red"></i></a>
                                    </td>
                                </tr>
                                <?php $i++;
                            }
                        }else{ ?>
                            <td colspan="9" class="uk-width-medium-1-1 uk-text-danger uk-text-center">
                                La liste de vos emplois est vide
                            </td>
                        <?php }?>
                    <?php }else{ ?>
                        <td colspan="9" class="uk-width-medium-1-1 uk-text-danger uk-text-center">
                            Vous n'avez publier à aucun emploi
                        </td>
                    <?php } ?>
                </tbody>
            </table>
            <?php if(!empty($offre)){ ?>
                <div class="uk-grid col-md-12" data-uk-grid-margin="">
                    <div class="uk-width-medium-1-1">
                        <?= $paginator->paginateTwo(); ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<div class="modal fade" id="modalJob" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content"  style="border-radius: 0">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalScrollableTitle">EDIT JOB</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= App::url('entreprise/postjob') ?>" class="p-5 bg-white search-job" id="formPost" method="post">
                    <input type="hidden" id="offre" name="offre">
                    <div class="row form-group">
                        <p class="ml-0">(<span style="color:red">*</span>) champs obligatoires</p>
                        <div class="col-md-12 mb-3 mb-md-0">
                            <label class="font-weight-bold" for="titre">Titre de l'emploi<span style="color:red">*</span></label><br>
                            <input type="text" id="titre" name="titre" class="form-control title" placeholder="ex. Developpeur Full Stack"><br>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12 mb-3 mb-md-0">
                            <label class="font-weight-bold" for="categorie">Categorie<span style="color:red">*</span></label><br>
                            <select type="text" id="categorie" name="categorie" class="form-control type">
                                <option value="" selected>Catégorie</option>
                                <?php
                                foreach($categories as $key=>$value)
                                {
                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                }
                                ?>
                            </select><br>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12 mb-3 mb-md-0">
                            <label class="font-weight-bold" for="salaire">Salaire Mensuel</label><br>
                            <input type="number" id="salaire" name="salaire" class="form-control" placeholder="ex. 300000"><br>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12 mb-3 mb-md-0">
                            <label class="font-weight-bold" for="titre">Lieu<span style="color:red">*</span></label><br>
                            <input type="text" id="lieu" name="lieu" class="form-control" placeholder="ex. Douala,Akwa"><br>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12 mb-3 mb-md-0">
                            <label class="font-weight-bold" for="ville">Ville<span style="color:red">*</span></label><br>
                            <input type="text" id="ville" name="ville" class="form-control"><br>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12 mb-3 mb-md-0">
                            <label class="font-weight-bold" for="delais">Date de délais<span style="color:red">*</span></label><br>
                            <input type="text" id="delais" name="delais" class="form-control date"><br>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12 mb-3 mb-md-0">
                            <label for="domaineActivite" >Secteur d'activité </label>
                            <select id="domaine" name="domaine" class="form-control">
                                <option selected style="color:#157efb">Secteur d'activité</option>
                                <?php
                                    foreach($activites as $key=>$value)
                                    {
                                        echo '<option value="'.$key.'">'.$value.'</option>';
                                    }
                                ?>
                            </select><br>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12 mb-3 mb-md-0">
                            <label class="font-weight-bold" for="description">Description<span style="color:red">*</span></label><br>
                            <textarea id="description" name="description" class="form-control description" cols="30" rows="10"></textarea><br>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary" id="btnPost" style="border-radius: 0px">UPDATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



