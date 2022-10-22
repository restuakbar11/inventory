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
                    INPUT MASTER GEDUNG
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
                           <input type="text" class="form-control" name="nama_gedung" id="nama_gedung" >
                           <label class="form-label">Nama Gedung</label>
                        </div>
                    </div>
                    <div class="form-line">
                           <input type="number" class="form-control" name="jumlah_lantai" id="jumlah_lantai" maxlength="2" placeholder="Jumlah Lantai">
                           <input type="hidden" name="username" id="username" value="<?php echo $username; ?>" >
                           <input type="hidden" name="act" id="act">
                    </div>
                    </br>
            <button class="btn btn-primary waves-effect" type="button" onclick="javascript:add_gedung();">SUBMIT</button>
                    <a href="index.php?page=gedung" type="button" class="btn bg-cyan waves-effect right">Back to List Data</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="module/gedung/j_gedung.js"></script>

