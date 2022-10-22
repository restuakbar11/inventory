<?php
include ('../../config/connect.php');
date_default_timezone_set('Asia/Jakarta');
$tgl =date('Y-m-d');
$now =date('Y-m-d H:i:s');
$data_array=array();

switch ($_POST['act']){
	
    case "form":
        $id_department = $_POST['id_department'];
        $getData =$mysqli->query( "select * from M_DEPARTMENT where ID_DEPARTMENT = '$id_department'");
        // oci_execute($getData);
        $r =mysqli_fetch_array($getData);

        $data['id_department']     =$r['ID_DEPARTMENT'];
        $data['nama_department']       =$r['NAMA_DEPARTMENT'];
        echo json_encode($data);
    break;

	case "DataList":
		$sql = "select ID_DEPARTMENT,NAMA_DEPARTMENT from M_DEPARTMENT where DEPARTMENTISACTIVE='Y'";
		$getData = $mysqli->query($sql);
		// oci_execute($getData);
		while ($row =oci_fetch_assoc($getData)){
			array_push($data_array,$row);
		}
		echo json_encode($data_array);
	break ;
	
    case "simpan":
        $NAMA_DEPARTMENT = $_POST['nama_department'];
		$USERID = $_POST['userid'];
		//echo $sql;
		$sql = "select ID_DEPARTMENT,NAMA_DEPARTMENT from M_DEPARTMENT where NAMA_DEPARTMENT = '$NAMA_DEPARTMENT' and DEPARTMENTISACTIVE='Y'";
        $check = $mysqli->query( $sql);
        // oci_execute($check);
        $count = mysqli_num_rows($check);
       // echo $count;

        if($count > 0){
            $return = array('status'=> 'FAILED : Departemen sudah terdaftar');               
        } else {
		$sql_insert = "INSERT INTO M_DEPARTMENT (NAMA_DEPARTMENT,USERID,DEPARTMENTLASTUPDATE) 
			values ('$NAMA_DEPARTMENT','$USERID','$now')";
			//echo $sql_insert;
            $simpan =$mysqli->query( $sql_insert);
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
		$ID_DEPARTMENT = $_POST['id_department'];
		$NAMA_DEPARTMENT = $_POST['nama_department'];
		$update =$mysqli->query( "UPDATE M_DEPARTMENT SET NAMA_DEPARTMENT='$NAMA_DEPARTMENT' where ID_DEPARTMENT = '$ID_DEPARTMENT'");
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
		$ID_DEPARTMENT = $_POST['id_department'];
		$delete =$mysqli->query( "UPDATE M_DEPARTMENT SET DEPARTMENTISACTIVE='N' where ID_DEPARTMENT = '$ID_DEPARTMENT'");
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