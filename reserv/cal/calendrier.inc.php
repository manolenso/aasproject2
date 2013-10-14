<?php 


// -----------------------------------------
// Source  :	http://cogites.com
// Script  :	E RESERV
// Version :	5
// revente et redistribution interdites 
// Vous devez laisser le copyright.
// -----------------------------------------

function showCalendar($periode){ 
	// on ins�re les variables globales
	global $tab_res_1;
	global $tab_res_deb_1;
	global $tab_res_fin_1;
    // on reprend les variables
    $an = getYear($periode);
    $mois = getMonth($periode); 
    // si le fomulaire a �t� post� on prend la variable ID_location dans le champ cach� du fomulaire de requ�te
    if ($_POST) {
        $ID_location = $_POST['ID_location'];
    } 
    // sinon on prend la variable ID_location pass�e dans l'url. A la premi�re ouverture de la pop.
    else {
        $ID_location = $_GET['ID_location'];
    } 
		
	
    // on v�rifie s'il y a des jours r�serv�s dans le mois demand�. s'il y en a on les place dans le tableau $tab_res ainsi que les d�but et fin de p�riodes
    $tab_res = array();
	$tab_res_deb = array();
	$tab_res_fin = array();
	
	// du premier au dernier jours du mois
    $jour = "1";
	while ($jour <= 31) {
	
        $date_test = "$an-$mois";
        if ($jour < 10) {
            $date_test .= "-0$jour";
        } else {
            $date_test .= "-$jour";
        } 
		
		// tableau des jours r�serv�s
		if(in_array($date_test, $tab_res_1)){
            $tab_res[] = $jour;
        } 
		// tableau des d�buts de p�riodes r�serv�es
		if(in_array($date_test, $tab_res_deb_1)){
            $tab_res_deb[] = $jour;
        } 
		// tableau des fins de p�riodes r�serv�es
		if(in_array($date_test, $tab_res_fin_1)){
            $tab_res_fin[] = $jour;
        } 
		
        $jour++; 
        // on teste jusqu'� jour <= 31
    } 
	
	    // si le tableau n'est pas vide il faudra le traiter    if (!empty($tab_res)) 


    // on commence la construction du tableau a afficher
    $leCalendrier = '';
    $leCalendrier .= '<div id="cadre_calendrier">'; 
    // Tableau des valeurs possibles pour un num�ro de jour dans la semaine
    $tableau = Array("0", "1", "2", "3", "4", "5", "6", "0", "1"); 
    // calcul du nombre de jour dans le mois
    $nb_jour = Date("t", mktime(0, 0, 0, getMonth($periode), 1, getYear($periode)));
    $pas = 0;
    $indexe = 1; 
    // Affichage du mois et de l'ann�e au dessus du tableau
    $leCalendrier .= "\n\t<h2>" . monthNumToName(getMonth($periode)) . " " . getYear($periode) . "</h2>"; 
    // Affichage des ent�tes
    $leCalendrier .= "
          <ul id=\"libelle\">
               \t<li>S</li>
               \t<li>D</li>
               \t<li>L</li>
               \t<li>M</li>
               \t<li>M</li>
               \t<li>J</li>
               \t<li>V</li>
			   \t<li>S</li>
          </ul>"; 
    // Tant que l'on n'a pas affect� tous les jours du mois trait�
    while ($pas < $nb_jour) {
        if ($indexe == 1) $leCalendrier .= "\n\t<ul class=\"ligne\">"; 
        // Si le jour calendrier == jour de la semaine en cours (puce ou nombre)
        if (Date("w", mktime(0, 0, 0, getMonth($periode), 3 + $pas, getYear($periode))) == $tableau[$indexe]) {
            $afficheJour = Date("j", mktime(0, 0, 0, getMonth($periode), 1 + $pas, getYear($periode))); 
            // c un jour de la semaine on test pour savoir s'il est r�serv�

				 // si $affichJour est dans le tableau des jours r�serv�s alors on le met en rouge

if (in_array ($afficheJour, $tab_res)) {

	// entre deux reserv
	if ( (in_array ($afficheJour, $tab_res_fin)) && (in_array ($afficheJour, $tab_res_deb)) ){
		if (@$_SESSION["login_admin"] == true){
		$class = " class=\"reserv_entre "; 
		}
		
	}
	// d�but de reserv
	elseif (in_array ($afficheJour, $tab_res_deb)) {
					$class = " class=\"reserve_deb "; 
	}
	// fin de reserv
	elseif (in_array ($afficheJour, $tab_res_fin)){
		$class = " class=\"reserve_fin "; 
	}
	else{
	$class = " class=\"reserve "; 
	}
}
				
else {
    $class = " class=\"libre_basse "; 
   // si $affichJour n'est pas dans le tableau des jours r�serv�s alors on ne le met pas en forme
  } 
				
	// la date du jour en gras
	if (Date("Y-m-d", mktime(0, 0, 0, getMonth($periode), 1 + $pas, getYear($periode))) == Date("Y-m-d")) {
	$class .= " today\"";
	} 
	else{
		$class .= "\"";
	}
				
				
            // Ajout de la case avec la date
            $leCalendrier .= "\n\t\t<li$class>$afficheJour</li>";
            $pas++;
        } 
        
        else {
            // Ajout d'une case vide
            $leCalendrier .= "\n\t\t<li>&nbsp;</li>";
        } 
        if ($indexe == 8 && $pas < $nb_jour) {
            $leCalendrier .= "\n\t</ul>";
            $indexe = 1;
			$pas=$pas-1;
        } else {
            $indexe++;
        } 
    } 
    // Ajustement du tableau
    for ($i = $indexe; $i <= 7; $i++) {
        $leCalendrier .= "\n\t\t<li>&nbsp;</li>";
		
    } 
    $leCalendrier .= "\n\t</ul></div>\n"; 
    // Retour de la chaine contenant le Calendrier
    return $leCalendrier;
} 



?>