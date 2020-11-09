<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 10/05/2019
 * Time: 14:41
 */

use Projet\Database\Candidat;
use Projet\Database\Entreprise;
use Projet\Database\Offre;
use Projet\Model\DateParser;
use Projet\Model\FileHelper;
use Projet\Model\App;
use Projet\Model\Session;
use Projet\Model\StringHelper;
$session = Session::getInstance();
$categorie = StringHelper::$categorie;
$page = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
$type = $session->read('type');
if(App::getDBAuth()->user())
{
    $user = $session->read('dbauth');
    $nom = $user->nom;
}
if($type == 'entreprise')
{
$ul = ' <a class="dropdown-item " href="'.App::url('account').'" style="color:#000">Poster un emplois</a>
        <a class="dropdown-item " href="'.App::url('account/listeOffre?id='.$user->id.'').'" style="color:#000">Liste des emplois</a>
        <a class="dropdown-item" href="'.App::url('account/listeCandidature?id='.$user->id.'').'" style="color:#000">Liste des candidatures</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="'.App::url("logout").'" style="color:#000"><i class="fa fa-sign-out"></i> Déconnexion</a>';
    $name = "Compte Entreprise";
    $breadCum = '<a href="'.App::url('').'">Acceuil <i class="ion-ios-arrow-forward"></i></a><span> My Account</span></p>';
    App::setTitle('My Account');
}
elseif($type == 'candidat'){
    $ul = '<a class="dropdown-item" href="'.App::url('account').'" style="color:#000"><i class="fa fa-user"></i> Profil</a>
            <a class="dropdown-item" href="'.App::url('emplois').'" style="color:#000"><i class="fa fa-paper-plane"></i> Postuler à un emploi</a>
            <a class="dropdown-item" href="'.App::url('account/monCv').'" style="color:#000"><i class="fa fa-file"></i> Créér un Cv</a>
            <a class="dropdown-item" href="'.App::url('account/consulterCandidature?id='.$user->id.'').'" style="color:#000"><i class="fa fa-reply"></i>Consulter sa candidature</a>
            <a class="dropdown-item" href="'.App::url("account/profilCandidat").'" data-nom="'.$user->nom.'" style="color:#000" id="profilC"><i class="icon-user"></i> Editer mon Profil</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="'.App::url("logout").'" style="color:#000"><i class="fa fa-sign-out"></i> Déconnexion</a>';
    $name = "Compte Candidat";
    $breadCum = '<a href="'.App::url('').'">Acceuil <i class="ion-ios-arrow-forward"></i></a><span> My Account</span></p>';
    App::setTitle('My Account');
}
if($page == 'login') {
    $name = 'Connexion';
    $breadCum = '<a href="'.App::url('').'">Acceuil <i class="ion-ios-arrow-forward"></i></a><span> Log In</span></p>';
    App::setTitle('Connexion');
}
elseif ($page == 'register') {
    $name = "S'enrégister";
    $breadCum = '<a href="'.App::url('').'">Acceuil <i class="ion-ios-arrow-forward"></i></a><span> Sign In</span></p>';
    App::setTitle('Create Account');
}
elseif ($page == 'account/profilCandidat') {
    $name = "Mon Profil";
    $breadCum = '<a href="'.App::url('').'">Acceuil <i class="ion-ios-arrow-forward"></i></a><a href="'.App::url('account').'"> My Account <i class="ion-ios-arrow-forward"></i></a><span> Editer Profil</span></p>';
    App::setTitle('Profil');
}
elseif ($page == 'account/listeCandidature') {
    $name = "Liste des candidatures";
    $breadCum = '<a href="'.App::url('').'">Acceuil <i class="ion-ios-arrow-forward"></i></a><a href="'.App::url('account').'"> My Account <i class="ion-ios-arrow-forward"></i></a><span> candidatures</span></p>';
    App::setTitle('Liste des candidatures');
}
elseif ($page == 'account/listeOffre') {
    $name = "Liste des emplois";
    $breadCum = '<a href="'.App::url('').'">Acceuil <i class="ion-ios-arrow-forward"></i></a><a href="'.App::url('account').'"> My Account <i class="ion-ios-arrow-forward"></i></a><span> Mes emplois</span></p>';
    App::setTitle('Liste des emplois');
}
elseif ($page == 'emplois') {
    $name = "Liste des emplois";
    $breadCum = '<a href="'.App::url('').'">Acceuil <i class="ion-ios-arrow-forward"></i></a> Emplois</span></p>';
    App::setTitle('Liste des emplois');
}
elseif ($page == 'account/monCv') {
    $name = "Créer mon cv";
    $breadCum = '<a href="'.App::url('').'">Acceuil <i class="ion-ios-arrow-forward"></i></a><a href="'.App::url('account').'"> My Account <i class="ion-ios-arrow-forward"></i></a><span> cv</span></p>';
    App::setTitle('Mon cv');
}
elseif ($page == 'account/consulterCandidature') {
    $name = "Mes Candidatures";
    $breadCum = '<a href="'.App::url('').'">Acceuil <i class="ion-ios-arrow-forward"></i></a><a href="'.App::url('account').'"> My Account <i class="ion-ios-arrow-forward"></i></a><span> candidatures</span></p>';
    App::setTitle('Mes candidatures');
}
elseif ($page == 'account/listeCandidature/detail') {
    $name = "Detail du candidat";
    $breadCum = '<a href="'.App::url('').'">Acceuil <i class="ion-ios-arrow-forward"></i></a><a href="'.App::url('account').'"> My Account <i class="ion-ios-arrow-forward"></i></a><a href="'.App::url('account/listeCandidature?id='.$user->id).'"> candidatures <i class="ion-ios-arrow-forward"></i></a><span> Détail</span></p>';
    App::setTitle('Details candidat');
}
elseif ($page == 'contact') {
    $name = "Contact us";
    $breadCum = '<a href="'.App::url('').'">Acceuil <i class="ion-ios-arrow-forward"></i></a><span> Contact us</span></p>';
    App::setTitle("Contact us");
}
elseif ($page == 'job/categorie') {
    $name = "Categorie d'emploi";
    $breadCum = '<a href="'.App::url('').'">Acceuil <i class="ion-ios-arrow-forward"></i></a><span> Categorie d\'emploi</span></p>';
    App::setTitle("Categorie d'emploi");
}
?>
<!doctype html>
<html lang="en">
<head>
    <title><?= App::getTitle(); ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700,800,900" rel="stylesheet">
    <?php
    App::addStyle('assets/css/bootstrap.min.css',true,true);
    App::addStyle("assets/plugins/toastr/toastr.min.css",true,true);
    App::addStyle('assets/css/open-iconic-bootstrap.min.css',true,true);
    App::addStyle('assets/css/animate.css',true,true);
    App::addStyle('assets/css/owl.carousel.min.css',true,true);
    App::addStyle('assets/css/owl.theme.default.min.css',true,true);
    App::addStyle('assets/css/magnific-popup.css',true,true);
    App::addStyle('assets/css/aos.css',true,true);
    App::addStyle('assets/css/jquery.timepicker.css',true,true);
    App::addStyle('assets/css/ionicons.min.css',true,true);
    App::addStyle('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css',true,true);
    App::addStyle('assets/plugins/selectric/public/selectric.css',true,true);
    App::addStyle('assets/plugins/bootstrap-fileinput/css/fileinput.css',true,true);
    App::addStyle('assets/plugins/bootstrap-fileinput/css/fileinput.min.css',true,true);
    App::addStyle('assets/css/flaticon.css',true,true);
    App::addStyle('assets/css/icomoon.css',true,true);
    App::addStyle('assets/css/otherStyle.css',true,true);
    App::addStyle('assets/css/style.css',true,true);
    App::addStyle('assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css',true,true);
    App::addStyle('assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css',true,true);
    App::addStyle('assets/css/util.css',true,true);
    App::addStyle('assets/css/main.css',true,true);
    App::addStyle('assets/plugins/summernote/summernote-bs4.css',true,true);
    App::addStyle('assets/plugins/uikit/css/uikit.almost-flat.min.css',true,true);
    App::addStyle("assets/css/sweetalert.css",true, true);
    if(!empty(App::getStyles()['default'])){
        foreach (App::getStyles()['default'] as $default) {
            echo $default;
        }
    }
    if(!empty(App::getStyles()['source'])){
        foreach (App::getStyles()['source'] as $source) {
            echo $source;
        }
    }
    if(!empty(App::getStyles()['script'])){
        foreach (App::getStyles()['script'] as $style) {
            echo $style;
        }
    }
    ?>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-white ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar" style="color:black">
    <div class="container">
        <p class="navbar-brand">JobAlert</p>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a href="<?= App::url('') ?>" class="nav-link">Acceuil</a></li>
                <li class="nav-item"><a href="<?= App::url('emplois') ?>" class="nav-link">Emplois</a></li>
                <li class="nav-item"><a href="<?= App::url('contact') ?>" class="nav-link">Nous Contacter</a></li>
                <li class="nav-item cta mr-md-2"><a href="<?= App::url('account') ?>" class="nav-link">Poster un emploi</a></li>
            </ul>
            <?php if(App::getDBAuth()->isLogged()){ ?>
            <div class="btn-group" style="color:#fff;">
                <button type="button" style="text-transform: none;color:#fff;background-color: #5dd28e" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <?= App::getDBAuth()->isLogged()?App::salutation().''.$nom.' ':''?><i class="icon-user-circle" style="font-size:20px;"></i>
                </button>
                <div class="dropdown-menu">
                    <?= $ul ?>
                </div>
            </div>
            <?php } else{} ?>
        </div>
        </div>
    </div>
