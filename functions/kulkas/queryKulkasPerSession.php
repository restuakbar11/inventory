<?php
session_start();
$id_department =$_SESSION['id_department'];

$queryKulkasPerSession =$mysqli->query ( "SELECT KODE_KULKAS, NAMAGUDANG as NAMA_KULKAS from M_KULKAS k
JOIN M_GUDANG g ON g.ID_GUDANG=k.ID_GUDANG
where KULKASISACTIVE = 'Y' and g.id_department='$id_department' order by NAMA_KULKAS ASC");
// oci_execute($queryKulkasPerSession);
?>