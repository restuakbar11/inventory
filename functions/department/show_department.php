<?php 
include "../../config/connect.php";
?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-basic-example">
                                    <thead bgcolor="yellow">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Departemen</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
									                              
                                    <tbody>
                                      
									<?php 
										$no=1;
										$sql = "select ID_DEPARTMENT,NAMA_DEPARTMENT from M_DEPARTMENT where DEPARTMENTISACTIVE='Y'
										order by NAMA_DEPARTMENT ASC";
										$load =$mysqli->query( $sql);
										// oci_execute($load);
										while ($r =mysqli_fetch_array($load)){ 
									?>
										<tr>
											<td><?php echo $no?></td>
											<td><?php echo $r['NAMA_DEPARTMENT']?></td>
											<td><center>
												<a href="#" class="btn btn-info btn-sm editdepartment" data-toggle="modal" data="<?php echo $r['ID_DEPARTMENT'] ?>" style="color:white; width:35px;" title="Edit"><i class="fa fa-edit"></i></a>
												<a id="hapusdepartment" class="btn btn-danger btn-sm hapusdepartment" data="<?php echo $r['ID_DEPARTMENT'] ?>" style="color:white; width:35px;" title="Hapus"><i class="fa fa-trash"></i></a>
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
