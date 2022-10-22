<?php 
include '../../config/connect.php';
date_default_timezone_set('Asia/Jakarta');
$tgl =date('Y-m-d');
$now =date('Y-m-d H:i:s');
$rfgr_id = urldecode($_GET['rid']);

//echo $rfgr_id;

?>

<div class="content col-lg-4">
												<div class="text"><h4>Power <br> Monitoring</h4></div>
											</div>
											<?php 
											$query4 = "select * from (SELECT TANGGAL,JAM,POWER
											FROM M_KULKAS k
											join KULKAS_DATA_LOG l ON k.KODE_KULKAS = l.KODE_KULKAS
											WHERE k.KODE_KULKAS = '$rfgr_id'  AND TANGGAL='$tgl'                                     
											order by jam desc)
											where rownum <=3";											
											$load4 = $mysqli->query( $query4);
											// oci_execute($load4);
											while($r4 = mysqli_fetch_array($load4)){
											
											?>
											<div class="content col-lg-3">
												<div class="text"><h4><?php echo $r4['JAM']; ?></h4></div>
												<div class="number count-to" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20"><?php echo $r4['POWER'].' VA'; ?></div>
											</div>
											<?php } ?>