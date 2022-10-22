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
                <th>LAPORAN BARANG MASUK DARI SUPPLIER</th>
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
			<th class='layout' width='12%'>No Transaksi</th>
			<th class='layout' width='12%'>Nama Supplier</th>
			<th class='layout' width='10%'>Tanggal</th>
			<th class='layout' width='10%'>Kode</th>
			<th class='layout' width='20%'>Nama Item</th>
			<th class='layout' width='9%'>Satuan</th>
			<th class='layout' width='10%'>Lot Number</th>
			<th class='layout' width='10%'>Qty</th>
		</tr>
	</thead>
								  
	<tbody>";
	  
	
		$no=1;	
			$query = "SELECT b.NOBARANGMASUK,JML,BARANGMASUKTANGGAL,NAMASUPPLIER,t.NOBARANGMASUK_DETAIL,IDITEM,NAMAITEM,NAMASATUAN,BARANGMASUKDETAILQTY,BARANGMASUKDETAILM_ITEMSTOCKLOTNUMBER
							FROM BARANG_MASUK b
                            JOIN BARANG_MASUK_DETAIL t ON t.NOBARANGMASUK=b.NOBARANGMASUK AND BARANGMASUKDETAILISACTIVE='Y'
                            JOIN M_ITEMBARCODE c ON c.BARANGMASUKDETAILIDMASUK=t.NOBARANGMASUK_DETAIL AND FLAGGUDANG=2
							JOIN M_ITEM i ON i.IDITEM=t.BARANGMASUKDETAILM_ITEMID
							JOIN M_SATUAN s ON s.IDSATUAN=t.BARANGMASUKDETAILM_SATUANID
                            LEFT JOIN M_SUPPLIER s ON s.IDSUPPLIER=b.BARANGMASUKM_SUPPLIERID AND SUPPLIERISACTIVE='Y'
                            JOIN 
                            (
                                SELECT b.NOBARANGMASUK,COUNT(b.NOBARANGMASUK) AS JML
                                FROM BARANG_MASUK b
                                JOIN BARANG_MASUK_DETAIL t ON t.NOBARANGMASUK=b.NOBARANGMASUK AND BARANGMASUKDETAILISACTIVE='Y'
                                WHERE BARANGMASUKISACTIVE='Y' AND FLAGBATAL='N' AND BARANGMASUKTANGGAL BETWEEN '$startdate' AND '$finishdate'
                                GROUP BY b.NOBARANGMASUK
                            ) a ON a.NOBARANGMASUK=b.NOBARANGMASUK
							WHERE BARANGMASUKISACTIVE='Y' AND FLAGBATAL='N' AND BARANGMASUKTANGGAL BETWEEN '$startdate' AND '$finishdate'
                            GROUP BY b.NOBARANGMASUK,JML,BARANGMASUKTANGGAL,NAMASUPPLIER,t.NOBARANGMASUK_DETAIL,IDITEM,NAMAITEM,NAMASATUAN,BARANGMASUKDETAILQTY,BARANGMASUKDETAILM_ITEMSTOCKLOTNUMBER
							ORDER BY t.NOBARANGMASUK_DETAIL ";

		
		
		$getData = $mysqli->query( $query);
				// oci_execute($getData);
		while ($row =mysqli_fetch_array($getData)){
			echo"
			<tr>";
				if($NOBARANGMASUK!=$row['NOBARANGMASUK']) {
					$span=(int)$row[JML];
					echo"
					<td rowspan=$span class='layout'>$no</td>
					<td rowspan=$span class='kiri'>$row[NOBARANGMASUK]</td>
					<td rowspan=$span class='kiri'>$row[NAMASUPPLIER]</td>
					<td rowspan=$span class='kiri'>$row[BARANGMASUKTANGGAL]</td>
					";
					$NOBARANGMASUK =$row['NOBARANGMASUK'];
					$no++;
				}
				echo"
					<td class='kiri'>$row[IDITEM]</td>
					<td class='kiri'>$row[NAMAITEM]</td>
					<td class='kiri'>$row[NAMASATUAN]</td>
					<td class='kiri'>$row[BARANGMASUKDETAILM_ITEMSTOCKLOTNUMBER]</td>
					<td class='layout'>$row[BARANGMASUKDETAILQTY]</td>
			</tr>";
		}
		echo"
	</tbody>
</table>";


include ('getReport_P.php');
?>