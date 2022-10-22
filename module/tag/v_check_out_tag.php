<div class="row clearfix" >
	<input type="hidden" class="form-control date" name="no_tag" id="no_tag" value="<?php echo $_GET['id']?>" readonly style="background-color:#F0FFF0;">
	<input type="hidden" id="act" name="act" value="<?php echo $_GET['act']?>">
	<?php
	if($_GET['act']=='proses') { ?>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="top:50%;left: 50%;transform: translate(-50%);">
			<div class="card" >
				<div class="header">
					<h2>
						CHECK OUT BARCODE TAG
					</h2>
					   
				</div>
				<div class="body" class="ui-widget">
					
						<div class="form-group form-float">
								<div class="form-line">
									<label>No. Tag</label>
									<input type="text" class="form-control date" value="<?php echo $_GET['id']?>" readonly style="background-color:#F0FFF0;">
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
		<?php
	} ?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
        <div class="card">
            <div class="header">
                <h2>
                    DETAIL ITEM
                </h2>
                   
            </div>
            <div class="body">
				<div class="show_checkout_tag"></div>
				
				
				<a href="?page=tag" class="btn btn-danger waves-effect">Kembali</a>
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

<!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

<script>
$(document).ready(function(){
		tampil_checkout();
});

function tampil_checkout() {
		var no_tag =$('#no_tag').val();
		var act =$('#act').val();
		$.ajax({
				type: 'POST',
				url: "functions/tag/show_checkout_tag.php",
				data: "no_tag="+no_tag+"&act="+act,
				success: function(hasil) {
					$('.show_checkout_tag').html(hasil);
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
			$.ajax({
					type: "POST", 
					url : "functions/tag/f_tag.php", 
					data: "act=checkout_barcode&no_tag="+no_tag+"&barcode="+barcode,
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
									tampil_checkout();
									$('#barcode').val('');
								} else {
									tampil_checkout();
									$('#barcode').val('');
									Swal.fire({
										title: 'CONFIRM',
										text: "Proses Check Out Sudah Lengkap.. Apakah Anda ingin Kembali ke Halaman Awal ?",
										type: 'warning',
										showCancelButton: true,
										confirmButtonColor: '#3085d6',
										cancelButtonColor: '#d33',
										allowOutsideClick: false,
										confirmButtonText: 'Yes',
										position: 'center'
									}).then((result) => {
										if (result.value) {
											$(location).attr('href','index.php?page=tag');
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