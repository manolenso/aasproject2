<?php 
// -----------------------------------------
// Source  :	http://cogites.com
// Script  :	E RESERV
// Version :	5
// revente et redistribution interdites 
// Vous devez laisser le copyright.
// -----------------------------------------

	// transforme les dates JJ-MM-AAAA(fran�aises) en AAAA-MM-JJ(anglaises)
	function fran_angl($date){
			$an = substr($date, 6, 4);
			$mois = substr($date, 3, 2);
			$jour = substr($date, 0, 2);  
			$date = $an . '-' . $mois . '-' . $jour; 
		return $date;
	}					

	// transforme les dates AAAA-MM-JJ(anglaises) en JJ-MM-AAAA(fran�aises)
	function angl_fran($date){
			$an = substr($date, 0, 4);
			$mois = substr($date, 5, 2);
			$jour = substr($date, 8, 2);  
			$date = $jour . '-' . $mois . '-' . $an; 
		return $date;
	}					


	// v�rification des dates
	function ctrl_date($datedeb,$datefin){
		// les lignes suivantes serviront aux tests / dates entr�es "� la mains"
		$trouve = '-'; 
		$nbr_trouve_deb = substr_count($datedeb, $trouve);
		$nbr_trouve_fin = substr_count($datefin, $trouve);
		$datedeb_bloc=str_replace("-", "", $datedeb); 
		$datefin_bloc=str_replace("-", "", $datefin); 

		// d�coupage des dates
		$an_deb = substr($datedeb, 0, 4);
		$mois_deb = substr($datedeb, 5, 2);
		$jour_deb = substr($datedeb, 8, 2);  

		$an_fin = substr($datefin, 0, 4);
		$mois_fin = substr($datefin, 5, 2);
		$jour_fin = substr($datefin, 8, 2);  
	
		$erreur_suite = '<br><br><a href="javascript:history.back();">cliquez ici pour retourner au formulaire</a>';  
		// au moins un des deux champs date est rest� vide
		if ( (empty($datedeb)) || (empty($datefin)) || ($datedeb=='--') || ($datefin=='--') ){
			 return $erreur ='!!! ERREUR !!! <br><br>Merci de renseigner les dates d\'entr�e et de sortie';
		}
		// on ne peut avoir une r�servation sur une seule et m�me journ�e
		elseif($datedeb==$datefin){
			 return $erreur ='!!! ERREUR !!! <br><br>On ne peut effectuer une r�servation sur une seule et m�me journ�e';
		}
			// contr�le des dates impossibles : la fin avant le d�but
		elseif ((strtotime($datedeb) - strtotime($datefin)) > 0) {
			return $erreur = '!!! ERREUR !!! <br><br>La date de fin est ant&eacute;rieure ou identique 
			&agrave; la date de d&eacute;but';
		}
			// v�rification que les chaines date se compose de 2'-' est de chiffres
		elseif($nbr_trouve_deb != '2') {
			return $erreur= 'La date de d�but semble incorrecte';
		}
		elseif(!is_numeric($datedeb_bloc)){
			return $erreur = 'La date de d�but semble incorrecte';
		}
		elseif($nbr_trouve_fin != '2') {
			return $erreur= 'La date de fin semble incorrecte';
		}
		elseif(!is_numeric($datefin_bloc)){
			return $erreur = 'La date de fin semble incorrecte';
		}
		elseif(($jour_deb > 31) || ($jour_fin > 31)){
			return $erreur = 'Les mois ne peuvent avoir plus de 31 jours';
		}
		elseif(($mois_deb > 12) || ($mois_fin > 12)){
			return $erreur = 'Les ann�es ne peuvent avoir plus de 12 mois';
		}
		elseif (($jour_deb.$mois_deb == 3002) || ($jour_deb.$mois_deb == 3102) || ($jour_fin.$mois_fin == 3102) || ($jour_fin.$mois_fin == 3102)) {
		   return $erreur = '!!! ERREUR !!! <br><br>Le mois de f�vrier compte au maximum 29 jours';
        } 
		// contr�le des dates impossibles : ann�es bissextiles (29 f�vrier)
		elseif ((($jour_deb.$mois_deb == 2902) || ($jour_deb.$mois_deb == 2902)) && ((!is_int($an_deb/4) || is_int($an_deb/100) ) && (!is_int($an_deb/400)))) {
			// si on a demand� un 29 f�vrier pour la date de d�but on test pour savoir si c'est une ann�e non bissextile
			// si l'ann�e n'est pas bissextile on affiche un message d'erreur 
			return $erreur = '!!! ERREUR !!! <br><br>Le mois de f�vrier compte 28 jours cette ann�e l�'; 
		}
		elseif ((($jour_fin.$mois_fin == 2902) || ($jour_fin.$mois_fin == 2902)) && ((!is_int($an_fin/4) || is_int($an_deb/100) ) && (!is_int($an_fin/400)))) {
			// si on a demand� un 29 f�vrier pour la date de fin on test pour savoir si c'est une ann�e non bissextile
			// si l'ann�e n'est pas bissextile on affiche un message d'erreur 
			return $erreur = '!!! ERREUR !!! <br><br>Le mois de f�vrier compte 28 jours cette ann�e l�'; 
		}
	}
?>