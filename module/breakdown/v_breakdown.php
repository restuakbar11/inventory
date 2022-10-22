<?php
include 'config/connect.php';
date_default_timezone_set('Asia/Jakarta');
$now	=date('Y-m-d');
$start =date('Y-m-d', strtotime('-1 month', strtotime($now)));

Switch ($_GET['act'])
{
	default : ?>
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						DATA BREAKDOWN BARANG
					</h2>
				</div>
					
				<div class="body">
					
					<div class="form-group form-float">
						<div class="col-md-6">
							<a href="?page=add_breakdown&act=add" class="btn btn-success" ><i class="material-icons">add</i> Tambah Data</a>
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
					
					<div class="show_breakdown"></div>
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
	
	
	
	
	case "batal" : ?>
	<div class="row clearfix" >
		<input type="hidden" class="form-control date" name="no_breakdown" id="no_breakdown" value="<?php echo $_GET['id']?>" readonly style="background-color:#F0FFF0;">
		<input type="hidden" id="act" name="act" value="<?php echo $_GET['act']?>">
		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
			<div class="card">
				<div class="header">
					<h2>
						BATAL TRANSAKSI BREAKDOWN <font color="red"><b><?php echo $_GET['id']?></b></font>
					</h2>
					   
				</div>
				<div class="body">
					<div class="show_detail_item"></div>
					
					<div class="form-group">
						<div class="form-line">
							<label>Keterangan Batal</label>
							<textarea name="ket_batal" id="ket_batal" class="form-control" autofocus="on" placeholder="Keterangan" onkeyup="maxKet()"></textarea>
						</div>
					</div>
					<a href="#" class="btn btn-warning waves-effect batal">Batal</a>
					<a href="?page=breakdown" class="btn btn-danger waves-effect">Kembali</a>
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
		//alert('y');
		tampil_checkout();
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
		//alert(warehouse);
		$.ajax({
				type: 'POST',
				url: "functions/breakdown/show_breakdown.php",
				data: "startdate=" +startdate+ "&finishdate=" +finishdate,
				success: function(hasil) {
					$('.show_breakdown').html(hasil);
				}
		});
}

$(document).ready(function() {
		$('#startdate').on('changeDate', function() {
			tampil_list();
		});
		$('#finishdate').on('changeDate', function() {
			tampil_list();
		});
});

$(document).on('click', '.hapusbreakdown', function(){
		var no_breakdown = $(this).attr('data');
		//alert(no_breakdown);
		Swal.fire({
			title: 'CONFIRM',
			text: "Apakah Anda Yakin ingin Menghapus Data ini ?",
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
							url : "functions/breakdown/f_breakdown.php", 
							data: "act=hapusbreakdown&no_breakdown=" + no_breakdown ,
							dataType: "json",			
							success: function(data){
								if(data){
									tampil_list();
								}
								else{
									alert("Error");
								}
							}		
						});
			}
		})
});

$(document).ready(function() {
	$(".modal").on("hidden.bs.modal", function() {
		//$(".modal-body").html("");
		$(".modal-body").html("<embed src='' id='pdf_view' frameborder='0' width='100%' height='400px'>");
		document.getElementById("pdf_view").src='';
	});
});

$(document).on('click', '.cetak', function(){
		var no_breakdown = $(this).attr('data');
		var tgl_trans = $(this).attr('tgl');
		var dept = $(this).attr('dept');
		var link_base ="functions/breakdown/c_breakdown.php?no_breakdown="+no_breakdown+"&tgl_trans="+tgl_trans+"&dept="+dept;
		$('#pdf_view').attr('src', link_base);
		$('#modal_Cetak').modal('show');
		$('.modal-title').text('Cetak Breakdown');
});

function tampil_checkout() {
		var no_breakdown =$('#no_breakdown').val();
		var act =$('#act').val();
		$.ajax({
				type: 'POST',
				url: "functions/breakdown/show_detail_item.php",
				data: "no_breakdown="+no_breakdown+"&act="+act,
				success: function(hasil) {
					$('.show_detail_item').html(hasil);
				}
		});
}

$(document).on('click', '.viewbarcode', function(){
		$(document).ajaxStart(function(){
			$("#wait").css("display", "block");
		});
		$(document).ajaxComplete(function(){
			$("#wait").css("display", "none");
		});
		$('#defaultModalLabel').text('Detail Barcode');
		var nobreakdown_detail = $(this).attr('data');
		$.ajax({
					type: 'POST',
					url: "functions/breakdown/show_detail_barcode.php",
					data: "nobreakdown_detail="+nobreakdown_detail,
					success: function(hasil) {
						$('.show_detail_barcode').html(hasil);
					}
			});
		$("#modaldetailbarcode").modal('show');
});

function maxKet() {
		var ket_batal =$('#ket_batal').val();
		var jml_karakter =ket_batal.length;
		if(jml_karakter>100) {
			Swal.fire({
				title: 'WARNING',
				text: 'Max 100 Karakter...',
				type: 'warning',
				confirmButtonColor: "red",
				showCancelButton: false,
				allowOutsideClick: false,
				position: 'top'
			})
			var sub =ket_batal.substring(0, 100);
			$('#ket_batal').val(sub);
		}
}

$('.batal').click(function (){
		var no_breakdown =$('#no_breakdown').val();
		var ket_batal =$('#ket_batal').val();
		if(ket_batal=='') {
			Swal.fire({
				title: 'WARNING',
				text: 'Keterangan Batal tidak boleh kosong..',
				type: 'warning',
				confirmButtonColor: "red",
				showCancelButton: false,
				allowOutsideClick: false,
				position: 'top'
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
						url : "functions/breakdown/f_breakdown.php", 
						data: "act=batal_breakdown&no_breakdown=" +no_breakdown+"&ket_batal="+ket_batal ,
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
									$(location).attr('href','index.php?page=breakdown');
								}
							}
							else{
								alert("Error");
							}
						}		
					});
				}
			})
		}
});
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