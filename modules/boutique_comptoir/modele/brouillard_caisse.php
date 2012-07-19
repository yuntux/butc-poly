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

function montant_commande($id_commande){
	global $connexion;
	$resultats=$connexion->query(
"SELECT ec.id AS id_commande, SUM(p.prix*lc.quantite) AS montant_commande
FROM entete_commande ec, ligne_commande lc
		INNER JOIN poly p ON p.code_barre=lc.code_poly
WHERE lc.id_entete_commande=ec.id AND ec.id= ".$connexion->quote($id_commande, PDO::PARAM_STR)) or die(print_r($connexion->errorInfo()));
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
