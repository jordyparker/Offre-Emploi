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
App::addScript('assets/js/page/cv.js',true);
if(App::getDBAuth()->user())
{
    $user = $session->read('dbauth');
}
?>
<section class="ftco-section">
<div class="container">
    <p>
        <button class="btn btn-primary btn-block dropdown-toggle" style="border-radius:0" data-toggle="collapse" href="#cvetab" role="button" aria-expanded="false" aria-controls="cvetab">FORMATION ACADEMIQUE & PROFESSIONNELLE</button>
    </p>
    <div class="row">
        <div class="col">
            <div class="collapse multi-collapse" id="cvetab">
                <div class="card card-body" style="border-radius:0">
                    <form action="<?= App::url('account/monCv/formation') ?>" method="post" class="search-job form-row" id="addEtab">
                        <input type="hidden" id="idForm" name="idForm">
                        <input type="hidden" name="action" id="action" value="add">
                        <div class="form-group col-md-12">
                            <label for="etablissement">Etablissement</label>
                            <input type="text" class="form-control" placeholder="Nom d'établissement" id="etablissement" name="etablissement"><br>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="diplome">Diplôme</label>
                            <input type="text" class="form-control" placeholder="Diplôme" id="diplome" name="diplome"><br>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="annee">Année</label>
                            <input type="text" class="form-control" placeholder="Année" id="annee" name="annee"><br>
                        </div>
                        <div class="form-group col-md-4">
                            <button type="submit" class="btn btn-primary" style="border-radius:0" id="btnetab">Enrégistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <p>
        <button class="btn btn-primary btn-block dropdown-toggle" style="border-radius:0" data-toggle="collapse" href="#cvE" role="button" aria-expanded="false" aria-controls="cvE">EXPERIENCES PROFESSIONNELLES</button>
    </p>
    <div class="row">
        <div class="col">
            <div class="collapse multi-collapse" id="cvE">
                <div class="card card-body" style="border-radius:0">
                    <form action="<?= App::url('account/monCv/experience') ?>" method="post" class="search-job form-row cv" id="addExp">
                        <input type="hidden" id="idExp" name="idExp">
                        <input type="hidden" id="action" name="action" value="add">
                        <div class="form-group col-md-12">
                            <label for="nomentreprise">Nom Entreprise</label>
                            <input type="text" class="form-control" placeholder="Nom Entreprise" id="nomentreprise" name="nomentreprise"><br>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="dated">Date Début</label>
                            <input type="text" class="form-control date" placeholder="Date de début" required id="dated" name="dated"><br>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="datef">Date Fin</label>
                            <input type="text" class="form-control date" placeholder="Date de fin" id="datef" name="datef"><br>
                        </div>
                        <div class="form-group col-md-12">
                            <textarea id="description" class="form-control description" name="description"></textarea><br>
                        </div>
                        <div class="form-group col-md-4">
                            <button type="submit" class="btn btn-primary" style="border-radius:0" id="btnexp">Enrégistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <p>
        <button class="btn btn-primary btn-block dropdown-toggle" style="border-radius:0" data-toggle="collapse" href="#cvC" role="button" aria-expanded="false" aria-controls="cvC">COMPETENCES</button>
    </p>
    <div class="row">
        <div class="col">
            <div class="collapse multi-collapse" id="cvC">
                <div class="card card-body" style="border-radius:0">
                    <form action="<?= App::url('account/monCv/competence') ?>" method="post" class="search-job form-row cv" id="addCmp">
                        <input type="hidden" id="idCmp" name="idCmp">
                        <input type="hidden" name="action" id="action" value="add">
                        <div class="form-group col-md-8">
                            <label for="nomcompetence">Compétence</label>
                            <input type="text" class="form-control" placeholder="Nom Compétence" id="nomcompetence" name="nomcompetence"><br>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="pourcentage">Pourcentage</label>
                            <input type="number" class="form-control" id="pourcentage" name="pourcentage"><br>
                        </div>
                        <div class="form-group col-md-4">
                            <button type="submit" class="btn btn-primary" style="border-radius:0" id="btncmp">Enrégistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <p>
        <a class="btn btn-primary btn-block dropdown-toggle" style="border-radius:0" data-toggle="collapse" href="#cvlan" role="button" aria-expanded="false" aria-controls="cvlan">LANGUE</a>
    </p>
    <div class="row">
        <div class="col">
            <div class="collapse" id="cvlan">
                <div class="card card-body" style="border-radius:0">
                    <form action="<?= App::url('account/monCv/langue') ?>" method="post" class="search-job form-row" id="addLang">
                        <input type="hidden" id="idLang" name="idLang">
                        <input type="hidden" name="action" id="action" value="add">
                        <div class="form-group col-md-12">
                            <textarea id="descriptionl" name="descriptionl" class="form-control description"></textarea><br>
                        </div>
                        <div class="form-group col-md-4">
                            <button type="submit" class="btn btn-primary" style="border-radius:0" id="btnlang">Enrégistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>


