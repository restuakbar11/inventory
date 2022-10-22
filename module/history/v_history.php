<?php
include 'config/connect.php';
date_default_timezone_set('Asia/Jakarta');
$now	=date('Y-m-d');
$start =date('Y-m-d', strtotime('-1 month', strtotime($now)));

switch($_GET['act']) {
	
default : ?>
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						DATA HISTORY TRANSAKSI
					</h2>
				</div>
					
				<div class="body">
					
					
					<div class="show_history"></div>
					<div id="waiting" style="display:none;width:70px;height:70px;border:0px solid black;position:absolute;top:50%;left:45%;padding:2px;">
						<img src='images/loading.gif' width="70" height="70" />
					</div>
					
				</div>
			</div>
		</div>
	</div>
	<?php
break;



case "detailhistory": ?>
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						DETAIL HISTORY
					</h2>
				</div>
					
				<div class="body">
					<div class="form-group form-float">
						<div class="col-md-1" style="text-align:right;">
							<label>Department</label>
						</div>
						<div class="col-md-3">
							<select name="department" id="department" class="form-control">
								<option value="0" selected>ALL</option>
								<?php
								include 'functions/department/queryGetDepartment.php';
								while ($d =mysqli_fetch_array($queryGetDepartment)) { ?>
									<option value="<?php echo $d['ID_DEPARTMENT']?>"><?php echo $d['NAMA_DEPARTMENT']?></option>
									<?php
								} ?>
							</select>
						</div>
						<div class="col-md-2" style="text-align:right;">
							
						</div>
						<div class="col-md-2" style="text-align:right;">
							<label>Periode</label>
						</div>
						<div class="col-md-2" id="bs_datepicker_container">
							<input type="text" id="startdate" data-date-format="yyyy-mm-dd" class="date" value="<?php echo $start ?>">
						</div>
						<div class="col-md-2" id="bs_datepicker_container">
							<input type="text" id="finishdate" data-date-format="yyyy-mm-dd" class="date" value="<?php echo $now ?>">
						</div>
                    </div></br></br>
					
					<input type="hidden" name="item" id="item" value="<?php echo $_GET['item']?>">
					<input type="hidden" name="satuan" id="satuan" value="<?php echo $_GET['sat']?>">
					
					<div class="show_detail_history"></div>
					<div id="wait" style="display:none;width:70px;height:70px;border:0px solid black;position:absolute;top:50%;left:45%;padding:2px;">
						<img src='images/loading.gif' width="70" height="70" />
					</div>
					
					<a href="?page=history" class="btn btn-danger">Kembali</a>
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
		tampil_detail_history ();
		$('#department').on('change',function() {
			tampil_detail_history();
		});
		$('#startdate').on('changeDate', function() {
			tampil_detail_history();
		});
		$('#finishdate').on('changeDate', function() {
			tampil_detail_history();
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
				url: "functions/history/show_history.php",
				data: "",
				success: function(hasil) {
					$('.show_history').html(hasil);
				}
		});
}

function tampil_detail_history () {
		$(document).ajaxStart(function(){
			$("#wait").css("display", "block");
		});
		$(document).ajaxComplete(function(){
			$("#wait").css("display", "none");
		});
		var startdate = $("#startdate").val();
		var finishdate = $("#finishdate").val();
		var item =$('#item').val();
		var satuan =$('#satuan').val();
		var department =$('#department').val();
		$.ajax({
				type: 'POST',
				url: "functions/history/show_detail_history.php",
				data: "item="+item+"&satuan="+satuan+"&department="+department+"&startdate=" +startdate+ "&finishdate=" +finishdate,
				success: function(hasil) {
					$('.show_detail_history').html(hasil);
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
		var department =$('#department').val();
		$.ajax({
				type: 'POST',
				url: "functions/history/show_detail_barcode.php",
				data: "item="+item+"&satuan="+satuan+"&lot_number="+lot_number+"&ed="+ed+"&department="+department,
				success: function(hasil) {
					$('.show_detail_barcode').html(hasil);
				}
		});
}

</script>