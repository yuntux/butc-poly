<?php
function duree_moyenne_achat_retrait_comptoir(){
	global $connexion;
	$resultats=$connexion->query("SELECT SUM(duree_retrait)/COUNT(*) AS moyenne_duree_retrait FROM entete_retrait
LEFT OUTER JOIN entete_commande ON entete_commande.id=entete_retrait.id WHERE entete_commande.id IS NOT NULL") or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}

function duree_moyenne_simple_retrait_comptoir(){
	global $connexion;
	$resultats=$connexion->query("SELECT SUM(duree_retrait)/COUNT(*) AS moyenne_duree_retrait FROM entete_retrait
LEFT OUTER JOIN entete_commande ON entete_commande.id=entete_retrait.id WHERE entete_commande.id IS NULL") or die(print_r($connexion->errorInfo()));
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	return $resultats;
}
?>
