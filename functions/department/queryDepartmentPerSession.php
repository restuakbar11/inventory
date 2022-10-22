<?php
session_start();
$id_department =$_SESSION['id_department'];

$queryDepartmentPerSession =$mysqli->query ( "SELECT ID_DEPARTMENT,NAMA_DEPARTMENT
                                            from M_DEPARTMENT where DEPARTMENTISACTIVE='Y' AND ID_DEPARTMENT='$id_department' ");
// oci_execute($queryDepartmentPerSession);
?>