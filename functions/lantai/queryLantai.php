<?php 
include ("../../config/connect.php");
$querySatuan = $mysqli->query( "SELECT JUMLAH_LANTAI FROM M_GEDUNG WHERE ID_GEDUNG='$_POST[idgedung]'");
// oci_execute($querySatuan);

?>

<select name="lantai" id="lantai" class="form-control clearform" >
	<?php
	while ($s =mysqli_fetch_array($querySatuan)) {
		$jml_lantai = $s['JUMLAH_LANTAI'];
		for ($i=1; $i <= $jml_lantai; $i++) { 
			echo "<option style='margin-left:20px;' value='".$i."' >".$i."</option>";
		}
	 ?>
		
		<?php
	} ?>
</select>




    <!-- Select Plugin Js -->
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>
	
	<!-- Custom Js -->
    <script src="js/admin.js"></script>