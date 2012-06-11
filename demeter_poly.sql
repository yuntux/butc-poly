-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Lun 11 Juin 2012 à 14:34
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
-- Structure de la table `demande_impression`
--

CREATE TABLE IF NOT EXISTS `demande_impression` (
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

CREATE TABLE IF NOT EXISTS `entete_commande` (
  `id` varchar(24) NOT NULL,
  `login_acheteur` varchar(8) NOT NULL,
  `login_vendeur` varchar(8) NOT NULL,
  `date_heure_commande` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `entete_commande`
--

INSERT INTO `entete_commande` (`id`, `login_acheteur`, `login_vendeur`, `date_heure_commande`) VALUES
('adumaine_11062012_115436', 'adumaine', 'adumaine', '2012-06-11 11:55:06'),
('adumaine_11062012_020824', 'adumaine', 'adumaine', '2012-06-11 02:08:32'),
('adumaine_11062012_020624', 'adumaine', 'adumaine', '2012-06-11 02:06:28'),
('', 'adumaine', 'adumaine', '2012-06-11 02:02:34'),
('adumaine_11062012_015957', 'adumaine', 'adumaine', '2012-06-11 02:02:22'),
('adumaine_10062012_185917', 'adumaine', 'adumaine', '2012-06-10 19:00:45');

-- --------------------------------------------------------

--
-- Structure de la table `entete_retrait`
--

CREATE TABLE IF NOT EXISTS `entete_retrait` (
  `id` varchar(24) NOT NULL,
  `login_acheteur` varchar(8) NOT NULL,
  `login_vendeur` varchar(8) NOT NULL,
  `date_heure_retrait` datetime NOT NULL,
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `ligne_commande`
--

INSERT INTO `ligne_commande` (`id`, `id_entete_commande`, `code_poly`, `quantite`) VALUES
(5, 'adumaine_11062012_015957', 'LB24C1P12', 1),
(3, 'adumaine_10062012_190206', 'LO21C1P12', 1),
(4, 'adumaine_10062012_190206', 'LB24C1P12', 2),
(6, 'adumaine_11062012_020624', 'LO21C1P12', 1),
(7, 'adumaine_11062012_020824', 'LO21C1P12', 1),
(8, 'adumaine_11062012_115436', 'LO21C1P12', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

CREATE TABLE IF NOT EXISTS `paiement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_commande` varchar(24) NOT NULL,
  `date_heure_paiement` datetime NOT NULL,
  `mode_paiement` enum('PAYBOX','MONEO','CHEQUE','CB') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `paiement`
--

INSERT INTO `paiement` (`id`, `reference_commande`, `date_heure_paiement`, `mode_paiement`) VALUES
(1, 'test', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Structure de la table `parametre`
--

CREATE TABLE IF NOT EXISTS `parametre` (
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

CREATE TABLE IF NOT EXISTS `poly` (
  `id` int(10) NOT NULL,
  `id_uv` int(10) NOT NULL,
  `code_barre` char(9) NOT NULL,
  `pdf` longblob NOT NULL,
  `type` enum('Cours','TD','TP') NOT NULL,
  `auteur` varchar(128) NOT NULL,
  `nb_pages` int(3) NOT NULL,
  `couleur_couverture` varchar(64) NOT NULL,
  `prix` double NOT NULL,
  `stock_courant` int(3) NOT NULL,
  `stock_alerte` int(3) NOT NULL,
  `rangement_lineaire` varchar(64) NOT NULL,
  `commentaire` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `poly`
--

INSERT INTO `poly` (`id`, `id_uv`, `code_barre`, `pdf`, `type`, `auteur`, `nb_pages`, `couleur_couverture`, `prix`, `stock_courant`, `stock_alerte`, `rangement_lineaire`, `commentaire`) VALUES
(1, 0, 'LO21C1P12', '', 'TP', '', 0, '', 3.85, 0, 0, '', ''),
(5, 0, 'LB24C1P12', '', 'Cours', '0', 0, '', 3.15, 0, 0, '', '');

-- --------------------------------------------------------

--
-- Structure de la table `rel_uv_branche`
--

CREATE TABLE IF NOT EXISTS `rel_uv_branche` (
  `uv` int(11) NOT NULL DEFAULT '0',
  `branche` enum('TC','GI','GP','GB','GM','GSM','GSU') NOT NULL DEFAULT 'TC',
  PRIMARY KEY (`uv`,`branche`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `rel_uv_branche`
--

INSERT INTO `rel_uv_branche` (`uv`, `branche`) VALUES
(0, 'GI');

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
  `formation_continue` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `login`, `num_badge`, `num_national`, `nom`, `prenom1`, `prenom2`, `prenom3`, `date_naissance`, `email`, `service`, `administrateur`, `vendeur`, `imprimeur`, `acheteur`, `formation_continue`) VALUES
(3, 'adumaine', 72648, 0, 'DUMAINE', 'Aurélien', '', '', '0000-00-00', 'aurelien.dumaine@etu.utc.fr', '', 1, 1, 1, 0, 0),
(1, 'ajouglet', 1, 1, 'JOUGLET', 'Antoine', '', '', '2012-05-01', 'antoine.jouglet@utc.fr', '', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `uv`
--

CREATE TABLE IF NOT EXISTS `uv` (
  `id` int(10) NOT NULL,
  `code` char(4) NOT NULL,
  `intitule` varchar(64) NOT NULL,
  `type` enum('CS','TM','TSH') NOT NULL,
  `id_responsable` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `uv`
--

INSERT INTO `uv` (`id`, `code`, `intitule`, `type`, `id_responsable`) VALUES
(0, 'LO21', 'POO', 'TM', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
