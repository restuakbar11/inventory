
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">No</th>
				<th width="13%">No TAG</th>
				<th>Department Pengirim</th>
				<th>Department Tujuan</th>
				<th width="10%">Tanggal</th>
				<th width="15%">Note</th>
				<th width="10%">Status</th>
				<th width="20%">Action</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			include '../department/queryDepartmentUtama.php';
			$d =mysqli_fetch_array($queryGetDepartment);
			
			$now=date('Y-m-d');
			$startdate	=$_POST['startdate'];
			$finishdate	=$_POST['finishdate'];
			
			$no=1;
			$user2 =$mysqli->query( "SELECT t.*,d.*,t.TAGTANGGAL as TGLTAGNOW
											FROM TAG t
                                            JOIN M_DEPARTMENT d ON d.ID_DEPARTMENT=t.TAGID_DEPARTMENT
											WHERE t.TAGISACTIVE='Y' AND t.TAGTANGGAL BETWEEN '$startdate' AND '$finishdate'
											ORDER BY t.NOTAG desc");
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) { 
				$linkbatal=($r['TGLTAGNOW']==$now && $r['TAGVALIDASI']!='N' &&$r['FLAGBATAL']=='N' ? "<a href='?page=bataltag&id=".$r['NOTAG']."'><font color=blue>".$r['NOTAG']."</font></a>" 
											: "".$r['NOTAG']."") ;
				if($r['FLAGBATAL']=='Y') {
					$status ='Batal';
					$warna ='danger';
				} else {
					if($r['TAGVALIDASI']=='N') {
						$status ='Belum Validasi';
						$warna ='danger';
					} else if($r['TAGVALIDASI']=='Y') {
						$status ='Belum Check Out';
						$warna ='warning';
					} else if($r['TAGVALIDASI']=='C' AND $r['TAGTERIMA']=='N') {
						$status ='Belum Diterima';
						$warna ='warning';
					} else if($r['TAGVALIDASI']=='C' AND $r['TAGTERIMA']=='Y') {
						$status ='Sudah Diterima';
						$warna ='success';
					}
				}
				?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $linkbatal?></td>
					<td><?php echo $d['NAMA_DEPARTMENT'] ?></td>
					<td><?php echo $r['NAMA_DEPARTMENT'] ?></td>
					<td><?php echo $r['TAGTANGGAL'] ?></td>
					<td><?php echo $r['TAGNOTE'] ?></td>
					<td><center><span class="label label-<?php echo $warna ?>"><?php echo $status ?></span></center></td>
					<td><?php
						if($r['FLAGBATAL']=='N') { ?>
							<center>
							<?php
							if($r['TAGVALIDASI']=='N') { ?>
								<a href="?page=add_tag&act=validasi&id=<?php echo $r['NOTAG']?>" class="btn btn-success" title="Validasi">Validasi <i class="fa fa-check-square"></i></a> 
								<a href="?page=add_tag&act=update&id=<?php echo $r['NOTAG']?>" class="btn btn-info" title="Edit"><i class="fa fa-edit"></i></a> 
								<a href="#" class="btn btn-danger hapustag" data="<?php echo $r['NOTAG']?>" title="Hapus"><i class="fa fa-trash"></i></a>
								<?php
							} else if($r['TAGVALIDASI']=='Y'){ ?>
								<a href="?page=check_out_tag&act=proses&id=<?php echo $r['NOTAG']?>" class="btn btn-primary" title="Check Out Barcode">Check Out <i class="fa fa-external-link"></i></a> 
								
								<?php
							} else if($r['TAGVALIDASI']=='C'){ ?>
								<a href="?page=check_out_tag&act=view&id=<?php echo $r['NOTAG']?>" class="btn btn-warning" data="<?php echo $r['NOTAG']?>" title="View"><i class="fa fa-eye"></i></a>
								<a href="#" class="btn btn-default cetak" data="<?php echo $r['NOTAG']?>" tgl="<?php echo $r['TAGTANGGAL']?>"
									asal="<?php echo $d['NAMA_DEPARTMENT']?>" tujuan="<?php echo $r['NAMA_DEPARTMENT']?>" title="Cetak"><i class="fa fa-print"></i></a>
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