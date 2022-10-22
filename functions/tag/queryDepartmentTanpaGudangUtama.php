<?php
include '../../config/connect.php';
include 'functions/department/queryDepartmentUtama.php';
$z =mysqli_fetch_array($queryGetDepartment);

$queryDepartmentTanpaGudangUtama =$mysqli->query ( "SELECT ID_DEPARTMENT,NAMA_DEPARTMENT from M_DEPARTMENT 
	where DEPARTMENTISACTIVE='Y' AND ID_DEPARTMENT!='$z[ID_DEPARTMENT]' ");
// oci_execute($queryDepartmentTanpaGudangUtama);
?>