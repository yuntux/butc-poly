<?php
$message_erreur = '';
function verifier_form($nom, $prenom, $telephone) {

	$valide =true;	
	global $message_erreur;

	if (empty($nom)) {
		 $message_erreur.="Veuillez saisir notre nom.<br>";
		 $valide =false;
	 }
	if (empty($prenom)) {
		 $message_erreur.="Veuillez saisir votre prenom.<br>";
		 $valide =false;
	 }
	if (!ereg("([0-9]){10}", $telephone)) {
		$message_erreur.="Le numéro de téléphone doit être composé exactement de dix chiffres.<br>";
		$valide =false;
	}

	return $valide;
}
?>
