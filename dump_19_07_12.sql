-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Jeu 19 Juillet 2012 à 16:42
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
  `date_heure_paiement` datetime DEFAULT NULL,
  `mode_paiement` enum('PAYBOX','MONEO','CHEQUE','CB','INTERNE') NOT NULL,
  `proprietaire_moyen_paiement` varchar(255) NOT NULL,
  `references_moyen_paiement` varchar(255) NOT NULL,
  `url_retour_paybox` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `entete_commande`
--

INSERT INTO `entete_commande` (`id`, `login_acheteur`, `login_vendeur`, `date_heure_commande`, `date_heure_paiement`, `mode_paiement`, `proprietaire_moyen_paiement`, `references_moyen_paiement`, `url_retour_paybox`) VALUES
('adumaine_09072012_160623', 'adumaine', 'adumaine', '2012-07-09 16:06:43', NULL, 'PAYBOX', '', '', NULL),
('adumaine_21062012_143322', 'adumaine', 'adumaine', '2012-06-21 14:33:39', '2012-07-04 00:00:00', 'PAYBOX', '', '', NULL),
('adumaine_21062012_111640', 'adumaine', 'adumaine', '2012-06-21 11:17:03', '2012-07-11 00:00:00', 'PAYBOX', '', '', NULL),
('adumaine_16062012_212838', 'adumaine', 'adumaine', '2012-06-16 21:28:48', NULL, 'PAYBOX', '', '', NULL),
('adumaine_14062012_154651', 'adumaine', 'adumaine', '2012-06-14 15:47:02', NULL, 'PAYBOX', '', '', NULL),
('adumaine_11062012_115436', 'adumaine', 'adumaine', '2012-06-11 11:55:06', NULL, 'PAYBOX', '', '', NULL),
('adumaine_11062012_020824', 'adumaine', 'adumaine', '2012-06-11 02:08:32', NULL, 'PAYBOX', '', '', NULL),
('adumaine_11062012_020624', 'adumaine', 'adumaine', '2012-06-11 02:06:28', '2012-07-04 00:00:00', 'PAYBOX', '', '', NULL),
('adumaine_18072012_231739', 'adumaine', 'adumaine', '2012-07-18 23:17:47', '2012-07-18 23:17:47', 'INTERNE', '', '', NULL),
('adumaine_11062012_015957', 'adumaine', 'adumaine', '2012-06-11 02:02:22', NULL, 'PAYBOX', '', '', NULL),
('adumaine_10062012_185917', 'adumaine', 'adumaine', '2012-06-10 19:00:45', NULL, 'PAYBOX', '', '', NULL),
('adumaine_17072012_231310', 'adumaine', 'adumaine', '2012-07-17 23:14:06', '2012-07-17 23:14:06', 'INTERNE', '', '', NULL),
('adumaine_18072012_000745', 'adumaine', 'adumaine', '2012-07-18 00:07:50', '2012-07-18 00:07:50', 'CB', '', '', NULL),
('adumaine_18072012_000813', 'adumaine', 'adumaine', '2012-07-18 00:46:01', NULL, 'PAYBOX', '', '', NULL),
('adumaine_18072012_004818', 'adumaine', 'adumaine', '2012-07-18 00:48:28', '2012-07-18 00:48:28', 'MONEO', 'Aurélien DUMAINE', '', NULL);

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

--
-- Contenu de la table `entete_retrait`
--

INSERT INTO `entete_retrait` (`id`, `login_acheteur`, `login_vendeur`, `date_heure_retrait`) VALUES
('1', 'adumaine', 'adumaine', '2012-07-13 00:00:00'),
('adumaine_17072012_023113', 'adumaine', 'adumaine', '2012-07-17 02:31:13'),
('adumaine_17072012_231310', 'adumaine', 'adumaine', '2012-07-17 23:14:06'),
('adumaine_17072012_231739', 'adumaine', 'adumaine', '2012-07-17 23:17:47'),
('', 'adumaine', 'adumaine', '2012-07-18 00:03:48'),
('adumaine_18072012_000745', 'adumaine', 'adumaine', '2012-07-18 00:07:50'),
('adumaine_18072012_004818', 'adumaine', 'adumaine', '2012-07-18 00:48:28');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Contenu de la table `ligne_commande`
--

