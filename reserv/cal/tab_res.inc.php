<?php
// -----------------------------------------
// Source  :	http://cogites.com
// Script  :	E RESERV
// Version :	5
// revente et redistribution interdites 
// Vous devez laisser le copyright.
// -----------------------------------------


	// construction du tableau des jours r�serv�s pour l'ann�e (+d�but et fin de r�servation)
	$tab_res_1 = array();
	$tab_res_deb_1 = array();
	$tab_res_fin_1 = array();
			
	$req_res = mysql_query("SELECT datedeb, datefin FROM $T_reserv WHERE ID_location='$ID_location' AND (datedeb >= '01-01-$an' AND datefin <= '31-12-$an')") or die ("erreur requete chch jour reserve");
	while ($contenu_res = mysql_fetch_array ($req_res)){
		$date_req=$contenu_res['datedeb'];
		$datefin_req=$contenu_res['datefin'];

		// deux tableaux pour les d�but et fin de r�servation
		$tab_res_deb_1[] = $date_req;
		$tab_res_fin_1[] = $datefin_req;
	
		while ($date_req <= $datefin_req) { 
			 
			// d�coupage de la date
			$jour_req = substr($date_req, 8, 2);  
			$mois_req = substr($date_req, 5, 2);
			$an_req = substr($date_req, 0, 4);
				
			// on place chaque jours r�serv�s dans le tableau
			$tab_res_1[] = $date_req;
					
			$date_req = date("Y-m-d", mktime(0, 0, 0, $mois_req, $jour_req+1, $an_req)); // on incr�mente la date de 1 jour
		}
	}
		?>