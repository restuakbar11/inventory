<?php
include "../../config/connect.php";
$id_gudang=$_POST['id_gudang'];
$queryGetRakGudang =$mysqli->query ( "SELECT ID_RAKGUDANG,NAMARAKGUDANG from M_RAKGUDANG 
	where RAKGUDANGAKTIF='Y' and ID_GUDANG='$id_gudang'");
// oci_execute($queryGetRakGudang);

echo "<select class='form-control' name='id_rakgudang' id='id_rakgudang'>
		<option value=0 selected >--Pilih Rak--</option>";
		while($k = mysqli_fetch_array($queryGetRakGudang)){
			echo "<option value='$k[ID_RAKGUDANG]'>$k[NAMARAKGUDANG]</option> \n";
		}
echo"</select>";
?>