<?php

$queryGetTypeKulkas =$mysqli->query ( "SELECT ID_TYPEKULKAS, NAMA_TYPEKULKAS from M_TYPEKULKAS where TYPEKULKASISACTIVE = 'Y' order by NAMA_TYPEKULKAS ASC");
// oci_execute($queryGetTypeKulkas);
?>