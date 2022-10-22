<?php
include 'config/connect.php';
date_default_timezone_set('Asia/Jakarta');
$now	=date('Y-m-d');
$start =date('Y-m-d', strtotime('-1 month', strtotime($now)));
?>
	
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						DATA BARANG KELUAR
					</h2>
				</div>
					
				<div class="body">
					
					<div class="alert alert-success alert-dismissible" id="sukses" style="width:300px; height:50px; float:right; display:none;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color:white;">&times;</button>
						<h4><i class="icon fa fa-check"></i> <label id="pesan"></label></h4>
					</div>
					
					
					<div class="form-group form-float">
						<div class="col-md-6">
							<a href="?page=add_barangkeluar&act=add" class="btn btn-success" ><i class="material-icons">add</i> Tambah Data</a>
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
					
					<div class="show_barangkeluar"></div>
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
	
	
<!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>
<script>
$(document).ready(function(){
		tampil_list();
		//alert('y');
});

$(document).on('click','.batal_keluar',function(){  
	var id = $(this).attr('data');
	window.location.replace("index.php?page=batal_keluar&nosj="+id
);
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
				url: "functions/barang_keluar/show_barangkeluar.php",
				data: "startdate=" +startdate+ "&finishdate=" +finishdate,
				success: function(hasil) {
					$('.show_barangkeluar').html(hasil);
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

$(document).on('click', '.hapusbarangkeluar', function(){
		var no_barang_keluar = $(this).attr('data');
		//alert(no_barang_keluar);
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
							url : "functions/barang_keluar/f_barang_keluar.php", 
							data: "act=hapusbarangkeluar&no_barang_keluar=" + no_barang_keluar ,
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
		var no_trans = $(this).attr('data');
		var tgl = $(this).attr('tgl');
		var dept = $(this).attr('dept');
		var sub_dept = $(this).attr('sub_dept');
		var link_base ="functions/barang_keluar/c_barangkeluar.php?no_trans="+no_trans+"&tgl="+tgl+"&dept="+dept+"&sub_dept="+sub_dept;
		$('#pdf_view').attr('src', link_base);
		$('#modal_Cetak').modal('show');
		$('.modal-title').text('Cetak Barang Keluar');
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