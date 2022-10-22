<?php
include 'config/connect.php';
?>
	
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						DATA USER
						<a href="index.php?page=master_data" type="button" class="btn bg-cyan waves-effect right">Back to Master Data</a>
					</h2>
				</div>
					
				<div class="body">
					
					<div class="alert alert-success alert-dismissible" id="sukses" style="width:300px; height:50px; float:right; display:none;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color:white;">&times;</button>
						<h4><i class="icon fa fa-check"></i> <label id="pesan"></label></h4>
					</div>
					<a href="#" class="btn btn-success tambahuser" data-toggle="modal" ><i class="material-icons">add</i> Tambah Data</a></br></br>
					
					<div class="showuser"></div>
					<div id="waiting" style="display:none;width:70px;height:70px;border:0px solid black;position:absolute;top:50%;left:45%;padding:2px;">
						<img src='images/loading.gif' width="70" height="70" />
					</div>
					
				</div>
			</div>
		</div>
	</div>
	
	
	<!-- Default Size modal-->
	<div class="modal fade" id="modaluser" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="defaultModalLabel"></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4 control-label">Nama user*</label>

						<div class="col-sm-8 ">
							<div class="form-line">
								<input type="text" class="form-control clearform user date" name="nm_user" id="nm_user" placeholder="Nama User / Staff ">
								<input type="hidden" class="form-control clearform user" name="act" id="act" >
								<input type="hidden" class="form-control clearform user" name="userID" id="userID" >
							</div>
						</div></br>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4 control-label">Jenis Kelamin</label>

						<div class="col-sm-8">
							<select class="form-control clearform user show-tick" name="kelamin" id="kelamin">
								<option value="Laki-laki">Laki-laki</option>
								<option value="Perempuan">Perempuan</option>
							</select>
						</div></br>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4 control-label">Alamat*</label>

						<div class="col-sm-8">
							<div class="form-line">
								<textarea name="alamat" id="alamat" class="form-control clearform user"></textarea>
							</div>
						</div></br>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4 control-label">Username*</label>

						<div class="col-sm-8">
							<div class="form-line">
								<input type="text" class="form-control clearform user" name="username" id="username" placeholder="Username">
							</div>
						</div></br></br>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4 control-label">Grup Akses</label>

						<div class="col-sm-8">
							<select class="form-control clearform user" name="grup" id="grup" >
								<?php
								include 'functions/queryUserGroup.php';
								while ($u =mysqli_fetch_array($queryUserGroup)) { ?>
									<option style="align:center;" value="<?php echo $u['USERGROUPID']?>"><?php echo $u['USERGROUPNAMA']?></option>
									<?php
								} ?>
							</select>
						</div></br>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4 control-label">Department</label>

						<div class="col-sm-8">
							<select class="form-control clearform user" name="department" id="department" >
								<?php
								include 'functions/department/queryGetDepartment.php';
								while ($d =mysqli_fetch_array($queryGetDepartment)) { ?>
									<option style="align:center;" value="<?php echo $d['ID_DEPARTMENT']?>"><?php echo $d['NAMA_DEPARTMENT']?></option>
									<?php
								} ?>
							</select>
						</div></br>
					</div>
					<div class="form-group" id="act_style_password">
						<label for="inputEmail3" class="col-sm-4 control-label">Ubah Password ?</label>

						<div class="col-sm-8">
							<div class="demo-checkbox">
                                <input type="checkbox" id="cekUbahPassword" name="cekUbahPassword" class="filled-in chk-col-blue clearform user" />
                                <label for="cekUbahPassword"></label>
							</div>
						</div></br>
					</div>
					<div id="style_password" style="display:none;">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-4 control-label">Password*</label>

							<div class="col-sm-8">
								<div class="form-line">
									<input type="password" class="form-control clearform user" name="password" id="password" placeholder="Password">
								</div>
							</div></br>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-4 control-label">Ulang Password*</label>

							<div class="col-sm-8">
								<div class="form-line">
									<input type="password" class="form-control clearform user" name="ulang_password" id="ulang_password" placeholder="Ulang Password">
								</div>
							</div></br>
						</div>
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
				url: "module/user/show_user.php",
				data: "",
				success: function(hasil) {
					$('.showuser').html(hasil);
				}
		});
}

$(".tambahuser").click(function(){
	clear ();
	$('#defaultModalLabel').text('Tambah User');
    $("#modaluser").modal('show');
	$('#modaluser').on('shown.bs.modal', function () {
		$('#nm_user').focus();
	});
	$("#act").val('add');
	$('#save').text('SAVE');
	document.getElementById("username").disabled = false;
	$('#act_style_password').css("display", "none");
	$('#style_password').css("display", "block");
});

function clear () {
	$('input[type=text].clearform').val('');
	$('input[type=password].clearform').val('');
	$('input[type=number].clearform').val('0');
	$('#alamat').val('');
}

