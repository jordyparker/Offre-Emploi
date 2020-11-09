<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 10/05/2019
 * Time: 14:41
 */

use Projet\Database\Offre;
use Projet\Model\FileHelper;
use Projet\Model\App;
use Projet\Model\Session;
use Projet\Model\StringHelper;

$session = Session::getInstance();
$categorie = StringHelper::$categorie;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700,800,900" rel="stylesheet">
    <title><?= App::getTitle(); ?></title>
    <!-- styles-->
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
    App::addStyle('assets/css/otherStyle.css',true,true);
    App::addStyle('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css',true,true);
    App::addScript('assets/plugins/selectric/public/bootstrap-select.css',true,true);
    App::addScript('assets/plugins/selectric/public/bootstrap-select.min.css',true,true);
    App::addStyle('assets/css/flaticon.css',true,true);
    App::addStyle('assets/css/icomoon.css',true,true);
    App::addStyle('assets/css/style.css',true,true);
    App::addStyle('assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css',true,true);
    App::addStyle('assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css',true,true);
    App::addStyle('assets/css/util.css',true,true);
    App::addStyle('assets/css/main.css',true,true);
    App::addStyle('assets/plugins/summernote/summernote-bs4.css',true,true);
    App::addStyle('assets/plugins/uikit/css/uikit.almost-flat.min.css',true,true);
    App::addStyle('assets/plugins/uikit/css/uikit.css',true,true);
    App::addStyle('assets/plugins/uikit/css/uikit.min.css',true,true);
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
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <p class="navbar-brand">JobAlert</p>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a href="<?= App::url('') ?>" class="nav-link">Acceuil</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Nous Contacter</a></li>
                <li class="nav-item"><a href="<?= App::url('login') ?>" class="nav-link" ><i class="icon-user" style="font-size: 20px"></i></a></li>
                <li class="nav-item cta mr-md-2"><a href="<?= App::url('login') ?>" class="nav-link">Poster une offre</a></li>
                <li class="nav-item cta cta-colored"><a href="<?= App::url('emplois') ?>" class="nav-link">Emplois</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="hero-wrap js-fullheight" style="background-image: url(<?= FileHelper::url('assets/images/img_6.jpg') ?>);" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start" data-scrollax-parent="true">
            <div class="col-xl-10 ftco-animate mb-5 pb-5" data-scrollax=" properties: { translateY: '70%' }">
                <p class="mb-4 mt-5 pt-5" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">vous avez <span class="number" data-number="<?php $nbre = Offre::count(); echo $nbre->Total;?>">0</span> emplois offerts!</p>
                <!--<h1 data-scrollax="properties: { translateY: '30%', opacity: 1.6 }" class="text-change mb-5"> </h1>-->
                <h1 class="mb-5" style="font-style:italic">Trouvez-<i class="text-change"> </i></h1>
                   <div class="row bg-white" style="border-radius: 5px">
                    <div class="col-md-12 tab-wrap">
                        <div class="tab-content p-4" id="v-pills-tabContent">
                            <form action="<?= App::url('emplois') ?>" class="search-job">
                                <div class="row">
                                    <div class="col-md">
                                        <div class="form-group">
                                            <div class="form-field">
                                                <div class="icon"><span class="icon-briefcase"></span></div>
                                                <input type="text" class="form-control" placeholder="ex.. Webmaster" id="titre" name="titre" <?= (isset($_GET['titre'])&&!empty($_GET['titre']))?'value="'.$_GET['titre'].'"':''; ?>>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="form-group">
                                            <div class="form-field">
                                                <div class="select-wrap">
                                                    <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                                    <select class="form-control bg-light" id="categorie" name="categorie" <?= (isset($_GET['categorie'])&&!empty($_GET['categorie']))?'value="'.$_GET['categorie'].'"':''; ?>>
                                                        <option value="" selected>Catégorie</option>
                                                        <?php
                                                            foreach($categorie as $key=>$value)
                                                            {
                                                                echo '<option value="'.$key.'">'.$value.'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="form-group">
                                            <div class="form-field">
                                                <div class="icon"><span class="icon-map-marker"></span></div>
                                                <input type="text" class="form-control" placeholder="Location" id="lieu" name="lieu" <?= (isset($_GET['lieu'])&&!empty($_GET['lieu']))?'value="'.$_GET['lieu'].'"':''; ?>>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="form-group">
                                            <div class="form-field">
                                                <input type="submit" value="Rechercher" class="form-control btn btn-primary">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $content ?>
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
                            <li><i class="icon icon-phone"></i><p class="text">(+237) <?= \Projet\thousand(695113844) ?></p></li>
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
<a href="index.html#0" class="cd-top"> <i class="fa fa-angle-double-up"></i></a>
<?php
App::addScript('assets/js/jquery.min.js',true,true);
App::addScript('assets/js/jquery-migrate-3.0.1.min.js',true,true);
App::addScript('assets/js/popper.min.js',true,true);
App::addScript('assets/js/script.js',true,true);
App::addScript('assets/js/bootstrap.min.js',true,true);
App::addScript('assets/js/jquery.easing.1.3.js',true,true);
App::addScript('assets/js/jquery.waypoints.min.js',true,true);
App::addScript('assets/js/jquery.stellar.min.js',true,true);
App::addScript('assets/js/owl.carousel.min.js',true,true);
App::addScript('assets/js/jquery.magnific-popup.min.js',true,true);
App::addScript('assets/js/aos.js',true,true);
App::addScript('assets/js/jquery.animateNumber.min.js',true,true);
App::addScript('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js',true,true);
App::addScript('assets/plugins/selectric/public/bootstrap-select.min.js',true,true);
App::addScript('assets/plugins/selectric/public/bootstrap-select.js',true,true);
App::addScript('assets/js/jquery.timepicker.min.js',true,true);
App::addScript('assets/js/scrollax.min.js',true,true);
App::addScript('assets/plugins/toastr/toastr.min.js',true,true);
App::addScript('assets/js/google-map.js',true,true);
App::addScript('assets/js/main.js',true,true);
App::addScript('assets/plugins/summernote/summernote-bs4.js',true,true);
App::addScript('assets/plugins/uikit/js/uikit_custom.min.js',true,true);
App::addScript('assets/js/page/email.js',true);
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
<script>
    function backtotop(){
        // browser window scroll (in pixels) after which the "back to top" link is shown
        var offset = 300,
            //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
            offset_opacity = 1200,
            //duration of the top scrolling animation (in ms)
            scroll_top_duration = 700,
            //grab the "back to top" link
            $back_to_top = $('.cd-top');
        //hide or show the "back to top" link
        $(window).scroll(function(){
            ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
            if( $(this).scrollTop() > offset_opacity ) {
                $back_to_top.addClass('cd-fade-out');
            }
        });
        //smooth scroll to top
        $back_to_top.on('click', function(event){
            event.preventDefault();
            $('body,html').animate({
                    scrollTop: 0 ,
                }, scroll_top_duration
            );
        });
    }
</script>
</body>
</html>
