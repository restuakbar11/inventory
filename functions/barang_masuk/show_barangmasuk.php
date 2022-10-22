<?php 
include "../../config/connect.php";
$tgl =date('Y-m-d');
$tgl_sekarang = date_create($tgl);		
$now = date_format($tgl_sekarang,'Y-m-d');

?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable" border="1">
                                    <thead bgcolor="yellow">
                                        <tr>
                                            <th width="2%">No</th>
											<th>Nomor SJ</th>
											<th>Nama Supplier</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Note</th>
                                            <th>Ket Batal</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
									                              
                                    <tbody>
                                      
									<?php 
										$no=1;
										$startdate	=$_POST['startdate'];
										$finishdate	=$_POST['finishdate'];
										/*$sql = "SELECT * FROM BARANG_MASUK bm
										LEFT JOIN M_SUPPLIER s ON s.IDSUPPLIER = bm.BARANGMASUKM_SUPPLIERID
										WHERE BARANGMASUKISACTIVE = 'Y'
										";*/
										$sql ="SELECT bm.NOBARANGMASUK,BARANGMASUKTANGGAL as TGL_MASUK,NAMASUPPLIER,BARANGMASUKTANGGAL,BARANGMASUKNOTE,
												COUNT(bd.NOBARANGMASUK_DETAIL) AS JML,g.TOTAL,KETERANGAN,FLAGBATAL,IDSUPPLIER
												FROM BARANG_MASUK bm
												LEFT JOIN BARANG_MASUK_DETAIL bd ON bd.NOBARANGMASUK=bm.NOBARANGMASUK AND BARANGMASUKDETAILISACTIVE='Y'
												LEFT JOIN
												(SELECT m.NOBARANGMASUK,COUNT(z.NOBARANGMASUK_DETAIL) AS TOTAL
													FROM BARANG_MASUK m
													JOIN
														(
														SELECT NOBARANGMASUK,NOBARANGMASUK_DETAIL
														FROM BARANG_MASUK_DETAIL d 
														JOIN M_ITEMBARCODE b ON b.BARANGMASUKDETAILIDMASUK=d.NOBARANGMASUK_DETAIL
														WHERE BARANGMASUKDETAILISACTIVE='Y'
														GROUP BY NOBARANGMASUK_DETAIL,NOBARANGMASUK
														)z ON z.NOBARANGMASUK=m.NOBARANGMASUK
													GROUP BY m.NOBARANGMASUK
												) g ON g.NOBARANGMASUK=bm.NOBARANGMASUK
												LEFT JOIN M_SUPPLIER s ON s.IDSUPPLIER = bm.BARANGMASUKM_SUPPLIERID
												WHERE BARANGMASUKISACTIVE = 'Y' AND BARANGMASUKTANGGAL BETWEEN '$startdate' AND '$finishdate'
												GROUP BY bm.NOBARANGMASUK,IDSUPPLIER ,NAMASUPPLIER,BARANGMASUKTANGGAL,BARANGMASUKNOTE,g.TOTAL,KETERANGAN,FLAGBATAL
												ORDER BY BARANGMASUKTANGGAL DESC
												";
										$load =$mysqli->query( $sql);
										// oci_execute($load);
										while ($r =mysqli_fetch_array($load)){ 
											$d1 = strtotime($r['TGL_MASUK']);
											$d2 = strtotime(date('Y-m-d'));
											
											$selisih =$d2-$d1;
											if ($r['FLAGBATAL']=='N' AND ($selisih == 0 || $selisih == 1)) {
												$nosj = '<a href="#" class="batal_masuk" data="'.$r['NOBARANGMASUK'].'" ><font color=blue>'.$r['NOBARANGMASUK'].'</font></a>';
											}else{
												$nosj = $r['NOBARANGMASUK'];
											}
									?>
										<tr>
											<td><?php echo $no; ?></td>
											<td><?php echo $nosj; ?></td>
											<td><?php echo $r['NAMASUPPLIER']?></td>
											<td><?php echo $r['BARANGMASUKTANGGAL'] ?></td>
											<td><?php echo $r['BARANGMASUKNOTE']?></td>
											<td><?php echo $r['KETERANGAN']?></td>
											<td><?php
												if($r['FLAGBATAL']=='N') { ?>
													<center>
													<?php 
													if($r['JML']==$r['TOTAL']) { ?>
														<!--<a id="cetak" class="btn btn-default btn-sm cetak" data="<?php echo $r['NOBARANGMASUK'] ?>" title="Cetak"><i class="material-icons">print</i> <span class="icon-name"></span></a>-->
														<a class="btn btn-warning btn-sm view" data="<?php echo $r['NOBARANGMASUK'] ?>"><i class="material-icons">visibility</i> <span class="icon-name"></span></a>
														<!--<a id="viewdetail" class="btn btn-success btn-sm viewdetail" data="<?php echo $r['NOBARANGMASUK'] ?>" title="Generate Barcode"><i class="material-icons">nfc</i> <span class="icon-name">Barcode</span></a>-->
														<?php
													} else if($r['TOTAL']>0 AND $r['TOTAL']<$r['JML']) { ?>
														<a id="viewdetail" class="btn btn-success btn-sm viewdetail" data="<?php echo $r['NOBARANGMASUK'] ?>" title="Generate Barcode"><i class="material-icons">nfc</i> <span class="icon-name">Barcode</span></a>
														<?php
													} else if($r['TOTAL']==0) {?>
														<a id="inputitem" class="btn btn-info btn-sm inputitem" data-toggle="modal" data="<?php echo $r['NOBARANGMASUK'] ?>&<?php echo $r['IDSUPPLIER'] ?>" style="color:white;" title="Edit"><i class="material-icons">edit</i> <span class="icon-name">Edit</span></a>
														<a id="viewdetail" class="btn btn-success btn-sm viewdetail" data="<?php echo $r['NOBARANGMASUK'] ?>" title="Generate Barcode"><i class="material-icons">nfc</i> <span class="icon-name">Barcode</span></a>
														<a id="hapusbrgmasuk" class="btn btn-danger btn-sm hapusbrgmasuk" data="<?php echo $r['NOBARANGMASUK'] ?>" style="color:white; width:35px;" title="Hapus"><i class="fa fa-trash"></i></a>
														<?php
													} ?>
													</center>
													<?php
												} else { ?>
													<center>
														<span class="label label-danger">Batal</span>
													</center>
													<?php
												} ?>
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