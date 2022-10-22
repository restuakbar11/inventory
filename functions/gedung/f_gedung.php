<?php
include ('../../config/connect.php');
date_default_timezone_set('Asia/Jakarta');
$tgl =date('Y-m-d');
$now =date('Y-m-d h:i:s');
$data_array=array();
switch ($_POST['act']){


    case "form":
        $id_gedung = $_POST['id_gedung'];
        $getData =$mysqli->query( "select * from M_GEDUNG where ID_GEDUNG = '$id_gedung'");
        // oci_execute($getData);
        $r =mysqli_fetch_array($getData);
        
        $data['nm_gedung']      =$r['NAMA_GEDUNG'];
        $data['jml_lantai']     =$r['JUMLAH_LANTAI'];
        echo json_encode($data);
    break;

    case "simpan":
        $NAMA_GEDUNG = $_POST['nama_gedung'];
		$USERNAME = $_POST['userid'];
		$JUMLAH_LANTAI = $_POST['jumlah_lantai'];

        $check = $mysqli->query( "select NAMA_GEDUNG from M_GEDUNG where NAMA_GEDUNG = '$NAMA_GEDUNG' and GEDUNGISACTIVE='Y' ");
        // oci_execute($check);
        $count = mysqli_num_rows($check);
       // echo $count;

        if($count > 0){
            $return = array('status'=> 'FAILED : Gedung sudah terdaftar', 'info' => 0);               
        } else {
		$sql = "INSERT INTO M_GEDUNG (NAMA_GEDUNG,JUMLAH_LANTAI,USERNAME,GEDUNGLASTUPDATE) 
			values ('$NAMA_GEDUNG',$JUMLAH_LANTAI,'$USERNAME','$now')";
            $simpan =$mysqli->query( $sql);
            // oci_execute($simpan);
            // oci_commit($oci);
            	if(!$simpan){
                    $return = array('status'=> 'FAILED');
                } else {
                    $return = array('status'=> 'SUCCESS');
                }     
        }   
        
        
        echo json_encode($return);
		
    break;
    
	 case "update":
		$ID_GEDUNG 		= $_POST['id_gedung'];
		$NAMA_GEDUNG 	= $_POST['nama_gedung'];
		$JUMLAH_LANTAI 	= $_POST['jumlah_lantai'];
		$update =$mysqli->query( "UPDATE M_GEDUNG SET NAMA_GEDUNG='$NAMA_GEDUNG', JUMLAH_LANTAI=$JUMLAH_LANTAI where ID_GEDUNG = '$ID_GEDUNG'");
        // oci_execute($update);
        // oci_commit($oci);
		if(!$update)
        {
            $return = array('status'=> 'FAILED');
        } else {
            $return = array('status'=> 'SUCCESS');
        }
        echo json_encode($return);
		
	break;
    
    case "delete":
		$ID_GEDUNG = $_POST['id_gedung'];
		$delete =$mysqli->query( "UPDATE M_GEDUNG SET GEDUNGISACTIVE='N' where ID_GEDUNG = '$ID_GEDUNG'");
        // oci_execute($delete);
        // oci_commit($oci);
		if(!$delete)
        {
            $return = array('status'=> 'FAILED');
        } else {
            $return = array('status'=> 'SUCCESS');
        }
        echo json_encode($return);
	break;
	
	case "getLantai":
        $ID_GEDUNG = $_POST['id_gedung'];

        $check = $mysqli->query( "select * from M_GEDUNG where ID_GEDUNG = '$ID_GEDUNG'");
        // oci_execute($check);
        $count = mysqli_fetch_array($check);
       // echo $count;
	   $jml_lantai = $count['JUMLAH_LANTAI'];
		
		for($i=1; $i <= $jml_lantai; $i++){
			$return = array('lantai'=> $i);                                     
		}
		echo json_encode($return);
    break;

}
?>