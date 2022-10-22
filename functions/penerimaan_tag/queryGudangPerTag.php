<?php
include ("../../config/connect.php");

$queryGudangPerTag =$mysqli->query ( "SELECT *
										FROM TAG t
										JOIN M_GUDANG g ON g.ID_DEPARTMENT=t.TAGID_DEPARTMENT AND GUDANGAKTIF='Y'
										WHERE NOTAG='$_POST[no_tag]' ");
// oci_execute($queryGudangPerTag);
?>
<select name="gudang" id="gudang" class="form-control show-tick myGudang" data-live-search="on">
	<option style="margin-left:20px;" value='0'>--PILIH GUDANG--</option>
	<?php
	while ($g =mysqli_fetch_array($queryGudangPerTag)) { ?>
		<option style="margin-left:20px;" value="<?php echo $g['ID_GUDANG']?>"><?php echo $g['NAMAGUDANG']?></option>
		<?php
	} ?>
</select>


	<!-- Custom Js -->
    <script src="js/searchBar.js"></script>