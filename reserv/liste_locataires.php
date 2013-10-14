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
include ('inc/chemin.php'); 

?>
<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <title>Liste des  locataires</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <!-- css génériques -->
            <link href="inc/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" >
            <link href="style_reserv.css" rel="stylesheet" type="text/css" >

            <!-- js boostrap et j query -->    
            <script  src="inc/bootstrap/jquery.min.js" type="text/javascript"></script>
            <script  src="inc/bootstrap/js/bootstrap.js" type="text/javascript"></script>
            
            
            <!-- js spécifique (date etc.) -->    
            <script src="inc/fonc.js" type="text/javascript"></script>
</head>
<body>
    <?php include ('inc/menu_reserv.php'); ?>
        <div class="container">
        <h2 class="titre" >Liste des locataires</h2>
        <?php
        if ($_POST) {
            // si la requête ne concerne qu'un seul locataire
            if (isset($_POST['ID_locataire'])) {
                $ID_locataire = intval($_POST['ID_locataire']);
                if ($ID_locataire == "all") {
                    echo "<p div =center class=\"alert alert-error\">ERREUR. Vous devez choisir un locataire.</p>";
                    die;
                }
                $req = mysql_query("SELECT * FROM $T_locataires WHERE $T_locataires.ID_locataire='$ID_locataire'") or die("erreur requête chch locataires");
            } else {
                // recherche multicritères. on regarde tous les cas de figure.
                // une location sur l'ensemble des années
                $ID_location = intval($_POST['ID_location']);
                $an_res = intval($_POST['an_res']);
                $premier_janv_iso = $an_res . '-01-01';
                $dernier_dec_iso = $an_res . '-12-31';
                $tri = ($_POST['tri']);

                if ($an_res == 'all' and $ID_location != 'all') {
                    $ad_sql = "AND ($T_locations.ID_location='$ID_location')";
                }
                // toutes les locations sur une année
                elseif ($ID_location == 'all' and $an_res != 'all') {
                    $ad_sql = "AND (datedeb <= '$dernier_dec_iso') AND (datefin >='$premier_janv_iso')";
                }
                // toutes les locations sur l'ensemble des années
                elseif ($ID_location == 'all' and $an_res == 'all') {
                    $ad_sql = "";
                }
                // une location sur une année
                else {
                    $ad_sql = "AND (datedeb <= '$dernier_dec_iso') AND (datefin >='$premier_janv_iso') AND ($T_locations.ID_location='$ID_location')";
                }
                // requette de la liste des locataires
                $req = mysql_query("SELECT * FROM $T_reserv, $T_locations, $T_locataires WHERE ($T_locations.ID_location=$T_reserv.ID_location) AND ($T_locataires.ID_locataire=$T_reserv.ID_locataire) AND (nom_locataire !='supprimée') $ad_sql ORDER BY $tri") or die("erreur requête chch locataires 1");
            }
        }
        else
        //affichage par défaut
            $req = mysql_query("SELECT * FROM $T_locataires ORDER BY nom_locataire") or die("erreur requête chch locataires");
        ?>
        
        <div class="well">
               <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="form-inline" >
                <select id=select2 name=ID_location>
                    <option value="all" selected>sélectionner une location</option>
                    <?php
                    // liste des locations
                    $query = "SELECT * FROM $T_locations ORDER BY nom_location";
                    $result = mysql_query($query);
                    while ($val = mysql_fetch_array($result)) {
                        print'<option value="' . $val['ID_location'] . '">' . $val['nom_location'] . '</option>';
                    }
                    ?>
                    <option value="all">Toutes</option>
                </select>
              
                <select class="input-small" id=servselect name=an_res>
                    <option value="all" selected>ann&eacute;e</option>
                <?php
                // les date de 2005 à today +4 ans
                $an = date('Y');
                for ($i = 2005; $i < $an + 4; $i++)
                    echo"<option value=\"$i\">$i</option>";
                ?>
                    <option value="all">Toutes</option>
                </select>
              
                <select class="input-medium" id=select4 name=tri>
                    <option value="nom_locataire" selected>Classer par</option>
                    <option value="nom_locataire" >Nom</option>
                    <option value="date_enreg_locataire">Date d'enregistrement</option>
                    <option value="nbr_sejour DESC">Nombre de séjours</option>
                    <option value="codepostal">Code Postal</option>
                </select>
                <input type="hidden" name="seek_loca" value="yes">
                    <input class="btn btn-primary" type="submit" name="Submit" value="Voir">
                        <div class="lead">ou</div>
                        </form>
          
          
          
                        <div class="row-fluid">
                            <div class="span6"> <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="form-inline">
                                    <select id=select3 name=ID_locataire>
                                        <option value="all" selected>sélectionner un locataire</option>
                                        <?php
                                        // liste des locataires
                                        $query = "SELECT ID_locataire, prenom, nom_locataire FROM $T_locataires WHERE nom_locataire !='supprimée' ORDER BY nom_locataire";
                                        $result = mysql_query($query);
                                        while ($val = mysql_fetch_array($result)) {
                                            print'<option value="' . $val['ID_locataire'] . '">' . $val['nom_locataire'] . ' ' . $val['prenom'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <input type="hidden" name="seek_one_loca" value="yes">
                                        <input class="btn btn-primary" type="submit" name="Submit" value="Voir">
                                            </form></div>
                                            <div class="span6"><a href="#" onclick="newWindow('ajout_locataire.php', '', 600, 700, 1, 0, 0, 0, 0, 0, 0);return(false)"><img src="img/ajout_locataires.png" width="48" height="48" border="0" align="absmiddle" /> Ajouter un locataire</a></div>
                        </div>
          </div>
        
        <div class="alert alert-info" style ="text-align:center;">
            <strong><?php echo mysql_num_rows($req);?> locataire(s)</strong> corresponde(nt) &agrave; votre recherche
        </div>
        <?php
        // on affiche la liste des locataires
        while ($val = mysql_fetch_array($req)) {
        ?>
        <p>
            <div class="liste">
              <table width="940" border="0" align="center" cellspacing="0" bgcolor="#FFEFD7" class="texte">
                <tr> 
                    <td width="128" height="20">ID : <?php echo $val['ID_locataire'];
                       ?> <font size="1">(<?php echo $val['date_enreg_locataire'];
                       ?>)</font>
                    </td>
                    <td width="284"><strong>&nbsp;<?php echo "$val[titre] $val[prenom] $val[nom_locataire]"; ?></strong></td>
                    <td width="274"><strong>&nbsp;<?php echo "$val[tel] / $val[tel_portable]"; ?></strong></td>
                </tr>
                <tr>
                    <td height="20" colspan="2">&nbsp;<?php echo "$val[rue] $val[codepostal] $val[ville]  ($val[pays]) ";?></td>
                    <td><a href="mailto:<?php echo $val['email']; ?>">&nbsp;<?php echo $val['email']; ?></a></td>
                </tr>
                <tr>
                    <td height="20" colspan="2"> &nbsp;Commentaires : <?php echo $val['commentaires']; ?></td>
                    <td>&nbsp;Le client est venu <?php echo $val['nbr_sejour']; ?> fois</td>
                </tr>
                  <tr> 
                      <form name="form1" method="post" onSubmit="newWindow('maj_locataire.php?ID_locataire=<?php echo $val['ID_locataire']; ?>', '', 800, 900, 1, 0, 0, 0, 0, 0, 0);return(false)"> 
                        <td height="26" colspan="2">
                        <button class="btn btn-warning" name="Submit2" type="submit">Modifier <i class="icon-white icon-pencil"></i> </button> 
                        </td>
                </form>
                <form method="post" action="sup_locataire.php"  onsubmit="return verif_form()">
                 <td>
                     <div align="left">
                         <input type="hidden" name="ID_locataire" value="<?php echo $val['ID_locataire']; ?>">
                             <button class="btn btn-danger" name="Submit2" type="submit">Supprimer <i class="icon-white icon-trash"></i> </button>
                        </div>
                 </td>
                </form>
                  </tr>
              </table>
        </div>
    <?php
} // fin boucle affiche la liste des locataires
// nbr de résultats
print'<p><p>&nbsp;</p>';
?>
</div> <!--   fin de div container-->
</body>
</html>