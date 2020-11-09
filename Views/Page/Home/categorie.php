<?php

use Projet\Database\Entreprise;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\Paginator;
use Projet\Model\StringHelper;

$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
$categories = StringHelper::$categorie;
$activites = StringHelper::$secteurActivite;?>
<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
            <div class="col-md-7 heading-section text-center ftco-animate">
                <h2 class="mb-4"><span><?php echo !empty($categorie)?"Tous Les Emplois":""?></span></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="<?= App::url('job/categorie') ?>" class="search-job form-row" id="search">
                    <div class="form-group col-md-3">
                        <input type="text" style="border-radius: 0px" class="form-control" placeholder="ex.. Webmaster" id="titre" name="titre" <?= (isset($_GET['titre'])&&!empty($_GET['titre']))?'value="'.$_GET['titre'].'"':''; ?>>
                    </div>
                    <div class="form-group col-md-3">
                        <select class="form-control" style="border-radius: 0px" id="categorie" name="categorie" <?= (isset($_GET['categorie'])&&!empty($_GET['categorie']))?'value="'.$_GET['categorie'].'"':''; ?>>
                            <option value="" selected>Catégorie</option>
                            <?php
                            foreach($categories as $key=>$value)
                            {
                                echo '<option value="'.$key.'">'.$value.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control" style="border-radius: 0px" placeholder="Location" id="lieu" name="lieu" <?= (isset($_GET['lieu'])&&!empty($_GET['lieu']))?'value="'.$_GET['lieu'].'"':''; ?>><br>
                    </div>
                    <div class="form-group col-md-3">
                        <button class="btn btn-primary pull-right" style="border-radius: 0px" id="btnSubmit">CHERCHER</button>
                        <br>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <a href="<?= App::url('job/categorie') ?>"><i class="fa fa-refresh pull-right" style="font-size: 20px"><?=" "?>Refresh</i></a>
            <div class="col-md-12 ftco-animate" style="color:#000000">
                <?php
                if(!empty($categorie)){
                    foreach ($categorie as $emploi) {
                        ?>
                        <div class="job-post-item bg-white p-4 d-block d-md-flex align-items-center">

                            <div class="mb-4 mb-md-0 mr-5">
                                <div class="job-post-item-header d-flex align-items-center">
                                    <h2 class="mr-3 text-black h4"><?= $emploi->titre ?></h2>
                                    <div class="badge-wrap">
                                <span class="bg-info text-white badge py-2 px-3">
                                    <?php foreach ($categories as $key=>$value){
                                        if($key==$emploi->categorie)
                                        {
                                            echo $value;
                                        }
                                    }
                                    ?>
                                </span>
                                    </div>
                                </div>
                                <div class="job-post-item-body d-block d-md-flex">
                                    <div class="mr-3"><span class="icon-layers"></span> <a href="<?php $entre = Entreprise::find($emploi->idEntreprise); echo $entre->siteweb !=''?$entre->siteweb:'';  ?>"><?php $entre = Entreprise::find($emploi->idEntreprise); echo $entre->siteweb !=''?$entre->siteweb:'';  ?></a></div>
                                    <div><span class="fa fa-location-arrow"></span> <span>
                                    <?= $emploi->ville?>
                                </span>
                                    </div>
                                </div>
                                <div class="job-post-item-body d-block d-md-flex">
                                    <div><span class="icon-timer_off"></span> <span><?= DateParser::DateConviviale($emploi->delais );?></span></div>
                                </div>
                                <div class="job-post-item-body d-block d-md-flex">
                                    <div><span class="pull-right"><?=  DateParser::getRelativeDate($emploi->created_at,1); ?></span></div>
                                </div>
                            </div>

                            <div class="ml-auto d-flex">
                                <a href="<?= App::url("jobsingle?idE=".$emploi->id.'')?>" class="btn btn-primary py-2 mr-1">Voir Plus</a>
                            </div>
                        </div>
                    <?php }
                }else{
                    echo '<h3 class="uk-width-medium-1-1 uk-text-danger uk-text-center">Aucun emploi pour cette catégorie/recherche</h3>';
                }?>
                <?php if(!empty($categorie)){ ?>
                    <div class="uk-grid" data-uk-grid-margin="">
                        <div class="uk-width-medium-1-1">
                            <?= $paginator->paginateTwo(); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>