INSERT INTO `ligne_commande` (`id`, `id_entete_commande`, `code_poly`, `quantite`) VALUES
(5, 'adumaine_11062012_015957', 'LB24C1P12', 1),
(3, 'adumaine_10062012_190206', 'LO21C1P12', 1),
(4, 'adumaine_10062012_190206', 'LB24C1P12', 2),
(6, 'adumaine_11062012_020624', 'LO21C1P12', 1),
(7, 'adumaine_11062012_020824', 'LO21C1P12', 1),
(8, 'adumaine_11062012_115436', 'LO21C1P12', 1),
(9, 'adumaine_14062012_154651', 'LO21C1P12', 1),
(10, 'adumaine_16062012_212838', 'LO21C1P12', 2),
(11, 'adumaine_21062012_111640', 'LO21C1P12', 1),
(12, 'adumaine_21062012_143322', 'LO21C1P12', 3),
(13, 'adumaine_21062012_143322', 'LB24C1P12', 1),
(14, 'adumaine_09072012_160623', 'LO21C1P12', 1),
(15, 'adumaine_17072012_231310', 'LB24C1P12', 1),
(16, 'adumaine_17072012_231310', 'DIPLTOEIC', 1),
(17, 'adumaine_17072012_231739', 'DIPLTOEIC', 1),
(18, '', 'DIPLTOEIC', 1),
(19, 'adumaine_18072012_000745', 'DIPLTOEIC', 1),
(20, 'adumaine_18072012_000813', 'DIPLTOEIC', 8),
(21, 'adumaine_18072012_004818', 'DIPLTOEIC', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Contenu de la table `ligne_retrait`
--

INSERT INTO `ligne_retrait` (`id`, `id_entete_retrait`, `code_poly`, `quantite`) VALUES
(13, 'adumaine_17072012_231310', 'LB24C1P12', 1),
(1, '1', 'LO21C1P12', 1),
(12, 'adumaine_17072012_023113', 'LO21C1P12', 1),
(14, 'adumaine_17072012_231310', 'DIPLTOEIC', 1),
(15, 'adumaine_17072012_231739', 'DIPLTOEIC', 1),
(16, '', 'DIPLTOEIC', 1),
(17, 'adumaine_18072012_000745', 'DIPLTOEIC', 1),
(18, 'adumaine_18072012_004818', 'DIPLTOEIC', 1);

-- --------------------------------------------------------

--
-- Structure de la table `paiement_useless`
--

CREATE TABLE IF NOT EXISTS `paiement_useless` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_commande` varchar(24) NOT NULL,
  `date_heure_paiement` datetime NOT NULL,
  `mode_paiement` enum('PAYBOX','MONEO','CHEQUE','CB') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `paiement_useless`
--

INSERT INTO `paiement_useless` (`id`, `reference_commande`, `date_heure_paiement`, `mode_paiement`) VALUES
(1, 'adumaine_10062012_190206', '2012-07-05 00:00:00', 'PAYBOX');

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
  `designation` varchar(255) NOT NULL,
  `code_barre` char(9) NOT NULL,
  `sans_code_barre` tinyint(1) NOT NULL,
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

INSERT INTO `poly` (`id`, `id_uv`, `designation`, `code_barre`, `sans_code_barre`, `pdf`, `type`, `auteur`, `nb_pages`, `couleur_couverture`, `prix`, `stock_courant`, `stock_alerte`, `rangement_lineaire`, `commentaire`) VALUES
(1, 0, '', 'LO21C1P12', 0, '', 'TP', '', 0, '', 3.85, 0, 0, '', ''),
(5, 0, '', 'LB24C1P12', 0, '', 'Cours', '0', 0, '', 3.15, 0, 0, '', ''),
(2, 0, 'Diplôme TOEIC', 'DIPLTOEIC', 1, '', '', '', 0, '', 25, 0, 0, '', '');

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
  `regisseur` tinyint(1) NOT NULL,
  `enseignant` tinyint(1) NOT NULL,
  `formation_continue` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `login`, `num_badge`, `num_national`, `nom`, `prenom1`, `prenom2`, `prenom3`, `date_naissance`, `email`, `service`, `administrateur`, `vendeur`, `imprimeur`, `acheteur`, `regisseur`, `enseignant`, `formation_continue`) VALUES
(3, 'adumaine', 81640, 0, 'DUMAINE', 'Aurélien', '', '', '0000-00-00', 'aurelien.dumaine@etu.utc.fr', '', 1, 1, 1, 0, 0, 0, 1),
(1, 'ajouglet', 1, 1, 'JOUGLET', 'Antoine', '', '', '2012-05-01', 'antoine.jouglet@utc.fr', '', 0, 0, 0, 0, 0, 0, 0);

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
