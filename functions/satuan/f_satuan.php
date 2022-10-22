<?php
error_reporting(0);
include "../../config/connect.php";
session_start();

date_default_timezone_set('Asia/Jakarta');
$now			=date('Y-m-d H:i:s');
$username		=$_SESSION['username'];


switch ($_POST['act']){
	
	case "form":
	$sql =$mysqli->query( "SELECT * FROM M_SATUAN WHERE IDSATUAN='$_POST[satuanID]' ");
	// oci_execute($sql);
	$r =mysqli_fetch_array($sql);
	
    $data['NAMASATUAN']		=$r['NAMASATUAN'];
    $data['IDSATUAN']		=$r['IDSATUAN'];
    echo json_encode($data);
    break;
	
	
	case "hapus":
	$delete =$mysqli->query( "UPDATE M_SATUAN SET 
							SATUANISACTIVE='N',
							SATUANLASTUPDATE='$now'
						WHERE IDSATUAN='$_POST[satuanID]' ");
	// oci_execute($delete);
	// oci_commit;
    $data['hasil']=1;
    echo json_encode($data);
	break;
	
	
	
	case"save":
	$inp=$_POST['satuan'];
    if($inp['act']=='add'){
				/*Action Add Data*/
				$cek_name =$mysqli->query( "SELECT * FROM M_SATUAN WHERE NAMASATUAN='$inp[nm_satuan]' AND SATUANISACTIVE='Y'");
				// oci_execute($cek_name);
				$jml =mysqli_num_rows($cek_name);
				
				if($jml>0) {
					$data['hasil']=0;
				} else {
						
						$input =$mysqli->query( "INSERT INTO M_SATUAN 
												(NAMASATUAN,SATUANUSERNAME,SATUANLASTUPDATE) VALUES
												('$inp[nm_satuan]','$username','$now')
												") ;
						// oci_execute($input);
						// oci_commit;
						$data['hasil']=1;
				}
				
				echo json_encode($data);
    }
    else{
				/*Action Update Data*/
				$update =$mysqli->query( "UPDATE M_SATUAN SET 
											NAMASATUAN		='$inp[nm_satuan]',
											SATUANLASTUPDATE	='$now'
										WHERE IDSATUAN='$inp[satuanID]' ") ;
				// oci_execute($update);
				// oci_commit;
				$data['hasil']=1;
				echo json_encode($data);
    }
	break;
	
	
}