$("#save").click(function(){
	var act = $('#act').val();
	if (act=='add') {
		action_save();
	} else if(act=='update') {
		var checkbox2 =document.getElementById("cekUbahPassword");
		if(checkbox2.checked == true) {
			action_save();
		} else {
			var nm_user = $('#nm_user').val();
			var kelamin = $('#kelamin').val();
			var username = $('#username').val();
			var alamat = $('#alamat').val();
			var password = $('#password').val();
			var ulang_password = $('#ulang_password').val();
			var grup = $('#grup').val();
			if(nm_user=='' || username=='' || alamat=='') {
				Swal.fire({
					title: 'WARNING',
					text: 'Mohon Lengkapi Form Inputan Bertanda (*)..',
					type: 'warning',
					confirmButtonColor: "red",
					showCancelButton: false,
					allowOutsideClick: false,
					position: 'top'
				})
			} else {
				//alert('act stat =0');
				var status =0;
				var user = {};
				$(".user").each(function(k,v){
						user[$(this).attr('name')] = $(this).val();
						//user[$(this).attr('name')] = $(this).is(':checkbox:checked') == true ? '1': $(this).val();
				});
				$.ajax({
						type: "POST", 
						url : "module/user/aksi_user.php", 
						data: {act:'save', status:status, user:user},
						dataType: "json",			
						success: function(data){
							if(data){
									$('#modaluser').modal('hide');
									tampil_list();
									document.getElementById('sukses').style.display='block';
									if(act=='add') {
										$('#pesan').text('Insert Success!');
									} else {
										$('#pesan').text('Update Success!');
									}
							}
							else{
								alert("Error..");
							}
						}		
				});
			}
		}
	} 
});

function action_save() {
	var nm_user = $('#nm_user').val();
	var kelamin = $('#kelamin').val();
	var username = $('#username').val();
	var alamat = $('#alamat').val();
	var password = $('#password').val();
	var ulang_password = $('#ulang_password').val();
	var grup = $('#grup').val();
	var act = $('#act').val();
	if(nm_user=='' || username=='' || alamat=='' || password=='' || ulang_password=='') {
		Swal.fire({
			title: 'WARNING',
			text: 'Mohon Lengkapi Form Inputan Bertanda (*)..',
			type: 'warning',
			confirmButtonColor: "red",
			showCancelButton: false,
			allowOutsideClick: false,
			position: 'top'
		})
	} else if(password.length <5) {
		Swal.fire({
			title: 'WARNING',
			text: 'Password Minimal 5 Karakter..',
			type: 'warning',
			confirmButtonColor: "red",
			showCancelButton: false,
			allowOutsideClick: false,
			position: 'top'
		})
	} else if(password!=ulang_password) {
		Swal.fire({
			title: 'WARNING',
			text: 'Ulang Password Tidak Sesuai..',
			type: 'warning',
			confirmButtonColor: "red",
			showCancelButton: false,
			allowOutsideClick: false,
			position: 'top'
		})
	} else {
		//alert('act');
		var status =1;
		var user = {};
		$(".user").each(function(k,v){
				user[$(this).attr('name')] = $(this).val();
				//user[$(this).attr('name')] = $(this).is(':checkbox:checked') == true ? '1': $(this).val();
		});
		$.ajax({
				type: "POST", 
				url : "module/user/aksi_user.php", 
                data: {act:'save', status:status, user:user},
                dataType: "json",			
            	success: function(data){
					if(data){
						if(data.hasil==0) {
							Swal.fire({
								title: 'GAGAL',
								text: 'Username Sudah Digunakan.. Silahkan Input Ulang Dengan Username Lain..',
								type: 'warning',
								confirmButtonColor: "red",
								showCancelButton: false,
								allowOutsideClick: false,
								position: 'top'
							})
							$('#modaluser').modal('hide');
							tampil_list();
						} else if(data.hasil==1) {
							Swal.fire({
								title: 'GAGAL',
								text: 'Gagal Menyimpan..',
								type: 'warning',
								confirmButtonColor: "red",
								showCancelButton: false,
								allowOutsideClick: false,
								position: 'top'
							})
							$('#modaluser').modal('hide');
							tampil_list();
						} else {
							$('#modaluser').modal('hide');
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
}

$(document).on('click', '.hapususer', function(){
	var userID = $(this).attr('data');
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
						url : "module/user/aksi_user.php", 
						data: "act=hapus&userID=" + userID ,
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

$(document).on('click', '.edituser', function(){
	$('#defaultModalLabel').text('Edit User');
	var userID = $(this).attr('data');
    $.ajax({
				type: "POST", 
				url : "module/user/aksi_user.php", 
                data: "act=form&userID=" + userID ,
                dataType: "json",			
            	success: function(data){
					if(data){
						$('#userID').val(userID);
						$('#nm_user').val(data.USER_NAMA);
						$('#username').val(data.USER_USERNAME);
						$('#password').val('');
						$('#ulang_password').val('');
						$('#kelamin').val(data.USER_KELAMIN).change();
						$('#grup').val(data.USER_USERGROUPID).change();
						$('#department').val(data.USER_IDDEPARTMENT).change();
						$('#alamat').val(data.USER_ALAMAT);
						$('#act').val('update');
						$('#save').text('UPDATE');
						document.getElementById("username").disabled = true;
						$('#act_style_password').css("display", "block");
						$('#style_password').css("display", "none");
					}
					else{
						alert("Error");
					}
				}		
			});
    $("#modaluser").modal('show');
});

$(document).on('click', '#cekUbahPassword', function(){
	var checkbox =document.getElementById("cekUbahPassword");
	if(checkbox.checked == true) {
		$('#style_password').css("display", "block");
		$('#password').val('');
		$('#ulang_password').val('');
	} else {
		$('#style_password').css("display", "none");
		$('#password').val('');
		$('#ulang_password').val('');
	}
});

</script>