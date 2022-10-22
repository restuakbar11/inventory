<?php

$queryGetDepartment =$mysqli->query ( "SELECT ID_DEPARTMENT,NAMA_DEPARTMENT from M_DEPARTMENT 
	where DEPARTMENTISACTIVE='Y' and ID_DEPARTMENT=41");
// oci_execute($queryGetDepartment);
?>