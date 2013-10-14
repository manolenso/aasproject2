<?php
session_start();

$liste = "123456789abcdefghjkmnpqrstuvwxyz";


$code = '';
while(strlen($code) != 5) {
$code .= $liste[rand(0,32)];
}
$_SESSION['code']=$code;
$larg = 70;
$haut =16;
$img = imageCreate($larg, $haut);
$vert = imageColorAllocate($img,178,219,171);
$noir = imageColorAllocate($img,0,0,0);
$code_police=15;
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
header('Cache-Control: no-store, no-cache, must-revalidate'); 
header('Cache-Control: post-check=0, pre-check=0', false); 
header("Content-type: image/jpeg");
imageString($img, $code_police,($larg-imageFontWidth($code_police)*strlen("".$code.""))/2,0, $code,$noir);
imagejpeg($img,'',90);
imageDestroy($img);
?>