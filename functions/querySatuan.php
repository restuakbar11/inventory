<?php 

$querySatuan = $mysqli->query ( "SELECT * FROM M_SATUAN WHERE SATUANISACTIVE='Y' ORDER BY NAMASATUAN ");
// oci_execute($querySatuan);
?>