</nav>
<div class="hero-wrap js-fullheight bg-white" style="background-image: url(<?= FileHelper::url('assets/images/downloads/4.jpg') ?>);max-height: 400px" data-stellar-background-ratio="0.5">
    <div class="overlay bg-white"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start" data-scrollax-parent="true">
            <div class="col-md-8 ftco-animate text-center text-md-left mb-5" data-scrollax=" properties: { translateY: '70%' }" style="position:relative;top:-250px">
                <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-3"><?php if($page=='jobsingle'){
                    $id= $_GET['idE']; $offres = Offre::find($id); ?>
                    <h1 class="mb-5" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><?= $offres->titre ?></h1> <?php ?>
                        <div class="job-post-item-body d-block d-md-flex row" style="font-size:18px;font-weight: bold;">
                            <div class="col-md-3">
                                <span class="bg-info text-white badge py-2 px-3">
                                    <?php foreach ($categorie as $key=>$value){
                                        if($key==$offres->categorie)
                                        {
                                            echo $value;
                                        }
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="col-md-3">
                                <span class="fa fa-location-arrow"></span>
                                    <?= $offres->ville ?>
                            </div>
                            <div class="col-md-4"><span class="icon-timer_off"></span><?= DateParser::DateConviviale($offres->delais );?></div>
                            <div class="col-md-3"><span class="pull-right"></span><?=  DateParser::getRelativeDate($offres->created_at,1); ?></div>
                        </div>
                        <?php
                        }else{
                    ?><?= $breadCum ?>
                <h2 class="mb-3 bread" style="color:white" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><?= $name ?></h2> <?php } ?>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="modalReset">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Réinitialiser votre mot de passe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= App::url("login/reset")?>" method="post" class="search-job" id="resetForm">
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="E-mail" required/>
                    </div>
                    <button class="btn-primary btn btn-block" type="submit" id="submit_password" style="margin-top: 15px">Envoyer <i class="fa fa-send"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $content ?>
