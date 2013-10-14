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
    <title>Saisir fiche locataire</title>
            <!-- css génériques -->
            <link href="inc/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" >
            <link href="style_reserv.css" rel="stylesheet" type="text/css" >

            <!-- js boostrap et j query -->    
            <script  src="inc/bootstrap/jquery.min.js" type="text/javascript"></script>
            <script  src="inc/bootstrap/js/bootstrap.js" type="text/javascript"></script>
            
            <!-- js spécifique (date etc.) -->    
            <script src="inc/fonc.js" type="text/javascript"></script>
    
            <style type="text/css">
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
            <?php
            // si le formulaire a été posté alors on update le locataire
            if ($_POST) {
                $ID_locataire = intval($_POST['ID_locataire']);
                $titre = mysql_real_escape_string($_POST['titre']);
                $nom_locataire = mysql_real_escape_string($_POST['nom_locataire']);
                $prenom = mysql_real_escape_string($_POST['prenom']);
                $rue = mysql_real_escape_string($_POST['rue']);
                $codepostal = mysql_real_escape_string($_POST['codepostal']);
                $ville = mysql_real_escape_string($_POST['ville']);
                $pays = mysql_real_escape_string($_POST['pays']);
                $tel = mysql_real_escape_string($_POST['tel']);
                $tel_portable = mysql_real_escape_string($_POST['tel_portable']);
                $email = mysql_real_escape_string($_POST['email']);
                $commentaires = mysql_real_escape_string($_POST['commentaires']);
                $nbr_sejour = intval($_POST['nbr_sejour']);

                mysql_query("UPDATE $T_locataires SET titre ='$titre', nom_locataire='$nom_locataire', prenom='$prenom', rue='$rue', codepostal='$codepostal', ville='$ville', pays='$pays', tel='$tel', tel_portable='$tel_portable', email='$email', commentaires='$commentaires', nbr_sejour='$nbr_sejour' WHERE ID_locataire=$ID_locataire") or die("erreur requète update locataire");
                print'<div class = "alert alert-success">La fiche du locataire a été mise à jour</div>';
                // fonction "save and close"
                print'<script>
	javascript:refreshParent()
	javascript:window.close()
	</script>';
            } else {
                $ID_locataire = intval($_GET['ID_locataire']);
            }
            // sinon affichage des informations du locataire (la page est demandé à partir de la liste des réservations)
            $req = ("SELECT * FROM $T_locataires WHERE ID_locataire=$ID_locataire") or die("erreur requete 1");
            $result = mysql_query($req);
            while ($val = mysql_fetch_array($result)) {
                ?>
                <h2 class="titre"> Fiche locataires</h2>  
               <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="form-horizontal">
                  <div id="div_titre" class="control-group">
                        <label class="control-label">Titre </label>
                        <div class="controls">
                            <select class="input-medium" name="titre" id="titre">
                                <option value="" >choix</option>
                                <option value="Mme"<?php
            if ($val['titre'] === 'Mme') {
                echo 'selected=\"selected\"';
            }
                ?>
                                        >Madame</option>
                                <option value="Mr"<?php
                            if ($val['titre'] === 'Mr') {
                                echo 'selected=\"selected\"';
                            }
                ?>>Monsieur</option>
                                <option value="Mlle"<?php
                                    if ($val['titre'] == 'Mlle') {
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
                            <input class="input-" name="prenom" type="text"  id="prenom" value="<?php echo $val['prenom']; ?>" /> 
                            <div id="prenom_alerte" class="alert alert-error hide">
                                <h4 class="alert-heading">Erreur !</h4>Merci d'indiquer un Prénom.</div>
                        </div>
                    </div>
         
                    <div ID="div_nom_locataire" class="control-group">
                        <label class="control-label">NOM</label> 
                        <div class="controls">
                            <input name="nom_locataire" type="text" id="nom_locataire" value="<?php echo $val['nom_locataire']; ?>"/>
                            <div id="nom_locataire_alerte" class="alert alert-error hide">
                                <h4>Erreur !</h4>Merci d'indiquer un Nom.</div>
                        </div>
                    </div>

                    <div ID="div_rue" class="control-group">
                        <label class="control-label"> Adresse</label>  
                        <div class="controls">
                            <input name="rue" type="text" id="rue" value="<?php echo $val['rue']; ?>" /> 
                            <div id="rue_alerte" class="alert alert-error hide">
                            <h4>Erreur !</h4>Merci d'indiquer une Adresse.</div>
                        </div>
                    </div>
           
                    <div ID="div_code_postal" class="control-group">
                        <label class="control-label"> Code postal </label> 
                        <div class="controls">
                            <input class="input-small" name="codepostal" type="text" id="codepostal" value="<?php echo $val['codepostal']; ?>" />
                            <div id="code_postal_alerte" class="alert alert-error hide">
                                <h4>Erreur !</h4>Merci d'indiquer un code postal.</div>
                        </div>
                    </div>

                    <div ID="div_ville" class="control-group">
                        <label class="control-label">Ville </label> 
                        <div class="controls">
                            <input name="ville" type="text" id="ville" value="<?php echo $val['ville']; ?>"  /> 
                            <div id="ville_alerte" class="alert alert-error hide">
                                <h4>Erreur !</h4>Merci d'indiquer une Adresse.</div>
                        </div>
                    </div>

                    <div ID="div_pays" class="control-group">
                        <label class="control-label"> Pays</label>  
                        <div class="controls"> 
                            <input name="pays" type="text" id="pays" value="<?php echo $val['pays']; ?>"/>
                            <div id="pays_alerte" class="alert alert-error hide">
                                <h4>Erreur !</h4>Merci d'indiquer un Pays.</div> 
                        </div>
                    </div>
        
                    <div class="control-group">
                        <label class="control-label"> T&eacute;l&eacute;phone*</label> 
                        <div class="controls">
                            <input name="tel" type="tel"  id="tel" value="<?php echo $val['tel']; ?>" /> </div>
                    </div>
        
                    <div class="control-group">
                        <label class="control-label"> Mobile *</label> 
                        <div class="controls">
                            <input name="tel_portable" type="tel"  id="tel_portable" value="<?php echo $val['tel_portable']; ?>" /> </div>
                    </div> 
          
                    <div ID="div_email" class="control-group">
                        <label class="control-label"> Email*</label> 
                        <div class="controls">
                            <input name="email" type="email"  id="email" value="<?php echo $val['email']; ?>" /> 
                        </div>
                    </div>
                    <div ID="div_email" class="control-group">
                        <label class="control-label"> Le client est venu</label> 
                        <div class="controls">
                            <input class="input-mini" name="nbr_sejour" type="text" id="nbr_sejour" value="<?php echo $val['nbr_sejour']; ?>" size="3">&nbsp;fois
                        </div>
                    </div> 
                    <textarea  rows="3" name="commentaire_locataire" ><?php echo $val['commentaires']; ?></textarea>
                    <br/>

        
                    <div style ="text-align:center;">
                        <a href="formulaire_reserv_loueur_client_connu.php?ID_locataire=<?php echo $val['ID_locataire']; ?>">Entrer une r&eacute;servation 
                            pour ce locataire</a>
                    </div>
        
                    <div class="form-actions" style ="text-align:center;">
                        <input name="ID_locataire" type="hidden" id="ID_locataire" value ="<?php echo $val['ID_locataire']; ?>">
                            <input type="submit" class="btn btn-primary btn-large" name="Submit2" value="Enregistrer les modifications / fermer" />
                    <br/>* Renseigner soit l'email soit un des t&eacute;l&eacute;phones<br/>
            
            </div>
        </form> 
        <?php

        }
    // on ferme la connexion à mysql
        mysql_close();
        ?>
    
    
    </div> <!--   fin de div container-->
</body>
</html>
<script type="text/javascript" >
// permet de gérer les erreurs (uniquement champs vides) 
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