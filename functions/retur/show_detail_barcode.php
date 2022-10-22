
	<table class="table table-bordered table-striped table-hover ">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">No</th>
				<th width="13%">Kode Barcode</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			$no=1;
			$user2 =$mysqli->query( "SELECT * FROM RETUR_DETAIL_BARCODE WHERE NORETUR_DETAIL='$_POST[noretur_detail]' ORDER BY KODEBARCODE ASC");
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) { ?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['KODEBARCODE'] ?></td>
				</tr>
				<?php
				$no++;
			} ?>
			
		</tbody>
	</table>
	
