
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">No</th>
				<th width="13%">Kode Barcode Header</th>
				<th width="13%">Item</th>
				<th width="10%">Satuan Awal</th>
				<th width="10%">Satuan Baru</th>
				<th width="10%">Qty Awal</th>
				<th width="10%">Qty Baru</th>
				<th width="7%">Action</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			$no=1;
			$user2 =$mysqli->query( "SELECT t.NOBREAKDOWN,d.NOBREAKDOWNDETAIL,i.IDITEM,i.NAMAITEM,s.NAMASATUAN,ss.NAMASATUAN as SATUANAKHIR,
                                    d.QTY_AWAL,d.QTY_AKHIR,KODEBARCODE_HEADER
											FROM BREAKDOWN t
											JOIN BREAKDOWN_DETAIL d ON d.NOBREAKDOWN=t.NOBREAKDOWN AND d.ISACTIVE='Y'
                                            JOIN M_ITEMBARCODE b ON b.KODEBARCODE=d.KODEBARCODE_HEADER
											LEFT JOIN M_ITEM i ON i.IDITEM=b.M_ITEMIDITEM
											LEFT JOIN M_SATUAN s ON s.IDSATUAN=b.M_SATUANIDSATUAN
											LEFT JOIN M_SATUAN ss ON ss.IDSATUAN=d.IDSATUAN_AKHIR
											WHERE t.NOBREAKDOWN='$_POST[no_breakdown]' AND t.ISACTIVE='Y' 
											ORDER BY d.NOBREAKDOWNDETAIL desc");
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) { ?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['KODEBARCODE_HEADER'] ?></td>
					<td><font color="red"><?php echo $r['IDITEM'] ?></font> </br><?php echo $r['NAMAITEM'] ?></td>
					<td><?php echo $r['NAMASATUAN'] ?></td>
					<td><?php echo $r['SATUANAKHIR'] ?></td>
					<td><?php echo $r['QTY_AWAL'] ?></td>
					<td><?php echo $r['QTY_AKHIR'] ?></td>
					<td>
						<center>
							<div class="btn-group">
							<?php
							if($_POST['act']=='update') { ?>
								<a href="#" class="btn btn-danger hapusitem" data="<?php echo $r['NOBREAKDOWNDETAIL']?>" title="Hapus"><i class="fa fa-trash"></i></a>
								<?php
							} else if($_POST['act']=='view') { ?>
								<a href="#" class="btn btn-info viewbarcode" data="<?php echo $r['NOBREAKDOWNDETAIL']?>" title="Detail Barcode">Barcode <i class="fa fa-eye"></i></a>
								<?php
							} else if($_POST['act']=='batal') { ?>
								<a href="#" class="btn btn-info viewbarcode" data="<?php echo $r['NOBREAKDOWNDETAIL']?>" title="Detail Barcode">Barcode <i class="fa fa-eye"></i></a>
								<?php
							} ?>
							</div>
						</center>
					</td>
				</tr>
				<?php
				$no++;
			} ?>
			
		</tbody>
	</table>
	<input type="hidden" id="jml_data" value="<?php echo $no-1 ?>">
	


    <!-- Custom Js -->
    <script src="js/pages/tables/jquery-datatable.js"></script>