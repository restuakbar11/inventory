<?php
include 'config/connect.php';


switch ($_GET['act'])
{
	default : ?>
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							DATA USER GROUP ACCESS
							<a href="index.php?page=master_data" type="button" class="btn bg-cyan waves-effect right">Back to Master Data</a>
						</h2>
					</div>
						
					<div class="body">
						
						
						<div class="showusergroupaccess"></div>
						<div id="waiting" style="display:none;width:70px;height:70px;border:0px solid black;position:absolute;top:50%;left:45%;padding:2px;">
							<img src='images/loading.gif' width="70" height="70" />
						</div>
						
					</div>
				</div>
			</div>
		</div>
		
		<?php
	break;


	case "detail": ?>
		<input type="hidden" id="id" value="<?php echo $_GET['id']?>">
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							USER GROUP : <?php echo $_GET['nm']?>
							<a href="#" class="btn btn-danger right" onclick="self.history.back()">Kembali</a>
						</h2>
					</div>
						
				</div>
			</div>
		</div>
		<div class="row clearfix">
			<div id="waiting" style="display:none;width:70px;height:70px;border:0px solid black;position:absolute;top:50%;left:45%;padding:2px;">
				<img src='images/loading.gif' width="70" height="70" />
			</div>
			<div class="col-lg-6" >
				<div class="card">
					<div class="header">
						<h2>
							MENU BELUM AKSES
						</h2>
					</div>
						
					<div class="body">
						<div class="show_not_access"></div>
					</div>
				</div>
			</div>
		
			<div class="col-lg-6">
				<div class="card">
					<div class="header">
						<h2>
							MENU SUDAH AKSES
						</h2>
					</div>
						
					<div class="body">
						<div class="show_has_access"></div>
					</div>
				</div>
			</div>
		</div>
		<?php
	break;
} ?>
	


<!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>
<script>
$(document).ready(function(){
		tampil_list();
		tampil_has_access ();
		tampil_not_access ();
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
				url: "functions/usergroupaccess/show_usergroupaccess.php",
				data: "",
				success: function(hasil) {
					$('.showusergroupaccess').html(hasil);
				}
		});
}

function tampil_not_access () {
		var id=$('#id').val();
		$.ajax({
				type: 'POST',
				url: "functions/usergroupaccess/show_not_access.php",
				data: "id="+id,
				success: function(hasil) {
					$('.show_not_access').html(hasil);
				}
		});
}

function tampil_has_access () {
		var id=$('#id').val();
		$.ajax({
				type: 'POST',
				url: "functions/usergroupaccess/show_has_access.php",
				data: "id="+id,
				success: function(hasil) {
					$('.show_has_access').html(hasil);
				}
		});
}

$(document).on('click', '.detail', function(){
		var usergroupID = $(this).attr('data');
		var nama = $(this).attr('nama');
		$(location).attr('href','?page=usergroupaccess&act=detail&id='+usergroupID+"&nm="+nama);
});

$(document).on('click', '.tambah', function(){
	var menusubid = $(this).attr('data');
	var groupid=$('#id').val();
	$(document).ajaxStart(function(){
		$("#waiting").css("display", "block");
	});
	$(document).ajaxComplete(function(){
		$("#waiting").css("display", "none");
	});
    $.ajax({
				type: "POST", 
				url : "functions/usergroupaccess/f_usergroupaccess.php", 
                data: "act=tambah&menusubid=" + menusubid+"&groupid="+groupid ,
                dataType: "json",			
            	success: function(data){
					if(data){
						Swal.fire({
							title: 'SUCCESS',
							text: 'Berhasil Tambah..',
							type: 'success',
							confirmButtonColor: "blue",
							showCancelButton: false,
							allowOutsideClick: false
						})
						tampil_has_access ();
						tampil_not_access ();
					}
					else{
						alert("Error");
					}
				}		
			});
});

$(document).on('click', '.hapus', function(){
	var menusubid = $(this).attr('data');
	var groupid=$('#id').val();
	$(document).ajaxStart(function(){
		$("#waiting").css("display", "block");
	});
	$(document).ajaxComplete(function(){
		$("#waiting").css("display", "none");
	});
    $.ajax({
				type: "POST", 
				url : "functions/usergroupaccess/f_usergroupaccess.php", 
                data: "act=hapus&menusubid=" + menusubid+"&groupid="+groupid ,
                dataType: "json",			
            	success: function(data){
					if(data){
						Swal.fire({
							title: 'SUCCESS',
							text: 'Berhasil Hapus..',
							type: 'success',
							confirmButtonColor: "blue",
							showCancelButton: false,
							allowOutsideClick: false
						})
						tampil_has_access ();
						tampil_not_access ();
					}
					else{
						alert("Error");
					}
				}		
			});
});
</script>