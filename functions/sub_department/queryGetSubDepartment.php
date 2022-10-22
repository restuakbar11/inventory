<?php

$queryGetSubDepartment =$mysqli->query ( "SELECT ID_SUBDEPARTMENT,NAMA_SUBDEPARTMENT,d.ID_DEPARTMENT,d.NAMA_DEPARTMENT
                                            from M_SUBDEPARTMENT s
                                            JOIN M_DEPARTMENT d ON d.ID_DEPARTMENT=s.ID_DEPARTMENT AND DEPARTMENTISACTIVE='Y'
											where SUBDEPARTMENTISACTIVE='Y'");
// oci_execute($queryGetSubDepartment);
?>