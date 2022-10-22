<?php
session_start ();
$username = $_SESSION['username'];
$nosj = urldecode($_GET['nosj']);
$page = urldecode($_GET['page']);
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
                <a href="index.php?page=brg_masuk" type="button" class="btn btn-danger waves-effect">Back to List Data</a>
                
                <div class="body">
                    <div class="detail_tabel"></div>
                        <form method="POST" >
                        <div class="form-group form-float">
                            <label>Alasan Pembatalan</label>
                            <div class="form-line">
                               <textarea class="form-control" name="ket" id="ket"
                                placeholder="Tulis alasan disini..."></textarea>
                                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
                            </div>
                        </div>
                            <button class="btn btn-primary waves-effect" type="button" onclick="javascript:btl_msk();">BATAL</button>
                        </form>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(
  function(){
    
    nosj = "<?php echo $nosj ?>";
    page = "<?php echo $page ?>";
$('.detail_tabel').load("functions/barang_masuk/show_detailbarangmasuk.php?nosj="+nosj+"&page="+page);
});

function btl_msk(){
    nosj = "<?php echo $nosj ?>";
    keterangan = document.getElementById('ket').value;
    username = document.getElementById('username').value;
    var checkstr =  confirm('Apa anda yakin ingin melakukan pembatalan');
    if(checkstr == true){
    $.ajax({
        type: "POST", 
        url : "functions/barang_masuk/f_barangmasuk.php", 
        data: "act=pembatalan&nosj=" + nosj +"&userid="+username+"&keterangan="+keterangan ,
        dataType: "json",     
        success: function(data){
            if (data.status == 'SUCCESS') {
                window.location.replace("index.php?page=brg_masuk");
                 
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
    } else{
    return false;
    }

}

</script>