<?php
include ("../../config/connect.php");

$no_barang_keluar =$_POST['no_barang_keluar'];
$barang_keluar =$mysqli->query( "SELECT NOBARANGKELUAR,d.ID_SUBDEPARTMENT,d.ID_DEPARTMENT
									FROM BARANG_KELUAR k
									JOIN M_SUBDEPARTMENT d ON d.ID_SUBDEPARTMENT=k.BARANGKELUARID_SUBDEPARTMENT
									WHERE NOBARANGKELUAR='$no_barang_keluar' AND BARANGKELUARISACTIVE='Y'");
// oci_execute($barang_keluar);
$d =mysqli_fetch_array($barang_keluar);
$idDepartment =$d['ID_DEPARTMENT'];

//cek apakah ada BARANG_KELUAR yang belum di validasi
$cek_tag =$mysqli->query( "SELECT * 
								FROM BARANG_KELUAR k
								JOIN BARANG_KELUAR_DETAIL d ON d.NOBARANGKELUAR=k.NOBARANGKELUAR 
								WHERE k.NOBARANGKELUAR!='$no_barang_keluar' AND BARANGKELUARVALIDASI='N' AND BARANGKELUARISACTIVE='Y' AND BARANGKELUARFLAGBATAL='N' AND
								BARANGKELUARDETAILIDITEM='$_POST[iditem]' AND BARANGKELUARDETAILISACTIVE='Y' AND BARANGKELUARID_DEPARTMENT='$idDepartment' ");
// oci_execute($cek_tag);
$jml =mysqli_num_rows($cek_tag);

if($jml>0) { ?>
	<select name="lot_number" id="lot_number" class="form-control show-tick myLotNumber" data-live-search="on" >
		<option style="margin-left:20px;" value="0">Ada Transaksi Barang Keluar yang belum validasi dengan Item ini</option>
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

	<!-- Custom Js -->
    <script src="js/searchBar.js"></script>