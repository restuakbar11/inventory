<?php
include 'config/connect.php';
include "functions/numbering/f_numbering.php";
session_start();
$conn ="config/connect.php";
$numbering =Cek_Numbering('Tag', $conn);
$username = $_SESSION['username'];

if($_GET['act']=='add') {
	$number =$numbering;
} else if($_GET['act']=='update' || $_GET['act']=='validasi') {
	$number =$_GET['id'];
}
?>

<div class="row clearfix">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" >
        <div class="card" style="min-height:450px;">
            <div class="header">
                <h2>
                    INPUT TAG
                </h2>
                   
            </div>
            <div class="body" class="ui-widget">
                
                    <div class="form-group form-float">
						<div class="col-md-6">
							<div class="input-group">
								<div class="form-line">
									<label>No. TAG</label>
								   <input type="text" class="form-control date" name="no_tag" id="no_tag" value="<?php echo $number?>" readonly style="background-color:#F0FFF0;">
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
                        <div class="col-md-6">
							<div class="input-group">
								<div class="form-line">
									<label>Department Pengirim</label>
										<?php
										include 'functions/department/queryDepartmentUtama.php';
										$z =mysqli_fetch_array($queryGetDepartment);?>
									<input type="text" class="form-control date" name="departmentUtama" id="departmentUtama" value="<?php echo $z['NAMA_DEPARTMENT']?>" readonly style="background-color:#F0FFF0;">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="input-group">
								<div class="form-line">
									<label>Department Tujuan *</label>
									<select class="form-control" data-live-search="on" name="id_department" id="id_department">
										<option style="margin-left:20px;" value="0">-- PILIH DEPARTMENT --</option>
										<?php
										include 'functions/tag/queryDepartmentTanpaGudangUtama.php';
										while ($u =mysqli_fetch_array($queryDepartmentTanpaGudangUtama)) { ?>
											<option style="margin-left:20px;" value="<?php echo $u['ID_DEPARTMENT']?>"><?php echo $u['NAMA_DEPARTMENT']?></option>
										<?php
										} ?>
									</select>
								</div>
							</div>
						</div>
                    </div>

                     <div class="form-group form-float">
                            <div class="form-line">
								<label>Note</label>
                                <textarea rows="2" class="form-control no-resize" placeholder="Note..." id="note" name="note"></textarea>
                            </div>
                    </div>
                        
                    <button class="btn btn-primary waves-effect" id="save_header" type="button" >NEXT<i class="material-icons">forward</i></button> 
                
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" id="addItem" style="display:none;">
        <div class="card" style="min-height:450px;">
            <div class="header">
                <h2>
                    INPUT ITEM DISINI
                </h2>
                   
            </div>
            <div class="body">
                
                    <div class="form-group form-float">
                            <div class="form-line">
                                <select class="form-control" name="item" id="item" data-live-search="on" onchange="myItem()">
                                    <option style="margin-left:20px;" value="0">-- PILIH ITEM --</option>
                                    <?php
                                include 'functions/itemsupplier/queryItem.php';
                                while ($u =mysqli_fetch_array($queryItem)) { ?>
                                    <option style="margin-left:20px;" value="<?php echo $u['IDITEM']?>"><?php echo $u['NAMAITEM']?></option>
                                <?php
                                } ?>
                                </select>
                            </div>
                    </div>
					<div class="form-group form-float">
                            <div class="form-line">
                                <div class="queryLotNumber"></div>
                            </div>
                    </div> 
					<div class="form-group form-float">
						<div class="col-md-4">
							<div class="input-group">
								<div class="form-line" >
									<label>Stock *</label>
									<input type="text" class="form-control" name="stock" id="stock" readonly style="background-color:#F0FFF0;">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="input-group">
								<div class="form-line ">
									<label>Satuan *</label>
									<input type="hidden" class="form-control" name="id_satuan" id="id_satuan">
									<input type="text" class="form-control" name="nm_satuan" id="nm_satuan" readonly style="background-color:#F0FFF0;">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="input-group">
								<div class="form-line">
									<label>Expire Date</label>
									<input type="text" class="form-control" name="ed" id="ed" readonly style="background-color:#F0FFF0;">
								</div>
							</div>
						</div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
							<label>Quantity *</label>
						   <input type="number" class="form-control" name="qty" id="qty" autocomplete="off" oninput="cekQty()">
                        </div>
                    </div> 
                    
                    <button class="btn btn-primary waves-effect" id="save_item" type="button" >Add Item<i class="material-icons">forward</i></button>                     
                
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
				<button class="btn btn-success waves-effect" id="validasi_tag" type="button" style="display:none;">Validasi</button> 
				<a href="?page=tag" id="kembali" class="btn btn-danger waves-effect">Kembali</a>
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
		var no_tag =$('#no_tag').val();
		if(act=='add'){
			$("#addItem").css("display", "none");
			$("#detailItem").css("display", "none");
			$("#save_header").css("display", "block");
		} else if(act=='update') {
			$.ajax({
					type: 'POST',
					url: "functions/tag/f_tag.php",
					data: "act=getHeader&no_tag="+no_tag,
					dataType: "json",	
					success: function(data) {
						if(data) {
							$('#tanggal').val(data.TAGTANGGAL);
							$('#note').val(data.TAGNOTE);
							$('#id_department').val(data.TAGID_DEPARTMENT).change();
						}
					}
			});
			$("#addItem").css("display", "block");
			$("#detailItem").css("display", "block");
			$("#save_header").text("UPDATE HEADER");
			$("#kembali").text("SELESAI");
			tampil_detail_item ();
		} else if(act=='validasi') {
			$.ajax({
					type: 'POST',
					url: "functions/tag/f_tag.php",
					data: "act=getHeader&no_tag="+no_tag,
					dataType: "json",	
					success: function(data) {
						if(data) {
							$('#tanggal').val(data.TAGTANGGAL);
							$('#note').val(data.TAGNOTE);
							$('#id_department').val(data.TAGID_DEPARTMENT).change();
						}
					}
			});
			$("#addItem").css("display", "block");
			$("#detailItem").css("display", "block");
			$("#save_header").css("display", "none");
			$("#save_item").css("display", "none");
			$("#validasi_tag").css("display", "block");
			$('select.form-control').attr('disabled', 'disabled');
			$('input.form-control').attr('disabled', 'disabled');
			$('textarea.form-control').attr('disabled', 'disabled');
			tampil_detail_item ();
		}
});