<section class="ftco-section ftco-counter img" id="section-counter" style="background-image: url(images/bg_1.jpg);" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-4 d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18 text-center">
                            <div class="text">
                                <strong class="number" data-number="<?php $nbre = Offre::count()->Total; if(!empty($nbre)){echo $nbre;}else{echo 0;} ?>">0</strong>
                                <span>Emplois</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18 text-center">
                            <div class="text">
                                <strong class="number" data-number="<?php $nbre = Entreprise::count()->Total; if(!empty($nbre)){echo $nbre;}else{echo 0;}?>">0</strong>
                                <span>Entreprises</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center counter-wrap ftco-animate">
                        <div class="block-18 text-center">
                            <div class="text">
                                <strong class="number" data-number="<?php $nbre = Candidat::count()->Total; if(!empty($nbre)){echo $nbre;}else{echo 0;}?>">0</strong>
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
                    <h2>Souscrire à notre Newsletter</h2>
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
<footer class="ftco-footer ftco-bg-dark ftco-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="ftco-heading-2">A Propos</h2>
                    <p>Suivez vous sur nos pages.</p>
                    <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-3">
                        <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                        <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                        <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="ftco-heading-2">Employeurs</h2>
                    <ul class="list-unstyled">
                        <li><a href="#" class="py-2 d-block">Publier une offre</a></li>
                        <li><a href="#" class="py-2 d-block">Gestion des candidatures</a></li>
                        <li><a href="#" class="py-2 d-block">Consulter les cv</a></li>
                        <li><a href="#" class="py-2 d-block">Rechercher un profil</a></li>

                    </ul>
                </div>
            </div>
            <div class="col-md">
                <div class="ftco-footer-widget mb-4 ml-md-4">
                    <h2 class="ftco-heading-2">Candidats</h2>
                    <ul class="list-unstyled">
                        <li><a href="#" class="py-2 d-block">Postuler à une offre</a></li>
                        <li><a href="#" class="py-2 d-block">Consulter les emplois</a></li>
                        <li><a href="#" class="py-2 d-block">Gestion de candidature</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="ftco-heading-2">Vous avez des questions?</h2>
                    <div class="block-23 mb-3">
                        <ul>
                            <li><span class="icon icon-map-marker"></span><span class="text">Douala Akwa, Rue castelneau</span></li>
                            <li><i class="icon icon-phone"></i><a href="tel:+237 695113844"><p class="text">+237 695113844 </p></a></li>
                            <li><a href="mailto:jordanlontsi01@yahoo.com"><span class="icon icon-envelope"></span><span class="text">jordanlontsi01@yahoo.com</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">

                <p>
                    Copyright &copy; <script>document.write(new Date().getFullYear());</script> JobAlert. Tous les droits réservés
                </p>
            </div>
        </div>
    </div>
