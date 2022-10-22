<?php
include "../../config/connect.php";
$id_departmen=$_POST['id_department'];
$id_rakgudang=$_POST['id_rakgudang'];
if($id_rakgudang==''){
	$queryGetGudangALL =$mysqli->query ( "SELECT ID_GUDANG,NAMAGUDANG from M_GUDANG 
	where GUDANGAKTIF='Y' and ID_DEPARTMENT='$id_departmen'");
// oci_execute($queryGetGudangALL);

echo "<select class='form-control rakgudang' name='id_gudang' id='id_gudang'>
		<option value=0 selected >--Pilih Gudang--</option>";
		while($k = mysqli_fetch_array($queryGetGudangALL)){
			echo "<option value='$k[ID_GUDANG]'>$k[NAMAGUDANG]</option> \n";
		}
echo"</select>";
}
else {
	$queryGetGudangALL =$mysqli->query ( "SELECT b.ID_GUDANG,b.NAMAGUDANG from M_RAKGUDANG a
	JOIN M_GUDANG b on a.ID_GUDANG=b.ID_GUDANG and b.GUDANGAKTIF='Y' 
	where a.ID_RAKGUDANG='$id_rakgudang'");
// oci_execute($queryGetGudangALL);

echo "<select class='form-control rakgudang' name='id_gudang' id='id_gudang'>";
		$k = mysqli_fetch_array($queryGetGudangALL);
			echo "<option value='$k[ID_GUDANG]'>$k[NAMAGUDANG]</option> \n";
		
echo"</select>";
}

?>