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
                              MASTER SUB DEPARTMENT
							  <a href="index.php?page=master_data" type="button" class="btn bg-cyan waves-effect right">Back to Master Data</a>
                            </h2>
                        
                        </div>
                        <div class="body">
                            <div class="alert alert-success alert-dismissible" id="sukses" style="width:300px; height:50px; float:right; display:none;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color:white;">&times;</button>
                            <h4><i class="icon fa fa-check"></i> <label id="pesan"></label></h4>
                            </div>
						<a href="#" class="btn btn-success tambahsubdept"><i class="material-icons">add</i>  Tambah Data</a></br></br>
                            <div class="restu"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalsubdepartment" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel"></h4>
                    
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Department*</label>
                        <div class="col-sm-8 ">
                            <div class="form-line">
                                <select class="form-control clearform show-tick" id="id_department" name="id_department">
                                <option value="0">-- PILIH DEPARTMENT --</option>
                                <?php
                                include 'functions/department/queryGetDepartment.php';
                                while ($u =mysqli_fetch_array($queryGetDepartment)) { ?>
                                    <option style="align:center;" value="<?php echo $u['ID_DEPARTMENT']?>"><?php echo $u['NAMA_DEPARTMENT']?></option>
                                    <?php
                                } ?>
                           </select>
                            </div>
                        </div></br>
                        <label for="inputEmail3" class="col-sm-4 control-label">Ruangan*</label>
                        <div class="col-sm-8 ">
                            <div class="form-line">
                                <select class="form-control show-tick clearform user" name="ruangan" id="ruangan" data-live-search="true">
                                    <option value="0">-- PILIH RUANGAN --</option>
                                    <?php
                                    include 'functions/ruangan/queryGetRuangan.php';
                                    while ($u =mysqli_fetch_array($queryGetRuangan)) { ?>
                                    <option style="align:center;" value="<?php echo $u['ID_RUANGAN']?>"><?php echo $u['NAMA_RUANGAN']?></option>
                                    <?php
                                } ?>
                            </select>
                            </div>
                        </div></br>
                        <label for="inputEmail3" class="col-sm-4 control-label">Nama Sub Department*</label>
                        <div class="col-sm-8 ">
                            <div class="form-line">
                                <input type="text" class="form-control" name="nama_subdep" id="nama_subdep" >
                                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>" >
                                <input type="hidden" name="act" id="act" >
                                <input type="hidden" name="id_subdepartment" id="id_subdepartment"  class="form-control">
                            </div>
                        </div></br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary waves-effect" type="button" id="save" onclick="javascript:add_subdep();">SUBMIT</button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

<script src="module/sub_department/j_subDepartment.js"></script>
