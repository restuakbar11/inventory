<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
$now	=date('Y-m-d');
$start	=date('Y-m-d', strtotime('-1 month', strtotime($now)));
$kode_laporan = $_GET['kode'];
/*
Prompt dipisahkan sesuai dengan kkode laporan
masing2 kode laporan memiliki form input yang berda-beda
*/
?>
<head>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/jquery/jquery.js"></script>
</head>
<div class="row clearfix">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="card">
		<?php 
	
	if($kode_laporan == 'RC-INV-002'){ ?>
            <div class="header">
                <h2>
                    <?php echo $kode_laporan ?> - LAPORAN STOK OPNAME
                </h2>
				<hr>
				<form action="_blank" method="post">
                    <input type="hidden" name="userid" id="userid" value="<?php echo $username ?>">       
					<input type="hidden" name="kode_laporan" id="kode_laporan" value="<?php echo $kode_laporan ?>">
					<div class="form-group form-float">
						<h2 class="card-inside-title">Departemen *</h2>
                        <div class="form-line">
                            <select class="form-control" name="id_department" id="id_department">
							<option value="">--Pilih Department--</option>
							<option value="all" nama="ALL">ALL</option>
                                <?php
                            include 'functions/department/queryGetDepartment.php';
                            while ($u =mysqli_fetch_array($queryGetDepartment)) { ?>
                                <option style="align:center;" value="<?php echo $u['ID_DEPARTMENT'] ?>" nama="<?php echo $u['NAMA_DEPARTMENT'] ?>" ><?php echo $u['NAMA_DEPARTMENT'] ;?></option>
                            <?php
                            } ?>
                            </select>
                        </div>
                    </div>
					<a class="btn btn-primary waves-effect" id="L_Stok_Opname" type="button" ><i class="material-icons">forward</i>Buat Laporan</a> 
					<a href="#" class="btn btn-danger" onclick="self.history.back()"><i class="material-icons">undo</i>Kembali</a>
					
				</form>
            </div>
			<?php 
	}
    elseif ($kode_laporan == 'RC-INV-001') { ?>
			<div class="header">
                <h2>
                    <?php echo $kode_laporan ?> - LAPORAN ITEM PER SUPPLIER
                </h2>
                <hr>
                <form action="_blank" method="post">
                    <input type="hidden" name="userid" id="userid" value="<?php echo $username ?>">       
                    <input type="hidden" name="kode_laporan" id="kode_laporan" value="<?php echo $kode_laporan ?>">
                    
					<div class="form-group form-float">
						<h2 class="card-inside-title">Supplier *</h2>
						<div class="form-line">
							<select class="form-control" name="id_supplier" id="id_supplier">
							<option value="">--Pilih Supplier--</option>
							<option value="all" nama="ALL">ALL</option>
								<?php
							include 'functions/supplier/queryGetSupplier.php';
							while ($u =mysqli_fetch_array($queryGetSupplier)) { ?>
								<option style="align:center;" value="<?php echo $u['IDSUPPLIER'] ?>" nama="<?php echo $u['NAMASUPPLIER'] ?>" ><?php echo $u['NAMASUPPLIER'] ;?></option>
								<?php
							} ?>
							</select>
						</div>
					</div>
                    
                    <a class="btn btn-primary waves-effect" id="L_itemsupplier" type="button" ><i class="material-icons">forward</i>Buat Laporan</a> 
					<a href="#" class="btn btn-danger" onclick="self.history.back()"><i class="material-icons">undo</i>Kembali</a>
                    
                </form>
            </div>
            <?php 
	}
	else if($kode_laporan == 'RC-INV-003'){ ?>
            <div class="header">
                <h2>
                    <?php echo $kode_laporan ?> - LAPORAN TAG
                </h2>
				<hr>
				<form action="_blank" method="post">
                    <input type="hidden" name="userid" id="userid" value="<?php echo $username ?>">       
					<input type="hidden" name="kode_laporan" id="kode_laporan" value="<?php echo $kode_laporan ?>">
					<div class="form-group form-float">
						<h2 class="card-inside-title">Tanggal Awal *</h2>
                        <div class="form-line">
                            <div id="bs_datepicker_container">
								<input type="text" id="startdate" data-date-format="yyyy-mm-dd" class="form-control date" value="<?php echo $start ?>">
							</div>
                        </div>
                    </div>
					<div class="form-group form-float">
						<h2 class="card-inside-title">Tanggal Akhir *</h2>
                        <div class="form-line">
                            <div id="bs_datepicker_container">
								<input type="text" id="finishdate" data-date-format="yyyy-mm-dd" class="form-control date" value="<?php echo $now ?>">
							</div>
                        </div>
                    </div>
					<a class="btn btn-primary waves-effect" id="L_TAG" type="button" ><i class="material-icons">forward</i>Buat Laporan</a> 
					<a href="#" class="btn btn-danger" onclick="self.history.back()"><i class="material-icons">undo</i>Kembali</a>
					
				</form>
            </div>
			<?php 
	}
	else if($kode_laporan == 'RC-INV-004'){ ?>
            <div class="header">
                <h2>
                    <?php echo $kode_laporan ?> - LAPORAN BARANG MASUK DARI SUPPLIER
                </h2>
				<hr>
				<form action="_blank" method="post">
                    <input type="hidden" name="userid" id="userid" value="<?php echo $username ?>">       
					<input type="hidden" name="kode_laporan" id="kode_laporan" value="<?php echo $kode_laporan ?>">
					<div class="form-group form-float">
						<h2 class="card-inside-title">Tanggal Awal *</h2>
                        <div class="form-line">
                            <div id="bs_datepicker_container">
								<input type="text" id="startdate" data-date-format="yyyy-mm-dd" class="form-control date" value="<?php echo $start ?>">
							</div>
                        </div>
                    </div>
					<div class="form-group form-float">
						<h2 class="card-inside-title">Tanggal Akhir *</h2>
                        <div class="form-line">
                            <div id="bs_datepicker_container">
								<input type="text" id="finishdate" data-date-format="yyyy-mm-dd" class="form-control date" value="<?php echo $now ?>">
							</div>
                        </div>
                    </div>
					<a class="btn btn-primary waves-effect" id="L_barangmasuk" type="button" ><i class="material-icons">forward</i>Buat Laporan</a> 
					<a href="#" class="btn btn-danger" onclick="self.history.back()"><i class="material-icons">undo</i>Kembali</a>
					
				</form>
            </div>
			<?php 
	}
	else if($kode_laporan == 'RC-INV-005'){ ?>
            <div class="header">
                <h2>
                    <?php echo $kode_laporan ?> - LAPORAN BARANG KELUAR
                </h2>
				<hr>
				<form action="_blank" method="post">
                    <input type="hidden" name="userid" id="userid" value="<?php echo $username ?>">       
					<input type="hidden" name="kode_laporan" id="kode_laporan" value="<?php echo $kode_laporan ?>">
					<div class="form-group form-float">
						<h2 class="card-inside-title">Tanggal Awal *</h2>
                        <div class="form-line">
                            <div id="bs_datepicker_container">
								<input type="text" id="startdate" data-date-format="yyyy-mm-dd" class="form-control date" value="<?php echo $start ?>">
							</div>
                        </div>
                    </div>
					<div class="form-group form-float">
						<h2 class="card-inside-title">Tanggal Akhir *</h2>
                        <div class="form-line">
                            <div id="bs_datepicker_container">
								<input type="text" id="finishdate" data-date-format="yyyy-mm-dd" class="form-control date" value="<?php echo $now ?>">
							</div>
                        </div>
                    </div>
					<div class="form-group form-float">
						<h2 class="card-inside-title">Department *</h2>
						<?php
						if($_SESSION['grupID']==1) { ?>
							<div class="form-line">
								<select class="form-control" name="id_department" id="id_department">
								<option value="">--Pilih Department--</option>
								<option value="all" nama="ALL">ALL</option>
									<?php
								include 'functions/department/queryGetDepartment.php';
								while ($u =mysqli_fetch_array($queryGetDepartment)) { ?>
									<option style="align:center;" value="<?php echo $u['ID_DEPARTMENT'] ?>" nama="<?php echo $u['NAMA_DEPARTMENT'] ?>" ><?php echo $u['NAMA_DEPARTMENT'] ;?></option>
								<?php
								} ?>
								</select>
							</div>
							<?php
						} else { ?>
							<div class="form-line">
								<select class="form-control" name="id_department" id="id_department">
									<?php
								include 'functions/department/queryDepartmentPerSession.php';
								while ($u =mysqli_fetch_array($queryDepartmentPerSession)) { ?>
									<option style="align:center;" value="<?php echo $u['ID_DEPARTMENT'] ?>" nama="<?php echo $u['NAMA_DEPARTMENT'] ?>" ><?php echo $u['NAMA_DEPARTMENT'] ;?></option>
								<?php
								} ?>
								</select>
							</div>
							<?php
						} ?>
                    </div>
					<a class="btn btn-primary waves-effect" id="L_barangkeluar" type="button" ><i class="material-icons">forward</i>Buat Laporan</a> 
					<a href="#" class="btn btn-danger" onclick="self.history.back()"><i class="material-icons">undo</i>Kembali</a>
					
				</form>
            </div>
			<?php 
	}else if($kode_laporan == 'RC-INV-006'){ ?>
            <div class="header">
                <h2>
                    <?php echo $kode_laporan ?> - LAPORAN BUKA TUTUP KULKAS 
                </h2>
				<hr>
				<form action="_blank" method="post">
                    <input type="hidden" name="userid" id="userid" >       
					<input type="hidden" name="kode_laporan" id="kode_laporan" value="<?php echo $kode_laporan ?>">
					<div class="form-group form-float">
						<h2 class="card-inside-title">Tanggal Awal *</h2>
                        <div class="form-line">
                            <div id="bs_datepicker_container">
								<input type="text" id="startdate" data-date-format="yyyy-mm-dd" class="form-control date" value="<?php echo $start ?>">
							</div>
                        </div>
                    </div>
					<div class="form-group form-float">
						<h2 class="card-inside-title">Tanggal Akhir *</h2>
                        <div class="form-line">
                            <div id="bs_datepicker_container">
								<input type="text" id="finishdate" data-date-format="yyyy-mm-dd" class="form-control date" value="<?php echo $now ?>">
							</div>
                        </div>
                    </div>
                    <div class="form-group form-float">
						<h2 class="card-inside-title">Kulkas *</h2>
						<?php
						if($_SESSION['grupID']==1) { ?>
							<div class="form-line">
								<select class="form-control" name="id_kulkas" id="id_kulkas">
								<option value="">--Pilih Kulkas--</option>
								<option value="all" nama="ALL">ALL</option>
									<?php
								include 'functions/kulkas/queryGetKulkas.php';
								while ($u =mysqli_fetch_array($queryGetKulkas)) { ?>
									<option style="align:center;" value="<?php echo $u['KODE_KULKAS'] ?>" nama="<?php echo $u['NAMA_KULKAS'] ?>" ><?php echo $u['NAMA_KULKAS'] ;?></option>
								<?php
								} ?>
								</select>
							</div>
							<?php
						} else { ?>
							<div class="form-line">
								<select class="form-control" name="id_kulkas" id="id_kulkas">
									<?php
								include 'functions/kulkas/queryKulkasPerSession.php';
								while ($u =mysqli_fetch_array($queryKulkasPerSession)) { ?>
									<option style="align:center;" value="<?php echo $u['KODE_KULKAS'] ?>" nama="<?php echo $u['NAMA_KULKAS'] ?>" ><?php echo $u['NAMA_KULKAS'] ;?></option>
								<?php
								} ?>
								</select>
							</div>
							<?php
						} ?>
                    </div>
					<a class="btn btn-primary waves-effect" id="L_kulkas" type="button" ><i class="material-icons">forward</i>Buat Laporan</a> 
					<a href="#" class="btn btn-danger" onclick="self.history.back()"><i class="material-icons">undo</i>Kembali</a>
					
				</form>
            </div>
			<?php 
	}else if($kode_laporan == 'RC-INV-007'){ ?>
            <div class="header">
                <h2>
                    <?php echo $kode_laporan ?> - LAPORAN CEK IN 
                </h2>
				<hr>
				<form action="_blank" method="post">
                    <input type="hidden" name="userid" id="userid" >       
					<input type="hidden" name="kode_laporan" id="kode_laporan" value="<?php echo $kode_laporan ?>">
					<div class="form-group form-float">
						<h2 class="card-inside-title">Tanggal Awal *</h2>
                        <div class="form-line">
                            <div id="bs_datepicker_container">
								<input type="text" id="startdate" data-date-format="yyyy-mm-dd" class="form-control date" value="<?php echo $start ?>">
							</div>
                        </div>
                    </div>
					<div class="form-group form-float">
						<h2 class="card-inside-title">Tanggal Akhir *</h2>
                        <div class="form-line">
                            <div id="bs_datepicker_container">
								<input type="text" id="finishdate" data-date-format="yyyy-mm-dd" class="form-control date" value="<?php echo $now ?>">
							</div>
                        </div>
                    </div>
					<a class="btn btn-primary waves-effect" id="L_cekin" type="button" ><i class="material-icons">forward</i>Buat Laporan</a> 
					<a href="#" class="btn btn-danger" onclick="self.history.back()"><i class="material-icons">undo</i>Kembali</a>
					
				</form>
            </div>
			<?php 
	}
	else {
			echo "Prompt Belum Ada";
	}?>
            <div class="body">
                
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
	<div id="modal_Laporan" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
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
					<button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
				</div>

			</div>
		</div>
	</div>


