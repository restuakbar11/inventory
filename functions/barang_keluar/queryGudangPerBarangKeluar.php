<?php
include ("../../config/connect.php");

$queryGudangPerBarangKeluar =$mysqli->query ( "SELECT *
										FROM BARANG_KELUAR t
										JOIN M_SUBDEPARTMENT s ON s.ID_SUBDEPARTMENT=t.BARANGKELUARID_SUBDEPARTMENT
										JOIN M_GUDANG g ON g.ID_DEPARTMENT=s.ID_DEPARTMENT AND GUDANGAKTIF='Y'
										WHERE NOBARANGKELUAR='$_POST[no_barang_keluar]' ");
// oci_execute($queryGudangPerBarangKeluar);
?>
<select name="gudang" id="gudang" class="form-control show-tick myGudang" data-live-search="on">
	<option style="margin-left:20px;" value='0'>--PILIH GUDANG--</option>
	<?php
	while ($g =mysqli_fetch_array($queryGudangPerBarangKeluar)) { ?>
		<option style="margin-left:20px;" value="<?php echo $g['ID_GUDANG']?>"><?php echo $g['NAMAGUDANG']?></option>
		<?php
	} ?>
</select>


<!-- Select Plugin Js -->
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>
	
	<!-- Custom Js -->
    <script src="js/admin.js"></script>