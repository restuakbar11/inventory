<?php
define("HOST", "localhost"); // Host database
define("USER", "root"); // Usernama database
define("PASSWORD", ""); // Password database
define("DATABASE", "sip_inventory"); // Nama database

$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

if(!$mysqli){
	echo "gagal terhubung database:" .mysql_error();	
}
?>