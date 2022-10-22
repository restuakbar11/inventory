<?php

$queryGetGedung =$mysqli->query ( "SELECT ID_GEDUNG,NAMA_GEDUNG from m_gedung where gedungisactive='Y'");
// oci_execute($queryGetGedung);
?>