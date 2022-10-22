<?php
session_start ();
$username = $_SESSION['username'];
?>
<head>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/jquery/jquery.js"></script>
	<style>
	 .restu{
		padding-top: 20px;
	 }
	</style>
</head>
        <div class="container-fluid">
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                              MAPPING KULKAS SUB DEPARTMENT
							  <a href="index.php?page=master_data" type="button" class="btn bg-cyan waves-effect right">Back to Master Data</a>
                            </h2>
                        
                        </div>
                        <div class="body">
                            <div class="alert alert-success alert-dismissible" id="sukses" style="width:300px; height:50px; float:right; display:none;">
						        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color:white;">&times;</button>
						        <h4><i class="icon fa fa-check"></i> <label id="pesan"></label></h4>
					        </div>
						<a href="#" class="btn btn-success tambahsubdkulkas"><i class="material-icons">add</i>  Tambah Data</a>

                            <div class="restu"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalsubdkulkas" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel"></h4>
                    <div class="alert alert-success alert-dismissible" id="sukses" style="width:300px; height:50px; float:right; display:none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color:white;">&times;</button>
                        <h4><i class="icon fa fa-check"></i> </h4>
                </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
						<label for="inputEmail3" class="col-sm-4 control-label">Kulkas*</label>
                        <div class="col-sm-8 ">
                            <div class="form-line">
                               <select class="form-control clearform show-tick" name="kode_kulkas" id="kode_kulkas" data-live-search="true">
                            <option value="0" style="align:center;margin-left:20px;">-- PILIH KULKAS --</option>
                            <?php
                                include 'functions/kulkas/queryGetKulkas.php';
                                while ($u =mysqli_fetch_array($queryGetKulkas)) { ?>
                                    <option style="align:center;margin-left:20px;" value="<?php echo $u['KODE_KULKAS']?>"><?php echo "[".$u['KODE_KULKAS']."] --".$u['NAMA_KULKAS']?></option>
                                    <?php
                                } ?>
                            </select>
                            </div>
                        </div></br>
						
                        <label for="inputEmail3" class="col-sm-4 control-label">Sub Department*</label>
                        <div class="col-sm-8 ">
                            <div class="form-line">
                                <select class="form-control clearform show-tick" id="id_subdepartment" name="id_subdepartment">
                                <option value="0" style="align:center;margin-left:20px;">-- PILIH SUB DEPARTMENT --</option>
                                <?php
                                include 'functions/sub_department/queryGetSubDepartment.php';
                                while ($u =mysqli_fetch_array($queryGetSubDepartment)) { ?>
                                    <option style="align:center; margin-left:20px;" value="<?php echo $u['ID_SUBDEPARTMENT']?>"><?php echo $u['NAMA_SUBDEPARTMENT']?></option>
                                    <?php
                                } ?>
                           </select>
                            </div>
                        </div></br>
                        
                        <div class="col-sm-8">
                            <input type="hidden" name="username" id="username" value="<?php echo $username; ?>" >
                            <input type="hidden" name="act" id="act" >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary waves-effect" type="button" id="save" onclick="javascript:add_subdeptkulkas();">SUBMIT</button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

<script src="module/sub_departmentkulkas/j_subDepartmentKulkas.js"></script>
