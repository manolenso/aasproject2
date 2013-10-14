<?php

	// échappe les double quote (") pour les email
	function dbl_qoute_vers_html($ch){
	$var = '"';
	$ch = preg_replace("$var", "&quot;", "$ch"); 
	return $ch;}

?>