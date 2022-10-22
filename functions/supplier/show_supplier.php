
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">No</th>
				<th>Nama Supplier</th>
				<th width="20%">Alamat</th>
				<th width="15%">Email</th>
				<th width="13%">Contact Person</th>
				<th width="12%">Telp</th>
				<th width="13%">Action</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			$no=1;
			$user2 =$mysqli->query( "SELECT * FROM M_SUPPLIER 
										WHERE SUPPLIERISACTIVE='Y'
										ORDER BY NAMASUPPLIER ASC ");
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) { ?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['NAMASUPPLIER'] ?></td>
					<td><?php echo $r['ADDRESSSUPPLIER'] ?></td>
					<td><?php echo $r['EMAILSUPPLIER'] ?></td>
					<td><?php echo $r['SUPPLIERCONTACTPERSON'] ?></td>
					<td><?php echo $r['TELEPHONESUPPLIER'] ?></td>
					<td>
						<center>
							<div class="btn-group">
							<a href="#" class="btn btn-info editsupplier" data="<?php echo $r['IDSUPPLIER']?>" data-toggle="modal" title="Edit"><i class="fa fa-edit"></i></a>
							<a href="#" class="btn btn-danger hapussupplier" data="<?php echo $r['IDSUPPLIER']?>" title="Hapus"><i class="fa fa-trash"></i></a>
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