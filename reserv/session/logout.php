<?php 
// -----------------------------------------
// Source  :	http://cogites.com
// Script  :	E RESERV
// Version :	5
// revente et redistribution interdites 
// Vous devez laisser le copyright.
// -----------------------------------------
session_start();
// on termine la session
if (isset($_SESSION['login_admin'])) {
   unset($_SESSION['login_admin']);
}

include("../inc/conec.php");
// on renvoit vers l'url du site
header("Location: $url");
?>
