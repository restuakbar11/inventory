<?php
error_reporting(0);
include "../../config/connect.php";
session_start();

date_default_timezone_set('Asia/Jakarta');
$now			=date('Y-m-d H:i:s');
$username		=$_SESSION['username'];

switch ($_POST['act']){
	
	case "form":
	$sql =$mysqli->query( "SELECT * FROM M_USERGROUP WHERE USERGROUPID='$_POST[usergroupID]' ");
	// oci_execute($sql);
	$r =mysqli_fetch_array($sql);
	
    $data['USERGROUPNAMA']		=$r['USERGROUPNAMA'];
    $data['USERGROUPID']		=$r['USERGROUPID'];
    echo json_encode($data);
    break;
	
	
	
	case "hapus":
	$delete =$mysqli->query( "UPDATE M_USERGROUP SET 
							USERGROUPISACTIVE='N',
							USERGROUPLASTUPDATE='$now'
						WHERE USERGROUPID='$_POST[usergroupID]' ");
	// oci_execute($delete);
	// oci_commit;
    $data['hasil']=1;
    echo json_encode($data);
	break;
	
	
	
	case "save":
	$inp=$_POST['usergroup'];
    if($inp['act']=='add'){
				/*Action Add Data*/
				$cek_name =$mysqli->query( "SELECT * FROM M_USERGROUP WHERE USERGROUPNAMA='$inp[nm_usergroup]' AND USERGROUPISACTIVE='Y' ");
				// oci_execute($cek_name);
				$jml =mysqli_num_rows($cek_name);
				
				if($jml>0) {
					$data['hasil']=0;
				} else {
						
						$input =$mysqli->query( "INSERT INTO M_USERGROUP 
												(USERGROUPNAMA,USERGROUPLASTUPDATE) VALUES
												('$inp[nm_usergroup]','$now')
												") ;
						// oci_execute($input);
						// oci_commit;
						$data['hasil']=1;
				}
				
				echo json_encode($data);
    }
    else{
				/*Action Update Data*/
				$update =$mysqli->query( "UPDATE M_USERGROUP SET 
											USERGROUPNAMA		='$inp[nm_usergroup]',
											USERGROUPLASTUPDATE	='$now'
										WHERE USERGROUPID='$inp[usergroupID]' ") ;
				// oci_execute($update);
				// oci_commit;
				$data['hasil']=1;
				echo json_encode($data);
    }
	break;
	
}