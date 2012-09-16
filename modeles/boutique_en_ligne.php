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
function lister_poly($branche="", $type=""){
	global $connexion;
	if (($branche != "") && ($type != ""))
		$resultats=$connexion->query("SELECT * FROM uv, poly, rel_uv_branche WHERE (poly.id_uv=uv.id AND rel_uv_branche.uv=uv.id AND rel_uv_branche.branche=".$connexion->quote($branche, PDO::PARAM_STR)."AND uv.type LIKE ".$connexion->quote($type, PDO::PARAM_STR).")") or die(print_r($connexion->errorInfo()));
/*else {
		if ($type != "") {
		$resultats=$connexion->query("SELECT * FROM uv, poly, rel_uv_branche WHERE (poly.id_uv=uv.id AND rel_uv_branche.uv=uv.id AND branche LIKE ".$connexion->quote($branche, PDO::PARAM_STR).")") or die(print_r($connexion->errorInfo()));
	} */
	if (($branche == "") && ($type == ""))
		$resultats=$connexion->query("
		SELECT *, (qte_commandee-qte_retiree) AS reste_a_retirer
		FROM poly
				LEFT OUTER JOIN uv ON uv.code=poly.id_uv
				LEFT OUTER JOIN utilisateur ON uv.id_responsable=utilisateur.login
				LEFT OUTER JOIN (SELECT lr.code_poly AS cpr, SUM(lr.quantite) AS qte_retiree
								FROM ligne_retrait lr
								GROUP BY cpr) AS retraits ON retraits.cpr=poly.code_barre
				LEFT OUTER JOIN (SELECT lc.code_poly AS cpc, SUM(lc.quantite) AS qte_commandee
								FROM ligne_commande lc
								GROUP BY cpc) AS commandes ON commandes.cpc=poly.code_barre
		") or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function lister_poly_boutique_etu(){
	global $connexion;
		$resultats=$connexion->query("
		SELECT *
		FROM poly
		WHERE dispo_commande_en_ligne=1
		ORDER BY code_barre
		") or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function modif_stock_poly($code_poly, $delta_stock){
	global $connexion;
	$resultats=$connexion->query("UPDATE poly SET stock_courant=stock_courant+(".$connexion->quote($delta_stock, PDO::PARAM_INT).") WHERE code_barre=".$connexion->quote($code_poly, PDO::PARAM_STR)) or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function lister_uv(){
	global $connexion;
	$resultats=$connexion->query("SELECT * FROM uv") or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function enregistrer_poly($id_uv, $code_barre, $type, $prix, $sans_code_barre, $dispo_commande_en_ligne){
	global $connexion;
	$resultats=$connexion->query("INSERT INTO poly(id_uv, code_barre, type, prix, sans_code_barre, dispo_commande_en_ligne) VALUES (".$connexion->quote($id_uv, PDO::PARAM_STR).",".$connexion->quote($code_barre, PDO::PARAM_STR).",".$connexion->quote($type, PDO::PARAM_STR).",".$connexion->quote($prix, PDO::PARAM_INT).",".$connexion->quote($sans_code_barre, PDO::PARAM_INT).",".$connexion->quote($dispo_commande_en_ligne, PDO::PARAM_INT).")") or die(print_r($connexion->errorInfo()));
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
	$resultats=$connexion->query("SELECT * FROM poly LEFT OUTER JOIN uv ON uv.code=poly.id_uv WHERE code_barre=".$connexion->quote($code, PDO::PARAM_STR)) or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function detailler_ligne_commande($code){
	global $connexion;
	$resultats=$connexion->query("SELECT * FROM ligne_commande INNER JOIN entete_commande ON entete_commande.id=ligne_commande.id_entete_commande WHERE code_poly=".$connexion->quote($code, PDO::PARAM_STR)) or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function detailler_ligne_retrait($code){
	global $connexion;
	$resultats=$connexion->query("SELECT * FROM ligne_retrait INNER JOIN entete_retrait ON entete_retrait.id=ligne_retrait.id_entete_retrait WHERE code_poly=".$connexion->quote($code, PDO::PARAM_STR)) or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function detailler_ligne_impression($code){
	global $connexion;
	$resultats=$connexion->query("SELECT * FROM ligne_impression INNER JOIN entete_impression ON entete_impression.id=ligne_impression.id_entete_impression WHERE code_poly=".$connexion->quote($code, PDO::PARAM_STR)) or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function enregistrer_devenir_poly($code_poly, $devenir_poly, $login){
	global $connexion;
	$resultats=$connexion->query("UPDATE poly SET date_heure_devenir= NOW(), devenir_fin_semestre=".$connexion->quote($devenir_poly, PDO::PARAM_STR)." , login_devenir=".$connexion->quote($login, PDO::PARAM_STR)." WHERE code_barre = ".$connexion->quote($code_poly, PDO::PARAM_STR)) or die(print_r($connexion->errorInfo()));
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

function enregistrer_entete_retrait($id, $login_acheteur, $login_vendeur, $duree_retrait){
	global $connexion;
	$resultats=$connexion->query("INSERT INTO entete_retrait(id, login_acheteur, login_vendeur, date_heure_retrait, duree_retrait) VALUES (".$connexion->quote($id, PDO::PARAM_STR).",".$connexion->quote($login_acheteur, PDO::PARAM_STR).",".$connexion->quote($login_vendeur, PDO::PARAM_STR).",NOW() ,".$connexion->quote($duree_retrait, PDO::PARAM_STR).")") or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function enregistrer_ligne_retrait($id_entete_retrait, $poly, $quantite){
	global $connexion;
	$resultats=$connexion->query("INSERT INTO ligne_retrait(id_entete_retrait, code_poly, quantite) VALUES (".$connexion->quote($id_entete_retrait, PDO::PARAM_STR).",".$connexion->quote($poly, PDO::PARAM_STR).",".$connexion->quote($quantite, PDO::PARAM_INT).")") or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function enregistrer_entete_impression($id, $login){
	global $connexion;
	$resultats=$connexion->query("INSERT INTO entete_impression(id, login_imprimeur, date_heure_impression) VALUES (".$connexion->quote($id, PDO::PARAM_STR).",".$connexion->quote($login, PDO::PARAM_STR).",NOW())") or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function enregistrer_ligne_impression($id_entete_impression, $poly, $quantite){
	global $connexion;
	$resultats=$connexion->query("INSERT INTO ligne_impression(id_entete_impression, code_poly, quantite) VALUES (".$connexion->quote($id_entete_impression, PDO::PARAM_STR).",".$connexion->quote($poly, PDO::PARAM_STR).",".$connexion->quote($quantite, PDO::PARAM_INT).")") or die(print_r($connexion->errorInfo()));
//FIX ME : remplacer ça par un trigger (pas de calcul de stock avec impressions-retraits car stock initial non nul => champ stock_courant)
	modif_stock_poly($poly, $quantite);
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function liste_retraits_possibles($login){
	global $connexion;
	$resultats=$connexion->query("
SELECT lc.code_poly AS codep, SUM(lc.quantite) AS qte_payee, retraits.qte_retiree, p.stock_courant
FROM entete_commande ec
		INNER JOIN ligne_commande lc ON ec.id=lc.id_entete_commande
		LEFT OUTER JOIN poly p ON p.code_barre=lc.code_poly
		LEFT OUTER JOIN (SELECT lr.code_poly AS cpr, SUM(lr.quantite) AS qte_retiree
						FROM 	entete_retrait er
						INNER JOIN ligne_retrait lr ON er.id=lr.id_entete_retrait
						WHERE er.login_acheteur=".$connexion->quote($login, PDO::PARAM_STR)."
						GROUP BY cpr) AS retraits ON retraits.cpr=lc.code_poly
WHERE ec.date_heure_paiement IS NOT NULL AND mode_paiement IS NOT NULL AND ec.login_acheteur=".$connexion->quote($login, PDO::PARAM_STR)."
GROUP BY codep") or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function liste_commandes($login){
	global $connexion;
	$resultats=$connexion->query("SELECT * FROM entete_commande WHERE login_acheteur=".$connexion->quote($login, PDO::PARAM_STR)) or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
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

function entete_commande($id){
	global $connexion;
	$resultats=$connexion->query("SELECT * FROM entete_commande WHERE id=".$connexion->quote($id, PDO::PARAM_STR)) or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function ligne_commande($id_commande){
	global $connexion;
	$resultats=$connexion->query("SELECT * FROM ligne_commande INNER JOIN poly ON code_poly=poly.code_barre WHERE id_entete_commande=".$connexion->quote($id_commande, PDO::PARAM_STR)) or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function liste_retraits($login="", $date=""){
	global $connexion;
	if ($login != "")
		$resultats=$connexion->query("SELECT * FROM entete_retrait WHERE login_acheteur=".$connexion->quote($login, PDO::PARAM_STR)) or die(print_r($connexion->errorInfo()));
	if ($date != "")
		$resultats=$connexion->query("
SELECT *
FROM entete_retrait
	INNER JOIN ligne_retrait ON ligne_retrait.id_entete_retrait=entete_retrait.id
	INNER JOIN poly ON code_poly=code_barre
WHERE DATE(date_heure_retrait)=".$connexion->quote($date, PDO::PARAM_STR)." GROUP BY code_poly") or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function ligne_retrait($id_retrait){
	global $connexion;
	$resultats=$connexion->query("SELECT * FROM ligne_retrait WHERE id_entete_retrait=".$connexion->quote($id_retrait, PDO::PARAM_STR)) or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function liste_impressions($date=""){
	global $connexion;
	$resultats=$connexion->query("SELECT * FROM entete_impression") or die(print_r($connexion->errorInfo()));
	if ($date != "")
		$resultats=$connexion->query("
			SELECT *
			FROM entete_impression
				INNER JOIN ligne_impression ON ligne_impression.id_entete_impression=entete_impression.id
				INNER JOIN poly ON code_poly=code_barre
			WHERE DATE(date_heure_impression)=".$connexion->quote($date, PDO::PARAM_STR)." GROUP BY code_poly") or die(print_r($connexion->errorInfo()));

	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function ligne_impression($id_impression){
	global $connexion;
	$resultats=$connexion->query("SELECT * FROM ligne_impression INNER JOIN poly ON code_poly=code_barre WHERE id_entete_impression=".$connexion->quote($id_impression, PDO::PARAM_STR)) or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function supprimer_impression($id_impression){
	global $connexion;
//FIX ME : DELETE ON CASCADE => COMME ÇA C'EST SUPER CRADE !
	$resultats=$connexion->query("DELETE FROM entete_impression WHERE id=".$connexion->quote($id_impression, PDO::PARAM_STR)) or die(print_r($connexion->errorInfo()));
//DÉCRÉMENTATION DU STOCK
	$resultats=$connexion->query("SELECT * FROM ligne_impression WHERE id_entete_impression=".$connexion->quote($id_impression, PDO::PARAM_STR)) or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	while($ligne = $resultats->fetch())
		modif_stock_poly($ligne->code_poly, -$ligne->quantite);
//SUPPRESSION DES LIGNES
	$resultats=$connexion->query("DELETE FROM ligne_impression WHERE id_entete_impression=".$connexion->quote($id_impression, PDO::PARAM_STR)) or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function liste_utilisateurs(){
	global $connexion;
	$resultats=$connexion->query("SELECT * FROM utilisateur WHERE acheteur=1") or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function utilisateur_formation_continue(){
	global $connexion;
	$resultats=$connexion->query("SELECT * FROM utilisateur WHERE formation_continue=1") or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function vente_interne_utilisateur($login=""){
	global $connexion;
$requete = "SELECT lc.code_poly AS codep, p.prix AS prix, SUM(lc.quantite) AS quantite FROM entete_commande ec 
INNER JOIN ligne_commande lc ON ec.id = lc.id_entete_commande 
INNER JOIN poly p ON p.code_barre = lc.code_poly 
WHERE ec.date_heure_paiement IS NOT NULL  AND ec.mode_paiement ='INTERNE'";

if ($login != "")
	$requete.=" AND ec.login_acheteur =".$connexion->quote($login, PDO::PARAM_STR);

$requete.=" GROUP BY codep";
	$resultats=$connexion->query($requete) or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function enregistrer_paiement($id_commande, $mode_paiement, $proprietaire_moyen_paiement, $references_moyen_paiement){
	global $connexion;
	$resultats=$connexion->query("UPDATE entete_commande SET date_heure_paiement= NOW(), mode_paiement=".$connexion->quote($mode_paiement, PDO::PARAM_STR)." , proprietaire_moyen_paiement=".$connexion->quote($proprietaire_moyen_paiement, PDO::PARAM_STR)." , references_moyen_paiement=".$connexion->quote($references_moyen_paiement, PDO::PARAM_STR)." WHERE id = ".$connexion->quote($id_commande, PDO::PARAM_INT)) or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function articles_sans_code_barre(){
	global $connexion;
	$resultats=$connexion->query("SELECT code_barre, designation FROM poly WHERE sans_code_barre=1") or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

?>
