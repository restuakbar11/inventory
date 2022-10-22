<?php
session_start ();
$username = $_SESSION['username'];
$nosj = urldecode($_GET['id']);
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
                    <?php echo  "Form Pembatalan RETUR Nomor $nosj" ?> 
                </h2>
            </div>

            <div class="body" class="ui-widget">
                
                <input type="hidden" name="noretur" id="noretur" value="<?php echo $nosj; ?>">
                           
                <div class="body">
                    <div class="detail_tabel"></div></br>
                        <form method="POST" >
                        <div class="form-group form-float">
                            <label>Alasan Pembatalan</label>
                            <div class="form-line">
                               <textarea class="form-control" name="ket" id="ket"
                                placeholder="Tulis alasan disini..."></textarea>
                                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
                            </div>
                        </div>
                            <button class="btn btn-primary waves-effect" type="button" onclick="javascript:btl_retur();">BATAL</button>
							<a href="index.php?page=retur" type="button" class="btn btn-danger waves-effect">Kembali</a>
                        </form>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(
  function(){
   var nosj = $('#noretur').val();
$('.detail_tabel').load("functions/retur/show_detailbatalretur.php?noretur="+nosj);
});

function btl_retur(){
		var nosj = $('#noretur').val();
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
							url : "functions/retur/f_retur.php", 
							data: "act=pembatalan&nosj=" + nosj +"&userid="+username+"&keterangan="+keterangan ,
							dataType: "json",     
							success: function(data){
								if (data.status == 'SUCCESS') {
									Swal.fire({
										title: data.status,
										text: data.info,
										confirmButtonColor: "#80C8FE",
										type: "success",
										confirmButtonText: "Ya",
										showConfirmButton: true
									});
									$(location).attr('href','index.php?page=retur');
								} else {
									Swal.fire({
										title: data.status,
										text: data.ket,
										confirmButtonColor: "#80C8FE",
										type: "error",
										confirmButtonText: "Ya",
										showConfirmButton: true
									});
									$(location).attr('href','index.php?page=retur');
								}
							} 
						});
				}
			})
		}
}

</script>