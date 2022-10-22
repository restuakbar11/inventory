<?php
session_start ();
$username = $_SESSION['username'];
$nosj = urldecode($_GET['nosj']);
$id_supplier = urldecode($_GET['idsupplier']);

if ($nosj == '') {
    $act = 'simpan';
    $title = 'INPUT BARANG MASUK';
    $text_button = 'NEXT';
    $status_form = '';
}else{
    $act = 'update_header';
    $title = 'EDIT BARANG MASUK';
    $text_button = 'UPDATE';
    $status_form = 'disabled';
}
?>
<head>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/jquery/jquery.js"></script>
</head>
<div class="row clearfix">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="card" style="min-height:530px;">
            <div class="header">
                <h2>
                    <?php echo "$title"; ?>
                </h2>
                   
            </div>
            <div class="body" class="ui-widget">
                <form method="POST" >
                    <div class="form-group form-float">
                            <div class="form-line">
                               <input type="text" class="form-control" name="brg_masuk" id="brg_masuk" value="<?php echo $nosj; ?>" <?php echo "$status_form"; ?> onkeyup="validation()">
                               <input type="hidden" name="act" id="act" value="<?php echo $act ?>">
                               <input type="hidden" name="userid" id="userid" value="<?php echo $username ?>">
                               <label class="form-label">No. Surat Jalan</label>
                        </div>
                       <!--  <div class="help-info">Ex: A0001</div> -->
                    </div>

                    <div class="form-group form-float">
                            <div class="form-line" id="bs_datepicker_container">
                                <input type="text" data-date-format="yyyy-mm-dd" class="form-control" name="tgl_masuk" id="tgl_masuk" value="<?php echo date('Y-m-d');?>" >
                                <input type="hidden" name="department" id="department" value="4">
                            </div>
                    </div>
                    
                    <div class="form-group form-float">
                        <div class="form-line">
                             <select class="form-control" name="supplier" id="supplier">
                                <option style="margin-left:20px;" value="0" selected="selected">-- PILIH SUPPLIER --</option>
                                <?php
                            include 'functions/itemsupplier/querySupplier.php';
                            while ($u =mysqli_fetch_array($querySupplier)) { ?>
                                <option <?php if($id_supplier==$u['IDSUPPLIER']){echo "selected"; } ?> value="<?php echo $u['IDSUPPLIER']?>-<?php echo $u['ADDRESSSUPPLIER']?>"><?php echo $u['NAMASUPPLIER']?></option>
                               
                            <?php
                            } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" name="alamat" id="alamat" disabled>
                                <input type="hidden" name="id_supplier" id="id_supplier" value="<?php echo $id_supplier?>" disabled >
                                <input type="hidden" name="flag" id="flag" value="HEADER">
                            </div>
                    </div>
                    
                     <div class="form-group form-float">
                            <div class="form-line">
                                <textarea rows="4" class="form-control no-resize" placeholder="Please type what you want..." id="catatan" name="catatan" value="eeeee"></textarea>
                            </div>
                    </div>
                        
                    <button class="btn btn-primary waves-effect" id="smpn_header" type="button" onclick="javascript:simpan_header();"><?php echo "$text_button"; ?><i class="material-icons">forward</i></button> 
                </form></br>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" id="addItem">
        <div class="card" style="min-height:530px;">
            <div class="header">
                <h2>
                    INPUT ITEM DISINI
                </h2>
                   
            </div>
            <div class="body">
                <form method="POST">

                    <div class="form-group form-float">
                            <div class="form-line">
                                <select class="form-control" name="item" id="item" data-live-search="on">
                                    <option style="margin-left:20px;" value="0">-- PILIH ITEM --</option>
                                    <?php
                                include 'functions/itemsupplier/queryItem.php';
                                while ($u =mysqli_fetch_array($queryItem)) { ?>
                                    <option style="margin-left:20px;" value="<?php echo $u['IDITEM']?>"><?php echo $u['NAMAITEM']?></option>
                                <?php
                                } ?>
                                </select>
                            </div>
                    </div>
                    <div class="form-group form-float">
                            <div class="form-line">
                                <div class="querySatuan"></div>
                            </div>
                    </div>
                    <div class="form-group form-float">
                            <div class="form-line" id="bs_datepicker_container">
                                <input type="text" data-date-format="yyyy-mm-dd" class="form-control" name="ed" id="ed" value="<?php echo date('Y-m-d');?>" >
                                <label>Expire Date</label>
                            </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="qty" id="qty" onkeyup="number()">
                            <label>Quantity</label>
                        </div>
                    </div> 
                    <div class="form-group form-float">
                        <div class="form-line">
                               <input type="text" class="form-control" name="lot" id="lot">
                               <label class="form-label">Lot Number</label>
                        </div>
                    </div> 
                    <button class="btn btn-primary waves-effect" id="smpn_detail" type="button" onclick="javascript:simpan_detail();">Add Item<i class="material-icons">forward</i></button>
                    <a href="index.php?page=brg_masuk" type="button" class="btn btn-danger waves-effect right">Back to List Data</a>                     
                </form>
                
                           
            </div>
        </div>
    </div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="detailItem" >
        <div class="card">
            <div class="header">
                <h2>
                    DETAIL ITEM
                </h2>
                   
            </div>
            <div class="body">
				<div class="detail_tabel"></div>
				
			</div>
		</div>
	</div>
</div>
<script src="module/barang_masuk/j_brg_masuk.js"></script>
<script>
$(document).ready(
  function(){
  act = "<?php echo $act ?>";
  nosj = "<?php echo $nosj ?>";

  id_supplier = "<?php echo $id_supplier ?>";
  if (act == 'simpan') {
    $('#addItem').fadeOut('slow');
    $('#detailItem').fadeOut('slow');
}else{
    $('#addItem').fadeIn('slow');
	$("#detailItem").fadeIn('slow');
    $('.detail_tabel').load("functions/barang_masuk/show_detailbarangmasuk.php?nosj="+nosj);
}


 });
</script>
