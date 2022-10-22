<?php
//echo "test";
include '../config/connect.php';
//echo $oci;


//get all kulkas
$qry_kulkas = "select * from M_KULKAS where KULKASISACTIVE = 'Y'";
// echo $qry_kulkas;
// echo "\n";
$g_kulkas = $mysqli->query($qry_kulkas);
// oci_execute($g_kulkas);
while ($jack = mysqli_fetch_array($g_kulkas)) {

	// $KODE_KULKAS = $jack['KODE_KULKAS'];
	// $IP_KULKAS = $jack['IP_KULKAS'];

	//debug
	$KODE_KULKAS = "69499";
	$IP_KULKAS = "192.168.10.10";

	//get last data kulkas
	$query = "SELECT MAX(ROWID_DATA_LOG) as ROWID_DATA_LOG FROM KULKAS_DATA_LOG WHERE KODE_KULKAS = '$KODE_KULKAS'";
	echo $query;
	echo "\n";
	$getData = $mysqli->query($query);
	// oci_execute($getData);
	$row = mysqli_fetch_assoc($getData);

	$ROWID_DATA_LOG = $row['ROWID_DATA_LOG'];



	if ($ROWID_DATA_LOG == null) {
		$ROWID_DATA_LOG = 0;
	}

	// echo $ROWID_DATA_LOG;
	// echo "\n";
	//break;


	$url = "http://" . $IP_KULKAS . "/xml_get_log_voltage.php";
	echo $url;
	echo "\n";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'id=' . $ROWID_DATA_LOG);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	curl_close($ch);

	$object = json_decode($output, true);

	// var_dump($object);
	// echo "\n";
	// break;

	$alert = "";
	//loop
	foreach ($object as $row) {


		$kode_kulkas = $row['kode_kulkas'];
		$date = $row['Date'];
		$watt = $row['Watt'];
		$consume = $row['Consume'];
		$voltage = $row['Voltage'];
		$min_temp = $row['LowTempLimit'];
		$max_temp = $row['HighTempLimit'];
		$cold_room = $row['Cold_room'];
		$rowid = $row['ROWID'];

		if ($cold_room > $max_temp) {
			$alert = 'H';
		}
		if ($cold_room < $min_temp) {
			$alert = 'L';
		}

		// echo "tgl : " . $date;
		// echo "\n";
		//22/02/16 00:04:30

		$year = substr($date, 0, 2);
		$month = substr($date, 3, 2);
		$day = substr($date, 6, 2);

		$hour = substr($date, 9, 2);
		$min = substr($date, 12, 2);
		$sec = substr($date, 15, 2);
		$newdate = "20" . $year . '-' . $month . '-' . $day;
		$newtime = $hour . ':' . $min . ':' . $sec;
		$newdate = date('Y-m-d', strtotime($newdate));
		$qry = "INSERT INTO KULKAS_DATA_LOG (KODE_KULKAS,TANGGAL,JAM,COLD_ROOM,MIN_TEMP,MAX_TEMP,VOLTAGE,POWER,ALERT_COLD_ROOM,ROWID_DATA_LOG) 
		values ('$kode_kulkas','$newdate','$newtime','$cold_room','$min_temp','$max_temp','$voltage','$watt','$alert',$rowid)";
		echo $qry;
		echo "\n";
		$simpan = $mysqli->query($qry);
		// oci_execute($simpan);
		// oci_commit($oci);
		if (!$simpan) {
			$return = array('status' => 'FAILED');
		} else {
			$return = array('status' => 'SUCCESS');
		}

		echo $return;
	}
}
