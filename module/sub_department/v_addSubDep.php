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
                    INPUT MASTER SUB DEPARTMENT
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
                              <select class="form-control show-tick" id="id_department" name="id_department">
                                <option value="0">-- PILIH DEPARTMENT --</option>
                                <?php
                                include 'functions/department/queryGetDepartment.php';
                                while ($u =mysqli_fetch_array($queryGetDepartment)) { ?>
                                    <option style="align:center;" value="<?php echo $u['ID_DEPARTMENT']?>"><?php echo $u['NAMA_DEPARTMENT']?></option>
                                    <?php
                                } ?>
                           </select>
                            </div>
                        </div>
                        <div class="form-group form-float">
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
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" name="nama_subdep" id="nama_subdep" >
                                <input type="text" name="username" id="username" value="<?php echo $username; ?>" >
                                <input type="text" name="act" id="act" >
                               <label class="form-label">Nama Sub Department cc</label>
                            </div>
                        </div>
                    </div>
                        
            <button class="btn btn-primary waves-effect" type="button" onclick="javascript:add_subdep();">SUBMIT</button>
            <a href="index.php?page=sub_department" type="button" class="btn bg-cyan waves-effect right">Back to List Data</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="module/sub_department/j_subDepartment.js"></script>

