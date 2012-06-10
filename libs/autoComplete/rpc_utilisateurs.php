<?php	
//	chdir ("../..");
//	include_once 'global/init.php';
//	include CHEMIN_MODELE.'utilisateur.php';

	// Is there a posted query string?
		if(isset($_POST['queryString'])) {
				$queryString = mysql_real_escape_string($_POST['queryString']);

	echo $queryString;
			// Is the string length greater than 0?
			if(strlen($queryString) >2) {
				// Run the query: We use LIKE '$queryString%'
				// The percentage sign is a wild-card, in my example of countries it works like this...
				// $queryString = 'Uni';
				// Returned data = 'United States, United Kindom';
				
				// YOU NEED TO ALTER THE QUERY TO MATCH YOUR DATABASE.
				// eg: SELECT yourColumnName FROM yourTable WHERE yourColumnName LIKE '$queryString%' LIMIT 10
				$query = lister_utilisateurs($queryString);
				if($query) {
					// While there are results loop through them - fetching an Object (i like PHP5 btw!).
					while ($result =  mysql_fetch_array(lister_utilisateurs($queryString))) {
						// Format the results, im using <li> for the list, you can change it.
						// The onClick function fills the textbox with the result.
						
						// YOU MUST CHANGE: $result->value to $result->your_colum
	         			echo '<li onClick="fill_2(\''.$result['login'].' ('.$result['prenom'].' '.$result['nom'].')\', \''.$result['login'].'\');">'.$result['nom'].' ('.$result['prenom'].')</li>';
	         		}
				} else {
					echo 'ERROR: There was a problem with the query.';
				}
			} else {
				// Dont do anything.
			} // There is a queryString.
		} else {
			echo 'There should be no direct access to this script!';
		}
?>
