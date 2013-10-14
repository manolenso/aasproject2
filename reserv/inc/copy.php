<?php 
// -----------------------------------------
// Source  :	http://cogites.com
// Script  :	E RESERV
// Version :	5
// revente et redistribution interdites 
// Vous devez laisser le copyright.
// Merci à http://twitter.github.com/bootstrap/ et http://glyphicons.com/
// -----------------------------------------
?>
<hr>
<table width="700" border="0" align="center" cellspacing="0" class="texte">
  <tr> 
    <td><div align="center"> <img src="img/<?php if (is_dir('suivi')){ // module suivi alors on ajoute AND ($T_reserv.etat_reserv=2)
	echo 'e_reserv_plus.jpg';
	}
	else{
	echo 'e_reserv.jpg';
	}
	?>" width="200" height="72" align="absmiddle"><a href="http://cogites.com/e_reserv/">E 
        Reserv' 5 - cogites.com - Mises &agrave; jour du scrpit &gt;&gt;</a> 
        &nbsp;&nbsp;<img src="http://cogites.com/e_reserv/img_reserv/e_reserv5.jpg" title="si je suis rouge, une mise à jour est nécessaire" width="45" height="41" align="middle"> 
      </div></td>
  </tr>
  <?php if (!is_dir('suivi')){ // module suivi alors on ajoute AND ($T_reserv.etat_reserv=2)
?>
<tr> 
    <td><div align="center"><a href="http://cogites.com/e_reserv/e_reserv_plus.php" target="_blank">Passer 
        à E-reserv' PLUS</a></div></td>
  </tr>
  <tr>
    <td> <div align="center"> 
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
          <input type="hidden" name="cmd" value="_s-xclick">
          <input type="hidden" name="hosted_button_id" value="11352011">
          <input type="image" src="https://www.paypal.com/fr_FR/FR/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - la solution de paiement en ligne la plus simple et la plus sécurisée !">
          <img alt="" border="0" src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" width="1" height="1"> 
        </form>
      </div></td>
  </tr>
  <?php }?>
</table>