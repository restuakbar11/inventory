
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">No</th>
				<th width="15%">Department</th>
				<th width="10%">Kode</th>
				<th>Nama Item</th>
				<th width="10%">Satuan</th>
				<th width="13%">Lot Number</th>
				<th width="10%">ED</th>
				<th width="10%">Stock</th>
				<th width="10%">Action</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			session_start();
			$item	=$_POST['item'];
			$satuan	=$_POST['satuan'];
			$department	=$_SESSION['id_department'];
			$no=1;
			
				$user2 =$mysqli->query( "SELECT IDITEM,NAMAITEM,IDSATUAN,NAMASATUAN,ITEMSTOCK_LOTNUMBER,ITEMSTOCK_ED,ID_DEPARTMENT,NAMA_DEPARTMENT,SUM(ITEMSTOCK_STOCK) AS STOCK
										FROM ITEMSTOCK s
                                        JOIN M_DEPARTMENT d ON d.ID_DEPARTMENT=s.ITEMSTOCK_IDDEPARTMENT
										JOIN M_ITEM i ON i.IDITEM=s.ITEMSTOCK_IDITEM AND ITEM_ISACTIVE='Y'
										JOIN M_SATUAN u ON u.IDSATUAN=s.ITEMSTOCK_IDSATUAN
										WHERE IDITEM='$item' AND IDSATUAN='$satuan' AND ITEMSTOCK_STOCK>0 AND ITEMSTOCK_IDDEPARTMENT='$department'
										GROUP BY IDITEM,NAMAITEM,IDSATUAN,NAMASATUAN,ITEMSTOCK_LOTNUMBER,ITEMSTOCK_ED,ID_DEPARTMENT,NAMA_DEPARTMENT
										ORDER BY NAMAITEM ");
			
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) { 
				?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['NAMA_DEPARTMENT'] ?></td>
					<td><?php echo $r['IDITEM'] ?></td>
					<td><?php echo $r['NAMAITEM'] ?> </td>
					<td><?php echo $r['NAMASATUAN'] ?></td>
					<td><?php echo $r['ITEMSTOCK_LOTNUMBER'] ?></td>
					<td><?php echo $r['ITEMSTOCK_ED'] ?></td>
					<td><center><?php echo $r['STOCK'] ?></center></td>
					<td><center>
						<a href="?page=stock_per_dept&act=detailbarcode&item=<?php echo $r['IDITEM']?>&sat=<?php echo $r['IDSATUAN']?>&lot=<?php echo $r['ITEMSTOCK_LOTNUMBER']?>&ed=<?php echo $r['ITEMSTOCK_ED']?>" class="btn btn-info">Barcode <i class="fa fa-eye"></i></a>
						</center>
					</td>
				</tr>
				<?php
				$no++;
			} ?>
			
		</tbody>
	</table>


    <!-- Custom Js -->
    <script src="js/pages/tables/jquery-datatable.js"></script>