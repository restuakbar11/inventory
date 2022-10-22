<?php error_reporting(E_ALL);
include ("session.php");
//include ("config/connect.php");
require_once ('config/connect.php');
$user =$mysqli->query( "SELECT * FROM M_USER u 
						LEFT JOIN M_USERGROUP g ON USERGROUPID=USER_USERGROUPID 
						WHERE USERID='$_SESSION[userID]' ");

$arr =mysqli_fetch_array($user);
$foto =$arr['USER_FOTO'];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Inventory System Module</title>
    <!-- Favicon-->
    <link rel="icon" href="images/title_ism.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="plugins/morrisjs/morris.css" rel="stylesheet" />
	
	<!-- JQuery DataTable Css -->
    <link href="plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
	
    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">
	
	<!-- Colorpicker Css -->
    <link href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet" />
	
	<!-- Bootstrap Material Datetime Picker Css -->
    <link href="plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
	
	<!-- Bootstrap DatePicker Css -->
    <link href="plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
	
	<!-- Dropzone Css -->
    <link href="plugins/dropzone/dropzone.css" rel="stylesheet">

    <!-- Multi Select Css -->
    <link href="plugins/multi-select/css/multi-select.css" rel="stylesheet">

    <!-- Bootstrap Spinner Css -->
    <link href="plugins/jquery-spinner/css/bootstrap-spinner.css" rel="stylesheet">

    <!-- Bootstrap Tagsinput Css -->
    <link href="plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">

    <!-- Bootstrap Select Css -->
    <link href="plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    <!-- noUISlider Css -->
    <link href="plugins/nouislider/nouislider.min.css" rel="stylesheet" />

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />
	
	<link rel="stylesheet" type="text/css" href="plugins/sweetalert/css/sweetalert2.min.css">
	<link rel="stylesheet" type="text/css" href="plugins/sweetalert/css/font-awesome.min.css">
</head>

<body class="theme-<?php echo $_COOKIE['tema'] ?>">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <!--<a class="navbar-brand" href="index.html">ADMINBSB - MATERIAL DESIGN</a>-->
				<a class="navbar-brand animate__animated animate__jackInTheBox" href="index.php" >
					<img src="images/grahcis-header2.png" height="25px">
				</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <span class="label-count"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICATIONS</li>
                            
                            <li class="footer">
                                <a href="javascript:void(0);">View All Notifications</a>
                            </li>
                        </ul>
                    </li>
                    <!-- #END# Notifications -->
                    
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info" style="background: url('images/user_background/<?php echo $_COOKIE['user_background'] ?>') no-repeat no-repeat ;">
                <div class="image">
                    <img src="images/<?php echo $foto?>" width="60" height="60" alt="User" />
                </div>
                <div class="info-container" style="top:10%;">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $arr['USER_NAMA']?></div>
                    <div class="email"><?php echo $arr['USERGROUPNAMA']?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);" id="profil"><i class="material-icons">person</i>Profile</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#" id="logout"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <?php include "menu.php"; ?>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2021 <a href="javascript:void(0);">GVP - PT Gracia Visi Pratama</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
                <li role="presentation"><a href="#settings" data-toggle="tab">USER BACKGROUND</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
						<?php 
						$tema =array('red','pink','purple','deep-purple','indigo','blue','light-blue','cyan','teal','green','light-green','lime','yellow','amber','orange','deep-orange','brown','grey','blue-grey','black');
						$jml_tema =count($tema) - 1;
						for ($a=0; $a<=$jml_tema; $a++) { 
							if($tema[$a]==$_COOKIE['tema']) {
								$active ='active';
							} else {
								$active ='';
							}
							?>
							<li data-theme="<?php echo $tema[$a] ?>" class="pilihTema <?php echo $active ?>" tema="<?php echo $tema[$a] ?>">
								<div class="<?php echo $tema[$a] ?>"></div>
								<span><?php echo $tema[$a] ?></span>
							</li>
							<?php
						} ?>
                        
                    </ul>
                </div>
				<div role="tabpanel" class="tab-pane fade in active in active" id="settings">
                    <ul class="demo-choose-background">
						<?php 
						$bg =array('user_background00.jpg','user_background01.jpg','user_background02.jpg','user_background03.jpg','user_background04.jpg',
									'user_background05.jpg','user_background06.jpg','user_background07.jpg','user_background08.jpg','user_background09.jpg',
									'user_background10.jpg','user_background11.jpg');
						$jml_bg =count($bg) - 1;
						for ($q=0; $q<=$jml_bg; $q++) { 
							if($bg[$q]==$_COOKIE['user_background']) {
								$active_bg ='active';
							} else {
								$active_bg ='';
							}
							?>
							<li class="pilihBackground <?php echo $active_bg ?>" bg="<?php echo $bg[$q] ?>">
								<div><img src="images/user_background/<?php echo $bg[$q] ?>" width="40px" height="20px"></div>
								<span style="left:20px;"><?php echo $bg[$q] ?></span>
							</li>
							<?php
						}
						?>
					</ul>
				</div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <?php include ('page.php');  ?>
        </div>
    </section>
	
	
	<!-- Default Size modal-->
	<div class="modal fade" id="modalprofil" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="defaultModalLabel"></h4>
				</div>
				<div class="modal-body">
					<div class="box-body">
						<form method="POST" action="upload.php" enctype="multipart/form-data">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Pilih Foto*</label>

								<div class="col-sm-9">
									<input type="file" class="form-control clearform" name="gambar" id="gambar">
									<small style="color:red;">*) Max 1 MB, File berekstensi .jpg, .jpeg, .png</small>
								</div></br>
							</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary waves-effect" id="saveFoto"></button>
					<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CLOSE</button>
				</div>
						</form>
			</div>
		</div>
	</div>
	

    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>
	
	<script src="plugins/sweetalert/js/sweetalert2.min.js"></script> 
	
    <!-- Jquery DataTable Plugin Js -->
    <script src="plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
	
	<!-- Autosize Plugin Js -->
    <script src="plugins/autosize/autosize.js"></script>
	
	<!-- Moment Plugin Js -->
    <script src="plugins/momentjs/moment.js"></script>
	
	<!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
	
	<!-- Bootstrap Datepicker Plugin Js -->
    <script src="plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	
    <!-- Custom Js -->
    <script src="js/admin.js"></script>
	<script src="js/pages/forms/basic-form-elements.js"></script>
    <script src="js/pages/tables/jquery-datatable.js"></script>
	<script src="js/pages/ui/modals.js"></script>
	
	
	<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
	<script src="plugins/dropzone/dropzone.js"></script>
	<script src="plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
	<script src="plugins/nouislider/nouislider.js"></script>
	<script src="plugins/node-waves/waves.js"></script>
	<!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>
	
	<!-- Multi Select Plugin Js -->
    <script src="plugins/multi-select/js/jquery.multi-select.js"></script>

    <!-- Demo Js -->
    <script src="js/demo.js"></script>
	<script src="js/jquery.idle.js"></script>
	
	
