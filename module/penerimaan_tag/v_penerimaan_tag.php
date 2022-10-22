<?php
include 'config/connect.php';
date_default_timezone_set('Asia/Jakarta');
$now	=date('Y-m-d');
$start =date('Y-m-d', strtotime('-1 month', strtotime($now)));
?>

<?php
switch ($_GET['act']){
default : ?>
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						PENERIMAAN TAG
					</h2>
				</div>
					
				<div class="body">
					
					<div class="alert alert-success alert-dismissible" id="sukses" style="width:300px; height:50px; float:right; display:none;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color:white;">&times;</button>
						<h4><i class="icon fa fa-check"></i> <label id="pesan"></label></h4>
					</div>
					<div class="form-group form-float">
						<div class="col-md-1" style="text-align:right;">
							<label>Status</label>
						</div>
						<div class="col-md-2">
							<select name="status" id="status" class="form-control">
								<option value="all" selected>ALL</option>
								<option value="belum diterima">Belum Diterima</option>
								<option value="sudah diterima">Sudah Diterima</option>
							</select>
						</div>
						<div class="col-md-3" style="text-align:right;">
							
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
					
					<div class="show_penerimaan_tag"></div>
					<div id="waiting" style="display:none;width:70px;height:70px;border:0px solid black;position:absolute;top:50%;left:45%;padding:2px;">
						<img src='images/loading.gif' width="70" height="70" />
					</div>
					
				</div>
			</div>
		</div>
	</div>
	
	
	<!-- Modal -->
	<div id="modal_Cetak" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog modal-lg" style="width:80%;">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">

					<embed src="" id="pdf_view"
						   frameborder="0" width="100%" height="400px">

					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>

			</div>
		</div>
	</div>
	<?php
break;



case "proses" : ?>
	<div class="row clearfix">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="top:50%;left: 50%;transform: translate(-50%);">
			<div class="card" >
				<div class="header">
					<h2>
						PROSES PENERIMAAN TAG
					</h2>
					   
				</div>
				<div class="body" class="ui-widget">
					
						<div class="form-group form-float">
								<div class="form-line">
									<label>No. Tag</label>
									<input type="text" class="form-control date" name="no_tag" id="no_tag" value="<?php echo $_GET['id']?>" readonly style="background-color:#F0FFF0;">
									<input type="hidden" id="act" name="act" value="<?php echo $_GET['act']?>">
								</div>
						</div>
						<div class="form-group form-float">
								<div class="form-line">
									<label>Gudang *</label>
									<div class="selectGudang"></div>
								</div>
						</div>
						<div class="form-group form-float">
								<div class="form-line">
									<label>Rak Gudang *</label>
									<div class="selectRakGudang"></div>
								</div>
						</div>
						<div class="form-group form-float">
								<div class="form-line">
									<label>Kode Barcode</label>
									<input type="text" class="form-control date" name="barcode" id="barcode" onkeypress="pressEnter(this, event)" autofocus="on" autocomplete="off">
								</div>
						</div>
					
				</div>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
			<div class="card">
				<div class="header">
					<h2>
						DETAIL ITEM
					</h2>
					   
				</div>
				<div class="body">
					<div class="show_checkin_tag"></div>
					
					
					<a href="?page=penerimaan_tag" class="btn btn-danger waves-effect">Kembali</a>
				</div>
			</div>
		</div>
	</div>
	<?php
break;


case "view" : ?>
	<div class="row clearfix">
		<input type="hidden" class="form-control date" name="no_tag" id="no_tag" value="<?php echo $_GET['id']?>" readonly style="background-color:#F0FFF0;">
		<input type="hidden" id="act" name="act" value="<?php echo $_GET['act']?>">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
			<div class="card">
				<div class="header">
					<h2>
						DETAIL ITEM
					</h2>
					   
				</div>
				<div class="body">
					<div class="show_checkin_tag"></div>
					
					
					<a href="?page=penerimaan_tag" class="btn btn-danger waves-effect">Kembali</a>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Default Size modal-->
	<div class="modal fade" id="modaldetailbarcode" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="defaultModalLabel"></h4>
				</div>
				<div class="modal-body">
					<div class="show_detail_barcode"></div>
					
					<div id="wait" style="display:none;width:70px;height:70px;border:0px solid black;position:absolute;top:50%;left:45%;padding:2px;">
						<img src='images/loading.gif' width="70" height="70" />
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CLOSE</button>
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
		tampil_checkin();
		selectGudang();
});

function tampil_list () {
		$(document).ajaxStart(function(){
			$("#waiting").css("display", "block");
		});
		$(document).ajaxComplete(function(){
			$("#waiting").css("display", "none");
		});
		var startdate = $("#startdate").val();
		var finishdate = $("#finishdate").val();
		var status = $("#status").val();
		$.ajax({
				type: 'POST',
				url: "functions/penerimaan_tag/show_penerimaan_tag.php",
				data: "startdate=" +startdate+ "&finishdate=" +finishdate+"&status="+status,
				success: function(hasil) {
					$('.show_penerimaan_tag').html(hasil);
				}
		});
}

function selectGudang() {
		var no_tag =$('#no_tag').val();
		$.ajax({
				type: 'POST',
				url: "functions/penerimaan_tag/queryGudangPerTag.php",
				data: "no_tag=" +no_tag,
				success: function(hasil) {
					$('.selectGudang').html(hasil);
				}
		});
}

