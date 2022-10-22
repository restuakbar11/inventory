<?php
include ('../../config/connect.php');
date_default_timezone_set('Asia/Jakarta');
$tgl =date('Y-m-d');
$now =date('Y-m-d H:i:s');
$data_array=array();
switch ($_POST['act']){

    case "getList":
		$sql = "select ID_TYPEKULKAS, NAMA_TYPEKULKAS from M_TYPEKULKAS where TYPEKULKASISACTIVE = 'Y' order by NAMA_TYPEKULKAS ASC";
        $check = $mysqli->query( $sql);
        // oci_execute($check);
        while($count = oci_fetch_assoc($check)){
			$data_array[] = array("id_type" => $count['ID_TYPEKULKAS'], "nm_kulkas" => $count['NAMA_TYPEKULKAS']);
			
		}
		echo json_encode($data_array);
	break;
}
?>