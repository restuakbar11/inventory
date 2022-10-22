<?php 
include "../../config/connect.php";
?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-basic-example">
                                    <thead bgcolor="yellow">
                                        <tr>
                                            <th width="2%">No</th>
                                            <th>Nama Ruangan</th>
                                            <th>Gedung</th>
											<th>Lantai</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
									                              
                                    <tbody>
                                      
									<?php 
										$no=1;
										$load =$mysqli->query( strtoupper("select id_ruangan,nama_ruangan,lantai,nama_gedung from m_ruangan r
												left join m_gedung g on g.id_gedung = r.id_gedung
												where r.ruanganisactive='Y'
												order by nama_ruangan asc"));
										//$load =$mysqli->query( $sql);
										// oci_execute($load);
										while ($r =mysqli_fetch_array($load)){ 
									?>
										<tr>
											<td><?php echo $no?></td>
											<td><?php echo $r['NAMA_RUANGAN']?></td>
											<td><?php echo $r['NAMA_GEDUNG']?></td>
											<td><center><?php echo $r['LANTAI']?></center></td>
											<td><center>
												<a href="#" class="btn btn-info btn-sm editruangan" data-toggle="modal" data="<?php echo $r['ID_RUANGAN'] ?>" style="color:white; width:35px;" title="Edit"><i class="fa fa-edit"></i></a>
												<a id="hapusruangan" class="btn btn-danger btn-sm hapusruangan" data="<?php echo $r['ID_RUANGAN'] ?>" style="color:white; width:35px;" title="Hapus"><i class="fa fa-trash"></i></a>
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
