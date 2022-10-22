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
                    INPUT MASTER gudang
                </h2>
                   
            </div>
            <div class="body">
                <form method="POST">
                    <div class="form-group form-float">
                        <div class="form-line">
                           <input type="text" class="form-control" name="nama_gudang" id="nama_gudang" >
                           <label class="form-label">Nama Gudang</label>
                        </div>
                    </div>
                    <div class="form-line">
                           <input type="number" class="form-control" name="jumlah_lantai" id="jumlah_lantai" maxlength="2" placeholder="Jumlah Lantai">
                           <input type="hidden" name="username" id="username" value="<?php echo $username; ?>" >
                           <input type="hidden" name="act" id="act">
                    </div>
                    </br>
                    <button class="btn btn-primary waves-effect" type="button" onclick="javascript:add_gudang();">SUBMIT</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="module/gudang/j_gudang.js"></script>

