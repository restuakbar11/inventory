<?php
include ('../../config/connect.php');
date_default_timezone_set('Asia/Jakarta');
$tgl =date('Y-m-d');
$now =date('Y-m-d H:i:s');
$data_array=array();
switch ($_POST['act']){

	case "getData":
		$KODE_KULKAS = $_POST['kode_kulkas'];
		$getData =$mysqli->query( "select * from M_KULKAS where KODE_KULKAS = '$KODE_KULKAS'");
		// oci_execute($getData);
		while ($row =oci_fetch_assoc($getData)){
			array_push($data_array,$row);
		}
		echo json_encode($data_array);
    break;

    case "form":
        $KODE_KULKAS = $_POST['kode_kulkas'];
        $getData =$mysqli->query( "select * from M_KULKAS where KODE_KULKAS = '$KODE_KULKAS'");
        // oci_execute($getData);
        $r =mysqli_fetch_array($getData);

        $data['kd_kulkas']     =$r['KODE_KULKAS'];
        $data['id_gudang']       =$r['ID_GUDANG'];
        $data['id_typekulkas']     =$r['ID_TYPEKULKAS'];
        $data['ip_kulkas']       =$r['IP_KULKAS'];
        echo json_encode($data);
    break;

    case "simpan":
        $KODE_KULKAS = $_POST['kode_kulkas'];
        //$NAMA_KULKAS = $_POST['nama_kulkas'];
		$ID_GUDANG = $_POST['id_gudang'];
        $TYPE_KULKAS = $_POST['id_typekulkas'];
        $IP_KULKAS = $_POST['ip_kulkas'];
		$USERID = $_POST['userid'];

        $check = $mysqli->query( "select KODE_KULKAS from M_KULKAS where KODE_KULKAS = '$KODE_KULKAS' AND KULKASISACTIVE='Y'");
        // oci_execute($check);
        $count = mysqli_num_rows($check);
       // echo $count;

        if($count > 0){
            $return = array('status'=> 'FAILED : Kode Kulkas sudah terdaftar');               
        } else {
			/*$sql = "INSERT INTO M_KULKAS (KODE_KULKAS,NAMA_KULKAS,ID_TYPEKULKAS,IP_KULKAS,USERNAME,KULKASLASTUPDATE) 
			values ('$KODE_KULKAS','$NAMA_KULKAS',$TYPE_KULKAS,'$IP_KULKAS','$USERID','$now')";*/
			$sql = "INSERT INTO M_KULKAS (KODE_KULKAS,ID_TYPEKULKAS,IP_KULKAS,USERNAME,KULKASLASTUPDATE,ID_GUDANG) 
			values ('$KODE_KULKAS',$TYPE_KULKAS,'$IP_KULKAS','$USERID','$now',$ID_GUDANG)";
			//echo $sql;
            $simpan =$mysqli->query($sql );
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
		$KODE_KULKAS = $_POST['kode_kulkas'];
		$delete =$mysqli->query( "UPDATE M_KULKAS SET KULKASISACTIVE='N' where KODE_KULKAS = '$KODE_KULKAS'");
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
        $KODE_KULKAS = $_POST['kode_kulkas'];
        $ID_GUDANG = $_POST['id_gudang'];
        $TYPE_KULKAS = $_POST['id_typekulkas'];
        $IP_KULKAS = $_POST['ip_kulkas'];
        $USERID = $_POST['userid'];
        $update =$mysqli->query( "UPDATE M_KULKAS SET KODE_KULKAS='$KODE_KULKAS', ID_TYPEKULKAS=$TYPE_KULKAS, USERNAME='$USERID', IP_KULKAS='$IP_KULKAS' where KODE_KULKAS = '$KODE_KULKAS'");
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