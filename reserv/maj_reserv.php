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
            <title>Mettre &agrave; jour une r&eacute;servation</title>

            <!-- css génériques -->
            <link href="inc/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" >
            <link href="style_reserv.css" rel="stylesheet" type="text/css" >

            <!-- js boostrap et j query -->    
            <script  src="inc/bootstrap/jquery.min.js" type="text/javascript"></script>
            <script  src="inc/bootstrap/js/bootstrap.js" type="text/javascript"></script>
            
            
            <!-- js spécifique (date etc.) -->    
            <script src="inc/fonc.js" type="text/javascript"></script>

            <!-- js du datepicker -->    
            <script  src="inc/bootstrap/js_ui/jq-ui-smooth.js" type="text/javascript"></script>
            <!-- js datepicker en français etc. -->    
            <script type="text/javascript" src="inc/bootstrap/js_cal/cal.js"></script>
            <!-- css du date datepicker -->    
            <link href="inc/bootstrap/js_ui/css/style_smoothness.css" rel="stylesheet" type="text/css" >


            <style type="text/css">
            .container{
                margin-left: 20px; 
                margin-top: -50px; 
            }
            textarea{
                width: 850px;
            }
            </style>
    </head>
    
    <body onload="GereControle('radio_1', 'menu_locataire_connu', '0');">
        <div class="container">
        <?php 
        include("inc/func.dates.php"); 
        if($_GET){
                $ID_reserv = intval($_GET['ID_reserv']);
        }
        // si le formulaire a été posté alors on update 
        if ($_POST) {
            $datedeb = mysql_real_escape_string($_POST['datedeb']);
            $datefin = mysql_real_escape_string($_POST['datefin']);
            $ID_reserv = intval($_POST['ID_reserv']);
                $prix = floatval($_POST['prix']);
                $commentaire_reserv = mysql_real_escape_string($_POST['commentaire_reserv']);
                $titre_nx = mysql_real_escape_string($_POST['titre_nx']);
                $prenom_nx = mysql_real_escape_string($_POST['prenom_nx']);
                $nom_locataire_nx = mysql_real_escape_string($_POST['nom_locataire_nx']);

                // autres variables
                $nbr_adultes = floatval($_POST['nbr_adultes']);
                $nbr_enfants_2_13 = floatval($_POST['nbr_enfants_2_13']);
                $nbr_enfants_inf_2 = floatval($_POST['nbr_enfants_inf_2']);	
                $pmr = floatval($_POST['pmr']);


                if (isset($_POST['ID_locataire'])) {
                $ID_locataire = intval($_POST['ID_locataire']);
                } 
                $ID_location = intval($_POST['ID_location']);

                // on passe les dates de françaises en anglaises
                $datedeb = fran_angl("$datedeb");
                $datefin = fran_angl("$datefin");

                // contrôle des dates impossibles : champs vide et la fin avant le début
                $erreur = ctrl_date($datedeb, $datefin);

            // controle du recouvrement des dates
                if (is_dir('suivi')){// si module suivi alors on ajoute AND ($T_reserv.etat_reserv=2)
                $req = mysql_query("SELECT * from $T_reserv WHERE ID_location=$ID_location AND ID_reserv != $ID_reserv AND (('$datedeb' >= datedeb AND '$datedeb' < datefin) OR ('$datefin' > datedeb AND '$datefin' <= datefin) OR (('$datedeb' < datedeb) AND (datedeb < '$datefin')) OR ('$datedeb' = datedeb) AND (datefin = '$datefin') OR ('$datedeb' = datedeb)) AND ($T_reserv.etat_reserv=2)") or die ("erreur requete recouvrement date");
                }
                else{
                $req = mysql_query("SELECT * from $T_reserv WHERE ID_location=$ID_location AND ID_reserv != $ID_reserv AND (('$datedeb' >= datedeb AND '$datedeb' < datefin) OR ('$datefin' > datedeb AND '$datefin' <= datefin) OR (('$datedeb' < datedeb) AND (datedeb < '$datefin')) OR ('$datedeb' = datedeb) AND (datefin = '$datefin') OR ('$datedeb' = datedeb))") or die ("erreur requete recouvrement date");
                }


            $contenu = mysql_fetch_array ($req);
            if (!empty($contenu)) {
                $erreur ='<div class="alert alert-error"> !!! ERREUR !!! <br/><br/>La période proposée 
                        recouvre une période déjà enregistrée';
                }
                if (isset($erreur)){
                        $erreur .='<br/><br/><a href="javascript:history.back();">cliquez ici pour retourner au formulaire</a>';  
                        echo "<div class = \"alert alert-error\"> $erreur</div>";
                        exit;
                }
            // on met à jours les informations
            // la date du jour comme date d'enregistrement de la réservation et le cas échéant du locataire
            $date_enreg = date("Y-m-d"); 

            // requète d'insertion dans les tables locataires et reserv
            // si c'est un locataire déjà connu on maj reserv
            if (isset($ID_locataire)) {
                        // si on a changé de locataire on incrémente son nbr de séjour
                        $req_ID_locataire = mysql_query("SELECT ID_locataire FROM $T_reserv WHERE ID_reserv='$ID_reserv'")or die ("erreur cherche locataire");
                        $ID_locataire_old = mysql_result($req_ID_locataire, 0);
                        if ($ID_locataire_old != $ID_locataire){
                mysql_query("UPDATE $T_locataires SET nbr_sejour=nbr_sejour+1 WHERE ID_locataire='$ID_locataire' ");
                        }
                        mysql_query("UPDATE $T_reserv SET ID_location='$ID_location', ID_locataire='$ID_locataire', datedeb='$datedeb', datefin='$datefin', prix='$prix', commentaire_reserv='$commentaire_reserv', nbr_adultes='$nbr_adultes', nbr_enfants_2_13='$nbr_enfants_2_13', nbr_enfants_inf_2='$nbr_enfants_inf_2', pmr='$pmr' WHERE ID_reserv='$ID_reserv'") or die ("erreur requète maj reserv 1");

            } 
            // si c'est un nouveau locataire on va lui créer une fiche et reprendre son ID pour la table reserv
            else {
                if ((empty ($_POST['nom_locataire_nx'])) || (empty ($_POST['prenom_nx'])) || (empty ($_POST['titre_nx'])) || ($_POST['prenom_nx'] =='Prénom') || ($_POST['nom_locataire_nx'] =='NOM')) { 
                        $erreur = '!!! ERREUR !!! <br/><br/> Vous n\'avez pas complété le titre, le prenom et le NOM du nouveau locataire';
                        echo "<div class = \"alert alert-error\"> $erreur</div>";
                        exit;
                        }
                        elseif (is_dir('suivi')){ // module suivi nbr_sejour = 0
                        mysql_query("INSERT INTO $T_locataires VALUES ('','$titre_nx','$nom_locataire_nx','$prenom_nx','rue','codepostal','ville','pays','tel','portable','coucou@chezmoi.com','','0','$date_enreg')")or die ("erreur requète insertion locataire"); 
                        }
                        else{		
                        mysql_query("INSERT INTO $T_locataires VALUES ('','$titre_nx','$nom_locataire_nx','$prenom_nx','rue','codepostal','ville','pays','tel','portable','coucou@chezmoi.com','','1','$date_enreg')")or die ("erreur requète insertion locataire"); 
                        }
                // on va chercher l'ID du locataire que l'on vient juste de rentrer
                $res_req = mysql_query("SELECT ID_locataire FROM $T_locataires ORDER BY ID_locataire DESC") or die ("erreur requete recup ID_locataire");
                $ID_locataire = mysql_result($res_req, 0); 
                // requète d'insertion dans la table reserv

                mysql_query("UPDATE $T_reserv SET ID_reserv='$ID_reserv', ID_location='$ID_location', ID_locataire='$ID_locataire', datedeb='$datedeb', datefin='$datefin', prix='$prix', commentaire_reserv='$commentaire_reserv', nbr_adultes='$nbr_adultes', nbr_enfants_2_13='$nbr_enfants_2_13', nbr_enfants_inf_2='$nbr_enfants_inf_2', pmr='$pmr'  WHERE ID_reserv='$ID_reserv'") or die ("erreur requète maj reserv 2");
            } 
            print'<div class = "alert alert-success">La réservation a été mise à jour</div>';
                // fonction on enregistre, on ferme et on actualise la page
                print'<script>
                javascript:refreshParent()
                javascript:window.close()
                </script>';
        } 
        // sinon affichage des informations de la réservation
        $req = ("SELECT * FROM $T_locations, $T_reserv, $T_locataires WHERE ($T_reserv.ID_reserv=$ID_reserv) AND ($T_locations.ID_location=$T_reserv.ID_location) AND ($T_locataires.ID_locataire=$T_reserv.ID_locataire)") or die ("erreur requete 1");
        $result = mysql_query($req);
        while ($val_res = mysql_fetch_array($result)) {
        ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="form-horizontal">
            <div class="row">
                    <div class="span6">
                        <div class="control-group">
                            <label class="control-label">Nom de la location :</label>
                            <div class="controls">
                                <select name="ID_location" id="nom_location">
                                    <option value="<?php echo $val_res['ID_location']; ?>" selected><?php echo $val_res['nom_location']; ?></option>
                                    <?php
                                    $query = "SELECT ID_location, nom_location FROM $T_locations WHERE ID_location != $val_res[ID_location] ORDER BY nom_location";
                                    $result = mysql_query($query);
                                    while ($val = mysql_fetch_array($result)) {
                                        print'<option value="' . $val['ID_location'] . '">' . $val['nom_location'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        
                        <div ID="div_datedeb"  class="control-group">
                            <label class="control-label" >Date de d&eacute;but</label>
                            <div class="controls">
                                <div class="input-append"><input type="text" class="datepicker input-small" name="datedeb" id="date_deb" value="<?php
                                $datedeb = $val_res['datedeb'];
                                echo angl_fran("$datedeb");
                                    ?>" name="date_deb"  title="Cliquez ici pour afficher le calendrier"> <span class="add-on"><i class="icon-calendar"></i></span>
                                    
                                </div>
                            </div>
                         
                        </div>
                     
                     
                        <div ID="div_datefin" class="control-group">
                            <label class="control-label" >Date de fin</label>
                            <div class="controls">
                                <div class="input-append"><input type="text" class="datepicker input-small" id="date_fin" value="<?php
                                                             $datefin = $val_res['datefin'];
                                                             echo angl_fran("$datefin");
                                    ?>" name="datefin"  title="Cliquez ici pour afficher le calendrier"><span class="add-on"><i class="icon-calendar"></i></span>
                                </div>
                            </div>
                            <div id="datefin_alerte" class="alert alert-error hide">
                                <h4>Erreur !</h4>Merci d'indiquer une date de fin.
                            </div>
                        </div>
                     
                     
                        <input name="radios" type="radio" id="radio_1" onClick="GereControle('radio_1', 'menu_locataire_connu', '0');" checked>
                            Client connu <select name="ID_locataire" id="menu_locataire_connu">
                                <option value="<?php echo $val_res['ID_locataire']; ?>"selected><?php echo "$val_res[titre] $val_res[prenom] $val_res[nom_locataire]"; ?></option>
                                <?php
                                $query = "SELECT ID_locataire, titre, prenom, nom_locataire FROM $T_locataires WHERE ID_locataire != $val_res[ID_locataire] ORDER BY nom_locataire";
                                $result = mysql_query($query);
                                while ($val = mysql_fetch_array($result)) {
                                    print'<option value="' . $val['ID_locataire'] . '">' . $val['titre'] . ' ' . $val['prenom'] . ' ' . $val['nom_locataire'] . '</option>';
                                }
                                ?>
                            </select>
                            <br/><br/> 
                            <input name="radios" type="radio" id="radio_2" onClick="GereControle('radio_1', 'menu_locataire_connu', '0');"> 
                                Nouveau Client
                                <select class="input-small"  name="titre_nx" id="titre_nx">
                                    <option value="" >choix</option>
                                    <option value="Mme">Mme</option>
                                    <option value="Mr">Mr</option>
                                    <option value="Mlle">Mlle</option>
                                </select> <input class="input-small" name="prenom_nx" type="text" id="prenom_nx" value="Prénom" size="17"> 
                                    <input class="input-small"  name="nom_locataire_nx" type="text" id="nom_locataire_nx" value="NOM" size="17" /> 
                              
                        </div><!--              fin span 6-->
                              
                        <div class="span6"> 
                                <div class="control-group">
                                    <label class="control-label"><strong> Prix</strong></label> 
                                    <div class="controls">
                                        <input class="input-mini" name="prix" type="text"  id="prix" value="<?php echo $val_res['prix']; ?>" /> 
                                </div>
                                </div>
                                                    
                                                    
                                                    
                                <div  class="control-group">
                                    <label  class="control-label" for="nbr_adultes">Nombre d'adultes</label>
                                    <div class="controls">
                                        <input class="input-mini" name="nbr_adultes" type="text" id="nbr_adultes" value="<?php
                if (isset($val_res['nbr_adultes'])) {
                    echo $val_res['nbr_adultes'];
                }
                ?>"  />
                                    </div>
                                                    
                                </div>
                                                
                                                
                                <div class="control-group">
                                    <label class="control-label"  for="nbr_enfants_2_13"> Enfants 2 &agrave; 13 ans</label>
                                    <div class="controls"><input class="input-mini" name="nbr_enfants_2_13" type="text" id="nbr_enfants_2_13" value="<?php
                if (isset($val_res['nbr_enfants_2_13'])) {
                    echo $val_res['nbr_enfants_2_13'];
                }
                    ?>"  />
                                    </div>
                                </div>
                                                
                                                
                                <div class="control-group">
                                    <label class="control-label" style ="width:150px;" for="nbr_enfants_inf_2">Enfant moins de 2 ans</label>
                                    <div class="controls"><input class="input-mini" name="nbr_enfants_inf_2" type="text" id="nbr_enfants_inf_2" value="<?php
                            if (isset($val_res['nbr_enfants_inf_2'])) {
                                echo $val_res['nbr_enfants_inf_2'];
                            }
                            ?>"  />
                                    </div>
                                </div>                     
                                                
                                <div class="row">
                                    <div class="span3">Personne(s) &agrave; mobilit&eacute; r&eacute;duite ?</div>
                                    <div class="span2"> 
                                        <label class="radio">oui <input type="radio" name="pmr" value="1" <?php
                            if ($val_res['pmr'] == '1') {
                                print 'checked="checked"';
                            }
                    ?>/></label>
                                            
                                        <label class="radio">non<input name="pmr" type="radio" value="0"  <?php
                            if (@$_POST['pmr'] != '1') {
                                print 'checked="checked"';
                            }
                            ?> /></label></div>
                                </div>   
                                              
                            </div><!--              fin span 6-->
                
           </div><!--   fin row-->

             <textarea name="commentaire_reserv" rows="3" wrap="VIRTUAL"><?php echo $val_res['commentaire_reserv'] ;?></textarea>

             <div class="form-actions" style ="text-align:center;">
                     <input name="ID_reserv" type="hidden" id="ID_reserv" value ="<?php echo $val_res['ID_reserv']; ?>" />
                     <input type="submit" class="btn btn-primary btn-large span6" name="envoyer" value="Enregistrer les modifications / fermer" />
             </div>



            <?php ;
        } 
        // on ferme la connexion à mysql
        mysql_close();
        ?>
        </form>
           </div> <!--   fin de div container-->
    </body>
</html>