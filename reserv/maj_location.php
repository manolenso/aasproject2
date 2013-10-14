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
<html>
    <head>
        <meta http-equiv="refresh" content="2;url=liste_locations.php">
        <title>Modification d'une location</title>

        <link href="inc/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" >
    </head>
    <body>
        <div class="container">
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <?php
            $ID_location = intval($_POST['ID_location']);
            $nom_location = mysql_real_escape_string($_POST['nom_location']);
            $description = mysql_real_escape_string($_POST['description']);
// requète de modification
            mysql_query("UPDATE $T_locations SET nom_location='$nom_location', description ='$description'  WHERE ID_location=$ID_location") or die("erreur requète maj location");
// on ferme la connexion
            mysql_close();
            echo "<div class = \"alert alert-success\" style =\"text-align:center;\"> <p>&nbsp;</p><strong> La location a été modifié</strong><p>&nbsp;</p> Vous allez être redirigé vers la page locations<p>&nbsp;</p> </div>";
            ?>
            <p style ="text-align:center;">Si rien ne se passe cliquez ici : <a href="liste_locations.php">Liste des locations</a></p>
        </div> 
    </body>
</html>