<?php
include 'config/connect.php';
include "functions/numbering/f_numbering.php";
session_start();
$conn ="config/connect.php";
$numbering =Cek_Numbering('Breakdown', $conn);
$username = $_SESSION['username'];

if($_GET['act']=='add') {
	$number =$numbering;
} else if($_GET['act']=='update' || $_GET['act']=='validasi') {
	$number =$_GET['id'];
}
?>

<div class="row clearfix">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" >
        <div class="card" style="min-height:520px;">
            <div class="header">
                <h2>
                    INPUT BREAKDOWN BARANG
                </h2>
                   
            </div>
            <div class="body" class="ui-widget">
                
                    <div class="form-group form-float">
						<div class="col-md-6">
							<div class="input-group">
								<div class="form-line">
									<label>No. Breakdown</label>
								   <input type="text" class="form-control date" name="no_breakdown" id="no_breakdown" value="<?php echo $number?>" readonly style="background-color:#F0FFF0;">
								   <input type="hidden" name="act" id="act" value="<?php echo $_GET['act']?>">
								   <input type="hidden" name="userid" id="userid" value="<?php echo $username ?>">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="input-group">
								<div class="form-line" id="bs_datepicker_container">
									<label>Tanggal *</label>
									<input type="text" data-date-format="yyyy-mm-dd" class="form-control date" name="tanggal" id="tanggal" value="<?php echo date('Y-m-d');?>" >
								</div>
							</div>
						</div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
							<label>Department *</label>
                                <?php
								include 'functions/breakdown/queryDepartmentPerSession.php';
								$u =mysqli_fetch_array($queryDepartmentPerSession); ?>
							<input type="text" class="form-control date" name="nm_department" id="nm_department" value="<?php echo $u['NAMA_DEPARTMENT']?>" readonly style="background-color:#F0FFF0;">
							<input type="hidden" class="form-control date" name="id_department" id="id_department" value="<?php echo $u['ID_DEPARTMENT']?>" >
                        </div>
                    </div>

                     <div class="form-group form-float">
                            <div class="form-line">
								<label>Note</label>
                                <textarea rows="4" class="form-control no-resize" placeholder="Note..." id="note" name="note"></textarea>
                            </div>
                    </div>
                        
                    <button class="btn btn-primary waves-effect" id="save_header" type="button" >NEXT<i class="material-icons">forward</i></button> 
                
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" id="addItem" style="display:none;">
        <div class="card" style="min-height:520px;">
            <div class="header">
                <h2>
                    INPUT ITEM DISINI
                </h2>
                   
            </div>
            <div class="body">
                
                    <div class="form-group form-float">
                            <div class="form-line">
								<label>Kode Barcode *</label>
                                <input type="text" name="kodebarcode" id="kodebarcode" class="form-control" placeholder="Scan Kode Barcode" onkeypress="pressEnter(this, event)" autocomplete="off">
                            </div>
                    </div>
					<div class="form-group form-float">
                        <div class="col-md-6">
							<div class="input-group">
								<div class="form-line" >
									<label>Kode Item</label>
									<input type="text" class="form-control" name="id_item" id="id_item" readonly style="background-color:#F0FFF0;">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="input-group">
								<div class="form-line" >
									<label>Nama Item</label>
									<input type="text" class="form-control" name="nm_item" id="nm_item" readonly style="background-color:#F0FFF0;">
								</div>
							</div>
						</div>
                    </div> 
					<div class="form-group form-float">
						<div class="col-md-6">
							<div class="input-group">
								<div class="form-line" >
									<label>Quantity Awal</label>
									<input type="text" class="form-control" name="qty_awal" id="qty_awal" value="1" readonly style="background-color:#F0FFF0;">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="input-group">
								<div class="form-line ">
									<label>Satuan Awal</label>
									<input type="hidden" class="form-control" name="id_satuan" id="id_satuan">
									<input type="text" class="form-control" name="nm_satuan" id="nm_satuan" readonly style="background-color:#F0FFF0;">
								</div>
							</div>
						</div>
                    </div>
					<div class="form-group form-float">
						<div class="col-md-6">
							<div class="input-group">
								<div class="form-line" >
									<label>Quantity Baru *</label>
									<input type="number" class="form-control" name="qty_akhir" id="qty_akhir" oninput="cekQty()">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="input-group">
								<div class="form-line" >
									<label>Satuan Baru *</label>
									<select class="form-control" name="id_satuan_akhir" id="id_satuan_akhir" data-live-search="on" onchange="mySatuan()">
										<option style="margin-left:20px;" value="0">-PILIH SATUAN-</option>
										<?php 
										include 'functions/breakdown/querySatuan.php';
										while ($s =mysqli_fetch_array($querySatuan)) { ?>
											<option style="margin-left:20px;" value="<?php echo $s['IDSATUAN']?>"><?php echo $s['NAMASATUAN']?></option>
											<?php
										} ?>
									</select>
								</div>
							</div>
						</div>
					</div>
                    
                    <button class="btn btn-primary waves-effect" id="save_item" type="button" >Add Item<i class="material-icons">forward</i></button>                     
                    <button class="btn btn-danger waves-effect" id="reset" type="button" >Reset<i class="material-icons">cached</i></button>                     
                
            </div>
        </div>
    </div>
	
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="detailItem" style="display:none;">
        <div class="card">
            <div class="header">
                <h2>
                    DETAIL ITEM
                </h2>
                   
            </div>
            <div class="body">
				<div class="show_detail_item"></div>
				
				<div class="btn-group">
				<button class="btn btn-success waves-effect" id="validasi_breakdown" type="button" style="display:none;">Validasi</button> 
				<a href="?page=breakdown" id="kembali" class="btn btn-danger waves-effect">Kembali</a>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

