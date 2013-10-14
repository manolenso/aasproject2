<?php
// -----------------------------------------
// Source  :	http://cogites.com
// Script  :	E RESERV
// Version :	5
// revente et redistribution interdites
// Vous devez laisser le copyright.
// -----------------------------------------
session_start() ;

include ("../inc/conec.php");
include ("calendrier.inc.php");
include ("string.inc.php");

header('Content-Type: text/html; charset=UTF-8');

	// mode d'affiche du calendrier
	// vous pouvez modifier l'affichage en commentant l'un des deux lignes "$mois=..."

	// le calendrier d?marre au mois en cours
	 $mois = intval(date('m'));

	// pour que le calendrier commence au mois de janvier mettre chiffre $mois = '1' pour commencer en f?vrier $mois = '2' etc.
	// $mois = '1';


// si le formulaire a ?t? post? on prend les variables demand?es
if ($_POST) {
    $an = intval($_POST['an']);
    $ID_location = intval($_POST['ID_location']);
}
// si le formulaire n'a pas ?t? post? on prend les mois et ann?e en cours
else {
	if(!empty($_GET['an'])){
	$an = intval($_GET['an']);
	}
	else{
	$an = date('Y');
	}
    $ID_location = intval($_GET['ID_location']);
}

if (empty($an) || empty($ID_location)){
    echo '<link REL="StyleSheet" TYPE="text/css" HREF="../style.css">';
	echo '<div class="texte_erreur"> Probleme : il faut appeler une location et une année<br/><br/><br/>';
	echo 'Merci de prévenir l\'administrateur</div>';
exit;
}

// on r?cup?re le nom de la location
$res_req = mysql_query("SELECT nom_location FROM $T_locations WHERE ID_location='$ID_location'") or die ("erreur chch nom_location");
$nom_location = mysql_result($res_req, 0);

// 	le tableau des jours r?serv?s pour l'ann?e (+d?but et fin de r?servation)
include ("tab_res.inc.php");


?>
<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Calendrier des r&eacute;servations pour la location : <?php echo $nom_location;?></title>
<link REL="StyleSheet" TYPE="text/css" HREF="style.css">
</head>
<body>
<div id="wrapper">
  <h1>Calendrier des r&eacute;servations pour <?php echo "$nom_location";?></h1>
  <p>

  <table width="100%" border="0" align="center" cellspacing="0">
    <?php
// on initialise les variables de colonnes et de lignes

$col ='';
$ligne='';

	while ($col<4){
	echo '<tr align="top">';

		while ($ligne<3){
		echo '<td>';

			if ($mois >=13){
			$mois = 01;
			$an = $an+1;
			}
			if ($mois<10){
			$mois = "0$mois";
			}

			echo showCalendar("$an-$mois");

		$mois++;

		echo '</td>';
		$ligne++;
		}
	$ligne='';
	echo '</tr>';
	$col++;
	}
?>

  </table>
  <p>&nbsp;</p>
  <div id="footer">
    <!-- Option pour changer d'ann?e. -->
    <p>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>" >
      <?php
	  	if($mois != 13){
		$an = $an-1;
		}

	if ((@$_SESSION["login_admin"] == true) || ($an > date('Y'))){
		$an_back = $an-1;
		echo "&nbsp;<a href=\"index.php?an=$an_back&ID_location=$ID_location\"><img src=\"../img/arrow-gauche.png\" width=\"40\" height=\"40\" border=\"0\" align=\"absmiddle\"></a>&nbsp";
	}
	?>
      <select id=servselect name=an>
        <?php $today = date('Y');?>
        <option value="<?php echo $today ?>" selected><?php echo $today ?></option>
        <option value="<?php echo $today + 1 ?>"><?php echo $today + 1 ?></option>
        <option value="<?php echo $today + 2 ?>"><?php echo $today + 2 ?></option>
        <option value="<?php echo $today + 3 ?>"><?php echo $today + 3 ?></option>
      </select>
      &nbsp;
      <input type="hidden" name="ID_location" value="<?php echo "$ID_location" ;?>">
      <input type="submit" name="Submit" value="Voir">
      &nbsp;<a href="index.php?an=<?php echo $an+1 ?>&ID_location=<?php echo $ID_location?>"><img src="../img/arrow-droite.png" width="40" height="40" border="0" align="absmiddle"></a>
    </form></p>
    <!-- merci de laisser le copyright ou bien de contacter cogites.com-->
    <p><a  href="javascript:window.close()" >Fermer la fen&ecirc;tre</a> </p>
    <p><a href="http://cogites.com" target="_blank" class="copyright">E-reserv
      (Cogites)</a> </p>
  </div>
  <!-- fin footer -->
  <p>&nbsp;</p>
</div>
<!-- fin wrapper -->
</body>
</html>
