
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">No</th>
				<th width="18%">Nama</th>
				<th width="18%">Alamat</th>
				<th width="10%">Jenis Kelamin</th>
				<th width="15%">User Group</th>
				<th width="15%">Department</th>
				<th width="10%">Username</th>
				<th width="18%">Action</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			$no=1;
			$user2 =$mysqli->query( "SELECT s.*,g.*,d.ID_DEPARTMENT,d.NAMA_DEPARTMENT FROM M_USER s 
										LEFT JOIN M_USERGROUP g ON USERGROUPID=USER_USERGROUPID
										LEFT JOIN M_DEPARTMENT d ON d.ID_DEPARTMENT=s.USER_IDDEPARTMENT
										WHERE USER_ISACTIVE='Y'
										ORDER BY USER_NAMA ASC ");
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) { ?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['USER_NAMA'] ?></td>
					<td><?php echo $r['USER_ALAMAT'] ?></td>
					<td><?php echo $r['USER_KELAMIN'] ?></td>
					<td><?php echo $r['USERGROUPNAMA'] ?></td>
					<td><?php echo $r['NAMA_DEPARTMENT'] ?></td>
					<td><?php echo $r['USER_USERNAME'] ?></td>
					<td>
						<center>
							<div class="btn-group">
							<a href="#" class="btn btn-info edituser" data="<?php echo $r['USERID']?>" data-toggle="modal" title="Edit"><i class="fa fa-edit"></i></a>
							<a href="#" class="btn btn-danger hapususer" data="<?php echo $r['USERID']?>" title="Hapus"><i class="fa fa-trash"></i></a>
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