
	<table class="table table-bordered table-striped table-hover ">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">No</th>
				<th width="12%">Kodebarcode</th>
				<th width="13%">Kode</th>
				<th>Nama Item</th>
				<th width="10%">Satuan</th>
				<th width="15%">Lot Number</th>
				<th width="13%">ED</th>
				<th width="13%">Department</th>
				<th width="7%">Status</th>
				<th width="7%">Action</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			$nosj = urldecode($_GET['nosj']);
			$id_item = urldecode($_GET['id_item']);
			$no=1;
			echo "$nosj";
			echo "$id_item";
			$user2 =$mysqli->query( "SELECT bm.NOBARANGMASUK,bd.NOBARANGMASUK_DETAIL,KODEBARCODE,i.IDITEM,NAMAITEM,NAMASATUAN,LOT_NUMBER,t.ED,NAMA_DEPARTMENT,FLAGGUDANG
											FROM BARANG_MASUK bm 
                                            JOIN BARANG_MASUK_DETAIL bd ON bd.NOBARANGMASUK=bm.NOBARANGMASUK AND bd.BARANGMASUKDETAILISACTIVE='Y'
                                            JOIN M_ITEMBARCODE t ON t.BARANGMASUKDETAILIDMASUK=bd.NOBARANGMASUK_DETAIL AND BARCODEISACTIVE='Y'
											JOIN M_ITEM i ON i.IDITEM=t.M_ITEMIDITEM
											JOIN M_SATUAN s ON s.IDSATUAN=t.M_SATUANIDSATUAN
                                            LEFT JOIN M_DEPARTMENT d ON d.ID_DEPARTMENT=t.M_DEPARTMENTDEPARTMENTID
											WHERE bm.NOBARANGMASUK='$nosj' AND t.M_ITEMIDITEM='$id_item'
											ORDER BY t.BARANGMASUKDETAILIDMASUK,KODEBARCODE");
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) { ?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['KODEBARCODE'] ?></td>
					<td><?php echo $r['IDITEM'] ?></td>
					<td><?php echo $r['NAMAITEM'] ?></td>
					<td><?php echo $r['NAMASATUAN'] ?></td>
					<td><?php echo $r['LOT_NUMBER'] ?></td>
					<td><?php echo $r['ED'] ?></td>
					<td><?php echo $r['NAMA_DEPARTMENT'] ?></td>
					<td>
						<center>
							<div class="btn-group">
							<?php
							if($r['FLAGGUDANG']==0) { ?>
								<span class="label label-danger">Belum Check In</span>
								<?php
							} else if($r['FLAGGUDANG']==1) { ?>
								<span class="label label-warning">Sudah Check In</span>
								<?php
							} else if($r['FLAGGUDANG']==2) { ?>
								<span class="label label-success">Sudah Check In</span>
								<?php
							} ?>
							</div>
						</center>
					</td>
					<td>
						<a class="btn btn-sm cetak_barcode_satuan" data="<?php echo $r['KODEBARCODE'] ?>" title="cetak"><i class="fa fa-print"></i></a>
					</td>
				</tr>
				<?php
				$no++;
			} ?>
			
		</tbody>
	</table>
	