<!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

<script>
$(document).ready(function() {
	$(".modal").on("hidden.bs.modal", function() {
		//$(".modal-body").html("");
		$(".modal-body").html("<embed src='' id='pdf_view' frameborder='0' width='100%' height='400px'>");
		document.getElementById("pdf_view").src='';
	});
});

$('#L_Stok_Opname').click(function () {
	var kode_laporan =$('#kode_laporan').val();
	var id_department =$('#id_department').val();
	var nm_department = $("#id_department option:selected").attr("nama");
	if(id_department=='') {
		Swal.fire({
			title: 'WARNING',
			text: 'Lengkapi Form inputan bertanda *...',
			type: 'warning',
			confirmButtonColor: "red",
			showCancelButton: false,
			allowOutsideClick: false,
			position: 'top'
		})
	} else {
		var link_base ="functions/reports/L_stockopname.php?id_department="+id_department+"&nm_department="+nm_department+"&kode_laporan="+kode_laporan;
		//var link_base ="module/laporan_rekap/c_stockopname.php?id_department="+id_department;
		$('#pdf_view').attr('src', link_base);
		$('#modal_Laporan').modal('show');
		$('.modal-title').text('Laporan Stok Opaname');
	}
});

$('#L_TAG').click(function () {
	var kode_laporan =$('#kode_laporan').val();
	var startdate =$('#startdate').val();
	var finishdate =$('#finishdate').val();
	if(startdate=='' || finishdate=='') {
		Swal.fire({
			title: 'WARNING',
			text: 'Lengkapi Form inputan bertanda *...',
			type: 'warning',
			confirmButtonColor: "red",
			showCancelButton: false,
			allowOutsideClick: false,
			position: 'top'
		})
	} else {
		var link_base ="functions/reports/L_TAG.php?startdate="+startdate+"&finishdate="+finishdate+"&kode_laporan="+kode_laporan;
		$('#pdf_view').attr('src', link_base);
		$('#modal_Laporan').modal('show');
		$('.modal-title').text('Laporan TAG');
	}
});

