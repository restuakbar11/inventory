
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">No</th>
				<th width="13%">No Retur</th>
				<th>Department Pengirim</th>
				<th>Department Tujuan</th>
				<th width="10%">Tanggal</th>
				<th width="12%">Note</th>
				<th width="12%">Ket Batal</th>
				<th width="10%">Status</th>
				<th width="20%">Action</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			include '../department/queryDepartmentUtama.php';
			$d =mysqli_fetch_array($queryGetDepartment);
			include '../barang_keluar/queryDepartmentPerSession.php';
			$z =mysqli_fetch_array($queryDepartmentPerSession);
			
			$now=date('Y-m-d');
			$startdate	=$_POST['startdate'];
			$finishdate	=$_POST['finishdate'];
			
			$no=1;
			$user2 =$mysqli->query( "SELECT t.*,d.*,t.RETURTANGGAL as TGLRETURNOW
											FROM RETUR t
                                            JOIN M_DEPARTMENT d ON d.ID_DEPARTMENT=t.RETURID_DEPARTMENT
											WHERE t.RETURISACTIVE='Y' AND t.RETURTANGGAL BETWEEN '$startdate' AND '$finishdate' AND t.RETURID_DEPARTMENT='$z[ID_DEPARTMENT]'
											ORDER BY t.NORETUR desc");
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) { 
				$linkbatal=($r['TGLRETURNOW']==$now && $r['RETURVALIDASI']!='N' && $r['FLAGBATAL']=='N' ? "<a href='?page=batalretur&id=".$r['NORETUR']."'><font color=blue>".$r['NORETUR']."</font></a>" 
											: "".$r['NORETUR']."") ;
				if($r['FLAGBATAL']=='Y') {
					$status ='Batal';
					$warna ='danger';
				} else {
					if($r['RETURVALIDASI']=='N') {
						$status ='Belum Validasi';
						$warna ='danger';
					} else if($r['RETURVALIDASI']=='Y') {
						$status ='Belum Check Out';
						$warna ='warning';
					} else if($r['RETURVALIDASI']=='C' AND $r['RETURTERIMA']=='N') {
						$status ='Belum Diterima';
						$warna ='warning';
					} else if($r['RETURVALIDASI']=='C' AND $r['RETURTERIMA']=='Y') {
						$status ='Sudah Diterima';
						$warna ='success';
					}
				}
				?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $linkbatal?></td>
					<td><?php echo $r['NAMA_DEPARTMENT'] ?></td>
					<td><?php echo $d['NAMA_DEPARTMENT'] ?></td>
					<td><?php echo $r['RETURTANGGAL'] ?></td>
					<td><?php echo $r['RETURNOTE'] ?></td>
					<td><?php echo $r['KET_BATAL'] ?></td>
					<td><center><span class="label label-<?php echo $warna ?>"><?php echo $status ?></span></center></td>
					<td><?php
						if($r['FLAGBATAL']=='N') { ?>
							<center>
							<?php
							if($r['RETURVALIDASI']=='N') { ?>
								<a href="?page=add_retur&act=validasi&id=<?php echo $r['NORETUR']?>" class="btn btn-success" title="Validasi">Validasi <i class="fa fa-check-square"></i></a> 
								<a href="?page=add_retur&act=update&id=<?php echo $r['NORETUR']?>" class="btn btn-info" title="Edit"><i class="fa fa-edit"></i></a> 
								<a href="#" class="btn btn-danger hapusretur" data="<?php echo $r['NORETUR']?>" title="Hapus"><i class="fa fa-trash"></i></a>
								<?php
							} else if($r['RETURVALIDASI']=='Y'){ ?>
								<a href="?page=check_out_retur&act=proses&id=<?php echo $r['NORETUR']?>" class="btn btn-primary" title="Check Out Barcode">Check Out <i class="fa fa-external-link"></i></a> 
								
								<?php
							} else if($r['RETURVALIDASI']=='C'){ ?>
								<a href="?page=check_out_retur&act=view&id=<?php echo $r['NORETUR']?>" class="btn btn-warning" data="<?php echo $r['NORETUR']?>" title="View"><i class="fa fa-eye"></i></a>
								<a href="#" class="btn btn-default cetak" data="<?php echo $r['NORETUR']?>" tgl="<?php echo $r['RETURTANGGAL']?>"
									asal="<?php echo $r['NAMA_DEPARTMENT']?>" tujuan="<?php echo $d['NAMA_DEPARTMENT']?>" title="Cetak"><i class="fa fa-print"></i></a>
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