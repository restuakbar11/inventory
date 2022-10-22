<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Login | Inventory</title>
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
		<link rel="stylesheet" type="text/css" href="plugins/sweetalert/css/sweetalert2.min.css">
		<link rel="stylesheet" type="text/css" href="plugins/sweetalert/css/font-awesome.min.css">

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">
</head>

<style>
	#back {
		background-color: #6cd0ed;
		height: 50%;
		background-repeat :no-repeat;
		width :100%;
		background-size :100%;
	}
	.logo {
		text-align: center;
		vertical-align: middle;
		color: #000000;
		opacity: 0.85;
		filter: alpha(opacity=60); /* For IE8 and earlier */
		margin-top: 20%;
		font-family: verdana;
	}
	.card {
		background-color: #ffffff;
		border: 1px solid black;
		border-radius: 10px;
		opacity: 0.85;
		filter: alpha(opacity=60); /* For IE8 and earlier */
		width : 360px;
	}
	
	.logo_bottom {
		vertical-align: middle;
		filter: alpha(opacity=60); /* For IE8 and earlier */
		margin-top:10px; margin-bottom:10px;
	}
</style>

<body class="login-page" id="back">
    <div class="login-box">
        <div class="logo" >
            <!--<h1><b>ISM</b></h1>
            <h4>Inventory System Module</h4>-->
			<img src="images/grahcis-inventory2.png" width="250px" style="margin-top:10px; margin-bottom:10px;">
			<hr>
        </div>
        <div class="card">
            <div class="body">
                    <div class="msg">Sign in to start your session</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="username" id="username" placeholder="Username" required autofocus autocomplete="off">
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-pink waves-effect" type="button" id="login">SIGN IN</button>
                        </div>
                    </div>
            </div>
        </div>
    </div>
	
	<div class="logo_bottom" >
            <!--<h1><b>ISM</b></h1>
            <h4>Inventory System Module</h4>-->
			<img src="images/Logo_gvp_small.png" width="350px">
    </div>
	
    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- Validation Plugin Js -->
    <script src="plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/examples/sign-in.js"></script>
	
	<script src="plugins/sweetalert/js/sweetalert2.min.js"></script> 
	<script src="plugins/sweetalert/js/bootstrap.min.js"></script>
</body>
<script>
$("#login").click(function(){
	aksi();
});

$("#password").keyup(function(event) {
    if (event.keyCode == 13) {
        aksi();
    }
});

function aksi() {
	var username =$("#username").val();
	var password =$("#password").val();
	if(username=='') {
		swal({
			title: 'WARNING..!',
			text: "Username Masih Kosong!",
			confirmButtonColor: "red",
			type: "warning",
			confirmButtonText: "Oke",
			showConfirmButton: true
		});
	} else if(password=='') {
		swal({
			title: 'WARNING..!',
			text: "Password Masih Kosong!",
			confirmButtonColor: "red",
			type: "warning",
			confirmButtonText: "Oke",
			showConfirmButton: true
		});
	} else {
		$.ajax({
				type: "POST", 
				url : "loginproses.php", 
				data: "username=" +username+ "&password=" +password,
				dataType: "json",			
				success: function(data){
					if(data.status=='logon'){
						swal({
							title: 'WARNING..!',
							text: "Session Aktif.. Mohon Logout Dahulu..",
							confirmButtonColor: "red",
							type: "warning",
							confirmButtonText: false,
							showConfirmButton: false,
							footer: '<a class="btn btn-danger" href="logout.php">Logout</a>'
						});
					}
					else if(data.status=='wait'){
						var time =data.time;
						swal({
							title: 'WARNING..!',
							text: "Username ini baru saja login. Mohon tunggu "+time+ " menit lagi",
							confirmButtonColor: "red",
							type: "warning",
							confirmButtonText: "Oke",
							showConfirmButton: true
						});
					}
					else if(data.status=='gagal'){
						swal({
							title: 'ERROR..!',
							text: "Username atau Password tidak ditemukan !!",
							confirmButtonColor: "red",
							type: "error",
							confirmButtonText: "Oke",
							showConfirmButton: true
						});
					} 
					else if(data.status=='sukses'){
						$(location).attr('href','index.php');
					} 
				}		
		});
		//$(location).attr('href','index.php');
	}
}
</script>
</html>

<style>
	.swal2-popup {
		font-size: 1.5rem !important;
	}
</style>