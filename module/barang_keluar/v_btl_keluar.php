<?php
session_start ();
$username = $_SESSION['username'];
$nosj = urldecode($_GET['nosj']);
?>
<head>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/jquery/jquery.js"></script>
</head>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    <?php echo  "Form Pembatalan Nomor $nosj" ?> 
                </h2>
            </div>

            <div class="body" class="ui-widget">
                <a href="index.php?page=brg_keluar" type="button" class="btn btn-danger waves-effect">Back to List Data</a>
                
                <div class="body">
                    <!-- <div class="detail_tabel"></div> -->
                        <form method="POST" >
                        <div class="form-group form-float">
                            <label>Alasan Pembatalan</label>
                            <div class="form-line">
                               <textarea class="form-control" name="ket" id="ket"
                                placeholder="Tulis alasan disini..."></textarea>
                                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
                            </div>
                        </div>
                            <button class="btn btn-primary waves-effect" type="button" onclick="javascript:btl_keluar();">BATAL</button>
                        </form>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(
  function(){
});

function btl_keluar(){
    nosj = "<?php echo $nosj ?>";
    keterangan = document.getElementById('ket').value;
    username = document.getElementById('username').value;
	if(keterangan=='') {
		Swal.fire({
			title: 'WARNING',
			text: 'Keterangan Batal tidak boleh kosong...',
			type: 'warning',
			confirmButtonColor: "red",
			showCancelButton: false,
			allowOutsideClick: false
		})
	} else {
		Swal.fire({
			title: 'CONFIRM',
			text: "Apakah Anda Yakin ingin Membatalkan Transaksi ini ?",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			allowOutsideClick: false,
			confirmButtonText: 'Yes',
			position: 'center'
		}).then((result) => {
			if (result.value) {
				$.ajax({
						type: "POST", 
						url : "functions/barang_keluar/f_barang_keluar.php", 
						data: "act=pembatalan&nosj=" + nosj +"&userid="+username+"&keterangan="+keterangan ,
						dataType: "json",     
						success: function(data){
							if (data.status == 'SUCCESS') {
								Swal.fire({
									title: data.status,
									text: data.info,
									confirmButtonColor: "#80C8FE",
									type: "success",
									timer: 3500,
									confirmButtonText: "Ya",
									showConfirmButton: true
								});
								$(location).attr('href','index.php?page=brg_keluar');
							}else{
								Swal.fire({
									title: data.status,
									text: data.info,
									confirmButtonColor: "#80C8FE",
									type: "error",
									timer: 3500,
									confirmButtonText: "Ya",
									showConfirmButton: true
								});
							}
						}   
					});
			}
		})
	}

}

</script>