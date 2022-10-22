
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">No</th>
				<th width="13%">No RETUR</th>
				<th width="11%">Tanggal RETUR</th>
				<th width="14%">Tanggal Diterima</th>
				<th>Department Pengirim</th>
				<th>Department Penerima</th>
				<th width="12%">Note</th>
				<th width="12%">Ket Batal</th>
				<th width="10%">Status</th>
				<th width="10%">Action</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			include '../department/queryDepartmentUtama.php';
			$d =mysqli_fetch_array($queryGetDepartment);
			$departmentUtama =$d['NAMA_DEPARTMENT'];
			
			session_start();
			$id_department	=$_SESSION['id_department'];
			$startdate	=$_POST['startdate'];
			$finishdate	=$_POST['finishdate'];
			$status 	=$_POST['status'];
			$no=1;
			if($status=='all') {
					$sql =$mysqli->query( "SELECT NORETUR,RETURTANGGAL,NAMA_DEPARTMENT,RETURNOTE,date_format(RETURTERIMATANGGAL, '%Y-%m-%d') AS RETURTERIMATANGGAL,
										RETURTERIMA,FLAGBATAL,KET_BATAL
											FROM RETUR t
                                            JOIN M_DEPARTMENT d ON d.ID_DEPARTMENT=t.RETURID_DEPARTMENT
											WHERE RETURISACTIVE='Y' AND RETURTANGGAL BETWEEN '$startdate' AND '$finishdate' AND RETURVALIDASI='C' 
											ORDER BY NORETUR desc");
			} else if($status=='belum diterima') {
					$sql =$mysqli->query( "SELECT NORETUR,RETURTANGGAL,NAMA_DEPARTMENT,RETURNOTE,date_format(RETURTERIMATANGGAL, '%Y-%m-%d') AS RETURTERIMATANGGAL,
										RETURTERIMA,FLAGBATAL,KET_BATAL
											FROM RETUR t
                                            JOIN M_DEPARTMENT d ON d.ID_DEPARTMENT=t.RETURID_DEPARTMENT
											WHERE RETURISACTIVE='Y' AND RETURTANGGAL BETWEEN '$startdate' AND '$finishdate' AND RETURVALIDASI='C'  
												AND RETURTERIMA='N'
											ORDER BY NORETUR desc");
			} else if($status=='sudah diterima') {
					$sql =$mysqli->query( "SELECT NORETUR,RETURTANGGAL,NAMA_DEPARTMENT,RETURNOTE,date_format(RETURTERIMATANGGAL, '%Y-%m-%d') AS RETURTERIMATANGGAL,
										RETURTERIMA,FLAGBATAL,KET_BATAL
											FROM RETUR t
                                            JOIN M_DEPARTMENT d ON d.ID_DEPARTMENT=t.RETURID_DEPARTMENT
											WHERE RETURISACTIVE='Y' AND RETURTANGGAL BETWEEN '$startdate' AND '$finishdate' AND RETURVALIDASI='C'  
												AND RETURTERIMA='Y'
											ORDER BY NORETUR desc");
			}
			// oci_execute($sql);
			while ($r =mysqli_fetch_array($sql)) { 
				if($r['FLAGBATAL']=='Y') {
					$status ='Batal RETUR';
					$warna ='danger';
				} else {
					if($r['RETURTERIMA']=='N') {
						$status ='Belum Diterima';
						$warna ='warning';
					} else if($r['RETURTERIMA']=='Y') {
						$status ='Finish';
						$warna ='success';
					} 
				}
				?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['NORETUR'] ?></td>
					<td><?php echo $r['RETURTANGGAL'] ?></td>
					<td><?php echo $r['RETURTERIMATANGGAL'] ?></td>
					<td><?php echo $r['NAMA_DEPARTMENT'] ?></td>
					<td><?php echo $departmentUtama ?></td>
					<td><?php echo $r['RETURNOTE'] ?></td>
					<td><?php echo $r['KET_BATAL'] ?></td>
					<td><center><span class="label label-<?php echo $warna ?>"><?php echo $status ?></span></center></td>
					<td><?php
						if($r['FLAGBATAL']=='N') { ?>
							<center>
							<?php
							if($r['RETURTERIMA']=='N') { ?>
								<a href="?page=penerimaan_retur&act=proses&id=<?php echo $r['NORETUR']?>" class="btn btn-primary" title="Proses">Proses <i class="fa fa-check-square"></i></a> 
								<?php
							} else if($r['RETURTERIMA']=='Y'){ ?>
								<a href="?page=penerimaan_retur&act=view&id=<?php echo $r['NORETUR']?>" class="btn btn-warning" data="<?php echo $r['NORETUR']?>" title="View"><i class="fa fa-eye"></i></a>
								<!--<a href="#" class="btn btn-default cetak" data="<?php echo $r['NORETUR']?>" tgl_kirim="<?php echo $r['RETURTANGGAL']?>" tgl_terima="<?php echo $r['RETURTERIMATANGGAL']?>"
									asal="<?php echo $d['NAMA_DEPARTMENT']?>" tujuan="<?php echo $r['NAMA_DEPARTMENT']?>" title="Cetak"><i class="fa fa-print"></i></a>-->
								<?php
							} ?>
							</center>
							<?php
						} ?>
					</td>
				</tr>
				<?php
				$no++;
			} ?>
			
		</tbody>
	</table>


    <!-- Custom Js -->
    <script src="js/pages/tables/jquery-datatable.js"></script>