<?php

$queryGetSupplier =$mysqli->query ( "SELECT * from M_SUPPLIER 
	where SUPPLIERISACTIVE='Y' 
	ORDER BY NAMASUPPLIER ASC ");
// oci_execute($queryGetSupplier);
?>