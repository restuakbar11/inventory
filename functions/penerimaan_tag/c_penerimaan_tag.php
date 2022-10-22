<?php
date_default_timezone_set("Asia/Bangkok");
ob_start();
ini_set('memory_limit','500M');

include "../../config/connect.php";
$tgl =date('Y-m-d');
$kode_laporan='Transaksi Penerimaan TAG';
$no_trans =$_GET['no_penerimaan_tag'];
$tgl_kirim =$_GET['tgl_kirim'];
$tgl_terima =$_GET['tgl_terima'];
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
		<th >CETAK TRANSAKSI PENERIMAAN TAG</th>
	</tr>
	<tr>
		<th >No Transaksi : $no_trans</th>
	</tr>
	<tr>
		<th >Tgl Transaksi : $tgl_kirim</th>
	</tr>
	<tr>
		<th >Tgl Penerimaan : $tgl_terima</th>
	</tr>
</table>
<hr>

<label>Department Pengirim : <b>$asal</b></label><br>
<label>Department Tujuan : <b>$tujuan</b></label>";

$tampil =$mysqli->query( "SELECT NOTAG,b.NOTAG_DETAIL,IDITEM,NAMAITEM,NAMASATUAN,TAGDETAILQTY,TAGDETAILM_ITEMSTOCKLOTNUMBER,
							TAGDETAILED,KODEBARCODE
							FROM TAG_DETAIL t
							JOIN M_ITEM i ON i.IDITEM=t.TAGDETAILM_ITEMID
							JOIN M_SATUAN s ON s.IDSATUAN=t.TAGDETAILM_SATUANID
							JOIN TAG_DETAIL_BARCODE b ON b.NOTAG_DETAIL=t.NOTAG_DETAIL AND b.ISACTIVE='Y'
							WHERE TAGDETAILISACTIVE='Y' AND NOTAG='$no_trans'
							ORDER BY b.NOTAG_DETAIL,KODEBARCODE");
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
			if($NOTAG_DETAIL!=$r['NOTAG_DETAIL']) {
				$span=(int)$r[TAGDETAILQTY];
				echo"	
				<td rowspan=$span class='layout' valign='top'>$no</td>
				<td rowspan=$span class='kiri' valign='top'>$r[IDITEM]</td>
				<td rowspan=$span class='kiri' valign='top'>$r[NAMAITEM]</td>
				<td rowspan=$span class='kiri' valign='top'>$r[NAMASATUAN]</td>
				<td rowspan=$span class='kiri' valign='top'>$r[TAGDETAILM_ITEMSTOCKLOTNUMBER]</td>
				<td rowspan=$span class='kiri' valign='top'>$r[TAGDETAILED]</td>
				<td rowspan=$span class='layout' valign='top'>$r[TAGDETAILQTY]</td>";
				$NOTAG_DETAIL =$r['NOTAG_DETAIL'];
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