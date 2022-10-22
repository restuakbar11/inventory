<?php
session_start ();
$username = $_SESSION['username'];
?>
<head>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/jquery/jquery.js"></script>
</head>
<div class="row clearfix">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="card">
            <div class="header">
                <h2>
                    INPUT MASTER RAK KULKAS
                </h2>
                <div class="alert alert-success alert-dismissible" id="sukses" style="width:300px; height:50px; float:right; display:none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color:white;">&times;</button>
                        <h4><i class="icon fa fa-check"></i> <label id="pesan"></label></h4>
                </div>
                   
            </div>
            <div class="body">
                <form method="POST">
                    <div class="form-group form-float">
                        <div class="form-line">
                           <input type="text" class="form-control" name="kode_rak" id="kode_rak" maxlength="10">
                           <label class="form-label">Kode Rak Kulkas</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <select class="form-control" name="type_kulkas" id="type_kulkas" data-live-search="true">
                            <option value="0">-- PILIH KULKAS --</option>
                            <?php
                                include 'functions/kulkas/queryGetKulkas.php';
                                while ($u =mysqli_fetch_array($queryGetKulkas)) { ?>
                                    <option style="align:center;" value="<?php echo $u['KODE_KULKAS']?>"><?php echo $u['NAMA_KULKAS']?></option>
                            <?php
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="nama_rak" id="nama_rak" min="10" max="200" >
                            <label class="form-label">Nama Rak Kulkas</label>
                            <input type="hidden" name="username" id="username" value="<?php echo $username; ?>" >
                            <input type="hidden" name="act" id="act" >
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                           <input type="text" class="form-control" name="jenis_rak" id="jenis_rak" >
                           <label class="form-label">Jenis Rak Kulkas</label>
                        </div>
                    </div>
                        
            <button class="btn btn-primary waves-effect" type="button" onclick="javascript:add_rak();">SUBMIT</button>
            <a href="index.php?page=rakKulkas" type="button" class="btn bg-cyan waves-effect right">Back to List Data</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="module/rak_kulkas/j_rakKulkas.js"></script>
