<?php
include "config/connect.php";
?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<?php 
						$load = $mysqli->query("select * from M_GEDUNG WHERE GEDUNGISACTIVE='Y'");
						// oci_execute($load);
						while ($r =mysqli_fetch_array($load)){ 
					?>
					<div class="col-lg-6 col-md-3 col-sm-3 col-xs-3">
                    <div class="card">
					
                        <div class="header">
                            <h2>
                                <?php echo $r['NAMA_GEDUNG']; ?>
                            </h2>                            
                        </div>
						<?php 
						$jml_lantai=$r['JUMLAH_LANTAI']; 
						for ($i=$jml_lantai;$i>=1;$i--){
						?>
						<div class="panel-group" id="accordion_2" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-amber">
                                <div class="panel-heading" role="tab" id="headingOne_<?php echo $r['ID_GEDUNG'].$i; ?>">
                                    <h4 class="panel-title">
                                        <a role="button" class="waves-effect" data-toggle="collapse" data-parent="#accordion_<?php echo $r['ID_GEDUNG'].$i; ?>" href="#collapseOne_<?php echo $r['ID_GEDUNG'].$i; ?>" aria-expanded="true" aria-controls="collapseOne_2">
                                            <button class="btn bg-blue btn-block btn-lg waves-effect "><h4><?php echo 'Lantai '.$i; ?></h4></button>
                                        </a>
                                    </h4>
                                </div>
								
                                <div id="collapseOne_<?php echo $r['ID_GEDUNG'].$i; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_<?php echo $i; ?>">
                                    <div class="panel-body">
									<?php 
									$data=$mysqli->query("select k.kode_kulkas, gu.NAMAGUDANG, t.nama_typekulkas, t.image_url, k.ip_kulkas,s.nama_subdepartment, d.nama_department,r.nama_ruangan,r.lantai, g.nama_gedung 
														from m_kulkas k
														join m_gudang gu on gu.ID_GUDANG=k.ID_GUDANG
														join m_typekulkas t on t.id_typekulkas = k.id_typekulkas
														join m_subdepartmentkulkas sk on sk.kode_kulkas=k.kode_kulkas
														join m_subdepartment s on s.id_subdepartment = sk.id_subdepartment and sk.subdepartmentkulkasisactive = 'Y'
														join m_department d on d.id_department = s.id_department
														join m_ruangan r on r.id_ruangan=s.id_ruangan
														join m_gedung g on g.id_gedung = r.id_gedung 
														WHERE g.id_gedung = $r[ID_GEDUNG]
														and r.lantai = $i
														Order by k.NAMA_KULKAS ASC");
									// oci_execute($data);
									while ($t =mysqli_fetch_array($data)){ 
									?>
                                        <div class="col-lg-4 col-md-2 col-sm-6 col-xs-6">
                                            <p align="center">
                                                <b><?php echo $t['NAMA_RUANGAN'] ?></b>
                                            </p>
                                            <a href="index.php?page=ref_detail&rid=<?php echo $t['KODE_KULKAS']; ?>" type="button" class="btn btn-secondary btn-block waves-effect" role="button" data-toggle="tooltip" data-placement="bottom" title="<?php echo $t['TYPE_KULKAS']; ?>"><img src="<?php echo $t['IMAGE_URL']; ?>" width="80px"></a>
                                            <p align="center">
                                                <b><?php echo $t['NAMAGUDANG'] ?></b>
                                            </p>
                                        </div>
                                    <?php } ?>
                                    </div>
                                </div>
								
                            </div>                          
                          
                        </div>
						
						<?php } ?>
                        
                        
                    </div>
					</div>

                   <?php 
				   }
				   ?>
</div>