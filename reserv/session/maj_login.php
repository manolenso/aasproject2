<?php 
// -----------------------------------------
// Source  :	http://cogites.com
// Script  :	E RESERV
// Version :	5
// revente et redistribution interdites 
// Vous devez laisser le copyright.
// -----------------------------------------
session_start() ;

?>
<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Mettre &agrave; jour votre mot de passe</title>
            <!-- css g�n�riques -->
            <link href="../inc/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" >
            <link href="../style_reserv.css" rel="stylesheet" type="text/css" >

            <!-- js boostrap et j query -->    
            <script  src="../inc/bootstrap/jquery.min.js" type="text/javascript"></script>
            <script  src="../inc/bootstrap/js/bootstrap.js" type="text/javascript"></script>
            
            <!-- js sp�cifique (date etc.) -->    
            <script src="../inc/fonc.js" type="text/javascript"></script>
</head>
<body>
    <div class="container">
        <?php
        if ($_SESSION["login_admin"] == true) {
            if ($_POST) {
                if ($_POST["login_admin"] != "" && $_POST["mot_de_passe_admin"] != "" && $_POST["mot_de_passe_admin"] == $_POST["mot_de_passe_admin_2"]) {
                    $login_admin = $_POST["login_admin"];
                    $pass_admin = md5($_POST["mot_de_passe_admin"]);

                    //connexion au serveur
                    include("../inc/conec.php");

                    //cr�ation de la requ�te SQL de maj
                    $sql = "UPDATE $T_admin SET pass_admin='$pass_admin', login_admin='$login_admin' WHERE ID_admin='1'";

                    //ex�cution de la requ�te SQL
                    $requete = @mysql_query($sql) or die($sql . "<br>" . mysql_error());

                    //si la requ�te s'est bien pass�, on affiche un message de succ�s
                    if ($requete) {
                        ?>
                    
                        <div class="alert alert-success">La mise � jour s'est bien pass�e <a href="login.php">se connecter</a></div>
                        <?php
                    } //fin maj ok
                } // fin post ok
                else {
                    echo "<div class = \"alert alert-error\"> Soit vous n'avez rien saisie soit la r�p�tition du mot de passe est incorrecte</div>";
                }
            } // fin post
            ?>
        
            <h2 class="titre" >Mettre &agrave; jour votre mot de passe</h2>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="form-horizontal" style ="width:450px;">
                <div class="control-group">
                    <label class="control-label">login</label>
                    <div class="controls">
                        <input name="login_admin" type="text" id="login_admin" value="<?php echo $_SESSION["login_admin"]; ?>" /> 
                    </div>
                </div>
                  
                <div class="control-group">
                    <label class="control-label" style ="width:150px;">nouveau mot de passe</label>
                    <div class="controls">
                        <input name="mot_de_passe_admin" type="password" id="mot_de_passe_admin" />
                    </div>
                </div>
                  
                <div class="control-group">
                    <label class="control-label" style="width:150px;">r&eacute;p&eacute;ter le nouveau mot de passe</label>
                    <div class="controls">
                        <input name="mot_de_passe_admin_2" type="password" id="mot_de_passe_admin_2" />
                    </div>
                </div>
                  
                <div class="form-actions">
                    <input class="btn btn-primary btn-large" type="submit" name="Submit" value="Envoyer">
                </div>
                  
            </form>
           <p>Retourner &agrave; la <a href="../config.php">page de configuration</a></p>
        </div> <!--   fin de div container-->  
</body>
</html>
<?php
} // fin session
?>
