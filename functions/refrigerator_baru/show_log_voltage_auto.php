<?php 
include '../../config/connect.php';
date_default_timezone_set('Asia/Jakarta');
$tgl =date('Y-m-d');
$now =date('Y-m-d H:i:s');
$rfgr_id = urldecode($_GET['rid']);

//echo $rfgr_id;

?>

<div class="content col-lg-4">
												<div class="text"><h4>Voltage <br> Monitoring</h4></div>
											</div>
											<?php 
											$query3 = "select * from (SELECT TANGGAL,JAM,VOLTAGE
											FROM M_KULKAS k
											join KULKAS_DATA_LOG l ON k.KODE_KULKAS = l.KODE_KULKAS
											WHERE k.KODE_KULKAS = '$rfgr_id'  AND TANGGAL='$tgl'                                         
											order by jam desc)
											where rownum <=3";											
											$load3 = $mysqli->query( $query3);
											// oci_execute($load3);
											while($r3 = mysqli_fetch_array($load3)){
											
											?>
											<div class="content col-lg-3">
												<div class="text"><h4><?php echo $r3['JAM']; ?></h4></div>
												<div class="number count-to" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20"><?php echo $r3['VOLTAGE'].' V'; ?></div>
											</div>
											<?php } ?>