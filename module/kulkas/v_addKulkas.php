<?php
session_start ();
$username = $_SESSION['username'];
$kd_kulkas = urldecode($_GET['kulkas']);

if ($kd_kulkas == '') {
    $act = 'simpan';
    $title = 'INPUT MASTER KULKAS';
}else{
    $act = 'update';
    $title = 'EDIT MASTER KULKAS';
}
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
                    <?php echo $title; ?>
                </h2>
                <div class="alert alert-success alert-dismissible" id="sukses" style="width:300px; height:50px; float:right; display:none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color:white;">&times;</button>
                        <h4><i class="icon fa fa-check"></i> <label id="pesan"></label></h4>
                </div>
                   
            </div>
            <div class="body">
                <form method="POST" id="form-data">
                    <div class="form-group form-float">
                        <div class="form-line">
                           <input type="text" class="form-control" name="kode_kulkas" id="kode_kulkas" maxlength="7">
                           <input type="hidden" name="username" id="username" value="<?php echo $username; ?>" >
                           <input type="hidden" name="act" id="act" value="<?php echo $act; ?>">
                           <label class="form-label">Kode Kulkas</label>
                        </div>
                       <!--  <div class="help-info">Ex: A0001</div> -->
                    </div>
					
                    <div class="form-group form-float">
                        <div class="form-line">
						   <select class="form-control" name="id_gudang" id="id_gudang" data-live-search="true">
                            <option value="0" style="align:center; margin-left:20px;">-- PILIH KULKAS --</option>
                            <?php
                                include 'functions/queryGetKulkasFromGudang.php';
                                while ($u =mysqli_fetch_array($queryGetKulkasFromGudang)) { ?>
                                    <option style="align:center; margin-left:20px;" value="<?php echo $u['ID_GUDANG']?>"><?php echo $u['NAMAGUDANG']?></option>
                            <?php
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <select class="form-control" name="type_kulkas" id="type_kulkas" data-live-search="true">
                            <option value="0" style="align:center; margin-left:20px;">-- PILIH TYPE KULKAS --</option>
                            <?php
                                include 'functions/type_kulkas/queryGetTypeKulkas.php';
                                while ($u =mysqli_fetch_array($queryGetTypeKulkas)) { ?>
                                    <option style="align:center; margin-left:20px;" value="<?php echo $u['ID_TYPEKULKAS']?>"><?php echo $u['NAMA_TYPEKULKAS']?></option>
                            <?php
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
							<div class="input-group">
                            <input type="text" class="form-control ip" name="ip_kulkas" id="ip_kulkas" placeholder="Ex: 255.255.255.255">
							</div>
                            <label class="form-label">IP Kulkas</label>
                        </div>
                    </div>
                                            
            <button class="btn btn-primary waves-effect" type="button" onclick="javascript:add_kulkas();">SUBMIT</button>
            <a href="index.php?page=kulkas" type="button" class="btn bg-cyan waves-effect right">Back to List Data</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="module/kulkas/j_kulkas.js"></script>
<script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>