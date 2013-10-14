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
	$commentaire_locataire = mysql_real_escape_string($_POST['commentaire_locataire']);
	$date_enreg = date("Y-m-d"); 

	 
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


 	if(!isset($erreur)){
		// il n'y a pas d'erreur dans la saisie du formulaire on va insérer les données clients et les dates dans la base
		mysql_query("INSERT INTO $T_locataires VALUES ('', '$titre', '$nom_locataire', '$prenom', '$rue', '$codepostal', '$ville', '$pays', '$tel', '$tel_portable', '$email', '$commentaire_locataire','0','$date_enreg')") or die(mysql_error());
	}
} // fin if ($_POST)
?>
<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>Formulaire ajout locataire</title>
            <!-- css génériques -->
            <link href="inc/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" >
            <link href="style_reserv.css" rel="stylesheet" type="text/css" >

            <!-- js boostrap et j query -->    
            <script  src="inc/bootstrap/jquery.min.js" type="text/javascript"></script>
            <script  src="inc/bootstrap/js/bootstrap.js" type="text/javascript"></script>
            
            
            <!-- js spécifique (date etc.) -->    
            <script src="inc/fonc.js" type="text/javascript"></script>
    
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
                width:500px;
            }
    
            textarea{
                width: 380px;
        
            }
            </style>
</head>
<body>
    <div class="container">
    <h2 class="titre">Ajouter un locataire</h2>
        <?php if ($_POST) { ?>
            <?php
            if (isset($erreur)) {
                echo "<div class=\"alert alert-error\">$erreur</div>"; // affichage du message d'erreur dans la saisie du formulaire
            } else {
                echo "<div class=\"alert alert-success\">Le locataire a été enregistré</div>";
            }
            ?>
                                
        <?php } // fin if ($_POST)
        ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="form-horizontal">

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
                        <h4>Erreur !</h4>Merci d'indiquer un Titre.</div>
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
    
            <textarea  rows="3" name="commentaire_locataire" ><?php if ($_POST) {
                            echo htmlentities(@$_POST['commentaire_locataire'], ENT_QUOTES);
                        } else {
                            echo "Commentaire locataire";
                        } ?></textarea>
        
        
                <div class="form-actions" style ="text-align:center;">
                <input type="submit" class="btn btn-primary btn-large" name="envoyer" value="Enregistrer / fermer" />
                <br/>* Renseigner soit l'email soit un des t&eacute;l&eacute;phones<br/>
                </div>
        </form>
    <p>&nbsp;</p>
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
             
        })
        $(' .alert .close').live('click',function(){
            $(this).parent().slideUp();
            return false;
        })   
    });
</script>