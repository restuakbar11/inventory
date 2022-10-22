<?php
date_default_timezone_set("Asia/Bangkok");
ob_start();
ini_set('memory_limit','500M');

include "../../config/connect.php";
$startdate =date('Y-m-d', strtotime($_GET['startdate']));
$finishdate =date('Y-m-d', strtotime($_GET['finishdate']));
$tgl =date('Y-m-d');
$kode_laporan=$_GET['kode_laporan'];
$id_department=$_GET['id_department'];
$nm_department=$_GET['nm_department'];

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
                <th>LAPORAN BARANG KELUAR</th>
			</tr>
			<tr>
                <th>DEPARTMENT : $nm_department</th>
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
			<th class='layout' width='10%'>Tanggal</th>
			<th class='layout' width='12%'>Nama Department</th>
			<th class='layout' width='12%'>Nama Sub Department</th>
			<th class='layout' width='10%'>Kode</th>
			<th class='layout' width='20%'>Nama Item</th>
			<th class='layout' width='9%'>Satuan</th>
			<th class='layout' width='10%'>Lot Number</th>
			<th class='layout' width='10%'>Qty</th>
		</tr>
	</thead>
								  
	<tbody>";
	  
	
		$no=1;	
		if($id_department=='all') {
			$query = "SELECT b.NOBARANGKELUAR,NAMA_DEPARTMENT,NAMA_SUBDEPARTMENT,JML,NOBARANGKELUARDETAIL,BARANGKELUARTANGGAL,
					IDITEM,NAMAITEM,NAMASATUAN,BARANGKELUARDETAILLOT_NUMBER,BARANGKELUARDETAILQTY
						FROM BARANG_KELUAR b
						JOIN BARANG_KELUAR_DETAIL d ON d.NOBARANGKELUAR=b.NOBARANGKELUAR AND BARANGKELUARDETAILISACTIVE='Y'
						JOIN M_ITEM i ON i.IDITEM=d.BARANGKELUARDETAILIDITEM
						JOIN M_SATUAN s ON s.IDSATUAN=d.BARANGKELUARDETAILIDSATUAN
						JOIN M_DEPARTMENT p ON p.ID_DEPARTMENT=b.BARANGKELUARID_DEPARTMENT AND DEPARTMENTISACTIVE='Y'
						JOIN M_SUBDEPARTMENT t ON t.ID_SUBDEPARTMENT=b.BARANGKELUARID_SUBDEPARTMENT AND SUBDEPARTMENTISACTIVE='Y'
						JOIN
						( SELECT b.NOBARANGKELUAR,COUNT(b.NOBARANGKELUAR) AS JML
							FROM BARANG_KELUAR b
							JOIN BARANG_KELUAR_DETAIL d ON d.NOBARANGKELUAR=b.NOBARANGKELUAR AND BARANGKELUARDETAILISACTIVE='Y'
							WHERE BARANGKELUARISACTIVE='Y' AND BARANGKELUARFLAGBATAL='N' AND BARANGKELUARVALIDASI!='N' AND BARANGKELUARTANGGAL BETWEEN '$startdate' AND '$finishdate'
							GROUP BY b.NOBARANGKELUAR
						) a ON a.NOBARANGKELUAR=b.NOBARANGKELUAR
						WHERE BARANGKELUARISACTIVE='Y' AND BARANGKELUARFLAGBATAL='N' AND BARANGKELUARVALIDASI!='N' AND BARANGKELUARTANGGAL BETWEEN '$startdate' AND '$finishdate'
						ORDER BY NOBARANGKELUARDETAIL ASC ";
		} else {
			$query = "SELECT b.NOBARANGKELUAR,NAMA_DEPARTMENT,NAMA_SUBDEPARTMENT,JML,NOBARANGKELUARDETAIL,BARANGKELUARTANGGAL,
					IDITEM,NAMAITEM,NAMASATUAN,BARANGKELUARDETAILLOT_NUMBER,BARANGKELUARDETAILQTY
						FROM BARANG_KELUAR b
						JOIN BARANG_KELUAR_DETAIL d ON d.NOBARANGKELUAR=b.NOBARANGKELUAR AND BARANGKELUARDETAILISACTIVE='Y'
						JOIN M_ITEM i ON i.IDITEM=d.BARANGKELUARDETAILIDITEM
						JOIN M_SATUAN s ON s.IDSATUAN=d.BARANGKELUARDETAILIDSATUAN
						JOIN M_DEPARTMENT p ON p.ID_DEPARTMENT=b.BARANGKELUARID_DEPARTMENT AND DEPARTMENTISACTIVE='Y'
						JOIN M_SUBDEPARTMENT t ON t.ID_SUBDEPARTMENT=b.BARANGKELUARID_SUBDEPARTMENT AND SUBDEPARTMENTISACTIVE='Y'
						JOIN
						( SELECT b.NOBARANGKELUAR,COUNT(b.NOBARANGKELUAR) AS JML
							FROM BARANG_KELUAR b
							JOIN BARANG_KELUAR_DETAIL d ON d.NOBARANGKELUAR=b.NOBARANGKELUAR AND BARANGKELUARDETAILISACTIVE='Y'
							WHERE BARANGKELUARISACTIVE='Y' AND BARANGKELUARFLAGBATAL='N' AND BARANGKELUARVALIDASI!='N' AND BARANGKELUARTANGGAL BETWEEN '$startdate' AND '$finishdate'
								AND BARANGKELUARID_DEPARTMENT='$id_department'
							GROUP BY b.NOBARANGKELUAR
						) a ON a.NOBARANGKELUAR=b.NOBARANGKELUAR
						WHERE BARANGKELUARISACTIVE='Y' AND BARANGKELUARFLAGBATAL='N' AND BARANGKELUARVALIDASI!='N' AND BARANGKELUARTANGGAL BETWEEN '$startdate' AND '$finishdate'
							AND BARANGKELUARID_DEPARTMENT='$id_department'
						ORDER BY NOBARANGKELUARDETAIL ASC ";
		}
		
		
		$getData = $mysqli->query( $query);
				// oci_execute($getData);
		while ($row =mysqli_fetch_array($getData)){
			echo"
			<tr>";
				if($NOBARANGKELUAR!=$row['NOBARANGKELUAR']) {
					$span=(int)$row[JML];
					echo"
					<td rowspan=$span class='layout'>$no</td>
					<td rowspan=$span class='kiri'>$row[NOBARANGKELUAR]</td>
					<td rowspan=$span class='kiri'>$row[BARANGKELUARTANGGAL]</td>
					<td rowspan=$span class='kiri'>$row[NAMA_DEPARTMENT]</td>
					<td rowspan=$span class='kiri'>$row[NAMA_SUBDEPARTMENT]</td>
					";
					$NOBARANGKELUAR =$row['NOBARANGKELUAR'];
					$no++;
				}
				echo"
					<td class='kiri'>$row[IDITEM]</td>
					<td class='kiri'>$row[NAMAITEM]</td>
					<td class='kiri'>$row[NAMASATUAN]</td>
					<td class='kiri'>$row[BARANGKELUARDETAILLOT_NUMBER]</td>
					<td class='layout'>$row[BARANGKELUARDETAILQTY]</td>
			</tr>";
		}
		echo"
	</tbody>
</table>";


include ('getReport_P.php');
?>