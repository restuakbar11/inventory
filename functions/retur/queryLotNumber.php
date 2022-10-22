<?php
include ("../../config/connect.php");

//cek apakah ada Retur yang belum di validasi
$cek_tag =$mysqli->query( "SELECT * 
								FROM RETUR t
								JOIN RETUR_DETAIL d ON d.NORETUR=t.NORETUR 
								WHERE RETURVALIDASI='N' AND RETURISACTIVE='Y' AND FLAGBATAL='N' AND RETURDETAIL_IDITEM='$_POST[iditem]' 
									AND RETURDETAIL_ISACTIVE='Y' AND t.NORETUR!='$_POST[no_retur]' AND RETURID_DEPARTMENT='$_POST[id_department]' ");
// oci_execute($cek_tag);
$jml =mysqli_num_rows($cek_tag);

if($jml>0) { ?>
	<select name="lot_number" id="lot_number" class="form-control show-tick myLotNumber" data-live-search="on" >
		<option style="margin-left:20px;" value="0">Ada Retur yang belum validasi dengan Item ini</option>
	</select>
	<?php
} else {
	$sql =$mysqli->query( "SELECT IDITEMSTOCK,ITEMSTOCK_IDITEM,ITEMSTOCK_IDSATUAN,ITEMSTOCK_LOTNUMBER,ITEMSTOCK_ED,ITEMSTOCK_STOCK,NAMASATUAN
							FROM ITEMSTOCK i
							JOIN M_SATUAN s ON s.IDSATUAN=i.ITEMSTOCK_IDSATUAN
							WHERE ITEMSTOCK_IDITEM='$_POST[iditem]' AND ITEMSTOCK_IDDEPARTMENT='$_POST[id_department]' ");
	// oci_execute($sql);
	?>

	<select name="lot_number" id="lot_number" class="form-control show-tick myLotNumber" data-live-search="on" >
		<option style="margin-left:20px;" value="0">--PILIH LOT NUMBER--</option>
		<?php
		while ($s =mysqli_fetch_array($sql)) { ?>
			<option style="margin-left:20px;" value="<?php echo $s['ITEMSTOCK_LOTNUMBER'] ?>" id_satuan="<?php echo $s['ITEMSTOCK_IDSATUAN'] ?>" nm_satuan="<?php echo $s['NAMASATUAN'] ?>" ed="<?php echo $s['ITEMSTOCK_ED'] ?>" stock="<?php echo $s['ITEMSTOCK_STOCK'] ?>"><?php echo $s['ITEMSTOCK_LOTNUMBER'] ?> - [<?php echo $s['NAMASATUAN'] ?>]</option>
			<?php
		} ?>
	</select>
	<?php
}
?>


	<!-- Custom Js -->
    <script src="js/searchBar.js"></script>
	