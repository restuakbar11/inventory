<?php
error_reporting(0);
include "../../config/connect.php";
session_start();

date_default_timezone_set('Asia/Jakarta');
$now			=date('Y-m-d H:i:s');
$username		=$_SESSION['username'];


switch ($_POST['act']){
	
	case "form":
	$sql =$mysqli->query( "SELECT * FROM M_SUPPLIER WHERE IDSUPPLIER='$_POST[supplierID]' ");
	// oci_execute($sql);
	$r =mysqli_fetch_array($sql);
	
    $data['NAMASUPPLIER']			=$r['NAMASUPPLIER'];
    $data['IDSUPPLIER']				=$r['IDSUPPLIER'];
    $data['EMAILSUPPLIER']			=$r['EMAILSUPPLIER'];
    $data['TELEPHONESUPPLIER']		=$r['TELEPHONESUPPLIER'];
    $data['ADDRESSSUPPLIER']		=$r['ADDRESSSUPPLIER'];
    $data['SUPPLIERCONTACTPERSON']	=$r['SUPPLIERCONTACTPERSON'];
    echo json_encode($data);
    break;
	
	
	
	case "hapus":
	$delete =$mysqli->query( "UPDATE M_SUPPLIER SET 
							SUPPLIERISACTIVE='N',
							SUPPLIERLASTUPDATE='$now'
						WHERE IDSUPPLIER='$_POST[supplierID]' ");
	// oci_execute($delete);
	// oci_commit;
    $data['hasil']=1;
    echo json_encode($data);
	break;
	
	
	
	case "save":
	$inp=$_POST['supplier'];
    if($inp['act']=='add'){
				/*Action Add Data*/
				$cek_name =$mysqli->query( "SELECT * FROM M_SUPPLIER WHERE NAMASUPPLIER='$inp[nm_supplier]' AND SUPPLIERISACTIVE='Y' ");
				// oci_execute($cek_name);
				$jml =mysqli_num_rows($cek_name);
				
				if($jml>0) {
					$data['hasil']=0;
				} else {
						
						$input =$mysqli->query( "INSERT INTO M_SUPPLIER 
												(NAMASUPPLIER,EMAILSUPPLIER,TELEPHONESUPPLIER,ADDRESSSUPPLIER,SUPPLIERCONTACTPERSON,SUPPLIERUSERNAME,SUPPLIERLASTUPDATE) VALUES
												('$inp[nm_supplier]','$inp[email]','$inp[telp]','$inp[alamat]','$inp[person]','$username','$now')
												") ;
						// oci_execute($input);
						// oci_commit;
						$data['hasil']=1;
				}
				
				echo json_encode($data);
    }
    else{
				/*Action Update Data*/
				$update =$mysqli->query( "UPDATE M_SUPPLIER SET 
											NAMASUPPLIER		='$inp[nm_supplier]',
											EMAILSUPPLIER		='$inp[email]',
											ADDRESSSUPPLIER		='$inp[alamat]',
											TELEPHONESUPPLIER	='$inp[telp]',
											SUPPLIERCONTACTPERSON='$inp[person]',
											SUPPLIERLASTUPDATE	='$now'
										WHERE IDSUPPLIER='$inp[supplierID]' ") ;
				// oci_execute($update);
				// oci_commit;
				$data['hasil']=1;
				echo json_encode($data);
    }
	break;
	
}