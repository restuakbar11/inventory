<?php
include ('../../config/connect.php');
date_default_timezone_set('Asia/Jakarta');
$tgl =date('Y-m-d');
$now =date('Y-m-d H:i:s');
$data_array=array();

if($_POST['act']=='delete'){
	$ID_RAKGUDANG = $_POST['id_rakgudang'];
		$delete =$mysqli->query( "UPDATE M_RAKGUDANG SET RAKGUDANGAKTIF='N' where ID_RAKGUDANG = '$ID_RAKGUDANG'");
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
	$sql =$mysqli->query( "SELECT a.ID_RAKGUDANG,a.NAMARAKGUDANG,c.NAMA_DEPARTMENT,c.ID_DEPARTMENT,b.ID_GUDANG,b.NAMAGUDANG FROM M_RAKGUDANG a
	JOIN M_GUDANG b on a.ID_GUDANG=b.ID_GUDANG and b.GUDANGAKTIF='Y'
	join M_DEPARTMENT c on c.ID_DEPARTMENT=b.ID_DEPARTMENT and c.DEPARTMENTISACTIVE='Y'
	where a.ID_RAKGUDANG='$_POST[id_rakgudang]' ");
	// oci_execute($sql);
	$r =mysqli_fetch_array($sql);
	
    $data['ID_RAKGUDANG']		=$r['ID_RAKGUDANG'];
    $data['NAMARAKGUDANG']		=$r['NAMARAKGUDANG'];
    $data['NAMA_DEPARTMENT']		=$r['NAMA_DEPARTMENT'];
    $data['ID_DEPARTMENT']		=$r['ID_DEPARTMENT'];
    $data['ID_GUDANG']		=$r['ID_GUDANG'];
    $data['NAMAGUDANG']		=$r['NAMAGUDANG'];
    echo json_encode($data);
}
else{
   $id_department = $_POST['id_department'];
   $id_gudang = $_POST['id_gudang'];
   $namarakgudang = $_POST['namarakgudang']; 
   $idrakgudang = $_POST['idrakgudang'];  
   $userid = $_POST['userid']; 
if($_POST['act']=='add'){
			$sql = "INSERT INTO M_RAKGUDANG (NAMARAKGUDANG,ID_GUDANG,USERID,LASTUPDATE) 
			values ('{$namarakgudang}','{$id_gudang}','{$userid}',CURRENT_TIMESTAMP)";
			//echo $sql;
            $simpan =$mysqli->query($sql );
            // oci_execute($simpan);
            // oci_commit($oci);
            if(!$simpan)
                {
                    $return = array('status'=> 'FAILED');
                } else {
                    $return = array('status'=> 'SUCCESS','id_department'=>$id_department,'id_gudang'=>$id_gudang,'namarakgudang'=>$namarakgudang,'userid'=>$userid);
                }     
			}
else{
	$sql = "update M_RAKGUDANG set NAMARAKGUDANG='{$namarakgudang}',
					USERID='{$userid}',
					LASTUPDATE=CURRENT_TIMESTAMP
					where ID_RAKGUDANG='$idrakgudang'";
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