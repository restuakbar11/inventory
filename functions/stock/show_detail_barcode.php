
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">No</th>
				<th width="15%">Kode Barcode</th>
				<th width="10%">Nama Gudang</th>
				<th width="10%">Nama Rak Gudang</th>
				<th width="15%">Department</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			session_start();
			$item			=$_POST['item'];
			$satuan			=$_POST['satuan'];
			$lot_number		=$_POST['lot_number'];
			$ed				=$_POST['ed'];
			$department		=$_POST['department'];
			$no=1;
			$sql =$mysqli->query( "SELECT KODEBARCODE,NAMAGUDANG,NAMARAKGUDANG,NAMA_DEPARTMENT
									FROM M_ITEMBARCODE b
									LEFT JOIN M_RAKGUDANG r ON r.ID_RAKGUDANG=b.IDRAKGUDANG AND RAKGUDANGAKTIF='Y'
									LEFT JOIN M_GUDANG g ON g.ID_GUDANG=b.IDGUDANG AND GUDANGAKTIF='Y'
									JOIN M_DEPARTMENT d ON d.ID_DEPARTMENT=b.M_DEPARTMENTDEPARTMENTID AND DEPARTMENTISACTIVE='Y'
									WHERE M_ITEMIDITEM='$item' AND M_SATUANIDSATUAN='$satuan' AND LOT_NUMBER='$lot_number' AND ED='$ed' AND M_DEPARTMENTDEPARTMENTID='$department'
										AND BARCODEISACTIVE='Y'
									ORDER BY KODEBARCODE ");
			
			// oci_execute($sql);
			while ($r =mysqli_fetch_array($sql)) { 
				?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['KODEBARCODE'] ?></td>
					<td><?php echo $r['NAMAGUDANG'] ?></td>
					<td><?php echo $r['NAMARAKGUDANG'] ?> </td>
					<td><?php echo $r['NAMA_DEPARTMENT'] ?></td>
				</tr>
				<?php
				$no++;
			} ?>
			
		</tbody>
	</table>


    <!-- Custom Js -->
    <script src="js/pages/tables/jquery-datatable.js"></script>