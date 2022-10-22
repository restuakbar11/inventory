<?php
include 'config/connect.php';
date_default_timezone_set('Asia/Jakarta');
$now	=date('Y-m-d');
$start =date('Y-m-d', strtotime('-1 month', strtotime($now)));
$id_department =$_SESSION['id_department'];
include 'functions/barang_keluar/queryDepartmentPerSession.php';
$d =mysqli_fetch_array($queryDepartmentPerSession);

switch($_GET['act']) {
	
default : ?>
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						DATA STOK BARANG DEPARTEMEN :<font color="blue"><b> <?php echo $d['NAMA_DEPARTMENT'] ?></b></font>
					</h2>
				</div>
					
				<div class="body">
					
					
					<div class="show_stock_per_dept"></div>
					<div id="waiting" style="display:none;width:70px;height:70px;border:0px solid black;position:absolute;top:50%;left:45%;padding:2px;">
						<img src='images/loading.gif' width="70" height="70" />
					</div>
					
				</div>
			</div>
		</div>
	</div>
	<?php
break;



case "detailstock": ?>
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						DETAIL STOCK
					</h2>
				</div>
					
				<div class="body">
					
					
					<input type="hidden" name="item" id="item" value="<?php echo $_GET['item']?>">
					<input type="hidden" name="satuan" id="satuan" value="<?php echo $_GET['sat']?>">
					
					<div class="show_detail_stock_per_dept"></div>
					<div id="wait" style="display:none;width:70px;height:70px;border:0px solid black;position:absolute;top:50%;left:45%;padding:2px;">
						<img src='images/loading.gif' width="70" height="70" />
					</div>
					
					<a href="?page=stock_per_dept" class="btn btn-danger">Kembali</a>
				</div>
			</div>
		</div>
	</div>
	<?php
break;



case "detailbarcode": 
	$tampil =$mysqli->query( "SELECT * FROM M_ITEM WHERE IDITEM='$_GET[item]' AND ITEM_ISACTIVE='Y' ");
	// oci_execute($tampil);
	$t =mysqli_fetch_array($tampil);
	
	$tampil2 =$mysqli->query( "SELECT * FROM M_SATUAN WHERE IDSATUAN='$_GET[sat]' AND SATUANISACTIVE='Y' ");
	// oci_execute($tampil2);
	$tt =mysqli_fetch_array($tampil2);
	?>
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						DETAIL BARCODE
					</h2>
				</div>
					
				<div class="body">
					<div class="row clearfix">
						<div class="form-group form-float">
							<div class="col-md-2" style="background-color:yellow;">
								<label>Nama Item</label>
							</div>
							<div class="col-md-4" style="background-color:cyan;">
								<label>: <?php echo $t['NAMAITEM']?></label>
							</div>
							<div class="col-md-2" style="background-color:yellow;">
								<label>Satuan</label>
							</div>
							<div class="col-md-4" style="background-color:cyan;">
								<label>: <?php echo $tt['NAMASATUAN']?></label>
							</div>
						</div>
					</div>
					<div class="row clearfix">
						<div class="form-group form-float">
							<div class="col-md-2" style="background-color:yellow;">
								<label>Lot Number</label>
							</div>
							<div class="col-md-4" style="background-color:cyan;">
								<label>: <?php echo $_GET['lot']?></label>
							</div>
							<div class="col-md-2" style="background-color:yellow;">
								<label>ED</label>
							</div>
							<div class="col-md-4" style="background-color:cyan;">
								<label>: <?php echo $_GET['ed']?></label>
							</div>
						</div></br></br>
					</div>
					
					<input type="hidden" name="item" id="item" value="<?php echo $_GET['item']?>">
					<input type="hidden" name="satuan" id="satuan" value="<?php echo $_GET['sat']?>">
					<input type="hidden" name="lot_number" id="lot_number" value="<?php echo $_GET['lot']?>">
					<input type="hidden" name="ed" id="ed" value="<?php echo $_GET['ed']?>">
					<input type="hidden" name="department" id="department" value="<?php echo $_GET['dept']?>">
					
					<div class="show_detail_barcode"></div>
					<div id="wait" style="display:none;width:70px;height:70px;border:0px solid black;position:absolute;top:50%;left:45%;padding:2px;">
						<img src='images/loading.gif' width="70" height="70" />
					</div>
					
					<a href="#" class="btn btn-danger" onclick="self.history.back()">Kembali</a>
				</div>
			</div>
		</div>
	</div>
	<?php
break;

} ?>
	
	
<!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>
<script>
$(document).ready(function(){
		tampil_list();
		tampil_detail_stock_per_dept ();
		$('#department').on('change',function() {
			tampil_detail_stock_per_dept();
		});
		tampil_detail_barcode ();
});

function tampil_list () {
		$(document).ajaxStart(function(){
			$("#waiting").css("display", "block");
		});
		$(document).ajaxComplete(function(){
			$("#waiting").css("display", "none");
		});
		$.ajax({
				type: 'POST',
				url: "functions/stock_per_dept/show_stock_per_dept.php",
				data: "",
				success: function(hasil) {
					$('.show_stock_per_dept').html(hasil);
				}
		});
}

function tampil_detail_stock_per_dept () {
		$(document).ajaxStart(function(){
			$("#wait").css("display", "block");
		});
		$(document).ajaxComplete(function(){
			$("#wait").css("display", "none");
		});
		var item =$('#item').val();
		var satuan =$('#satuan').val();
		$.ajax({
				type: 'POST',
				url: "functions/stock_per_dept/show_detail_stock_per_dept.php",
				data: "item="+item+"&satuan="+satuan,
				success: function(hasil) {
					$('.show_detail_stock_per_dept').html(hasil);
				}
		});
}

function tampil_detail_barcode () {
		$(document).ajaxStart(function(){
			$("#wait").css("display", "block");
		});
		$(document).ajaxComplete(function(){
			$("#wait").css("display", "none");
		});
		var item =$('#item').val();
		var satuan =$('#satuan').val();
		var lot_number =$('#lot_number').val();
		var ed =$('#ed').val();
		$.ajax({
				type: 'POST',
				url: "functions/stock_per_dept/show_detail_barcode.php",
				data: "item="+item+"&satuan="+satuan+"&lot_number="+lot_number+"&ed="+ed,
				success: function(hasil) {
					$('.show_detail_barcode').html(hasil);
				}
		});
}

</script>