</footer>
<a href="index.html#0" class="cd-top"><i class="fa fa-angle-double-up"></i></a>
<?php
App::addScript('assets/js/jquery.min.js',true,true);
App::addScript('assets/js/jquery-migrate-3.0.1.min.js',true,true);
App::addScript('assets/js/script.js',true,true);
App::addScript('assets/js/popper.min.js',true,true);
App::addScript('assets/js/bootstrap.min.js',true,true);
App::addScript('assets/js/jquery.easing.1.3.js',true,true);
App::addScript('assets/js/jquery.waypoints.min.js',true,true);
App::addScript('assets/js/jquery.stellar.min.js',true,true);
App::addScript('assets/js/owl.carousel.min.js',true,true);
App::addScript('assets/js/jquery.magnific-popup.min.js',true,true);
App::addScript('assets/js/aos.js',true,true);
App::addScript('assets/js/jquery.animateNumber.min.js',true,true);
App::addScript('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js',true,true);
App::addScript('assets/plugins/selectric/public/jquery.selectric.min.js',true,true);
App::addScript('assets/plugins/bower_components/ckeditor/ckeditor.js',true);
App::addScript('assets/plugins/bower_components/ckeditor/adapters/jquery.js',true);
App::addScript('assets/js/jquery.timepicker.min.js',true,true);
App::addScript('assets/js/scrollax.min.js',true,true);
App::addScript('assets/plugins/toastr/toastr.min.js',true,true);
App::addScript('assets/js/google-map.js',true,true);
App::addScript('assets/js/main.js',true,true);
App::addScript('assets/plugins/summernote/summernote-bs4.js',true,true);
App::addScript('assets/plugins/bootstrap-fileinput/js/fileinput.js',true,true);
App::addScript('assets/plugins/bootstrap-fileinput/js/fileinput.min.js',true,true);
App::addScript('assets/plugins/bootstrap-fileinput/js/locales/es.js',true,true);
App::addScript('assets/plugins/bootstrap-fileinput/js/plugins/piexif.min.js',true,true);
App::addScript('assets/plugins/bootstrap-fileinput/js/plugins/purify.min.js',true,true);
App::addScript('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js',true,true);
App::addScript('assets/plugins/uikit/js/uikit_custom.min.js',true,true);
App::addScript("assets/js/sweetalert.min.js",true, true);
if(!empty(App::getScripts()['default'])){
    foreach (App::getScripts()['default'] as $default) {
        echo $default.PHP_EOL;
    }
}
if(!empty(App::getScripts()['source'])){
    foreach (App::getScripts()['source'] as $source) {
        echo $source.PHP_EOL;
    }
}
if(!empty(App::getScripts()['script'])){
    foreach (App::getScripts()['script'] as $script)
    {
        echo $script.PHP_EOL;
    }
}
?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=A7QOK2M0TQLE&callback=loadmap" async defer></script>
</body>
</html>
