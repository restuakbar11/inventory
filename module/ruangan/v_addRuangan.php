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
                    INPUT MASTER RUANGAN
                </h2>
                <div class="alert alert-success alert-dismissible" id="sukses" style="width:300px; height:50px; float:right; display:none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color:white;">&times;</button>
                        <h4><i class="icon fa fa-check"></i> <label id="pesan"></label></h4>
                </div>  
            </div>
            <div class="body">
                <form method="POST">
                    <div class="form-group form-float">
                        <div class="form-group form-float">
                            <div class="form-line">
                               <select class="form-control" name="gedung" id="gedung" data-live-search="true">
                            <option value="0" style="align:center;margin-left:20px;">-- PILIH GEDUNG --</option>
                             <?php
                                include 'functions/gedung/queryGetGedung.php';
                                while ($u =mysqli_fetch_array($queryGetGedung)) { ?>
                                    <option style="align:center;margin-left:20px;" value="<?php echo $u['ID_GEDUNG']?>"><?php echo $u['NAMA_GEDUNG']?></option>
                                    <?php
                                } ?>
                            </select>
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                               <input type="text" class="form-control" name="nama_ruangan" id="nama_ruangan" >
                               <label class="form-label">Nama Ruangan</label>
                            </div>
                        </div>
                        <div class="form-line">
                          <input type="number" class="form-control" name="lantai" id="lantai" maxlength="2">
                           <input type="hidden" name="username" id="username" value="<?php echo $username; ?>" >
                           <input type="hidden" name="act" id="act">    
                          <label class="form-label">Lantai</label>
						   
						   <select class="form-control" id="lantaix">

							</select>
							
                        </div>
						
                       <!--  <div class="help-info">Ex: A0001</div> -->
                    </div>
                <button class="btn btn-primary waves-effect" type="button" onclick="javascript:add_ruangan();">SUBMIT</button>
                <a href="index.php?page=ruangan" type="button" class="btn bg-cyan waves-effect right">Back to List Data</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="module/ruangan/j_ruangan.js"></script>
<script>
/*
 $("#gedung").change(function(){
            // variabel dari nilai combo box gedung
            var id_gedung = $("#gedung").val();

            // Menggunakan ajax untuk mengirim dan dan menerima data dari server
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "functions/gedung/f_gedung.php",
                data: "act=getLantai&id_gedung="+id_gedung,
                success: function(data){
				var selOpts = "";
				$.each(data, function(k, v)
				{
					var lantai = data[k].lantai;
					alert(lantai);
					selOpts += "<option value='"+lantai+"'>"+lantai+"</option>";
				});
				
				$('#lantaix').append(selOpts);
             }
       });
 });
 */
 </script>