$(document).on('change', '.myGudang', function(){
		var gudang =$('#gudang').val();
		$.ajax({
				type: 'POST',
				url: "functions/penerimaan_tag/queryRakGudang.php",
				data: "gudang=" +gudang,
				success: function(hasil) {
					$('.selectRakGudang').html(hasil);
				}
		});
});

$(document).ready(function() {
		$('#startdate').on('changeDate', function() {
			tampil_list();
		});
		$('#finishdate').on('changeDate', function() {
			tampil_list();
		});
		$('#status').on('change',function() {
			tampil_list();
		});
});

function tampil_checkin() {
		var no_tag =$('#no_tag').val();
		var act =$('#act').val();
		$.ajax({
				type: 'POST',
				url: "functions/penerimaan_tag/show_checkin_tag.php",
				data: "no_tag="+no_tag+"&act="+act,
				success: function(hasil) {
					$('.show_checkin_tag').html(hasil);
				}
		});
}

function pressEnter(inField, e) {
		var charCode;
		if(e && e.which){
			charCode = e.which;
		}else if(window.event){
			e = window.event;
			charCode = e.keyCode;
		}
		if(charCode == 13) {
			var no_tag =$('#no_tag').val();
			var barcode =$('#barcode').val();
			var gudang =$('#gudang').val();
			var rak_gudang =$('#rak_gudang').val();
			if(gudang==0 || rak_gudang==0) {
				Swal.fire({
					title: 'WARNING',
					text: 'Lengkapi Form inputan yang bertanda * ...',
					type: 'warning',
					confirmButtonColor: "red",
					showCancelButton: false,
					allowOutsideClick: false,
					position: 'top'
				})
			} else {
				$.ajax({
						type: "POST", 
						url : "functions/penerimaan_tag/f_penerimaan_tag.php", 
						data: "act=checkin_barcode&no_tag="+no_tag+"&barcode="+barcode+"&gudang="+gudang+"&rak_gudang="+rak_gudang,
						dataType: "json",			
						success: function(data){
							if(data){
								if(data.hasil==0) {
									Swal.fire({
										title: data.judul,
										text: data.ket,
										type: data.status,
										confirmButtonColor: "red",
										showCancelButton: false,
										allowOutsideClick: false,
										position: 'top'
									})
								} else {
									if(data.lengkap==0) {
										Swal.fire({
											title: "SUCCESS",
											text: "Berhasil",
											type: "success",
											confirmButtonColor: "blue",
											showCancelButton: false,
											allowOutsideClick: false,
											position: 'top'
										})
										tampil_checkin();
										$('#barcode').val('');
									} else {
										tampil_checkin();
										$('#barcode').val('');
										Swal.fire({
											title: 'CONFIRM',
											text: "Proses Check In Sudah Lengkap.. Apakah Anda ingin Kembali ke Halaman Awal ?",
											type: 'warning',
											showCancelButton: true,
											confirmButtonColor: '#3085d6',
											cancelButtonColor: '#d33',
											allowOutsideClick: false,
											confirmButtonText: 'Yes',
											position: 'center'
										}).then((result) => {
											if (result.value) {
												$(location).attr('href','index.php?page=penerimaan_tag');
											}
										})
									}
								} 
							}
							else{
								alert("Error..");
							}
						}		
				});
			}
		}
}

$(document).on('click', '.viewbarcode', function(){
		$(document).ajaxStart(function(){
			$("#wait").css("display", "block");
		});
		$(document).ajaxComplete(function(){
			$("#wait").css("display", "none");
		});
		$('#defaultModalLabel').text('Detail Barcode');
		var notag_detail = $(this).attr('data');
		$.ajax({
					type: 'POST',
					url: "functions/tag/show_detail_barcode.php",
					data: "notag_detail="+notag_detail,
					success: function(hasil) {
						$('.show_detail_barcode').html(hasil);
					}
			});
		$("#modaldetailbarcode").modal('show');
});
/*
$(document).ready(function() {
	$(".modal").on("hidden.bs.modal", function() {
		//$(".modal-body").html("");
		$(".modal-body").html("<embed src='' id='pdf_view' frameborder='0' width='100%' height='400px'>");
		document.getElementById("pdf_view").src='';
	});
});

$(document).on('click', '.cetak', function(){
		var no_penerimaan_tag = $(this).attr('data');
		var tgl_kirim = $(this).attr('tgl_kirim');
		var tgl_terima = $(this).attr('tgl_terima');
		var asal = $(this).attr('asal');
		var tujuan = $(this).attr('tujuan');
		var link_base ="functions/penerimaan_tag/c_penerimaan_tag.php?no_penerimaan_tag="+no_penerimaan_tag+"&tgl_kirim="+tgl_kirim+"&tgl_terima="+tgl_terima+"&tujuan="+tujuan+"&asal="+asal;
		$('#pdf_view').attr('src', link_base);
		$('#modal_Cetak').modal('show');
		$('.modal-title').text('Cetak Penerimaan TAG');
});*/
</script>

<style>
.modal-header{
    background-color: orange;
}
.modal-title{
    color: white;
}
.close{
    color: white;
}
.modal-footer{
    background-color: #A9A9A9;
}
</style>