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
    <title>Supprimer un locataire</title>
    <link href="inc/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" >
</head>
<body>
    <div class="container">
        <p>&nbsp;</p><p>&nbsp;</p>
            <?php
            $ID_locataire = intval($_POST['ID_locataire']);
            $query = "SELECT ID_locataire FROM $T_reserv WHERE ID_locataire='$ID_locataire'";
            $result = mysql_query($query);

            // si le locataire est rattaché à une réservation 
            if (mysql_num_rows($result) != 0) {
            // pour des raisons de cohérence,  il reste dans la base avec le nom de "supprimé"
                mysql_query("UPDATE $T_locataires SET nom_locataire='supprimé', prenom='locataire', rue='rue', codepostal='codepostal', ville='ville', pays='pays',tel='tel', tel_portable='portable', email='coucou@chezmoi.com', commentaires='', nbr_sejour='1', date_enreg_locataire='0000-00-00' WHERE ID_locataire=$ID_locataire") or die("erreur requète update locataire supprimé");
                echo "<div class = \"alert alert-success\"> <strong>Le locataire étant rattaché à une réservation, il n'a pas été supprimé définitivement mais se nomme maintenant \"Supprimé\"</strong>
                <p>&nbsp;</p> Vous allez être redirigé vers la liste des locataires</div>";
                echo "<meta http-equiv=\"refresh\" content=\"8;url=liste_locataires.php\">";
                } else {
                // le locataire n'est pas rattaché à une réservation on le supprime
                mysql_query("DELETE FROM $T_locataires WHERE ID_locataire=$ID_locataire") or die("erreur requete sup locataire");
                echo "<div class = \"alert alert-success\"><h4>Le locataire à été supprimé définitivement</h4>
                <p>&nbsp;</p> Vous allez être redirigé vers la liste des locataires</div>";
                echo "<meta http-equiv=\"refresh\" content=\"5;url=liste_locataires.php\">";
            }
            // on ferme la connexion
            mysql_close();
            ?>
        <p style ="text-align:center;">Si rien ne se passe cliquez ici : <a href="liste_locataires.php">Liste des locataires</a></p>
    </div>
</body>
</html>