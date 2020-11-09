-- --------------------------------------------------------
-- Hôte :                        localhost
-- Version du serveur:           5.7.19 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Export de la structure de la base pour offreemploi
CREATE DATABASE IF NOT EXISTS `offreemploi` /*!40100 DEFAULT CHARACTER SET latin7 */;
USE `offreemploi`;

-- Export de la structure de la table offreemploi. candidat
CREATE TABLE IF NOT EXISTS `candidat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `sexe` varchar(20) NOT NULL,
  `pays` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `domaineActivite` varchar(255) NOT NULL,
  `numero` varchar(255) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT 'assets/images/img.jpg',
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `situationMatrimonial` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin7;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table offreemploi. competence
CREATE TABLE IF NOT EXISTS `competence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomCompetence` varchar(50) NOT NULL,
  `pourcentage` int(11) NOT NULL,
  `idCandidat` int(11) NOT NULL,
  `isActive` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin7;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table offreemploi. email
CREATE TABLE IF NOT EXISTS `email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin7;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table offreemploi. entreprise
CREATE TABLE IF NOT EXISTS `entreprise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `numero` varchar(255) NOT NULL,
  `lieu` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT 'assets/images/img.jpg',
  `domaineactivite` varchar(255) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `siteweb` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `idcandidat` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin7;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table offreemploi. experience
CREATE TABLE IF NOT EXISTS `experience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomEntreprise` varchar(255) NOT NULL,
  `dated` date NOT NULL,
  `datef` date NOT NULL,
  `description` text NOT NULL,
  `idCandidat` int(11) NOT NULL,
  `isActive` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin7;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table offreemploi. formation
CREATE TABLE IF NOT EXISTS `formation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `diplome` varchar(255) NOT NULL,
  `etablissement` varchar(255) NOT NULL,
  `annee` varchar(255) NOT NULL,
  `idCandidat` int(11) NOT NULL,
  `isActive` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin7;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table offreemploi. langue
CREATE TABLE IF NOT EXISTS `langue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `langue` text NOT NULL,
  `idCandidat` int(11) NOT NULL,
  `isActive` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin7;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table offreemploi. message
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idOffre` int(11) NOT NULL,
  `idCandidat` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin7;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table offreemploi. offre
CREATE TABLE IF NOT EXISTS `offre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `categorie` varchar(50) NOT NULL DEFAULT '0',
  `delais` date NOT NULL,
  `lieu` varchar(255) NOT NULL,
  `salaire` int(11) NOT NULL DEFAULT '0',
  `ville` varchar(50) NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `idEntreprise` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin7;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table offreemploi. postuler
CREATE TABLE IF NOT EXISTS `postuler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idCandidat` int(11) NOT NULL,
  `nomC` varchar(50) NOT NULL,
  `idOffre` int(11) NOT NULL,
  `idEntreprise` int(11) NOT NULL,
  `titreO` varchar(50) NOT NULL,
  `CNI` varchar(255) DEFAULT NULL,
  `lettreMotivation` varchar(255) DEFAULT NULL,
  `autre` varchar(255) DEFAULT NULL,
  `isActive` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin7;

-- Les données exportées n'étaient pas sélectionnées.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
