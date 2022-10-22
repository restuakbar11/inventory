<?php
include ("../../config/connect.php");

$no_breakdown =$_POST['no_breakdown'];
$breakdown =$mysqli->query( "SELECT NOBREAKDOWN,d.ID_DEPARTMENT,d.ID_DEPARTMENT
									FROM BREAKDOWN k
									JOIN M_DEPARTMENT d ON d.ID_DEPARTMENT=k.ID_DEPARTMENT
									WHERE NOBREAKDOWN='$no_breakdown' AND ISACTIVE='Y'");
// oci_execute($breakdown);
$d =mysqli_fetch_array($breakdown);
$idDepartment =$d['ID_DEPARTMENT'];

//cek apakah ada BREAKDOWN yang belum di validasi
$cek_trans =$mysqli->query( "SELECT * 
								FROM BREAKDOWN k
								JOIN BREAKDOWN_DETAIL d ON d.NOBREAKDOWN=k.NOBREAKDOWN 
								WHERE k.NOBREAKDOWN!='$no_breakdown' AND VALIDASI='N' AND IDITEM='$_POST[iditem]' AND k.ID_DEPARTMENT='$idDepartment' AND d.ISACTIVE='Y'
									AND k.ISACTIVE='Y' AND k.FLAGBATAL='N' ");
// oci_execute($cek_trans);
$jml =mysqli_num_rows($cek_trans);

if($jml>0) { ?>
	<select name="lot_number" id="lot_number" class="form-control show-tick myLotNumber" data-live-search="on" >
		<option style="margin-left:20px;" value="0">Ada Transaksi Breakdown yang belum validasi dengan Item ini</option>
	</select>
	<?php
} else {
	$sql =$mysqli->query( "SELECT IDITEMSTOCK,ITEMSTOCK_IDITEM,ITEMSTOCK_IDSATUAN,ITEMSTOCK_LOTNUMBER,ITEMSTOCK_ED,ITEMSTOCK_STOCK,NAMASATUAN
							FROM ITEMSTOCK i
							JOIN M_SATUAN s ON s.IDSATUAN=i.ITEMSTOCK_IDSATUAN
							WHERE ITEMSTOCK_IDITEM='$_POST[iditem]' AND ITEMSTOCK_IDDEPARTMENT='$idDepartment' ");
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


    <!-- Select Plugin Js -->
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>
	
	<!-- Custom Js -->
    <script src="js/admin.js"></script>
	