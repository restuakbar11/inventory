<?php
error_reporting(0);
include "../../config/connect.php";
session_start();

date_default_timezone_set('Asia/Jakarta');
$now			=date('Y-m-d H:i:s');
$username		=$_SESSION['username'];


switch ($_POST['act']){
	
	
	case "form":
	$sql =$mysqli->query( "SELECT * FROM M_ITEMSUPPLIER WHERE IDITEMSUPPLIER='$_POST[itemsupplierID]' ");
	// oci_execute($sql);
	$r =mysqli_fetch_array($sql);
	
    $data['IDITEMSUPPLIER']				=$r['IDITEMSUPPLIER'];
    $data['ITEMSUPPLIER_IDSUPPLIER']	=$r['ITEMSUPPLIER_IDSUPPLIER'];
    $data['ITEMSUPPLIER_IDITEM']		=$r['ITEMSUPPLIER_IDITEM'];
    echo json_encode($data);
    break;
	
	
	
	case "hapus":
	$delete =$mysqli->query( "UPDATE M_ITEMSUPPLIER SET 
							ITEMSUPPLIERISACTIVE='N',
							ITEMSUPPLIERLASTUPDATE='$now'
						WHERE IDITEMSUPPLIER='$_POST[itemsupplierID]' ");
	// oci_execute($delete);
	// oci_commit;
    $data['hasil']=1;
    echo json_encode($data);
	break;
	
	
	
	case "save":
	$inp=$_POST['itemsupplier'];
    if($inp['act']=='add'){
				/*Action Add Data*/
				$cek_name =$mysqli->query( "SELECT * FROM M_ITEMSUPPLIER WHERE ITEMSUPPLIER_IDSUPPLIER='$inp[supplier]' AND ITEMSUPPLIER_IDITEM='$inp[item]' AND ITEMSUPPLIERISACTIVE='Y' ");
				// oci_execute($cek_name);
				$jml =mysqli_num_rows($cek_name);
				
				if($jml>0) {
					$data['hasil']=0;
				} else {
						$input =$mysqli->query( "INSERT INTO M_ITEMSUPPLIER 
												(ITEMSUPPLIER_IDSUPPLIER,ITEMSUPPLIER_IDITEM,ITEMSUPPLIERUSERNAME,ITEMSUPPLIERLASTUPDATE) VALUES
												('$inp[supplier]','$inp[item]','$username','$now')
												") ;
						// oci_execute($input);
						// oci_commit;
						$data['hasil']=1;
				}
				
				echo json_encode($data);
    }
    else{
				/*Action Update Data*/
				$update =$mysqli->query( "UPDATE M_ITEMSUPPLIER SET 
											ITEMSUPPLIER_IDSUPPLIER	='$inp[supplier]',
											ITEMSUPPLIER_IDITEM		='$inp[item]',
											ITEMSUPPLIERLASTUPDATE	='$now'
										WHERE IDITEMSUPPLIER='$inp[itemsupplierID]' ") ;
				// oci_execute($update);
				// oci_commit;
				$data['hasil']=1;
				echo json_encode($data);
    }
	break;
	
	
}