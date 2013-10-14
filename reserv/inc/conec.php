<?php
// -----------------------------------------
// Source  :	http://cogites.com
// Script  :	E RESERV
// Version :	5
// revente et redistribution interdites
// Vous devez laisser le copyright.
// -----------------------------------------


// entrez les parametres profil de votre site
//$url = "http://localhost/public/assproject/index.html";
$url = "www.testproject.manolenso.fr/assproject2/index.html#";
// $url = "localhost/assproject/index.html#";
$site = "assert(assertion)";
$email_webmaster = "remylaurent89@gmail.com"; // utile en cas de perte du mot de passe

// entrer les parametres pour la connexion
//
// $dbUser = "root";
// $dbPass = "";
// $dbName = "e_reserv";
// $dbHote = "localhost";

$dbUser = "dbo459700541";
$dbPass = "ass-pass";
$dbName = "db459700541";
$dbHote = "db459700541.db.1and1.com";

// note sur les mots de passe.
// de pr?f?rence ils doivent ?tre compos?s:
// - de chiffres et de lettres
// - de minuscules et de majuscules ;
// - d'une longueur minimale de 8 ? 10 caract?res

// liste des tables

// ajouter un pr?fixe (exemple : $prefixe='ereserv_')
$prefixe='';

$T_admin = $prefixe."admin";
$T_reserv = $prefixe."reserv";
$T_locations = $prefixe."locations";
$T_locataires = $prefixe."locataires";

// tables pour le module de suivi
$T_contrats = $prefixe."contrats";
$T_loueur = $prefixe."loueur";

// table pour le module saisons
$T_saisons= $prefixe."saisons";


// en cas de difficult? => http://cogites.com/e_reserv/faq_reserv.php

//-----------------------------------------------------------------------------//
// !!! Ne rien changer sous cette ligne !!!

function stripslashes_r($var){// Fonction qui supprime l'effet des magic quotes
    if (is_array($var)) { // Si la variable pass?e en argument est un array, on appelle la fonction stripslashes_r dessus
       return array_map('stripslashes_r', $var);
    }
	else { // Sinon stripslashes
       return stripslashes($var);
    }
}

if (get_magic_quotes_gpc()) { // Si les magic quotes sont activ?s on les d?sactive
    $_GET = stripslashes_r($_GET);
    $_POST = stripslashes_r($_POST);
    $_COOKIE = stripslashes_r($_COOKIE);
}

// connexion et choix de la base
$connexion = mysql_connect($dbHote, $dbUser, $dbPass);
$mysql_select_db = mysql_select_db("$dbName");
// si la connexion ?choue
if (!$mysql_select_db)
    // afficher la ligne suivante
    echo "<b>Mauvaise configuration!!! </b><br>
	Vérifiez dans votre fichier conec.php que votre login et mot de passe sont bien saisi pour la connexion
	? la base <b>$dbName</b>";
?>
