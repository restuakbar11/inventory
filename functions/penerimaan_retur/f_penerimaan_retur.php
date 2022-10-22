<?php
error_reporting(0);
include "../../config/connect.php";
session_start();


date_default_timezone_set('Asia/Jakarta');
$now			=date('Y-m-d H:i:s');
$username		=$_SESSION['username'];


switch ($_POST['act']){
	
	case "terima_retur":
		$update_flag_terima =$mysqli->query( "UPDATE RETUR SET 
												RETURTERIMA				='Y',
												RETURTERIMAUSERNAME		='$username',
												RETURTERIMATANGGAL		='$now'
											WHERE NORETUR='$_POST[no_retur]' ");
		// oci_execute($update_flag_terima);
		// oci_commit;
		
		//menambah stok pada department tujuan (pusat) di table ITEMSTOCK 
		include '../department/queryDepartmentUtama.php';
		$z =mysqli_fetch_array($queryGetDepartment);
		$idDepartmentUtama =$z['ID_DEPARTMENT'];
		
		$item =$mysqli->query( "SELECT * FROM RETUR_DETAIL WHERE NORETUR='$_POST[no_retur]' AND RETURDETAIL_ISACTIVE='Y' ");
		// oci_execute($item);
		while ($i =mysqli_fetch_array($item)) {
			$cek_itemstock =$mysqli->query( "SELECT * FROM ITEMSTOCK WHERE ITEMSTOCK_IDITEM='$i[RETURDETAIL_IDITEM]' AND ITEMSTOCK_IDSATUAN='$i[RETURDETAIL_IDSATUAN]' 
												AND ITEMSTOCK_LOTNUMBER='$i[RETURDETAIL_LOTNUMBER]' AND ITEMSTOCK_ED='$i[RETURDETAIL_ED]' 
												AND ITEMSTOCK_IDDEPARTMENT='$idDepartmentUtama' ");
			// oci_execute($cek_itemstock);
			$ada =mysqli_num_rows($cek_itemstock);
			if($ada>0) {
				$id_itemstock =$mysqli->query( "SELECT * FROM ITEMSTOCK WHERE ITEMSTOCK_IDITEM='$i[RETURDETAIL_IDITEM]' AND ITEMSTOCK_IDSATUAN='$i[RETURDETAIL_IDSATUAN]' 
												AND ITEMSTOCK_LOTNUMBER='$i[RETURDETAIL_LOTNUMBER]' AND ITEMSTOCK_ED='$i[RETURDETAIL_ED]' 
												AND ITEMSTOCK_IDDEPARTMENT='$idDepartmentUtama' ");
				// oci_execute($id_itemstock);
				$s =mysqli_fetch_array($id_itemstock);
				$iditemstock =$s['IDITEMSTOCK'];
				$stock_awal =$s['ITEMSTOCK_STOCK'];
				$stock_akhir =$stock_awal + $i['RETURDETAIL_QTY'];
				
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
											('$now','$iditemstock','$idDepartmentUtama','$stock_awal','$i[RETURDETAIL_QTY]','0','$stock_akhir',
											'PENERIMAAN RETUR','$_POST[no_retur]')
											");
				// oci_execute($input);
				// oci_commit;
			} else {
				$input_stock =$mysqli->query( "INSERT INTO ITEMSTOCK
												(ITEMSTOCK_IDITEM,ITEMSTOCK_IDSATUAN,ITEMSTOCK_LOTNUMBER,ITEMSTOCK_ED,ITEMSTOCK_STOCK,
												ITEMSTOCK_IDDEPARTMENT,ITEMSTOCK_USERNAME,ITEMSTOCK_LASTUPDATE) 
												VALUES
												('$i[RETURDETAIL_IDITEM]','$i[RETURDETAIL_IDSATUAN]','$i[RETURDETAIL_LOTNUMBER]','$i[RETURDETAIL_ED]','$i[RETURDETAIL_QTY]',
												'$idDepartmentUtama','$username','$now')
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
											('$now','$iditemstock','$idDepartmentUtama','0','$i[RETURDETAIL_QTY]','0','$i[RETURDETAIL_QTY]',
											'PENERIMAAN RETUR','$_POST[no_retur]')
											");
				// oci_execute($input);
				// oci_commit;
			}
			//mengubah qty terima dari RETUR_DETAIL
			$updatedetail =$mysqli->query( "UPDATE RETUR_DETAIL SET 
												RETURDETAIL_QTYTERIMA	='$i[RETURDETAIL_QTY]',
												RETURDETAIL_USERNAME	='$username',
												RETURDETAIL_LASTUPDATE	='$now'
											WHERE NORETUR_DETAIL='$i[NORETUR_DETAIL]' ");
			// oci_execute($updatedetail);
			// oci_commit;
			
			//mengubah flagditerima pada RETUR_DETAIL_BARCODE
			$updatedetailbarcode =$mysqli->query( "UPDATE RETUR_DETAIL_BARCODE SET 
													FLAGDITERIMA	='Y',
													TANGGALTERIMA	='$now'
												WHERE NORETUR_DETAIL='$i[NORETUR_DETAIL]' ");
			// oci_execute($updatedetailbarcode);
			// oci_commit;
		}
		$data['hasil']=1;
		echo json_encode($data);
	break;
	
	/* case "checkin_barcode":
		//cek apakah kode barcode ada/valid
		$cek =$mysqli->query( "SELECT t.NORETUR,b.KODEBARCODE,d.NORETUR_DETAIL
								FROM RETUR_DETAIL_BARCODE b
								JOIN RETUR_DETAIL d ON d.NORETUR_DETAIL=b.NORETUR_DETAIL AND RETURDETAIL_ISACTIVE='Y'
								JOIN RETUR t ON t.NORETUR=d.NORETUR AND RETURISACTIVE='Y'
								WHERE b.KODEBARCODE='$_POST[barcode]' AND t.NORETUR='$_POST[no_retur]' ");
		// oci_execute($cek);
		$cek_jml =mysqli_num_rows($cek);
		
		if($cek_jml==0) {
			$data['hasil']=0;
			$data['judul']='ERROR';
			$data['status']='error';
			$data['ket']='Kode Barcode tidak valid...';
		} else {
			//mencari id_department tujuan dan cek apakah qtyditerima sudah diterima sesuai qty RETUR
			$tag_detail =$mysqli->query( "SELECT KODEBARCODE,t.NORETUR,d.NORETUR_DETAIL,RETURID_DEPARTMENT,RETURDETAIL_QTY,RETURDETAILTERIMA,FLAGDITERIMA
												FROM RETUR_DETAIL_BARCODE b
												JOIN RETUR_DETAIL d ON d.NORETUR_DETAIL=b.NORETUR_DETAIL AND RETURDETAIL_ISACTIVE='Y'
												JOIN RETUR t ON t.NORETUR=d.NORETUR AND RETURISACTIVE='Y'
												WHERE b.KODEBARCODE='$_POST[barcode]' AND t.NORETUR='$_POST[no_retur]' ");
			// oci_execute($tag_detail);
			$r =mysqli_fetch_array($tag_detail);
			$notag_detail =$r['NORETUR_DETAIL'];
			$id_department =$r['RETURID_DEPARTMENT'];
			$qty =$r['RETURDETAIL_QTY'];
			$qtyterima =$r['RETURDETAILTERIMA'];
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
				$data['ket']='Qty Terima Item ini sudah sesuai qty RETUR.. Action Check In hanya mengaupdate lokasi Gudang dan Rak Gudang..';
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
				//mengubah qty terpenuhi dari RETUR_DETAIL
				$hasil =$qtyterima + 1;
				$updatedetail =$mysqli->query( "UPDATE RETUR_DETAIL SET 
													RETURDETAILTERIMA		='$hasil',
													RETURDETAILUSERNAME	='$username',
													RETURDETAILLASTUPDATE	='$now'
												WHERE NORETUR_DETAIL='$notag_detail' ");
				// oci_execute($updatedetail);
				// oci_commit;
				
				//mengubah flagditerima pada RETUR_DETAIL_BARCODE
				$updatedetailbarcode =$mysqli->query( "UPDATE RETUR_DETAIL_BARCODE SET 
														FLAGDITERIMA	='Y',
														TANGGALDITERIMA	='$now'
													WHERE NORETUR_DETAIL='$notag_detail' AND KODEBARCODE='$_POST[barcode]' ");
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
				
				//mengubah tagterima menjadi 'Y' pada table RETUR jika sudah diterima semua
				$cek_terima =$mysqli->query( "SELECT COUNT(NORETUR) AS TOTAL,SUM(NILAI) AS NILAI
												FROM
												(
													SELECT NORETUR,RETURDETAIL_QTY,RETURDETAILTERIMA,CASE WHEN RETURDETAIL_QTY=RETURDETAILTERIMA THEN 1 ELSE 0 END NILAI
													FROM RETUR_DETAIL 
													WHERE NORETUR='$_POST[no_retur]'
												) s
												GROUP BY NORETUR");
				// oci_execute($cek_terima);
				$v =mysqli_fetch_array($cek_terima);
				if($v['TOTAL']==$v['NILAI']) {
					$update_flag_terima =$mysqli->query( "UPDATE RETUR SET 
															RETURTERIMA			='Y',
															RETURTERIMA_USERNAME	='$username',
															RETURTERIMA_TANGGAL	='$now'
														WHERE NORETUR='$_POST[no_retur]' ");
					// oci_execute($update_flag_terima);
					// oci_commit;
					
					//menambah stok pada department tujuan di table ITEMSTOCK 
					$item =$mysqli->query( "SELECT * FROM RETUR_DETAIL WHERE NORETUR='$_POST[no_retur]' AND RETURDETAIL_ISACTIVE='Y' ");
					// oci_execute($item);
					while ($i =mysqli_fetch_array($item)) {
						$cek_itemstock =$mysqli->query( "SELECT * FROM ITEMSTOCK WHERE ITEMSTOCK_IDITEM='$i[RETURDETAIL_IDITEM]' AND ITEMSTOCK_IDSATUAN='$i[RETURDETAIL_IDSATUAN]' 
															AND ITEMSTOCK_LOTNUMBER='$i[RETURDETAIL_LOTNUMBER]' AND ITEMSTOCK_ED='$i[RETURDETAIL_ED]' 
															AND ITEMSTOCK_IDDEPARTMENT='$id_department' ");
						// oci_execute($cek_itemstock);
						$ada =mysqli_num_rows($cek_itemstock);
						if($ada>0) {
							$id_itemstock =$mysqli->query( "SELECT * FROM ITEMSTOCK WHERE ITEMSTOCK_IDITEM='$i[RETURDETAIL_IDITEM]' AND ITEMSTOCK_IDSATUAN='$i[RETURDETAIL_IDSATUAN]' 
															AND ITEMSTOCK_LOTNUMBER='$i[RETURDETAIL_LOTNUMBER]' AND ITEMSTOCK_ED='$i[RETURDETAIL_ED]' 
															AND ITEMSTOCK_IDDEPARTMENT='$id_department' ");
							// oci_execute($id_itemstock);
							$s =mysqli_fetch_array($id_itemstock);
							$iditemstock =$s['IDITEMSTOCK'];
							$stock_awal =$s['ITEMSTOCK_STOCK'];
							$stock_akhir =$stock_awal + $i['RETURDETAIL_QTY'];
							
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
														('$now','$iditemstock','$id_department','$stock_awal','$i[RETURDETAIL_QTY]','0','$stock_akhir',
														'PENERIMAAN RETUR','$_POST[no_retur]')
														");
							// oci_execute($input);
							// oci_commit;
						} else {
							$input_stock =$mysqli->query( "INSERT INTO ITEMSTOCK
															(ITEMSTOCK_IDITEM,ITEMSTOCK_IDSATUAN,ITEMSTOCK_LOTNUMBER,ITEMSTOCK_ED,ITEMSTOCK_STOCK,
															ITEMSTOCK_IDDEPARTMENT,ITEMSTOCK_USERNAME,ITEMSTOCK_LASTUPDATE) 
															VALUES
															('$i[RETURDETAIL_IDITEM]','$i[RETURDETAIL_IDSATUAN]','$i[RETURDETAIL_LOTNUMBER]','$i[RETURDETAIL_ED]','$i[RETURDETAIL_QTY]',
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
														('$now','$iditemstock','$id_department','0','$i[RETURDETAIL_QTY]','0','$i[RETURDETAIL_QTY]',
														'PENERIMAAN RETUR','$_POST[no_retur]')
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
	 */
}