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
    <title>Gestion des locations</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
   
            <!-- css génériques -->
            <link href="inc/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" >
            <link href="style_reserv.css" rel="stylesheet" type="text/css" >

            <!-- js boostrap et j query -->    
            <script  src="inc/bootstrap/jquery.min.js" type="text/javascript"></script>
            <script  src="inc/bootstrap/js/bootstrap.js" type="text/javascript"></script>
            
            
            <!-- js spécifique (date etc.) -->    
            <script src="inc/fonc.js" type="text/javascript"></script>
            
            <!-- un clic sur la croix referme l'alerte -->    
            <script type="text/javascript" >
                    $(function(){
                            $(' .alert .close').live('click',function(){
                                $(this).parent().slideUp();
                                return false;
                            })   
                        });
                </script>
</head>
<body>
    <div class="container">
        <?php include ('inc/menu_reserv.php'); ?>
        <h2 class="titre">Gestion des locations<img src="img/locations.png" width="48" height="48" /></h2>
        <h3>Liste des locations : </h3>
        <?php
        // on affiche la liste des locations
        $req = mysql_query("SELECT * from $T_locations ORDER BY nom_location") or die("erreur requete");
        if (mysql_num_rows($req) == 0) {
            ?>
            <div class="alert alert-error">
                <a href="#" class="close">x</a>
                Au moins une location doit être enregistrée pour que la page d'administration fonctionne
            </div>
            <?php
        } while ($contenu = mysql_fetch_array($req)) {

            print'<div class="row">
                    <div class="span8">
                        <form method="POST" action="maj_location.php" class="form-inline" >
                            <input type="hidden" name="ID_location" value="' . $contenu["ID_location"] . '">
                            <input name="nom_location"  type="text"  id="nom_location" value="' . $contenu["nom_location"] . '">
                            <input name="description" type="text" id="description" value="' . $contenu["description"] . '" >
                            <button class="btn btn-warning" name="Submit" type="submit">Modifier <i class="icon-white icon-pencil"></i></button>                                       
                        </form>
                     </div>
                                  
                     <div class="span4">
			<form method="POST" action="sup_location.php" class="form-inline" onsubmit="return verif_form()">
				<input type="hidden" name="ID_location" value="' . $contenu["ID_location"] . '">
                                <button class="btn btn-danger" name="Submit2"type="submit">Supprimer <i class="icon-white icon-trash"></i></button>    
                        </form>
                     </div>
		</div>';
        }
        // on ferme la connexion à mysql
        mysql_close();
        ?>
         <div class="well">
            <fieldset>
                <legend>
                    Pour ajouter une location entrez son nom (la description est en option)
                </legend>
                <form method="post" action="ajout_location.php">
                    <div class="control-group">
                        <label class="control-label" for="nom location">Nom de la location</label>
                        <div class="control input-prepend">
                            <span class="add-on"><i class="icon-home"  ></i></span>
                            <input type="text"  name="nom_location" class="input-large span7"  placeholder="Nom de la location" >
                        </div>
                    </div>  
                       
                    <div class="control-group">
                        <label class="control-label" for="description">Description </label>
                        <div class="controls">
                            <textarea rows="3"  name="description" class="input-xxlarge span8" id="textarea" >255 caractères maximum</textarea>
                        </div>
                    </div>  

                    <input type="submit"  value="Ajouter" class="btn btn-primary btn-large span5">
                </form>
            </fieldset >
        </div>
        <?php
        include ("inc/copy.php");
        ?>
    </div>
    <!--   fin de div container-->
</body>
</html>