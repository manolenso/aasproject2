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
    <title>Supprimer une r&eacute;servation</title><head>
    <meta http-equiv="refresh" content="3;url=liste_reserv.php">
    <link href="inc/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" >
</head>
<div class="container">
    <?php
    $ID_reserv = intval($_POST['ID_reserv']);

    if (!isset($_POST['sup_suivi'])) {
        // maj dans la table locataire. On décrémente le nombre de visite sauf si la suppression vient du suivi
        $req_ID_locataire = mysql_query("SELECT ID_locataire FROM $T_reserv WHERE ID_reserv='$ID_reserv'") or die("erreur cherche locataire");
        $ID_locataire = mysql_result($req_ID_locataire, 0);

        mysql_query("UPDATE $T_locataires SET nbr_sejour='nbr_sejour'-1  WHERE $ID_locataire='$ID_locataire'") or die($query . " - " . mysql_error());
    }
    // la requette de suppression de la réservation
    mysql_query("DELETE FROM $T_reserv WHERE ID_reserv='$ID_reserv'") or die("erreur requete sup reserv");

    // on ferme la connexion
    mysql_close();
    // on renvoi le visiteur


    echo "<p>&nbsp;</p><p>&nbsp;</p>
    <div class = \"alert alert-error\" style =\"text-align:center;\">
    <strong>La réservation à été supprimée</strong>
    <p>&nbsp;</p>
    Vous allez être redirigé vers la page des réservations</div>";
    ?>
    
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p style ="text-align:center;">Si rien ne se passe cliquez ici : <a href="liste_reserv.php">Liste des réservations</a></p>
</div>