<?php 
// -----------------------------------------
// Source  :	http://cogites.com
// Script  :	E RESERV
// Version :	3.53
// revente et redistribution interdites 
// Vous devez laisser le copyright.
// -----------------------------------------
?>
<?php
 function captcha_word($word_size,$allow_repeat_chars=false){
   $allowed_chars = '123456789abcdefghjkmnpqrstuvwxyz';
   
   $result = '';
   while(strlen($result)<$word_size) {
     $chr = substr($allowed_chars, mt_rand(0, strlen($allowed_chars)-1), 1);
     if($allow_repeat_chars || !strstr($result,$chr)) 
        $result .= $chr;
   }
   return $result;
 }
?>