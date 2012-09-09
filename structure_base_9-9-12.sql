-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Dim 09 Septembre 2012 à 21:53
-- Version du serveur: 5.1.61
-- Version de PHP: 5.3.10-2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
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
-- Structure de la table `entete_commande`
--

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


-- --------------------------------------------------------

--
-- Structure de la table `entete_impression`
--

CREATE TABLE IF NOT EXISTS `entete_impression` (
  `id` varchar(24) NOT NULL,
  `login_imprimeur` varchar(8) NOT NULL,
  `date_heure_impression` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Structure de la table `entete_retrait`
--

CREATE TABLE IF NOT EXISTS `entete_retrait` (
  `id` varchar(24) NOT NULL,
  `login_acheteur` varchar(8) NOT NULL,
  `login_vendeur` varchar(8) NOT NULL,
  `date_heure_retrait` datetime NOT NULL,
  `duree_retrait` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Structure de la table `ligne_commande`
--

CREATE TABLE IF NOT EXISTS `ligne_commande` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_entete_commande` varchar(24) NOT NULL,
  `code_poly` varchar(9) NOT NULL,
  `quantite` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;


-- --------------------------------------------------------

--
-- Structure de la table `ligne_impression`
--

CREATE TABLE IF NOT EXISTS `ligne_impression` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_entete_impression` varchar(24) NOT NULL,
  `code_poly` varchar(9) NOT NULL,
  `quantite` int(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_entete_impression` (`id_entete_impression`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Structure de la table `ligne_retrait`
--

CREATE TABLE IF NOT EXISTS `ligne_retrait` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_entete_retrait` varchar(24) NOT NULL,
  `code_poly` varchar(9) NOT NULL,
  `quantite` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Structure de la table `poly`
--

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

-- --------------------------------------------------------

--
-- Structure de la table `rel_uv_branche`
--

CREATE TABLE IF NOT EXISTS `rel_uv_branche` (
  `uv` int(11) NOT NULL DEFAULT '0',
  `branche` enum('TC','GI','GP','GB','GM','GSM','GSU') NOT NULL DEFAULT 'TC',
  PRIMARY KEY (`uv`,`branche`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

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

CREATE TABLE IF NOT EXISTS `uv` (
  `id` int(10) NOT NULL,
  `code` char(4) NOT NULL,
  `intitule` varchar(64) NOT NULL,
  `type` enum('CS','TM','TSH') NOT NULL,
  `id_responsable` char(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
