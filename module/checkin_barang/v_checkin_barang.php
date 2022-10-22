<?php
session_start ();
$username = $_SESSION['username'];
$tanggal = date('Y-m-d');
?>
<head>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/jquery/jquery.js"></script>
</head>
<div class="row clearfix">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="top:50%;left: 50%;transform: translate(-50%);">
        <div class="card">
            <div class="header">
                <h2>
                    Check In Barang Masuk
                </h2>
                   
            </div>
            <div class="body" class="ui-widget">
                    <div class="form-group form-float">
                    <h2 class="card-inside-title">Departemen</h2>
                            <div class="form-line">
                            <select class="form-control" name="id_department" id="id_department">
                                <?php
                            include 'functions/department/queryDepartmentUtama.php';
                            while ($u =mysqli_fetch_array($queryGetDepartment)) { ?>
                                <option style="align:center;" value="<?php echo $u['ID_DEPARTMENT'] ;?>" ><?php echo $u['NAMA_DEPARTMENT'] ;?></option>
                            <?php
                            } ?>
                            </select>
                               <input type="hidden" name="userid" id="userid" value="<?php echo $username ?>">
                               <input type="hidden" name="lastupdate" id="lastupdate" value="<?php echo $tanggal ?>">
                               
                        </div>
                       <!--  <div class="help-info">Ex: A0001</div> -->
                    </div>

                    <div class="form-group form-float">
                    <h2 class="card-inside-title">Lokasi Penyimpanan</h2>
                            <div class="form-line" >
                            <select class="form-control" name="id_gudang" id="id_gudang">
                                <option value="0">--Pilih Lokasi--</option>
                                <?php
                            include 'functions/gudang/queryGetGudang.php';
                            while ($kulkas =mysqli_fetch_array($queryGetGudang)) { ?>
                                <option style="align:center;" value="<?php echo $kulkas['ID_GUDANG'] ;?>" ><?php echo $kulkas['NAMAGUDANG'] ;?></option>
                            <?php
                            } ?>
                            </select>
                            </div>
                    </div>
                    
                    <div class="form-group form-float">
                    <h2 class="card-inside-title">RAK</h2>
                        <div class="form-line">
                             <div class='rak'></div>
                        </div>
                    </div>
                    
                    <div class="form-group form-float">
                    <h2 class="card-inside-title">Kode Barcode</h2>
                        <div class="form-line">
                            <input type="text" class="form-control" name="kode_barcode" id="kode_barcode"> 
                        </div>
                    </div>
                        
                </br>
            </div>
        </div>
    </div>
    <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                DETAIL CHECK IN BARCODE
                            </h2>
                        </div>
                        <div id='loading'><img src='images/loading.gif'style="display: block;margin-left: auto;
  margin-right: auto;
  width: 5%;"/></div>
      </br>
                        <div class="body table-responsive" id="tampilkan">
                            
                        </div>
                    </div>
                </div>
            </div>
            
</div>
<script src="module/checkin_barang/j_checkin_barang.js"></script>
