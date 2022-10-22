<?php 
include "../../config/connect.php";
?>

<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
<thead>
                                        <tr>
                                            <th style="width:5%;">No</th>
                                            <th>Nama Gudang</th>
                                            <th>Nama Departemen</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
									                              
                                    <tbody>
                                      
									<?php 
										$no=1;
										$sql = "select b.ID_DEPARTMENT,b.NAMA_DEPARTMENT,a.NAMAGUDANG,a.ID_GUDANG from M_GUDANG a
										join M_DEPARTMENT b on a.ID_DEPARTMENT=b.ID_DEPARTMENT and b.DEPARTMENTISACTIVE='Y'
										where a.GUDANGAKTIF='Y'
										order by a.NAMAGUDANG ASC";
										$load =$mysqli->query( $sql);
										// oci_execute($load);
										while ($r =mysqli_fetch_array($load)){ 
									?>
										<tr>
											<td><?php echo $no?></td>
											<td><?php echo $r['NAMAGUDANG']?></td>
											<td><?php echo $r['NAMA_DEPARTMENT']?></td>
											<td><center>
												<a href="#" class="btn btn-info btn-sm editgudang" data-toggle="modal" data="<?php echo $r['ID_GUDANG'] ?>" style="color:white; width:35px;" title="Edit"><i class="fa fa-edit"></i></a>
												<a id="hapusgudang" class="btn btn-danger btn-sm hapusgudang" data="<?php echo $r['ID_GUDANG'] ?>" style="color:white; width:35px;" title="Hapus"><i class="fa fa-trash"></i></a>
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
