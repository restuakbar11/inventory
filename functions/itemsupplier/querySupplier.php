<?php 

$querySupplier = $mysqli->query ( "SELECT * FROM M_SUPPLIER WHERE SUPPLIERISACTIVE='Y' ORDER BY NAMASUPPLIER ");
// oci_execute($querySupplier);
?>