function myItem() {
		var iditem =$('#item').val();
		$('#id_satuan').val('');
		$('#nm_satuan').val('');
		$('#stock').val('');
		$('#ed').val('');
		$('.queryLotNumber').css("display", "block");
		if(iditem!=0) {
			tampil_lotnumber ();
		}
}

function tampil_lotnumber () {
		var iditem =$('#item').val();
		var no_tag =$('#no_tag').val();
		$.ajax({
				type: 'POST',
				url: "functions/tag/queryLotNumber.php",
				data: "iditem="+iditem+"&no_tag="+no_tag,
				success: function(hasil) {
					$('.queryLotNumber').html(hasil);
				}
		});
}

$(document).on('change', '.myLotNumber', function(){
		var lot_number =$('#lot_number').val();
		var id_satuan = $("#lot_number option:selected").attr("id_satuan");
		var nm_satuan = $("#lot_number option:selected").attr("nm_satuan");
		var ed = $("#lot_number option:selected").attr("ed");
		var stock = $("#lot_number option:selected").attr("stock");
		//alert (lot_number+nm_satuan+id_satuan+ed);
		$('#id_satuan').val(id_satuan);
		$('#nm_satuan').val(nm_satuan);
		$('#ed').val(ed);
		$('#stock').val(stock);
});

