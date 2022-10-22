<?php
date_default_timezone_set("Asia/Bangkok");
ob_start();
ini_set('memory_limit','500M');

include "../../config/connect.php";
$tgl =date('Y-m-d');
$kode_laporan='Transaksi Barang Keluar';
$no_trans =$_GET['no_trans'];
$tgl =$_GET['tgl'];
$dept =$_GET['dept'];
$sub_dept =$_GET['sub_dept'];

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
		<th >CETAK TRANSAKSI BARANG KELUAR</th>
	</tr>
	<tr>
		<th >No Transaksi : $no_trans</th>
	</tr>
	<tr>
		<th >Tgl Transaksi : $tgl</th>
	</tr>
</table>
<hr>

<label>Untuk</label><br>
<label>Sub Department : <b>$sub_dept</b> dari Department : <b>$dept</b></label>";

$tampil =$mysqli->query( "SELECT NOBARANGKELUAR,b.NOBARANGKELUARDETAIL,IDITEM,NAMAITEM,NAMASATUAN,BARANGKELUARDETAILQTY,BARANGKELUARDETAILLOT_NUMBER,
							BARANGKELUARDETAILED,KODEBARCODE
							FROM BARANG_KELUAR_DETAIL t
							JOIN M_ITEM i ON i.IDITEM=t.BARANGKELUARDETAILIDITEM
							JOIN M_SATUAN s ON s.IDSATUAN=t.BARANGKELUARDETAILIDSATUAN
							JOIN BARANG_KELUAR_DETAIL_BARCODE b ON b.NOBARANGKELUARDETAIL=t.NOBARANGKELUARDETAIL AND b.ISACTIVE='Y'
							WHERE BARANGKELUARDETAILISACTIVE='Y' AND NOBARANGKELUAR='$no_trans'
							ORDER BY b.NOBARANGKELUARDETAIL,KODEBARCODE");
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
			if($NOBARANGKELUARDETAIL!=$r['NOBARANGKELUARDETAIL']) {
				$span=(int)$r[BARANGKELUARDETAILQTY];
				echo"	
				<td rowspan=$span class='layout' valign='top'>$no</td>
				<td rowspan=$span class='kiri' valign='top'>$r[IDITEM]</td>
				<td rowspan=$span class='kiri' valign='top'>$r[NAMAITEM]</td>
				<td rowspan=$span class='kiri' valign='top'>$r[NAMASATUAN]</td>
				<td rowspan=$span class='kiri' valign='top'>$r[BARANGKELUARDETAILLOT_NUMBER]</td>
				<td rowspan=$span class='kiri' valign='top'>$r[BARANGKELUARDETAILED]</td>
				<td rowspan=$span class='layout' valign='top'>$r[BARANGKELUARDETAILQTY]</td>";
				$NOBARANGKELUARDETAIL =$r['NOBARANGKELUARDETAIL'];
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