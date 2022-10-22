<?php
include 'config/connect.php';
?>
	
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						DATA ITEM
						<a href="index.php?page=master_data" type="button" class="btn bg-cyan waves-effect right">Back to Master Data</a>
					</h2>
				</div>
					
				<div class="body">
					
					<div class="alert alert-success alert-dismissible" id="sukses" style="width:300px; height:50px; float:right; display:none;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color:white;">&times;</button>
						<h4><i class="icon fa fa-check"></i> <label id="pesan"></label></h4>
					</div>
					
					<a href="#" class="btn btn-success tambahitem" data-toggle="modal" ><i class="material-icons">add</i> Tambah Data</a></br></br>
					
					<div class="showitem"></div>
					<div id="waiting" style="display:none;width:70px;height:70px;border:0px solid black;position:absolute;top:50%;left:45%;padding:2px;">
						<img src='images/loading.gif' width="70" height="70" />
					</div>
					
				</div>
			</div>
		</div>
	</div>
	
	
	<!-- Default Size modal-->
	<div class="modal fade" id="modalitem" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="defaultModalLabel"></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Kelompok Item*</label>

						<div class="col-sm-8 ">
							<div class="form-line">
		                      <select class="form-control item" name="item_idkelompok" id="item_idkelompok" style="background-color:red;">
                                    <option style="align:center;" value="0">Pilih Kelompok Item</option>
								<?php
								include 'functions/queryKelompokItem.php';
								while ($i =mysqli_fetch_array($queryKelompokItem)) { ?>
									<option style="align:center;" value="<?php echo $i['IDKELOMPOKITEM']?>"><?php echo $i['NAMAKELOMPOKITEM']?></option>
									<?php
								} ?>
							 </select>
                            </div>
						</div></br>
						<label for="inputEmail3" class="col-sm-4 control-label">Kode Item*</label>

						<div class="col-sm-8 ">
							<div class="form-line">
								<input type="text" class="form-control clearform item date" name="iditem" id="iditem" placeholder="Kode Item" autocomplete="off">
								<input type="hidden" class="form-control clearform item" name="act" id="act" >
							</div>
						</div></br>
                        <label for="inputEmail3" class="col-sm-4 control-label">Nama Item*</label>
                        <div class="col-sm-8 ">
							<div class="form-line">
								<input type="text" class="form-control clearform item date" name="namaitem" id="namaitem" placeholder="Nama Item" autocomplete="off">
							</div>
						</div></br>
                        <label for="inputEmail3" class="col-sm-4 control-label">Satuan* <font color="red" size="1px">multi select</font></label>
                        <div class="col-sm-8 ">
							<div class="form-line">
							<select class="form-control show-tick clearform item" name="idsatuan" id="idsatuan" multiple>
                                   
								<?php
								include 'functions/querySatuan.php';
								while ($u =mysqli_fetch_array($querySatuan)) { ?>
									<option style="align:center;" value="<?php echo $u['IDSATUAN']?>"><?php echo $u['NAMASATUAN']?></option>
									<?php
								} ?>
							</select>
                            </div>
						</div></br></br>
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
				url: "functions/item/show_item.php",
				data: "",
				success: function(hasil) {
					$('.showitem').html(hasil);
				}
		});
}

$(".tambahitem").click(function(){
	clear ();
	$('#defaultModalLabel').text('Tambah item');
    $("#modalitem").modal('show');
	$('#modalitem').on('shown.bs.modal', function () {
		$('#nm_item').focus();
	});
	$("#act").val('add');
	$('#save').text('SAVE');
});

function clear () {
	$('input[type=text].clearform').val('');
	$('input[type=password].clearform').val('');
	$('input[type=number].clearform').val('0');
	$('select.clearform').val('0').change();
    $('#iditem').removeAttr('disabled');
	$('#iditem').css('background-color','white');
}

$("#save").click(function(){
	var act = $('#act').val();
	var item_idkelompok = $('#item_idkelompok').val();
	var iditem = $('#iditem').val();
	var namaitem = $('#namaitem').val();
	var idsatuan = $('select[name=idsatuan]').val();
	//alert(idsatuan);
	if(iditem=='' || item_idkelompok=='0' || namaitem=='' || idsatuan==null) {
		Swal.fire({
			title: 'WARNING',
			text: 'Tanda * Wajib Di isi...',
			type: 'warning',
			confirmButtonColor: "red",
			showCancelButton: false,
			allowOutsideClick: false,
			position: 'top'
		})
		//alert(idsatuan);
	} else {
		var item = {};
		$(".item").each(function(k,v){
				item[$(this).attr('name')] = $(this).val();
				//item[$(this).attr('name')] = $(this).is(':checkbox:checked') == true ? '1': $(this).val();
		});
		$.ajax({
				type: "POST", 
				url : "functions/item/f_item.php", 
                data: {act:'save',item:item},
                dataType: "json",			
            	success: function(data){
					if(data){
						if(data.hasil==0) {
							Swal.fire({
								title: 'GAGAL',
								text: 'Kode Item Sudah Ada...',
								type: 'warning',
								confirmButtonColor: "red",
								showCancelButton: false,
								allowOutsideClick: false,
								position: 'top'
							})
							$('#modalitem').modal('hide');
							tampil_list();
						} else {
							$('#modalitem').modal('hide');
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


$(document).on('click', '.hapusitem', function(){
	var itemID = $(this).attr('data');
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
						url : "functions/item/f_item.php", 
						data: "act=hapus&itemID=" + itemID ,
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

$(document).on('click', '.edititem', function(){
	$('#defaultModalLabel').text('Edit item');
	var itemID = $(this).attr('data');
    $.ajax({
				type: "POST", 
				url : "functions/item/f_item.php", 
                data: "act=form&itemID=" + itemID ,
                dataType: "json",			
            	success: function(data){
					if(data){
						$('#iditem').val(data.IDITEM).attr('disabled','true');
						$('#iditem').css('background-color','#F0FFF0');
						$('#namaitem').val(data.NAMAITEM);
						//$('#idsatuan').val(data.ITEM_IDSATUAN).change();
						var values = data.ITEM_IDSATUAN;
						$('#idsatuan').val(values.split(',')).change();
						//$('#item_idkelompok option[value='+data.ITEM_IDKELOMPOKITEM+']').attr('selected','selected');
						$('#item_idkelompok').val(data.ITEM_IDKELOMPOKITEM).change();
						$('#act').val('update');
						$('#save').text('UPDATE');
					}
					else{
						alert("Error");
					}
				}		
			});
    $("#modalitem").modal('show');
});

</script>