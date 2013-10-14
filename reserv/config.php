<?php
// -----------------------------------------
// Source  :	http://cogites.com
// Script  :	E RESERV
// Version :	5
// revente et redistribution interdites
// Vous devez laisser le copyright.
// -----------------------------------------
session_start() ;
if (!isset($_SESSION["login_admin"]) || !$_SESSION["login_admin"] == true){
   // si pas connect? on retourne ? la page login
    header('Location: session/login.php');
   exit;
}
// l'include avec les identifiants de connexion
include ("inc/conec.php");
?>
<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>Configuration E'reserv</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <!-- css g?n?riques -->
            <link href="inc/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" >
            <link href="style_reserv.css" rel="stylesheet" type="text/css" >

            <!-- js boostrap et j query -->
            <script  src="inc/bootstrap/jquery.min.js" type="text/javascript"></script>
            <script  src="inc/bootstrap/js/bootstrap.js" type="text/javascript"></script>


            <!-- js sp?cifique (date etc.) -->
            <script src="inc/fonc.js" type="text/javascript"></script>
</head>
<body>
<?php
include ("inc/chemin.php");
include ('inc/menu_reserv.php'); ?>
    <div class="container">
        <h2 class="titre" >Configuration E'reserv</h2>
        <h4> <img src="img/config.png" width="48" height="48" />&nbsp;Voici
            les &eacute;l&eacute;ments de configuration que vous avez entr&eacute;
        dans le fichier conec.php</h4>

        <p>pour modifier ces informations, &eacute;ditez
            le fichier conec.php et r&eacute;-envoyez le sur votre
        espace web.</p>

        <p><strong>Param&egrave;tres profil du site : </strong></p>

        <?php
        // les param?tres profil
        echo "<b>url :</b> $url <br/><br/>";
        echo "<b>site : </b>$site <br/><br/>";
        echo "<b>email admin :</b> $email_webmaster <br/><br/>";
        ?>

        <small>En cas de perte de votre mot de passe un nouveau mot de passe sera
            g&eacute;n&eacute;r&eacute; et envoy&eacute; &agrave; l'email ci-dessus. </small>
        <hr />

        <?php
        echo "<b>Votre login de connection est : </b> $_SESSION[login_admin]<br/>";
        ?>
        <p>Si vous souhaitez <a href="session/maj_login.php">modifier vos
        login et / ou mot de passe</a></p>


        <?php
        //on v?rifie que le mot de passe n'est plus admin
        $req_passe = mysql_query("SELECT pass_admin FROM $T_admin");
        $passe_md5 = mysql_result($req_passe, 0);
        if ($passe_md5 == '21232f297a57a5a743894a0e4a801fc3') {
            echo "<div class = \"alert alert-error\">Votre mot de passe est toujours : <strong>\"admin\"</strong>. Nous vous conseillons de le changer.</div>";
        }
        ?>


        <?php
        include ("inc/copy.php");
        ?>

    </div> <!--   fin de div container-->
</body>
</html>
