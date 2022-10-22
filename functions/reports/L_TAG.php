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
                <th>LAPORAN TAG</th>
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
			<th class='layout' width='12%'>No TAG</th>
			<th class='layout' width='10%'>Tanggal</th>
			<th class='layout' width='15%'>Department Tujuan</th>
			<th class='layout' width='10%'>Kode</th>
			<th class='layout' width='20%'>Nama Item</th>
			<th class='layout' width='9%'>Satuan</th>
			<th class='layout' width='10%'>Lot Number</th>
			<th class='layout' width='10%'>Qty</th>
		</tr>
	</thead>
								  
	<tbody>";
	  
	
		$no=1;	
			$query = "SELECT p.NOTAG,JML,NAMA_DEPARTMENT,TAGTANGGAL,t.NOTAG_DETAIL,IDITEM,NAMAITEM,NAMASATUAN,TAGDETAILQTY,TAGDETAILM_ITEMSTOCKLOTNUMBER
							FROM TAG p
                            JOIN TAG_DETAIL t ON t.NOTAG=p.NOTAG AND TAGDETAILISACTIVE='Y'
							JOIN M_ITEM i ON i.IDITEM=t.TAGDETAILM_ITEMID
							JOIN M_SATUAN s ON s.IDSATUAN=t.TAGDETAILM_SATUANID
                            JOIN M_DEPARTMENT d ON d.ID_DEPARTMENT=p.TAGID_DEPARTMENT AND DEPARTMENTISACTIVE='Y'
                            JOIN 
                            (
                                SELECT p.NOTAG,COUNT(p.NOTAG) AS JML
                                FROM TAG p
                                JOIN TAG_DETAIL t ON t.NOTAG=p.NOTAG AND TAGDETAILISACTIVE='Y'
                                WHERE TAGISACTIVE='Y' AND FLAGBATAL='N' AND TAGVALIDASI!='N' AND TAGTANGGAL BETWEEN '$startdate' AND '$finishdate'
                                GROUP BY p.NOTAG
                            ) a ON a.NOTAG=p.NOTAG
							WHERE TAGISACTIVE='Y' AND FLAGBATAL='N' AND TAGVALIDASI!='N' AND TAGTANGGAL BETWEEN '$startdate' AND '$finishdate'
							ORDER BY t.NOTAG_DETAIL ";

		
		
		$getData = $mysqli->query( $query);
				// oci_execute($getData);
		while ($row =mysqli_fetch_array($getData)){
			echo"
			<tr>";
				if($NOTAG!=$row['NOTAG']) {
					$span=(int)$row[JML];
					echo"
					<td rowspan=$span class='layout'>$no</td>
					<td rowspan=$span class='kiri'>$row[NOTAG]</td>
					<td rowspan=$span class='kiri'>$row[TAGTANGGAL]</td>
					<td rowspan=$span class='kiri'>$row[NAMA_DEPARTMENT]</td>
					";
					$NOTAG =$row['NOTAG'];
					$no++;
				}
				echo"
					<td class='kiri'>$row[IDITEM]</td>
					<td class='kiri'>$row[NAMAITEM]</td>
					<td class='kiri'>$row[NAMASATUAN]</td>
					<td class='kiri'>$row[TAGDETAILM_ITEMSTOCKLOTNUMBER]</td>
					<td class='layout'>$row[TAGDETAILQTY]</td>
			</tr>";
		}
		echo"
	</tbody>
</table>";


include ('getReport_P.php');
?>