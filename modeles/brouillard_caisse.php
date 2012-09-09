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
function encaissements($date, $moyen_paiement){
	global $connexion;
	$resultats=$connexion->query("
SELECT COUNT(*) AS nb_paiements, SUM(paiement.montant_commande) AS total_paiements
FROM
	(SELECT  ec.id AS id_commande, SUM(p.prix*lc.quantite) AS montant_commande
	FROM entete_commande ec, ligne_commande lc
			INNER JOIN poly p ON p.code_barre=lc.code_poly
	WHERE lc.id_entete_commande=ec.id AND ec.mode_paiement=".$connexion->quote($moyen_paiement, PDO::PARAM_STR)." AND DATE(ec.date_heure_paiement)=".$connexion->quote($date, PDO::PARAM_STR)."
	GROUP BY ec.id) AS paiement
") or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats->fetch();
}

function liste_paiements($date, $moyen_paiement){
	global $connexion;
	$resultats=$connexion->query(
"SELECT  ec.id AS id_commande, SUM(p.prix*lc.quantite) AS montant_commande, ec.date_heure_commande, ec.proprietaire_moyen_paiement, ec.references_moyen_paiement AS ref
	FROM entete_commande ec, ligne_commande lc
			INNER JOIN poly p ON p.code_barre=lc.code_poly
	WHERE lc.id_entete_commande=ec.id AND ec.mode_paiement=".$connexion->quote($moyen_paiement, PDO::PARAM_STR)." AND DATE(ec.date_heure_paiement)=".$connexion->quote($date, PDO::PARAM_STR)."
	GROUP BY ec.id
") or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}
/*
SELECT * 
FROM  `entete_commande` 
WHERE DATE( date_heure_paiement ) =  "2012-07-18"


SELECT ec.id AS id_commande, SUM(p.prix*lc.quantite) AS montant_commande, ec.date_heure_paiement
FROM entete_commande ec, ligne_commande lc
		INNER JOIN poly p ON p.code_barre=lc.code_poly
WHERE lc.id_entete_commande=ec.id AND ec.mode_paiement='PAYBOX' AND DATE(ec.date_heure_paiement)='2012-07-04'
GROUP BY ec.id
*/
?>
