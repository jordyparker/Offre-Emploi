<?php
use Projet\Model\App;
use Projet\Model\StringHelper;
App::addScript('assets/js/page/entreprise.js',true);
App::addScript('assets/js/page/candidat.js',true);
$pays = StringHelper::$tabLesPays;
$secteursActivites = StringHelper::$secteurActivite;
?>
<section class="ftco-section bg-light">
    <div class="container" style="margin-top:20px;margin-bottom: 20px">
        <div class="row">
            <div class="col-lg-6 mt-4">
                <div class="card" style="box-shadow: #f5fcf8  5px 5px">
                    <div class="card-header border-light text-center" style="background-color: #157efb;color:#fff;size:14px">Compte Candidat</div>
                    <div class="card-body search-job">
                        <p class="ml-0">(<span style="color:red">*</span>) champs obligatoires</p>
                        <form action="<?= App::url('register/candidate');?>" class="form-row" method="post" id="formC" autocomplete="on">
                            <div class="form-group col-md-6">
                                <label for="nom" >Nom<span style="color:red">*</span></label>
                                <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" ><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nom" >Prenom<span style="color:red">*</span></label>
                                <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom" ><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="date" >Date de naissance<span style="color:red">*</span></label>
                                <input type="text" class="form-control" id="date" name="date"><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="situationMatrimonial">Situation Matrimoniale<span style="color:red">*</span></label>
                                <select id="situationMatrimonial" name="situationMatrimonial" class="form-control" >
                                    <option value="" selected style="color:#157efb">Situation Matrimoniale</option>
                                    <option value="1">Marié(e)</option>
                                    <option value="2">Célibataire</option>
                                </select><br>

                            </div>
                            <div class="form-group col-md-6">
                                <label for="sexe" >Sexe<span style="color:red">*</span></label>
                                <select class="form-control" id="sexe" name="sexe" >
                                    <option selected style="color:#157efb">Sexe</option>
                                    <option value="1">Masculin</option>
                                    <option value="2">Feminin</option>
                                </select><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="domaineActivite" >Secteur d'activité<span style="color:red">*</span></label>
                                <select id="domaineActivite" name="domaineActivite" class="form-control" >
                                    <option selected style="color:#157efb">Secteur d'activité</option>
                                    <?php
                                    foreach ($secteursActivites as $key=>$value ){
                                        echo '<option value="'.$key.'">'.$value.'</option>';
                                    }
                                    ?>
                                </select><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="numero" >Numéro<span style="color:red">*</span></label>
                                <input type="tel" class="form-control" id="numero" name="numero" placeholder="678463716" ><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="adresse" >Adresse </label>
                                <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Adresse" ><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ville" >Ville<span style="color:red">*</span></label>
                                <input type="text" id="ville" name="ville" class="form-control"><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="pays" >Pays<span style="color:red">*</span></label>
                                <select id="pays" name="pays" class="form-control" >
                                    <option value="" selected style="color:#157efb">Pays</option>
                                    <?php
                                    foreach ($pays as $key=>$pays ){
                                        echo '<option value="'.$key.'">'.$pays.'</option>';
                                    }
                                    ?>
                                </select><br>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="email" >E-mail<span style="color:red">*</span></label>
                                <input type="email" autocomplete="email" class="form-control" id="email" name="email" placeholder="E-mail" ><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password" >Mot de passe<span style="color:red">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" ><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="confirmpassword" >Confirmer le mot de passe<span style="color:red">*</span></label>
                                <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirmer le mot de passe" >
                            </div>
                            <div class="form-group col-md-12" style="margin-top: 15px">
                                <button class="btn btn-primary btn-block" id="btnC">Créer mon compte</button>
                            </div>
                        </form>
                        <hr class="bg-light">
                        <p style="font-family: 'sans forgetica';font-style: italic" class="text-center">Vous avez déja un compte?<a href="<?= App::url('login') ?>"> Se Connecter</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-4">
                <div class="card shadow-xl">
                    <div class="card-header border-light text-center" style="background-color: #157efb;color:#fff;size:14px">Compte Entreprise</div>
                    <div class="card-body search-job">
                        <p class="ml-0">(<span style="color:red">*</span>) champs obligatoires</p>
                        <form action="<?= App::url('register/entreprise');?>" id="formE" method="post" class="form-row" autocomplete="on">
                            <div class="form-group col-md-6">
                                <label for="nomE" >Nom Entreprise<span style="color:red">*</span></label>
                                <input type="text" class="form-control" id="nomE" name="nomE"  placeholder="Nom Entreprise" ><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="lieuE" >Lieu<span style="color:red">*</span></label>
                                <input type="text" class="form-control" id="lieuE" name="lieuE"  placeholder="Lieu" ><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="telE" >Numéro<span style="color:red">*</span></label>
                                <input type="tel" class="form-control" id="numeroE" name="numeroE"  placeholder="ex. (+237) 678463716" ><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="siteE" >Site Web</label>
                                <input type="text" class="form-control" id="siteE" name="siteE"  placeholder="Site Web"><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="emailE" >E-mail<span style="color:red">*</span></label>
                                <input type="email" class="form-control" autocomplete="email" id="emailE" name="emailE"  placeholder="E-mail" ><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="adresseE" >Adresse</label>
                                <input type="text" class="form-control" id="adresseE" name="adresseE"  placeholder="Adresse" ><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ville" >Ville<span style="color:red">*</span></label>
                                <input type="text" id="villeE" name="villeE" class="form-control"><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="domaineActiviteE" >Secteur d'activité<span style="color:red">*</span></label>
                                <select id="domaineActiviteE" name="domaineActiviteE" class="form-control">
                                    <option selected style="color:#157efb">Secteur d'activité</option>
                                    <?php
                                    foreach ($secteursActivites as $key=>$value ){
                                        echo '<option value="'.$key.'">'.$value.'</option>';
                                    }
                                    ?>
                                </select><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="passwordE" >Mot de passe<span style="color:red">*</span></label>
                                <input type="password" class="form-control" id="passwordE" name="passwordE"  placeholder="Mot de passe" ><br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="confirmpasswordE" >Confirmer le mot de passe<span style="color:red">*</span></label>
                                <input type="password" class="form-control" id="confirmpasswordE" name="confirmpasswordE"  placeholder="Confirmer le mot de passe" >
                            </div>
                            <div class="form-group col-md-12" style="margin-top: 15px">
                                <button class="btn btn-primary btn-block" id="btnE">Créer mon compte</button>
                            </div>
                        </form>
                        <hr class="bg-light">
                        <p style="font-family: 'sans forgetica';font-style: italic" class="text-center">Vous avez déja un compte?<a href="<?= App::url('login') ?>"> Se Connecter</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

