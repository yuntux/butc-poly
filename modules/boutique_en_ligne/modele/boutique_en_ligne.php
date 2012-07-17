<?php
function lister_poly($branche="", $type=""){
	global $connexion;
	if ($branche != "") {
	$resultats=$connexion->query("SELECT * FROM uv, poly, rel_uv_branche WHERE (poly.id_uv=uv.id AND rel_uv_branche.uv=uv.id AND rel_uv_branche.branche=".$connexion->quote($branche, PDO::PARAM_STR)."AND uv.type LIKE ".$connexion->quote($type, PDO::PARAM_STR).")") or die(print_r($connexion->errorInfo()));
	} else {
	$resultats=$connexion->query("SELECT * FROM uv, poly, rel_uv_branche WHERE (poly.id_uv=uv.id AND rel_uv_branche.uv=uv.id AND branche='GI')") or die(print_r($connexion->errorInfo()));
	}
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function detailler_utilisateur($num_badge="", $login=""){
	global $connexion;
	if ($num_badge != "") {
	$resultats=$connexion->query("SELECT * FROM utilisateur WHERE num_badge=".$connexion->quote($num_badge, PDO::PARAM_STR)) or die(print_r($connexion->errorInfo()));
	} else {
	$resultats=$connexion->query("SELECT * FROM utilisateur WHERE login=".$connexion->quote($login, PDO::PARAM_STR)) or die(print_r($connexion->errorInfo()));
	}
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function detailler_poly($code){
	global $connexion;
	$resultats=$connexion->query("SELECT * FROM poly WHERE code_barre=".$connexion->quote($code, PDO::PARAM_STR)) or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function enregistrer_entete_commande($id, $login_acheteur, $login_vendeur){
	global $connexion;
	$resultats=$connexion->query("INSERT INTO entete_commande(id, login_acheteur, login_vendeur, date_heure_commande) VALUES (".$connexion->quote($id, PDO::PARAM_STR).",".$connexion->quote($login_acheteur, PDO::PARAM_STR).",".$connexion->quote($login_vendeur, PDO::PARAM_STR).",NOW())") or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function enregistrer_ligne_commande($id_entete_commande, $poly, $quantite){
	global $connexion;
	$resultats=$connexion->query("INSERT INTO ligne_commande(id_entete_commande, code_poly, quantite) VALUES (".$connexion->quote($id_entete_commande, PDO::PARAM_STR).",".$connexion->quote($poly, PDO::PARAM_STR).",".$connexion->quote($quantite, PDO::PARAM_INT).")") or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function enregistrer_entete_retrait($id, $login_acheteur, $login_vendeur){
	global $connexion;
	$resultats=$connexion->query("INSERT INTO entete_retrait(id, login_acheteur, login_vendeur, date_heure_retrait) VALUES (".$connexion->quote($id, PDO::PARAM_STR).",".$connexion->quote($login_acheteur, PDO::PARAM_STR).",".$connexion->quote($login_vendeur, PDO::PARAM_STR).",NOW())") or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function enregistrer_ligne_retrait($id_entete_retrait, $poly, $quantite){
	global $connexion;
	$resultats=$connexion->query("INSERT INTO ligne_retrait(id_entete_retrait, code_poly, quantite) VALUES (".$connexion->quote($id_entete_retrait, PDO::PARAM_STR).",".$connexion->quote($poly, PDO::PARAM_STR).",".$connexion->quote($quantite, PDO::PARAM_INT).")") or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function liste_retraits_possibles($login){
	global $connexion;
	$resultats=$connexion->query("
SELECT lc.code_poly AS codep, SUM(lc.quantite) AS qte_payee, retraits.qte_retiree
FROM entete_commande ec
		INNER JOIN ligne_commande lc ON ec.id=lc.id_entete_commande
		LEFT OUTER JOIN (SELECT lr.code_poly AS cpr, SUM(lr.quantite) AS qte_retiree
						FROM 	entete_retrait er
						INNER JOIN ligne_retrait lr ON er.id=lr.id_entete_retrait
						WHERE er.login_acheteur=".$connexion->quote($login, PDO::PARAM_STR)."
						GROUP BY cpr) AS retraits ON retraits.cpr=lc.code_poly
WHERE ec.date_heure_paiement IS NOT NULL AND ec.login_acheteur=".$connexion->quote($login, PDO::PARAM_STR)."
GROUP BY codep") or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function enregistrer_paiement($id_commande, $mode_paiement){
	global $connexion;
	$resultats=$connexion->query("UPDATE entete_commande SET date_heure_paiement= NOW(), mode_paiement=".$connexion->quote($mode_paiement, PDO::PARAM_STR)." WHERE id = ".$connexion->quote($id_commande, PDO::PARAM_INT)) or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

/*
function liste_poly_commandes_payees($login){
	global $connexion;
	$resultats=$connexion->query("SELECT lc.code_poly FROM paiement p, ligne_retrait lc WHERE p.reference_commande=ec.id AND p.mode_paiement != '' AND ec.login_acheteur=".$connexion->quote($login, PDO::PARAM_INT)." AND lc.code_barre_poly =".$connexion->quote($code_poly, PDO::PARAM_STR)." AND lc.id_entete_commande=ec.id GROUP BY lc.code_poly") or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	$resultats = $resultat->fetch();
	return $resultats->lc.quantite;
}

function nb_exemplaires_commandes_payees($login, $poly){
	global $connexion;
//SELECT SUM(lc.quantite), lc.code_poly, ec.login_acheteur, lc.id_entete_commande, ec.id FROM ligne_commande lc, entete_commande ec  WHERE ec.login_acheteur='adumaine'  AND lc.code_poly = 'LB24C1P12' AND lc.id_entete_commande=ec.id GROUP BY lc.code_poly
	$resultats=$connexion->query("SELECT SUM(lc.quantite), lc.code_poly, ec.login_acheteur, lc.id_entete_commande, ec.id, p.mode_paiement FROM paiement p, ligne_commande lc, entete_commande ec  WHERE ec.login_acheteur=".$connexion->quote($login, PDO::PARAM_INT)." AND lc.code_poly =".$connexion->quote($code_poly, PDO::PARAM_STR)." AND lc.id_entete_commande=ec.id  AND p.reference_commande=ec.id AND p.mode_paiement!=''GROUP BY lc.code_poly") or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	$resultats = $resultat->fetch();
	return $resultats->lc.quantite;
}

function nb_exemplaires_retires($login, $poly){
	global $connexion;
	$resultats=$connexion->query("SELECT SUM(lc.quantite), lc.code_poly, ec.login_acheteur, lc.id_entete_commande, ec.id FROM ligne_retrait lc, entete_retrait ec  WHERE ec.login_acheteur=".$connexion->quote($login, PDO::PARAM_INT)." AND lc.code_poly =".$connexion->quote($code_poly, PDO::PARAM_STR)." AND lc.id_entete_commande=ec.id GROUP BY lc.code_poly") or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	$resultats = $resultat->fetch();
	return $resultats->lc.quantite;
}
*/

function stock_poly($poly){
	return 1000;
}
?>