$('#save_header').click(function (){
		var act =$('#act').val();
		var no_tag =$('#no_tag').val();
		var tanggal =$('#tanggal').val();
		var id_department =$('#id_department').val();
		var note =$('#note').val();
		if(tanggal=='' || id_department==0) {
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
			//$(location).attr('href','index.php?page=add_tag&act=update&id='+no_tag);
			$.ajax({
					type: "POST", 
					url : "functions/tag/f_tag.php", 
					data: "act=save_header&aksi="+act+"&tanggal="+tanggal+"&id_department="+id_department+"&note="+note+"&no_tag="+no_tag,
					dataType: "json",			
					success: function(data){
						if(data){
							if(data.hasil==0) {
								Swal.fire({
									title: 'GAGAL',
									text: 'No TAG sudah terdaftar..',
									type: 'warning',
									confirmButtonColor: "red",
									showCancelButton: false,
									allowOutsideClick: false,
									position: 'top'
								})
							} else {
								$(location).attr('href','index.php?page=add_tag&act=update&id='+no_tag);
								
							} 
						}
						else{
							alert("Error..");
						}
					}		
			});
			
		}
		
});

$('#save_item').click(function (){
		var no_tag =$('#no_tag').val();
		var item =$('#item').val();
		var lot_number =$('#lot_number').val();
		var id_satuan =$('#id_satuan').val();
		var qty =$('#qty').val();
		var ed =$('#ed').val();
		if(item==0 || lot_number==0 || id_satuan=='' || qty=='' || qty==0) {
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
					url : "functions/tag/f_tag.php", 
					data: "act=save_item&id_item="+item+"&lot_number="+lot_number+"&id_satuan="+id_satuan+"&ed="+ed+"&qty="+qty+"&no_tag="+no_tag,
					dataType: "json",			
					success: function(data){
						if(data){
							if(data.hasil==0) {
								Swal.fire({
									title: 'GAGAL',
									text: 'gagal input..',
									type: 'warning',
									confirmButtonColor: "red",
									showCancelButton: false,
									allowOutsideClick: false,
									position: 'top'
								})
							} else {
								tampil_detail_item ();
								$('#item').val('0').change();
								$('#lot_number').val('0').change();
								$('#id_satuan').val('');
								$('#nm_satuan').val('');
								$('#ed').val('');
								$('#stock').val('');
								$('#qty').val('');
								$('.queryLotNumber').css("display", "none");
							} 
						}
						else{
							alert("Error..");
						}
					}		
			});
			
		}
		
});

function tampil_detail_item () {
		var no_tag =$('#no_tag').val();
		var act =$('#act').val();
		$.ajax({
				type: 'POST',
				url: "functions/tag/show_detail_item.php",
				data: "no_tag="+no_tag+"&act="+act,
				success: function(hasil) {
					$('.show_detail_item').html(hasil);
				}
		});
}

function cekQty () {
		var stock =$('#stock').val();
		var qty =$('#qty').val();
		if(parseInt(qty)>parseInt(stock)) {
			Swal.fire({
				title: 'WARNING',
				text: 'Quantity tidak boleh lebih dari stock...',
				type: 'warning',
				confirmButtonColor: "red",
				showCancelButton: false,
				allowOutsideClick: false,
				position: 'top'
			})
			$('#qty').val(stock);
		} else if(parseInt(qty)<0) {
			$('#qty').val(0);
		}
}

$(document).on('click', '.hapusitem', function(){
		var notag_detail = $(this).attr('data');
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
							url : "functions/tag/f_tag.php", 
							data: "act=hapusitem&notag_detail=" + notag_detail ,
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

$('#validasi_tag').click(function (){
		var no_tag =$('#no_tag').val();
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
								url : "functions/tag/f_tag.php", 
								data: "act=validasi_tag&no_tag=" + no_tag ,
								dataType: "json",			
								success: function(data){
									if(data){
										if(data.hasil==0) {
											//alert('1');
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
											$(location).attr('href','index.php?page=tag');
											//alert('2');
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