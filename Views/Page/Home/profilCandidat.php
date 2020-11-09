<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 25/05/2019
 * Time: 16:25
 */
use Projet\Model\App;
use Projet\Model\StringHelper;

$pays = StringHelper::$tabLesPays;
$secteursActivites = StringHelper::$secteurActivite;
if(App::getDBAuth()->user())
{
    $user = $session->read('dbauth');
}
App::addScript('assets/js/page/editCandidat.js',true);
?>
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-2">
                <div class="card">
                    <div class="card-header border-light text-center" style="background-color: #157efb;color:#fff;size:14px">Editer mon profil</div>
                    <div class="card-body search-job">
                        <form action="<?= App::url('update/candidate');?>" class="form-row" method="post" id="updateForm" autocomplete="on">
                            <input type="hidden" id="id" name="id" value="<?= $user->id ?>">
                            <div class="form-group col-md-6">
                                <label for="nom" >Nom </label>
                                <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" value="<?= $user->nom ?>"><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nom" >Prenom </label>
                                <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom" value="<?= $user->prenom ?>"><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="date" >Date de naissance </label>
                                <input type="text" class="form-control" id="date" name="date" value="<?= $user->date ?>"><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="situationMatrimonial">Situation Matrimoniale</label>
                                <select id="situationMatrimonial" name="situationMatrimonial" class="form-control">
                                    <option value="" selected style="color:#157efb">Situation Matrimoniale</option>
                                    <option value="1" <?= $user->situationMatrimonial == 1 ? "selected" : "" ?>>Marié(e)</option>
                                    <option value="2" <?= $user->situationMatrimonial == 2 ? "selected" : "" ?>>Célibataire</option>
                                </select><br>

                            </div>
                            <div class="form-group col-md-6">
                                <label for="sexe" >Sexe</label>
                                <select class="form-control" id="sexe" name="sexe" >
                                    <option selected style="color:#157efb">Sexe</option>
                                    <option value="1"  <?= $user->sexe == 1 ? "selected" : "" ?>>Masculin</option>
                                    <option value="2"  <?= $user->sexe == 2 ? "selected" : "" ?>>Feminin</option>
                                </select><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="domaineActivite" >Secteur d'activité </label>
                                <select id="domaineActivite" name="domaineActivite" class="form-control">
                                    <option selected style="color:#157efb">Secteur d'activité</option>
                                    <?php
                                        foreach ($secteursActivites as $key=>$value ){ ?>
                                            <option value="<?=$key ?>" <?= $user->domaineActivite == $key ? "selected" : "" ?>><?= $value ?></option>';
                                       <?php }
                                    ?>
                                </select><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="numero" >Numéro </label>
                                <input type="tel" class="form-control" id="numero" name="numero" placeholder="Numéro de téléphone" value="<?php echo $user->numero; ?>"><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="adresse" >Adresse </label>
                                <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Adresse" value="<?= $user->adresse ?>"><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ville" >Ville</label>
                                <input type="text" id="ville" name="ville" class="form-control" value="<?= $user->ville ?>"><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="pays" >Pays</label>
                                <select id="pays" name="pays" class="form-control" >
                                    <option value="" selected style="color:#157efb">Pays</option>
                                    <?php
                                    foreach ($pays as $key=>$pays ){ ?>
                                        <option value="<?= $key ?>" <?= $user->pays == $key ? "selected" : "" ?>><?= $pays ?></option>;
                                    <?php
                                    }
                                    ?>
                                </select><br>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="email" >E-mail</label>
                                <input type="email" autocomplete="email" class="form-control" id="email" name="email" placeholder="E-mail" value="<?= $user->email ?>"><br>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="photo" >Photo</label>
                                <input type="file"  id="file" name="file"><br>
                            </div>
                            <div class="form-group col-md-6" style="margin-top: 15px">
                                <button class="btn btn-primary btn-block" id="btnC">Modifier mon compte</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-2">
                <div class="card">
                    <div class="card-header border-light text-center" style="background-color: #157efb;color:#fff;size:14px">Editer mes paramètres</div>
                    <div class="card-body search-job">
                        <form action="<?= App::url('change/passwordC');?>" class="form-row" method="post" id="formU">
                            <input type="hidden" id="id" name="id" value="<?= $user->id?>">
                            <div class="form-group col-md-12">
                                <label for="apassword">Ancien Mot de passe</label>
                                <input type="password" class="form-control" id="apassword" name="apassword" placeholder="Ancien Mot de passe" ><br>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="npassword" >Nouveau mot de passe</label>
                                <input type="password" class="form-control" id="npassword" name="npassword" placeholder="Nouveau mot de passe" ><br>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="cnpassword" >Confirmer le nouveau mot de passe</label>
                                <input type="password" class="form-control" id="cnpassword" name="cnpassword" placeholder="Confirmer le mot de passe" ><br>
                            </div>
                            <div class="form-group col-md-12" style="margin-top: 15px">
                                <button class="btn btn-primary" id="btnU" data-id="<?= $user->id ?>">Modifier</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-header border-light text-center" style="background-color: #157efb;color:#fff;size:14px">Supprimer mon compte</div>
                    <div class="card-body search-job">
                        <h3>Supprimer votre Compte</h3>
                        <p style="color:#000000;font-size: 12px;font-style: italic">Nb : Une fois votre compte supprimer vous perdrez toutes vos informations et vous n'aurez plus la possibilité de postuler à des offres d'emplois</p>
                            <div class="form-group col-md-3" style="margin-top: 15px">
                                <a data-url="<?= App::url('delete/candidate');?>" href="javascript:void(0)" data-id="<?= $user->id ?>" class="btn btn-primary deleteUser">SUPPRIMER</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

