<?php
/**
 * Created by PhpStorm.
 * User: Ndjeunou
 * Date: 08/11/2016
 * Time: 14:31
 */
use Projet\Model\App;
use Projet\Model\FileHelper;

App::setTitle("404 Error");
?>
<div class="row">
    <div class="col-md-10 center" style="margin-top: 120px">
        <p class="text-center">
            <a href="<?= App::url(''); ?>" class="logo-name text-center" style="font-size: 3em">
                <h3 class="text-center" style="font-weight: bold">JobAlert</h3>
            </a>
        </p>
        <h1 class="text-center"><i class="fa fa-undo fa-3x"></i></h1>
        <h1 class="text-xxl text-primary text-center">404</h1>
        <div class="text-center">
            <h3>Oups ! Quelque chose ne va pas.</h3>
            <p class="text-md">Nous ne pouvons pas trouver ce que vous demandez !</p>
            <p class="text-md">Retour à <a href="<?= App::url(''); ?>">l'accueil</a>.</p>
        </div>
    </div>
</div>

