<?php 
include "../../config/connect.php";
?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            
				<th width="2%">No</th>
				<th width="13%">Kode</th>
				<th>Nama Item</th>
				<th width="10%">Satuan</th>
				<th width="15%">Lot Number</th>
				<th width="10%">Qty</th>
				<th width="13%">ED</th>
                                        </tr>
                                    </thead>
									                              
                                    <tbody>
                                      
									<?php 
										$no=1;
										$user2 =$mysqli->query( "SELECT t.NOTAG,d.NOTAG_DETAIL,i.IDITEM,i.NAMAITEM,s.IDSATUAN,s.NAMASATUAN,d.TAGDETAILQTY,
									d.TAGDETAILM_ITEMSTOCKLOTNUMBER,d.TAGDETAILED
											FROM TAG t
											JOIN TAG_DETAIL d ON d.NOTAG=t.NOTAG AND d.TAGDETAILISACTIVE='Y'
											LEFT JOIN M_ITEM i ON i.IDITEM=d.TAGDETAILM_ITEMID
											LEFT JOIN M_SATUAN s ON s.IDSATUAN=d.TAGDETAILM_SATUANID
											WHERE t.NOTAG='$_GET[notag]' AND t.TAGISACTIVE='Y' 
											ORDER BY d.NOTAG_DETAIL desc");
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) { ?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['IDITEM'] ?></td>
					<td><?php echo $r['NAMAITEM'] ?></td>
					<td><?php echo $r['NAMASATUAN'] ?></td>
					<td><?php echo $r['TAGDETAILM_ITEMSTOCKLOTNUMBER'] ?></td>
					<td><?php echo $r['TAGDETAILQTY'] ?></td>
					<td><?php echo $r['TAGDETAILED'] ?></td>
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