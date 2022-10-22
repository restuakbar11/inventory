
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th>No</th>
				<th>Kode Kulkas/ Nama Kulkas</th>
				<th>Sub Department</th>
				<th>Department</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			$no=1; 
			$sql =$mysqli->query( "select dk.KODE_KULKAS, d.ID_SUBDEPARTMENT,d.NAMA_SUBDEPARTMENT,dp.NAMA_DEPARTMENT, g.NAMAGUDANG from M_SUBDEPARTMENTKULKAS dk
									join M_SUBDEPARTMENT d ON d.ID_SUBDEPARTMENT = dk.ID_SUBDEPARTMENT
									JOIN M_KULKAS k ON k.KODE_KULKAS = dk.KODE_KULKAS
									JOIN M_GUDANG g ON g.ID_GUDANG = k.ID_GUDANG
									JOIN M_DEPARTMENT dp ON dp.ID_DEPARTMENT = d.ID_DEPARTMENT AND dp.DEPARTMENTISACTIVE='Y'
									WHERE SUBDEPARTMENTKULKASISACTIVE = 'Y' ");
			// oci_execute($sql);
			while ($r =mysqli_fetch_array($sql)) { ?>
				<tr>
					<td><?php echo $no?></td>
					<td><?php echo '[ '.$r['KODE_KULKAS'].' ] - '.$r['NAMAGUDANG']?></td>
					<td><?php echo $r['NAMA_SUBDEPARTMENT']?></td>
					<td><?php echo $r['NAMA_DEPARTMENT']?></td>
					<td><center>
						<a href="#" class="btn btn-info btn-sm editsubdepartmentkulkas" data-toggle="modal" data="<?php echo $r['KODE_KULKAS'] ?>" id_subDept="<?php echo $r['ID_SUBDEPARTMENT'] ?>" style="color:white; width:35px;" title="Edit"><i class="fa fa-edit"></i></a>
						<a id="hapussubdepartmentkulkas" class="btn btn-danger btn-sm hapussubdepartmentkulkas" data="<?php echo $r['KODE_KULKAS'] ?>" style="color:white; width:35px;" title="Hapus"><i class="fa fa-trash"></i></a>
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

