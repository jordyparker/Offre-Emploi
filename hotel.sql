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


-- Export de la structure de la base pour hotel
CREATE DATABASE IF NOT EXISTS `hotel` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `hotel`;

-- Export de la structure de la table hotel. bar
CREATE TABLE IF NOT EXISTS `bar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idService` int(11) NOT NULL DEFAULT '0',
  `idBoisson` int(11) NOT NULL DEFAULT '0',
  `intitule` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `etat` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table hotel. boisson
CREATE TABLE IF NOT EXISTS `boisson` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prix` float NOT NULL,
  `type` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `etat` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table hotel. categoriechambres
CREATE TABLE IF NOT EXISTS `categoriechambres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `etat` tinyint(4) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table hotel. chambre
CREATE TABLE IF NOT EXISTS `chambre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `intitule` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `prix` float NOT NULL,
  `nbrelit` int(11) NOT NULL,
  `nbretoilette` int(11) NOT NULL,
  `wifi` tinyint(4) DEFAULT '0',
  `balcon` tinyint(4) DEFAULT '0',
  `etat` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table hotel. client
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `numero` varchar(50) NOT NULL,
  `datenaiss` date DEFAULT NULL,
  `cni` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `etat` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table hotel. commentaire
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idParent` int(11) DEFAULT NULL,
  `nom` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `idNews` int(11) DEFAULT NULL,
  `idRealisation` int(11) DEFAULT NULL,
  `isActive` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table hotel. configuration
CREATE TABLE IF NOT EXISTS `configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idChambre` int(11) DEFAULT NULL,
  `cout` float DEFAULT NULL,
  `nbreheure` int(11) NOT NULL,
  `etat` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table hotel. forfait
CREATE TABLE IF NOT EXISTS `forfait` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idChambre` int(11) DEFAULT NULL,
  `idService` int(11) DEFAULT NULL,
  `idVoiture` int(11) DEFAULT NULL,
  `idClient` int(11) DEFAULT NULL,
  `intitule` varchar(255) NOT NULL,
  `periode` varchar(255) NOT NULL,
  `avantage` varchar(255) NOT NULL,
  `reduction` varchar(255) NOT NULL,
  `etat` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table hotel. gestion
CREATE TABLE IF NOT EXISTS `gestion` (
  `date` date NOT NULL,
  `decharge` varchar(30) NOT NULL,
  `objet` varchar(45) NOT NULL,
  `type` varchar(255) NOT NULL,
  `model` varchar(30) NOT NULL,
  `S/N` varchar(30) NOT NULL,
  `Beneficiaire` varchar(255) NOT NULL,
  `Statut` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table hotel. image
CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idChambre` int(11) DEFAULT NULL,
  `idVoiture` int(11) DEFAULT NULL,
  `idBar` int(11) DEFAULT NULL,
  `idResto` int(11) DEFAULT NULL,
  `idLocal` int(11) DEFAULT NULL,
  `idClient` int(11) DEFAULT NULL,
  `path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table hotel. local
CREATE TABLE IF NOT EXISTS `local` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idClient` int(11) NOT NULL,
  `idService` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `etat` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table hotel. news
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `vues` int(11) NOT NULL DEFAULT '0',
  `liked` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table hotel. produit
CREATE TABLE IF NOT EXISTS `produit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `intitule` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `cout` int(11) DEFAULT NULL,
  `vues` int(11) NOT NULL DEFAULT '0',
  `etat` tinyint(2) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table hotel. promotion
CREATE TABLE IF NOT EXISTS `promotion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table hotel. resto
CREATE TABLE IF NOT EXISTS `resto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL DEFAULT '0',
  `type` varchar(255) DEFAULT NULL,
  `imageprincipale` varchar(255) NOT NULL,
  `prix` float NOT NULL DEFAULT '0',
  `etat` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table hotel. service
CREATE TABLE IF NOT EXISTS `service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table hotel. servicelouer
CREATE TABLE IF NOT EXISTS `servicelouer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idClient` int(11) NOT NULL,
  `idVoiture` int(11) NOT NULL,
  `idLocal` int(11) NOT NULL,
  `idChambre` int(11) NOT NULL,
  `idBar` int(11) NOT NULL,
  `idResto` int(11) NOT NULL,
  `intitule` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `etat` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table hotel. suggestion
CREATE TABLE IF NOT EXISTS `suggestion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `numero` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sujet` varchar(80) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table hotel. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `numero` varchar(255) NOT NULL,
  `login` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `sexe` varchar(255) NOT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `dateNaissance` date DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `roles` varchar(80) NOT NULL DEFAULT 'ROLE_ADMIN',
  `photo` varchar(255) NOT NULL DEFAULT 'assets/img/icon.png',
  `etat` tinyint(2) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table hotel. visite
CREATE TABLE IF NOT EXISTS `visite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `device` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.
-- Export de la structure de la table hotel. voiture
CREATE TABLE IF NOT EXISTS `voiture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idService` int(11) NOT NULL DEFAULT '0',
  `nom` varchar(255) NOT NULL DEFAULT '0',
  `type` varchar(255) DEFAULT NULL,
  `imageprincipale` varchar(255) DEFAULT NULL,
  `prix` float NOT NULL,
  `nbre` int(11) NOT NULL DEFAULT '0',
  `etat` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
