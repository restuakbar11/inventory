<?php
session_start();
$id_department =$_SESSION['id_department'];

$querySubDepartmentPerSession =$mysqli->query ( "SELECT ID_SUBDEPARTMENT,NAMA_SUBDEPARTMENT,d.ID_DEPARTMENT,d.NAMA_DEPARTMENT
                                            from M_SUBDEPARTMENT s
                                            JOIN M_DEPARTMENT d ON d.ID_DEPARTMENT=s.ID_DEPARTMENT AND DEPARTMENTISACTIVE='Y'
											where SUBDEPARTMENTISACTIVE='Y' AND d.ID_DEPARTMENT='$id_department' ");
// oci_execute($querySubDepartmentPerSession);
?>