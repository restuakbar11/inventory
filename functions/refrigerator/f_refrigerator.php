<?php
include('../../config/connect.php');
date_default_timezone_set('Asia/Jakarta');
$tgl = date('Y-m-d');
$data_array = array();
switch ($_POST['act']) {

	case "getTemperature":
		$KODE_KULKAS = $_POST['kode_kulkas'];
		$query = strtoupper("SELECT q.* FROM (SELECT TANGGAL,JAM,COLD_ROOM 
		FROM KULKAS_DATA_LOG where KODE_KULKAS='$KODE_KULKAS' AND TANGGAL = '$tgl' order by JAM DESC)q limit 500");
		//echo $query;
		$getData = $mysqli->query($query);

		// oci_execute($getData);
		while ($row = mysqli_fetch_assoc($getData)) {
			$date = $row['TANGGAL'] . " " . $row['JAM'] . " UTC";

			$strtime = strtotime($date);
			$strtimefull = $strtime * 1000;
			$data_array[] = array("datetime" => $strtimefull, "temperature" => $row['COLD_ROOM']);
		}
		echo json_encode($data_array);

		break;


	case "getVoltage":
		$KODE_KULKAS = $_POST['kode_kulkas'];
		$query = strtoupper("SELECT q.* FROM (SELECT TANGGAL,JAM,VOLTAGE FROM KULKAS_DATA_LOG 
		where KODE_KULKAS='$KODE_KULKAS' AND TANGGAL = '$tgl' order by JAM DESC)q limit 500");
		$getData = $mysqli->query($query);
		// oci_execute($getData);
		while ($row = mysqli_fetch_assoc($getData)) {
			$date = $row['TANGGAL'] . " " . $row['JAM'] . " UTC";

			$strtime = strtotime($date);
			$strtimefull = $strtime * 1000;
			$data_array[] = array("datetime" => $strtimefull, "voltage" => $row['VOLTAGE']);
		}
		echo json_encode($data_array);

		break;

	case "getPower":
		$KODE_KULKAS = $_POST['kode_kulkas'];
		$query = strtoupper("SELECT q.* FROM (SELECT TANGGAL,JAM,POWER FROM KULKAS_DATA_LOG 
		where KODE_KULKAS='$KODE_KULKAS' AND TANGGAL = '$tgl' order by JAM DESC)q limit 500");
		//echo $query;
		$getData = $mysqli->query($query);
		// oci_execute($getData);
		while ($row = mysqli_fetch_assoc($getData)) {
			$date = $row['TANGGAL'] . " " . $row['JAM'] . " UTC";

			$strtime = strtotime($date);
			$strtimefull = $strtime * 1000;
			$data_array[] = array("datetime" => $strtimefull, "power" => $row['POWER']);
		}
		echo json_encode($data_array);

		break;
}
