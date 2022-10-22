<?php
include 'config/connect.php';
?>
	
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						DATA SUPPLIER
						<a href="index.php?page=master_data" type="button" class="btn bg-cyan waves-effect right">Back to Master Data</a>
					</h2>
				</div>
					
				<div class="body">
					
					<div class="alert alert-success alert-dismissible" id="sukses" style="width:300px; height:50px; float:right; display:none;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color:white;">&times;</button>
						<h4><i class="icon fa fa-check"></i> <label id="pesan"></label></h4>
					</div>
					
					<a href="#" class="btn btn-success tambahsupplier" data-toggle="modal" ><i class="material-icons">add</i> Tambah Data</a></br></br>
					
					<div class="showsupplier"></div>
					<div id="waiting" style="display:none;width:70px;height:70px;border:0px solid black;position:absolute;top:50%;left:45%;padding:2px;">
						<img src='images/loading.gif' width="70" height="70" />
					</div>
					
				</div>
			</div>
		</div>
	</div>
	
	
	<!-- Default Size modal-->
	<div class="modal fade" id="modalsupplier" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="defaultModalLabel"></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4 control-label">Nama Supplier*</label>

						<div class="col-sm-8 ">
							<div class="form-line">
								<input type="text" class="form-control clearform supplier date" name="nm_supplier" id="nm_supplier" placeholder="Nama Supplier" autocomplete="off">
								<input type="hidden" class="form-control clearform supplier" name="act" id="act" >
								<input type="hidden" class="form-control clearform supplier" name="supplierID" id="supplierID" >
							</div>
						</div></br>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4 control-label">Email Supplier*</label>

						<div class="col-sm-8 ">
							<div class="form-line">
								<input type="text" class="form-control clearform supplier date" name="email" id="email" placeholder="Email Supplier" autocomplete="off">
							</div>
						</div></br>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4 control-label">Alamat Supplier*</label>

						<div class="col-sm-8 ">
							<div class="form-line">
								<textarea name="alamat" id="alamat" class="form-control clearform supplier date"></textarea>
							</div>
						</div></br>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4 control-label">Contact Person*</label>

						<div class="col-sm-8 ">
							<div class="form-line">
								<input type="text" class="form-control clearform supplier date" name="person" id="person" placeholder="Contact Person" autocomplete="off">
							</div>
						</div></br>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4 control-label">Telp Supplier*</label>

						<div class="col-sm-8 ">
							<div class="form-line">
								<input type="number" class="form-control clearform supplier date" name="telp" id="telp" placeholder="Telp Supplier" autocomplete="off">
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
				url: "functions/supplier/show_supplier.php",
				data: "",
				success: function(hasil) {
					$('.showsupplier').html(hasil);
				}
		});
}

$(".tambahsupplier").click(function(){
	clear ();
	$('#defaultModalLabel').text('Tambah Supplier');
    $("#modalsupplier").modal('show');
	$('#modalsupplier').on('shown.bs.modal', function () {
		$('#nm_supplier').focus();
	});
	$("#act").val('add');
	$('#save').text('SAVE');
});

function clear () {
	$('input[type=text].clearform').val('');
	$('input[type=password].clearform').val('');
	$('input[type=number].clearform').val('');
	$('#alamat').val('');
}

$("#save").click(function(){
	var act = $('#act').val();
	var nm_supplier = $('#nm_supplier').val();
	var email = $('#email').val();
	var alamat = $('#alamat').val();
	var person = $('#person').val();
	var telp = $('#telp').val();
	var detek_at =email.indexOf("@");
	var detek_titik =email.lastIndexOf(".");
	//alert(detek_at+ ',' +detek_titik);
	if(nm_supplier=='' || email=='' || alamat=='' || person=='' || telp=='') {
		Swal.fire({
			title: 'WARNING',
			text: 'Lengkapi Form inputan yang bertanda * ...',
			type: 'warning',
			confirmButtonColor: "red",
			showCancelButton: false,
			allowOutsideClick: false,
			position: 'top'
		})
	} else if(detek_at<1 || detek_titik<detek_at+2) {
		Swal.fire({
			title: 'WARNING',
			text: 'Email tidak valid...',
			type: 'warning',
			confirmButtonColor: "red",
			showCancelButton: false,
			allowOutsideClick: false,
			position: 'top'
		})
	} else {
		var supplier = {};
		$(".supplier").each(function(k,v){
				supplier[$(this).attr('name')] = $(this).val();
				//supplier[$(this).attr('name')] = $(this).is(':checkbox:checked') == true ? '1': $(this).val();
		});
		$.ajax({
				type: "POST", 
				url : "functions/supplier/f_supplier.php", 
                data: {act:'save', supplier:supplier},
                dataType: "json",			
            	success: function(data){
					if(data){
						if(data.hasil==0) {
							Swal.fire({
								title: 'GAGAL',
								text: 'Nama Supplier Sudah Ada...',
								type: 'warning',
								confirmButtonColor: "red",
								showCancelButton: false,
								allowOutsideClick: false,
								position: 'top'
							})
							$('#modalsupplier').modal('hide');
							tampil_list();
						} else {
							$('#modalsupplier').modal('hide');
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


$(document).on('click', '.hapussupplier', function(){
	var supplierID = $(this).attr('data');
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
						url : "functions/supplier/f_supplier.php", 
						data: "act=hapus&supplierID=" + supplierID ,
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

$(document).on('click', '.editsupplier', function(){
	$('#defaultModalLabel').text('Edit Supplier');
	var supplierID = $(this).attr('data');
    $.ajax({
				type: "POST", 
				url : "functions/supplier/f_supplier.php", 
                data: "act=form&supplierID=" + supplierID ,
                dataType: "json",			
            	success: function(data){
					if(data){
						$('#supplierID').val(supplierID);
						$('#nm_supplier').val(data.NAMASUPPLIER);
						$('#email').val(data.EMAILSUPPLIER);
						$('#alamat').val(data.ADDRESSSUPPLIER);
						$('#telp').val(data.TELEPHONESUPPLIER);
						$('#person').val(data.SUPPLIERCONTACTPERSON);
						$('#act').val('update');
						$('#save').text('UPDATE');
					}
					else{
						alert("Error");
					}
				}		
			});
    $("#modalsupplier").modal('show');
});

</script>

<style>
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
</style>