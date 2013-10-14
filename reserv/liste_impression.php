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
$an = $_GET['an'];
$ID_location = $_GET['ID_location'];
?>
<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>Liste des r&eacute;seravtion et des locataires pour et l'année <?php echo $an; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link REL="StyleSheet" TYPE="text/css" HREF="style.css">
</head>
<body onload="window.print()">
<table width="500" border="0" align="center" class="texte">
  <tr>
    <td>
	Liste des r&eacute;servations pour la location et l'ann&eacute;e <?php echo $an; ?> 
      (<a href="liste_impression.php?an=<?php echo $an+1; ?>&ID_location=<?php echo $ID_location; ?>">+</a> 
      / <a href="liste_impression.php?an=<?php echo $an-1; ?>&ID_location=<?php echo $ID_location; ?>">-</a>)
	</td>
  </tr>
</table>
<table width="1000" border="1" align="center" cellspacing="0" class="texte">
  <tr bgcolor="#CCCCCC"> 
    <td width="180"><div align="center">Location</div></td>
    <td width="120"><div align="center">D&eacute;but / Fin</div></td>
    <td width="200"><div align="center">Pr&eacute;nom / NOM</div></td>
    <td width="200"><div align="center">Adresse</div></td>
    <td width="200"><div align="center">Tel / Portable/ Email</div></td>
	<td width="100"><div align="center">Prix</div></td>
  </tr>
</table>
<?php
include("inc/func.dates.php"); 
$premier_janv_iso = $an . '-01-01'; 
$dernier_dec_iso = $an . '-12-31'; 
 
// requete compléte

if (is_dir('suivi')){ // module suivi alors on ajoute AND ($T_reserv.etat_reserv=2)
$req = mysql_query("SELECT * FROM $T_reserv, $T_locations, $T_locataires WHERE ($T_locations.ID_location=$T_reserv.ID_location) AND ($T_locataires.ID_locataire=$T_reserv.ID_locataire) AND (nom_locataire !='supprimée') AND (datedeb <= '$dernier_dec_iso') AND (datefin >='$premier_janv_iso') AND ($T_locations.ID_location ='$ID_location') AND ($T_reserv.etat_reserv=2) ORDER BY datedeb") or die ("erreur requête chch locataires");
}
else{
$req = mysql_query("SELECT * FROM $T_reserv, $T_locations, $T_locataires WHERE ($T_locations.ID_location=$T_reserv.ID_location) AND ($T_locataires.ID_locataire=$T_reserv.ID_locataire) AND (nom_locataire !='supprimée') AND (datedeb <= '$dernier_dec_iso') AND (datefin >='$premier_janv_iso') AND ($T_locations.ID_location ='$ID_location') ORDER BY datedeb") or die ("erreur requête chch locataires");
}
while ($val = mysql_fetch_array ($req)) {

$datedeb = $val['datedeb'];
$datefin = $val['datefin'];

// dates anglaises -> dates françaises
$datedeb = angl_fran("$datedeb");
$datefin = angl_fran("$datefin");
echo "
  <table width=\"1000\" border=\"1\" align=\"center\" cellspacing=\"0\" class=\"texte\">
  	<tr>
	  <td width=\"180\">&nbsp;$val[nom_location]</td>
	  <td width=\"120\">&nbsp;du $datedeb <br/>&nbsp;au $datefin</td>
	  <td width=\"200\">&nbsp;$val[titre] $val[prenom] $val[nom_locataire]<br/>
	  <font size=\"1\">
	  &nbsp;adulte(s) : $val[nbr_adultes]  <br/> 
	&nbsp;enfant(s) 2 à 13 ans : $val[nbr_enfants_2_13]<br/>
	&nbsp;enfant(s) moins de 2 ans : $val[nbr_enfants_inf_2]<br/>
	&nbsp;handicapé(s) : ";
	  if($val['pmr']!=1){
	  echo 'non';
	  }
	  else{
	  echo 'oui';
	  }
	echo "</font></td>
	  <td width=\"200\">&nbsp;$val[rue] <br/>&nbsp;$val[ville]<br/>&nbsp;$val[codepostal]</td>
	  <td width=\"200\">&nbsp;$val[tel]<br/>&nbsp;$val[tel_portable]<br/>&nbsp;$val[email]</td>
	  <td width=\"100\" align=\"center\" >&nbsp;$val[prix]€</td>
     </tr>
  </table>
  <br/>
  	";
} // fin de la boucle 
?>
</body>
</html>