<?php
error_reporting(0);
include "../../config/connect.php";
include "../numbering/f_numbering.php";
session_start();
$conn ="../../config/connect.php";

date_default_timezone_set('Asia/Jakarta');
$now			=date('Y-m-d H:i:s');
$username		=$_SESSION['username'];


switch ($_POST['act']){
	
	
	case "getNumber":
	$number =Cek_Numbering('Kelompok Item', $conn);
	$data['NUMBER']		=$number;
    echo json_encode($data);
	break;
	
	
	
	case "form":
	$sql =$mysqli->query( "SELECT * FROM M_KELOMPOKITEM WHERE IDKELOMPOKITEM='$_POST[kelompokitemID]' ");
	// oci_execute($sql);
	$r =mysqli_fetch_array($sql);
	
    $data['NAMAKELOMPOKITEM']	=$r['NAMAKELOMPOKITEM'];
    $data['IDKELOMPOKITEM']		=$r['IDKELOMPOKITEM'];
    echo json_encode($data);
    break;
	
	
	
	case "hapus":
	$delete =$mysqli->query( "UPDATE M_KELOMPOKITEM SET 
							KELOMPOKITEMISACTIVE='N',
							KELOMPOKITEMLASTUPDATE='$now'
						WHERE IDKELOMPOKITEM='$_POST[kelompokitemID]' ");
	// oci_execute($delete);
	// oci_commit;
    $data['hasil']=1;
    echo json_encode($data);
	break;
	
	
	
	case "save":
	$inp=$_POST['kelompokitem'];
    if($inp['act']=='add'){
				/*Action Add Data*/
				$cek_name =$mysqli->query( "SELECT * FROM M_KELOMPOKITEM WHERE NAMAKELOMPOKITEM='$inp[nm_kelompokitem]' AND KELOMPOKITEMISACTIVE='Y'");
				// oci_execute($cek_name);
				$jml =mysqli_num_rows($cek_name);
				
				if($jml>0) {
					$data['hasil']=0;
				} else {
						$number =Numbering('Kelompok Item', $conn);
						$input =$mysqli->query( "INSERT INTO M_KELOMPOKITEM 
												(IDKELOMPOKITEM,NAMAKELOMPOKITEM,KELOMPOKITEMUSERNAME,KELOMPOKITEMLASTUPDATE) VALUES
												('$number','$inp[nm_kelompokitem]','$username','$now')
												") ;
						// oci_execute($input);
						// oci_commit;
						$data['hasil']=1;
						$data['number']=$number;
				}
				
				echo json_encode($data);
    }
    else{
				/*Action Update Data*/
				$update =$mysqli->query( "UPDATE M_KELOMPOKITEM SET 
											NAMAKELOMPOKITEM		='$inp[nm_kelompokitem]',
											KELOMPOKITEMLASTUPDATE	='$now'
										WHERE IDKELOMPOKITEM='$inp[kelompokitemID]' ") ;
				// oci_execute($update);
				// oci_commit;
				$data['hasil']=1;
				echo json_encode($data);
    }
	break;
	
	
}