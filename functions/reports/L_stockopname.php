<?php
date_default_timezone_set("Asia/Bangkok");
ob_start();
ini_set('memory_limit','500M');

include "../../config/connect.php";
$id_department =$_GET['id_department'];
$nm_department =$_GET['nm_department'];
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
                <th>LAPORAN STOK OPNAME</th>
			</tr>
			<tr>
                <th>DEPT : $nm_department</th>
			</tr>
			<tr>
				<td align='center'>Per Tanggal $tgl</td>
			</tr>
</table>
<hr>";

//ISI
echo"
<table width='100%' class='layout'  id='table_report'>
	<thead>
		<tr>
			<th class='layout' width='5%'>No</th>
			<th class='layout' width='15%'>Department</th>
			<th class='layout' width='10%'>Kode</th>
			<th class='layout' width='20%'>Nama Item</th>
			<th class='layout' width='9%'>Satuan</th>
			<th class='layout' width='10%'>Lot Number</th>
			<th class='layout' width='10%'>Jumlah</th>
			<th class='layout' width='12%'>Gudang</th>
			<th class='layout' width='12%'>Rak Gudang</th>
		</tr>
	</thead>
								  
	<tbody>";
	  
	
		$no=1;	
		if($id_department=='all') {
			$query = "select NAMA_DEPARTMENT,IDITEM,NAMAITEM,NAMASATUAN,LOT_NUMBER,NAMAGUDANG,NAMARAKGUDANG,SUM(NILAI) AS JUMLAH
					FROM
					(
						select NAMA_DEPARTMENT,IDITEM,m.NAMAITEM,s.NAMASATUAN,i.LOT_NUMBER,NAMAGUDANG,NAMARAKGUDANG,
						CASE WHEN BARANGMASUKDETAILIDMASUK is not null AND FLAGGUDANG=2 THEN 1
						WHEN BARANGMASUKDETAILIDMASUK is null THEN 1
						ELSE 0 END AS NILAI
							from M_ITEMBARCODE i
							join M_SATUAN s ON s.IDSATUAN = i.M_SATUANIDSATUAN
							join M_ITEM m ON m.IDITEM = i.M_ITEMIDITEM
							join M_DEPARTMENT d ON d.ID_DEPARTMENT=i.M_DEPARTMENTDEPARTMENTID AND DEPARTMENTISACTIVE='Y'
							left join M_GUDANG g ON g.ID_GUDANG=i.IDGUDANG AND g.GUDANGAKTIF='Y'
							left join M_RAKGUDANG r ON r.ID_RAKGUDANG=i.IDRAKGUDANG AND r.RAKGUDANGAKTIF='Y'
							WHERE i.BARCODEISACTIVE='Y' 
					) a
					GROUP BY NAMA_DEPARTMENT,IDITEM,NAMAITEM,NAMASATUAN,LOT_NUMBER,NAMAGUDANG,NAMARAKGUDANG
					ORDER BY NAMA_DEPARTMENT,IDITEM,NAMAITEM,NAMASATUAN,LOT_NUMBER,NAMAGUDANG,NAMARAKGUDANG ";

		} else {
			$query = "select NAMA_DEPARTMENT,IDITEM,NAMAITEM,NAMASATUAN,LOT_NUMBER,NAMAGUDANG,NAMARAKGUDANG,SUM(NILAI) AS JUMLAH
					FROM
					(
						select NAMA_DEPARTMENT,IDITEM,m.NAMAITEM,s.NAMASATUAN,i.LOT_NUMBER,NAMAGUDANG,NAMARAKGUDANG,
						CASE WHEN BARANGMASUKDETAILIDMASUK is not null AND FLAGGUDANG=2 THEN 1
						WHEN BARANGMASUKDETAILIDMASUK is null THEN 1
						ELSE 0 END AS NILAI
							from M_ITEMBARCODE i
							join M_SATUAN s ON s.IDSATUAN = i.M_SATUANIDSATUAN
							join M_ITEM m ON m.IDITEM = i.M_ITEMIDITEM
							join M_DEPARTMENT d ON d.ID_DEPARTMENT=i.M_DEPARTMENTDEPARTMENTID AND DEPARTMENTISACTIVE='Y'
							left join M_GUDANG g ON g.ID_GUDANG=i.IDGUDANG AND g.GUDANGAKTIF='Y'
							left join M_RAKGUDANG r ON r.ID_RAKGUDANG=i.IDRAKGUDANG AND r.RAKGUDANGAKTIF='Y'
							WHERE M_DEPARTMENTDEPARTMENTID='$id_department' AND i.BARCODEISACTIVE='Y' 
					) a
					GROUP BY NAMA_DEPARTMENT,IDITEM,NAMAITEM,NAMASATUAN,LOT_NUMBER,NAMAGUDANG,NAMARAKGUDANG
					ORDER BY NAMA_DEPARTMENT,IDITEM,NAMAITEM,NAMASATUAN,LOT_NUMBER,NAMAGUDANG,NAMARAKGUDANG ";
		}
		
		$getData = $mysqli->query( $query);
				// oci_execute($getData);
		while ($row =mysqli_fetch_array($getData)){
			echo"
			<tr>
				<td class='layout'>$no</td>
				<td class='kiri'>$row[NAMA_DEPARTMENT]</td>
				<td class='kiri'>$row[IDITEM]</td>
				<td class='kiri'>$row[NAMAITEM]</td>
				<td class='kiri'>$row[NAMASATUAN]</td>
				<td class='kiri'>$row[LOT_NUMBER]</td>
				<td class='layout'>$row[JUMLAH]</td>
				<td class='kiri'>$row[NAMAGUDANG]</td>
				<td class='kiri'>$row[NAMARAKGUDANG]</td>
			</tr>";
			$no++;
		}
		echo"
	</tbody>
</table>";


include ('getReport_P.php');
?>