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

if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {

    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

} else {
	if(isset($_SESSION['imprimeur']) && $_SESSION['imprimeur']==1) {

		include_once 'modules/boutique_en_ligne/modele/boutique_en_ligne.php';
		include_once(CHEMIN_LIB.'fonctions-panier.php');


		if (isset($_POST['valider_impression'])) {
				$id_impression = $_SESSION['login'].'_'.date('dmY_His');
				$enregistrer_une_entete = false;
				foreach ($_POST as $cle=>$valeur)
				{
					if(substr($cle,0,10) == "code_poly_" && is_numeric($valeur) && (int)$valeur>0)
					{
						$enregistrer_une_entete = true;
//FIX ME : la vérification de l'existence du code poly en base est bien effectuée par la contrainte référentielle sur clé étrangère ? Quel message d'erreur compréhensible pour l'utilisateur ?
						enregistrer_ligne_impression($id_impression, strtoupper(substr($cle,10,LONGUEUR_CODE_POLY)), $valeur);
					}
				}
				if ($enregistrer_une_entete)
					enregistrer_entete_impression($id_impression, $_SESSION['login']);
				header('Location: index.php?module=imprimerie&action=liste_impression');
		} else {
			$liste_polys = lister_poly();
			include CHEMIN_VUE.'ajout_impression.php';
		}

	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}

}
?>
