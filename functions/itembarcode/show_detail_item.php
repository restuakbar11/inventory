
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">#</th>
				<th width="12%">Kodebarcode</th>
				<th width="13%">Kode</th>
				<th>Nama Item</th>
				<th width="10%">Satuan</th>
				<th width="15%">Lot Number</th>
				<th width="13%">ED</th>
				<th width="7%">Status</th>
				<th width="7%">Action</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			$nosj = urldecode($_GET['nosj']);
			$id_item = urldecode($_GET['id_item']);
			$no=1;
			echo "$nosj";
			echo "$id_item";
			$user2 =$mysqli->query( "select * from m_itembarcode i
							join m_satuan s on s.idsatuan = i.m_satuanidsatuan 
							where i.idgudang = 1 and i.m_departmentdepartmentid = 41 and i.BARCODEISACTIVE = 'Y'");
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) {

			?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['KODEBARCODE'] ?></td>
					<td><?php echo $r['IDITEM'] ?></td>
					<td><?php echo $r['NAMAITEM'] ?></td>
					<td><?php echo $r['NAMASATUAN'] ?></td>
					<td><?php echo $r['LOT_NUMBER'] ?></td>
					<td><?php echo $r['ED'] ?></td>
					<td><?php echo $r['NAMA_DEPARTMENT'] ?></td>
					<td>
						<center>
							<div class="btn-group">
							<?php
							if($r['FLAGGUDANG']==0) { ?>
								<span class="label label-danger">Belum Check In</span>
								<?php
							} else if($r['FLAGGUDANG']==1) { ?>
								<span class="label label-warning">Sudah Check In</span> 
								<?php
							} else if($r['FLAGGUDANG']==2) { ?>
								<span class="label label-success">Sudah Check In</span>
								<?php
							} ?>
							</div>
						</center>
					</td>
					<td>
						<a id="printbarcode" class="btn btn-warning btn-sm printbarcode" data="<?php echo $r['NOBARANGMASUK'] ?>&<?php echo $r['BARANGMASUKDETAILM_ITEMID'] ?>" title="print"><i class="fa fa-print"></i></a>
					</td>
				</tr>
				<?php
				$no++;
			} ?>
			
		</tbody>
	</table>
	


    <!-- Custom Js -->
    <script src="js/pages/tables/jquery-datatable.js"></script>