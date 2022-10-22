<?php
include ('../../config/connect.php');
date_default_timezone_set('Asia/Jakarta');
$tgl =date('Y-m-d');
$now =date('Y-m-d H:i:s');
$data_array=array();
switch ($_POST['act']){

    case "form":
        $id_subdepartment = $_POST['id_subdepartment'];
        $getData =$mysqli->query( "select * from m_subdepartment where id_subdepartment = '$id_subdepartment'");
        // oci_execute($getData);
        $r =mysqli_fetch_array($getData);
		
		$data['id_subdepartment']     =$r['ID_SUBDEPARTMENT'];
        $data['id_department']     =$r['ID_DEPARTMENT'];
        $data['id_ruangan']       =$r['ID_RUANGAN'];
        $data['nama_subdepartment']       =$r['NAMA_SUBDEPARTMENT'];
        echo json_encode($data);
    break;

    case "simpan":
        $NAMA_SUBDEPARTMENT = $_POST['nama_subdepartment'];
		$ID_RUANGAN = $_POST['id_ruangan'];
		$ID_DEPARTMENT = $_POST['id_department'];
		$USERID = $_POST['userid'];

        $check = $mysqli->query( "select NAMA_SUBDEPARTMENT from M_SUBDEPARTMENT where NAMA_SUBDEPARTMENT = '$NAMA_SUBDEPARTMENT' AND SUBDEPARTMENTISACTIVE='Y'");
        // oci_execute($check);
        $count = mysqli_num_rows($check);
       // echo $count;

        if($count > 0){
            $return = array('status'=> 'FAILED : Sub Department sudah terdaftar');               
        } else {
            $simpan =$mysqli->query( "INSERT INTO M_SUBDEPARTMENT (ID_DEPARTMENT,NAMA_SUBDEPARTMENT,ID_RUANGAN,USERID,SUBDEPARTMENTLASTUPDATE) 
			values ('$ID_DEPARTMENT','$NAMA_SUBDEPARTMENT','$ID_RUANGAN','$USERID','$now')");
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
		$ID_SUBDEPARTMENT = $_POST['id_subdepartment'];
		$NAMA_SUBDEPARTMENT = $_POST['nama_subdepartment'];
		$ID_RUANGAN = $_POST['id_ruangan'];
		$USERNAME = $_POST['userid'];
		$ID_DEPARTMENT = $_POST['id_department'];
		$sql = "UPDATE M_SUBDEPARTMENT SET 
		NAMA_SUBDEPARTMENT = '$NAMA_SUBDEPARTMENT',
		ID_RUANGAN = $ID_RUANGAN,
		USERID = '$USERNAME',
		ID_DEPARTMENT = $ID_DEPARTMENT
		where ID_SUBDEPARTMENT = '$ID_SUBDEPARTMENT'";
		//echo $sql;
		$update =$mysqli->query($sql );
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
		$ID_SUBDEPARTMENT = $_POST['id_subdepartment'];
		$delete =$mysqli->query( "UPDATE M_SUBDEPARTMENT SET SUBDEPARTMENTISACTIVE='N' where ID_SUBDEPARTMENT = '$ID_SUBDEPARTMENT'");
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