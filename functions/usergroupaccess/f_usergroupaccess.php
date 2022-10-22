<?php
error_reporting(0);
include "../../config/connect.php";
session_start();

date_default_timezone_set('Asia/Jakarta');
$now			=date('Y-m-d H:i:s');
$username		=$_SESSION['username'];

switch ($_POST['act']){
	
	case "tambah":
		$tambah =$mysqli->query( "INSERT INTO M_USERGROUPACCESS
									(USERGROUPID,MENUSUBID)
									VALUES
									('$_POST[groupid]','$_POST[menusubid]')");
		// oci_execute($tambah);
		// oci_commit;
		$data['hasil']=1;
		echo json_encode($data);
    break;
	
	
	
	case "hapus":
	$delete =$mysqli->query( "DELETE FROM M_USERGROUPACCESS
						WHERE USERGROUPID='$_POST[groupid]' AND MENUSUBID='$_POST[menusubid]' ");
	// oci_execute($delete);
	// oci_commit;
    $data['hasil']=1;
    echo json_encode($data);
	break;
	
	
}