<?php 
include "../../config/connect.php";
?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-basic-example">
                                    <thead bgcolor="yellow">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Gedung</th>
                                            <th>Jumlah Lantai</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
									                              
                                    <tbody>
                                      
									<?php 
										$no=1;
										$sql = "select ID_GEDUNG,NAMA_GEDUNG,JUMLAH_LANTAI from m_gedung where gedungisactive='Y'
										order by NAMA_GEDUNG ASC";
										$load =$mysqli->query( $sql);
										// oci_execute($load);
										while ($r =mysqli_fetch_array($load)){ 
									?>
										<tr>
											<td><?php echo $no?></td>
											<td><?php echo $r['NAMA_GEDUNG']?></td>
											<td><?php echo $r['JUMLAH_LANTAI']?></td>
											<td><center>
												<a href="#" class="btn btn-info btn-sm editgedung" data-toggle="modal" data="<?php echo $r['ID_GEDUNG'] ?>" style="color:white; width:35px;" title="Edit"><i class="fa fa-edit"></i></a>
												<a id="hapusgedung" class="btn btn-danger hapusgedung" data="<?php echo $r['ID_GEDUNG'] ?>" style="color:white; width:35px;" title="Hapus"><i class="fa fa-trash"></i></a>
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
