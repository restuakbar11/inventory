<?php
include ('../../config/connect.php');
date_default_timezone_set('Asia/Jakarta');
$tgl =date('Y-m-d');
$now =date('Y-m-d H:i:s');
$data_array=array();
switch ($_POST['act']){

        case "form":
        $KODE_KULKAS = $_POST['kode_kulkas'];
        $SUBDEPT = $_POST['id_subDept'];
        $getData =$mysqli->query( "select * from M_SUBDEPARTMENTKULKAS where KODE_KULKAS = '$KODE_KULKAS' AND ID_SUBDEPARTMENT='$SUBDEPT'");
        // oci_execute($getData);
        $r =mysqli_fetch_array($getData);

        $data['kd_kulkas']     =$r['KODE_KULKAS'];
        $data['id_subdepartment']       =$r['ID_SUBDEPARTMENT'];
        echo json_encode($data);
    break;

    case "simpan":
        $KODE_KULKAS = $_POST['kode_kulkas'];
        $ID_SUBDEPARTMENT = $_POST['id_subdepartment'];
		$USERID = $_POST['userid'];

        $check = $mysqli->query( "select KODE_KULKAS, NAMA_SUBDEPARTMENT from M_SUBDEPARTMENTKULKAS k 
		JOIN M_SUBDEPARTMENT s ON s.ID_SUBDEPARTMENT = k.ID_SUBDEPARTMENT
		where KODE_KULKAS = '$KODE_KULKAS' AND SUBDEPARTMENTKULKASISACTIVE = 'Y'");
        // oci_execute($check);
        $count = mysqli_num_rows($check);
       // echo $count;
	   $subdept = $count['NAMA_SUBDEPARTMENT'];
	echo $subdept;
        if($count > 0){
            $return = array('status'=> 'FAILED : Kulkas masih aktif digunakan');               
        } else {
			$sql = "INSERT INTO M_SUBDEPARTMENTKULKAS (KODE_KULKAS,ID_SUBDEPARTMENT,USERID,LASTUPDATE) 
			values ('$KODE_KULKAS','$ID_SUBDEPARTMENT','$USERID','$now')";
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
    
	case "update":
		$id_subdepartment	= $_POST['id_subdepartment'];
		$KODE_KULKAS		= $_POST['kode_kulkas'];
		$userid				= $_POST['userid'];
		$sql				="UPDATE M_SUBDEPARTMENTKULKAS SET ID_SUBDEPARTMENT = $id_subdepartment where KODE_KULKAS = '$KODE_KULKAS'";
		//echo $sql;
		$update =$mysqli->query( $sql);
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
		$KODE_KULKAS = $_POST['kode_kulkas'];
		$delete =$mysqli->query( "UPDATE M_SUBDEPARTMENTKULKAS SET SUBDEPARTMENTKULKASISACTIVE='N' where KODE_KULKAS = '$KODE_KULKAS'");
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