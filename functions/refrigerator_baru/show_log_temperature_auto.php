<?php 
include '../../config/connect.php';
date_default_timezone_set('Asia/Jakarta');
$tgl =date('Y-m-d');
$now =date('Y-m-d H:i:s');
$rfgr_id = urldecode($_GET['rid']);

//echo $rfgr_id;

?>
											<div class="content col-lg-4">
												<div class="text"><h4>Temperature <br> Monitoring</h4></div>
											</div>
											<?php 
											
											$query2 = "select * from (SELECT TANGGAL,JAM,COLD_ROOM,ALERT_COLD_ROOM
											FROM M_KULKAS k
											join KULKAS_DATA_LOG l ON k.KODE_KULKAS = l.KODE_KULKAS
											WHERE k.KODE_KULKAS = '$rfgr_id' AND TANGGAL='$tgl'                                         
											order by jam desc)
											where rownum <=3";											
											$load2 = $mysqli->query( $query2);
											// oci_execute($load2);

											//echo $query2;
											while($r2 = mysqli_fetch_array($load2)){
											if($r2['ALERT_COLD_ROOM'] == 'H'){
												$cold_room = "<font color='RED'>$r2[COLD_ROOM] &#8451</font>";
											} else if ($r2['ALERT_COLD_ROOM'] == 'L'){
												$cold_room = "<font color='YELLOW'>$r2[COLD_ROOM] &#8451</font>";
											} else {
												$cold_room = $r2['COLD_ROOM'].' &#8451';
											}
											?>
											<div class="content col-lg-3">
												<div class="text"><h4><?php echo $r2['JAM']; ?></h4></div>
												<div class="number count-to" data-from="0" data-to="125" data-speed="1000" data-fresh-interval="20"><?php echo $cold_room; ?></div>
											</div>
											
											<?php } ?>