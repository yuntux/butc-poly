<?php
//FIX ME : indiquer le nombre de polys commandés mais non retiré de manière distincte du stock courant total
echo '
<h1>Devenir du poly '.$_GET['code_poly'].'</h1>
<form name="ajouter_poly" action="index.php?module=enseignant&action=devenir_invendu&code_poly='.$_GET['code_poly'].'" method="post" autocomplete="off">
En fin de semestre, je souhaite que les polycopiés '.$_GET['code_poly'].' invendus (actuellement '.$detail_poly->stock_courant.' exemplaires sont concernés) soient 
<SELECT name="devenir_poly" >
<OPTION value="DESTRUCTION">détruits</OPTION>
<OPTION value="REVENTE">revendus au semestre suivant</OPTION>
</SELECT>.
<br>
	<input type="submit" name="valider" value="VALIDER" class="btn_valider">
';
?>
