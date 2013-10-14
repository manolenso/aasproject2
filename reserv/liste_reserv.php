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
include ('inc/conec.php'); 
include ('inc/chemin.php'); 
include('inc/func.dates.php'); 
?>
<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <title>Liste des r&eacute;servations</title>
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
    <div class="container">
        <?php include ('inc/menu_reserv.php'); ?>
        <h2 class="titre">Liste des r&eacute;servations</h2>
  
        <?php
        // si la demande vient de la page d'administration les variables viennent de GET
        $display = 'none';
        if (($_GET) or ($_POST)) {
            if ($_GET) {
                $an_res = intval($_GET['an_res']);
                $premier_janv_iso = $an_res . '-01-01';
                $dernier_dec_iso = $an_res . '-12-31';
                $ID_location = intval($_GET['ID_location']);
                $tri = "datedeb";
                // la requête porte sur une location et une année
                $ad_sql = "AND (datedeb <= '$dernier_dec_iso') AND (datefin >='$premier_janv_iso') AND ($T_locations.ID_location='$ID_location')";
            }
            // si la demande vient de la page liste_reserv les variables viennent de POST
            if ($_POST) {
                $an_res = intval($_POST['an_res']);
                $premier_janv_iso = $an_res . '-01-01';
                $dernier_dec_iso = $an_res . '-12-31';
                $ID_location = intval($_POST['ID_location']);
                $tri = ($_POST['tri']);
                $display = 'none';
                if (!empty($_POST['display'])) {
                    $display = ($_POST['display']);
                }

                // construction de la fin des requêtes suivant la demande du formulaire 
                // une location sur l'ensemble des années
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
                } else {
                    // une location sur une année
                    $ad_sql = "AND (datedeb <= '$dernier_dec_iso') AND (datefin >='$premier_janv_iso') AND ($T_locations.ID_location='$ID_location')";
                }
                // fin $_POST
            }
            // la requête qui sera aménagée avec ad_sql à la fin
            if (is_dir('suivi')) { // module suivi alors on ajoute AND ($T_reserv.etat_reserv=2)	
                $req_reserv = mysql_query("SELECT * FROM $T_reserv, $T_locations, $T_locataires WHERE ($T_locations.ID_location=$T_reserv.ID_location) AND ($T_locataires.ID_locataire=$T_reserv.ID_locataire) AND ($T_reserv.etat_reserv=2) $ad_sql ORDER BY $tri") or die(mysql_error());
            } else {
                $req_reserv = mysql_query("SELECT * FROM $T_reserv, $T_locations, $T_locataires WHERE ($T_locations.ID_location=$T_reserv.ID_location) AND ($T_locataires.ID_locataire=$T_reserv.ID_locataire) $ad_sql ORDER BY $tri") or die(mysql_error());
            }
        } else {
        // affichage par défaut
            if (is_dir('suivi')) { // module suivi alors on ajoute AND ($T_reserv.etat_reserv=2)	
                $req_reserv = mysql_query("SELECT DISTINCT * FROM $T_reserv, $T_locations, $T_locataires WHERE ($T_locations.ID_location=$T_reserv.ID_location) AND ($T_locataires.ID_locataire=$T_reserv.ID_locataire) AND ($T_reserv.etat_reserv=2) ORDER BY datedeb") or die("erreur requete reservations");
            } else {
                $req_reserv = mysql_query("SELECT DISTINCT * FROM $T_reserv, $T_locations, $T_locataires WHERE ($T_locations.ID_location=$T_reserv.ID_location) AND ($T_locataires.ID_locataire=$T_reserv.ID_locataire) ORDER BY datedeb") or die("erreur requete reservations");
            }
        }
        ?>
    <div class="well">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="form-inline">
                <select id=select name=ID_location>
                    <option value="all" selected="selected">sélectionner une location</option>
        <?php
        $query = "SELECT * FROM $T_locations  ORDER BY nom_location";
        $result = mysql_query($query);
        while ($val = mysql_fetch_array($result)) {
            print'<option value="' . $val['ID_location'] . '">' . $val['nom_location'] . '</option>';
        }
        ?>
                    <option value="all">Toutes</option>
                </select>
              
                <select id=servselect name=an_res class="input-small">
                    <option value="all" selected="selected">ann&eacute;e</option>
                <?php
                //les dates de 2005 à today +4 ans
                $an = date('Y');
                for ($i = 2005; $i < $an + 4; $i++)
                    echo"<option value=\"$i\">$i</option>";
                ?>
                    <option value="all">Toutes</option>
                </select>
              
                <select id=select name=tri >
                    <option value="datedeb" selected="selected">Classer par</option>
                    <option value="datedeb">Date de début</option>
                    <option value="datefin DESC">Date de fin</option>
                </select>
              
                <input type="submit" name="Submit" value="Lister" class="btn btn-primary"/>
            </form> 
        </div>
        
        <div class="alert alert-info" style ="text-align:center;">
        <?php echo mysql_num_rows($req_reserv); ?>
                    &nbsp;r&eacute;servation(s) correspond(ent) &agrave; votre recherche</div>
                <p><small> <span class="label label-info">Astuce</span> cliquer sur <i class="icon-chevron-down"></i>pour 
                        afficher/masquer les détails
                    </small></p>

        <?php
        $id = 1;
        while ($val_reserv = mysql_fetch_array($req_reserv)) {
            ?>
            <a id="<?php echo $id; ?>"></a>
        
        
            <div class="row" style="background-color:#FFEFD7" >
                <div class="span3">  <strong> <a href="#" onClick="newWindow('maj_locataire.php?ID_locataire=<?php echo $val_reserv['ID_locataire']; ?>', '', 600, 800, 1, 0, 0, 0, 0, 0, 0);return(false)"><?php echo "$val_reserv[titre] $val_reserv[prenom] $val_reserv[nom_locataire]";
                    ?></a></strong>   <a href="#<?php echo $id; ?>" onclick="showhide('help<?php echo $id; ?>');"> <i class="icon-chevron-down"></i></a>
                </div>
                 <div class="span6"> du&nbsp;<a href="#" onClick="newWindow('maj_reserv.php?ID_reserv=<?php echo $val_reserv['ID_reserv']; ?>', '', 1000, 500, 1, 0, 0, 0, 0, 0, 0);return(false)"><strong>
                    <?php
                    $val_reserv['datedeb'] = explode('-', $val_reserv['datedeb']);
                    echo $val_reserv['datedeb'][2], '/', $val_reserv['datedeb'][1], '/', $val_reserv['datedeb'][0];
                    ?>
                     </strong>&nbsp;au&nbsp;<strong>
                     <?php
                     $val_reserv['datefin'] = explode('-', $val_reserv['datefin']);
                     echo $val_reserv['datefin'][2], '/', $val_reserv['datefin'][1], '/', $val_reserv['datefin'][0];
                     ?>
                     </strong></a>&nbsp;-&nbsp;prix:<?php echo $val_reserv['prix'];
                     ?>&euro;
                 </div>
                <div class="span3"> <?php echo $val_reserv['nom_location']; ?></div>
            </div>
            
                <div class="liste">
                    <div id="help<?php echo $id; ?>" style="display: <?php echo $display; ?>" >
                    <div class="row">
                        <div class="span6">  
                            &nbsp;adulte(s) :&nbsp;<?php echo $val_reserv['nbr_adultes']; ?> <br/>
                            &nbsp;enfant(s) 2 &agrave; 13 ans :&nbsp;<?php echo $val_reserv['nbr_enfants_2_13']; ?><br/>
                            &nbsp;enfant(s) moins de 2 ans :&nbsp;<?php echo $val_reserv['nbr_enfants_inf_2']; ?><br/>
                            &nbsp;handicapé(s) :&nbsp; 
                            <?php
                            if ($val_reserv['pmr'] != 1) {
                                echo 'non';
                            } else {
                                echo 'oui';
                            };
                            ?>
                        </div>
                        <div class="span3">     <?php echo "$val_reserv[rue] <br/>$val_reserv[codepostal] $val_reserv[ville]<br/>  ($val_reserv[pays]) ";
                            ?>
                        </div>
                        <div class="span3"><?php echo "$val_reserv[tel] <br/> $val_reserv[tel_portable]<br/>"; ?>
                            <a href="mailto:<?php echo $val_reserv['email']; ?>">
                            <?php echo $val_reserv['email']; ?></a>
                        </div>
                    </div>
     
                    <div class="row">
                        <div class="span8">   
                            &nbsp;Commentaire : 
                        <?php
                        $max = '60';
                        $chaine = $val_reserv['commentaire_reserv'];
                        //Si le commentaire dépasse 100 caractères on tronque et on rajoute ... 
                        if (strlen($chaine) >= $max) {
                            $chaine = substr($chaine, 0, $max);
                            echo "$chaine...";
                        } else {
                            echo $chaine;
                        }
                        ?>
                        </div>
                        <div class="span4">
                            ID :<?php echo $val_reserv['ID_reserv'];
                        ?> enregsitrée le (<?php
                        $date_enreg = $val_reserv['date_enreg'];
                        // date anglaise en date françaises
                        $date_enreg = angl_fran($date_enreg);
                        echo $date_enreg;
                        ?>)
                        </div>
                    </div>
                
                </div>      <!--      fin id=help    -->   
         
                <div class="row" style ="text-align:center;">
                    <div class="span3">
                        <input name="button" type="submit" class="btn btn-primary " value="Fiche d'accueil" onclick="newWindow('fiche_accueil.php?ID_reserv=<?php echo $val_reserv['ID_reserv']; ?>', '', 850, 350, 1, 0, 0, 0, 0, 0, 0);return(false)" />
                    </div>
                    <div class="span3">
                        <button class="btn btn-warning" name="save" type="submit" onclick="newWindow('maj_reserv.php?ID_reserv=<?php echo $val_reserv['ID_reserv']; ?>', '', 1000, 500, 1, 0, 0, 0, 0, 0, 0);return(false)">Modifier <i class="icon-white icon-pencil"></i> </button>   
                    </div>
                    <div class="span3">
                        <?php if (is_dir('suivi')) { ?>
                           <button class="btn btn-warning" name="button" type="submit" onclick="location.href='suivi/re_option.php?ID_reserv=<?php echo $val_reserv['ID_reserv']; ?>';">Remettre en option <i class="icon-white  icon-retweet"></i> </button>   
                        <?php } ?></div>
                    <div class="span3">
                        <form method="post" action="sup_reserv.php"   onsubmit="return verif_form()">
                            <input type="hidden" name="ID_reserv" value="<?php echo $val_reserv['ID_reserv']; ?>">
                                <button class="btn btn-danger" name="save" type="submit">Supprimer <i class="icon-white icon-trash"></i> </button>   
                        </form>
                    </div>
                </div>
              </div>
        
            <?php
            $id = $id + 1;
        } // fin boucle affichage
        ?>
    
        <form method="post" name="formulaire" id="formulaire">
            <input name="an_res" type="hidden" value="<?php if (isset($an_res)) {
            echo $an_res;
        } ?>" />
            <input name="ID_location" type="hidden" value="<?php if (isset($ID_location)) {
            echo $ID_location;
        } ?>" />
            <input name="tri" type="hidden" value="<?php if (isset($tri)) {
            echo $tri;
        } else {
            echo'datedeb';
        } ?>" />
            <input name="display" type="hidden" value="<?php if ($display == 'none') {
            echo 'block';
        } else {
            echo'none';
        } ?>" />
            <button class="btn " name="liste"  type="submit">Afficher/masquer les détails <i class="icon-chevron-down"></i> </button>   
        </form>
        <small> <span class="label label-info">Astuce</span> cliquer sur <i class="icon-chevron-down"></i>pour afficher/masquer les détails d'une réservation</small>
        <p style ="text-align:right;"><a href="#haut" >Haut <i class="icon-arrow-up"></i></a></p>
        <?php
        if (isset($ID_location) && ($ID_location != 0)) {
            // si la liste concerne une location en particulier on propose la page d'impression du récap annuel
            ?>
        <a href="liste_impression.php?ID_location=<?php echo $ID_location; ?>&an=<?php echo date('Y'); ?>">Imprimer 
                la liste des r&eacute;servations et des locataires pour l'ann&eacute;e 
                en cours</a>
        <?php } ?>
        <?php include ("inc/copy.php"); ?>
    
    
    </div><!--   fin de div container-->
</body>
</html>