</body>

</html>


<script>
$('.pilihTema').click(function() {
	var tema =$(this).attr('tema');
	document.cookie="tema="+tema;
});

$('.pilihBackground').click(function() {
	var bg =$(this).attr('bg');
	document.cookie="user_background="+bg;
	location.reload();
	//document.getElementById("ganti").style.backgroundColor="yellow !important";
});

$('#logout').click(function() {
	Swal.fire({
		title: 'CONFIRM',
		text: "Apakah Anda Yakin ingin Keluar ?",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		allowOutsideClick: false,
		confirmButtonText: 'Yes',
		position: 'top'
	}).then((result) => {
		if (result.value) {
			$(location).attr('href','logout.php');
		}
	})
});

$('#profil').click(function() {
	$('#modalprofil').modal('show');
	$('#defaultModalLabel').text('Update Profil');
	$('#saveFoto').text('Save');
});

/*$("#saveFoto").click(function(){
	var size =$("#gambar")[0].files[0].size;
	var maxsize =1084000; //1MB
	//alert(size);
	const fileupload = $('#gambar').prop('files')[0];
	let formData = new FormData();
	formData.append('gambar', fileupload);
	
	if(size>maxsize) {
		Swal.fire({
			title: 'WARNING',
			text: 'Ukuran File Terlalu Besar.. Max 1MB',
			type: 'warning',
			showCancelButton: false,
			allowOutsideClick: false,
			position: 'top'
		})
	} else {
		var filesSelected = document.getElementById("gambar").files;
			if (filesSelected.length > 0) {
				var fileToLoad = filesSelected[0];

				var fileReader = new FileReader();

				fileReader.onload = function(fileLoadedEvent) {
					var srcData = fileLoadedEvent.target.result; // <--- data: base64

					var newImage = document.createElement('img');
					newImage.src = srcData;

					var fotoBase64 = newImage.outerHTML;
					//alert("Converted Base64 version is " + fotoBase64);
					//console.log("Converted Base64 version is " + fotoBase64);
					$.ajax({
						type: "POST", 
						url : "upload.php", 
						data: "foto" + fotoBase64 ,
						dataType: "json",	
						success: function (data) {
							if(data.hasil==0) {
								Swal.fire({
									title: 'GAGAL',
									text: 'Nama File Kosong...',
									type: 'warning',
									showCancelButton: false,
									allowOutsideClick: false,
									position: 'top'
								})
							} else if(data.hasil==1) {
								Swal.fire({
									title: 'GAGAL',
									text: 'Ekstensi file tidak sesuai...',
									type: 'warning',
									showCancelButton: false,
									allowOutsideClick: false,
									position: 'top'
								})
							} else {
								$('#modalprofil').modal('hide');
							}
						}
					});
				}
				fileReader.readAsDataURL(fileToLoad);
			}
	}
});*/

$(document).idle({
  onIdle: function(){
	let timerInterval
	swal({
			title: 'WARNING..!',
			html: "Anda tidak melakukan proses apapun lebih dari 30 menit.. </br>Sistem akan otomatis Logout Dalam <h3><strong> </strong></h3> Detik",
			//html: " </br>Sistem akan otomatis Logout Dalam <h3><strong> </strong></h3> Detik",
			confirmButtonColor: "red",
			type: "info",
			timer: 10000,
			onOpen: function () { 
				timerInterval = setInterval(() => {
					swal.getContent().querySelector('strong')
					  .textContent = Math.ceil(swal.getTimerLeft() / 1000)
				  }, 100)
				},
				onClose: () => {
				  $(location).attr('href','logout.php');
				},
			confirmButtonText: "Oke",
			showConfirmButton: true,
			allowOutsideClick: false,
			position: 'top'
		}).then((result) => {
			if (result.value) {
				$(location).attr('href','logout.php');
			}
		})
  },
  idle: 1800000
  //idle: 18000
})
</script>

<style>
	.swal2-popup {
		font-size: 1.5rem !important;
	}
</style>