<?php
include ('../../config/connect.php');
date_default_timezone_set('Asia/Jakarta');
$tgl =date('Y-m-d');
$now =date('Y-m-d H:i:s');
$data_array=array();

switch ($_POST['act']){

    case "form":
        $id_ruangan = $_POST['id_ruangan'];
        $getData =$mysqli->query( "select * from M_RUANGAN where ID_RUANGAN = '$id_ruangan'");
        // oci_execute($getData);
        $r =mysqli_fetch_array($getData);

        $data['id_gedung']     =$r['ID_GEDUNG'];
        $data['nm_ruangan']       =$r['NAMA_RUANGAN'];
        $data['lantai']     =$r['LANTAI'];
        echo json_encode($data);
    break;

	case "DataList":
		$sql="select ID_RUANGAN,NAMA_RUANGAN from M_RUANGAN where RUANGANISACTIVE='Y'";
		$getData = $mysqli->query($sql);
		// oci_execute($getData);
		while ($row =oci_fetch_assoc($getData)){
			array_push($data_array,$row);
		}
		echo json_encode($data_array);
	break ;
	
    case "simpan":
        $NAMA_RUANGAN = $_POST['nama_ruangan'];
		$ID_GEDUNG = $_POST['gedung'];
		$LANTAI = $_POST['lantai'];
		$USERID = $_POST['userid'];
		
		$sql =("SELECT NAMA_RUANGAN FROM M_RUANGAN WHERE NAMA_RUANGAN='$NAMA_RUANGAN' AND RUANGANISACTIVE='Y' ");
        $check = $mysqli->query( $sql);
        // oci_execute($check);
        $count = mysqli_num_rows($check);
       // echo $count;

        if($count > 0){
            $return = array('status'=> 'FAILED : Ruangan sudah terdaftar');               
        } else {
            $simpan =$mysqli->query( "INSERT INTO M_RUANGAN (ID_GEDUNG,NAMA_RUANGAN,LANTAI,USERID,RUANGANLASTUPDATE) 
			values ('$ID_GEDUNG','$NAMA_RUANGAN','$LANTAI','$USERID','$now')");
            // oci_execute($simpan);
            // oci_commit($oci);
            if(!$simpan)
                {
                    $return = array('status'=> 'FAILED');
                } else {
                    $return = array('status'=> 'SUCCESS');
                }     
             
        }
        
        echo json_encode($return);
		
    break;
    
    
    case "delete":
		$ID_RUANGAN = $_POST['id_ruangan'];
		$delete =$mysqli->query( "UPDATE M_RUANGAN SET RUANGANISACTIVE='N' where ID_RUANGAN = '$ID_RUANGAN'");
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

    case "update":
        $ID_RUANGAN = $_POST['id_ruangan'];
        $NAMA_RUANGAN = $_POST['nama_ruangan'];
        $ID_GEDUNG = $_POST['gedung'];
        $LANTAI = $_POST['lantai'];
        $USERID = $_POST['userid'];
        $update =$mysqli->query( "UPDATE M_RUANGAN SET ID_GEDUNG = '$ID_GEDUNG', NAMA_RUANGAN='$NAMA_RUANGAN', LANTAI=$LANTAI, USERID='$USERID' WHERE ID_RUANGAN = '$ID_RUANGAN'");
        //echo $update;
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

}
?>