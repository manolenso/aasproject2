<?php
// -----------------------------------------
// Source  :	http://cogites.com
// Script  :	E RESERV
// Version :	5
// revente et redistribution interdites 
// Vous devez laisser le copyright.
// -----------------------------------------
session_start();


if ($_POST) {
    if ($_POST["login_admin"] != "" && $_POST["mot_de_passe_admin"] != "") {
        $login_admin = $_POST["login_admin"];
        $pass_admin = md5($_POST["mot_de_passe_admin"]);

        //connexion au serveur
        include("../inc/conec.php");

        //création de la requête SQL
        $sql = "SELECT * FROM $T_admin WHERE login_admin = '" . $login_admin . "' AND pass_admin = '" . $pass_admin . "'";

        //exécution de la requête SQL
        $requete = @mysql_query($sql) or die($sql . "<br>" . mysql_error());
        //on récupère le résultat
        $result = mysql_fetch_object($requete);
        //si la requête s'est bien passée

        if (is_object($result)) {
            //enregistrement d'une variable de session, ici le login de l'utilisateur
            $_SESSION["login_admin"] = $login_admin;
            header("Location: ../index.php");
        }//fin if le login et le pass sont ok
        //sinon on retourne à la page d'inscription
        else {
            $erreur = 'login ou mot de passe incorrect';
        }
    }  //fin if quelque chose a été posté
    else {
        $erreur = 'login ou mot de passe incorrect';
    }
}//fin if _POST

?>
<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?" . ">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <title>E'reserv - Saisisez vos login et mot de pass</title>   
      
            <!-- css génériques -->
            <link href="../inc/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" >
   
            <!-- js boostrap et j query -->    
            <script  src="../inc/bootstrap/jquery.min.js" type="text/javascript"></script>
        
            <!-- js spécifique (date etc.) -->    
            <script src="../inc/fonc.js" type="text/javascript"></script>
                   
            <script type="text/javascript" >
                $(function(){
                    $(' .alert .close').live('click',function(){
                        $(this).parent().slideUp();
                        return false;
                    })   
                });
            </script>
                       
            <style type="text/css">
                .row {
                margin: auto; 
                margin-top: 100px;
                width: 350px;
                }
                .well{
                    box-shadow: 0 4px 10px -1px rgba(200, 200, 200, 0.7);
                }
                form input {
                padding: 3px;
                height: 40px;
                width:250px;
                font-size: 24px;
                font-weight: 200;
                           
                }
            </style>
            
</head>
<body onload="donner_focus('login_admin')">
    <div class="container">
        <div class="row"  >
            <img src="../img/<?php
            if (is_dir('../suivi')) { // test module suivi
                echo 'e_reserv_plus_big';
            } else {
                echo 'e_reserv_big';
            }
            ?>.jpg" width="350" height="151" />
                 <?php if (isset($erreur)) { ?>
                <div class="alert alert-error">
                    <a href="#" class="close">x</a>
                    <strong>Erreur : </strong><?php
                 echo $erreur;
                     ?> 
                </div>
            <?php } ?>
                            
            <form class="well" name="formulaire" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
                <legend>Saisisez login et mot de passe</legend>
                <div ID="div_login_admin" class="control-group">
                    <label class="control-label" for="login_admin" >Identifiant</label>
                    <div class="controls">
                        <input  style=" padding-left: 10px; height: 40px; width:250px; font-size: 24px; font-weight: 200;"type="text"  name="login_admin" type="text" id="login_admin" placeholder="Login" autofocus>
                    </div>
                    <div id="login_admin_alerte" class="alert alert-error hide">
                        <h4>Erreur !</h4>Merci d'indiquer un identifiant</div>
                </div>
                <div ID="div_mot_de_passe_admin" class="control-group">
                    <label class="control-label" for="mot_de_passe_admin">Mot de passe</label>
                    <div class="controls">
                        <input name="mot_de_passe_admin" type="password" style=" padding-left: 10px; height: 40px; width:250px; font-size: 24px; font-weight: 200;" id="mot_de_passe_admin" placeholder="Mot de passe">
                    </div>
                    <div id="mot_de_passe_admin_alerte" class="alert alert-error hide">
                        <h4>Erreur !</h4>Merci d'indiquer un mot de passe</div>
                </div>
                                
                <div class="control-group">
                        <div class="controls">
                                        
                        <button class="btn btn-large btn-primary" name="login"type="submit" style="width: 267px">Se connecter <i class="icon-white  icon-user"></i></button>    
                    </div>
                </div>
                <p>En cas d'oubli du mot de passe : <a href="passe_perdu.php">cliquer ici</a> 
            </form>
            <p>E'reserv, une solution <a href="http://cogites.com">cogites.com</a> 
            </p>
        </div>
    </div> <!--        fin de container-->
</body>
</html>

<script type="text/javascript" >
    $(function(){
        $("form").on("submit", function(){
            if($("#login_admin").val()== ""){
                $("#div_login_admin").addClass("error");
                $("#login_admin_alerte").show("slow").delay(3000).hide("slow");
                return false;
            }
            if($("#mot_de_passe_admin").val()== ""){
                $("#div_mot_de_passe_admin").addClass("error");
                $("#mot_de_passe_admin_alerte").show("slow").delay(3000).hide("slow");
                return false;
            }
        });  
        $(' .alert .close').live('click',function(){
            $(this).parent().slideUp();
            return false;
        }) 
    });
</script>