<script>
$(document).ready(function(){
		var act =$('#act').val();
		var no_breakdown =$('#no_breakdown').val();
		if(act=='add'){
			$("#addItem").css("display", "none");
			$("#detailItem").css("display", "none");
			$("#save_header").css("display", "block");
		} else if(act=='update') {
			$.ajax({
					type: 'POST',
					url: "functions/breakdown/f_breakdown.php",
					data: "act=getHeader&no_breakdown="+no_breakdown,
					dataType: "json",	
					success: function(data) {
						if(data) {
							$('#tanggal').val(data.TANGGAL);
							$('#note').val(data.NOTE);
							$('#id_department').val(data.ID_DEPARTMENT).change();
						}
					}
			});
			$("#addItem").css("display", "block");
			$("#detailItem").css("display", "block");
			$("#save_header").css("display", "none");
			//$("#save_header").text("UPDATE HEADER");
			$("#kembali").text("SELESAI");
			$('#no_breakdown').attr('readonly', 'readonly');
			$('#tanggal').attr('readonly', 'readonly');
			//$('#id_department').attr('readonly', 'readonly');
			$('#note').attr('readonly', 'readonly');
			$('#kodebarcode').focus();
			tampil_detail_item ();
		} else if(act=='validasi') {
			$.ajax({
					type: 'POST',
					url: "functions/breakdown/f_breakdown.php",
					data: "act=getHeader&no_breakdown="+no_breakdown,
					dataType: "json",	
					success: function(data) {
						if(data) {
							$('#tanggal').val(data.TANGGAL);
							$('#note').val(data.NOTE);
							$('#id_department').val(data.ID_DEPARTMENT).change();
						}
					}
			});
			$("#addItem").css("display", "block");
			$("#detailItem").css("display", "block");
			$("#save_header").css("display", "none");
			$("#save_item").css("display", "none");
			$("#validasi_breakdown").css("display", "block");
			$('select.form-control').attr('disabled', 'disabled');
			$('input.form-control').attr('disabled', 'disabled');
			$('textarea.form-control').attr('disabled', 'disabled');
			tampil_detail_item ();
		}
});


$('#save_header').click(function (){
		var act =$('#act').val();
		var no_breakdown =$('#no_breakdown').val();
		var tanggal =$('#tanggal').val();
		var id_department =$('#id_department').val();
		var note =$('#note').val();
		if(tanggal=='' || id_department==0 || id_department==null) {
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
			//$(location).attr('href','index.php?page=add_breakdown&act=update&id='+no_breakdown);
			$.ajax({
					type: "POST", 
					url : "functions/breakdown/f_breakdown.php", 
					data: "act=save_header&aksi="+act+"&tanggal="+tanggal+"&id_department="+id_department+"&note="+note+"&no_breakdown="+no_breakdown,
					dataType: "json",			
					success: function(data){
						if(data){
							if(data.hasil==0) {
								Swal.fire({
									title: 'FAILED',
									text: 'Gagal Menyimpan..',
									type: 'error',
									confirmButtonColor: "red",
									showCancelButton: false,
									allowOutsideClick: false,
									position: 'top'
								})
							} else {
								$(location).attr('href','index.php?page=add_breakdown&act=update&id='+no_breakdown);
								
							} 
						}
						else{
							alert("Error..");
						}
					}		
			});
			
		}
		
});

