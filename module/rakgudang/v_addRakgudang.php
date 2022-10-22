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
                    INPUT MASTER RAK
                </h2>
                   
            </div>
            <div class="body">
                <form method="POST">
                    <div class="form-group form-float">
                    <h2 class="card-inside-title">Departemen</h2>
                        <div class="form-line">
                        <select class="form-control" name="id_department" id="id_department">
                                <?php
                            include 'functions/department/queryGetDepartment.php';
                            while ($u =mysqli_fetch_array($queryGetDepartment)) { ?>
                                <option style="align:center;" value="<?php echo $u['ID_DEPARTMENT'] ;?>" ><?php echo $u['NAMA_DEPARTMENT'] ;?></option>
                            <?php
                            } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-float">
                    <h2 class="card-inside-title">Gudang</h2>
                        <div class="form-line">
                            <div class='gudang'></div>
                        </div>
                    </div>
                    <div class="form-group form-float">
                    <h2 class="card-inside-title">Rak</h2>
                        <div class="form-line">
                           <input type="text" class="form-control" name="nama_rakgudang" id="nama_rakgudang" >
                           <label class="form-label">Nama Rak</label>
                        </div>
                    </div>
                    <div class="form-line">
                          <input type="hidden" name="username" id="username" value="<?php echo $username; ?>" >
                           <input type="hidden" name="act" id="act">
                    </div>
                    </br>
                    <button class="btn btn-primary waves-effect" type="button" onclick="javascript:add_rakgudang();">SUBMIT</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="module/rakgudang/j_rakgudang.js"></script>

