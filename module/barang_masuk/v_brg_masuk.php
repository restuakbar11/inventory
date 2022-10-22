<?php
include 'config/connect.php';
date_default_timezone_set('Asia/Jakarta');
$now    =date('Y-m-d');
$start =date('Y-m-d', strtotime('-1 month', strtotime($now)));
?>
<head>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/jquery/jquery.js"></script>
</head>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                              DATA BARANG MASUK
                            </h2>
                        </div>
                        <div class="body">
							<div class="form-group form-float">
								<div class="col-md-6">
									<a class="btn btn-success add"><i class="material-icons">add</i>Tambah Data</a>
								</div>
								<div class="col-md-2" style="text-align:right;">
									<label>Periode</label>
								</div>
								<div class="col-md-2" id="bs_datepicker_container">
									<input type="text" id="startdate" data-date-format="yyyy-mm-dd" class="date" value="<?php echo $start ?>">
								</div>
								<div class="col-md-2" id="bs_datepicker_container">
									<input type="text" id="finishdate" data-date-format="yyyy-mm-dd" class="date" value="<?php echo $now ?>">
								</div>
							</div></br></br>
							
                            <div class="restu"></div>
							<div id="waiting" style="display:none;width:70px;height:70px;border:0px solid black;position:absolute;top:50%;left:45%;padding:2px;">
								<img src='images/loading.gif' width="70" height="70" />
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<script src="module/barang_masuk/j_brg_masuk.js"></script>
