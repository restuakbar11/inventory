
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">No</th>
				<th width="13%">Kode</th>
				<th>Nama Item</th>
				<th width="10%">Satuan</th>
				<th width="15%">Lot Number</th>
				<th width="10%">Qty</th>
				<th width="13%">ED</th>
				<th width="7%">Action</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			$no=1;
			$user2 =$mysqli->query( "SELECT t.NORETUR,d.NORETUR_DETAIL,i.IDITEM,i.NAMAITEM,s.IDSATUAN,s.NAMASATUAN,d.RETURDETAIL_QTY,
									d.RETURDETAIL_LOTNUMBER,d.RETURDETAIL_ED
											FROM RETUR t
											JOIN RETUR_DETAIL d ON d.NORETUR=t.NORETUR AND d.RETURDETAIL_ISACTIVE='Y'
											LEFT JOIN M_ITEM i ON i.IDITEM=d.RETURDETAIL_IDITEM
											LEFT JOIN M_SATUAN s ON s.IDSATUAN=d.RETURDETAIL_IDSATUAN
											WHERE t.NORETUR='$_POST[no_retur]' AND t.RETURISACTIVE='Y' 
											ORDER BY d.NORETUR_DETAIL desc");
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) { ?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['IDITEM'] ?></td>
					<td><?php echo $r['NAMAITEM'] ?></td>
					<td><?php echo $r['NAMASATUAN'] ?></td>
					<td><?php echo $r['RETURDETAIL_LOTNUMBER'] ?></td>
					<td><?php echo $r['RETURDETAIL_QTY'] ?></td>
					<td><?php echo $r['RETURDETAIL_ED'] ?></td>
					<td>
						<center>
							<div class="btn-group">
							<?php
							if($_POST['act']=='update') { ?>
								<a href="#" class="btn btn-danger hapusitem" data="<?php echo $r['NORETUR_DETAIL']?>" title="Hapus"><i class="fa fa-trash"></i></a>
								<?php
							} ?>
							</div>
						</center>
					</td>
				</tr>
				<?php
				$no++;
			} ?>
			
		</tbody>
	</table>
	<input type="hidden" id="jml_data" value="<?php echo $no-1 ?>">


    <!-- Custom Js -->
    <script src="js/pages/tables/jquery-datatable.js"></script>