<?php
date_default_timezone_set("Asia/Bangkok");
ob_start();
ini_set('memory_limit','500M');

include "../../config/connect.php";
$startdate =date('Y-m-d', strtotime($_GET['startdate']));
$finishdate =date('Y-m-d', strtotime($_GET['finishdate']));
$tgl =date('Y-m-d');
$kode_laporan=$_GET['kode_laporan'];

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
                <th>LAPORAN CHECK IN</th>
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
			<th class='layout' width='12%'>No Barang Masuk</th>
			<th class='layout' width='12%'>Tanggal Barang Masuk</th>
			<th class='layout' width='12%'>Kode Barcode</th>
			<th class='layout' width='10%'>Nama Item</th>
			<th class='layout' width='15%'>Lot Number</th>
			<th class='layout' width='10%'>ED</th>
			<th class='layout' width='10%'>Tanggal Check In</th>
			</tr>
	</thead>
								  
	<tbody>";
	  
	
		$no=1;	
			$query = "SELECT IB.KODEBARCODE,BM.NOBARANGMASUK,BM.BARANGMASUKTANGGAL,I.NAMAITEM, IB.LOT_NUMBER, IB.ED, IB.TANGGALCHECKINMASUK from BARANG_MASUK BM
				inner join BARANG_MASUK_DETAIL BMD on BM.NOBARANGMASUK=BMD.NOBARANGMASUK
				inner join M_ITEMBARCODE IB on BMD.NOBARANGMASUK_DETAIL=IB.BARANGMASUKDETAILIDMASUK
				inner join M_ITEM I on IB.M_ITEMIDITEM=I.IDITEM
                where BM.BARANGMASUKTANGGAL BETWEEN '$startdate' AND '$finishdate'
				order by BM.NOBARANGMASUK asc";

		
		
 		$getData = $mysqli->query( $query);
 				// oci_execute($getData);
 		while ($row =mysqli_fetch_array($getData)){
			echo"
			<tr>";
				
				echo"
					<td class='kiri'>$no</td>
					<td class='kiri'>$row[NOBARANGMASUK]</td>
					<td class='kiri'>$row[BARANGMASUKTANGGAL]</td>
					<td class='kiri'>$row[KODEBARCODE]</td>
					<td class='kiri'>$row[NAMAITEM]</td>
					<td class='kiri'>$row[LOT_NUMBER]</td>
					<td class='kiri'>$row[ED]</td>
					<td class='layout'>$row[TANGGALCHECKINMASUK]</td>
			</tr>";
			$no++;
 		}
		echo"
	</tbody>
</table>";


include ('getReport_P.php');
?>