$('#L_barangmasuk').click(function () {
	var kode_laporan =$('#kode_laporan').val();
	var startdate =$('#startdate').val();
	var finishdate =$('#finishdate').val();
	if(startdate=='' || finishdate=='') {
		Swal.fire({
			title: 'WARNING',
			text: 'Lengkapi Form inputan bertanda *...',
			type: 'warning',
			confirmButtonColor: "red",
			showCancelButton: false,
			allowOutsideClick: false,
			position: 'top'
		})
	} else {
		var link_base ="functions/reports/L_barangmasuk.php?startdate="+startdate+"&finishdate="+finishdate+"&kode_laporan="+kode_laporan;
		$('#pdf_view').attr('src', link_base);
		$('#modal_Laporan').modal('show');
		$('.modal-title').text('Laporan Barang Masuk');
	}
});

$('#L_barangkeluar').click(function () {
	var kode_laporan =$('#kode_laporan').val();
	var startdate =$('#startdate').val();
	var finishdate =$('#finishdate').val();
	var id_department =$('#id_department').val();
	var nm_department = $("#id_department option:selected").attr("nama");
	if(startdate=='' || finishdate=='' || id_department=='') {
		Swal.fire({
			title: 'WARNING',
			text: 'Lengkapi Form inputan bertanda *...',
			type: 'warning',
			confirmButtonColor: "red",
			showCancelButton: false,
			allowOutsideClick: false,
			position: 'top'
		})
	} else {
		var link_base ="functions/reports/L_barangkeluar.php?startdate="+startdate+"&finishdate="+finishdate+"&kode_laporan="+kode_laporan+
					"&id_department="+id_department+"&nm_department="+nm_department;
		$('#pdf_view').attr('src', link_base);
		$('#modal_Laporan').modal('show');
		$('.modal-title').text('Laporan Barang Keluar');
	}
});

