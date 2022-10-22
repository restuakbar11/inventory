
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">No</th>
				<th>Nama</th>
				<th width="18%">Action</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			$no=1;
			$user2 =$mysqli->query( "SELECT * FROM M_SATUAN 
										WHERE SATUANISACTIVE='Y'
										ORDER BY NAMASATUAN ASC ");
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) { ?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['NAMASATUAN'] ?></td>
					<td>
						<center>
							<div class="btn-group">
							<a href="#" class="btn btn-info editsatuan" data="<?php echo $r['IDSATUAN']?>" data-toggle="modal" title="Edit"><i class="fa fa-edit"></i></a>
							<a href="#" class="btn btn-danger hapussatuan" data="<?php echo $r['IDSATUAN']?>" title="Hapus"><i class="fa fa-trash"></i></a>
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