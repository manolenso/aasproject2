<?php
// -----------------------------------------
// Source  :	http://cogites.com
// Script  :	E RESERV
// Version :	5
// revente et redistribution interdites
// Vous devez laisser le copyright.
// -----------------------------------------

// $valeur repr?sente une date au format AAAA-MM
function getMonth($valeur){
    return substr($valeur, 5, 2);
}

function getYear($valeur){
    return substr($valeur, 0, 4);
}

function monthNumToName($mois){
    $tableau = Array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
    return (intval($mois) > 0 && intval($mois) < 13) ? $tableau[intval($mois)] : "Ind?fini";
}
?>
