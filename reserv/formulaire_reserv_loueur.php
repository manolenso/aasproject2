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
include ("inc/conec.php");
if ($_POST) { 

	// on récupère les variables et on filtre / injection sql
    $ID_location = mysql_real_escape_string($_POST['ID_location']);
	$titre = mysql_real_escape_string($_POST['titre']);
	$nom_locataire = mysql_real_escape_string($_POST['nom_locataire']);
	$prenom = mysql_real_escape_string($_POST['prenom']);
	$rue = mysql_real_escape_string($_POST['rue']);
	$ville = mysql_real_escape_string($_POST['ville']);
	$codepostal = mysql_real_escape_string($_POST['codepostal']);
	$rue = mysql_real_escape_string($_POST['rue']);
	$pays = mysql_real_escape_string($_POST['pays']);
	$tel = mysql_real_escape_string($_POST['tel']);
	$tel_portable = mysql_real_escape_string($_POST['tel_portable']);
	$email = mysql_real_escape_string($_POST['email']);
	$commentaire_reserv = mysql_real_escape_string($_POST['commentaire_reserv']);
	$commentaire_locataire = mysql_real_escape_string($_POST['commentaire_locataire']);
 	$prix = mysql_real_escape_string($_POST['prix']);
//        $prix = floatval($_POST['prix']);
	$datedeb = mysql_real_escape_string($_POST['datedeb']);
	$datefin = mysql_real_escape_string($_POST['datefin']);
	$date_enreg = date("Y-m-d"); 

	// autres variables
	$nbr_adultes = floatval($_POST['nbr_adultes']);
	$nbr_enfants_2_13 = floatval($_POST['nbr_enfants_2_13']);
	$nbr_enfants_inf_2 = floatval($_POST['nbr_enfants_inf_2']);	
	$pmr = floatval($_POST['pmr']);
	
	 
	// contrôle des dates impossibles : champs vide et la fin avant le début
	include("inc/func.dates.php"); 	 
	// date française en date anglaise
	$datedeb = fran_angl($datedeb);
	$datefin = fran_angl($datefin);
	
	$erreur = ctrl_date($datedeb, $datefin);
			
	// contrôle des dates impossibles : recouvrement des périodes
	if (is_dir('suivi')){// si module suivi AND ($T_reserv.etat_reserv=2)
	$req = mysql_query("SELECT * from $T_reserv WHERE ID_location=$ID_location AND
	(
		('$datedeb' >= datedeb AND '$datedeb' < datefin)
		 OR
		 ('$datefin' > datedeb AND '$datefin' <= datefin)
		 OR
		 ('$datedeb' < datedeb) AND (datedeb < '$datefin')
		OR
		('$datedeb' = datedeb) AND (datefin = '$datefin')
		OR ('$datedeb' = datedeb)
	)
		AND ($T_reserv.etat_reserv=2)
	 ") or die ("erreur requete recouvrement date");
	}
	else{
		$req = mysql_query("SELECT * from $T_reserv WHERE ID_location=$ID_location AND
		(
			('$datedeb' >= datedeb AND '$datedeb' < datefin)
			 OR
			 ('$datefin' > datedeb AND '$datefin' <= datefin)
			 OR
			 ('$datedeb' < datedeb) AND (datedeb < '$datefin')
			OR
			('$datedeb' = datedeb) AND (datefin = '$datefin')
			OR ('$datedeb' = datedeb)
		)
		 ") or die ("erreur requete recouvrement date");
 	}
	$contenu = mysql_fetch_array ($req);
	if (!empty($contenu)) {
		$erreur ='!!! ERREUR !!! <br/><br/>La période proposée recouvre une période déjà enregistrée';
	}

	// gestion des champs vides ou mal complétés
	if (empty($titre)) {
      $erreur = "Merci de renseigner le champ titre";
   	}
   	elseif (empty($nom_locataire)) {
      $erreur = "Merci de renseigner le champ nom";
   	}
   	elseif (empty($_POST['prenom'])) {
      $erreur = "Merci de renseigner le champ prénom";
   	}
	elseif (empty($_POST['ville'])) {
      $erreur = "Merci de renseigner le champ ville";
   	}
	elseif (empty($_POST['codepostal'])) {
      $erreur = "Merci de renseigner le champ code postal";
   	}
	elseif (empty($_POST['pays'])) {
      $erreur = "Merci de renseigner le champ pays";
   	}
	elseif (empty($_POST['tel']) && empty($_POST['tel_portable']) && empty($_POST['email'])) {
      $erreur = "Merci de renseigner soit le champ email soit un des champs téléphones";
	}
	elseif(preg_match("#[[:alpha:]]+$#", $tel)){	// le tel ne peut contenir de lettre
	  $erreur = "Le champ numéro de téléphone ne peut contenir de lettres";
	}
	elseif(preg_match("#[[:alpha:]]+$#", $tel_portable)){	// le tel portable ne peut contenir de lettre
	  $erreur = "Le champ numéro de téléphone portable ne peut contenir de lettres";
	}
	elseif ((!empty($_POST['email'])) && (!preg_match('`^[[:alnum:]]([-_.]?[[:alnum:]])*@[[:alnum:]]([-_.]?[[:alnum:]])*\.([a-z]{2,4})$`',$_POST['email']))){
	    $erreur = "Le champ  email semble non conforme";
		// différente vérification de composition d'email
	} 
	// gestion des champs vides ou mal complétés
	elseif (empty($_POST['prix']) && ($_POST['prix']!=0)) { // le prix peut être à zéro
      $erreur = "Merci de renseigner le champ prix";
   	}
        elseif(preg_match("#[[:alpha:]]+$#", $prix)){	// le prix ne peut contenir de lettre
	  $erreur = "Le champ de prix ne peut contenir de lettres";
	}

	elseif(empty($_POST['ID_location'])){
		$erreur = "Vous devez choisir une location.";
	}	
	
	
	
	// autres tests
	elseif (empty($_POST['nbr_adultes']) || !is_numeric($_POST['nbr_adultes']) || ($_POST['nbr_adultes']==0)) {
      $erreur = "Merci de renseigner le nombre d'adultes";
   	}
	elseif (empty($_POST['nbr_enfants_2_13']) && !is_numeric($_POST['nbr_enfants_2_13'])) {
      $erreur = "Merci de renseigner le nombre d'enfants de 2 à 13 ans";
   	}
	elseif (empty($_POST['nbr_enfants_inf_2']) && !is_numeric($_POST['nbr_enfants_inf_2'])) {
      $erreur = "Merci de renseigner le nombre d'enfants de moins de 2 ans";
   	}

	elseif (empty($_POST['pmr']) && ($_POST['pmr'] !=0) ) {
      $erreur = "Merci de d'indiquer la présence de personne(s) à mobilité réduite";
   	}

 	if(!isset($erreur)){
		if (is_dir('suivi')){ // module suivi nbr_sejour = 0
		// il n'y a pas d'erreur dans la saisie du formulaire on va insérer les données clients et les dates dans la base
		mysql_query("INSERT INTO $T_locataires VALUES ('', '$titre', '$nom_locataire', '$prenom', '$rue', '$codepostal', '$ville', '$pays', '$tel', '$tel_portable', '$email', '$commentaire_locataire','0','$date_enreg')") or die(mysql_error());
		}
		else{		
		mysql_query("INSERT INTO $T_locataires VALUES ('', '$titre', '$nom_locataire', '$prenom', '$rue', '$codepostal', '$ville', '$pays', '$tel', '$tel_portable', '$email', '$commentaire_locataire','1','$date_enreg')") or die(mysql_error());
		}
		$locataire_req = mysql_query("SELECT ID_locataire FROM $T_locataires ORDER BY ID_locataire DESC") or die ("erreur chch ID_client");
		$ID_locataire = mysql_result($locataire_req, 0); 
		if (is_dir('suivi')){ // module suivi alors on ajoute '0','' pour l'état de la réservation et la date d'envoie du contrat
		mysql_query("INSERT INTO $T_reserv VALUES ('', '$ID_location', '$ID_locataire', '$datedeb', '$datefin', '$date_enreg', '$prix', '$commentaire_reserv', '$nbr_adultes', '$nbr_enfants_inf_2', '$nbr_enfants_2_13', '$pmr','0','')")or die ("erreur requète ad_reservation");
		}
		else{
		mysql_query("INSERT INTO $T_reserv VALUES ('', '$ID_location', '$ID_locataire', '$datedeb', '$datefin', '$date_enreg', '$prix', '$commentaire_reserv', '$nbr_adultes', '$nbr_enfants_inf_2', '$nbr_enfants_2_13', '$pmr')")or die ("erreur requète ad_reservation");
		}
	}
} // fin if ($_POST)
?>
<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <title>Formulaire r&eacute;servation - loueur</title>
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
                 h1{ /* Le titre  */
                  margin-left: auto;
                  margin-right: auto;
      
                  color: #000;
                  font-size: 22px;
                  font-style: normal;
                  font-weight: normal;
                  text-transform: normal;
                  letter-spacing: -1.1px;
                  line-height: 1.2em;
                  padding: 2px;
                  border-bottom: 1px solid #CCC;
                }
                .container{
                    margin-left: 20px; 
                    margin-top: -50px; 
                }
                textarea{
                    width: 380px;
                }
                </style>
</head>
<body>
    <div class="container">
        <?php
        if ($_POST) {
            if (isset($erreur)) {
                echo "<div class=\"alert alert-error\">$erreur</div>"; // affichage du message d'erreur dans la saisie du formulaire
            } else {
                echo "<div class=\"alert alert-success\">La réservation et le locataire ont été enregistré</div>";
                // fonction on enregistre, on ferme et on actualise la page
                print'<script>
	javascript:refreshParent()
	javascript:window.close()
	</script>';
            }
        } // fin if ($_POST)
        ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="form-horizontal">
                <div class="well" style ="text-align:center;">  Choisissez votre location 
                <select name="ID_location" id="nom_location">
                    <?php
                    // menu des locations
                    $query = "SELECT ID_location, nom_location FROM $T_locations ORDER BY nom_location";
                    $result = mysql_query($query) or die(mysql_error());
                    while ($val = mysql_fetch_array($result)) {
                        print'<option value="' . $val['ID_location'] . '">' . $val['nom_location'] . '</option>';
                    }
                    ?>
                </select>
                &nbsp;
                <a href="formulaire_reserv_loueur_client_connu.php">Si le client est d&eacute;j&agrave; 
                    connu =&gt;</a>
            </div>
    
            <div class="row-fluid">
                    <div class="span6">
                        <div id="div_titre" class="control-group">
                        <label class="control-label">Titre </label>
                            <div class="controls">
                            <select class="input-medium" name="titre" id="titre">
                                <option value="" >choix</option>
                                <option value="Mme"<?php
                                if (( isset($_POST['titre']) && $_POST['titre'] == 'Mme' ) || ( isset($titre) && ($titre == 'Mme') )) {
                                    echo 'selected=\"selected\"';
                                }
                                ?>
                                        >Madame</option>
                                <option value="Mr"<?php
                                if (( isset($_POST['titre']) && $_POST['titre'] == 'Mr' ) || ( isset($titre) && ($titre == 'Mr') )) {
                                    echo 'selected=\"selected\"';
                                }
                                ?>>Monsieur</option>
                                <option value="Mlle"<?php
                                        if (( isset($_POST['titre']) && $_POST['titre'] == 'Mlle' ) || ( isset($titre) && ($titre == 'Mlle') )) {
                                            echo 'selected=\"selected\"';
                                        }
                                 ?>>Mademoiselle</option>
                             </select>
                            <div id="titre_alerte" class="alert alert-error hide">
                                <h4>Erreur !</h4>Merci d'indiquer un Titre.
                            </div>
                        </div> 
                    </div>
                    <div ID="div_prenom" class="control-group">
                        <label class="control-label">Pr&eacute;nom</label> 
                        <div class="controls">
                            <input class="input-" name="prenom" type="text"  id="prenom" value="<?php echo htmlentities(@$_POST['prenom'], ENT_QUOTES) ?>" /> 
                            <div id="prenom_alerte" class="alert alert-error hide">
                                <h4 class="alert-heading">Erreur !</h4>Merci d'indiquer un Prénom.</div>
                
                        </div>
                    </div>
     
                    <div ID="div_nom_locataire" class="control-group">
                        <label class="control-label">NOM</label> 
                        <div class="controls">
                            <input name="nom_locataire" type="text" id="nom_locataire" value="<?php echo htmlentities(@$_POST['nom_locataire'], ENT_QUOTES) ?>"/>
                            <div id="nom_locataire_alerte" class="alert alert-error hide">
                                <h4>Erreur !</h4>Merci d'indiquer un Nom.</div>
                        </div>
                    </div>

                    <div ID="div_rue" class="control-group">
                        <label class="control-label"> Adresse</label>  
                        <div class="controls">
                            <input name="rue" type="text" id="rue" value="<?php echo htmlentities(@$_POST['rue'], ENT_QUOTES) ?>" /> 
                            <div id="rue_alerte" class="alert alert-error hide">
                            <h4>Erreur !</h4>Merci d'indiquer une Adresse.</div>
                        </div>
                    </div>
       
                    <div ID="div_code_postal" class="control-group">
                        <label class="control-label"> Code postal </label> 
                        <div class="controls">
                            <input class="input-small" name="codepostal" type="text" id="codepostal" value="<?php echo htmlentities(@$_POST['codepostal'], ENT_QUOTES) ?>" />
                            <div id="code_postal_alerte" class="alert alert-error hide">
                                <h4>Erreur !</h4>Merci d'indiquer un code postal.</div>
                        </div>
                    </div>

                    <div ID="div_ville" class="control-group">
                        <label class="control-label">Ville </label> 
                        <div class="controls">
                            <input name="ville" type="text" id="ville" value="<?php echo htmlentities(@$_POST['ville'], ENT_QUOTES) ?>"  /> 
                            <div id="ville_alerte" class="alert alert-error hide">
                                <h4>Erreur !</h4>Merci d'indiquer une Adresse.</div>
                        </div>
                    </div>

                    <div ID="div_pays" class="control-group">
                        <label class="control-label"> Pays</label>  
                        <div class="controls"> 
                            <input name="pays" type="text" id="pays" value="<?php echo htmlentities(@$_POST['pays'], ENT_QUOTES) ?>"/>
                            <div id="pays_alerte" class="alert alert-error hide">
                                <h4>Erreur !</h4>Merci d'indiquer un Pays.</div> 
                        </div>
                    </div>
    
                    <div class="control-group">
                        <label class="control-label"> T&eacute;l&eacute;phone*</label> 
                        <div class="controls">
                            <input name="tel" type="tel"  id="tel" value="<?php echo htmlentities(@$_POST['tel'], ENT_QUOTES) ?>" /> </div>
                    </div>
    
                    <div class="control-group">
                        <label class="control-label"> Mobile *</label> 
                        <div class="controls">
                            <input name="tel_portable" type="tel"  id="tel_portable" value="<?php echo htmlentities(@$_POST['tel_portable'], ENT_QUOTES) ?>" /> </div>
                    </div> 
      
                    <div ID="div_email" class="control-group">
                        <label class="control-label"> Email*</label> 
                        <div class="controls">
                            <input name="email" type="email"  id="email" value="<?php echo htmlentities(@$_POST['email'], ENT_QUOTES) ?>" /> 
                        </div>
                    </div>
    
                    <div ID="div_prix" class="control-group">
                        <label class="control-label"><strong> Prix</strong></label> 
                        <div class="controls">
                            <input class="input-mini" name="prix" type="text"  id="prix" value="<?php echo htmlentities(@$_POST['prix'], ENT_QUOTES) ?>" /> 
                        </div>
                    </div>
    
                    <!--        fin de span 6 coordonnées-->
                </div>
                    <div class="span6">
                        <div ID="div_nbr_adultes" class="control-group">
                        <label  class="control-label" for="nbr_adultes">Nombre d'adultes**</label>
                        <div class="controls">
                            <input class="input-mini" name="nbr_adultes" type="text" id="nbr_adultes" value="<?php if ($_POST) {
                                            echo htmlentities(@$_POST['nbr_adultes'], ENT_QUOTES);
                                        } else {
                                            echo '0';
                                        } ?>"  />
                        </div>
                        <div id="nbr_adultes_alerte" class="alert alert-error hide">
                            <h4>Erreur !</h4>Merci d'indiquer un nombre d'adultes.</div>
                    </div>
                         <div class="control-group">
                        <label class="control-label"  for="nbr_enfants_2_13"> Enfants 2 &agrave; 13 ans</label>
                        <div class="controls"><input class="input-mini" name="nbr_enfants_2_13" type="text" id="nbr_enfants_2_13" value="<?php if ($_POST) {
                                            echo htmlentities(@$_POST['nbr_enfants_2_13'], ENT_QUOTES);
                                        } else {
                                            echo '0';
                                        } ?>"  />
                        </div>
                    </div>
        
                    <div class="control-group">
                        <label class="control-label" style ="width:150px;" for="nbr_enfants_inf_2">Enfant moins de 2 ans</label>
                        <div class="controls"><input class="input-mini" name="nbr_enfants_inf_2" type="text" id="nbr_enfants_inf_2" value="<?php if ($_POST) {
                                            echo htmlentities(@$_POST['nbr_enfants_inf_2'], ENT_QUOTES);
                                        } else {
                                            echo '0';
                                        } ?>"  />
                        </div>
                    </div>
        
                    <div class="row">
                        <div class="span6">Personne(s) &agrave; mobilit&eacute; r&eacute;duite ?</div>
                        <div class="span2"> <label class="radio">oui <input type="radio" name="pmr" value="1" <?php if (@$_POST['pmr'] == '1') {
                                            print 'checked="checked"';
                                        } ?>/></label></div>
                        <div class="span2">  <label class="radio">non<input name="pmr" type="radio" value="0"  <?php if (@$_POST['pmr'] != '1') {
                                    print 'checked="checked"';
                                } ?> /></label></div>
                    </div>
            <p>&nbsp;</p>
         
                    <!-- début dates -->
                    <div ID="div_datedeb"  class="control-group">
                        <label class="control-label" >Date de d&eacute;but</label>
                        <div class="controls">
                            <div class="input-append"><input type="text" class="datepicker input-small" name="datedeb" id="date_deb" value="<?php
                                if ($_POST) {
                                    echo htmlentities(@$_POST['datedeb'], ENT_QUOTES);
                                } else {
                                    echo date("d-m-Y"); // date du jour
                                }
                    ?>" name="date_deb"  title="Cliquez ici pour afficher le calendrier"> <span class="add-on"><i class="icon-calendar"></i></span>
    
                            </div>
                        </div>
                        <div id="datedeb_alerte" class="alert alert-error hide">
                            <h4>Erreur !</h4>Merci d'indiquer une date de début.</div>
                    </div>

                    <div ID="div_datefin" class="control-group">
                        <label class="control-label" >Date de fin</label>
                        <div class="controls">
                            <div class="input-append"><input type="text" class="datepicker input-small" id="date_fin" value="<?php
                                if ($_POST) {
                                    echo htmlentities(@$_POST['datefin'], ENT_QUOTES);
                                } else {
                                    echo date('d-m-Y', strtotime('+7 day'));
                                }
                    ?>" name="datefin"  title="Cliquez ici pour afficher le calendrier"><span class="add-on"><i class="icon-calendar"></i></span>
                            </div>
                        </div>
                        <div id="datefin_alerte" class="alert alert-error hide">
                            <h4>Erreur !</h4>Merci d'indiquer une date de fin.</div>
                    </div>
                 <!-- fin dates -->
        
        
                    <textarea   rows="3" name="commentaire_reserv" ><?php if ($_POST) {
                        echo htmlentities(@$_POST['commentaire_reserv'], ENT_QUOTES);
                    } else {
                        echo "Commentaire réservation";
                    } ?></textarea>
                    <p>&nbsp;</p>
                    <textarea  rows="3" name="commentaire_locataire" ><?php if ($_POST) {
                        echo htmlentities(@$_POST['commentaire_locataire'], ENT_QUOTES);
                    } else {
                        echo "Commentaire locataire";
                    } ?></textarea>
         
                </div>    <!--        fin de span 6 fin du form-->
            </div>            <!--        fin de row formulaire-->
            <div class="form-actions" >
                <input type="submit" class="btn btn-primary btn-large span8" name="envoyer" value="Enregistrer / fermer" />
            </br>* Renseigner soit l'email soit un des t&eacute;l&eacute;phones<br/>
             ** Tout individu de plus de 13 ans
            </div>
        </form>        
      
    <div style ="text-align:center;">
    <a href="javascript:refreshParent()">Fermer la fen&ecirc;tre</a> </div>
          
    </div> <!--   fin de div container-->
