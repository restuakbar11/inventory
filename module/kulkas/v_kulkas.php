<?php
session_start ();
$username = $_SESSION['username'];
?>
<head>
    <script src="./plugins/jquery/jquery.min.js"></script>
    <script src="./plugins/jquery/jquery.js"></script>
	<style>
	 .restu{
		padding-top: 20px;
	 }
	</style>
</head>
        <div class="container-fluid">
            
        </br>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                              MASTER KULKAS
							  <a href="index.php?page=master_data" type="button" class="btn bg-cyan waves-effect right">Back to Master Data</a>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="alert alert-success alert-dismissible" id="sukses" style="width:300px; height:50px; float:right; display:none;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color:white;">&times;</button>
                            <h4><i class="icon fa fa-check"></i> <label id="pesan"></label></h4>
                            </div>
						
                        <a href="#" class="btn btn-success tambahkulkas" data-toggle="modal"><i class="material-icons">add</i> Tambah Data</a></br></br>
                            <div class="restu"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalkulkas" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel"></h4>
                    
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Kode Kulkas*</label>
                        <div class="col-sm-8 ">
                            <div class="form-line">
                                <input type="text" class="form-control clearform" name="kode_kulkas" id="kode_kulkas" maxlength="7">
                                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>" >
                                <input type="hidden" name="act" id="act">
                            </div>
                        </div></br>
                        <label for="inputEmail3" class="col-sm-4 control-label">Gudang*</label>
                        <div class="col-sm-8 ">
                            <div class="form-line">
                                <select class="form-control clearform" name="id_gudang" id="id_gudang" data-live-search="true">
                                    <option value="0" style="align:center;">-- PILIH KULKAS --</option>
                            <?php
                                include 'functions/queryGetKulkasFromGudang.php';
                                while ($u =mysqli_fetch_array($queryGetKulkasFromGudang)) { ?>
                                    <option style="align:center; margin-left:20px;" value="<?php echo $u['ID_GUDANG']?>"><?php echo $u['NAMAGUDANG']?></option>
                            <?php
                                } ?>
                            </select>
                            </div>
                        </div></br>
                        <label for="inputEmail3" class="col-sm-4 control-label">Type Kulkas*</label>
                        <div class="col-sm-8 ">
                            <div class="form-line">
                               <select class="form-control clearform" name="type_kulkas" id="type_kulkas" data-live-search="true">
                            <option value="0" style="align:center; margin-left:20px;">-- PILIH TYPE KULKAS --</option>
                             <?php
                                include 'functions/type_kulkas/queryGetTypeKulkas.php';
                                while ($u =mysqli_fetch_array($queryGetTypeKulkas)) { ?>
                                    <option style="align:center; margin-left:20px;" value="<?php echo $u['ID_TYPEKULKAS']?>"><?php echo $u['NAMA_TYPEKULKAS']?></option>
                            <?php
                                } ?>
                           
                            </select>
                            </div>
                        </div></br>
                        <label for="inputEmail3" class="col-sm-4 control-label">IP Kulkas*</label>
                         <div class="col-sm-8 ">
						 <div class="input-group">
                            <div class="form-line">
                              <input type="text" class="form-control clearform ip" name="ip_kulkas" id="ip_kulkas" placeholder="Ex: 255.255.255.255">
                            </div>
						</div>
                        </div></br>


                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary waves-effect" type="button" onclick="javascript:add_kulkas();">SUBMIT</button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

<script src="module/kulkas/j_kulkas.js"></script>