function pressEnter(inField, e) {
		var charCode;
		if(e && e.which){
			charCode = e.which;
		}else if(window.event){
			e = window.event;
			charCode = e.keyCode;
		}
		if(charCode == 13) {
			var kodebarcode =$('#kodebarcode').val();
			var id_department =$('#id_department').val();
			$.ajax({
					type: "POST", 
					url : "functions/breakdown/f_breakdown.php", 
					data: "act=scan_barcode&kodebarcode="+kodebarcode+"&id_department="+id_department,
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
								reset();
							} else {
								$('#id_item').val(data.M_ITEMIDITEM);
								$('#nm_item').val(data.NAMAITEM);
								$('#id_satuan').val(data.M_SATUANIDSATUAN);
								$('#nm_satuan').val(data.NAMASATUAN);
								$('#qty_akhir').focus();
							} 
						}
						else{
							alert("Error..");
						}
					}		
			});
		}
}

$('#save_item').click(function (){
		var no_breakdown =$('#no_breakdown').val();
		var kodebarcode =$('#kodebarcode').val();
		var id_item =$('#id_item').val();
		var nm_item =$('#nm_item').val();
		var id_satuan =$('#id_satuan').val();
		var id_satuan_akhir =$('#id_satuan_akhir').val();
		var qty_awal =$('#qty_awal').val();
		var qty_akhir =$('#qty_akhir').val();
		if(kodebarcode=='' || id_item=='' || nm_item=='' || id_satuan=='' || qty_awal=='' || qty_awal==0 || qty_akhir=='' || qty_akhir==0 || id_satuan_akhir==0) {
			Swal.fire({
				title: 'WARNING',
				text: 'Lengkapi Form inputan yang bertanda * ...',
				type: 'warning',
				confirmButtonColor: "red",
				showCancelButton: false,
				allowOutsideClick: false,
				position: 'top'
			})
		} else if(id_satuan_akhir==id_satuan) {
			Swal.fire({
				title: 'WARNING',
				text: 'Satuan Baru tidak boleh sama dengan Satuan Awal...',
				type: 'warning',
				confirmButtonColor: "red",
				showCancelButton: false,
				allowOutsideClick: false,
				position: 'top'
			})
		} else {
			$.ajax({
					type: "POST", 
					url : "functions/breakdown/f_breakdown.php", 
					data: "act=save_item&kodebarcode="+kodebarcode+"&id_item="+id_item+"&id_satuan="+id_satuan+"&id_satuan_akhir="+id_satuan_akhir+
							"&qty_awal="+qty_awal+"&qty_akhir="+qty_akhir+"&no_breakdown="+no_breakdown,
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
								reset();
							} else {
								tampil_detail_item ();
								reset();
								$('#kodebarcode').focus();
							} 
						}
						else{
							alert("Error..");
						}
					}		
			});
			
		}
		
});

function reset() {
		$('#kodebarcode').val('');
		$('#id_item').val('');
		$('#nm_item').val('');
		$('#id_satuan_akhir').val('0').change();
		$('#id_satuan').val('');
		$('#nm_satuan').val('');
		$('#qty_akhir').val('');
}

$('#reset').click(function () {
		reset();
		$('#kodebarcode').focus();
});

function tampil_detail_item () {
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

function cekQty () {
		var qty_akhir =$('#qty_akhir').val();
		if(parseInt(qty_akhir)<0) {
			$('#qty_akhir').val(0);
		}
}

function mySatuan() {
		var id_satuan =$('#id_satuan').val();
		var id_satuan_akhir =$('#id_satuan_akhir').val();
		if(id_satuan_akhir==id_satuan) {
			Swal.fire({
				title: 'WARNING',
				text: 'Satuan Baru tidak boleh sama dengan Satuan Awal..',
				type: 'warning',
				confirmButtonColor: "red",
				showCancelButton: false,
				allowOutsideClick: false,
				position: 'top'
			})
			$('#id_satuan_akhir').val('0').change();
		}
}

$(document).on('click', '.hapusitem', function(){
		var nobreakdown_detail = $(this).attr('data');
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
							data: "act=hapusitem&nobreakdown_detail=" + nobreakdown_detail ,
							dataType: "json",			
							success: function(data){
								if(data){
									tampil_detail_item();
								}
								else{
									alert("Error");
								}
							}		
						});
			}
		})
});

$('#validasi_breakdown').click(function (){
		var no_breakdown =$('#no_breakdown').val();
		var jml_data =$('#jml_data').val();
		//alert(jml_data);
		if(jml_data<1) {
			Swal.fire({
				title: 'WARNING',
				text: 'Data Item Masih Kosong..',
				type: 'warning',
				confirmButtonColor: "red",
				showCancelButton: false,
				allowOutsideClick: false,
				position: 'top'
			})
		} else {
			Swal.fire({
				title: 'CONFIRM',
				text: "Apakah Anda akan Validasi Data ini ?",
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
								data: "act=validasi_breakdown&no_breakdown=" + no_breakdown ,
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