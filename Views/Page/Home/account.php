<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 17/05/2019
 * Time: 23:41
 */

use Projet\Model\App;
use Projet\Database\Entreprise;
use Projet\Model\DateParser;
use Projet\Model\FileHelper;
use Projet\Model\StringHelper;
App::addScript('assets/js/page/editCv.js',true);
App::addScript('assets/js/page/postjob.js',true);
App::addScript('assets/js/page/deleteAccountEntreprise.js',true);
App::addScript('assets/js/page/updateParams.js',true);
$pays = StringHelper::$tabLesPays;
$user = App::getDBAuth()->user();
$categorie =StringHelper::$categorie;
$activites =StringHelper::$secteurActivite;
if(Entreprise::byEmail($user->email))
{
    $session->write('type','entreprise');
}else{
    $session->write('type','candidat');
}
?>
<?php
if(Entreprise::byEmail($user->email)){
    ?><div class="ftco-section bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <form action="<?= App::url('entreprise/postjob') ?>" class="p-5 bg-white search-job" id="formPost" method="post">
                        <input type="hidden" id="offre" name="offre">
                        <div class="row form-group">
                            <p class="ml-0">(<span style="color:red">*</span>) champs obligatoires</p>
                            <div class="col-md-12 mb-3 mb-md-0">
                                <label class="font-weight-bold" for="titre">Titre de l'emploi<span style="color:red">*</span></label><br>
                                <input type="text" id="titre" name="titre" class="form-control" placeholder="ex. Developpeur Full Stack"><br>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12 mb-3 mb-md-0">
                                <label class="font-weight-bold" for="categorie">Categorie<span style="color:red">*</span></label><br>
                                <select type="text" id="categorie" name="categorie" class="form-control">
                                    <option value="" selected>Catégorie</option>
                                    <?php
                                        foreach($categorie as $key=>$value)
                                        {
                                            echo '<option value="'.$key.'">'.$value.'</option>';
                                        }
                                    ?>
                                </select><br>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12 mb-3 mb-md-0">
                                <label class="font-weight-bold" for="salaire">Salaire Mensuel</label><br>
                                <input type="number" id="salaire" name="salaire" class="form-control" placeholder="ex. 300000"><br>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12 mb-3 mb-md-0">
                                <label class="font-weight-bold" for="titre">Lieu<span style="color:red">*</span></label><br>
                                <input type="text" id="lieu" name="lieu" class="form-control" placeholder="ex. Douala,Akwa"><br>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12 mb-3 mb-md-0">
                                <label class="font-weight-bold" for="ville">Ville<span style="color:red">*</span></label><br>
                                <input type="text" id="ville" name="ville" class="form-control"><br>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12 mb-3 mb-md-0">
                                <label class="font-weight-bold" for="delais">Date de délais<span style="color:red">*</span></label><br>
                                <input type="text" id="delais" name="delais" class="form-control"><br>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12 mb-3 mb-md-0">
                                <label class="font-weight-bold" for="domaine">Secteur d'activité<span style="color:red">*</span></label><br>
                                <select name="domaine" id="domaine" class="form-control">
                                    <option value="" selected></option>
                                    <?php
                                        foreach($activites as $key=>$value)
                                        {
                                            echo '<option value="'.$key.'">'.$value.'</option>';
                                        }
                                    ?>
                                </select><br>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12 mb-3 mb-md-0">
                                <label class="font-weight-bold" for="description">Description<span style="color:red">*</span></label><br>
                                <textarea id="description" name="description" class="form-control" cols="30" rows="10"></textarea><br>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <input type="submit" value="Poster" class="btn btn-primary  py-2 px-5" id="btnPost">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <div class="p-4 mb-3 bg-white" style="color:#000000">
                        <h3 class="h5 text-black mb-3">Profil Entreprise</h3>
                        <p class="mb-0 font-weight-bold">Nom Entreprise</p>
                        <p class="mb-4"><?= $user->nom ?></p>

                        <p class="mb-0 font-weight-bold">Télephone</p>
                        <p class="mb-4"><i class="fa fa-phone"></i><?= ' '.$user->numero ?></p>

                        <p class="mb-0 font-weight-bold">Address Email</p>
                        <p class="mb-0"><i class="fa fa-envelope"></i><a href="javascript:void(0)"><?= ' '.$user->email ?></a></p>

                        <p class="mb-0 font-weight-bold">Site Web</p>
                        <p class="mb-0"><i class=""></i><a href="<?= $user->siteweb ?>"><?= ' '.$user->siteweb ?></a></p>

                        <p class="mb-0 font-weight-bold">Location</p>
                        <p class="mb-0"><i class="fa fa-location-arrow"></i><?= ' '.$user->ville.','.$user->lieu ?></a></p>

                        <p class="mb-0 font-weight-bold">Logo</p>
                        <p class="mb-0"><img src="<?= FileHelper::url($user->logo) ?>" style="max-height: 80px;min-width: 80px"></p>
                        <hr style="color:#157EFB"></hr>
                        <a href="javascript:void(0)" data-id="<?= $user->id ?>" data-nom="<?= $user->nom ?>" data-numero="<?= $user->numero ?>" data-email="<?= $user->email ?>" data-lieu="<?= $user->lieu ?>" data-ville="<?= $user->ville ?>" data-site="<?= $user->siteweb ?>" data-adresse="<?= $user->adresse ?>" data-domaine="<?= $user->domaineactivite ?>" class="btn btn-primary">Editer mon profil</a>
                        <a href="javascript:void(0)" id="deleteEntreprise" class="btn btn-primary" data-id="<?= $user->id ?>" data-url="<?= App::url('delete/entreprise') ?>">Supprimer mon compte</a><br><br>
                        <a href="javascript:void(0)" id="updateParams" class="btn btn-primary">Modifier mes paramètres</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalParams" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content"  style="border-radius: 0">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalScrollableTitle">EDITER MES PARAMETRES</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= App::url('change/passwordE');?>" class="form-row" method="post" id="formParams">
                        <input type="hidden" id="id" name="id" value="<?= $user->id?>">
                        <div class="form-group col-md-12">
                            <label for="apassword">Ancien Mot de passe</label>
                            <input type="password" class="form-control" id="apassword" name="apassword">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="npassword" >Nouveau mot de passe</label>
                            <input type="password" class="form-control" id="npassword" name="npassword">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="cnpassword" >Confirmer le nouveau mot de passe</label>
                            <input type="password" class="form-control" id="cnpassword" name="cnpassword">
                        </div>
                        <div class="form-group col-md-12" style="margin-top: 15px">
                            <button class="btn btn-primary" id="btnU" data-id="<?= $user->id ?>" style="border-radius: 0px">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}else{
    ?><section class="fto-section bg-white">
                <div class="container mt-4 mb-3">
                    <div class="card">
                        <div class="card-header text-center" style="background-color: #157efb;color:#fff">
                        Mon Profil
                        </div>
                        <div class="card-body" style="font-size: 18px;color:#000000">
                            <div class="row">
                                <div class="col-md-9 ml-4">
                                    <p class="card-text"><?= $user->nom.' '.$user->prenom ?></p>
                                    <p class="card-text"><?php echo $user->situationMatrimonial==1?"Marié(e)":"Célibataire" ?></p>
                                    <p class="card-text"><?php $date = $user->date; echo DateParser::calculAge($date); ?></p>
                                    <p class="card-text"><?php  echo $user->sexe==1?'Masculin':'Féminin' ?></p>
                                    <p class="card-text"><?php  foreach ($pays as $key=>$value){
                                        if($user->pays == $key){ echo $value;}
                                        } ?></p>
                                    <p class="card-text"><?= 'Tel : '.$user->numero ?></p>
                                    <p class="card-text"><?= 'E-mail : '.$user->email ?></p>
                                </div>
                                <div class="col-md-2 mt-5"><img src="<?= FileHelper::url($user->photo) ?>" class="img-fluid" style="max-height: 150px;max-width: 150px"></i></div>
                            </div>
                            <?php if(!empty($formations)){
                                echo '<h5 class="card-title text-center">FORMATION</h5> ' ;
                                echo '<hr style="border:#157EFB solid 1px">';
                                echo '<div class="row">';
                                foreach ($formations as $formation) {
                                    echo '<div class="col-md-11">';
                                    echo '<ul>';
                                    echo '<li><p class="card-text">' . $formation->etablissement . '</p></li>';
                                    echo '<p class="card-text">' . $formation->annee.' : '.$formation->diplome.'</p>';
                                    echo '</ul>';
                                    echo '</div>';
                                    echo '<div class="col-md-1">
                                          <a id="editEtab" data-id="'.$formation->id.'" data-url="'.App::url('account/monCv/formation').'" data-etablissement="'.strtoupper($formation->etablissement).'" data-diplome="'.$formation->diplome.'" data-annee="'.$formation->annee.'"><i class="fa fa-edit" style="color:#157efb"></i></a>
                                          </div>';
                                }
                                echo '</div>';
                            }else{}?>
                            <?php if(!empty($experiences)){
                                echo ' <h5 class="card-title text-center">EXPERIENCE</h5>' ;
                                echo '<hr style="border:#157EFB solid 1px">';
                                echo '<div class="row">';
                                foreach ($experiences as $experience) {
                                    echo '<div class="col-md-11">';
                                    echo '<p class="card-text">' . $experience->nomEntreprise. '</p>';
                                    echo '<p class="card-text">' . $experience->dated.'</p>';
                                    echo '<p class="card-text">' . $experience->datef.'</p>';
                                    echo '<p class="card-text">' . $experience->description.'</p>';
                                    echo '</div>';
                                    echo '<div class="col-md-1">
                                          <a id="editExp" data-id="'.$experience->id.'" data-url="'.App::url('account/monCv/experience').'" data-nomentreprise="'.$experience->nomEntreprise.'" data-dated="'.$experience->dated.'" data-datef="'.$experience->datef.'" data-description="'.$experience->description.'"><i style="color:#157efb" class="fa fa-edit"></i></a>
                                          </div>';
                                }
                                echo '</div>';
                            }else{}?>
                            <?php if(!empty($competences)){
                                echo ' <h5 class="card-title text-center">COMPETENCE</h5>' ;
                                echo '<hr style="border:#157EFB solid 1px">';
                                echo '<div class="row">';
                                foreach ($competences as $competence) {
                                    echo '<div class="col-md-11">';
                                    echo '<p class="card-text">' . $competence->nomCompetence. '</p>';
                                    echo '<div class="progress"><div class="progress-bar bg-primary" role="progressbar" style="width: '.$competence->pourcentage.'%;" aria-valuenow="'.$competence->pourcentage.'" aria-valuemin="0" aria-valuemax="100">'.$competence->pourcentage.'%'.'</div></div><br>';
                                    echo '</div>';
                                    echo '<div class="col-md-1">
                                          <a id="editCmp" data-id="'.$competence->id.'" data-url="'.App::url('account/monCv/competence').'" data-competence="'.$competence->nomCompetence.'" data-pourcentage="'.$competence->pourcentage.'"><i class="fa fa-edit" style="color:#157efb"></i></a>
                                          </div>';
                                }
                                echo '</div>';
                            }else{}?>
                            <?php if(!empty($langues)){
                                echo ' <h5 class="card-title text-center">LANGUE</h5>' ;
                                echo '<hr style="border:#157EFB solid 1px">';
                                echo '<div class="row">';
                                foreach ($langues as $langue) {
                                    echo '<div class="col-md-11">';
                                    echo '<p class="card-text">' . $langue->langue . '</p></li><br>';
                                    echo '</div>';
                                    echo '<div class="col-md-1">
                                          <a id="editLang" data-id="'.$langue->id.'" data-url="'.App::url('account/monCv/langue').'" data-langue="'.$langue->langue.'"><i class="fa fa-edit" style="color:#157efb"></i></a>
                                          </div>';
                                }
                                echo '</div>';
                                echo '</div>';
                            }else{}?>
                        </div>
                    </div>
                 </div>
          </section>
<?php } ?>
<div class="modal fade" id="modalEtab" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"  style="border-radius: 0">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="modalEtab">MODIFIER MA FORMATION</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= App::url('account/monCv/formation')?>" method="post" id="addEtab">
                    <input type="hidden" id="idForm" name="idForm">
                    <div class="form-group col-md-12">
                        <label for="etablissement">Etablissement</label>
                        <input type="text" class="form-control" placeholder="Nom d'établissement" id="etablissement" name="etablissement">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="diplome">Diplôme</label>
                        <input type="text" class="form-control" placeholder="Diplôme" id="diplome" name="diplome">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="annee">Année</label>
                        <input type="text" class="form-control" placeholder="Année" id="annee" name="annee">
                    </div>
                    <div class="form-group col-md-4">
                        <button type="submit" class="btn btn-primary" style="border-radius:0" id="btnetap">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalCmp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"  style="border-radius: 0">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="modalCmp">MODIFIER MA COMPETENCE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= App::url('account/monCv/competence') ?>" method="post" class="search-job form-row cv" id="addCmp">
                    <input type="hidden" id="idCmp" name="idCmp">
                    <div class="form-group col-md-8">
                        <label for="nomcompetence">Compétence</label>
                        <input type="text" class="form-control" placeholder="Nom Compétence" id="nomcompetence" name="nomcompetence">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="pourcentage">Pourcentage</label>
                        <input type="number" class="form-control" id="pourcentage" name="pourcentage"><br>
                    </div>
                    <div class="form-group col-md-4">
                        <button type="submit" class="btn btn-primary" style="border-radius:0" id="btncmp">Modifier</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
