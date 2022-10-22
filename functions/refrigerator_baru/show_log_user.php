<?php 
include "../../config/connect.php";
$refgr_id = urldecode($_GET['rid']);
//$date = urldecode($_GET['date']);
//echo $date;
?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Jam</th>
                                            <th>User</th>
											<th>Timer (Seconds)</th>
                                        </tr>
                                    </thead>
									                              
                                    <tbody>
                                      
									<?php 
										$no=1;
										$sql = "Select * from KULKAS_USER_LOG where KODE_KULKAS='$refgr_id'
										order by ROWID_KULKAS DESC";
										//echo $sql;
										$load =$mysqli->query( $sql);
										// oci_execute($load);
										while ($r =mysqli_fetch_array($load)){ 
									?>
										<tr>
											<td><?php echo $no?></td>
											<td><?php echo $r['TANGGAL']?></td>
											<td><?php echo $r['JAM']?></td>
											<td><?php echo $r['USERID']; ?></td>
											<td><?php echo $r['DETIK']?></td>
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
