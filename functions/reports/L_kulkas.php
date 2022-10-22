<?php
date_default_timezone_set("Asia/Bangkok");
ob_start();
ini_set('memory_limit','500M');

include "../../config/connect.php";
$startdate =date('Y-m-d', strtotime($_GET['startdate']));
$finishdate =date('Y-m-d', strtotime($_GET['finishdate']));
$tgl =date('Y-m-d');
$kode_laporan=$_GET['kode_laporan'];
$id_kulkas = $_GET['id_kulkas'];
$namaKulkas = "SELECT NAMAGUDANG as NAMA_KULKAS from M_KULKAS k
JOIN M_GUDANG g ON g.ID_GUDANG=k.ID_GUDANG 
where kode_kulkas='$id_kulkas' ";
$getKulkas = $mysqli->query( $namaKulkas);
				// oci_execute($getKulkas);
		while ($row =mysqli_fetch_array($getKulkas)){
			$nm_kulkas = $row['NAMA_KULKAS'];
		}
if ($id_kulkas == 'all') {
	$kulkas = " ";
	$judul = "Keseluruhan";
}else{
	$kulkas = " and k.kode_kulkas = '$id_kulkas'";
	$judul = $nm_kulkas;
}

echo"
<style>
table.layout {
	font-family: Arial Black;
	font-size: 12px;
	border: 1px solid black;
	border-collapse: black;
}
td.layout { 
	font-family: Arial Black;
	font-size: 12px;
	border:1px solid black;
	text-align:center;
}
td.kiri { 
	font-family: Arial Black;
	font-size: 12px;
	border:1px solid black;
	text-align:left;
}
th.layout { 
	font-family: Arial Black;
	font-size: 12px;
	text-align:center;
	border:1px solid black;
}
</style>";

//HEADER
echo "
<table width='100%' id='table_report'>
    		<tr>
                <th>LAPORAN Buka Tutup Kulkas $judul</th>
			</tr>
			<tr>
				<td align='center'>Periode : $startdate sampai $finishdate</td>
			</tr>
</table>
<hr>";

//ISI
echo"
<table width='100%' class='layout'  id='table_report'>
	<thead>
		<tr>
			<th class='layout' width='5%'>No</th>
			<th class='layout' width='12%'>Nama Kulkas</th>
			<th class='layout' width='12%'>User</th>
			<th class='layout' width='10%'>Tanggal</th>
			<th class='layout' width='15%'>Jam</th>
			<th class='layout' width='10%'>Durasi(detik)</th>
		</tr>
	</thead>
								  
	<tbody>";
	  
	
		$no=1;	
			$query = "SELECT NAMAGUDANG as NAMA_KULKAS, dl.userid, dl.tanggal, dl.jam, dl.detik from M_KULKAS k
JOIN M_GUDANG g ON g.ID_GUDANG=k.ID_GUDANG 
JOIN KULKAS_USER_LOG dl on k.kode_kulkas=dl.kode_kulkas
where KULKASISACTIVE = 'Y' AND dl.TANGGAL BETWEEN '$startdate' AND '$finishdate' $kulkas
group by g.namagudang, dl.userid,dl.tanggal, dl.jam, dl.detik
order by dl.tanggal asc, dl.jam asc";

		
		
		$getData = $mysqli->query( $query);
				// oci_execute($getData);
		while ($row =mysqli_fetch_array($getData)){
			echo"
			<tr>";
				
				echo"
					<td class='kiri'>$no</td>
					<td class='kiri'>$row[NAMA_KULKAS]</td>
					<td class='kiri'>$row[USERID]</td>
					<td class='kiri'>$row[TANGGAL]</td>
					<td class='kiri'>$row[JAM]</td>
					<td class='layout'>$row[DETIK]</td>
			</tr>";
			$no++;
		}
		echo"
	</tbody>
</table>";


include ('getReport_P.php');
?>