<?php 
// -----------------------------------------
// Source  :	http://cogites.com
// Script  :	E RESERV
// Version :	5
// revente et redistribution interdites 
// Vous devez laisser le copyright.
// -----------------------------------------

include ("../inc/conec.php");
include('../inc/captcha/functions.php');
session_start();
?>

<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <title>Mot de passe perdu?</title>
            <!-- css génériques -->
            <link href="../inc/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" >
            <link href="../style_reserv.css" rel="stylesheet" type="text/css" >

            <!-- js boostrap et j query -->    
            <script  src="../inc/bootstrap/jquery.min.js" type="text/javascript"></script>
            <script  src="../inc/bootstrap/js/bootstrap.js" type="text/javascript"></script>
            
            
            <!-- js spécifique (date etc.) -->    
            <script src="../inc/fonc.js" type="text/javascript"></script>
    
            <script language="javascript" type="text/javascript">
                function check(){
                    var errormessage="";
                    if(document.getElementById('captcha').value=="")
                        errormessage+="L'antispam est vide\n";
                    if(errormessage=="") return true;
                    alert(errormessage);
                    document.getElementById('captcha').focus();
                    return false;
                }
            </script>

</head>
<body>
    <div class="container">
        <h2 class="titre" >Mot de passe perdu ? </h2>
        <?php
        if ($_POST) {
            if (
                    isset($_POST["captcha"]) && $_POST["captcha"] != '' &&
                    isset($_SESSION['code']) &&
                    $_SESSION['code'] == $_POST["captcha"]
            ) {
                // on récupère l'identifiant dans la BDD
                $login_req = mysql_query("SELECT login_admin FROM $T_admin WHERE ID_admin='1'") or die("erreur chch login");
                $login = mysql_result($login_req, 0);

                //si l'identifiant ou l'email sont correcte on va créer et poster un nouveau passe 
                if (($_POST["login_admin"] == "$login") || ($_POST["email"] == "$email_webmaster")) {
                    // construction d'un mot de passe aléatoire
                    $nx_pass = rand(1, 9);
                    $nx_pass.= rand(1, 9);
                    $nx_pass.= rand(1, 9);
                    $nx_pass.= rand(1, 9);
                    // on crypte le nouveau mot de passe
                    $nx_pass_admin = md5($nx_pass);

                    // on entre le mot de passe crypté dans la BDD
                    $sql = "UPDATE $T_admin SET pass_admin='$nx_pass_admin' WHERE ID_admin='1'";
                    //exécution de la requête SQL
                    $requete = @mysql_query($sql) or die($sql . "<br>" . mysql_error());

                    // envoi du mot de passe par email
                    $frontiere = '-----=' . md5(uniqid(mt_rand()));
                    //Header du mail
                    $headers = 'From: "' . $email_webmaster . '" <' . $email_webmaster . '>' . "\n";
                    $headers .= 'Return-Path: <' . $email_webmaster . '>' . "\n";
                    $headers .= 'MIME-Version: 1.0' . "\n";
                    $headers .= 'Content-Type: multipart/mixed; boundary="' . $frontiere . '"' . "\n";

                    $to = "$email_webmaster";
                    $sujet = 'Mot de pass: E\'reserv';

                    //message texte
                    $texte = 'This is a multi-part message in MIME format.' . "\n\n";
                    $texte .= '--' . $frontiere . "\n";
                    $texte .= 'Content-Type: text/plain; charset="iso-8859-1"' . "\n";
                    $texte .= 'Content-Transfer-Encoding: 8bit' . "\n\n";


                    // récupération du chemin de connexion au script
                    $root = 'http://' . $_SERVER['HTTP_HOST'];
                    $self = $_SERVER['PHP_SELF'];
                    // on enlève 7 caractères à la fin pour le dossier "session"
                    $url_connexion = $root . mb_substr($self, 0, -(mb_strlen(strrchr($self, "/")) + 7));

                    $texte .= "bonjour \n \n";
                    $texte .= "Votre nouveau mot de passe : $nx_pass \n";
                    $texte .= "Votre identifiant demeurre : $login";
                    $texte .="\n \n pour vous connecter aller  " . $url_connexion . " \n \n bonne journée";
                    $texte .= "\n\n";


                    if (mail($to, $sujet, $texte, $headers)) {
                        echo "<div class = \"alert alert-success\"> Un email contenant le nouveau mot de passe vous a été envoyé </div>";
                    } else {
                        echo "<div class = \"alert alert-error\"> Un email contenant le nouveau mot de passe n'a pu être envoyé </div>";
                    }
                } else {
                    echo "<div class = \"alert alert-error\"> Votre login ou votre email n'ont pas été reconnu</div>";
                }
            } else {// si le capcha n'est pas bon
                echo "<div class = \"alert alert-error\"> le texte antispam est incorrecte</div>";
            }
        }//fin if($_POST)
// Captcha word has 5 chars (length) with repeated chars
        $_SESSION['sesscaptchaword'] = captcha_word(5, true);
        ?>
       <form method="post"  onsubmit="return check();" class="form-horizontal" style ="width:750px;" >
            <p>&nbsp;</p>
            <div class="lead">Saisissez, soit votre login, soit votre email. </div><p>&nbsp;</p>
            <label>&nbsp;login</label>
            <input name="login_admin" type="text" id="login_admin" /></td>
            <label>email</label>
            <input name="email" type="text"  id="email" size="30" /> <br/><br/>
            <img src="../inc/captcha/cryptimage.php" width="160" height="40"/>
            <label>Saisissez exactement le texte de l'image </label>
            <input name="captcha" type="text" id="captcha2" />
            <input name="button" class="btn btn-warning btn-large"type="button" onclick="document.location='passe_perdu.php';" value="Une autre image svp" /> 
            <div class="form-actions">
                <input type="submit" name="Submit" value="Envoyer" class="btn btn-primary btn-large span4" />
            </div>
        </form>
        <p>Retourner &agrave; la <a href="../index.php">page d'identification</a></p>
    </div> <!--   fin de div container-->  
</body>
</html>
