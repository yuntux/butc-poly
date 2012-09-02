<?php

if ((!isset($_SESSION['login'])) || (empty($_SESSION['login'])))  {

    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

} else {
	if(isset($_SESSION['vendeur']) && $_SESSION['vendeur']==1) {
			$id_pdf=$_SESSION['login'].date('dmY_His');
			$generation_pdf = fopen('modules/generation_pdf/controleur/'.$id_pdf, 'a');

			require_once('modules/boutique_en_ligne/modele/boutique_en_ligne.php');

			// Set some content to print
			$html = "Date : ".date("d/m/Y")."<BR>";

			if (isset($_GET['utilisateur'])){
				$vente_interne_utilisateur = vente_interne_utilisateur($_GET['utilisateur']);
				$detail_utilisateur = detailler_utilisateur("", $_GET['utilisateur'])->fetch();
				$html.='Étudiant : '.$detail_utilisateur->prenom1.' '.$detail_utilisateur->nom.'<br><br>';
			}else{
				$vente_interne_utilisateur = vente_interne_utilisateur();
			}

				$montant_commandes=0;
				$html.= '
				<TABLE cellspacing="0" cellpadding="1" border="1">
					<thead>
					<tr><TH>Code article</TH> <TH>Prix unitaire</TH> <TH>Quantité</TH> <TH>Total</TH> </tr>		
					</thead>
					<tbody>';
						while($l = $vente_interne_utilisateur->fetch()){
							$html.="<tr>";
							$html.="<td>".$l->codep."</td>";
							$html.="<td>".$l->prix."</td>";
							$html.="<td>".$l->quantite."</td>";
							$total_ligne = $l->prix*$l->quantite;
							$montant_commandes = $montant_commandes + $total_ligne;
							$html.="<td>".$total_ligne."</td>";
							$html.="</tr>";
						}
					$html.='</tbody><tfoot><tr><td colspan="3">TOTAL : </td><td>'.$montant_commandes.'</td></tr></tfoot>
				</TABLE>';

			fputs($generation_pdf, $html);

			fclose($generation_pdf);

			header('Location: modules/generation_pdf/controleur/generer_pdf.php?creator=&autor=BUTC'.$_SESSION['login'].'&title=Facture vente interne&subject=Formation continue&keywords=&entete1=BUTC - Facture interne&entete2=Formation continue&nom_fichier=facture_'.$_GET['utilisateur'].'&id_pdf='.$id_pdf);


	} else {
	        include CHEMIN_VUE_GLOBALE.'hacker.php';
	}
}
?>
