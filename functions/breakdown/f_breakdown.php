<?php
error_reporting(0);
include "../../config/connect.php";
session_start();
include "../numbering/f_numbering.php";
$conn ="../../config/connect.php";


date_default_timezone_set('Asia/Jakarta');
$now			=date('Y-m-d H:i:s');
$bln			=strtoupper(date('M'));
$username		=$_SESSION['username'];


switch ($_POST['act']){
	
	case "save_header":
		if($_POST['aksi']=='add') {
			$cek_name =$mysqli->query( "SELECT * FROM BREAKDOWN WHERE NOBREAKDOWN='$_POST[no_breakdown]' ");
			// oci_execute($cek_name);
			$jml =mysqli_num_rows($cek_name);
			
			if($jml>0) {
				$data['hasil']=0;
			} else {
				$number =Numbering('Breakdown', $conn);
				$tgl =$_POST['tanggal'];
				$input =$mysqli->query( "INSERT INTO BREAKDOWN 
											(NOBREAKDOWN,ID_DEPARTMENT,TANGGAL,NOTE,USERNAME,LASTUPDATE) VALUES
											('$number','$_POST[id_department]','$tgl','$_POST[note]','$username','$now')
											") ;
					// oci_execute($input);
					// oci_commit;
				if(!$input){
					$data['hasil']=0;
				} else {
					$data['hasil']=1;
					$data['tgl']=$tgl;
				}
					
			}
		} else if($_POST['aksi']=='update') {
			$tgl =date('Y-m-d',strtotime($_POST['tanggal']));
			$update =$mysqli->query( "UPDATE BREAKDOWN SET 
											ID_DEPARTMENT	='$_POST[id_subdepartment]',
											TANGGAL				='$tgl',
											NOTE				='$_POST[note]',
											USERNAME			='$username',
											LASTUPDATE			='$now'
										WHERE NOBREAKDOWN='$_POST[no_breakdown]' ");
			if(!$update){
				$data['hasil']=0;
			} else {
				$data['hasil']=1;
				$data['tgl']=$tgl;
			}
		}
		
		echo json_encode($data);
    break;
	
	
	
	case "getHeader":
		$sql =$mysqli->query( "SELECT * FROM BREAKDOWN WHERE NOBREAKDOWN='$_POST[no_breakdown]' ");
		// oci_execute($sql);
		$r =mysqli_fetch_array($sql);
		
		$tgl =date('Y-m-d',strtotime($r['TANGGAL']));
		$data['ID_DEPARTMENT']		=$r['ID_DEPARTMENT'];
		$data['TANGGAL']			=$tgl;
		$data['NOTE']				=$r['NOTE'];
		echo json_encode($data);
    break;
	
	
	
	case "scan_barcode":
		//cek barcode apakah dari department yg sama dg header dan masih aktif
		$cek_barcode =$mysqli->query( "SELECT * FROM M_ITEMBARCODE WHERE KODEBARCODE='$_POST[kodebarcode]' AND BARCODEISACTIVE='Y' AND M_DEPARTMENTDEPARTMENTID='$_POST[id_department]'");
		// oci_execute($cek_barcode);
		$jml =mysqli_num_rows($cek_barcode);
		if($jml==0) {
			$data['hasil']=0;
			$data['judul']='WARNING';
			$data['ket']='Kode Barcode tidak valid/tidak sesuai department yang di pilih..';
			$data['status']='warning';
		} else {
			$barcode =$mysqli->query( "SELECT * 
							FROM M_ITEMBARCODE b
							JOIN M_ITEM i ON i.IDITEM=b.M_ITEMIDITEM AND ITEM_ISACTIVE='Y'
							JOIN M_SATUAN s ON s.IDSATUAN=b.M_SATUANIDSATUAN AND SATUANISACTIVE='Y'
							WHERE KODEBARCODE='$_POST[kodebarcode]' AND BARCODEISACTIVE='Y' AND M_DEPARTMENTDEPARTMENTID='$_POST[id_department]'");
			// oci_execute($barcode);
			$b =mysqli_fetch_array($barcode);
			$data['hasil']=1;
			$data['M_ITEMIDITEM']=$b['M_ITEMIDITEM'];
			$data['M_SATUANIDSATUAN']=$b['M_SATUANIDSATUAN'];
			$data['NAMAITEM']=$b['NAMAITEM'];
			$data['NAMASATUAN']=$b['NAMASATUAN'];
		}
		echo json_encode($data);
	break;
	
	
	
	
	case "save_item":
		$cek =$mysqli->query( "SELECT NOBREAKDOWN,NOBREAKDOWNDETAIL,count(NOBREAKDOWNDETAIL) as JML 
								FROM BREAKDOWN_DETAIL 
								WHERE NOBREAKDOWN='$_POST[no_breakdown]' AND KODEBARCODE_HEADER='$_POST[kodebarcode]' AND ISACTIVE='Y' 
								GROUP BY NOBREAKDOWNDETAIL,NOBREAKDOWN");
		// oci_execute($cek);
		$r =mysqli_fetch_array($cek);
		
		if($r['JML']!='') {
			$data['hasil']=0;
			$data['judul']='WARNING';
			$data['ket']='Kode Barcode sudah digunakan..';
			$data['status']='warning';
		} else {
			$no_max =$mysqli->query( "SELECT *
									FROM
									(
										SELECT NOBREAKDOWN,NOBREAKDOWNDETAIL,SUBSTR(NOBREAKDOWNDETAIL,-3,3) AS COUNTER
											FROM BREAKDOWN_DETAIL 
											WHERE NOBREAKDOWN='$_POST[no_breakdown]'
											ORDER BY NOBREAKDOWNDETAIL DESC
									) a
									
									ORDER BY NOBREAKDOWNDETAIL DESC
									LIMIT 1");
			// oci_execute($no_max);
			$n =mysqli_fetch_array($no_max);
			$seq =$n['COUNTER'] + 1;
			$counter =str_pad($seq,3,'0',STR_PAD_LEFT); 
			$nobreakdown_detail =$_POST['no_breakdown'].'-'.$counter;
			
			
			$input =$mysqli->query( "INSERT INTO BREAKDOWN_DETAIL
									(NOBREAKDOWN,IDSATUAN_AKHIR,QTY_AWAL,QTY_AKHIR,USERNAME,LASTUPDATE,NOBREAKDOWNDETAIL,KODEBARCODE_HEADER) VALUES
									('$_POST[no_breakdown]','$_POST[id_satuan_akhir]','$_POST[qty_awal]','$_POST[qty_akhir]','$username','$now','$nobreakdown_detail','$_POST[kodebarcode]')");
			// oci_execute($input);
			// oci_commit;
			$data['hasil']=1;
			$data['no']=$nobreakdown_detail;
		}
		echo json_encode($data);
	break;
	
	
	
	case "hapusitem":
		$update =$mysqli->query ( "UPDATE BREAKDOWN_DETAIL SET 
										ISACTIVE 	='N',
										USERNAME	='$username',
										LASTUPDATE	='$now'
									WHERE NOBREAKDOWNDETAIL='$_POST[nobreakdown_detail]' ");
		// oci_execute($update);
		// oci_commit;
		$data['hasil']=1;
		echo json_encode($data);
	break;
	
	
	
	case "hapusbreakdown":
		$update =$mysqli->query ( "UPDATE BREAKDOWN SET 
										ISACTIVE 	='N',
										USERNAME	='$username',
										LASTUPDATE	='$now'
									WHERE NOBREAKDOWN='$_POST[no_breakdown]' ");
		// oci_execute($update);
		// oci_commit;
		$data['hasil']=1;
		echo json_encode($data);
	break;
	
	
	
	case "validasi_breakdown":
		//cek apakah transaksi breakdown sudah di validasi
		$cek_validasi =$mysqli->query( "SELECT * FROM BREAKDOWN WHERE NOBREAKDOWN='$_POST[no_breakdown]' ");
		// oci_execute($cek_validasi);
		$cv =mysqli_fetch_array($cek_validasi);
		
		if($cv['VALIDASI']=='Y' OR $cv['VALIDASI']=='C') {
			$data['hasil']=0;
			$data['judul']='WARNING';
			$data['status']='warning';
			$data['ket']='Transaksi ini Sudah di Validasi...';
		} else {
			//mencari id_department dari no_breakdown ini
			$department =$mysqli->query( "SELECT NOBREAKDOWN,ID_DEPARTMENT 
											FROM BREAKDOWN 
											WHERE NOBREAKDOWN='$_POST[no_breakdown]' ");
			// oci_execute($department);
			$d =mysqli_fetch_array($department);
			$id_department =$d['ID_DEPARTMENT'];
			
			$tampil =$mysqli->query( "SELECT * 
									FROM BREAKDOWN_DETAIL d
									JOIN M_ITEMBARCODE b ON b.KODEBARCODE=d.KODEBARCODE_HEADER AND BARCODEISACTIVE='Y'
									WHERE NOBREAKDOWN='$_POST[no_breakdown]' AND ISACTIVE='Y' ");
			// oci_execute($tampil);
			while ($t =mysqli_fetch_array($tampil)) {
				//mengurangi stock di department dengan qty awal
				$itemStock =$mysqli->query ( "SELECT * FROM ITEMSTOCK WHERE ITEMSTOCK_IDITEM='$t[M_ITEMIDITEM]' AND ITEMSTOCK_IDSATUAN='$t[M_SATUANIDSATUAN]' AND 
											ITEMSTOCK_LOTNUMBER='$t[LOT_NUMBER]' AND TO_DATE(ITEMSTOCK_ED, 'dd-MM-yy')='$t[ED]' AND 
											ITEMSTOCK_IDDEPARTMENT='$id_department' ");
				// oci_execute($itemStock);
				$i =mysqli_fetch_array($itemStock);
				$idItemStock =$i['IDITEMSTOCK'];
				$stock_awal =$i['ITEMSTOCK_STOCK'];
				
				$stock_akhir =$stock_awal - $t['QTY_AWAL'];
				$update =$mysqli->query ( "UPDATE ITEMSTOCK SET
												ITEMSTOCK_STOCK			='$stock_akhir',
												ITEMSTOCK_USERNAME		='$username',
												ITEMSTOCK_LASTUPDATE	='$now'
											WHERE IDITEMSTOCK='$idItemStock' ");
				// oci_execute($update);
				// oci_commit;
				
				//insert item stock history
				$input =$mysqli->query( "INSERT INTO ITEMSTOCK_HISTORY 
											(TANGGAL,IDITEMSTOCK,DEPARTMENTID,STOCKAWAL,STOCKIN,STOCKOUT,STOCKAKHIR,CATATAN,NOTRANSAKSI) VALUES
											('$now','$idItemStock','$id_department','$stock_awal','0','$t[QTY_AWAL]','$stock_akhir','BREAKDOWN KELUAR','$_POST[no_breakdown]')
											");
				// oci_execute($input);
				// oci_commit;
				
				
				
				//menambah stock di department sesuai qty akhir breakdown 
				//cek apakah ada stock di department tsb dengan item dan satuan terbaru (satuan akhir)
				$cek_itemstock =$mysqli->query( "SELECT * FROM ITEMSTOCK WHERE ITEMSTOCK_IDITEM='$t[M_ITEMIDITEM]' AND ITEMSTOCK_IDSATUAN='$t[IDSATUAN_AKHIR]' AND 
											ITEMSTOCK_LOTNUMBER='$t[LOT_NUMBER]' AND TO_DATE(ITEMSTOCK_ED, 'dd-MM-yy')='$t[ED]' AND 
											ITEMSTOCK_IDDEPARTMENT='$id_department'");
				// oci_execute($cek_itemstock);
				$jml_cek =mysqli_num_rows($cek_itemstock);
				if($jml_cek>0) {
					//update stock, tambah stock
					$tampil_stock =$mysqli->query( "SELECT * FROM ITEMSTOCK WHERE ITEMSTOCK_IDITEM='$t[M_ITEMIDITEM]' AND ITEMSTOCK_IDSATUAN='$t[IDSATUAN_AKHIR]' AND 
											ITEMSTOCK_LOTNUMBER='$t[LOT_NUMBER]' AND TO_DATE(ITEMSTOCK_ED, 'dd-MM-yy')='$t[ED]' AND 
											ITEMSTOCK_IDDEPARTMENT='$id_department'");
					// oci_execute($tampil_stock);
					$k =mysqli_fetch_array($tampil_stock);
					$id_stock =$k['IDITEMSTOCK'];
					$stock_sebelum =$k['ITEMSTOCK_STOCK'];
					$stock_setelah =$stock_sebelum + $t['QTY_AKHIR'];
					
					$update_tambah_stock =$mysqli->query( "UPDATE ITEMSTOCK SET 
																ITEMSTOCK_STOCK			='$stock_setelah',
																ITEMSTOCK_USERNAME		='$username',
																ITEMSTOCK_LASTUPDATE	='$now'
															WHERE IDITEMSTOCK='$id_stock' ");
					// oci_execute($update_tambah_stock);
					// oci_commit;
					
					//input itemstock_history
					$input_history =$mysqli->query( "INSERT INTO ITEMSTOCK_HISTORY 
											(TANGGAL,IDITEMSTOCK,DEPARTMENTID,STOCKAWAL,STOCKIN,STOCKOUT,STOCKAKHIR,CATATAN,NOTRANSAKSI) VALUES
											('$now','$id_stock','$id_department','$stock_sebelum','$t[QTY_AKHIR]','0','$stock_setelah','BREAKDOWN MASUK','$_POST[no_breakdown]')
											");
					// oci_execute($input_history);
					// oci_commit;
					
				} else {
					//input stock baru, tambah stock
					$input_tambah_stock =$mysqli->query( "INSERT INTO ITEMSTOCK
														(ITEMSTOCK_IDITEM,ITEMSTOCK_IDSATUAN,ITEMSTOCK_LOTNUMBER,ITEMSTOCK_ED,ITEMSTOCK_STOCK,ITEMSTOCK_IDDEPARTMENT,
														ITEMSTOCK_USERNAME,ITEMSTOCK_LASTUPDATE)
														VALUES
														('$t[M_ITEMIDITEM]','$t[IDSATUAN_AKHIR]','$t[LOT_NUMBER]','$t[ED]','$t[QTY_AKHIR]','$id_department',
														'$username','$now')
														");
					// oci_execute($input_tambah_stock);
					// oci_commit;
					
					$id_max =$mysqli->query( "SELECT max(IDITEMSTOCK) AS IDITEMSTOCK FROM ITEMSTOCK");
					// oci_execute($id_max);
					$m =mysqli_fetch_array($id_max);
					$id_max_iditemstock =$m['IDITEMSTOCK'];
					
					//input itemstock_history
					$input_history =$mysqli->query( "INSERT INTO ITEMSTOCK_HISTORY 
											(TANGGAL,IDITEMSTOCK,DEPARTMENTID,STOCKAWAL,STOCKIN,STOCKOUT,STOCKAKHIR,CATATAN,NOTRANSAKSI) VALUES
											('$now','$id_max_iditemstock','$id_department','0','$t[QTY_AKHIR]','0','$t[QTY_AKHIR]','BREAKDOWN MASUK','$_POST[no_breakdown]')
											");
					// oci_execute($input_history);
					// oci_commit;
				}
				
				//generate barcode hasil breakdown
				$tgl =date('ymd');
				for($i=1; $i<=$t['QTY_AKHIR']; $i++) {
					//cek kode barcode max
					$barcode_max =$mysqli->query( "SELECT *
													FROM
														(SELECT M_ITEMIDITEM,KODEBARCODE,SUBSTR(LASTUPDATE, 4,3) AS BULAN,SUBSTR(KODEBARCODE, -5) AS COUNTER
															FROM M_ITEMBARCODE WHERE M_ITEMIDITEM='$t[M_ITEMIDITEM]'
															ORDER BY KODEBARCODE DESC
														) a
													
													ORDER BY KODEBARCODE DESC
													LIMIT 1");
					// oci_execute($barcode_max);
					$b =mysqli_fetch_array($barcode_max);
					
					if($bln==$b['BULAN']) {
						$counter =$b['COUNTER'] + 1;
						$seq = str_pad($counter,5,'0',STR_PAD_LEFT); 
						$kodebarcode =$t['M_ITEMIDITEM'].$tgl.$seq;
						
						//input di M_ITEMBARCODE
						$input =$mysqli->query( "INSERT INTO M_ITEMBARCODE
											(KODEBARCODE,M_ITEMIDITEM,LASTUPDATE,USERID,M_DEPARTMENTDEPARTMENTID,ED,M_SATUANIDSATUAN,LOT_NUMBER,
											TANGGALCHECKINMASUK,IDGUDANG,IDRAKGUDANG)
											VALUES
											('$kodebarcode','$t[M_ITEMIDITEM]','$now','$username','$id_department','$t[ED]','$t[IDSATUAN_AKHIR]','$t[LOT_NUMBER]',
											'$now','$t[IDGUDANG]','$t[IDRAKGUDANG]')
											");
						// oci_execute($input);
						// oci_commit;
						
						//input di breakdown_detail_barcode
						$input_detail_barcode =$mysqli->query( "INSERT INTO BREAKDOWN_DETAIL_BARCODE 
																(NOBREAKDOWNDETAIL,KODEBARCODE,USERNAME,LASTUPDATE)
																VALUES
																('$t[NOBREAKDOWNDETAIL]','$kodebarcode','$username','$now')
																");
						// oci_execute($input_detail_barcode);
						// oci_commit;
					} else {
						$counter =1;
						$seq = str_pad($counter,5,'0',STR_PAD_LEFT); 
						$kodebarcode =$_POST['id_item'].$tgl.$seq;
						
						//input di M_ITEMBARCODE
						$input =$mysqli->query( "INSERT INTO M_ITEMBARCODE
											(KODEBARCODE,M_ITEMIDITEM,LASTUPDATE,USERID,M_DEPARTMENTDEPARTMENTID,ED,M_SATUANIDSATUAN,LOT_NUMBER,
											TANGGALCHECKINMASUK,IDGUDANG,IDRAKGUDANG)
											VALUES
											('$kodebarcode','$t[M_ITEMIDITEM]','$now','$username','$id_department','$t[ED]','$t[IDSATUAN_AKHIR]','$t[LOT_NUMBER]',
											'$now','$t[IDGUDANG]','$t[IDRAKGUDANG]')
											");
						// oci_execute($input);
						// oci_commit;
						
						//input di breakdown_detail_barcode
						$input_detail_barcode =$mysqli->query( "INSERT INTO BREAKDOWN_DETAIL_BARCODE 
																(NOBREAKDOWNDETAIL,KODEBARCODE,USERNAME,LASTUPDATE)
																VALUES
																('$t[NOBREAKDOWNDETAIL]','$kodebarcode','$username','$now')
																");
						// oci_execute($input_detail_barcode);
						// oci_commit;
					}
					
					//update m_itembarcode, menambah nobreakdown_detail sesuai kodebarcode_header
					$update_nobreakdown_detail =$mysqli->query( "UPDATE M_ITEMBARCODE SET 
																	BREAKDOWNDETAILIDBREAKDOWN	='$t[NOBREAKDOWNDETAIL]',
																	BARCODEISACTIVE				='N',
																	LASTUPDATE					='$now',
																	USERID						='$username'
																WHERE KODEBARCODE ='$t[KODEBARCODE_HEADER]' ");
					// oci_execute($update_nobreakdown_detail);
					// oci_commit;
				}
			}
			//ubah flag validasi breakdown
			$update2 =$mysqli->query ( "UPDATE BREAKDOWN SET 
											VALIDASI 	='Y',
											USERNAME	='$username',
											LASTUPDATE	='$now'
										WHERE NOBREAKDOWN='$_POST[no_breakdown]' ");
			// oci_execute($update2);
			// oci_commit;
			
			$data['hasil']=1;
		}
		
		echo json_encode($data);
	break;
	
	
	
	
	case "batal_breakdown":
		//cek apakah transaksi breakdown sudah pernah dibatal dan cek apakah kodebarcode hasil generate sudah digunakan transaksi lain atau belum
		$cek_batal =$mysqli->query( "SELECT NOBREAKDOWN,FLAGBATAL_BREAKDOWN,SUM(NILAI_BARANGKELUAR) AS NILAI_BARANGKELUAR,SUM(NILAI_TAG) AS NILAI_TAG
					FROM
					(
						SELECT b.NOBREAKDOWN,b.FLAGBATAL AS FLAGBATAL_BREAKDOWN,d.NOBREAKDOWNDETAIL,d.KODEBARCODE_HEADER,c.KODEBARCODE,
							i.BARANGKELUARDETAILIDKELUAR,i.BREAKDOWNDETAILIDBREAKDOWN,i.TAGDETAILIDTAG,t.TAGISACTIVE,t.FLAGBATAL,
							k.BARANGKELUARISACTIVE,k.BARANGKELUARFLAGBATAL,
							CASE WHEN i.BARANGKELUARDETAILIDKELUAR is NOT NULL AND k.BARANGKELUARISACTIVE='Y' AND k.BARANGKELUARFLAGBATAL='N' AND i.BARCODEISACTIVE='N' THEN 1
							ELSE 0 END AS NILAI_BARANGKELUAR,
							CASE WHEN i.TAGDETAILIDTAG is NOT NULL AND t.TAGISACTIVE='Y' AND t.FLAGBATAL='N' THEN 1
							ELSE 0 END AS NILAI_TAG
								FROM BREAKDOWN b
								JOIN BREAKDOWN_DETAIL d ON d.NOBREAKDOWN=b.NOBREAKDOWN AND d.ISACTIVE='Y'
								JOIN BREAKDOWN_DETAIL_BARCODE c ON c.NOBREAKDOWNDETAIL=d.NOBREAKDOWNDETAIL AND c.ISACTIVE='Y'
								JOIN M_ITEMBARCODE i ON i.KODEBARCODE=c.KODEBARCODE
								LEFT JOIN TAG_DETAIL td ON td.NOTAG_DETAIL=i.TAGDETAILIDTAG
								LEFT JOIN TAG t ON t.NOTAG=td.NOTAG
								LEFT JOIN BARANG_KELUAR_DETAIL kd ON kd.NOBARANGKELUARDETAIL=i.BARANGKELUARDETAILIDKELUAR
								LEFT JOIN BARANG_KELUAR k ON k.NOBARANGKELUAR=kd.NOBARANGKELUAR
								WHERE b.NOBREAKDOWN='$_POST[no_breakdown]' 
					) a
					GROUP BY NOBREAKDOWN,FLAGBATAL_BREAKDOWN ");
		// oci_execute($cek_batal);
		$cv =mysqli_fetch_array($cek_batal);
		
		if($cv['FLAGBATAL_BREAKDOWN']=='Y') {
			$data['hasil']=0;
			$data['judul']='WARNING';
			$data['status']='warning';
			$data['ket']='Transaksi ini Sudah di Batal...';
		} else if($cv['NILAI_BARANGKELUAR']>0) {
			$data['hasil']=0;
			$data['judul']='WARNING';
			$data['status']='warning';
			$data['ket']='Kode barcode hasil Breakdown sudah ada yang digunakan transaksi BARANG KELUAR...';
		} else if($cv['NILAI_TAG']>0) {
			$data['hasil']=0;
			$data['judul']='WARNING';
			$data['status']='warning';
			$data['ket']='Kode barcode hasil Breakdown sudah ada yang digunakan transaksi TAG...';
		} else {
			//mencari id_department dari no_breakdown ini
			$department =$mysqli->query( "SELECT NOBREAKDOWN,ID_DEPARTMENT 
											FROM BREAKDOWN 
											WHERE NOBREAKDOWN='$_POST[no_breakdown]' ");
			// oci_execute($department);
			$d =mysqli_fetch_array($department);
			$id_department =$d['ID_DEPARTMENT'];
			
			$tampil =$mysqli->query( "SELECT * 
									FROM BREAKDOWN_DETAIL d
									JOIN M_ITEMBARCODE b ON b.KODEBARCODE=d.KODEBARCODE_HEADER AND BARCODEISACTIVE='N'
									WHERE NOBREAKDOWN='$_POST[no_breakdown]' AND ISACTIVE='Y' ");
			// oci_execute($tampil);
			while ($t =mysqli_fetch_array($tampil)) {
				//mengembalikan/menambah stock di department dengan qty awal
				$itemStock =$mysqli->query ( "SELECT * FROM ITEMSTOCK WHERE ITEMSTOCK_IDITEM='$t[M_ITEMIDITEM]' AND ITEMSTOCK_IDSATUAN='$t[M_SATUANIDSATUAN]' AND 
											ITEMSTOCK_LOTNUMBER='$t[LOT_NUMBER]' AND TO_DATE(ITEMSTOCK_ED, 'dd-MM-yy')='$t[ED]' AND 
											ITEMSTOCK_IDDEPARTMENT='$id_department' ");
				// oci_execute($itemStock);
				$i =mysqli_fetch_array($itemStock);
				$idItemStock =$i['IDITEMSTOCK'];
				$stock_skrg =$i['ITEMSTOCK_STOCK'];
				
				$stock_akhir =$stock_skrg + $t['QTY_AWAL'];
				$update =$mysqli->query ( "UPDATE ITEMSTOCK SET
												ITEMSTOCK_STOCK			='$stock_akhir',
												ITEMSTOCK_USERNAME		='$username',
												ITEMSTOCK_LASTUPDATE	='$now'
											WHERE IDITEMSTOCK='$idItemStock' ");
				// oci_execute($update);
				// oci_commit;
				
				//insert item stock history
				$input =$mysqli->query( "INSERT INTO ITEMSTOCK_HISTORY 
											(TANGGAL,IDITEMSTOCK,DEPARTMENTID,STOCKAWAL,STOCKIN,STOCKOUT,STOCKAKHIR,CATATAN,NOTRANSAKSI) VALUES
											('$now','$idItemStock','$id_department','$stock_skrg','$t[QTY_AWAL]','0','$stock_akhir','BATAL BREAKDOWN KELUAR','$_POST[no_breakdown]')
											");
				// oci_execute($input);
				// oci_commit;
				
				
				//update stock, mengurangi stock berdasarkan satuan baru dengan qty akhir
				$tampil_stock =$mysqli->query( "SELECT * FROM ITEMSTOCK WHERE ITEMSTOCK_IDITEM='$t[M_ITEMIDITEM]' AND ITEMSTOCK_IDSATUAN='$t[IDSATUAN_AKHIR]' AND 
										ITEMSTOCK_LOTNUMBER='$t[LOT_NUMBER]' AND TO_DATE(ITEMSTOCK_ED, 'dd-MM-yy')='$t[ED]' AND 
										ITEMSTOCK_IDDEPARTMENT='$id_department'");
				// oci_execute($tampil_stock);
				$k =mysqli_fetch_array($tampil_stock);
				$id_stock =$k['IDITEMSTOCK'];
				$stock_sebelum =$k['ITEMSTOCK_STOCK'];
				$stock_setelah =$stock_sebelum - $t['QTY_AKHIR'];
				
				$update_tambah_stock =$mysqli->query( "UPDATE ITEMSTOCK SET 
															ITEMSTOCK_STOCK			='$stock_setelah',
															ITEMSTOCK_USERNAME		='$username',
															ITEMSTOCK_LASTUPDATE	='$now'
														WHERE IDITEMSTOCK='$id_stock' ");
				// oci_execute($update_tambah_stock);
				// oci_commit;
				
				//input itemstock_history
				$input_history =$mysqli->query( "INSERT INTO ITEMSTOCK_HISTORY 
										(TANGGAL,IDITEMSTOCK,DEPARTMENTID,STOCKAWAL,STOCKIN,STOCKOUT,STOCKAKHIR,CATATAN,NOTRANSAKSI) VALUES
										('$now','$id_stock','$id_department','$stock_sebelum','0','$t[QTY_AKHIR]','$stock_setelah','BATAL BREAKDOWN MASUK','$_POST[no_breakdown]')
										");
				// oci_execute($input_history);
				// oci_commit;
				
				
				//menonaktifkan kodebarcode yang di generate saat validasi breakdown
				$tampil_barcode =$mysqli->query( "SELECT * FROM BREAKDOWN_DETAIL_BARCODE WHERE NOBREAKDOWNDETAIL='$t[NOBREAKDOWNDETAIL]' AND ISACTIVE='Y' ");
				// oci_execute($tampil_barcode);
				while($b =mysqli_fetch_array($tampil_barcode)) {
					$update_barcode =$mysqli->query( "UPDATE M_ITEMBARCODE SET 
															BARCODEISACTIVE	='N',
															LASTUPDATE		='$now',
															USERID			='$username'
														WHERE KODEBARCODE='$b[KODEBARCODE]' ");
					// oci_execute($update_barcode);
					// oci_commit;
					
				}
				//mengaktifkan kodebarcode_header di m_itembarcode
				$update_barcode_header =$mysqli->query( "UPDATE M_ITEMBARCODE SET 
																BARCODEISACTIVE				='Y',
																LASTUPDATE					='$now',
																USERID						='$username'
															WHERE KODEBARCODE ='$t[KODEBARCODE_HEADER]' ");
				// oci_execute($update_barcode_header);
				// oci_commit;
			}
			//ubah flag batal breakdown
			$update2 =$mysqli->query ( "UPDATE BREAKDOWN SET 
											FLAGBATAL 	='Y',
											KETERANGAN 	='$_POST[ket_batal]',
											USERNAME	='$username',
											LASTUPDATE	='$now'
										WHERE NOBREAKDOWN='$_POST[no_breakdown]' ");
			// oci_execute($update2);
			// oci_commit;
			
			$data['hasil']=1;
		}
		echo json_encode($data);
	break;
	
}