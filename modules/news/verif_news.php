<?php
$message_erreur = '';
function verifier_news($titre, $date, $texte) {

	$valide =true;	
	global $message_erreur;

	if (empty($texte)) {
		 $message_erreur.="Vous devez saisir un texte dans le crops de la news.<br>";
		 $valide =false;
	 }
	if (empty($date)) {
		 $message_erreur.="Vous devez saisir la date de publication.<br>";
		 $valide =false;
	 }
	if (empty($titre)) {
		 $message_erreur.="Vous devez saisir un titre.<br>";
		 $valide =false;
	 }
    if (strlen($titre) > 20 ) {
        $message_erreur.="Le titre ne peut comporter plus de vingt caractères.<br>";
        $valide =false;
    }
		return $valide;
}
?>
