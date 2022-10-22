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
                    <?php echo  "Form Pembatalan TAG Nomor $nosj" ?> 
                </h2>
            </div>

            <div class="body" class="ui-widget">
                <a href="index.php?page=tag" type="button" class="btn btn-danger waves-effect">Back to List Data</a>
                <input type="hidden" name="notag" id="notag" value="<?php echo $nosj; ?>">
                           
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
                            <button class="btn btn-primary waves-effect" type="button" onclick="javascript:btl_tag();">BATAL</button>
                        </form>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(
  function(){
   var nosj = $('#notag').val();
$('.detail_tabel').load("functions/tag/show_detailbataltag.php?notag="+nosj);
});

function btl_tag(){
    var nosj = $('#notag').val();
    keterangan = document.getElementById('ket').value;
    username = document.getElementById('username').value;
    var checkstr =  confirm('Apa anda yakin ingin melakukan pembatalan');
    if(checkstr == true){
    $.ajax({
        type: "POST", 
        url : "functions/tag/f_tag.php", 
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
          
$(location).attr('href','index.php?page=tag');
            }else{
                Swal.fire({
                    title: data.status,
                    text: data.ket,
                    confirmButtonColor: "#80C8FE",
                    type: "error",
                    timer: 3500,
                    confirmButtonText: "Ya",
                    showConfirmButton: true
          });
          
$(location).attr('href','index.php?page=tag');
            } 
        }   
    });
    } else{
    return false;
    }

}

</script>