<?php
date_default_timezone_set("Asia/Bangkok");
ob_start();
ini_set('memory_limit','500M');

include "../../config/connect.php";
$tgl =date('Y-m-d');
$kode_laporan=$_GET['kode_laporan'];
$id_supplier=$_GET['id_supplier'];
$nm_supplier=$_GET['nm_supplier'];

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
                <th>LAPORAN ITEM PER SUPPLIER</th>
			</tr>
			<tr>
                <th>SUPPLIER : $nm_supplier</th>
			</tr>
</table>
<hr>";

//ISI
echo"
<table width='100%' class='layout'  id='table_report'>
	<thead>
		<tr>
			<th class='layout' width='5%'>No</th>
			<th class='layout' width='12%'>Nama Supplier</th>
			<th class='layout' width='10%'>Kode</th>
			<th class='layout' width='20%'>Nama Item</th>
		</tr>
	</thead>
								  
	<tbody>";
	  
	
		$no=1;	
		if($id_supplier=='all') {
			$query = "SELECT NAMASUPPLIER,IDITEM,NAMAITEM,JML
						FROM M_ITEMSUPPLIER z 
						JOIN M_SUPPLIER s ON s.IDSUPPLIER=z.ITEMSUPPLIER_IDSUPPLIER AND SUPPLIERISACTIVE='Y'
						JOIN M_ITEM i ON i.IDITEM=z.ITEMSUPPLIER_IDITEM AND ITEM_ISACTIVE='Y'
						JOIN
						( SELECT sup.ITEMSUPPLIER_IDSUPPLIER,COUNT(sup.ITEMSUPPLIER_IDSUPPLIER) AS JML
							FROM M_ITEMSUPPLIER sup
                            JOIN M_ITEM i ON i.IDITEM=sup.ITEMSUPPLIER_IDITEM AND ITEM_ISACTIVE='Y'
							WHERE ITEMSUPPLIERISACTIVE='Y' 
							GROUP BY ITEMSUPPLIER_IDSUPPLIER
						) a ON a.ITEMSUPPLIER_IDSUPPLIER=z.ITEMSUPPLIER_IDSUPPLIER
						WHERE ITEMSUPPLIERISACTIVE='Y' 
						ORDER BY NAMASUPPLIER,NAMAITEM ";
		} else {
			$query = "SELECT NAMASUPPLIER,IDITEM,NAMAITEM,JML
						FROM M_ITEMSUPPLIER z 
						JOIN M_SUPPLIER s ON s.IDSUPPLIER=z.ITEMSUPPLIER_IDSUPPLIER AND SUPPLIERISACTIVE='Y'
						JOIN M_ITEM i ON i.IDITEM=z.ITEMSUPPLIER_IDITEM AND ITEM_ISACTIVE='Y'
						JOIN
						( SELECT ITEMSUPPLIER_IDSUPPLIER,COUNT(ITEMSUPPLIER_IDSUPPLIER) AS JML
							FROM M_ITEMSUPPLIER
							WHERE ITEMSUPPLIERISACTIVE='Y' AND ITEMSUPPLIER_IDSUPPLIER='$id_supplier'
							GROUP BY ITEMSUPPLIER_IDSUPPLIER
						) a ON a.ITEMSUPPLIER_IDSUPPLIER=z.ITEMSUPPLIER_IDSUPPLIER
						WHERE ITEMSUPPLIERISACTIVE='Y' AND z.ITEMSUPPLIER_IDSUPPLIER='$id_supplier'
						ORDER BY NAMASUPPLIER,NAMAITEM ";
		}
		
		
		$getData = $mysqli->query( $query);
				// oci_execute($getData);
		while ($row =mysqli_fetch_array($getData)){
			echo"
			<tr>";
				if($NAMASUPPLIER!=$row['NAMASUPPLIER']) {
					$span=(int)$row[JML];
					echo"
					<td rowspan=$span class='layout'>$no</td>
					<td rowspan=$span class='kiri'>$row[NAMASUPPLIER]</td>
					";
					$NAMASUPPLIER =$row['NAMASUPPLIER'];
					$no++;
				}
				echo"
					<td class='kiri'>$row[IDITEM]</td>
					<td class='kiri'>$row[NAMAITEM]</td>
			</tr>";
		}
		echo"
	</tbody>
</table>";


include ('getReport_P.php');
?>