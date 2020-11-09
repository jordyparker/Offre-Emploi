<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 14/05/2019
 * Time: 16:21
 */
use Projet\Model\App;

App::addScript('assets/js/page/login.js',true);

?>
<section class="ftco-section bg-white">
    <?php
    if (isset($_SESSION['warning'])) {
        echo '<div class="row justify-content-md-center"><div class="col-md-6"><div class="alert alert-warning col-md-12 text-center alert-dismissible" id="alertDanger"><button  class="close" data-dismiss="alert">&times;</button><span>' . $session->read('warning') . '</span></div></div></div>';
        $session->delete('warning');
    }
    ?>
    <div class="container-contact100" style="margin-top: 0px">
        <div class="wrap-contact100">
            <form class="search-job" id="loginForm" action="<?= App::url('login/log') ?>" method="post">
                <h2 class="text-center"><i class="icon-user" style="font-size:50px;color:#157efb"></i></h2>
                <div class="form-group" style="margin-bottom: 15px;">
                    <select  class="form-control"  id="user" name="user">
                        <option value="" selected>Se connecter en temps que</option>
                        <option value="1">Candidat</option>
                        <option value="2">Entreprise</option>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom: 15px;">
                    <input  class="form-control"  type="email" id="email" name="email" placeholder="E-mail">
                </div>

                <div class="form-group" style="margin-bottom: 15px;" >
                    <input class="form-control"  type="password" id="password" name="password" placeholder="Password">
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <button type="submit" class="btn btn-primary btn-block" id="btnL">
                        Connexion
                    </button>
                </div>
                <hr>
                <div class="text-center mt-2"><a href="#modalReset" id="reset" data-toggle="modal" style="font-style:italic">Mot de passe oublié ?</a></div>
                <p style="font-family: 'sans forgetica';font-style: italic" class="text-center">Vous n'avez pas de compte? <a href="<?= App::url('register') ?>"> S'enrégistrer</a></p>
            </form>
        </div>
    </div>
</section>
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

