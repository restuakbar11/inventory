<?php
error_reporting(0);
include "../../config/connect.php";
session_start();

date_default_timezone_set('Asia/Jakarta');
$now			=date('Y-m-d H:i:s');
$username		=$_SESSION['username'];


switch ($_POST['act']){
	
	
	case "form":
	$sql =$mysqli->query( "SELECT IDITEM,NAMAITEM,ITEM_IDKELOMPOKITEM,REPLACE(ITEM_IDSATUAN,'^',',') AS SATUAN FROM M_ITEM WHERE IDITEM='$_POST[itemID]' ");
	// oci_execute($sql);
	$r =mysqli_fetch_array($sql);
	
    $data['NAMAITEM']			=$r['NAMAITEM'];
    $data['IDITEM']				=$r['IDITEM'];
    $data['ITEM_IDSATUAN']		=$r['SATUAN'];
    $data['ITEM_IDKELOMPOKITEM']=$r['ITEM_IDKELOMPOKITEM'];
    echo json_encode($data);
    break;
	
	
	
	case "hapus":
	$delete =$mysqli->query( "UPDATE M_ITEM SET 
							ITEM_ISACTIVE='N',
							ITEM_LASTUPDATE='$now'
						WHERE IDITEM='$_POST[itemID]' ");
	// oci_execute($delete);
	// oci_commit;
    $data['hasil']=1;
    echo json_encode($data);
	break;
	
	
	
	case "save":
	$inp=$_POST['item'];
    if($inp['act']=='add'){
				/*Action Add Data*/
				$cek_name =$mysqli->query( "SELECT * FROM M_ITEM WHERE IDITEM='$inp[iditem]' AND ITEM_ISACTIVE='Y'");
				// oci_execute($cek_name);
				$jml =mysqli_num_rows($cek_name);
				
				if($jml>0) {
					$data['hasil']=0;
				} else {
						$gabung = implode("^",$inp['idsatuan']);
						$input =$mysqli->query( "INSERT INTO M_ITEM 
												(IDITEM,NAMAITEM,ITEM_IDSATUAN,ITEM_IDKELOMPOKITEM,ITEM_USERNAME,ITEM_LASTUPDATE) VALUES
												('$inp[iditem]','$inp[namaitem]','$gabung','$inp[item_idkelompok]','$username','$now')
												") ;
						// oci_execute($input);
						// oci_commit;
						$data['hasil']=1;
						$data['satuan']=$inp['idsatuan'];
						$data['iditem']=$inp['iditem'];
						$data['namaitem']=$inp['namaitem'];
						$data['item_idkelompok']=$inp['item_idkelompok'];
						
				}
				
				echo json_encode($data);
    }
    else{
				/*Action Update Data*/
				$gabung = implode("^",$inp['idsatuan']);
				$update =$mysqli->query( "UPDATE M_ITEM SET 
											NAMAITEM		='$inp[namaitem]',
											ITEM_IDSATUAN	='$gabung',
											ITEM_IDKELOMPOKITEM	='$inp[item_idkelompok]',
											ITEM_LASTUPDATE	='$now'
										WHERE IDITEM='$inp[iditem]' ") ;
				// oci_execute($update);
				// oci_commit;
				$data['hasil']=1;
				echo json_encode($data);
    }
	break;
	
	
}