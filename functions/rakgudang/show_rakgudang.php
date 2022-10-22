<?php 
include "../../config/connect.php";
?>

<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
<thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Departemen</th>
                                            <th>Nama Gudang</th>
                                            <th>Nama RAK</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
									                              
                                    <tbody>
                                      
									<?php 
										$no=1;
										$sql = "select ID_RAKGUDANG,NAMARAKGUDANG,NAMA_DEPARTMENT,NAMAGUDANG 
										from M_RAKGUDANG a
										JOIN M_GUDANG b on a.ID_GUDANG=b.ID_GUDANG and b.GUDANGAKTIF='Y'
										join M_DEPARTMENT c on c.ID_DEPARTMENT=b.ID_DEPARTMENT and c.DEPARTMENTISACTIVE='Y'
										where a.RAKGUDANGAKTIF='Y'
										order by a.NAMARAKGUDANG ASC";
										$load =$mysqli->query( $sql);
										// oci_execute($load);
										while ($r =mysqli_fetch_array($load)){ 
									?>
										<tr>
											<td><?php echo $no?></td>
											<td><?php echo $r['NAMA_DEPARTMENT']?></td>
											<td><?php echo $r['NAMAGUDANG']?></td>
											<td><?php echo $r['NAMARAKGUDANG']?></td>
											<td><center>
												<a href="#" class="btn btn-info btn-sm editrakgudang" data-toggle="modal" data="<?php echo $r['ID_RAKGUDANG'] ?>" style="color:white; width:35px;" title="Edit"><i class="fa fa-edit"></i></a>
												<a id="hapusrakgudang" class="btn btn-danger btn-sm hapusrakgudang" data="<?php echo $r['ID_RAKGUDANG'] ?>" style="color:white; width:35px;" title="Hapus"><i class="fa fa-trash"></i></a>
												</center>
											</td>
										</tr>
									  <?php 
										$no++;
										}
									  ?>
                                    </tbody>
                                </table>
    <!-- Custom Js -->
    <script src="js/pages/tables/jquery-datatable.js"></script>
