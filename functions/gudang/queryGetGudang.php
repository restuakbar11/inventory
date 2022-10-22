<?php

$queryGetGudang =$mysqli->query ( "SELECT ID_GUDANG,NAMAGUDANG from M_GUDANG 
	where GUDANGAKTIF='Y' and ID_DEPARTMENT=41");
// oci_execute($queryGetGudang);
?>