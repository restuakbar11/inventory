<?php 

$queryKelompokItem = $mysqli->query ( "SELECT * FROM M_KELOMPOKITEM WHERE KELOMPOKITEMISACTIVE='Y' ORDER BY NAMAKELOMPOKITEM ");
// oci_execute($queryKelompokItem);
?>