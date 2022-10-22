<?php 

$queryGetRuangan =$mysqli->query ( "SELECT ID_RUANGAN,NAMA_RUANGAN from M_RUANGAN where RUANGANISACTIVE='Y'");
// oci_execute($queryGetRuangan);


?>