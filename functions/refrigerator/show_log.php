<?php
include "../../config/connect.php";
$refgr_id = urldecode($_GET['rid']);
$date = urldecode($_GET['date']);
//echo $date;
?>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead>
			<tr>
				<th>No</th>
				<th>Tanggal</th>
				<th>Jam</th>
				<th>Temperatur (&#8451)</th>
				<th>Flag</th>
				<th>Voltage (V)</th>
				<th>Power (VA)</th>
			</tr>
		</thead>

		<tbody>

			<?php
			$no = 1;
			$sql = strtoupper("Select * from KULKAS_DATA_LOG where KODE_KULKAS='$refgr_id' AND TANGGAL='$date'
										order by JAM desc");
			//echo $sql;
			$load = $mysqli->query($sql);
			// oci_execute($load);
			while ($r = mysqli_fetch_array($load)) {
			?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['TANGGAL'] ?></td>
					<td><?php echo $r['JAM'] ?></td>
					<td><?php echo $r['COLD_ROOM']; ?></td>
					<td><?php
						if ($r['ALERT_COLD_ROOM'] == 'H') {
							echo '<i class="material-icons">arrow_upward</i>';
						} else if ($r['ALERT_COLD_ROOM'] == 'L') {
							echo '<i class="material-icons">arrow_downward</i>';
						} else {
						}
						?>

					</td>
					<td><?php echo $r['VOLTAGE'] ?></td>
					<td><?php echo $r['POWER'] ?></td>
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