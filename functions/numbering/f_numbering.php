<?php
function Numbering($input, $conn) {
	//include '../../config/connect.php';
	include ($conn);
	$tgl=date('Y-m-d'); 
	$now =date('Y-m-d H:i:s');
	$a=$input; 
	//$a='Kulkas';
	$qry =$mysqli->query( "SELECT NUMBERING_MODUL,NUMBERING_AWALAN,NUMBERING_TENGAH,NUMBERING_COUNTER,NUMBERING_DIGIT,NUMBERING_RESET,
							NUMBERING_LASTUPDATE,date_format(NUMBERING_LASTUPDATE,NUMBERING_RESET) AS RESET 
							FROM S_NUMBERING WHERE NUMBERING_MODUL='$a' ");
	// oci_execute($qry);
	$get =mysqli_fetch_array($qry);
	$dpn = strftime($get['NUMBERING_AWALAN']); 
	$mid = strftime($get['NUMBERING_TENGAH']) ; 
	$perubahan =substr($get['NUMBERING_RESET'],1) ; 
	$date = date_create($tgl); 
	$tahun_input=date_format($date,$perubahan); 
	$tahun_akhir= $get['RESET']; 
	IF($tahun_input == $tahun_akhir) { 
		$end = $get['NUMBERING_COUNTER']+1; 
		$update =$mysqli->query( "UPDATE S_NUMBERING SET 
										NUMBERING_COUNTER		='$end',
										NUMBERING_LASTUPDATE	='$now'
									WHERE NUMBERING_MODUL='$a' ");
		// oci_execute($update);
		// oci_commit; 
	} ELSE { 
		$end = 1; 
		$update =$mysqli->query( "UPDATE S_NUMBERING SET 
										NUMBERING_COUNTER		='$end',
										NUMBERING_LASTUPDATE	='$now'
									WHERE NUMBERING_MODUL='$a' ");
		// oci_execute($update);
		// oci_commit;
	} 
	$seq= str_pad($end,$get['NUMBERING_DIGIT'],'0',STR_PAD_LEFT); 
	$number = $dpn.$mid.$seq; 
	return $number; 
}




function Cek_Numbering($input, $conn) {
	//include 'config/connect.php';
	include ($conn);
	$tgl=date('Y-m-d'); 
	$now =date('Y-m-d H:i:s');
	$a=$input; 
	//$a='Kulkas';
	$qry =$mysqli->query( "SELECT NUMBERING_MODUL,NUMBERING_AWALAN,NUMBERING_TENGAH,NUMBERING_COUNTER,NUMBERING_DIGIT,NUMBERING_RESET,
							NUMBERING_LASTUPDATE,date_format(NUMBERING_LASTUPDATE,NUMBERING_RESET) AS RESET 
							FROM S_NUMBERING WHERE NUMBERING_MODUL='$a' ");
	// oci_execute($qry);
	$get =mysqli_fetch_array($qry);
	$dpn = strftime($get['NUMBERING_AWALAN']); 
	$mid = strftime($get['NUMBERING_TENGAH']) ; 
	$perubahan =substr($get['NUMBERING_RESET'],1) ; 
	$date = date_create($tgl); 
	$tahun_input=date_format($date,$perubahan); 
	$tahun_akhir= $get['RESET']; 
	IF($tahun_input == $tahun_akhir) { 
		$end = $get['NUMBERING_COUNTER']+1; 
		
	} ELSE { 
		$end = 1; 
		
	} 
	$seq= str_pad($end,$get['NUMBERING_DIGIT'],'0',STR_PAD_LEFT); 
	$number = $dpn.$mid.$seq; 
	return $number; 
}

?>