</body>
</html>

<script type="text/javascript" >
    $(function(){
        $("form").on("submit", function(){
            if($("#titre option:selected").val()==""){
                $("#div_titre").addClass("error");
                $("#titre_alerte").show("slow").delay(3000).hide("slow");
                return false;
            }
            if($("#prenom").val()== ""){
                $("#div_prenom").addClass("error");
                $("#prenom_alerte").show("slow").delay(3000).hide("slow");
                return false;
            }
              
            if($("#nom_locataire").val()== ""){
                $("#div_nom_locataire").addClass("error");
                $("#nom_locataire_alerte").show("slow").delay(3000).hide("slow");
                return false;
            } 
            if($("#rue").val()== ""){
                $("#div_rue").addClass("error");
                $("#rue_alerte").show("slow").delay(3000).hide("slow");
                return false;
            }
            if($("#codepostal").val()== ""){
                $("#div_code_postal").addClass("error");
                $("#code_postal_alerte").show("slow").delay(3000).hide("slow");
                return false;
            } 
            if($("#ville").val()== ""){
                $("#div_ville").addClass("error");
                $("#ville_alerte").show("slow").delay(3000).hide("slow");
                return false;
            }
            if($("#pays").val()== ""){
                $("#div_pays").addClass("error");
                $("#pays_alerte").show("slow").delay(3000).hide("slow");
                return false;
            }
            if(($("#nbr_adultes").val()== "") || ($("#nbr_adultes").val()== "0") ){
                $("#div_nbr_adultes").addClass("error");
                $("#nbr_adultes_alerte").show("slow").delay(3000).hide("slow");
                return false;
            }
            if($("#datedeb").val()== ""){
                $("#div_datedeb").addClass("error");
                $("#datedeb_alerte").show("slow").delay(3000).hide("slow");
                return false;
            }
            if($("#datefin").val()== ""){
                $("#div_datefin").addClass("error");
                $("#datefin_alerte").show("slow").delay(3000).hide("slow");
                return false;
            }
            if($("#captcha").val()== ""){
                $("#div_captcha").addClass("error");
                $("#captcha_alerte").show("slow").delay(3000).hide("slow");
                return false;
            }         
        })       
        $(' .alert .close').live('click',function(){
            $(this).parent().slideUp();
            return false;
        })   
    });
</script>