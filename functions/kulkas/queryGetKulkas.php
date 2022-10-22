<?php
$query="SELECT KODE_KULKAS, NAMAGUDANG as NAMA_KULKAS from M_KULKAS k
JOIN M_GUDANG g ON g.ID_GUDANG=k.ID_GUDANG
where KULKASISACTIVE = 'Y' order by NAMA_KULKAS ASC";

$queryGetKulkas =$mysqli->query ( $query);
// oci_execute($queryGetKulkas);
?>

