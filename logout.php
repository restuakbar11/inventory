<?php
	include ('config/connect.php');
	session_start();
	
	session_unset();
	
	session_destroy();
	
	header('location:../inventory/login.php');

?>