<?php
include '../../config/connect.php';
date_default_timezone_set('Asia/Jakarta');
$tgl = date('Y-m-d');
$rfgr_id = urldecode($_GET['rid']);

//echo $rfgr_id;

$query = strtoupper("select q.* from (SELECT  L.* 
											FROM M_KULKAS k
											join KULKAS_DATA_LOG l ON k.KODE_KULKAS = l.KODE_KULKAS
											WHERE k.KODE_KULKAS = '$rfgr_id'  AND TANGGAL='$tgl'                                     
											order by jam desc)q
											limit 3");

//echo $query;
$load = $mysqli->query($query);
// oci_execute($load);
$r = mysqli_fetch_array($load);

?>
<div class="icon">
	<i class="material-icons col-red">devices</i>
</div>
<div class="content">
	<div class="text">COLD ROOM</div>
	<div class="number count-to" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20"><?php echo $r['COLD_ROOM'] . ' &#8451'; ?></div>
</div>
<div class="content">
	<div class="text">MIN LIMIT</div>
	<div class="number count-to" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20"><?php echo $r['MIN_TEMP'] . ' &#8451'; ?></div>
</div>
<div class="content">
	<div class="text">MAX LIMIT</div>
	<div class="number count-to" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20"><?php echo $r['MAX_TEMP'] . ' &#8451'; ?></div>
</div>