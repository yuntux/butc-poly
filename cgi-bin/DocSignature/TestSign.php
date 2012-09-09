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
<html>
<head>
<title>formulaire d'exemple/test de signature</title>
</head>
<body>

<?php

function LoadKey( $keyfile, $pub=true, $pass='' ) {         // chargement de la cl� (publique par d�faut)

    $fp = $filedata = $key = FALSE;                         // initialisation variables
    $fsize =  filesize( $keyfile );                         // taille du fichier
    if( !$fsize ) return FALSE;                             // si erreur on quitte de suite
    $fp = fopen( $keyfile, 'r' );                           // ouverture fichier
    if( !$fp ) return FALSE;                                // si erreur ouverture on quitte
    $filedata = fread( $fp, $fsize );                       // lecture contenu fichier
    fclose( $fp );                                          // fermeture fichier
    if( !$filedata ) return FALSE;                          // si erreur lecture, on quitte
    if( $pub )
        $key = openssl_pkey_get_public( $filedata );        // recuperation de la cle publique
    else                                                    // ou recuperation de la cle privee
        $key = openssl_pkey_get_private( array( $filedata, $pass ));
    return $key;                                            // renvoi cle ( ou erreur )
}

// comme precise la documentation Paybox, la signature doit �tre
// obligatoirement en derni�re position pour que cela fonctionne

function GetSignedData( $qrystr, &$data, &$sig, $url ) {    // renvoi les donnes signees et la signature

    $pos = strrpos( $qrystr, '&' );                         // cherche dernier separateur
    $data = substr( $qrystr, 0, $pos );                     // et voila les donnees signees
    $pos= strpos( $qrystr, '=', $pos ) + 1;                 // cherche debut valeur signature
    $sig = substr( $qrystr, $pos );                         // et voila la signature
    if( $url ) $sig = urldecode( $sig );                    // decodage signature url
    $sig = base64_decode( $sig );                           // decodage signature base 64
}

// $querystring = chaine enti�re retourn�e par Paybox lors du retour au site (m�thode GET)
// $keyfile = chemin d'acc�s complet au fichier de la cl� publique Paybox

function PbxVerSign( $qrystr, $keyfile, $url ) {            // verification signature Paybox

    $key = LoadKey( $keyfile );                             // chargement de la cle
    if( !$key ) return -1;                                  // si erreur chargement cle
//  penser � openssl_error_string() pour diagnostic openssl si erreur
    GetSignedData( $qrystr, $data, $sig, $url );            // separation et recuperation signature et donnees
while ($msg = openssl_error_string()) echo $msg . "<br />\n";
    return openssl_verify( $data, $sig, $key );             // verification : 1 si valide, 0 si invalide, -1 si erreur
}


if( !isset( $_POST['data'] ))                               // pour alimentation par defaut quand premier affichage du formulaire
    $_POST['data'] = 'arg1=aaaa&arg2=bbbb&arg3=cccc&arg4=dddd';

if( isset( $_POST['signer']) ) {                            // si on a demande la signature

    $key = LoadKey( 'test.pub.pem', false );            // chargement de la cle prive (de test, sans mot de passe)
    if( $key ) {
        openssl_sign( $_POST['data'], $signature, $key );   // generation de la signature
        openssl_free_key( $key );                           // liberation ressource (confidentialite cle prive)
    }
    else $status = openssl_error_string();                  // diagnostic erreur

    $_POST['signeddata'] = $_POST['data'];                  // construction chaine data + signature
    $_POST['signeddata'] .= '&sig=';
    if( isset( $_POST['urlenc'] ))
        $_POST['signeddata'] .= urlencode( base64_encode( $signature ));
    else
        $_POST['signeddata'] .= base64_encode( $signature );
}
if( isset( $_POST['verifier']) ) {                          // si on a demande la verification

    $CheckSig = PbxVerSign( $_POST['signeddata'], 'TestK004.pub.pem', $_POST['urlenc'] );

    if( $CheckSig == 1 )       $status = "Signature valide";
    else if( $CheckSig == 0 )  $status = "Signature invalide : donnees alterees ou signature falsifiee";
    else                       $status = "Erreur lors de la v�rification de la signature";
}

?>
    <form action="TestSign.php" method="POST">
    <table border="0" cellpadding="3" cellspacing="0" align="center">
    <tr>
      <td>status = <?= $status ?></td>
    </tr>
    <tr>
      <td><input type="text" name="data" size="80" value="<?php echo $_POST['data'] ?>"></td>
      <td><input type="submit" name="signer" value="signer"/></td>
    </tr>
    <tr>
      <td><input type="checkbox" name="urlenc" <?php if( $_POST['urlenc'] ) echo 'checked'; ?> >encodage URL</td>
      <td></td>
    </tr>
    <tr>
      <td><input type="text" name="signeddata" size="80" value="<?php echo $_POST['signeddata'] ?>"></td>
      <td><input type="submit" name="verifier" value="verifier"/></td>
    </tr>
    </table>
    </form>
</body>
</html>
