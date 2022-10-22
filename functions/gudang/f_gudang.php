<?php
include ('../../config/connect.php');
date_default_timezone_set('Asia/Jakarta');
$tgl =date('Y-m-d');
$now =date('Y-m-d H:i:s');
$data_array=array();

if($_POST['act']=='delete'){
	$ID_GUDANG = $_POST['id_gudang'];
		$delete =$mysqli->query( "UPDATE M_GUDANG SET GUDANGAKTIF='N' where ID_GUDANG = '$ID_GUDANG'");
        // oci_execute($delete);
        // oci_commit($oci);
		if(!$delete)
        {
            $return = array('status'=> 'FAILED');
        } else {
            $return = array('status'=> 'SUCCESS');
        }
        echo json_encode($return);
}
else if($_POST['act']=='form'){
	$sql =$mysqli->query( "SELECT c.NAMA_DEPARTMENT,c.ID_DEPARTMENT,a.ISKULKAS,a.ID_GUDANG,a.NAMAGUDANG from M_GUDANG a
    join M_DEPARTMENT c on c.ID_DEPARTMENT=a.ID_DEPARTMENT and c.DEPARTMENTISACTIVE='Y'
	where a.ID_GUDANG='$_POST[id_gudang]' ");
	// oci_execute($sql);
	$r =mysqli_fetch_array($sql);
	
    $data['NAMA_DEPARTMENT']		=$r['NAMA_DEPARTMENT'];
    $data['ISKULKAS']		=$r['ISKULKAS'];
    $data['ID_DEPARTMENT']		=$r['ID_DEPARTMENT'];
    $data['ID_GUDANG']		=$r['ID_GUDANG'];
    $data['NAMAGUDANG']		=$r['NAMAGUDANG'];
    echo json_encode($data);
}
else{
        $id_gudang = $_POST['item'];
        $kulkas=$_POST['iskulkas'];
        $namagudang =$id_gudang['namagudang'];
        $id_department =$id_gudang['id_department'];
        $userid =$id_gudang['userid'];
if($id_gudang['act']=='add'){
    $sql = "INSERT INTO M_GUDANG (NAMAGUDANG,ID_DEPARTMENT,USERID,LASTUPDATE,ISKULKAS) 
			values ('$namagudang','$id_department','$userid',CURRENT_TIMESTAMP,'$kulkas')";
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
else{
    
	$sql = "update M_GUDANG set NAMAGUDANG='$namagudang',
                    ID_DEPARTMENT='$id_department',
					USERID='$userid',
					LASTUPDATE=CURRENT_TIMESTAMP,
					ISKULKAS='$kulkas'
					where ID_GUDANG='$id_gudang[id_gudang]'";
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
}
?>