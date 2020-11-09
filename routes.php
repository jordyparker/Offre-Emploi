<?php
/**
 * Created by PhpStorm.
 * User: jordy
 * Date: 09/05/2019
 * Time: 13:41
 */

return [
    ""=>'\Projet\Controller\Site\HomeController#index',
    "login"=>'\Projet\Controller\Page\AuthController#login',
    "register"=>'\Projet\Controller\Page\AuthController#register',
    "login/log"=>"\Projet\Controller\Site\HomeController#log",
    "login/reset"=>'\Projet\Controller\Site\HomeController#resetPassword',
    "logout"=>'\Projet\Controller\Site\HomeController#logout',

    "error"=>'\Projet\Controller\Error\HomeController#error',
    "account"=>'\Projet\Controller\Membre\AccountController#account',
    "emplois"=>'\Projet\Controller\Membre\PostjobController#index',
    "contact"=>'\Projet\Controller\Site\AboutController#contact',
    "account/profilCandidat"=>'\Projet\Controller\Membre\AccountController#updateCandidat',
    "account/profilEntreprise"=>'\Projet\Controller\Membre\AccountController#updateEntreprise',
    "account/monCv"=>'\Projet\Controller\Membre\AccountController#cv',
    "account/monCv/formation"=>'\Projet\Controller\Membre\FormationController#add',
    "account/monCv/experience"=>'\Projet\Controller\Membre\ExperienceController#add',
    "account/monCv/competence"=>'\Projet\Controller\Membre\CompetenceController#add',
    "account/monCv/langue"=>'\Projet\Controller\Membre\LangueController#add',
    "account/listeCandidature"=>'\Projet\Controller\Membre\PostulerController#index',
    "account/listeOffre"=>'\Projet\Controller\Membre\PostjobController#liste',
    "account/listeCandidature/detail"=>'\Projet\Controller\Membre\PostulerController#detail',
    "account/listeCandidature/message"=>'\Projet\Controller\Membre\PostulerController#message',
    "account/consulterCandidature"=>'\Projet\Controller\Membre\AccountController#consulter',
    "account/delete/candidature"=>'\Projet\Controller\Membre\AccountController#delete',
    "account/delete/candidatures"=>'\Projet\Controller\Membre\AccountController#deleteC',
    "account/delete/offre"=>'\Projet\Controller\Membre\AccountController#deleteO',
    "job/categorie"=>'\Projet\Controller\Membre\PostjobController#categorie',

    "register/entreprise"=>'\Projet\Controller\Membre\EntrepriseController#save',
    "register/candidate"=>'\Projet\Controller\Membre\CandidatController#save',
    "update/candidate"=>'\Projet\Controller\Membre\CandidatController#update',
    "change/passwordC"=>'\Projet\Controller\Membre\CandidatController#changePassword',
    "change/passwordE"=>'\Projet\Controller\Membre\EntrepriseController#changePassword',
    "delete/candidate"=>'\Projet\Controller\Membre\CandidatController#delete',
    "delete/entreprise"=>'\Projet\Controller\Membre\EntrepriseController#delete',
    "subscribe"=>'\Projet\Controller\Site\AboutController#subscribe',
    "postjob"=>'\Projet\Controller\Membre\PostjobController#postjob',
    "jobsingle"=>'\Projet\Controller\Membre\PostulerController#jobsingle',
    "jobsingle/post"=>'\Projet\Controller\Membre\PostulerController#add',
    "entreprise/postjob"=>'\Projet\Controller\Membre\PostjobController#save',
];