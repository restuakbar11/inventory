<?php 
include '../../config/connect.php';
session_start();
$startdate	=$_POST['startdate'];
$finishdate	=$_POST['finishdate'];
$item	=$_POST['item'];
$satuan	=$_POST['satuan'];
$department	=$_POST['department'];
$no=1; ?>
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">No</th>
				<th width="7%">Tanggal</th>
				<th width="12%">Department</th>
				<th>Item</th>
				<th width="10%">Lot Number</th>
				<th width="8%">Stock Awal</th>
				<th width="5%">Masuk</th>
				<th width="5%">Keluar</th>
				<th width="8%">Stock Akhir</th>
				<th width="10%">Keterangan</th>
				<th width="10%">No Transaksi</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			
			if($department==0) {
				$user2 =$mysqli->query( "SELECT h.TANGGAL,ITEMSTOCK_IDITEM,NAMAITEM,ITEMSTOCK_IDSATUAN,NAMASATUAN,
										ITEMSTOCK_LOTNUMBER,DEPARTMENTID,NAMA_DEPARTMENT,
										STOCKAWAL,STOCKIN,STOCKOUT,STOCKAKHIR,CATATAN,NOTRANSAKSI
											FROM ITEMSTOCK s
											JOIN ITEMSTOCK_HISTORY h ON h.IDITEMSTOCK=s.IDITEMSTOCK
											JOIN M_DEPARTMENT d ON d.ID_DEPARTMENT=h.DEPARTMENTID AND DEPARTMENTISACTIVE='Y'
											JOIN M_ITEM i ON i.IDITEM=s.ITEMSTOCK_IDITEM AND ITEM_ISACTIVE='Y'
											JOIN M_SATUAN u ON u.IDSATUAN=s.ITEMSTOCK_IDSATUAN AND SATUANISACTIVE='Y'
											WHERE ITEMSTOCK_IDITEM='$item' AND ITEMSTOCK_IDSATUAN='$satuan'
											AND date_format(h.TANGGAL, '%Y-%m-%d') BETWEEN '$startdate' AND '$finishdate'
											ORDER BY h.TANGGAL ");
			} else {
				$user2 =$mysqli->query( "SELECT h.TANGGAL,ITEMSTOCK_IDITEM,NAMAITEM,ITEMSTOCK_IDSATUAN,NAMASATUAN,
										ITEMSTOCK_LOTNUMBER,DEPARTMENTID,NAMA_DEPARTMENT,
										STOCKAWAL,STOCKIN,STOCKOUT,STOCKAKHIR,CATATAN,NOTRANSAKSI
											FROM ITEMSTOCK s
											JOIN ITEMSTOCK_HISTORY h ON h.IDITEMSTOCK=s.IDITEMSTOCK
											JOIN M_DEPARTMENT d ON d.ID_DEPARTMENT=h.DEPARTMENTID AND DEPARTMENTISACTIVE='Y'
											JOIN M_ITEM i ON i.IDITEM=s.ITEMSTOCK_IDITEM AND ITEM_ISACTIVE='Y'
											JOIN M_SATUAN u ON u.IDSATUAN=s.ITEMSTOCK_IDSATUAN AND SATUANISACTIVE='Y'
											WHERE ITEMSTOCK_IDITEM='$item' AND ITEMSTOCK_IDSATUAN='$satuan' AND h.DEPARTMENTID='$department'
											AND date_format(h.TANGGAL, '%Y-%m-%d') BETWEEN '$startdate' AND '$finishdate'
											ORDER BY h.TANGGAL ");
			}
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) { 
				?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['TANGGAL'] ?></td>
					<td><?php echo $r['NAMA_DEPARTMENT'] ?></td>
					<td><font color="red"><?php echo $r['ITEMSTOCK_IDITEM'] ?></font> </br><?php echo $r['NAMAITEM'] ?> - <?php echo $r['NAMASATUAN'] ?></td>
					<td><?php echo $r['ITEMSTOCK_LOTNUMBER'] ?></td>
					<td><center><?php echo $r['STOCKAWAL'] ?></center></td>
					<td><center><?php echo $r['STOCKIN'] ?></center></td>
					<td><center><?php echo $r['STOCKOUT'] ?></center></td>
					<td><center><?php echo $r['STOCKAKHIR'] ?></center></td>
					<td><?php echo $r['CATATAN'] ?></td>
					<td><?php echo $r['NOTRANSAKSI'] ?></td>
				</tr>
				<?php
				$no++;
			} ?>
			
		</tbody>
	</table>


    <!-- Custom Js -->
    <script src="js/pages/tables/jquery-datatable.js"></script>