<?php 

$queryUserGroup =$mysqli->query ( "SELECT * FROM M_USERGROUP WHERE USERGROUPISACTIVE='Y' ORDER BY USERGROUPNAMA ");
// oci_execute($queryUserGroup);
?>