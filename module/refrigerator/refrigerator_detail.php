<?php
include './config/connect.php';
date_default_timezone_set('Asia/Jakarta');
$tgl = date('d-M-y');
$now = date('d-M-y h.i.s a');

$rfgr_id = $_GET['rid'];
//echo $rfgr_id;
$query1 = strtoupper("SELECT q.* FROM (select k.kode_kulkas, k.nama_kulkas,gu.NAMAGUDANG, t.image_url,t.nama_typekulkas, k.ip_kulkas,s.nama_subdepartment, d.nama_department,r.nama_ruangan,r.lantai, g.nama_gedung,
l.cold_room,l.min_temp,l.max_temp
														from m_kulkas k
														left join m_gudang gu ON gu.id_gudang = k.id_gudang
														left join m_typekulkas t on t.id_typekulkas = k.id_typekulkas
														left join m_subdepartmentkulkas sk on sk.kode_kulkas=k.kode_kulkas
														left join m_subdepartment s on s.id_subdepartment = sk.id_subdepartment
														left join m_department d on d.id_department = s.id_department
														left join m_ruangan r on r.id_ruangan=s.id_ruangan
														left join m_gedung g on g.id_gedung = r.id_gedung
														left join kulkas_data_log l on l.kode_kulkas = k.kode_kulkas
														WHERE k.kode_kulkas = '$rfgr_id')q limit 1");



/*detail refri */
// echo $query1;

$load = $mysqli->query($query1);
// oci_execute($load);
$r = mysqli_fetch_array($load);



?>

<head>
	<script src="plugins/jquery/jquery.min.js"></script>
	<script src="plugins/jquery/jquery.js"></script>
</head>
<style>
	img {
		display: block;
		margin-left: auto;
		margin-right: auto;
	}
</style>
<div class="container-fluid">
	<div class="block-header">
		<h2>DETAIL INFO
			<a href="index.php?page=refrigerator" type="button" class="btn bg-cyan waves-effect right">Back to Refrigerator Map</a>
		</h2>
	</div>

	<div class="row clearfix">
		<!-- Basic Examples -->
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h4>
						<?php echo $r['NAMAGUDANG']; ?><br>

					</h4>
					<?php echo $r['NAMA_RUANGAN']; ?> <br>
					<small><?php echo $r['NAMA_GEDUNG'] . ' Lantai ' . $r['LANTAI']; ?></small>
				</div>
				<div class="body center" style="height: auto;margin-top: 30px;">
					<img src="<?php echo $r['IMAGE_URL']; ?>" width="200px"> <br>
					<center><b>Type : <?php echo $r['NAMA_TYPEKULKAS']; ?></b></center>
					<hr>

				</div>

			</div>
		</div>
		<!-- #END# Basic Examples -->
		<!-- Badges -->
		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						LIVE
						<small>Add the badges component to any list group item and it will automatically be positioned on the right.</small>
					</h2>
				</div>
				<div class="body">
					<div class="info-box-4 coldroom">

					</div>

					<div class="info-box-4 users">

					</div>

					<a data="<?php echo $rfgr_id; ?>" type="button" class="btn bg-red waves-effect ref_detail_user">
						<i class="material-icons">trending_up</i>
						More Open Log Data
					</a>
				</div>
			</div>
		</div>

		<!-- Badges -->
		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						TEMPERATURE, VOLTAGE & POWER MONITORING
						<small>Add the badges component to any list group item and it will automatically be positioned on the right.</small>

					</h2>

				</div>
				<div class="body">
					<div class="info-box bg-grey temperature">

					</div>

					<div class="info-box bg-purple voltage">

					</div>

					<div class="info-box bg-orange power">

					</div>

					<a id="ref_detail_more" data="<?php echo $rfgr_id; ?>" type="button" class="btn bg-red waves-effect ref_detail_more">
						<i class="material-icons">trending_up</i>
						More Device Log Data
					</a>
				</div>
			</div>
		</div>
		<!-- #END# Badges -->
	</div>
</div>

<script src="module/refrigerator/j_refrigeratorDetail.js"></script>
<script>
	var otomatis = setInterval(
		function() {
			rfgr_id = '<?php echo $rfgr_id; ?>';
			$('.temperature').load('functions/refrigerator/show_log_temperature_auto.php?rid=' + rfgr_id).fadeIn("slow");
			$('.voltage').load('functions/refrigerator/show_log_voltage_auto.php?rid=' + rfgr_id).fadeIn("slow");
			$('.power').load('functions/refrigerator/show_log_power_auto.php?rid=' + rfgr_id).fadeIn("slow");
			$('.users').load('functions/refrigerator/show_log_users_auto.php?rid=' + rfgr_id).fadeIn("slow");
			$('.coldroom').load('functions/refrigerator/show_log_coldroom_auto.php?rid=' + rfgr_id).fadeIn("slow");
		}, 3000);
</script>