<?php
// -----------------------------------------
// Source  :	http://cogites.com
// Script  :	E RESERV
// Version :	PLUS 1.01
// revente et redistribution interdites
// Vous devez laisser le copyright.
// -----------------------------------------
session_start() ;


include ("../inc/conec.php");
// si le formulaire a ?t? post? on prend les variables demand?es
if ($_POST) {
    $an = intval($_POST['an']);
    $ID_location = intval($_POST['ID_location']);
	$langue = @$_POST['langue'];

}
// si le formulaire n'a pas ?t? post? on prend les mois et ann?e en cours
else {
    $an = intval($_GET['an']);
    $ID_location = intval($_GET['ID_location']);
	$langue = @$_GET['langue'];
}
if (empty($langue)){
	$langue='fr';
}
if (empty($an) || empty($ID_location)){
    echo '<link REL="StyleSheet" TYPE="text/css" HREF="../style.css">';
	echo '<div class="texte_erreur"> Probleme : il faut appeler une location et une année<br/><br/><br/>';
	echo 'Merci de prévenir l\'administrateur</div>';
exit;
}

$res_req = mysql_query("SELECT nom_location FROM $T_locations WHERE ID_location='$ID_location'") or die ("erreur chch nom_location");
$nom_location = mysql_result($res_req, 0);

?>
<?php echo "<?xml version=\"1.0\" encoding=\"\"?".">"; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>
<?php
if ($langue == 'fr'){
	$titre = "Calendrier des r&eacute;servations du ";
}
if ($langue == 'ang'){
	$titre = "Rental  Calendar : ";
}
if ($langue == 'nl'){
	$titre = "Reserveringskalender voor verhuur : ";
}
if ($langue == 'it'){
	$titre = "Calendario Prenotazioni : ";
}
if ($langue == 'all'){
	$titre = "Reservierungen Kalender f?r die Lage : ";
}
if ($langue == 'esp'){
	$titre = "Calendario de reservas : ";
}
echo $titre;
echo $nom_location;
?>

</title>
<meta http-equiv="Content-Type" content="text/html; charset="><style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}

.Submit {
	font-size: xx-small;
	width: 40px;
}
#servselect {
	font-size: xx-small;
	width: 90px;

}




-->
</style>
<link href="style_3mois.css" rel="stylesheet" type="text/css">
</head>
<body>

<table border="0" align="left">
  <tr valign="top">
    <td><?php
	// on commence par le mois de janvier
	$mois = '7';
	include ("calendrier.inc.php");
	include ("string.inc.php");
	echo showCalendar("$an-$mois");
	?></td>
  </tr>
  <tr valign="top">
    <td><?php
	// puis le mois de f&eacute;vrier = janvier +1 et ainsi de suite
	$mois = $mois + 1;
	$mois = "0$mois";
	echo showCalendar("$an-$mois");
	?></td>
  </tr>
  <tr valign="top">
    <td><?php
	// puis le mois de f&eacute;vrier = janvier +1 et ainsi de suite
	$mois = $mois + 1;
	$mois = "0$mois";
	echo showCalendar("$an-$mois");
	?></td>
  </tr>
  <tr valign="top">
    <td height="40" valign="bottom"> <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>" >
        <?php
	if (@$_SESSION["login_admin"] == true){
		$an = $an-1;
		echo "<div align=\"left\">&nbsp;<a href=\"index.php?an=$an&&ID_location=$ID_location\">&lt;&lt;</a>&nbsp";
	}
	?>
        <div align="left">
          <select id=servselect name=an>
            <?php $today = date(Y);?>
            <option value="<?php echo $today ?>" selected><?php echo $today ?></option>
            <option value="<?php echo $today + 1 ?>"><?php echo $today + 1 ?></option>
            <option value="<?php echo $today + 2 ?>"><?php echo $today + 2 ?></option>
            <option value="<?php echo $today + 3 ?>"><?php echo $today + 3 ?></option>
          </select>
        &nbsp;
          <input type="hidden" name="ID_location" value="<?php echo "$ID_location" ;?>">
          <input border=0 src="CaseCocher.gif" type="image" value="Voir">
          </div>
        </div>
    </form></td>
  </tr>
</table>
</body>
</html>
a
