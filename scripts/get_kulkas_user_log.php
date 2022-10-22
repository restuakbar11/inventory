<?php
include '../config/connect.php';
//echo $oci;

//get all kulkas
$qry_kulkas = "select * from M_KULKAS where KULKASISACTIVE = 'Y'";
$g_kulkas = $mysqli->query($qry_kulkas);
// oci_execute($g_kulkas);
while ($jack = mysqli_fetch_array($g_kulkas)) {

	$KODE_KULKAS = $jack['KODE_KULKAS'];
	$IP_KULKAS = $jack['IP_KULKAS'];


	//get last data kulkas
	$query = "SELECT MAX(ROWID_KULKAS) as ROWID_KULKAS FROM KULKAS_USER_LOG WHERE KODE_KULKAS = '$KODE_KULKAS'";
	//echo $qry;
	$getData = $mysqli->query($query);
	// oci_execute($getData);
	$row = mysqli_fetch_assoc($getData);

	$ROWID_KULKAS = $row['ROWID_KULKAS'];

	if ($ROWID_KULKAS == null) {
		$ROWID_KULKAS = 0;
	}

	$url = "http://" . $IP_KULKAS . "/xml_get_log_open_doors.php";
	// echo $url . '<br>';
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'id=' . $ROWID_KULKAS);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	curl_close($ch);

	$object = json_decode($output, true);

	//var_dump($object);

	//loop
	foreach ($object as $row) {

		$kode_kulkas = $row['kode_kulkas'];
		$userid = $row['USER'];
		$date = $row['TANGGAL']; //23/10/19
		$time = $row['JAM'];
		$sec = $row['DETIK'];
		$rowid = $row['ROWID'];

		$day = substr($date, 0, 2);
		$month = substr($date, 3, 2);
		$year = substr($date, 6, 2);

		$newdate = "20" . $year . '-' . $month . '-' . $day;

		$newdate = date('Y-m-d', strtotime($newdate));
		$qry = "INSERT INTO KULKAS_USER_LOG (KODE_KULKAS,USERID, TANGGAL,JAM,DETIK,ROWID_KULKAS) values ('$kode_kulkas','$userid','$newdate','$time','$sec',$rowid)";
		//echo $qry.'<br>';	
		$simpan = $mysqli->query($qry);
		// oci_execute($simpan);	
		// oci_commit($oci);
		if (!$simpan) {
			$return = array('status' => 'FAILED');
			print_r($return);
		} else {
			$return = array('status' => 'SUCCESS');
			print_r($return);
		}
	}
}