$('#L_itemsupplier').click(function () {
	var kode_laporan =$('#kode_laporan').val();
	var id_supplier =$('#id_supplier').val();
	var nm_supplier = $("#id_supplier option:selected").attr("nama");
	if(id_supplier=='') {
		Swal.fire({
			title: 'WARNING',
			text: 'Lengkapi Form inputan bertanda *...',
			type: 'warning',
			confirmButtonColor: "red",
			showCancelButton: false,
			allowOutsideClick: false,
			position: 'top'
		})
	} else {
		var link_base ="functions/reports/L_itemsupplier.php?id_supplier="+id_supplier+"&nm_supplier="+nm_supplier+"&kode_laporan="+kode_laporan;
		$('#pdf_view').attr('src', link_base);
		$('#modal_Laporan').modal('show');
		$('.modal-title').text('Laporan Item Per Supplier');
	}
});

$('#L_kulkas').click(function () {
	var kode_laporan =$('#kode_laporan').val();
	var startdate =$('#startdate').val();
	var finishdate =$('#finishdate').val();
	var id_kulkas = $('#id_kulkas').val();
	if(startdate=='' || finishdate=='' || id_kulkas=='') {
		Swal.fire({
			title: 'WARNING',
			text: 'Lengkapi Form inputan bertanda *...',
			type: 'warning',
			confirmButtonColor: "red",
			showCancelButton: false,
			allowOutsideClick: false,
			position: 'top'
		})
	} else {
		 var link_base ="functions/reports/L_kulkas.php?startdate="+startdate+"&finishdate="+finishdate+"&kode_laporan="+kode_laporan+"&id_kulkas="+id_kulkas;
		 $('#pdf_view').attr('src', link_base);
		 $('#modal_Laporan').modal('show');
		 $('.modal-title').text('Laporan Buka Tutup Kulkas');
	}
});

$('#L_cekin').click(function () {
	var kode_laporan =$('#kode_laporan').val();
	var startdate =$('#startdate').val();
	var finishdate =$('#finishdate').val();
	if(startdate=='' || finishdate=='') {
		Swal.fire({
			title: 'WARNING',
			text: 'Lengkapi Form inputan bertanda *...',
			type: 'warning',
			confirmButtonColor: "red",
			showCancelButton: false,
			allowOutsideClick: false,
			position: 'top'
		})
	} else {
		 var link_base ="functions/reports/L_cek_in.php?startdate="+startdate+"&finishdate="+finishdate+"&kode_laporan="+kode_laporan;
		 $('#pdf_view').attr('src', link_base);
		 $('#modal_Laporan').modal('show');
		 $('.modal-title').text('Laporan Cek In');
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