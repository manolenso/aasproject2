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
<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?" . ">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <title>Ajout d'une location</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    
       <!-- css génériques -->
            <link href="inc/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" >
            
            <meta http-equiv="refresh" content="2;url=liste_locations.php">
</head>
<body>
    <div class="container">
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <?php
        $nom_location = mysql_real_escape_string($_POST['nom_location']);
        $description = mysql_real_escape_string($_POST['description']);
    // requète d'insertion dans la table
        mysql_query("INSERT INTO $T_locations VALUES ('','$nom_location', '$description')") or die("erreur requète");
    // on ferme la connexion
        mysql_close();
        echo "<div class = \"alert alert-success\" style =\"text-align:center;\"> <p>&nbsp;</p><strong>La location à été ajoutée</strong><p>&nbsp;</p> Vous allez être redirigé vers la page de configuration<p>&nbsp;</p></div>";
        ?>
    <p style ="text-align:center;">Si rien ne se passe cliquez ici : <a href="liste_locations.php">Liste des locations</a></p>
    </div>
</body>
</html>





