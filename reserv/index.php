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
include ('inc/chemin.php');

//vérification chemin e_reserv (pour les menus)

$root = 'http://' . $_SERVER['HTTP_HOST'];
$self = $_SERVER['PHP_SELF'];
$url_e_reserv = $root . substr($self, 0, -(strlen(strrchr($self, "/")) - 1));


// si le chemin n'est pas bon ou n'existe pas on le créer ou le recréer		
if ((!isset($chemin)) || ($url_e_reserv != $chemin)) {
    // récupération du chemin de connexion au script
    $root = 'http://' . $_SERVER['HTTP_HOST'];
    $self = $_SERVER['PHP_SELF'];
    $url_e_reserv = $root . substr($self, 0, -(strlen(strrchr($self, "/")) - 1));

    if (!$fichier = fopen("inc/chemin.php", "w")) {
        echo "Echec de l'ouverture du fichier chemin";
        exit;
    }

    $chemin = '<?php $chemin="';
    $chemin .= "$url_e_reserv";
    $chemin .= '"; ?';
    $chemin .='>';

    fputs($fichier, $chemin);
    fclose($fichier);
    // on réimporte le fichier 
    include ('inc/chemin.php');
}
?>
<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?" . ">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>Interface d'administration pour des réservations pour <?php echo "$site"; ?></title>
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

              <h2 class="titre" >E'RESERV : gérez vos réservations en lignes</h2>
                                
              <?php
              // on vérifie s'il y a au moins une location d'enregistrée
              $query = "SELECT ID_location, nom_location FROM $T_locations ORDER BY nom_location";
              $result = mysql_query($query);
              $nbr_locations=mysql_num_rows($result);
              
              // calcul de la hauteur de la fenêtre du calendrier multi
              $hauteur_multi = ($nbr_locations*50)+300;
              if($hauteur_multi > 900){
                  $hauteur_multi = 900;
              }
              
              if ($nbr_locations == 0) {
                  print'<br/><br/><br/><div class="alert alert-error">
                      <h4>Vous devez enregistrer au moins une location => <a href="liste_locations.php">cliquez ici</a></h4></div>';
                  die;
              }
              ?>
              <div class="well">
                  <div class="row-fluid">
                      
                      <div class="span4"><a href="#" onclick="newWindow('formulaire_reserv_loueur.php', '', 1000, 800, 1, 0, 0, 0, 0, 0, 0);return(false)"><img src="img/ajout_reserv.png" width="32" height="32" > 
                          </a> <a href="#" onclick="newWindow('formulaire_reserv_loueur.php', '', 1000, 800, 1, 0, 0, 0, 0, 0, 0);return(false)">Ajouter 
                              une nouvelle r&eacute;servation</a></div>
                      <div class="span4"><a href="#" onclick="newWindow('ajout_locataire.php', '', 600, 800, 1, 0, 0, 0, 0, 0, 0);return(false)"><img src="img/ajout_locataires.png" width="32" height="32" > </a>
                          <a href="#" onclick="newWindow('ajout_locataire.php', '', 600, 700, 1, 0, 0, 0, 0, 0, 0);return(false)">Ajouter un client </a>
                      </div>
                     <?php if (is_dir('suivi')) { // test module suivi?>
                     <div class="span4"><a href="#" onClick="javascript:newWindow('cal/index_multi.php', '', 1500,<?php echo $hauteur_multi; ?>, 1, 0, 0, 0, 0, 0, 0);return(false)"><img src="img/multi_cal.jpg"> Calendrier multi-locations</a></div>
                     <?php } ?>
                  </div>
              </div>
                                    
              <?php
              // on insére le tableau de synthèse des réservations pour l'année demandée
              include ("tab_synt.inc.php");
              ?>


              <!--  liste prochains départs-->
              <?php
              if (is_dir('suivi')) { // test module suivi
                  include("inc/func.dates.php");
                  $today = date("Y-m-d");
                  $req_en_cours = mysql_query("SELECT * FROM $T_reserv, $T_locations, $T_locataires WHERE etat_reserv = 2 AND ($T_locations.ID_location=$T_reserv.ID_location) AND ($T_locataires.ID_locataire=$T_reserv.ID_locataire) AND (nom_locataire !='supprimée') AND (datedeb <= '$today') AND (datefin >= '$today') ORDER BY datedeb LIMIT 10") or die(mysql_error());
                  $nbr_en_cours = $num_rows = mysql_num_rows($req_en_cours);
                  ?>                       
                  <div class="accordion-heading">
                      <a class="accordion-toggle" href="#reserv_en_cours" data-toggle="collapse">
                          <h5 style="color:#FF9933;">Listes des réservations en cours (<?php echo $nbr_en_cours; ?>) <i class="icon-chevron-down"></i> </h5> </a> 
                  </div>
                  <div id="reserv_en_cours" class="collapse">
                          <div class="accordion-inner"> 
                                                
                          <table class="table table-hover table-condensed">
                              <thead >
                                  <tr style ="background:#F4C89F;">
                                      <th>Durée</th>
                                      <th>Locataire</th>
                                      <th>Location</th>
                                      <th>Dates</th>
                                      <th>Prix</th>
                                      <th>Fiche Accueil</th>
                                  </tr>
                              </thead>
                              <?php
                              while ($val = mysql_fetch_array($req_en_cours)) {
                                  $datedeb = $val['datedeb'];
                                  $datefin = $val['datefin'];
                                  // durée
                                  $nbjours_duree = round((strtotime($datefin) - strtotime($datedeb)) / (60 * 60 * 24));
                                  $datedeb = angl_fran("$datedeb");
                                  $datefin = angl_fran("$datefin");
                                  $ID_reserv = $val['ID_reserv'];
                                  echo "<tr style=\"background:#FFF9F7\">
                                            <td width=\"70\"> $nbjours_duree nuitée(s)</td>
                                            <td width=\"180\"><a href=\"#\" onClick=\"newWindow('maj_locataire.php?ID_locataire=$val[ID_locataire]', '', 600, 800, 1, 0, 0, 0, 0, 0, 0);return(false)\">$val[titre] $val[prenom] $val[nom_locataire]</a></td>
                                            <td width=\"150\">$val[nom_location]</td>
                                            <td width=\"140\"  ><a href=\"#\" onClick=\"newWindow('maj_reserv.php?ID_reserv=$val[ID_reserv]', '', 1000, 500, 1, 0, 0, 0, 0, 0, 0);return(false)\"> $datedeb / $datefin</a></td>
                                            <td width=\"100\">$val[prix]€</td>
                                            <td width=\"120\">
                                            <button class=\"btn btn-info btn-small\"  name=\"button\" type=\"submit\" onclick=\"newWindow('fiche_accueil.php?ID_reserv=$val[ID_reserv]', '', 1000, 500, 1, 0, 0, 0, 0, 0, 0);return(false)\">Fiche d'accueil <i class=\"icon-white icon-print\"></i> </button>
                                            </td>
                                        </tr>
                                        ";
                              }
                              ?>
                          </table>
                      </div>
                  </div>
              <?php } // fin  test module suivi pour les prochains départ ?>
                            
         
              <!--                            liste prochaines arrivées-->   
              <?php
              if (is_dir('suivi')) { // test module suivi
                  $today = date("Y-m-d");
                  $req_prochaines = mysql_query("SELECT * FROM $T_reserv, $T_locations, $T_locataires WHERE etat_reserv = 2 AND ($T_locations.ID_location=$T_reserv.ID_location) AND ($T_locataires.ID_locataire=$T_reserv.ID_locataire) AND (nom_locataire !='supprimée') AND (datedeb >= '$today') ORDER BY datedeb LIMIT 10") or die(mysql_error());
                  $nbr_proch_arriv = $num_rows = mysql_num_rows($req_prochaines);
                  ?>
                  <div class="accordion-heading">
                      <a class="accordion-toggle" href="#proch_arriv" data-toggle="collapse">
                          <h5 style="color:#FF9933;">Liste des prochaines r&eacute;servations (<?php echo $nbr_proch_arriv; ?>) <i class="icon-chevron-down"></i> </h5> </a> 
                  </div>
                  <div id="proch_arriv" class="collapse">
                          <div class="accordion-inner"> 
                                                
                          <table class="table table-hover table-condensed">
                              <thead >
                                  <tr style ="background:#F4C89F;">
                                      <th>Délai</th>
                                      <th>Locataire</th>
                                      <th>Location</th>
                                      <th>Dates</th>
                                      <th>Prix</th>
                                      <th>Fiche Accueil</th>
                                  </tr>
                              </thead>
                            <?php
                            while ($val = mysql_fetch_array($req_prochaines)) {
                                $datedeb = $val['datedeb'];
                                $datefin = $val['datefin'];
                                $datedeb = angl_fran("$datedeb");
                                $datefin = angl_fran("$datefin");
                                $ID_reserv = $val['ID_reserv'];

                                $req_ecart = mysql_query("SELECT datedeb FROM $T_reserv WHERE etat_reserv = 2 AND (ID_reserv='$ID_reserv') AND (datedeb >= '$today') ORDER BY datedeb LIMIT 3") or die(mysql_error());
                                $ecart_deb = mysql_result($req_ecart, 0);
                        // AAAA-MM-DD en AAAMMDD
                                $date_w1 = str_replace("-", "", "$ecart_deb");
                        // calcul du nombre de jours d'écart
                                $nbjours_ecart = round((strtotime($date_w1) - strtotime($today)) / (60 * 60 * 24));

                                echo "<tr style=\"background:#FFF9F7\">
                                                                    <td width=\"30\"> $nbjours_ecart j</td>
                                                                    <td width=\"180\"><a href=\"#\" onClick=\"newWindow('maj_locataire.php?ID_locataire=$val[ID_locataire]', '', 600, 800, 1, 0, 0, 0, 0, 0, 0);return(false)\">$val[titre] $val[prenom] $val[nom_locataire]</a></td>
                                                                    <td width=\"150\">$val[nom_location]</td>
                                                                    <td width=\"140\"  ><a href=\"#\" onClick=\"newWindow('maj_reserv.php?ID_reserv=$val[ID_reserv]', '', 1000, 500, 1, 0, 0, 0, 0, 0, 0);return(false)\"> $datedeb / $datefin</a></td>
                                                                    <td width=\"100\">$val[prix]€</td>
                                                                    <td width=\"100\">
                                                                    <button class=\"btn btn-info btn-small\"  name=\"button\" type=\"submit\" onclick=\"newWindow('fiche_accueil.php?ID_reserv=$val[ID_reserv]', '', 1000, 500, 1, 0, 0, 0, 0, 0, 0);return(false)\">Fiche d'accueil <i class=\"icon-white icon-print\"></i> </button>
                                                                    </td>
                                                                </tr>
                                                                ";
                            }
                            ?>
                          </table>
                                    
                      </div>
                  </div>
                                                
              <?php } // fin  test module suivi pour les prochaines réservations ?>
                            
            
              <p>&nbsp;</p> 
              <?php if (is_dir('suivi')) { // test module suivi pour ajout du tableau de synthèse des suisvis
                  ?>
                                        
                                        
                                        
                      <div class="row" style ="background:#CBE7CF; margin: 0; padding-top:10px;">
                          <div class="span5">Vous avez <a href="suivi/suivi_reserv.php"> 
                      <?php
                      $req_attente = mysql_query("SELECT etat_reserv FROM $T_reserv WHERE etat_reserv=0 OR etat_reserv=1 AND ID_location NOT IN (12)") or die("erreur requete reservations attente");
                      // affiche le nbre de réservations en attente
                      $nbr_reserv_attente = mysql_num_rows($req_attente);
                      echo $nbr_reserv_attente;
                      ?>
                                  demande(s) non trait&eacute;e(s) </a></div>
                          <div class="span5"><?php
                              $req_contrat_attente = mysql_query("SELECT etat_reserv FROM $T_reserv WHERE etat_reserv=1 ") or die("erreur requete reservations attente");
                              // affiche le nbre de réservations en attente
                              $nbr_contrat_attente = mysql_num_rows($req_contrat_attente);
                              echo $nbr_contrat_attente;
                      ?>
                              <a href="suivi/suivi_reserv.php?contrat=1">contrat(s) non retourn&eacute;(s)</a> 
                              dont <b> 
                              <?php
                              $today15j = date('Y-m-d', strtotime('-15 day'));
                              $req_contrat_attente_15j = mysql_query("SELECT etat_reserv FROM $T_reserv WHERE etat_reserv=1 AND (date_envoie_contrat < $today15j) ") or die("erreur requete reservations attente");
                              // affiche le nbre de réservations en attente
                              $nbr_contrat_attente_15j = mysql_num_rows($req_contrat_attente_15j);
                              echo $nbr_contrat_attente_15j;
                              ?>
                              </b> depuis plus de 15 jours
                          </div>
                      </div>
                  </p>
                                        
                <?php
                include ("suivi/tab_synt_suivi.inc.php");
            } // fin test module suivi
            ?>
                                    
                                    
              <?php
              include ("inc/copy.php");
              ?>
                                    
                </div> <!--   fin de div container-->
    </body>
</html>