<?php 
include ("../../config/connect.php");
$sql =$mysqli->query( "SELECT IDITEM,NAMAITEM,REPLACE(ITEM_IDSATUAN,'^',',') as IDSATUAN
										FROM M_ITEM 
										WHERE IDITEM='$_POST[iditem]'
										");
// oci_execute($sql);
$a =mysqli_fetch_array($sql);
	$satuan2 =array();
	$satuan =explode(',',$a['IDSATUAN']);
	foreach ($satuan as $nilai1) {
		array_push ($satuan2,"'". $nilai1."'");
	}
	$querySatuan = $mysqli->query( "SELECT IDITEM,NAMAITEM,IDSATUAN,group_concat(NAMASATUAN) AS NAMASATUAN
											FROM M_ITEM i 
											JOIN M_SATUAN s ON s.IDSATUAN IN (".join(", ",$satuan2).")
											WHERE ITEM_ISACTIVE='Y' AND IDITEM='$a[IDITEM]'
											GROUP BY IDITEM,NAMAITEM,IDSATUAN,NAMASATUAN
											ORDER BY NAMASATUAN ASC");
	//echo $querySatuan;
	// oci_execute($querySatuan);
	/*$data = array();
		while($row = mysqli_fetch_array($querySatuan)){ 
			//$data[] = array("id_satuan" => $row['IDSATUAN']);
			$html .= "<option value='".$row['IDSATUAN']."'>".$row['NAMASATUAN']."</option>";
		}
	$callback = array("id_satuan" => $html);

		echo json_encode($callback);*/

?>
<select name="satuan" id="satuan" class="form-control show-tick" data-live-search="on" >
	<option style="margin-left:20px;" value="0">-- PILIH SATUAN --</option>
	<?php
	while ($s =mysqli_fetch_array($querySatuan)) { ?>
		<option style="margin-left:20px;" value="<?php echo $s['IDSATUAN'] ?>"><?php echo $s['NAMASATUAN'] ?></option>
		<?php
	} ?>
</select>



	
	<!-- Custom Js -->
    <script src="js/searchBar.js"></script>