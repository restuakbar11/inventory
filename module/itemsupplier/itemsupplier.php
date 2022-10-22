<?php
include 'config/connect.php';
?>
	
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						DATA ITEM SUPPLIER
						<a href="index.php?page=master_data" type="button" class="btn bg-cyan waves-effect right">Back to Master Data</a>
					</h2>
				</div>
					
				<div class="body">
					
					<div class="alert alert-success alert-dismissible" id="sukses" style="width:300px; height:50px; float:right; display:none;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color:white;">&times;</button>
						<h4><i class="icon fa fa-check"></i> <label id="pesan"></label></h4>
					</div>
					
					<a href="#" class="btn btn-success tambahitemsupplier" data-toggle="modal" ><i class="material-icons">add</i> Tambah Data</a></br></br>
					
					<div class="showitemsupplier"></div>
					<div id="waiting" style="display:none;width:70px;height:70px;border:0px solid black;position:absolute;top:50%;left:45%;padding:2px;">
						<img src='images/loading.gif' width="70" height="70" />
					</div>
					
				</div>
			</div>
		</div>
	</div>
	
	
	<!-- Default Size modal-->
	<div class="modal fade" id="modalitemsupplier" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
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
								<select name="supplier" id="supplier" class="form-control show-tick clearform itemsupplier " data-live-search="on">
									<option style="margin-left:20px;" value="0" selected="selected">--Pilih Supplier--</option>
									<?php 
									include 'functions/itemsupplier/querySupplier.php';
									while ($s =mysqli_fetch_array($querySupplier)) { ?>
										<option style="margin-left:20px;" value="<?php echo $s['IDSUPPLIER'] ?>"><?php echo $s['NAMASUPPLIER'] ?></option>
									<?php
									} ?>
								</select>
								<input type="hidden" class="form-control clearform itemsupplier" name="act" id="act" >
								<input type="hidden" class="form-control clearform itemsupplier" name="itemsupplierID" id="itemsupplierID" >
							</div>
						</div></br>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4 control-label">Nama Item*</label>

						<div class="col-sm-8 ">
							<div class="form-line">
								<select name="item" id="item" class="form-control show-tick clearform itemsupplier " data-live-search="on">
									<option style="margin-left:20px;" value="0" selected="selected">--Pilih Item--</option>
									<?php 
									include 'functions/itemsupplier/queryItem.php';
									while ($i =mysqli_fetch_array($queryItem)) { ?>
										<option style="margin-left:20px;" value="<?php echo $i['IDITEM'] ?>"><?php echo $i['NAMAITEM'] ?></option>
									<?php
									} ?>
								</select>
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
				url: "functions/itemsupplier/show_itemsupplier.php",
				data: "",
				success: function(hasil) {
					$('.showitemsupplier').html(hasil);
				}
		});
}

$(".tambahitemsupplier").click(function(){
	clear ();
	$('#defaultModalLabel').text('Tambah Item Supplier');
    $("#modalitemsupplier").modal('show');
	$('#modalitemsupplier').on('shown.bs.modal', function () {
		$('#supplier').focus();
	});
	$("#act").val('add');
	$('#save').text('SAVE');
});

function clear () {
	$('input[type=text].clearform').val('');
	$('input[type=password].clearform').val('');
	$('input[type=number].clearform').val('');
}

$("#save").click(function(){
	var act = $('#act').val();
	var supplier = $('#supplier').val();
	var item = $('#item').val();
	//alert(detek_at+ ',' +detek_titik);
	if(supplier==0 || item==0) {
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
		var itemsupplier = {};
		$(".itemsupplier").each(function(k,v){
				itemsupplier[$(this).attr('name')] = $(this).val();
				//itemsupplier[$(this).attr('name')] = $(this).is(':checkbox:checked') == true ? '1': $(this).val();
		});
		$.ajax({
				type: "POST", 
				url : "functions/itemsupplier/f_itemsupplier.php", 
                data: {act:'save', itemsupplier:itemsupplier},
                dataType: "json",			
            	success: function(data){
					if(data){
						if(data.hasil==0) {
							Swal.fire({
								title: 'GAGAL',
								text: 'Item Supplier Sudah Terdaftar...',
								type: 'warning',
								confirmButtonColor: "red",
								showCancelButton: false,
								allowOutsideClick: false,
								position: 'top'
							})
							$('#modalitemsupplier').modal('hide');
							tampil_list();
						} else {
							$('#modalitemsupplier').modal('hide');
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


$(document).on('click', '.hapusitemsupplier', function(){
	var itemsupplierID = $(this).attr('data');
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
						url : "functions/itemsupplier/f_itemsupplier.php", 
						data: "act=hapus&itemsupplierID=" + itemsupplierID ,
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

$(document).on('click', '.edititemsupplier', function(){
	$('#defaultModalLabel').text('Edit Item Supplier');
	var itemsupplierID = $(this).attr('data');
    $.ajax({
				type: "POST", 
				url : "functions/itemsupplier/f_itemsupplier.php", 
                data: "act=form&itemsupplierID=" + itemsupplierID ,
                dataType: "json",			
            	success: function(data){
					if(data){
						$('#itemsupplierID').val(itemsupplierID);
						$('#supplier').val(data.ITEMSUPPLIER_IDSUPPLIER).change();
						$('#item').val(data.ITEMSUPPLIER_IDITEM).change();
						$('#act').val('update');
						$('#save').text('UPDATE');
					}
					else{
						alert("Error");
					}
				}		
			});
    $("#modalitemsupplier").modal('show');
});

</script>