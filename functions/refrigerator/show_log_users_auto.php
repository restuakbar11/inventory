<?php
include '../../config/connect.php';
date_default_timezone_set('Asia/Jakarta');
$tgl = date('Y-m-d');
$rfgr_id = urldecode($_GET['rid']);

//echo $rfgr_id;

$query2 = strtoupper("Select q.* from (select KODE_KULKAS,USERID,TANGGAL,JAM,DETIK,rowid_kulkas from kulkas_user_log 
where kode_kulkas='$rfgr_id'
order by ROWID_KULKAS DESC)q limit 1");

// echo $query2;

/*Last user log open door */
$load2 = $mysqli->query($query2);
// oci_execute($load2);
$r2 = mysqli_fetch_array($load2);
?>

<div class="icon">
	<i class="material-icons col-purple">bookmark</i>
</div>
<div class="content">
	<div class="text">LAST OPEN DOOR</div>
	<div class="number count-to" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20"><?php echo $r2['TANGGAL'] . '-' . $r2['JAM']; ?></div>
</div>
<div class="content">
	<div class="text">OPEN BY</div>
	<div class="number count-to" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20"><?php echo $r2['USERID']; ?></div>
</div>
<div class="content">
	<div class="text">TIMER</div>
	<div class="number count-to" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20"><?php echo $r2['DETIK'] . ' s'; ?></div>
</div>