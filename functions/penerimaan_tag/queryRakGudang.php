<?php
include ("../../config/connect.php");

$queryRakGudang =$mysqli->query ( "SELECT *
										FROM M_GUDANG g 
										JOIN M_RAKGUDANG r ON r.ID_GUDANG=g.ID_GUDANG AND RAKGUDANGAKTIF='Y'
										WHERE g.ID_GUDANG='$_POST[gudang]' ");
// oci_execute($queryRakGudang);
?>
<select name="rak_gudang" id="rak_gudang" class="form-control show-tick" data-live-search="on">
	<option style="margin-left:20px;" value='0'>--PILIH RAK GUDANG--</option>
	<?php
	while ($r =mysqli_fetch_array($queryRakGudang)) { ?>
		<option style="margin-left:20px;" value="<?php echo $r['ID_RAKGUDANG']?>"><?php echo $r['NAMARAKGUDANG']?></option>
		<?php
	} ?>
</select>


	<!-- Custom Js -->
    <script src="js/searchBar.js"></script>