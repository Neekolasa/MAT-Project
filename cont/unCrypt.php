<?php 
	include 'encriptar.php';
	$password = $_REQUEST['password'];
	$key = "neeko";

	echo decrypt($password,$key);
 ?>