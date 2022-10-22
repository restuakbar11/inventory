
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">No</th>
				<th width="13%">Kode</th>
				<th>Nama Item</th>
				<th width="10%">Satuan</th>
				<th width="15%">Lot Number</th>
				<th width="13%">ED</th>
				<th width="10%">Qty</th>
				<th width="12%">Qty Terpenuhi</th>
				<?php
				if($_POST['act']=='view') { ?>
					<th width="10%">Action</th>
					<?php
				} ?>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			$no=1;
			$user2 =$mysqli->query( "SELECT t.NORETUR,d.NORETUR_DETAIL,i.IDITEM,i.NAMAITEM,s.IDSATUAN,s.NAMASATUAN,d.RETURDETAIL_QTY,
									d.RETURDETAIL_LOTNUMBER,d.RETURDETAIL_ED,RETURDETAIL_QTYTERPENUHI
											FROM RETUR t
											JOIN RETUR_DETAIL d ON d.NORETUR=t.NORETUR AND d.RETURDETAIL_ISACTIVE='Y'
											LEFT JOIN M_ITEM i ON i.IDITEM=d.RETURDETAIL_IDITEM
											LEFT JOIN M_SATUAN s ON s.IDSATUAN=d.RETURDETAIL_IDSATUAN
											WHERE t.NORETUR='$_POST[no_retur]' AND t.RETURISACTIVE='Y' 
											ORDER BY d.NORETUR_DETAIL desc");
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) { ?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['IDITEM'] ?></td>
					<td><?php echo $r['NAMAITEM'] ?></td>
					<td><?php echo $r['NAMASATUAN'] ?></td>
					<td><?php echo $r['RETURDETAIL_LOTNUMBER'] ?></td>
					<td><?php echo $r['RETURDETAIL_ED'] ?></td>
					<td><?php echo $r['RETURDETAIL_QTY'] ?></td>
					<td><?php echo $r['RETURDETAIL_QTYTERPENUHI'] ?></td>
					<?php
					if($_POST['act']=='view') { ?>
						<td><a href="#" class="btn btn-info viewbarcode" data="<?php echo $r['NORETUR_DETAIL']?>" title="Detail Barcode">Detail Barcode</a></td>
						<?php
					} ?>
				</tr>
				<?php
				$no++;
			} ?>
			
		</tbody>
	</table>
	


    <!-- Custom Js -->
    <script src="js/pages/tables/jquery-datatable.js"></script>