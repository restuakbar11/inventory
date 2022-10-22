
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">No</th>
				<th width="13%">No TAG</th>
				<th width="11%">Tanggal TAG</th>
				<th width="14%">Tanggal Diterima</th>
				<th>Department Pengirim</th>
				<th>Department Penerima</th>
				<th width="12%">Note</th>
				<th width="10%">Status</th>
				<th width="10%">Action</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			include '../department/queryDepartmentUtama.php';
			$d =mysqli_fetch_array($queryGetDepartment);
			
			session_start();
			$id_department	=$_SESSION['id_department'];
			$startdate	=$_POST['startdate'];
			$finishdate	=$_POST['finishdate'];
			$status 	=$_POST['status'];
			$no=1;
			if($status=='all') {
					$sql =$mysqli->query( "SELECT NOTAG,TAGTANGGAL,NAMA_DEPARTMENT,TAGNOTE,date_format(TAGTERIMA_TANGGAL, '%Y-%m-%d') AS TAGTERIMA_TANGGAL,
										TAGTERIMA,FLAGBATAL
											FROM TAG t
                                            JOIN M_DEPARTMENT d ON d.ID_DEPARTMENT=t.TAGID_DEPARTMENT
											WHERE TAGISACTIVE='Y' AND TAGTANGGAL BETWEEN '$startdate' AND '$finishdate' AND TAGVALIDASI='C' AND t.TAGID_DEPARTMENT='$id_department'
											ORDER BY NOTAG desc");
			} else if($status=='belum diterima') {
					$sql =$mysqli->query( "SELECT NOTAG,TAGTANGGAL,NAMA_DEPARTMENT,TAGNOTE,date_format(TAGTERIMA_TANGGAL, '%Y-%m-%d') AS TAGTERIMA_TANGGAL,
										TAGTERIMA,FLAGBATAL
											FROM TAG t
                                            JOIN M_DEPARTMENT d ON d.ID_DEPARTMENT=t.TAGID_DEPARTMENT
											WHERE TAGISACTIVE='Y' AND TAGTANGGAL BETWEEN '$startdate' AND '$finishdate' AND TAGVALIDASI='C' AND t.TAGID_DEPARTMENT='$id_department' 
												AND TAGTERIMA='N'
											ORDER BY NOTAG desc");
			} else if($status=='sudah diterima') {
					$sql =$mysqli->query( "SELECT NOTAG,TAGTANGGAL,NAMA_DEPARTMENT,TAGNOTE,date_format(TAGTERIMA_TANGGAL, '%Y-%m-%d') AS TAGTERIMA_TANGGAL,
										TAGTERIMA,FLAGBATAL
											FROM TAG t
                                            JOIN M_DEPARTMENT d ON d.ID_DEPARTMENT=t.TAGID_DEPARTMENT
											WHERE TAGISACTIVE='Y' AND TAGTANGGAL BETWEEN '$startdate' AND '$finishdate' AND TAGVALIDASI='C' AND t.TAGID_DEPARTMENT='$id_department' 
												AND TAGTERIMA='Y'
											ORDER BY NOTAG desc");
			}
			// oci_execute($sql);
			while ($r =mysqli_fetch_array($sql)) { 
				if($r['FLAGBATAL']=='Y') {
					$status ='Batal TAG';
					$warna ='danger';
				} else {
					if($r['TAGTERIMA']=='N') {
						$status ='Belum Check In Barcode';
						$warna ='warning';
					} else if($r['TAGTERIMA']=='Y') {
						$status ='Finish';
						$warna ='success';
					} 
				}
				?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['NOTAG'] ?></td>
					<td><?php echo $r['TAGTANGGAL'] ?></td>
					<td><?php echo $r['TAGTERIMA_TANGGAL'] ?></td>
					<td><?php echo $d['NAMA_DEPARTMENT'] ?></td>
					<td><?php echo $r['NAMA_DEPARTMENT'] ?></td>
					<td><?php echo $r['TAGNOTE'] ?></td>
					<td><center><span class="label label-<?php echo $warna ?>"><?php echo $status ?></span></center></td>
					<td><?php
						if($r['FLAGBATAL']=='N') { ?>
							<center>
							<?php
							if($r['TAGTERIMA']=='N') { ?>
								<a href="?page=penerimaan_tag&act=proses&id=<?php echo $r['NOTAG']?>" class="btn btn-primary" title="Proses">Proses <i class="fa fa-check-square"></i></a> 
								<?php
							} else if($r['TAGTERIMA']=='Y'){ ?>
								<a href="?page=penerimaan_tag&act=view&id=<?php echo $r['NOTAG']?>" class="btn btn-warning" data="<?php echo $r['NOTAG']?>" title="View"><i class="fa fa-eye"></i></a>
								<!--<a href="#" class="btn btn-default cetak" data="<?php echo $r['NOTAG']?>" tgl_kirim="<?php echo $r['TAGTANGGAL']?>" tgl_terima="<?php echo $r['TAGTERIMA_TANGGAL']?>"
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