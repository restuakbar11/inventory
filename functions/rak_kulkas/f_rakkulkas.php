<?php
include ('../../config/connect.php');
date_default_timezone_set('Asia/Jakarta');
$tgl =date('Y-m-d');
$now =date('Y-m-d H:i:s');
$data_array=array();
switch ($_POST['act']){

    case "simpan":
        $KODE_RAKKULKAS = $_POST['kode_rakkulkas'];
        $NAMA_RAKKULKAS = $_POST['nama_rakkulkas'];
        $JENIS_RAKKULKAS = $_POST['jenis_rakkulkas'];
        $KODEKULKAS = $_POST['kulkas'];
		$USERID = $_POST['userid'];

        $check = $mysqli->query( "select KODE_RAKKULKAS from M_RAKKULKAS where KODE_RAKKULKAS = '$KODE_RAKKULKAS' AND RAKKULKASISACTIVE='Y' ");
        // oci_execute($check);
        $count = mysqli_num_rows($check);
       // echo $count;

        if($count > 0){
            $return = array('status'=> 'FAILED : Kode Rak Kulkas sudah terdaftar');               
        } else {
			$sql = "INSERT INTO M_RAKKULKAS (KODE_RAKKULKAS,NAMA_RAKKULKAS,JENIS_RAKKULKAS,M_RAKKODEKULKAS,USERID,LASTUPDATE) 
			values ('$KODE_RAKKULKAS','$NAMA_RAKKULKAS','$JENIS_RAKKULKAS','$KODEKULKAS','$USERID','$now')";
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
		$KODE_RAKKULKAS = $_POST['kode_rakkulkas'];
		$delete =$mysqli->query( "UPDATE M_RAKKULKAS SET RAKKULKASISACTIVE='N' where KODE_RAKKULKAS = '$KODE_RAKKULKAS'");
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

}
?>