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
   // si pas connecté on retourne à la page login  
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
<title>Fiche d'accueil</title>

            <!-- css génériques -->
            <link href="inc/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" >
            <link href="style_reserv.css" rel="stylesheet" type="text/css" >

            <!-- js boostrap et j query -->    
            <script  src="inc/bootstrap/jquery.min.js" type="text/javascript"></script>
            <script  src="inc/bootstrap/js/bootstrap.js" type="text/javascript"></script>
            
            
            <!-- js spécifique (date etc.) -->    
            <script src="inc/fonc.js" type="text/javascript"></script>

</head>
<body onload="window.print()">
    <?php
    include("inc/func.dates.php"); 
    if($_GET){
    $ID_reserv = $_GET['ID_reserv'];
    }

    $req = mysql_query("SELECT * FROM $T_reserv, $T_locations, $T_locataires WHERE ($T_locations.ID_location=$T_reserv.ID_location) AND ($T_locataires.ID_locataire=$T_reserv.ID_locataire) AND (nom_locataire !='supprimée') AND (ID_reserv = '$ID_reserv') ") or die ("erreur requête chch locataires");
    while ($val = mysql_fetch_array ($req)) {

    $datedeb = $val['datedeb'];
    $datefin = $val['datefin'];
    $datedeb = angl_fran("$datedeb");
    $datefin = angl_fran("$datefin");
    ?>
        <div class="container">
            <h2 class="titre" >Fiche d'accueil</h2>

            <div class="lead">
                <?php echo $val['nom_location']; ?> | <?php echo $datedeb; ?> au <?php echo $datefin; ?> | prix : <?php echo $val['prix']; ?>&euro;</div>   
                <strong><?php echo "$val[titre] $val[prenom] $val[nom_locataire]" ?> </strong>(<?php if (isset($val['nbr_sejour'])) {
                echo $val['nbr_sejour'];
            } ?> venue(s))<br/>
            <?php echo $val['rue']; ?><br/>
            <?php echo "$val[codepostal] $val[ville]"; ?><br/>
            (<?php echo $val['pays']; ?>)<br/>
        
            <strong><?php echo "$val[tel]"; ?> <br/>
            <?php echo "$val[tel_portable]"; ?></strong><br/>
            <?php echo "$val[email]"; ?> 
            <p><?php echo $val['nbr_adultes']; ?> adulte(s), <?php echo $val['nbr_enfants_2_13']; ?> enfant(s) entre 2 et 13 ans et <?php echo $val['nbr_enfants_inf_2']; ?> enfant(s) de moins de deux ans et personnes &agrave; mobilit&eacute; 
                r&eacute;duite (<?php if ($val['pmr'] != 1) {
                echo 'non';
            } else {
                echo 'oui';
            }; ?>). </p>
            <hr />
            <p>Commentaire r&eacute;servation : <?php echo $val['commentaire_reserv'];
             ?></p>
            <hr />
            <p>Commentaire locataire : <?php
            $com = $val['commentaires'];
            $com = htmlentities($com);
            echo "$com";
            ?></p>
                  

            <?php
        } // fin de la boucle des informaiton locataires
        ?>
    
    
        <hr />
        Commentaire suppl&eacute;mentaire: 
    </div> <!--   fin de div container-->
    </body>
</html>