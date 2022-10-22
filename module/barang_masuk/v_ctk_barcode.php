<?php
$page = urldecode($_GET['page']);
$aksi = urldecode($_GET['aksi']);
$nosj = urldecode($_GET['nosj']);
$id_item = urldecode($_GET['id_item']);
$generate = urldecode($_GET['generate']);
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
					<?php
					if($aksi=='generate') { ?>
						GENERATE DAN CETAK BARCODE
						<?php
					} else { ?>
						CETAK BARCODE
						<?php
					} ?>
                    
                </h2>
                       
                   
            </div>

            <div class="body" class="ui-widget">
                <form method="POST" >
                    <div class="form-group form-float">
                            <div class="form-line">
                               <input type="text" class="form-control" name="brg_masuk" id="brg_masuk" value="<?php echo $nosj; ?>" disabled>
                               <input type="hidden" name="act" id="act">
                               <label>No. Surat Jalan</label>
                        </div>
                       <!--  <div class="help-info">Ex: A0001</div> -->
                    </div>

                    <div class="form-group form-float">
                            <div class="form-line">
                                <input type="hidden" name="id_supplier" id="id_supplier" disabled>
                                <input type="hidden" name="flag" id="flag" value="HEADER">
                            </div>
                    </div>
                </form>
                            <div class="body">
                            <div class="detail_tabel"></div>
                            <a href="index.php?page=brg_masuk" type="button" class="btn btn-danger waves-effect right">Back to List Data</a>
                            </div>
            </div>
        </div>

    </div>
    <!-- DETAIL BARCODE -->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="det_barcode">
        <div class="card">

            <div class="body" class="ui-widget">
                            <div class="body">
                            <div class="detail_barcode"></div>
                            </div>
            </div>
        </div>
        
    </div>
</div>
<script>
    $(document).ready(
  function(){
    
    page = "<?php echo $page ?>";
    aksi = "<?php echo $aksi ?>";
    nosj = "<?php echo $nosj ?>";
    id_item= "<?php echo $id_item ?>";
    generate = "<?php echo $generate ?>";
    if (generate == 1) {
        $('#det_barcode').fadeIn('slow');
        $('.detail_barcode').load("functions/itembarcode/show_detail_barcode.php?nosj="+nosj+"&id_item="+id_item);
    }else{
        $('#det_barcode').fadeOut('slow');

    }
$('.detail_tabel').load("functions/barang_masuk/show_detailbarangmasuk.php?nosj="+nosj+"&page="+page+"&aksi="+aksi);
});

$(document).on('click','.generate',function(){
    $('#det_barcode').fadeIn('slow');
    var id = $(this).attr('data');
    var explode = id.split('&');
    nosj = explode[0];
    id_item = explode[1];
    nosj_detail=explode[2];
        $.ajax({
        type: "POST", 
        url : "functions/barang_masuk/f_generate_barcode.php", 
        data: "act=generate_barcode&nobarangmasuk_detail=" + nosj_detail +"&id_item="+id_item ,
        dataType: "json",     
        success: function(data){
           if (data.hasil == 0) {
                Swal.fire({
                    title: data.status,
                    text: data.ket,
                    confirmButtonColor: "#80C8FE",
                    type: "error",
                    timer: 3500,
                    confirmButtonText: "Ya",
                    showConfirmButton: true
                  });
                $('#det_barcode').fadeOut('slow');
           }else{
                Swal.fire({
                    title: data.status,
                    text: data.ket,
                    confirmButtonColor: "#80C8FE",
                    type: "success",
                    timer: 3500,
                    confirmButtonText: "Ya",
                    showConfirmButton: true
                });
    $('.detail_barcode').load("functions/itembarcode/show_detail_barcode.php?nosj="+nosj+"&id_item="+id_item);
           }
        }   
    });
});

$(document).on('click','.viewstatus',function(){
    var id = $(this).attr('data');
    var explode = id.split('&');
    nosj = explode[0];
    id_item = explode[1];
    nosj_detail=explode[2];
    $('#det_barcode').fadeIn('slow');
    $('.detail_barcode').load("functions/itembarcode/show_detail_barcode.php?nosj="+nosj+"&id_item="+id_item);
});

$(document).on('click','.hapusbarangmasukdetail',function(){

    var id = $(this).attr('data');
    var explode = id.split('&');
    nosj = explode[0];
    no_brg_masuk = "<?php echo $nosj ?>";
    alert(no_brg_masuk);
    userid = explode[1];
    var checkstr =  confirm('Are you sure want to delete?');
    if(checkstr == true){
    $.ajax({
        type: "POST", 
        url : "functions/barang_masuk/f_barangmasuk.php", 
        data: "act=delete_item&nosj_detail=" + nosj +"&userid="+userid ,
        dataType: "json",     
        success: function(data){
    if(data){
          Swal.fire({
            title: 'Berhasil Terhapus..!!',
            text: "Akan Menutup Dalam 2 Detik!!!",
            confirmButtonColor: "#80C8FE",
            type: "success",
            timer: 3500,
            confirmButtonText: "Ya",
            showConfirmButton: true
          });
          $('.detail_tabel').load("functions/barang_masuk/show_detailbarangmasuk.php?nosj="+no_brg_masuk+"&page="+page+"&aksi="+aksi);
        }else{
          Swal.fire({
            title: 'GAGAL MENGHAPUS..!!',
            text: "Akan Menutup Dalam 2 Detik!!!",
            confirmButtonColor: "#80C8FE",
            type: "success",
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
});

$(document).on('click','.cetak_barcode_all',function(){
	var nobarangmasuk_detail =$(this).attr('data');
	window.open('functions/barang_masuk/cetak_qrcode.php?status=all&nobarangmasuk_detail='+nobarangmasuk_detail, '_blank');
	/*$.ajax({
        type: "POST", 
        url : "functions/barang_masuk/cetak_qrcode.php", 
        data: "nobarangmasuk_detail="+nobarangmasuk_detail,   
        success: function(hasil){
			
		}
	});*/
});
$(document).on('click','.cetak_barcode_satuan',function(){
	var kodebarcode =$(this).attr('data');
	window.open('functions/barang_masuk/cetak_qrcode.php?status=satuan&kodebarcode='+kodebarcode, '_blank');
});

</script>