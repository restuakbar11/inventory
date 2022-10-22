<?php
error_reporting(0);
include "../../config/connect.php";
session_start();


date_default_timezone_set('Asia/Jakarta');
$now			=date('Y-m-d H:i:s');
$username		=$_SESSION['username'];


switch ($_POST['act']){
	
	case "checkin_barcode":
		//cek apakah kode barcode ada/valid
		$cek =$mysqli->query( "SELECT t.NOTAG,b.KODEBARCODE,d.NOTAG_DETAIL
								FROM TAG_DETAIL_BARCODE b
								JOIN TAG_DETAIL d ON d.NOTAG_DETAIL=b.NOTAG_DETAIL AND TAGDETAILISACTIVE='Y'
								JOIN TAG t ON t.NOTAG=d.NOTAG AND TAGISACTIVE='Y'
								WHERE b.KODEBARCODE='$_POST[barcode]' AND t.NOTAG='$_POST[no_tag]' ");
		// oci_execute($cek);
		$cek_jml =mysqli_num_rows($cek);
		
		if($cek_jml==0) {
			$data['hasil']=0;
			$data['judul']='ERROR';
			$data['status']='error';
			$data['ket']='Kode Barcode tidak valid...';
		} else {
			//mencari id_department tujuan dan cek apakah qtyditerima sudah diterima sesuai qty TAG
			$tag_detail =$mysqli->query( "SELECT KODEBARCODE,t.NOTAG,d.NOTAG_DETAIL,TAGID_DEPARTMENT,TAGDETAILQTY,TAGDETAILTERIMA,FLAGDITERIMA
												FROM TAG_DETAIL_BARCODE b
												JOIN TAG_DETAIL d ON d.NOTAG_DETAIL=b.NOTAG_DETAIL AND TAGDETAILISACTIVE='Y'
												JOIN TAG t ON t.NOTAG=d.NOTAG AND TAGISACTIVE='Y'
												WHERE b.KODEBARCODE='$_POST[barcode]' AND t.NOTAG='$_POST[no_tag]' ");
			// oci_execute($tag_detail);
			$r =mysqli_fetch_array($tag_detail);
			$notag_detail =$r['NOTAG_DETAIL'];
			$id_department =$r['TAGID_DEPARTMENT'];
			$qty =$r['TAGDETAILQTY'];
			$qtyterima =$r['TAGDETAILTERIMA'];
			$flagditerima =$r['FLAGDITERIMA'];
			
			if($qty==$qtyterima) {
				//update id_gudang dan id_rakgudang pada M_ITEMBARCODE
				$update_itembarcode =$mysqli->query( "UPDATE M_ITEMBARCODE SET 
															IDGUDANG	='$_POST[gudang]',
															IDRAKGUDANG	='$_POST[rak_gudang]',
															USERID		='$username',
															LASTUPDATE	='$now'
														WHERE KODEBARCODE='$_POST[barcode]' ");
				// oci_execute($update_itembarcode);
				// oci_commit;
				
				$data['hasil']=0;
				$data['judul']='WARNING';
				$data['status']='warning';
				$data['ket']='Qty Terima Item ini sudah sesuai qty TAG.. Action Check In hanya mengaupdate lokasi Gudang dan Rak Gudang..';
			} else if($flagditerima=='Y') {
				//update id_gudang dan id_rakgudang pada M_ITEMBARCODE
				$update_itembarcode =$mysqli->query( "UPDATE M_ITEMBARCODE SET 
															IDGUDANG	='$_POST[gudang]',
															IDRAKGUDANG	='$_POST[rak_gudang]',
															USERID		='$username',
															LASTUPDATE	='$now'
														WHERE KODEBARCODE='$_POST[barcode]' ");
				// oci_execute($update_itembarcode);
				// oci_commit;
				
				$data['hasil']=0;
				$data['judul']='WARNING';
				$data['status']='warning';
				$data['ket']='Kode Barcode sudah di scan terima... Action Check In ini hanya mengupdate lokasi Gudang dan Rak Gudang..';
			} else {
				//mengubah qty terpenuhi dari TAG_DETAIL
				$hasil =$qtyterima + 1;
				$updatedetail =$mysqli->query( "UPDATE TAG_DETAIL SET 
													TAGDETAILTERIMA		='$hasil',
													TAGDETAILUSERNAME	='$username',
													TAGDETAILLASTUPDATE	='$now'
												WHERE NOTAG_DETAIL='$notag_detail' ");
				// oci_execute($updatedetail);
				// oci_commit;
				
				//mengubah flagditerima pada TAG_DETAIL_BARCODE
				$updatedetailbarcode =$mysqli->query( "UPDATE TAG_DETAIL_BARCODE SET 
														FLAGDITERIMA	='Y',
														TANGGALDITERIMA	='$now'
													WHERE NOTAG_DETAIL='$notag_detail' AND KODEBARCODE='$_POST[barcode]' ");
				// oci_execute($updatedetailbarcode);
				// oci_commit;
				
				//update id_gudang dan id_rakgudang pada M_ITEMBARCODE
				$update_itembarcode =$mysqli->query( "UPDATE M_ITEMBARCODE SET 
															IDGUDANG	='$_POST[gudang]',
															IDRAKGUDANG	='$_POST[rak_gudang]',
															USERID		='$username',
															LASTUPDATE	='$now'
														WHERE KODEBARCODE='$_POST[barcode]' ");
				// oci_execute($update_itembarcode);
				// oci_commit;
				
				//mengubah tagterima menjadi 'Y' pada table TAG jika sudah diterima semua
				$cek_terima =$mysqli->query( "SELECT COUNT(NOTAG) AS TOTAL,SUM(NILAI) AS NILAI
												FROM
												(
													SELECT NOTAG,TAGDETAILQTY,TAGDETAILTERIMA,CASE WHEN TAGDETAILQTY=TAGDETAILTERIMA THEN 1 ELSE 0 END NILAI
													FROM TAG_DETAIL 
													WHERE NOTAG='$_POST[no_tag]' AND TAGDETAILISACTIVE='Y'
												) s
												GROUP BY NOTAG");
				// oci_execute($cek_terima);
				$v =mysqli_fetch_array($cek_terima);
				if($v['TOTAL']==$v['NILAI']) {
					$update_flag_terima =$mysqli->query( "UPDATE TAG SET 
															TAGTERIMA			='Y',
															TAGTERIMA_USERNAME	='$username',
															TAGTERIMA_TANGGAL	='$now'
														WHERE NOTAG='$_POST[no_tag]' ");
					// oci_execute($update_flag_terima);
					// oci_commit;
					
					//menambah stok pada department tujuan di table ITEMSTOCK 
					$item =$mysqli->query( "SELECT * FROM TAG_DETAIL WHERE NOTAG='$_POST[no_tag]' AND TAGDETAILISACTIVE='Y' ");
					// oci_execute($item);
					while ($i =mysqli_fetch_array($item)) {
						$cek_itemstock =$mysqli->query( "SELECT * FROM ITEMSTOCK WHERE ITEMSTOCK_IDITEM='$i[TAGDETAILM_ITEMID]' AND ITEMSTOCK_IDSATUAN='$i[TAGDETAILM_SATUANID]' 
															AND ITEMSTOCK_LOTNUMBER='$i[TAGDETAILM_ITEMSTOCKLOTNUMBER]' AND ITEMSTOCK_ED='$i[TAGDETAILED]' 
															AND ITEMSTOCK_IDDEPARTMENT='$id_department' ");
						// oci_execute($cek_itemstock);
						$ada =mysqli_num_rows($cek_itemstock);
						if($ada>0) {
							$id_itemstock =$mysqli->query( "SELECT * FROM ITEMSTOCK WHERE ITEMSTOCK_IDITEM='$i[TAGDETAILM_ITEMID]' AND ITEMSTOCK_IDSATUAN='$i[TAGDETAILM_SATUANID]' 
															AND ITEMSTOCK_LOTNUMBER='$i[TAGDETAILM_ITEMSTOCKLOTNUMBER]' AND ITEMSTOCK_ED='$i[TAGDETAILED]' 
															AND ITEMSTOCK_IDDEPARTMENT='$id_department' ");
							// oci_execute($id_itemstock);
							$s =mysqli_fetch_array($id_itemstock);
							$iditemstock =$s['IDITEMSTOCK'];
							$stock_awal =$s['ITEMSTOCK_STOCK'];
							$stock_akhir =$stock_awal + $i['TAGDETAILQTY'];
							
							$update_stock =$mysqli->query( "UPDATE ITEMSTOCK SET 
																ITEMSTOCK_STOCK		='$stock_akhir',
																ITEMSTOCK_USERNAME	='$username',
																ITEMSTOCK_LASTUPDATE ='$now'
															WHERE IDITEMSTOCK='$iditemstock' ");
							// oci_execute($update_stock);
							// oci_commit;
							
							//insert item stock history
							$input =$mysqli->query( "INSERT INTO ITEMSTOCK_HISTORY 
														(TANGGAL,IDITEMSTOCK,DEPARTMENTID,STOCKAWAL,STOCKIN,STOCKOUT,STOCKAKHIR,
														CATATAN,NOTRANSAKSI) VALUES
														('$now','$iditemstock','$id_department','$stock_awal','$i[TAGDETAILQTY]','0','$stock_akhir',
														'PENERIMAAN TAG','$_POST[no_tag]')
														");
							// oci_execute($input);
							// oci_commit;
						} else {
							$input_stock =$mysqli->query( "INSERT INTO ITEMSTOCK
															(ITEMSTOCK_IDITEM,ITEMSTOCK_IDSATUAN,ITEMSTOCK_LOTNUMBER,ITEMSTOCK_ED,ITEMSTOCK_STOCK,
															ITEMSTOCK_IDDEPARTMENT,ITEMSTOCK_USERNAME,ITEMSTOCK_LASTUPDATE) 
															VALUES
															('$i[TAGDETAILM_ITEMID]','$i[TAGDETAILM_SATUANID]','$i[TAGDETAILM_ITEMSTOCKLOTNUMBER]','$i[TAGDETAILED]','$i[TAGDETAILQTY]',
															'$id_department','$username','$now')
															");
							// oci_execute($input_stock);
							// oci_commit;
							
							$id_max =$mysqli->query( "SELECT max(IDITEMSTOCK) AS IDITEMSTOCK FROM ITEMSTOCK");
							// oci_execute($id_max);
							$m =mysqli_fetch_array($id_max);
							$iditemstock =$m['IDITEMSTOCK'];
							
							//insert item stock history
							$input =$mysqli->query( "INSERT INTO ITEMSTOCK_HISTORY 
														(TANGGAL,IDITEMSTOCK,DEPARTMENTID,STOCKAWAL,STOCKIN,STOCKOUT,STOCKAKHIR,
														CATATAN,NOTRANSAKSI) VALUES
														('$now','$iditemstock','$id_department','0','$i[TAGDETAILQTY]','0','$i[TAGDETAILQTY]',
														'PENERIMAAN TAG','$_POST[no_tag]')
														");
							// oci_execute($input);
							// oci_commit;
						}
					}
					$data['hasil']=2;
					$data['lengkap']=1;
				} else {
					$data['hasil']=2;
					$data['lengkap']=0;
				}
			}
		}
		echo json_encode($data);
	break;
	
}