<div class="modal fade" id="modalExp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"  style="border-radius: 0">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="modalExp">MODIFIER MON EXPERIENCE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= App::url('account/monCv/experience') ?>" method="post" class="search-job form-row cv" id="addExp">
                    <input type="hidden" id="idExp" name="idExp">
                    <div class="form-group col-md-12">
                        <label for="nomentreprise">Nom Entreprise</label>
                        <input type="text" class="form-control" placeholder="Nom Entreprise" id="nomentreprise" name="nomentreprise">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="dated">Date Début</label>
                        <input type="text" class="form-control date" placeholder="Date de début" required id="dated" name="dated">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="datef">Date Fin</label>
                        <input type="text" class="form-control date" placeholder="Date de fin" id="datef" name="datef">
                    </div>
                    <div class="form-group col-md-12">
                        <textarea id="description" class="form-control description" name="description"></textarea><br>
                    </div>
                    <div class="form-group col-md-4">
                        <button type="submit" class="btn btn-primary" style="border-radius:0" id="btnexp">Modifier</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
<div class="modal fade" id="modalLang" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"  style="border-radius: 0">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="modalLang">MODIFIER MA LANGUE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= App::url('account/monCv/langue') ?>" method="post" class="search-job form-row" id="addLang">
                    <input type="hidden" id="idLang" name="idLang">
                    <div class="form-group col-md-12">
                        <textarea id="descriptionl" class="form-control description" name="descriptionl"></textarea><br>
                    </div>
                    <div class="form-group col-md-4">
                        <button type="submit" class="btn btn-primary" style="border-radius:0" id="btnlang">Modifier</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>


