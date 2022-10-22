
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">No</th>
				<th width="15%">No Barang Keluar</th>
				<th width="15%">Sub Department Tujuan</th>
				<th width="10%">Tanggal</th>
				<th width="12%">Note</th>
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
			$user2 =$mysqli->query( "SELECT b.*,s.NAMA_SUBDEPARTMENT,d.ID_DEPARTMENT,d.NAMA_DEPARTMENT
										FROM BARANG_KELUAR b
										JOIN M_SUBDEPARTMENT s ON s.ID_SUBDEPARTMENT=b.BARANGKELUARID_SUBDEPARTMENT
										JOIN M_DEPARTMENT d ON d.ID_DEPARTMENT=b.BARANGKELUARID_DEPARTMENT 
										WHERE BARANGKELUARISACTIVE='Y' AND BARANGKELUARTANGGAL BETWEEN '$startdate' AND '$finishdate' AND d.ID_DEPARTMENT='$id_department'
										ORDER BY NOBARANGKELUAR DESC");
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) { 
				$tgl =strtotime($r['BARANGKELUARTANGGAL']);
				$diff =$now-$tgl;
				$selisih =floor($diff / (60 * 60 * 24));
				
				if($r['BARANGKELUARFLAGBATAL']=='Y') {
					$status ='Batal';
					$warna ='danger';
				} else {
					if($r['BARANGKELUARVALIDASI']=='N') {
						$status ='Belum Validasi';
						$warna ='danger';
					} else if($r['BARANGKELUARVALIDASI']=='Y') {
						$status ='Belum Check Out';
						$warna ='warning';
					} else if($r['BARANGKELUARVALIDASI']=='C') {
						$status ='Finish';
						$warna ='success';
					}
				}

				// $nobrgkeluar = '<a href="#" class="batal_keluar" data="'.$r[NOBARANGKELUAR].'" ><font color=blue>'.$r[NOBARANGKELUAR].'</font></a>';
				?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php
						if($selisih<1 AND $r['BARANGKELUARVALIDASI']!='N' AND $r['BARANGKELUARFLAGBATAL']=='N') { 
							echo $r['NOBARANGKELUAR'];
						} else { 
							echo $r['NOBARANGKELUAR'] ;
						} ?>
					</td>
					<td><?php echo $r['NAMA_SUBDEPARTMENT'] ?> </br><font color="red"><small>(Department :<?php echo $r['NAMA_DEPARTMENT'] ?>)</small></font></td>
					<td><?php echo $r['BARANGKELUARTANGGAL'] ?></td>
					<td><?php echo $r['BARANGKELUARNOTE'] ?></td>
					<td><?php echo $r['BARANGKELUARKETERANGAN'] ?></td>
					<td><center><span class="label label-<?php echo $warna ?>"><?php echo $status ?></span></center></td>
					<td><?php
						if($r['BARANGKELUARFLAGBATAL']=='N') { ?>
							<center>
							<?php
							if($r['BARANGKELUARVALIDASI']=='N') { ?>
								<a href="?page=add_barangkeluar&act=validasi&id=<?php echo $r['NOBARANGKELUAR']?>" class="btn btn-success" title="Validasi">Validasi <i class="fa fa-check-square"></i></a> 
								<a href="?page=add_barangkeluar&act=update&id=<?php echo $r['NOBARANGKELUAR']?>" class="btn btn-info" title="Edit"><i class="fa fa-edit"></i></a> 
								<a href="#" class="btn btn-danger hapusbarangkeluar" data="<?php echo $r['NOBARANGKELUAR']?>" title="Hapus"><i class="fa fa-trash"></i></a>
								<?php
							} else if($r['BARANGKELUARVALIDASI']=='Y'){ ?>
								<a href="?page=check_out_barangkeluar&act=proses&id=<?php echo $r['NOBARANGKELUAR']?>" class="btn btn-primary" title="Check Out Barcode">Check Out <i class="fa fa-external-link"></i></a> 
								
								<?php
							} else if($r['BARANGKELUARVALIDASI']=='C'){ ?>
								<a href="?page=check_out_barangkeluar&act=view&id=<?php echo $r['NOBARANGKELUAR']?>" class="btn btn-warning" title="View"><i class="fa fa-eye"></i></a>
								<a href="#" class="btn btn-default cetak" data="<?php echo $r['NOBARANGKELUAR']?>" tgl="<?php echo $r['BARANGKELUARTANGGAL']?>"
									dept="<?php echo $r['NAMA_DEPARTMENT']?>" sub_dept="<?php echo $r['NAMA_SUBDEPARTMENT']?>" title="Cetak"><i class="fa fa-print"></i></a>
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