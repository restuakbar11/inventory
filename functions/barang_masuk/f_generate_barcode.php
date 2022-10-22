<?php
error_reporting(0);
include "../../config/connect.php";
session_start();

date_default_timezone_set('Asia/Jakarta');
$now			=date('Y-m-d H:i:s');
$tgl			=date('ymd');
$bln			=date('m');
$username		=$_SESSION['username'];


switch ($_POST['act']){
	
	case "generate_barcode":
		//cek apakah item dengan nobarangmasuk_detail sudah di generate barcode
		$cek_barcode =$mysqli->query( "SELECT * FROM M_ITEMBARCODE WHERE BARANGMASUKDETAILIDMASUK='$_POST[nobarangmasuk_detail]' AND BARCODEISACTIVE='Y' ");
		// oci_execute($cek_barcode);
		$jml =mysqli_num_rows($cek_barcode);
		
		if($jml>0) {
			$data['hasil'] =0;
			$data['status'] ='error';
			$data['ket'] ='Sudah di proses Generate Barcode..';
		} else {
			//cek qty
			$cek_qty =$mysqli->query( "SELECT * FROM BARANG_MASUK_DETAIL WHERE BARANGMASUKDETAILISACTIVE='Y' AND NOBARANGMASUK_DETAIL='$_POST[nobarangmasuk_detail]' ");
			// oci_execute($cek_qty);
			$q =mysqli_fetch_array($cek_qty);
			$id_item =$q['BARANGMASUKDETAILM_ITEMID'];
			$id_satuan =$q['BARANGMASUKDETAILM_SATUANID'];
			$lot_number =$q['BARANGMASUKDETAILM_ITEMSTOCKLOTNUMBER'];
			$ed =$q['BARANGMASUKDETAIL_ED'];
			$qty =$q['BARANGMASUKDETAILQTY'];
			
			for($i=1; $i<=$qty; $i++) {
				//cek kode barcode max
				$barcode_max =$mysqli->query( "SELECT *
												FROM
													(SELECT M_ITEMIDITEM,KODEBARCODE,SUBSTR(LASTUPDATE, 6,2) AS BULAN,SUBSTR(KODEBARCODE, -5) AS COUNTER
														FROM M_ITEMBARCODE WHERE M_ITEMIDITEM='$_POST[id_item]'
														ORDER BY KODEBARCODE DESC
													) a
												
												ORDER BY KODEBARCODE DESC
												LIMIT 1");
				// oci_execute($barcode_max);
				$b =mysqli_fetch_array($barcode_max);
				
				if($bln==$b['BULAN']) {
					$counter =$b['COUNTER'] + 1;
					$seq = str_pad($counter,5,'0',STR_PAD_LEFT); 
					$kodebarcode =$_POST['id_item'].$tgl.$seq;
					
					//input di M_ITEMBARCODE
					$input =$mysqli->query( "INSERT INTO M_ITEMBARCODE
										(KODEBARCODE,M_ITEMIDITEM,BARANGMASUKDETAILIDMASUK,LASTUPDATE,USERID,ED,M_SATUANIDSATUAN,LOT_NUMBER)
										VALUES
										('$kodebarcode','$_POST[id_item]','$_POST[nobarangmasuk_detail]','$now','$username','$ed','$id_satuan','$lot_number')
										");
					// oci_execute($input);
					// oci_commit;
					if(!$input){
						$data['hasil']=0;
						$data['status'] ='failed';
						$data['ket'] ='Gagal';
					} else {
						$data['hasil']=1;
						$data['status'] ='success';
						$data['ket'] ='Berhasil';
					}
				} else {
					$counter =1;
					$seq = str_pad($counter,5,'0',STR_PAD_LEFT); 
					$kodebarcode =$_POST['id_item'].$tgl.$seq;
					
					//input di M_ITEMBARCODE
					$input =$mysqli->query( "INSERT INTO M_ITEMBARCODE
										(KODEBARCODE,M_ITEMIDITEM,BARANGMASUKDETAILIDMASUK,LASTUPDATE,USERID,ED,M_SATUANIDSATUAN,LOT_NUMBER)
										VALUES
										('$kodebarcode','$_POST[id_item]','$_POST[nobarangmasuk_detail]','$now','$username','$ed','$id_satuan','$lot_number')
										");
					// oci_execute($input);
					// oci_commit;
					if(!$input){
						$data['hasil']=0;
						$data['status'] ='failed';
						$data['ket'] ='Gagal';
					} else {
						$data['hasil']=1;
						$data['status'] ='success';
						$data['ket'] ='Berhasil';
					}
					
				}
			}
		}
		echo json_encode($data);
    break;
	
	
	
}