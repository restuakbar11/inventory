
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">No</th>
				<th width="20%">ID</th>
				<th>Nama</th>
				<th width="18%">Action</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			$no=1;
			$user2 =$mysqli->query( "SELECT * FROM M_KELOMPOKITEM 
										WHERE KELOMPOKITEMISACTIVE='Y'
										ORDER BY IDKELOMPOKITEM ASC ");
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) { ?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['IDKELOMPOKITEM'] ?></td>
					<td><?php echo $r['NAMAKELOMPOKITEM'] ?></td>
					<td>
						<center>
							<div class="btn-group">
							<a href="#" class="btn btn-info editkelompokitem" data="<?php echo $r['IDKELOMPOKITEM']?>" data-toggle="modal" title="Edit"><i class="fa fa-edit"></i></a>
							<a href="#" class="btn btn-danger hapuskelompokitem" data="<?php echo $r['IDKELOMPOKITEM']?>" title="Hapus"><i class="fa fa-trash"></i></a>
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