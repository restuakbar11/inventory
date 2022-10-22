<?php
include 'config/connect.php';
?>
	
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						DATA SATUAN
						<a href="index.php?page=master_data" type="button" class="btn bg-cyan waves-effect right">Back to Master Data</a>
					</h2>
				</div>
					
				<div class="body">
					
					<div class="alert alert-success alert-dismissible" id="sukses" style="width:300px; height:50px; float:right; display:none;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color:white;">&times;</button>
						<h4><i class="icon fa fa-check"></i> <label id="pesan"></label></h4>
					</div>
					
					<a href="#" class="btn btn-success tambahsatuan" data-toggle="modal" ><i class="material-icons">add</i> Tambah Data</a></br></br>
					
					<div class="showsatuan"></div>
					<div id="waiting" style="display:none;width:70px;height:70px;border:0px solid black;position:absolute;top:50%;left:45%;padding:2px;">
						<img src='images/loading.gif' width="70" height="70" />
					</div>
					
				</div>
			</div>
		</div>
	</div>
	
	
	<!-- Default Size modal-->
	<div class="modal fade" id="modalsatuan" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="defaultModalLabel"></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4 control-label">Nama Satuan*</label>

						<div class="col-sm-8 ">
							<div class="form-line">
								<input type="text" class="form-control clearform satuan date" name="nm_satuan" id="nm_satuan" placeholder="Nama Satuan" autocomplete="off">
								<input type="hidden" class="form-control clearform satuan" name="act" id="act" >
								<input type="hidden" class="form-control clearform satuan" name="satuanID" id="satuanID" >
							</div>
						</div></br>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary waves-effect" id="save"></button>
					<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CLOSE</button>
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

function tampil_list () {
		$(document).ajaxStart(function(){
			$("#waiting").css("display", "block");
		});
		$(document).ajaxComplete(function(){
			$("#waiting").css("display", "none");
		});
		//alert(warehouse);
		$.ajax({
				type: 'POST',
				url: "functions/satuan/show_satuan.php",
				data: "",
				success: function(hasil) {
					$('.showsatuan').html(hasil);
				}
		});
}

$(".tambahsatuan").click(function(){
	clear ();
	$('#defaultModalLabel').text('Tambah Satuan');
    $("#modalsatuan").modal('show');
	$('#modalsatuan').on('shown.bs.modal', function () {
		$('#nm_satuan').focus();
	});
	$("#act").val('add');
	$('#save').text('SAVE');
});

function clear () {
	$('input[type=text].clearform').val('');
	$('input[type=password].clearform').val('');
	$('input[type=number].clearform').val('0');
}

$("#save").click(function(){
	var act = $('#act').val();
	var nm_satuan = $('#nm_satuan').val();
	if(nm_satuan=='') {
		Swal.fire({
			title: 'WARNING',
			text: 'Nama Satuan Masih Kosong...',
			type: 'warning',
			confirmButtonColor: "red",
			showCancelButton: false,
			allowOutsideClick: false,
			position: 'top'
		})
	} else {
		var satuan = {};
		$(".satuan").each(function(k,v){
				satuan[$(this).attr('name')] = $(this).val();
				//satuan[$(this).attr('name')] = $(this).is(':checkbox:checked') == true ? '1': $(this).val();
		});
		$.ajax({
				type: "POST", 
				url : "functions/satuan/f_satuan.php", 
                data: {act:'save', satuan:satuan},
                dataType: "json",			
            	success: function(data){
					if(data){
						if(data.hasil==0) {
							Swal.fire({
								title: 'GAGAL',
								text: 'Nama Satuan Sudah Ada...',
								type: 'warning',
								confirmButtonColor: "red",
								showCancelButton: false,
								allowOutsideClick: false,
								position: 'top'
							})
							$('#modalsatuan').modal('hide');
							tampil_list();
						} else {
							$('#modalsatuan').modal('hide');
							tampil_list();
							document.getElementById('sukses').style.display='block';
							if(act=='add') {
								$('#pesan').text('Insert Success!');
							} else {
								$('#pesan').text('Update Success!');
							}
						} 
					}
					else{
						alert("Error..");
					}
				}		
		});
	}
});


$(document).on('click', '.hapussatuan', function(){
	var satuanID = $(this).attr('data');
	Swal.fire({
		title: 'CONFIRM',
		text: "Apakah Anda Yakin ingin Menghapus Data ini ?",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		allowOutsideClick: false,
		confirmButtonText: 'Yes',
		position: 'top'
	}).then((result) => {
		if (result.value) {
			$.ajax({
						type: "POST", 
						url : "functions/satuan/f_satuan.php", 
						data: "act=hapus&satuanID=" + satuanID ,
						dataType: "json",			
						success: function(data){
							if(data){
								tampil_list();
								document.getElementById('sukses').style.display='block';
								$('#pesan').text('Delete Success!');
							}
							else{
								alert("Error");
							}
						}		
					});
		}
	})
});

$(document).on('click', '.editsatuan', function(){
	$('#defaultModalLabel').text('Edit Satuan');
	var satuanID = $(this).attr('data');
    $.ajax({
				type: "POST", 
				url : "functions/satuan/f_satuan.php", 
                data: "act=form&satuanID=" + satuanID ,
                dataType: "json",			
            	success: function(data){
					if(data){
						$('#satuanID').val(satuanID);
						$('#nm_satuan').val(data.NAMASATUAN);
						$('#act').val('update');
						$('#save').text('UPDATE');
					}
					else{
						alert("Error");
					}
				}		
			});
    $("#modalsatuan").modal('show');
});

</script>