<?php
session_start ();
$username = $_SESSION['username'];
?>
<head>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/jquery/jquery.js"></script>
</head>
<style>
    #tiga
{
    
    z-index: 3;

}
</style>
<div class="row clearfix">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="card">
            <div class="header">
                <h2>
                    INPUT MAPPING KULKAS SUB DEPARTMENT
                </h2>
                   
            </div>
            <div class="body">
                <div class="alert alert-success alert-dismissible" id="sukses" style="width:300px; height:50px; float:right; display:none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color:white;">&times;</button>
                        <h4><i class="icon fa fa-check"></i> <label id="pesan"></label></h4>
                </div>

                <form method="POST">
                    <div class="form-group">
                        <div class="form-group">
                            <div class="form-line" id="tiga">
                              <select class="form-control show-tick" id="id_subdepartment" name="id_subdepartment">
                                <option value="0" style="align:center;margin-left:20px;">-- PILIH SUB DEPARTMENT --</option>
                                <?php
                                include 'functions/sub_department/queryGetSubDepartment.php';
                                while ($u =mysqli_fetch_array($queryGetSubDepartment)) { ?>
                                    <option style="align:center; margin-left:20px;" value="<?php echo $u['ID_SUBDEPARTMENT']?>"><?php echo $u['NAMA_SUBDEPARTMENT']?></option>
                                    <?php
                                } ?>
                           </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                               <select class="form-control show-tick" name="kode_kulkas" id="kode_kulkas" data-live-search="true">
                            <option value="0" style="align:center;margin-left:20px;">-- PILIH KULKAS --</option>
                            <?php
                                include 'functions/kulkas/queryGetKulkas.php';
                                while ($u =mysqli_fetch_array($queryGetKulkas)) { ?>
                                    <option style="align:center;margin-left:20px;" value="<?php echo $u['KODE_KULKAS']?>"><?php echo "[".$u['KODE_KULKAS']."] --".$u['NAMA_KULKAS']?></option>
                                    <?php
                                } ?>
                            </select>
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>" >
                                <input type="hidden" name="act" id="act" >
                            </div>
                        </div>
                    </div>
                        
            <button class="btn btn-primary waves-effect" type="button" onclick="javascript:add_subdeptkulkas();">SUBMIT</button>
            <a href="index.php?page=sub_department_kulkas" type="button" class="btn bg-cyan waves-effect right">Back to List Data</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="module/sub_departmentkulkas/j_subDepartmentKulkas.js"></script>

