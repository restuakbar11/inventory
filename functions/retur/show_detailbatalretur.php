<?php 
include "../../config/connect.php";
?>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
                                            
				<th width="2%">No</th>
				<th width="13%">Kode</th>
				<th>Nama Item</th>
				<th width="10%">Satuan</th>
				<th width="15%">Lot Number</th>
				<th width="10%">Qty</th>
				<th width="13%">ED</th>
			</tr>
		</thead>
									  
		<tbody>
                                      
			<?php 
				$no=1;
				$user2 =$mysqli->query( "SELECT t.NORETUR,d.NORETUR_DETAIL,i.IDITEM,i.NAMAITEM,s.IDSATUAN,s.NAMASATUAN,d.RETURDETAIL_QTY,
			d.RETURDETAIL_LOTNUMBER,d.RETURDETAIL_ED
					FROM RETUR t
					JOIN RETUR_DETAIL d ON d.NORETUR=t.NORETUR AND d.RETURDETAIL_ISACTIVE='Y'
					LEFT JOIN M_ITEM i ON i.IDITEM=d.RETURDETAIL_IDITEM
					LEFT JOIN M_SATUAN s ON s.IDSATUAN=d.RETURDETAIL_IDSATUAN
					WHERE t.NORETUR='$_GET[noretur]' AND t.RETURISACTIVE='Y' 
					ORDER BY d.NORETUR_DETAIL desc");
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) { ?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['IDITEM'] ?></td>
					<td><?php echo $r['NAMAITEM'] ?></td>
					<td><?php echo $r['NAMASATUAN'] ?></td>
					<td><?php echo $r['RETURDETAIL_LOTNUMBER'] ?></td>
					<td><?php echo $r['RETURDETAIL_QTY'] ?></td>
					<td><?php echo $r['RETURDETAIL_ED'] ?></td>
				</tr>
				<?php 
				$no++;
			}
		  ?>
		</tbody>
	</table>
</div>
<!-- Custom Js -->
    <script src="js/pages/tables/jquery-datatable.js"></script>