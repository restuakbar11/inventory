
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th>No</th>
				<th>Nama Sub Departemen</th>
				<th>Departemen</th>
				<th>Ruangan</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			$no=1;
			$sql =$mysqli->query( "SELECT ID_SUBDEPARTMENT,s.NAMA_SUBDEPARTMENT,d.NAMA_DEPARTMENT, NAMA_RUANGAN, NAMA_GEDUNG,LANTAI from M_SUBDEPARTMENT s
												left join M_RUANGAN r on r.id_ruangan = s.id_ruangan
												left join M_GEDUNG g on g.id_gedung = r.id_gedung
												left join M_DEPARTMENT d on d.id_department = s.id_department
												where s.subdepartmentisactive = 'Y'
												order by nama_department asc ");
			// oci_execute($sql);
			while ($r =mysqli_fetch_array($sql)) { ?>
				<tr>
					<td><?php echo $no?></td>
					<td><?php echo $r['NAMA_SUBDEPARTMENT']?></td>
					<td><?php echo $r['NAMA_DEPARTMENT']?></td>
					<td><?php echo $r['NAMA_RUANGAN'].'<br> Gedung <b>'.$r['NAMA_GEDUNG'].'</b> Lantai '.$r['LANTAI']?></td>
					<td><center>
						<a href="#" class="btn btn-info btn-sm editsubdepartment" data-toggle="modal" data="<?php echo $r['ID_SUBDEPARTMENT'] ?>" style="color:white; width:35px;" title="Edit"><i class="fa fa-edit"></i></a>
						<a id="hapussubdepartment" class="btn btn-danger btn-sm hapussubdepartment" data="<?php echo $r['ID_SUBDEPARTMENT'] ?>" style="color:white; width:35px;" title="Hapus"><i class="fa fa-trash"></i></a>
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

