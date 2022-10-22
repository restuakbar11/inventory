
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">No</th>
				<th width="15%">No Breakdown</th>
				<th>Department</th>
				<th width="10%">Tanggal</th>
				<th width="15%">Note</th>
				<th width="12%">Ket Batal</th>
				<th width="13%">Status</th>
				<th width="20%">Action</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			session_start();
			$now	=strtotime(date('Y-m-d'));
			$id_department =$_SESSION['id_department'];
			$startdate	=$_POST['startdate'];
			$finishdate	=$_POST['finishdate'];
			$no=1;
			$user2 =$mysqli->query( "SELECT b.*,d.ID_DEPARTMENT,d.NAMA_DEPARTMENT
										FROM BREAKDOWN b
										JOIN M_DEPARTMENT d ON d.ID_DEPARTMENT=b.ID_DEPARTMENT 
										WHERE b.ISACTIVE='Y' AND b.TANGGAL BETWEEN '$startdate' AND '$finishdate' AND d.ID_DEPARTMENT='$id_department'
										ORDER BY NOBREAKDOWN DESC");
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) { 
				$tgl =strtotime($r['TANGGAL']);
				$diff =$now-$tgl;
				$selisih =floor($diff / (60 * 60 * 24));
				
				if($r['FLAGBATAL']=='Y') {
					$status ='Batal';
					$warna ='danger';
				} else {
					if($r['VALIDASI']=='N') {
						$status ='Belum Validasi';
						$warna ='danger';
					} else if($r['VALIDASI']=='Y') {
						$status ='Finish';
						$warna ='success';
					} 
				}
				?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php
						if($selisih<1 AND $r['VALIDASI']=='Y' AND $r['FLAGBATAL']=='N') { ?>
							<a href="?page=breakdown&act=batal&id=<?php echo $r['NOBREAKDOWN'] ?>"><font color="blue"><?php echo $r['NOBREAKDOWN'] ?></font></a>
							<?php
						} else { 
							echo $r['NOBREAKDOWN'] ;
						} ?>
					</td>
					<td><?php echo $r['NAMA_DEPARTMENT'] ?> </td>
					<td><?php echo $r['TANGGAL'] ?></td>
					<td><?php echo $r['NOTE'] ?></td>
					<td><?php echo $r['KETERANGAN'] ?></td>
					<td><center><span class="label label-<?php echo $warna ?>"><?php echo $status ?></span></center></td>
					<td><?php
						if($r['FLAGBATAL']=='N') { ?>
							<center>
							<?php
							if($r['VALIDASI']=='N') { ?>
								<a href="?page=add_breakdown&act=validasi&id=<?php echo $r['NOBREAKDOWN']?>" class="btn btn-success" title="Validasi">Validasi <i class="fa fa-check-square"></i></a> 
								<a href="?page=add_breakdown&act=update&id=<?php echo $r['NOBREAKDOWN']?>" class="btn btn-info" title="Edit"><i class="fa fa-edit"></i></a> 
								<a href="#" class="btn btn-danger hapusbreakdown" data="<?php echo $r['NOBREAKDOWN']?>" title="Hapus"><i class="fa fa-trash"></i></a>
								<?php
							} else if($r['VALIDASI']=='Y'){ ?>
								<a href="?page=view_breakdown&act=view&id=<?php echo $r['NOBREAKDOWN']?>" class="btn btn-warning" title="View"><i class="fa fa-eye"></i></a>
								<a href="#" class="btn btn-default cetak" data="<?php echo $r['NOBREAKDOWN']?>" tgl="<?php echo $r['TANGGAL']?>"
									dept="<?php echo $r['NAMA_DEPARTMENT']?>" title="Cetak"><i class="fa fa-print"></i></a>
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