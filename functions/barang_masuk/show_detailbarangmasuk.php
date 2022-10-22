<?php 
include "../../config/connect.php";
$nosj = urldecode($_GET['nosj']);
if(isset($_GET['page'])){
	$page = urldecode($_GET['page']);
}
if(isset($_GET['aksi'])){
	$aksi = urldecode($_GET['aksi']);
}
?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead bgcolor="yellow">
                                        <tr>
                                            <th width="2%">No</th>
											<th>Item</th>
											<th>Qty</th>
                                            <th>Lot Number</th>
                                            <th>Expired Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
									                              
                                    <tbody>
                                      
									<?php 
										$no=1;
										$sql = "SELECT d.NOBARANGMASUK,d.NOBARANGMASUK_DETAIL,BARANGMASUKDETAILM_ITEMID,BARANGMASUKDETAILQTY,BARANGMASUKDETAILM_ITEMSTOCKLOTNUMBER,
										BARANGMASUKDETAIL_ED,d.USERID,i.NAMAITEM
										FROM BARANG_MASUK_DETAIL d 
												join M_SATUAN s on s.IDSATUAN = d.BARANGMASUKDETAILM_SATUANID
												join M_ITEM i ON i.IDITEM=BARANGMASUKDETAILM_ITEMID
												WHERE d.BARANGMASUKDETAILISACTIVE = 'Y' AND d.NOBARANGMASUK = '$nosj'";
										$load =$mysqli->query( $sql);
										// oci_execute($load);
										while ($r =mysqli_fetch_array($load)){ 
									?>
										<tr>
											<td><?php echo $no?></td>
											<td><?php echo $r['NAMAITEM']?></td>
											<td><?php echo $r['BARANGMASUKDETAILQTY']?></td>
											<td><?php echo $r['BARANGMASUKDETAILM_ITEMSTOCKLOTNUMBER']?></td>
											<td><?php echo $r['BARANGMASUKDETAIL_ED']?></td>
											<td><center>
												<?php 
												if(isset($_GET['page']) && $page=='ctk_barcode') { 
													if(isset($_GET['aksi']) && $aksi=='view') { ?>
														<a class="btn btn-warning btn-sm viewstatus" data="<?php echo $r['NOBARANGMASUK'] ?>&<?php echo $r['BARANGMASUKDETAILM_ITEMID'] ?>&<?php echo $r['NOBARANGMASUK_DETAIL'] ?>" title="view detail"><i class="material-icons">visibility</i> <span class="icon-name"></span></a>
														<a class="btn btn-sm cetak_barcode_all" data="<?php echo $r['NOBARANGMASUK_DETAIL'] ?>" title="cetak semua"><i class="material-icons">print</i> <span class="icon-name"></span></a>
														<?php
													} else { ?>
														<a id="generate" class="btn bg-green waves-effect generate" data="<?php echo $r['NOBARANGMASUK'] ?>&<?php echo $r['BARANGMASUKDETAILM_ITEMID'] ?>&<?php echo $r['NOBARANGMASUK_DETAIL'] ?>" title="Generate Barcode"><i class="material-icons">nfc</i> <span class="icon-name"></span></a>
														<?php
													}
												} else if(isset($_GET['page']) && $page=='batal_masuk') {

												} else { ?>
													<a id="hapusbarangmasukdetail" class="btn btn-danger btn-sm hapusbarangmasukdetail" data="<?php echo $r['NOBARANGMASUK_DETAIL'] ?>&<?php echo $r['USERID'] ?>" style="color:white; width:35px;" title="Hapus"><i class="fa fa-trash"></i></a>
													<?php
												} ?>
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