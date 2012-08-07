<?php

echo '<h2>Liste des utilisateurs en formation continue (elligibles à la vente interne)</h2>
<TABLE>
    <THEAD>
        <TR><TH>Utilisateur</TH> <TH>Action</TH></TR>
    </THEAD>
    <TBODY>';

        while($ligne = $utilisateur_formation_continue->fetch()){
			echo "<tr>";
            echo "<td>".$ligne->nom.' '.$ligne->prenom1."</td>";
            echo '<td><a href="modules/boutique_comptoir/controleur/facture_formation_continue.php?utilisateur='.$ligne->login.'">Facture</a></td>';
            echo "</tr>";
            }
    echo '</TBODY> 
</TABLE>';
echo '<br><a href="modules/boutique_comptoir/controleur/facture_formation_continue.php"Facture récapitulative</a>';
?>
