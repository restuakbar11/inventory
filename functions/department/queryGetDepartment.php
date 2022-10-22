<?php

$queryGetDepartment =$mysqli->query ( "SELECT ID_DEPARTMENT,NAMA_DEPARTMENT from M_DEPARTMENT 
	where DEPARTMENTISACTIVE='Y'");
// oci_execute($queryGetDepartment);
?>