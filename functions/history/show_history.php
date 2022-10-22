
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">No</th>
				<th width="15%">Kode</th>
				<th>Nama Item</th>
				<th width="15%">Satuan</th>
				<th width="10%">Action</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			session_start();
			
			$no=1;
			$user2 =$mysqli->query( "SELECT IDITEM,NAMAITEM,IDSATUAN,NAMASATUAN
										FROM ITEMSTOCK_HISTORY h
										JOIN ITEMSTOCK s ON s.IDITEMSTOCK=h.IDITEMSTOCK
										JOIN M_ITEM i ON i.IDITEM=s.ITEMSTOCK_IDITEM AND ITEM_ISACTIVE='Y'
										JOIN M_SATUAN u ON u.IDSATUAN=s.ITEMSTOCK_IDSATUAN AND SATUANISACTIVE='Y'
										GROUP BY IDITEM,NAMAITEM,IDSATUAN,NAMASATUAN
										ORDER BY NAMAITEM ");
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) { 
				?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['IDITEM'] ?></td>
					<td><?php echo $r['NAMAITEM'] ?> </td>
					<td><?php echo $r['NAMASATUAN'] ?></td>
					<td>
						<center>
						<a href="?page=history&act=detailhistory&item=<?php echo $r['IDITEM']?>&sat=<?php echo $r['IDSATUAN']?>" class="btn btn-info">Detail <i class="fa fa-eye"></i></a>
							
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