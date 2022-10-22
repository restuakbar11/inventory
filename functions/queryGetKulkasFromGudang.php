<?php 

$sql = "select * from M_GUDANG WHERE GUDANGAKTIF='Y' AND ISKULKAS='Y'";
//NOT IN (SELECT ID_GUDANG FROM M_KULKAS WHERE KULKASISACTIVE='Y') AND ISKULKAS='Y' AND GUDANGAKTIF='Y'";
$queryGetKulkasFromGudang =$mysqli->query ( $sql);
// oci_execute($queryGetKulkasFromGudang);


?>