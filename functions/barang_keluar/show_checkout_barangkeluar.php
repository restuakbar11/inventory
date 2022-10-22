
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">No</th>
				<th width="13%">Kode</th>
				<th>Nama Item</th>
				<th width="10%">Satuan</th>
				<th width="15%">Lot Number</th>
				<th width="13%">ED</th>
				<th width="10%">Qty</th>
				<th width="12%">Qty Terpenuhi</th>
				<?php
				if($_POST['act']=='view') { ?>
					<th width="10%">Action</th>
					<?php
				} ?>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			$no=1;
			$user2 =$mysqli->query( "SELECT t.NOBARANGKELUAR,d.NOBARANGKELUARDETAIL,i.IDITEM,i.NAMAITEM,s.IDSATUAN,s.NAMASATUAN,d.BARANGKELUARDETAILQTY,
									d.BARANGKELUARDETAILLOT_NUMBER,d.BARANGKELUARDETAILED,BARANGKELUARDETAILTERPENUHI
											FROM BARANG_KELUAR t
											JOIN BARANG_KELUAR_DETAIL d ON d.NOBARANGKELUAR=t.NOBARANGKELUAR AND d.BARANGKELUARDETAILISACTIVE='Y'
											LEFT JOIN M_ITEM i ON i.IDITEM=d.BARANGKELUARDETAILIDITEM
											LEFT JOIN M_SATUAN s ON s.IDSATUAN=d.BARANGKELUARDETAILIDSATUAN
											WHERE t.NOBARANGKELUAR='$_POST[no_barang_keluar]' AND t.BARANGKELUARISACTIVE='Y' 
											ORDER BY d.NOBARANGKELUARDETAIL desc");
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) { ?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['IDITEM'] ?></td>
					<td><?php echo $r['NAMAITEM'] ?></td>
					<td><?php echo $r['NAMASATUAN'] ?></td>
					<td><?php echo $r['BARANGKELUARDETAILLOT_NUMBER'] ?></td>
					<td><?php echo $r['BARANGKELUARDETAILED'] ?></td>
					<td><?php echo $r['BARANGKELUARDETAILQTY'] ?></td>
					<td><?php echo $r['BARANGKELUARDETAILTERPENUHI'] ?></td>
					<?php
					if($_POST['act']=='view') { ?>
						<td><a href="#" class="btn btn-info viewbarcode" data="<?php echo $r['NOBARANGKELUARDETAIL']?>" title="Detail Barcode">Detail Barcode</a></td>
						<?php
					} ?>
				</tr>
				<?php
				$no++;
			} ?>
			
		</tbody>
	</table>
	


    <!-- Custom Js -->
    <script src="js/pages/tables/jquery-datatable.js"></script>