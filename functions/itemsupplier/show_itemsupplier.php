
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">No</th>
				<th width="25%">Nama Supplier</th>
				<th width="13%">ID Item</th>
				<th>Nama Item</th>
				<th width="12%">Action</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			$no=1;
			$user2 =$mysqli->query( "SELECT * FROM M_ITEMSUPPLIER p 
										JOIN M_SUPPLIER s ON s.IDSUPPLIER=p.ITEMSUPPLIER_IDSUPPLIER
										JOIN M_ITEM i ON i.IDITEM=p.ITEMSUPPLIER_IDITEM
										WHERE ITEMSUPPLIERISACTIVE='Y'
										ORDER BY ITEMSUPPLIER_IDSUPPLIER ASC ");
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) { ?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['NAMASUPPLIER'] ?></td>
					<td><?php echo $r['IDITEM'] ?></td>
					<td><?php echo $r['NAMAITEM'] ?></td>
					<td>
						<center>
							<div class="btn-group">
							<a href="#" class="btn btn-info edititemsupplier" data="<?php echo $r['IDITEMSUPPLIER']?>" data-toggle="modal" title="Edit"><i class="fa fa-edit"></i></a>
							<a href="#" class="btn btn-danger hapusitemsupplier" data="<?php echo $r['IDITEMSUPPLIER']?>" title="Hapus"><i class="fa fa-trash"></i></a>
							</div>
						</center>
					</td>
				</tr>
				<?php
				$no++;
			} ?>
			
		</tbody>
	</table>


    <!-- Custom Js -->
    <script src="js/pages/tables/jquery-datatable.js"></script>