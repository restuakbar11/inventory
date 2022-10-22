<?php 


$queryItem = $mysqli->query ( "SELECT * FROM M_ITEM 
								WHERE ITEM_ISACTIVE='Y' ORDER BY NAMAITEM ");
// oci_execute($queryItem);
?>