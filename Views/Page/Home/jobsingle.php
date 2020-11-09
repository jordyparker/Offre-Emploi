<?php

use Projet\Database\Candidat;
use Projet\Model\App;
use Projet\Database\Offre;
use Projet\Model\DateParser;
use Projet\Model\Session;
$id = $_GET['idE'];
$categories = \Projet\Model\StringHelper::$categorie;
$offres = Offre::find($id);
App::addScript('assets/js/page/postuler.js',true);
?>
<section class="ftco-section">
    <div class="container pt-2">
        <div style="color:#000000">
            <?php if($offres->salaire != 0) {
                echo '<h3> Salaire Mensuel : '.\Projet\thousand($offres->salaire) . " " . "XAF".'</h3 >';
                }
            ?>
            <h3 > Ville : <?= $offres->ville ?></h3 >
            <h3 > Type de contrat :
                <?php foreach($categories as $key=>$value){
                    if($offres->categorie == $key)
                    {
                        echo $value;
                    }
                }
                ?>
            </h3 >
            <h3 > Publier : <?=  DateParser::getRelativeDate($offres->created_at,1); ?></h3 >
            <h3 > Date de ferméture : <?= DateParser::DateConviviale($offres->delais );?></h3 >
            <h3 style="font-weight: bold">Description : </h3>
            <p style="padding-left: 50px"><?= $offres->description ?></p>
            <?php
            if(App::getDBAuth()->isLogged()){ $user = App::getDBAuth()->user(); if(Candidat::byEmail($user->email)){ ?>
                <a class="btn btn-primary"  id="postuler" data-idc="<?= $user->id ?>" data-ido="<?= $id ?>">Postuler</a>
                <?php }else{ ?>
                <a class="btn btn-primary" href="<?= App::url("login") ?>">Postuler</a>
               <?php Session::getInstance()->write("warning","Seul les candidats peuvent postuler aux emplois");}
            }else{ ?>
                <a class="btn btn-primary" href="<?= App::url("login") ?>">Postuler</a>
            <?php
                Session::getInstance()->write("warning","Veuillez vous connectez ou vous inscrire");
            }
            ?>
        </div>
    </div>
</section>
<div class="modal fade" id="modalPost" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"  style="border-radius: 0">
            <div class="modal-header">
                <h3 class="text-center">Postuler à l'offre <?= $offres->titre ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>(<span style="color:red">*</span>) champs obligatoires</p>
                <form action="<?= App::url('jobsingle/post') ?>" method="post" class="search-job form-row" id="formPost">
                    <input type="hidden" id="idC" name="idC">
                    <input type="hidden" id="idO" name="idO">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="file">Lettre de motivation</label>
                            <input type="file" class="form-control" id="fileM" name="fileM" style="border:none">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fileC">CNI<span style="color:red">*</span></label>
                            <input type="file" class="form-control" id="fileC" name="fileC" style="border:none">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="fileA">Autre</label>
                            <input type="file" class="form-control" id="fileA" name="fileA" style="border:none">
                        </div>
                        <div class="form-group col-md-4">
                            <br>
                            <button class="btn btn-primary" id="btnSubmit" style="border-radius: 0">Postuler</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
