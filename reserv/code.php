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
<title>Le code que vous devez ins&eacute;rer dans votre pages</title>

            <!-- css génériques -->
            <link href="inc/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" >
            <link href="style_reserv.css" rel="stylesheet" type="text/css" >

            <!-- js boostrap et j query -->    
            <script  src="inc/bootstrap/jquery.min.js" type="text/javascript"></script>
            <script  src="inc/bootstrap/js/bootstrap.js" type="text/javascript"></script>
            
            
            <!-- js spécifique (date etc.) -->    
            <script src="inc/fonc.js" type="text/javascript"></script>
    
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
    <?php include ('inc/menu_reserv.php'); ?>
    <div class="container">
        <h2 class="titre" >Le code à insérer dans vos pages</h2>
         
        <p  class="alert alert-info"><a href="#" class="close">x</a><strong>Attention : </strong>Vous devez choisir une location avant d'afficher 
        le code</p>
      
        <div class="well">
            <div style="text-align:center"> 
                <form class="form-inline" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
                    <select class="input-xlarge" id=select2 name=ID_location>
                        <option value="" selected>sélectionner une location</option>
                        <?php
                        // construction du menu des locations
                        $query = ("SELECT nom_location, ID_location FROM $T_locations") or die("erreur requete location");
                        $result = mysql_query($query);
                        while ($val = mysql_fetch_array($result)) {
                            print'<option value="' . $val['ID_location'] . '">' . $val['nom_location'] . '</option>';
                        }
                        ?>
                    </select>
                    <input type="submit" name="Submit" 	class="btn btn-primary" value="1. Afficher le code">
                </form>                
            </div>
            <p>&nbsp;</p>
            <div style="text-align:center">
                <form method="post" name="boite" >
                    <textarea class="input-xxlarge" rows="5" name="copier" ><a href="#"  onClick="window.open('reserv/cal/index.php?ID_location=<?php
                        if ($_POST) {
                            echo "$_POST[ID_location]";
                        } else {
                            echo 0;
                        }
                        ?>','_blank','toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=1000, height=1000, left=10, top=10');return(false)">Calendrier</a></textarea>
                    </br> 
                    <input type="button" style="width:450px;"class="btn btn-primary" value="2. s&eacute;lectionner le code" onClick="javascript:document.boite.copier.select();" name="button2">                      
                </form>
          
          
                <a href="#"  onClick="window.open('cal/index.php?ID_location=<?php
                        if ($_POST) {
                            echo "$_POST[ID_location]";
                        } else {
                            echo 0;
                        }
                        ?>','_blank','toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0, width=1000, height=1000, left=10, top=10');return(false)">Cliquez 
                    ici pour voir le calendrier demand&eacute; <img src="img/calendrier.gif" width="24" height="24" align="absmiddle" border="0" /></a> 
            </div>
        </div>
            
        <h4>Aide et personnalisation</h4>
       <ul>
            <li>On suppose que le script <strong>E reserv'</strong> 
                se situe dans http://monsite.com/reserv/ </li>
            <li>Vous pouvez personnaliser l'affichage gr&acirc;ce &agrave; la feuille 
                de style (style.css) propre au calendrier qui se trouve dans la dossier 
                &quot;cal&quot;.</li>
            <li>vous pouvez personnaliser le calendrier (ex: affichage de janvier &agrave; 
                d&eacute;cembre) en modifiant le code au d&eacute;but de la page cal/index.php
            </li>
           <li>
           Vous pouvez placer le calendrier directement dans votre page avec une iframe ex: &lt;iframe src=&quot;reserv/cal/index.php?ID_location=1&quot; height=&quot;1000&quot; width=&quot;1000&quot;&gt;&lt;/iframe&gt;
           </li>
        </ul>
       <?php
        include ("inc/copy.php");
        ?>                                   
    </div> <!--   fin de div container-->
</body>
</html>