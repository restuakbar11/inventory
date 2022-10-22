<?php 
include "../../config/connect.php";
?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
											<th>Kode Kulkas</th>
                                            <th>Gudang</th>
                                            <th>Model</th>
											<th>Type</th>
											<th>IP Kulkas</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
									                              
                                    <tbody>
                                      
									<?php 
										$no=1;
										$sql = "select k.KODE_KULKAS,b.NAMAGUDANG,k.IP_KULKAS,t.NAMA_TYPEKULKAS,t.MODEL_KULKAS from M_KULKAS k
										join M_GUDANG b on b.ID_GUDANG=k.ID_GUDANG and b.GUDANGAKTIF='Y' and b.ISKULKAS='Y'		
										join m_typekulkas t on t.ID_TYPEKULKAS = k.ID_TYPEKULKAS
												where KULKASISACTIVE='Y'";
										$load =$mysqli->query( $sql);
										// oci_execute($load);
										while ($r =mysqli_fetch_array($load)){ 
									?>
										<tr>
											<td><?php echo $no?></td>
											<td><?php echo $r['KODE_KULKAS']?></td>
											<td><?php echo $r['NAMAGUDANG']?></td>
											<td><?php echo $r['MODEL_KULKAS']?></td>
											<td><?php echo $r['NAMA_TYPEKULKAS']?></td>
											<td><?php echo $r['IP_KULKAS']?></td>
											<td><center>
												<a href="#" class="btn btn-info btn-sm editkulkas" data-toggle="modal" data="<?php echo $r['KODE_KULKAS'] ?>" style="color:white; width:35px;" title="Edit"><i class="fa fa-edit"></i></a>
												<a id="hapuskulkas" class="btn btn-danger btn-sm hapuskulkas" data="<?php echo $r['KODE_KULKAS'] ?>" style="color:white; width:35px;" title="Hapus"><i class="fa fa-trash"></i></a>
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
    <!-- Jquery DataTable Plugin Js -->
    <script src="./plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="./plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="./plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="./plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="./plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="./plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="./plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="./plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="./plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
	<script src="./js/admin.js"></script>
    <script src="./js/pages/tables/jquery-datatable.js"></script>
