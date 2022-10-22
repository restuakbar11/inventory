<?php
date_default_timezone_set("Asia/Bangkok");
ob_start();
ini_set('memory_limit','500M');

include "../../config/connect.php";
$tgl =date('Y-m-d');
$kode_laporan='Transaksi Retur';
$no_trans =$_GET['no_retur'];
$tgl_trans =$_GET['tgl_trans'];
$asal =$_GET['asal'];
$tujuan =$_GET['tujuan'];

//style
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
<table border=0 width='100%'>
	<tr>
		<th >CETAK TRANSAKSI RETUR</th>
	</tr>
	<tr>
		<th >No Transaksi : $no_trans</th>
	</tr>
	<tr>
		<th >Tgl Transaksi : $tgl_trans</th>
	</tr>
</table>
<hr>

<label>Department Pengirim : <b>$asal</b></label><br>
<label>Department Tujuan : <b>$tujuan</b></label>";

$tampil =$mysqli->query( "SELECT NORETUR,b.NORETUR_DETAIL,IDITEM,NAMAITEM,NAMASATUAN,RETURDETAIL_QTY,RETURDETAIL_LOTNUMBER,
							RETURDETAIL_ED,KODEBARCODE
							FROM RETUR_DETAIL t
							JOIN M_ITEM i ON i.IDITEM=t.RETURDETAIL_IDITEM
							JOIN M_SATUAN s ON s.IDSATUAN=t.RETURDETAIL_IDSATUAN
							JOIN RETUR_DETAIL_BARCODE b ON b.NORETUR_DETAIL=t.NORETUR_DETAIL 
							WHERE RETURDETAIL_ISACTIVE='Y' AND NORETUR='$no_trans'
							ORDER BY b.NORETUR_DETAIL,KODEBARCODE");
// oci_execute($tampil);
echo"
<table class='layout' width='100%'>
	<tr>
		<th class='layout' width='5px'>No</th>
		<th class='layout' width='80px'>Kode Item</th>
		<th class='layout' width='150px'>Nama Item</th>
		<th class='layout' width='80px'>Satuan</th>
		<th class='layout' width='100px'>Lot Number</th>
		<th class='layout' width='80px'>ED</th>
		<th class='layout' width='50px'>Qty</th>
		<th class='layout' width='150px'>Kodebarcode</th>
	</tr>";
	$no=1;
	while ($r =mysqli_fetch_array($tampil)) {
		echo"
		<tr>";
			if($NORETUR_DETAIL!=$r['NORETUR_DETAIL']) {
				$span=(int)$r[RETURDETAIL_QTY];
				echo"	
				<td rowspan=$span class='layout' valign='top'>$no</td>
				<td rowspan=$span class='kiri' valign='top'>$r[IDITEM]</td>
				<td rowspan=$span class='kiri' valign='top'>$r[NAMAITEM]</td>
				<td rowspan=$span class='kiri' valign='top'>$r[NAMASATUAN]</td>
				<td rowspan=$span class='kiri' valign='top'>$r[RETURDETAIL_LOTNUMBER]</td>
				<td rowspan=$span class='kiri' valign='top'>$r[RETURDETAIL_ED]</td>
				<td rowspan=$span class='layout' valign='top'>$r[RETURDETAIL_QTY]</td>";
				$NORETUR_DETAIL =$r['NORETUR_DETAIL'];
				$no++;
			}
				echo"
				<td class='kiri'>$r[KODEBARCODE]</td>
		</tr>";
	}
	echo"
</table>";


include ('../reports/getReport_P.php');
?>