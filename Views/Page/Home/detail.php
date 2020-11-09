<?php

use Projet\Model\App;
use Projet\Model\DateParser;
use Projet\Model\FileHelper;
use Projet\Model\StringHelper;

$pays = StringHelper::$tabLesPays;
$categorie =StringHelper::$categorie;
?>
<section class="fto-section bg-white">
    <div class="container mt-4 mb-3">
        <div class="card">
            <div class="card-header text-center" style="background-color: #157efb;color:#fff">
                Detail de <?= $candidat->nom ?>
            </div>
            <div class="card-body" style="font-size: 18px;color:#000000">
                <div class="row">
                    <div class="col-md-9 ml-4">
                        <p class="card-text"><?= $candidat->nom.' '.$candidat->prenom ?></p>
                        <p class="card-text"><?php echo $candidat->situationMatrimonial==1?"Marié(e)":"Célibataire" ?></p>
                        <p class="card-text"><?php $date = $candidat->date; echo DateParser::calculAge($date); ?></p>
                        <p class="card-text"><?php  echo $candidat->sexe==1?'Masculin':'Féminin' ?></p>
                        <p class="card-text"><?php  foreach ($pays as $key=>$value){
                                if($candidat->pays == $key){ echo $value;}
                            } ?></p>
                        <p class="card-text"><?= 'Tel : '.$candidat->numero ?></p>
                        <p class="card-text"><?= 'E-mail : '.$candidat->email ?></p>
                    </div>
                    <div class="col-md-2 mt-5"><img src="<?= FileHelper::url($candidat->photo) ?>" class="img-fluid" style="max-height: 150px;max-width: 150px"></div>
                </div>
                <?php if(!empty($formations)){
                    echo '<h5 class="card-title text-center">FORMATION</h5> ' ;
                    echo '<hr style="border:#000000 solid 1px">';
                    echo '<div class="row">';
                    foreach ($formations as $formation) {
                        echo '<div class="col-md-11">';
                        echo '<ul>';
                        echo '<li><p class="card-text">' . strtoupper($formation->etablissement) . '</p></li>';
                        echo '<p class="card-text">' . $formation->annee.' : '.$formation->diplome.'</p>';
                        echo '</ul>';
                        echo '</div>';
                    }
                    echo '</div>';
                }else{}?>
                <?php if(!empty($experiences)){
                    echo ' <h5 class="card-title text-center">EXPERIENCE</h5>' ;
                    echo '<hr style="border:#000000 solid 1px">';
                    echo '<div class="row">';
                    foreach ($experiences as $experience) {
                        echo '<div class="col-md-11">';
                        echo '<p class="card-text">' . $experience->nomEntreprise. '</p>';
                        echo '<p class="card-text">' . $experience->dated.'</p>';
                        echo '<p class="card-text">' . $experience->datef.'</p>';
                        echo '<p class="card-text">' . $experience->description.'</p>';
                        echo '</div>';
                    }
                    echo '</div>';
                }else{}?>
                <?php if(!empty($competences)){
                    echo ' <h5 class="card-title text-center">COMPETENCES</h5>' ;
                    echo '<hr style="border:#000000 solid 1px">';
                    echo '<div class="row">';
                    foreach ($competences as $competence) {
                        echo '<div class="col-md-11">';
                        echo '<p class="card-text">' . $competence->nomCompetence. '</p>';
                        echo '<div class="progress"><div class="progress-bar bg-primary" role="progressbar" style="width: '.$competence->pourcentage.'%;" aria-valuenow="'.$competence->pourcentage.'" aria-valuemin="0" aria-valuemax="100">'.$competence->pourcentage.'%'.'</div></div><br>';
                        echo '</div>';
                    }
                    echo '</div>';
                }else{}?>
                <?php if(!empty($langues)){
                    echo ' <h5 class="card-title text-center">LANGUES</h5>' ;
                    echo '<hr style="border:#000000 solid 1px">';
                    echo '<div class="row">';
                    foreach ($langues as $langue) {
                        echo '<div class="col-md-11">';
                        echo '<p class="card-text">' . $langue->langue . '</p></li><br>';
                        echo '</div>';;
                    }
                    echo '</div>';
                    echo '</div>';
                }else{}?>
            </div>
            <?php
                if(!empty($postuler)){ ?>
                    <div class="card-footer bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                if(!empty($postuler->CNI)){ ?>
                                    <span class="col-md-12">
                                        <a href="<?= FileHelper::url($postuler->CNI) ?>" class="img-fluid btn btn-primary" style="max-height: 150px;max-width: 150px">Voir CNI <i class="fa fa-eye"></i></a>
                                    </span>
                                <?php }else{
                                }?>
                                <?php
                                if(!empty($postuler->lettreMotivation)){?>
                                    <span class="col-md-5">
                                        <a href="<?= FileHelper::url($postuler->lettreMotivation) ?>" class="img-fluid btn btn-primary" style="max-height: 150px;max-width: 150px">Lettre de Motivation <i class="fa fa-eye"></i></a>
                                    </span>
                                <?php  }else{

                                }?>
                                <?php
                                if(!empty($postuler->autre)){?>
                                    <span class="col-md-4">
                                        <a href="<?= FileHelper::url($postuler->autre) ?>" class="img-fluid btn btn-primary" style="max-height: 150px;max-width: 150px">Autre <i class="fa fa-eye"></i></a>
                                    </span>
                                <?php  }else{
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php }
            ?>
        </div>
    </div>
</section>

