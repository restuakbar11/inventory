<?php 
include "../../config/connect.php";
?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead style="background-color:yellow;">
                                        <tr>
                                            <th width="2%">No</th>
											<th>Kode Rak</th>
                                            <th>Nama Rak</th>
                                            <th>Jenis Rak</th>
                                            <th>Nama Kulkas</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
									                              
                                    <tbody>
                                      
									<?php 
										$no=1;
										$sql = "SELECT * FROM M_RAKKULKAS r 
													LEFT JOIN M_KULKAS k ON k.KODE_KULKAS=r.M_RAKKODEKULKAS
													WHERE RAKKULKASISACTIVE='Y' 
													ORDER BY KODE_KULKAS,NAMA_RAKKULKAS";
										$load =$mysqli->query( $sql);
										// oci_execute($load);
										while ($r =mysqli_fetch_array($load)){ 
									?>
										<tr>
											<td><?php echo $no?></td>
											<td><?php echo $r['KODE_RAKKULKAS']?></td>
											<td><?php echo $r['NAMA_RAKKULKAS']?></td>
											<td><?php echo $r['JENIS_RAKKULKAS']?></td>
											<td><?php echo $r['NAMA_KULKAS']?></td>
											<td><center>
												<a href="#" class="btn btn-info btn-sm editrakkulkas" data-toggle="modal" data="<?php echo $r['KODE_RAKKULKAS'] ?>" style="color:white; width:35px;" title="Edit"><i class="fa fa-edit"></i></a>
												<a id="hapusrakkulkas" class="btn btn-danger btn-sm hapusrakkulkas" data="<?php echo $r['KODE_RAKKULKAS'] ?>" style="color:white; width:35px;" title="Hapus"><i class="fa fa-trash"></i></a>
												</center>
											</td>
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