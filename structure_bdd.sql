-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Jeu 16 Août 2012 à 16:27
-- Version du serveur: 5.1.61
-- Version de PHP: 5.3.10-2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT=0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `demeter_poly`
--

-- --------------------------------------------------------

--
-- Structure de la table `demande_impression_useless`
--
-- Création: Lun 28 Mai 2012 à 01:26
-- Dernière modification: Lun 28 Mai 2012 à 01:26
--

DROP TABLE IF EXISTS `demande_impression_useless`;
CREATE TABLE IF NOT EXISTS `demande_impression_useless` (
  `id` int(10) NOT NULL,
  `id_poly` int(10) NOT NULL,
  `quantite` int(3) NOT NULL,
  `date_heure_demande` datetime NOT NULL,
  `date_heure_impression` datetime NOT NULL,
  `date_heure_disponibilite` datetime NOT NULL,
  `priorite` int(2) NOT NULL,
  `commentaire` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `entete_commande`
--
-- Création: Dim 12 Août 2012 à 16:22
-- Dernière modification: Dim 12 Août 2012 à 16:22
--

DROP TABLE IF EXISTS `entete_commande`;
CREATE TABLE IF NOT EXISTS `entete_commande` (
  `id` varchar(24) NOT NULL,
  `login_acheteur` varchar(8) NOT NULL,
  `login_vendeur` varchar(8) NOT NULL,
  `date_heure_commande` datetime NOT NULL,
  `date_heure_paiement` datetime DEFAULT NULL,
  `mode_paiement` enum('PAYBOX','MONEO','CHEQUE','CB','INTERNE') NOT NULL,
  `proprietaire_moyen_paiement` varchar(255) NOT NULL,
  `references_moyen_paiement` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `entete_commande`:
--   `login_acheteur`
--       `utilisateur` -> `login`
--   `login_vendeur`
--       `utilisateur` -> `login`
--

-- --------------------------------------------------------

--
-- Structure de la table `entete_impression`
--
-- Création: Mar 07 Août 2012 à 01:19
-- Dernière modification: Ven 10 Août 2012 à 14:29
--

DROP TABLE IF EXISTS `entete_impression`;
CREATE TABLE IF NOT EXISTS `entete_impression` (
  `id` varchar(24) NOT NULL,
  `login_imprimeur` varchar(8) NOT NULL,
  `date_heure_impression` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `entete_impression`:
--   `login_imprimeur`
--       `utilisateur` -> `login`
--

-- --------------------------------------------------------

--
-- Structure de la table `entete_retrait`
--
-- Création: Jeu 09 Août 2012 à 17:35
-- Dernière modification: Ven 10 Août 2012 à 14:27
--

DROP TABLE IF EXISTS `entete_retrait`;
CREATE TABLE IF NOT EXISTS `entete_retrait` (
  `id` varchar(24) NOT NULL,
  `login_acheteur` varchar(8) NOT NULL,
  `login_vendeur` varchar(8) NOT NULL,
  `date_heure_retrait` datetime NOT NULL,
  `duree_retrait` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `entete_retrait`:
--   `login_acheteur`
--       `utilisateur` -> `login`
--   `login_vendeur`
--       `utilisateur` -> `login`
--

-- --------------------------------------------------------

--
-- Structure de la table `ligne_commande`
--
-- Création: Lun 16 Juillet 2012 à 09:22
-- Dernière modification: Jeu 09 Août 2012 à 18:29
-- Dernière vérification: Jeu 19 Juillet 2012 à 12:07
--

DROP TABLE IF EXISTS `ligne_commande`;
CREATE TABLE IF NOT EXISTS `ligne_commande` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_entete_commande` varchar(24) NOT NULL,
  `code_poly` varchar(9) NOT NULL,
  `quantite` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- RELATIONS POUR LA TABLE `ligne_commande`:
--   `code_poly`
--       `poly` -> `code_barre`
--   `id_entete_commande`
--       `entete_commande` -> `id`
--

-- --------------------------------------------------------

--
-- Structure de la table `ligne_impression`
--
-- Création: Mer 08 Août 2012 à 23:39
-- Dernière modification: Ven 10 Août 2012 à 14:29
--

DROP TABLE IF EXISTS `ligne_impression`;
CREATE TABLE IF NOT EXISTS `ligne_impression` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_entete_impression` varchar(24) NOT NULL,
  `code_poly` varchar(9) NOT NULL,
  `quantite` int(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_entete_impression` (`id_entete_impression`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- RELATIONS POUR LA TABLE `ligne_impression`:
--   `code_poly`
--       `poly` -> `code_barre`
--   `id_entete_impression`
--       `entete_impression` -> `id`
--

-- --------------------------------------------------------

--
-- Structure de la table `ligne_retrait`
--
-- Création: Dim 10 Juin 2012 à 17:34
-- Dernière modification: Ven 10 Août 2012 à 14:27
-- Dernière vérification: Jeu 19 Juillet 2012 à 12:07
--

DROP TABLE IF EXISTS `ligne_retrait`;
CREATE TABLE IF NOT EXISTS `ligne_retrait` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_entete_retrait` varchar(24) NOT NULL,
  `code_poly` varchar(9) NOT NULL,
  `quantite` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- RELATIONS POUR LA TABLE `ligne_retrait`:
--   `code_poly`
--       `poly` -> `code_barre`
--   `id_entete_retrait`
--       `entete_retrait` -> `id`
--

-- --------------------------------------------------------

--
-- Structure de la table `parametre_useless`
--
-- Création: Lun 28 Mai 2012 à 01:26
-- Dernière modification: Lun 28 Mai 2012 à 01:26
--

DROP TABLE IF EXISTS `parametre_useless`;
CREATE TABLE IF NOT EXISTS `parametre_useless` (
  `semestre` char(3) NOT NULL,
  `date_debut_semestre` date NOT NULL,
  `date_fin_semestre` date NOT NULL,
  `date_debut_demande_impression` datetime NOT NULL,
  `date_fin_demande_impression` datetime NOT NULL,
  `population_pouvant_precommander` varchar(128) NOT NULL,
  `date_debut_precommandes` datetime NOT NULL,
  `date_fin_precommandes` datetime NOT NULL,
  `horaires_boutique_complete` varchar(256) NOT NULL,
  `horaires_boutique_reservees_precommandes_prepayees` varchar(256) NOT NULL,
  `horaires_boutique_reservees_precommandes_impayees` varchar(256) NOT NULL,
  PRIMARY KEY (`semestre`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `poly`
--
-- Création: Jeu 16 Août 2012 à 14:10
-- Dernière modification: Jeu 16 Août 2012 à 14:11
--

DROP TABLE IF EXISTS `poly`;
CREATE TABLE IF NOT EXISTS `poly` (
  `id` int(10) NOT NULL,
  `id_uv` char(4) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `code_barre` char(9) NOT NULL,
  `sans_code_barre` tinyint(1) NOT NULL,
  `pdf` longblob NOT NULL,
  `type` enum('CM','TD','TP') NOT NULL,
  `auteur` varchar(128) NOT NULL,
  `nb_pages` int(3) NOT NULL,
  `couleur_couverture` varchar(64) NOT NULL,
  `prix` double NOT NULL,
  `stock_courant` int(3) NOT NULL,
  `stock_alerte` int(3) NOT NULL,
  `rangement_lineaire` varchar(64) NOT NULL,
  `commentaire` longtext NOT NULL,
  `dispo_commande_en_ligne` tinyint(1) NOT NULL,
  `devenir_fin_semestre` enum('DESTRUCTION','REVENTE') NOT NULL,
  `date_heure_devenir` datetime NOT NULL,
  `login_devenir` char(8) NOT NULL,
  PRIMARY KEY (`code_barre`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `poly`:
--   `login_devenir`
--       `utilisateur` -> `login`
--

-- --------------------------------------------------------

--
-- Structure de la table `rel_uv_branche`
--
-- Création: Lun 28 Mai 2012 à 01:32
-- Dernière modification: Dim 10 Juin 2012 à 00:41
--

DROP TABLE IF EXISTS `rel_uv_branche`;
CREATE TABLE IF NOT EXISTS `rel_uv_branche` (
  `uv` int(11) NOT NULL DEFAULT '0',
  `branche` enum('TC','GI','GP','GB','GM','GSM','GSU') NOT NULL DEFAULT 'TC',
  PRIMARY KEY (`uv`,`branche`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `rel_uv_branche`:
--   `uv`
--       `uv` -> `id`
--

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--
-- Création: Mer 08 Août 2012 à 22:58
-- Dernière modification: Lun 13 Août 2012 à 19:41
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(10) NOT NULL,
  `login` char(8) NOT NULL,
  `num_badge` int(11) NOT NULL,
  `num_national` int(16) NOT NULL,
  `nom` varchar(64) NOT NULL,
  `prenom1` varchar(64) NOT NULL,
  `prenom2` varchar(64) NOT NULL,
  `prenom3` varchar(64) NOT NULL,
  `date_naissance` date NOT NULL,
  `email` varchar(64) NOT NULL,
  `service` varchar(64) NOT NULL,
  `administrateur` tinyint(1) NOT NULL,
  `vendeur` tinyint(1) NOT NULL,
  `imprimeur` tinyint(1) NOT NULL,
  `acheteur` tinyint(1) NOT NULL,
  `regisseur` tinyint(1) NOT NULL,
  `enseignant` tinyint(1) NOT NULL,
  `formation_continue` tinyint(1) NOT NULL,
  PRIMARY KEY (`login`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `uv`
--
-- Création: Jeu 09 Août 2012 à 14:05
-- Dernière modification: Jeu 09 Août 2012 à 18:29
--

DROP TABLE IF EXISTS `uv`;
CREATE TABLE IF NOT EXISTS `uv` (
  `id` int(10) NOT NULL,
  `code` char(4) NOT NULL,
  `intitule` varchar(64) NOT NULL,
  `type` enum('CS','TM','TSH') NOT NULL,
  `id_responsable` char(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `uv`:
--   `id_responsable`
--       `utilisateur` -> `login`
--
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
