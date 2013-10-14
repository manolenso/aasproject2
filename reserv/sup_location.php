<?php
// -----------------------------------------
// Source  :	http://cogites.com
// Script  :	E RESERV
// Version :	5
// revente et redistribution interdites 
// Vous devez laisser le copyright.
// -----------------------------------------

session_start();
if (!isset($_SESSION["login_admin"]) || !$_SESSION["login_admin"] == true) {
    // si pas connecté on retourne à la page login  
    header('Location: session/login.php');
    exit;
}
// l'include avec les identifiants de connexion
include ("inc/conec.php");
?>
<head>
    <title>Supprimer une location et ses r&eacute;servations</title>
    <link href="inc/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" >
    <meta http-equiv="refresh" content="3;url=liste_locations.php#ad_loc">
</head>


<div class="container">
    <?php
    $ID_location = intval($_POST['ID_location']);
// sup la location
    mysql_query("DELETE FROM $T_locations WHERE ID_location=$ID_location") or die("erreur requete sup location");
// sup les réservations associées (les locataires ne sont pas supprimés)
    mysql_query("DELETE FROM $T_reserv WHERE ID_location=$ID_location") or die("erreur requete sup les reservations");
// on ferme la connexion
    mysql_close();
// on renvoi le visiteur
    echo "<p>&nbsp;</p><p>&nbsp;</p>
<div class = \"alert alert-error\" style =\"text-align:center;\">
<strong>La location ainsi que les réservations qui lui étaient associées ont été supprimées</strong>
<p>&nbsp;</p>
Vous allez être redirigé vers la page des locations</div>";
    ?>

    <p style ="text-align:center;">Si rien ne se passe cliquez ici : <a href="liste_locations.php">Liste des locations</a></p>
</div>