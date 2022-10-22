<?php
date_default_timezone_set("Asia/Bangkok");
ob_start();
ini_set('memory_limit','500M');

include "../../config/connect.php";
$tgl =date('Y-m-d');
$kode_laporan='Transaksi Breakdown';
$no_trans =$_GET['no_breakdown'];
$tgl_trans =$_GET['tgl_trans'];
$dept =$_GET['dept'];

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
		<th >CETAK TRANSAKSI BREAKDOWN</th>
	</tr>
	<tr>
		<th >No Transaksi : $no_trans</th>
	</tr>
	<tr>
		<th >Tgl Transaksi : $tgl_trans</th>
	</tr>
</table>
<hr>

<label>Department : <b>$dept</b></label>";

$tampil =$mysqli->query( "SELECT b.NOBREAKDOWN,b.NOBREAKDOWNDETAIL,IDITEM,NAMAITEM,s.NAMASATUAN,ss.NAMASATUAN AS SATUAN_AKHIR,
						m.LOT_NUMBER,QTY_AWAL,QTY_AKHIR,KODEBARCODE_HEADER,d.KODEBARCODE,JML
							FROM BREAKDOWN_DETAIL b
							JOIN M_ITEMBARCODE m ON m.KODEBARCODE=b.KODEBARCODE_HEADER
							JOIN M_ITEM i ON i.IDITEM=m.M_ITEMIDITEM
							JOIN M_SATUAN s ON s.IDSATUAN=m.M_SATUANIDSATUAN
							JOIN M_SATUAN ss ON ss.IDSATUAN=b.IDSATUAN_AKHIR
							JOIN BREAKDOWN_DETAIL_BARCODE d ON d.NOBREAKDOWNDETAIL=b.NOBREAKDOWNDETAIL AND d.ISACTIVE='Y'
							JOIN 
								(SELECT b.NOBREAKDOWNDETAIL,COUNT(b.NOBREAKDOWNDETAIL) AS JML
								FROM BREAKDOWN_DETAIL b
								JOIN BREAKDOWN_DETAIL_BARCODE d ON d.NOBREAKDOWNDETAIL=b.NOBREAKDOWNDETAIL AND d.ISACTIVE='Y'
								WHERE b.ISACTIVE='Y' AND NOBREAKDOWN='$no_trans'
								GROUP BY b.NOBREAKDOWNDETAIL
								) a ON a.NOBREAKDOWNDETAIL=b.NOBREAKDOWNDETAIL
							WHERE b.ISACTIVE='Y' AND NOBREAKDOWN='$no_trans'
							ORDER BY b.NOBREAKDOWNDETAIL,d.KODEBARCODE ");
// oci_execute($tampil);
echo"
<table class='layout' width='100%'>
	<tr>
		<th class='layout' width='5px'>No</th>
		<th class='layout' width='80px'>Kode Item</th>
		<th class='layout' width='150px'>Nama Item</th>
		<th class='layout' width='100px'>Lot Number</th>
		<th class='layout' width='80px'>Satuan Awal</th>
		<th class='layout' width='80px'>Satuan Baru</th>
		<th class='layout' width='50px'>Qty Awal</th>
		<th class='layout' width='50px'>Qty Baru</th>
		<th class='layout' width='150px'>Kodebarcode Header</th>
		<th class='layout' width='150px'>Kodebarcode Turunan</th>
	</tr>";
	$no=1;
	while ($r =mysqli_fetch_array($tampil)) {
		echo"
		<tr>";
			if($NOBREAKDOWNDETAIL!=$r['NOBREAKDOWNDETAIL']) {
				$span=(int)$r[JML];
				echo"	
				<td rowspan=$span class='layout' valign='top'>$no</td>
				<td rowspan=$span class='kiri' valign='top'>$r[IDITEM]</td>
				<td rowspan=$span class='kiri' valign='top'>$r[NAMAITEM]</td>
				<td rowspan=$span class='kiri' valign='top'>$r[LOT_NUMBER]</td>
				<td rowspan=$span class='kiri' valign='top'>$r[NAMASATUAN]</td>
				<td rowspan=$span class='kiri' valign='top'>$r[SATUAN_AKHIR]</td>
				<td rowspan=$span class='layout' valign='top'>$r[QTY_AWAL]</td>
				<td rowspan=$span class='layout' valign='top'>$r[QTY_AKHIR]</td>
				<td rowspan=$span class='kiri' valign='top'>$r[KODEBARCODE_HEADER]</td>";
				$NOBREAKDOWNDETAIL =$r['NOBREAKDOWNDETAIL'];
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