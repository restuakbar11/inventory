<?php
include ("../../config/connect.php");

$querySatuan =$mysqli->query ( "SELECT *
										FROM M_SATUAN WHERE SATUANISACTIVE='Y' ");
// oci_execute($querySatuan);
?>