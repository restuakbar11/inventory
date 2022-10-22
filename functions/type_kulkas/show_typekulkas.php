<?php 
include "../../config/connect.php";
?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead bgcolor="yellow">
                                        <tr>
                                            <th>No</th>
                                            <th>Type</th>
                                            <th>Model</th>
											<th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
									                              
                                    <tbody>
                                      
									<?php 
										$no=1;
										$sql = "select ID_TYPEKULKAS,NAMA_TYPEKULKAS,IMAGE_URL,MODEL_KULKAS from M_TYPEKULKAS where TYPEKULKASISACTIVE='Y'
										order by NAMA_TYPEKULKAS ASC";
										$load =$mysqli->query( $sql);
										// oci_execute($load);
										while ($r =mysqli_fetch_array($load)){ 
									?>
										<tr>
											<td><?php echo $no?></td>
											<td><b><?php echo $r['NAMA_TYPEKULKAS']?></b></td>
											<td><?php echo $r['MODEL_KULKAS']?></td>
											<td><img src="<?php echo $r['IMAGE_URL']?>" width="60px"></td>
											<td><center>
												<a href="#" class="btn btn-info btn-sm edittypekulkas" data-toggle="modal" data="<?php echo $r['ID_TYPEKULKAS'] ?>" style="color:white; width:35px;" title="Edit"><i class="fa fa-edit"></i></a>
												<a id="hapustypekulkas" class="btn btn-danger btn-sm hapustypekulkas" data="<?php echo $r['ID_TYPEKULKAS'] ?>" style="color:white; width:35px;" title="Hapus"><i class="fa fa-trash"></i></a>
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
<!-- JQuery DataTable Css -->
<script src="./js/pages/tables/jquery-datatable.js"></script>
