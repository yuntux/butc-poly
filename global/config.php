<?php
////////////////////////////////////////////////////////////////////////////////
//
//    Ce fichier fait partie intégrante du Système de Gestion des Polycopiés
//    Copyright (C) 2012 - Aurélien DUMAINE (<wwwetu.utc.fr/~adumaine/>).
//
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU Affero General Public License as
//    published by the Free Software Foundation, either version 3 of the
//    License, or (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU Affero General Public License for more details.
//
//    You should have received a copy of the GNU Affero General Public License
//    along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
////////////////////////////////////////////////////////////////////////////////
?>
<?php

// Identifiants pour la base de données. Nécessaires a PDO2.
define('SQL_HOST', 'localhost');
define('SQL_USERNAME', 'demeter_poly');
define('SQL_PASSWORD', 'demeter_poly');
define('SQL_DATABASE', 'demeter_poly');

// Chemins à utiliser pour accéder aux vues/modeles/librairies
$module = empty($module) ? !empty($_GET['module']) ? $_GET['module'] : 'index' : $module;
define('CHEMIN_VUE',    'modules/'.$module.'/vue/');
define('CHEMIN_MODELE', 'modeles/');
define('CHEMIN_CONTROLEUR', 'modules/'.$module.'/controleur/');
define('CHEMIN_VUE_GLOBALE', 'vues_globales/');
define('CHEMIN_LIB',    'libs/');

//Paramètres du serveur CAS
define('SERVEUR_SSO', 'cas.utc.fr');
define('PORT_SSO', 443);
define('RACINE_SSO', 'cas');

//Définir environnement de démo
define('ENVIRONNEMENT_DEMO', 1);

//PARAMETRE POUR LES LECTEURS RFID
define('LONGUEUR_NUM_CARTE_ETU', '5');
define('LONGUEUR_CODE_POLY', '9');

//CONTACT BUTC
define('EMAIL_CONTACT_BUTC', 'butc@utc.fr');
define('VENDEUR_BUTC', 'Franck HETRUS - Poste 4094 ');

//Paramètres PAYBOX
//define('IP_SERVEUR_BUTC', '172.25.12.239');
define('IP_SERVEUR_BUTC', '80.67.175.138');
define('PBX_MODE', '13');
define('PBX_SITE', '1999888');
define('PBX_RANG', '99');
define('PBX_IDENTIFIANT', '2');
define('PBX_DEVISE', '978');
define('PBX_RETOUR', 'ref:R;trans:T;montant:M;auto:A;idtrans:S;sign:K');
define('PBX_REPONDRE_A', 'http://'.IP_SERVEUR_BUTC.'/cgi-bin/valider_paiement.php');
define('PBX_EFFECTUE', 'http://'.IP_SERVEUR_BUTC.'/code/modules/boutique_en_ligne/vue/paiement_effectue.html');
define('PBX_REFUSE', 'http://'.IP_SERVEUR_BUTC.'/code/modules/boutique_en_ligne/vue/paiement_refuse.html');
define('PBX_ANNULE', 'http://'.IP_SERVEUR_BUTC.'/code/modules/boutique_en_ligne/vue/paiement_annule.html');
define('FICHIERS_PAYBOX', 'fichiers_paybox/');
define('REPERTOIRE_SERVEUR', '/var/www/code/');

?>
