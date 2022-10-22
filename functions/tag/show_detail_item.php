
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
			$user2 =$mysqli->query( "SELECT t.NOTAG,d.NOTAG_DETAIL,i.IDITEM,i.NAMAITEM,s.IDSATUAN,s.NAMASATUAN,d.TAGDETAILQTY,
									d.TAGDETAILM_ITEMSTOCKLOTNUMBER,d.TAGDETAILED
											FROM TAG t
											JOIN TAG_DETAIL d ON d.NOTAG=t.NOTAG AND d.TAGDETAILISACTIVE='Y'
											LEFT JOIN M_ITEM i ON i.IDITEM=d.TAGDETAILM_ITEMID
											LEFT JOIN M_SATUAN s ON s.IDSATUAN=d.TAGDETAILM_SATUANID
											WHERE t.NOTAG='$_POST[no_tag]' AND t.TAGISACTIVE='Y' 
											ORDER BY d.NOTAG_DETAIL desc");
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) { ?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['IDITEM'] ?></td>
					<td><?php echo $r['NAMAITEM'] ?></td>
					<td><?php echo $r['NAMASATUAN'] ?></td>
					<td><?php echo $r['TAGDETAILM_ITEMSTOCKLOTNUMBER'] ?></td>
					<td><?php echo $r['TAGDETAILQTY'] ?></td>
					<td><?php echo $r['TAGDETAILED'] ?></td>
					<td>
						<center>
							<div class="btn-group">
							<?php
							if($_POST['act']=='update') { ?>
								<a href="#" class="btn btn-danger hapusitem" data="<?php echo $r['NOTAG_DETAIL']?>" title="Hapus"><i class="fa fa-trash"></i></a>
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