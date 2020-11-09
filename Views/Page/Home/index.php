<?php

use Projet\Database\Entreprise;
use Projet\Database\Offre;
use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\Paginator;
use Projet\Model\StringHelper;

$url = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$laPage = isset($_GET['page'])?$_GET['page']:1;
$paginator = new Paginator($url,$laPage,$nbrePages,$_GET,$_GET);
$categories = StringHelper::$categorie;
$activites = StringHelper::$secteurActivite;
?>
<section class="ftco-section services-section bg-white">
    <div class="container">
        <div class="row d-flex">
            <div class="col-md-3 d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services d-block">
                    <div class="icon"><span class="flaticon-resume"></span></div>
                    <div class="media-body">
                        <h3 class="heading mb-3">Recherche d'emploi(s)</h3>
                        <p>Vous êtes titulaire d'un diplôme, vous avez des compétences en un domaine précis, alors inscrivez vous sur JobAlert et postuler à des offres d'emplois. </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services d-block">
                    <div class="icon"><span class="flaticon-collaboration"></span></div>
                    <div class="media-body">
                        <h3 class="heading mb-3">Facile à gérer les emplois</h3>
                        <p>Vous êtes une entreprise, vous avez besoin d'un employé, alors inscrivez vous sur JobAlert pour publier des offres afin de choisir le profil correspondant à votre besoin parmis les candidatures reçues.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services d-block">
                    <div class="icon"><span class="flaticon-employee"></span></div>
                    <div class="media-body">
                        <h3 class="heading mb-3">Top Carrières</h3>
                        <p>Soyez constemment actif sur JobAlert pour ne pas perdre une opportinuté qui pourrais changer votre vie.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services d-block">
                    <div class="icon"><span class="flaticon-promotions"></span></div>
                    <div class="media-body">
                        <h3 class="heading mb-3">Recherche des candidats compétents</h3>
                        <p>Avant de publier une offre, faites des recherches dans votre cvthèque pour vérifier si un candidat à des compétences que vous recherchez, si vous le trouvez alors contactez le dans le cas contraire publiez votre offre.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
            <div class="col-md-7 heading-section text-center ftco-animate">
                <h2 class="mb-4"><span>Emplois</span> Recents</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 ftco-animate" style="color:#000000">
                <?php
                    foreach ($emplois as $emploi) {
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
                            <div><span class="fa fa-location-arrow"></span>
                                    <?= $emploi->ville.','.$emploi->lieu;?>
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
                    <?php } ?>
                <?php if(!empty($emplois)){ ?>
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
<section class="ftco-section ftco-counter">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
            <div class="col-md-7 heading-section text-center ftco-animate">
                <span class="subheading">Categories work wating for you</span>
                <h2 class="mb-4"><span>Current</span> Job Posts</h2>
            </div>
        </div>
        <div class="row">
            <?php foreach ($activites as $key=>$value){?>
                <div class="col-lg-4 ftco-animate">
                    <ul class="category">
                        <li><a href="<?= App::url("job/categorie?id=".$key.'') ?>"><?= $value ?> <span class="number"><?php $nbre= Offre::countCategorie($key); echo $nbre;?></span></a></li>
                    </ul>
                </div>
            <?php }?>
        </div>
    </div>
</section>
<section class="ftco-section ftco-counter img" id="section-counter" style="background-image: url(images/bg_1.jpg);" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-4 d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18 text-center">
                            <div class="text">
                                <strong class="number" data-number="<?= $offre->Total?>">0</strong>
                                <span>Emplois</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18 text-center">
                            <div class="text">
                                <strong class="number" data-number="<?= $entreprise->Total?>">0</strong>
                                <span>Entreprises</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18 text-center">
                            <div class="text">
                                <strong class="number" data-number="<?= $candidat->Total?>">0</strong>
                                <span>Candidats</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="ftco-section-parallax">
    <div class="parallax-img d-flex align-items-center">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
                    <h2 class="newsletter">Souscrire à notre Newsletter</h2>
                    <p>Souscrivez à notre newsletter pour être au parfum en temps réel de toute les offres publiées sur JobAlert</p>
                    <div class="row d-flex justify-content-center mt-4 mb-4">
                        <div class="col-md-8">
                            <form action="<?= App::url('subscribe') ?>" class="subscribe-form" id="subscribeForm" method="post">
                                <div class="form-group d-flex">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Entrer votre adresse email">
                                    <button type="submit" class="btn btn-success" id="btnSubscribe" style="border-top-left-radius: 0px;border-bottom-left-radius: 0px">Souscrire <i class="fa fa-send"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
