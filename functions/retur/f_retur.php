<?php
error_reporting(0);
include "../../config/connect.php";
session_start();
include "../numbering/f_numbering.php";
$conn ="../../config/connect.php";


date_default_timezone_set('Asia/Jakarta');
$now			=date('Y-m-d H:i:s');
$username		=$_SESSION['username'];


switch ($_POST['act']){
	
	case "save_header":
		if($_POST['aksi']=='add') {
			$number =Numbering('Retur', $conn);
			$cek_name =$mysqli->query( "SELECT * FROM RETUR WHERE NORETUR='$number' ");
			// oci_execute($cek_name);
			$jml =mysqli_num_rows($cek_name);
			
			if($jml>0) {
				$data['hasil']=0;
			} else {
				$tgl =date('Y-m-d',strtotime($_POST['tanggal']));
				$input =$mysqli->query( "INSERT INTO RETUR 
											(NORETUR,RETURID_DEPARTMENT,RETURTANGGAL,RETURNOTE,RETURUSERNAME,RETURLASTUPDATE) VALUES
											('$number','$_POST[id_department]','$tgl','$_POST[note]','$username','$now')
											") ;
					// oci_execute($input);
					// oci_commit;
					$data['hasil']=1;
					$data['tgl']=$tgl;
			}
		} else if($_POST['aksi']=='update') {
			$tgl =date('Y-m-d',strtotime($_POST['tanggal']));
			$update =$mysqli->query( "UPDATE RETUR SET 
											RETURID_DEPARTMENT		='$_POST[id_department]',
											RETURTANGGAL			='$tgl',
											RETURNOTE				='$_POST[note]',
											RETURUSERNAME			='$username',
											RETURLASTUPDATE			='$now'
										WHERE NORETUR='$_POST[no_retur]' ");
			// oci_execute($update);
			// oci_commit;
			$data['hasil']=1;
		}
		
		echo json_encode($data);
    break;
	
	
	
	case "getHeader":
		$sql =$mysqli->query( "SELECT * FROM RETUR WHERE NORETUR='$_POST[no_retur]' ");
		// oci_execute($sql);
		$r =mysqli_fetch_array($sql);
		
		$tgl =date('Y-m-d',strtotime($r['RETURTANGGAL']));
		$data['RETURID_DEPARTMENT']	=$r['RETURID_DEPARTMENT'];
		$data['RETURTANGGAL']		=$tgl;
		$data['RETURNOTE']			=$r['RETURNOTE'];
		echo json_encode($data);
    break;
	
	
	
	case "save_item":
		$cek =$mysqli->query( "SELECT NORETUR,NORETUR_DETAIL,count(NORETUR_DETAIL) as JML 
								FROM RETUR_DETAIL 
								WHERE NORETUR='$_POST[no_retur]' AND RETURDETAIL_IDITEM='$_POST[id_item]' AND RETURDETAIL_IDSATUAN='$_POST[id_satuan]'
								AND RETURDETAIL_LOTNUMBER='$_POST[lot_number]' AND RETURDETAIL_ED='$_POST[ed]' AND RETURDETAIL_ISACTIVE='Y' 
								GROUP BY NORETUR_DETAIL,NORETUR");
		// oci_execute($cek);
		$r =mysqli_fetch_array($cek);
		
		if($r['JML']!='') {
			$update =$mysqli->query( "UPDATE RETUR_DETAIL SET 
											RETURDETAIL_QTY		='$_POST[qty]',
											RETURDETAIL_USERNAME	='$username',
											RETURDETAIL_LASTUPDATE	='$now'
										WHERE NORETUR_DETAIL='$r[NORETUR_DETAIL]' ");
			// oci_execute($update);
			// oci_commit;
			$data['hasil']=1;
			$data['jml']=$r['JML'];
		} else {
			$no_max =$mysqli->query( "SELECT *
										FROM
										(
											SELECT NORETUR,NORETUR_DETAIL,SUBSTR(NORETUR_DETAIL,-3,3) AS COUNTER
												FROM RETUR_DETAIL 
												WHERE NORETUR='$_POST[no_retur]'
												ORDER BY NORETUR_DETAIL DESC
										) a
										
										ORDER BY NORETUR_DETAIL DESC
										LIMIT 1");
			// oci_execute($no_max);
			$n =mysqli_fetch_array($no_max);
			$seq =$n['COUNTER'] + 1;
			$counter =str_pad($seq,3,'0',STR_PAD_LEFT); 
			$noretur_detail =$_POST['no_retur'].'-'.$counter;
			
			
			$input =$mysqli->query( "INSERT INTO RETUR_DETAIL
									(NORETUR,RETURDETAIL_IDITEM,RETURDETAIL_IDSATUAN,RETURDETAIL_LOTNUMBER,RETURDETAIL_QTY,RETURDETAIL_ED,RETURDETAIL_USERNAME,
										RETURDETAIL_LASTUPDATE,NORETUR_DETAIL) VALUES
									('$_POST[no_retur]','$_POST[id_item]','$_POST[id_satuan]','$_POST[lot_number]','$_POST[qty]','$_POST[ed]','$username',
										'$now','$noretur_detail')");
			// oci_execute($input);
			// oci_commit;
			$data['hasil']=1;
			$data['no']=$noretur_detail;
		}
		echo json_encode($data);
	break;
	
	
	
	case "hapusitem":
		$update =$mysqli->query ( "UPDATE RETUR_DETAIL SET 
										RETURDETAIL_ISACTIVE 	='N',
										RETURDETAIL_USERNAME	='$username',
										RETURDETAIL_LASTUPDATE	='$now'
									WHERE NORETUR_DETAIL='$_POST[noretur_detail]' ");
		// oci_execute($update);
		// oci_commit;
		$data['hasil']=1;
		echo json_encode($data);
	break;
	
	
	
	case "hapusretur":
		$update =$mysqli->query ( "UPDATE RETUR SET 
										RETURISACTIVE 	='N',
										RETURUSERNAME	='$username',
										RETURLASTUPDATE	='$now'
									WHERE NORETUR='$_POST[no_retur]' ");
		// oci_execute($update);
		// oci_commit;
		$data['hasil']=1;
		echo json_encode($data);
	break;
	
	
	
	case "validasi_retur":
		//cek apakah retur sudah di validasi
		$cek_returvalidasi =$mysqli->query( "SELECT * FROM RETUR WHERE NORETUR='$_POST[no_retur]' ");
		// oci_execute($cek_returvalidasi);
		$ct =mysqli_fetch_array($cek_returvalidasi);
		
		if($ct['RETURVALIDASI']=='Y' OR $ct['RETURVALIDASI']=='C') {
			$data['hasil']=0;
			$data['judul']='WARNING';
			$data['status']='warning';
			$data['ket']='Transaksi RETUR Sudah di Validasi...';
		} else {
			$idDepartment =$ct['RETURID_DEPARTMENT'];
			
			$tampil =$mysqli->query( "SELECT * FROM RETUR_DETAIL WHERE NORETUR='$_POST[no_retur]' AND RETURDETAIL_ISACTIVE='Y' ");
			// oci_execute($tampil);
			while ($t =mysqli_fetch_array($tampil)) {
				$itemStock =$mysqli->query ( "SELECT * FROM ITEMSTOCK WHERE ITEMSTOCK_IDITEM='$t[RETURDETAIL_IDITEM]' AND ITEMSTOCK_IDSATUAN='$t[RETURDETAIL_IDSATUAN]' AND 
												ITEMSTOCK_LOTNUMBER='$t[RETURDETAIL_LOTNUMBER]' AND DATE(ITEMSTOCK_ED)='$t[RETURDETAIL_ED]' AND 
												ITEMSTOCK_IDDEPARTMENT='$idDepartment' ");
				// oci_execute($itemStock);
				$i =mysqli_fetch_array($itemStock);
				$idItemStock =$i['IDITEMSTOCK'];
				$stock_awal =$i['ITEMSTOCK_STOCK'];
				
				$stock_akhir =$stock_awal - $t['RETURDETAIL_QTY'];
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
											('$now','$idItemStock','$idDepartment','$stock_awal','0','$t[RETURDETAIL_QTY]','$stock_akhir','RETUR KELUAR','$_POST[no_retur]')
											");
				// oci_execute($input);
				// oci_commit;
			}
			
			//ubah flag validasi retur
			$update2 =$mysqli->query ( "UPDATE RETUR SET 
											RETURVALIDASI 	='Y',
											RETURUSERNAME	='$username',
											RETURLASTUPDATE	='$now'
										WHERE NORETUR='$_POST[no_retur]' ");
			// oci_execute($update2);
			// oci_commit;
			
			$data['hasil']=1;
		}
		echo json_encode($data);
	break;
	
	
	
	case "checkout_barcode":
		//cek apakah kode barcode ada/valid dari id_department pengirim
		$cek_idDepartment =$mysqli->query( "SELECT * FROM RETUR WHERE NORETUR='$_POST[no_retur]' ");
		// oci_execute($cek_idDepartment);
		$ct =mysqli_fetch_array($cek_idDepartment);
		$idDepartment =$ct['RETURID_DEPARTMENT'];
		
		$cek =$mysqli->query( "SELECT * FROM M_ITEMBARCODE WHERE KODEBARCODE='$_POST[barcode]' AND M_DEPARTMENTDEPARTMENTID='$idDepartment' AND BARCODEISACTIVE='Y' ");
		// oci_execute($cek);
		$cek_jml =mysqli_num_rows($cek);
		
		if($cek_jml==0) {
			$data['hasil']=0;
			$data['judul']='ERROR';
			$data['status']='error';
			$data['ket']='Kode Barcode tidak Valid...';
		} else {
			//mencari noretur_detail dan cek apakah qty sudah terpenuhi
			$retur_detail =$mysqli->query( "SELECT KODEBARCODE,t.NORETUR,NORETUR_DETAIL,RETURID_DEPARTMENT,RETURDETAIL_QTY,RETURDETAIL_QTYTERPENUHI
												FROM M_ITEMBARCODE b 
												JOIN RETUR_DETAIL d ON d.RETURDETAIL_IDITEM=b.M_ITEMIDITEM AND d.RETURDETAIL_IDSATUAN=b.M_SATUANIDSATUAN AND 
													d.RETURDETAIL_LOTNUMBER=b.LOT_NUMBER AND d.RETURDETAIL_ISACTIVE='Y' 
												JOIN RETUR t ON t.NORETUR=d.NORETUR
												WHERE d.NORETUR='$_POST[no_retur]' AND b.KODEBARCODE='$_POST[barcode]' ");
			// oci_execute($retur_detail);
			$r =mysqli_fetch_array($retur_detail);
			$noretur_detail =$r['NORETUR_DETAIL'];
			$qty =$r['RETURDETAIL_QTY'];
			$qtyterpenuhi =$r['RETURDETAIL_QTYTERPENUHI'];
			
			if($qty==$qtyterpenuhi) {
				$data['hasil']=0;
				$data['judul']='WARNING';
				$data['status']='warning';
				$data['ket']='Kode Barcode Item ini sudah terpenuhi..';
			} else {
				//cek barcode apakah sudah discan ke RETUR_DETAIL_BARCODE dengan noretur_detail diatas
				$cek_barcode =$mysqli->query( "SELECT * FROM RETUR_DETAIL_BARCODE WHERE NORETUR_DETAIL='$noretur_detail' AND KODEBARCODE='$_POST[barcode]' ");
				// oci_execute($cek_barcode);
				$jml =mysqli_num_rows($cek_barcode);
				
				if($jml>0) {
					$data['hasil']=0;
					$data['judul']='WARNING';
					$data['status']='warning';
					$data['ket']='Kode Barcode sudah di check out..';
				} else {
					//mencari id_department tujuan, yaitu department pusat
					include '../department/queryDepartmentUtama.php';
					$z =mysqli_fetch_array($queryGetDepartment);
					$idDepartmentUtama =$z['ID_DEPARTMENT'];
					
					//mengubah id department pada M_ITEMBARCODE
					$itembarcode =$mysqli->query( "UPDATE M_ITEMBARCODE SET 
														M_DEPARTMENTDEPARTMENTID	='$idDepartmentUtama',
														RETURDETAILIDRETUR			='$noretur_detail',
														TAGDETAILIDTAG				='',
														IDGUDANG					='0',
														IDRAKGUDANG					='0',
														USERID						='$username',
														LASTUPDATE					='$now'
													WHERE KODEBARCODE='$_POST[barcode]' ");
					// oci_execute($itembarcode);
					// oci_commit;
					
					//input data barcode ke RETUR_DETAIL_BARCODE
					$returbarcode =$mysqli->query( "INSERT INTO RETUR_DETAIL_BARCODE
												(NORETUR_DETAIL,KODEBARCODE,LASTUPDATE,USERNAME) VALUES
												('$noretur_detail','$_POST[barcode]','$now','$username')
												");
					// oci_execute($returbarcode);
					// oci_commit;
					
					//mengubah qty terpenuhi dari RETUR_DETAIL
					$hasil =$qtyterpenuhi + 1;
					$updatedetail =$mysqli->query( "UPDATE RETUR_DETAIL SET 
														RETURDETAIL_QTYTERPENUHI	='$hasil',
														RETURDETAIL_USERNAME		='$username',
														RETURDETAIL_LASTUPDATE		='$now'
													WHERE NORETUR_DETAIL='$noretur_detail' ");
					// oci_execute($updatedetail);
					// oci_commit;
					
					//mengubah returvalidasi menjadi 'C' pada table RETUR jika sudah terpenuhi semua
					$cek_validasi =$mysqli->query( "SELECT COUNT(NORETUR) AS TOTAL,SUM(NILAI) AS NILAI
													FROM
													(
														SELECT NORETUR,RETURDETAIL_QTY,RETURDETAIL_QTYTERPENUHI,CASE WHEN RETURDETAIL_QTY=RETURDETAIL_QTYTERPENUHI THEN 1 ELSE 0 END NILAI
														FROM RETUR_DETAIL 
														WHERE NORETUR='$_POST[no_retur]' AND RETURDETAIL_ISACTIVE='Y'
													) s
													GROUP BY NORETUR");
					// oci_execute($cek_validasi);
					$v =mysqli_fetch_array($cek_validasi);
					if($v['TOTAL']==$v['NILAI']) {
						$update_validasi =$mysqli->query( "UPDATE RETUR SET 
																RETURVALIDASI		='C',
																RETURLASTUPDATE		='$now'
															WHERE NORETUR='$_POST[no_retur]' ");
						// oci_execute($update_validasi);
						// oci_commit;
						$data['hasil']=2;
						$data['lengkap']=1;
					} else {
						$data['hasil']=2;
						$data['lengkap']=0;
					}
				}
			}
		}
		echo json_encode($data);
	break;

	case "pembatalan":
		$nosj=$_POST['nosj'];
		$userid=$_POST['userid'];
		$keterangan=$_POST['keterangan'];
		//cek apakah transaksi breakdown sudah pernah dibatal dan cek apakah kodebarcode hasil generate sudah digunakan transaksi lain atau belum
		$cek_batal =$mysqli->query( "SELECT NORETUR,FLAGBATAL,SUM(NILAI_TAG) AS NILAI_TAG
					FROM
					(                                    
						SELECT a.NORETUR,a.FLAGBATAL,
						CASE WHEN d.TAGDETAILIDTAG is NOT NULL AND f.TAGISACTIVE='Y' AND f.FLAGBATAL='N' THEN 1
						ELSE 0 END AS NILAI_TAG
						FROM RETUR a
						JOIN RETUR_DETAIL b ON b.NORETUR=a.NORETUR AND b.RETURDETAIL_ISACTIVE='Y'
						left JOIN RETUR_DETAIL_BARCODE c ON c.NORETUR_DETAIL=b.NORETUR_DETAIL 
						left JOIN M_ITEMBARCODE d ON d.KODEBARCODE=c.KODEBARCODE
						LEFT JOIN TAG_DETAIL e ON e.NOTAG_DETAIL=d.TAGDETAILIDTAG
						LEFT JOIN TAG f ON f.NOTAG=e.NOTAG
						WHERE b.NORETUR='$nosj'
					)a
					GROUP BY NORETUR,FLAGBATAL");
		// oci_execute($cek_batal);
		$cv =mysqli_fetch_array($cek_batal);
		
		if($cv['FLAGBATAL']=='Y') {
			$data['hasil']=0;
			$data['judul']='WARNING';
			$data['status']='warning';
			$data['ket']='Transaksi ini Sudah di Batal...';
		} else if($cv['NILAI_TAG']>0) {
			$data['hasil']=0;
			$data['judul']='WARNING';
			$data['status']='warning';
			$data['ket']='Kode barcode sudah ada yang digunakan transaksi TAG...';
		} else {
			include '../department/queryDepartmentUtama.php';
			$zz =mysqli_fetch_array($queryGetDepartment);
			$iddepartmenpusat=$zz['ID_DEPARTMENT'];
			
			$tampil =$mysqli->query( "SELECT a.NORETUR,a.RETURID_DEPARTMENT,a.RETURTERIMA,d.RETURDETAIL_IDITEM,d.RETURDETAIL_IDSATUAN,d.RETURDETAIL_LOTNUMBER,
					d.RETURDETAIL_QTY,d.RETURDETAIL_ED,d.NORETUR_DETAIL,d.RETURDETAIL_QTYTERPENUHI,d.RETURDETAIL_QTYTERIMA
					FROM RETUR_DETAIL d
					join RETUR a on a.NORETUR=d.NORETUR and a.RETURISACTIVE='Y'
					WHERE a.NORETUR='$nosj' AND d.RETURDETAIL_ISACTIVE='Y' ");
			// oci_execute($tampil);
			while ($t =mysqli_fetch_array($tampil)) {
				//menampilkan stok di department cabang
				$itemDeptCabang=$mysqli->query("select IDITEMSTOCK,ITEMSTOCK_STOCK from ITEMSTOCK 
							WHERE ITEMSTOCK_IDITEM='$t[RETURDETAIL_IDITEM]' AND ITEMSTOCK_IDSATUAN='$t[RETURDETAIL_IDSATUAN]' AND 
							ITEMSTOCK_LOTNUMBER='$t[RETURDETAIL_LOTNUMBER]' AND 
							ITEMSTOCK_IDDEPARTMENT='$t[RETURID_DEPARTMENT]'");
				// oci_execute($itemDeptCabang);
				$cb=mysqli_fetch_array($itemDeptCabang);
				$iditemstockCab=$cb['IDITEMSTOCK'];
				$stock_awalCab =$cb['ITEMSTOCK_STOCK'];
				$stock_akhirCab =$stock_awalCab + $t['RETURDETAIL_QTY'];
				
				//mengembalikan/menambah stock di department cabang dengan qty awal
				if($t['RETURTERIMA']=='Y'){
					//Mengurangi stok di department pusat
					$itemDeptUtama=$mysqli->query("select IDITEMSTOCK,ITEMSTOCK_STOCK 
							from ITEMSTOCK 
							WHERE ITEMSTOCK_IDITEM='$t[RETURDETAIL_IDITEM]' AND ITEMSTOCK_IDSATUAN='$t[RETURDETAIL_IDSATUAN]' AND 
							ITEMSTOCK_LOTNUMBER='$t[RETURDETAIL_LOTNUMBER]' AND 
							ITEMSTOCK_IDDEPARTMENT='$iddepartmenpusat'");
					// oci_execute($itemDeptUtama);
					$ut=mysqli_fetch_array($itemDeptUtama);
					$iditemstock=$ut['IDITEMSTOCK'];
					$stock_awal =$ut['ITEMSTOCK_STOCK'];
					$stock_akhir =$stock_awal - $t['RETURDETAIL_QTY'];

					$hasilDeptUtama=$mysqli->query("update ITEMSTOCK set 
											ITEMSTOCK_STOCK='$stock_akhir',
											ITEMSTOCK_LASTUPDATE=CURRENT_TIMESTAMP,
											ITEMSTOCK_USERNAME='$userid'
										where IDITEMSTOCK=$iditemstock");
					// oci_execute($hasilDeptUtama);

					$historyDeptUtama=$mysqli->query("INSERT INTO ITEMSTOCK_HISTORY 
									(TANGGAL,IDITEMSTOCK,DEPARTMENTID,STOCKAWAL,STOCKIN,STOCKOUT,STOCKAKHIR,
									CATATAN,NOTRANSAKSI) VALUES
									(CURRENT_TIMESTAMP,'$iditemstock','$iddepartmenpusat','$stock_awal','0','$t[RETURDETAIL_QTY]','$stock_akhir',
									'BATAL PENERIMAAN RETUR','$nosj')
									");
					// oci_execute($historyDeptUtama);

					//Menambah stok di department Cabang
					$hasilDeptCab=$mysqli->query("update ITEMSTOCK set 
										ITEMSTOCK_STOCK='$stock_akhirCab',
										ITEMSTOCK_LASTUPDATE=CURRENT_TIMESTAMP,
										ITEMSTOCK_USERNAME='$userid'
									where IDITEMSTOCK='$iditemstockCab'");
					// oci_execute($hasilDeptCab);
					
					$historyDeptCab=$mysqli->query("INSERT INTO ITEMSTOCK_HISTORY 
									(TANGGAL,IDITEMSTOCK,DEPARTMENTID,STOCKAWAL,STOCKIN,STOCKOUT,STOCKAKHIR,
									CATATAN,NOTRANSAKSI) VALUES
									(CURRENT_TIMESTAMP,'$iditemstockCab','$t[RETURID_DEPARTMENT]','$stock_awalCab','$t[RETURDETAIL_QTY]','0','$stock_akhirCab',
									'BATAL RETUR','$nosj')
									");
					// oci_execute($historyDeptCab);

					$barcodeCabang=$mysqli->query("update M_ITEMBARCODE set 
										M_DEPARTMENTDEPARTMENTID='$t[RETURID_DEPARTMENT]',
										RETURDETAILIDRETUR		='',
										LASTUPDATE				=CURRENT_TIMESTAMP,
										USERID					='$userid',
										IDGUDANG				='0',
										IDRAKGUDANG				='0'
									where KODEBARCODE in (
										select KODEBARCODE from RETUR_DETAIL_BARCODE
										where NORETUR_DETAIL='$t[NORETUR_DETAIL]'
										)");
					// oci_execute($barcodeCabang);
					
					// oci_commit;
					$data['hasil']=1;
					$data['status']='SUCCESS';
					$data['ket']='RETUR NO $nosj Sudah dibatalkan...';
				}
				else{
					//Menambah stok di department cabang
					$hasilDeptCab=$mysqli->query("update ITEMSTOCK set 
									ITEMSTOCK_STOCK		='$stock_akhirCab',
									ITEMSTOCK_LASTUPDATE=CURRENT_TIMESTAMP,
									ITEMSTOCK_USERNAME	='$userid'
								where IDITEMSTOCK=$iditemstockCab");
					// oci_execute($hasilDeptCab);
					
					$historyDeptCab=$mysqli->query("INSERT INTO ITEMSTOCK_HISTORY 
								(TANGGAL,IDITEMSTOCK,DEPARTMENTID,STOCKAWAL,STOCKIN,STOCKOUT,STOCKAKHIR,
								CATATAN,NOTRANSAKSI) VALUES
								(CURRENT_TIMESTAMP,'$iditemstockCab','$t[RETURID_DEPARTMENT]','$stock_awalCab','$t[RETURDETAIL_QTY]','0','$stock_akhirCab',
								'BATAL RETUR','$nosj')
								");
					// oci_execute($historyDeptCab);
					if($t['RETURDETAIL_QTYTERPENUHI'] > 0)
					{
						$barcodeCabang=$mysqli->query("update M_ITEMBARCODE set 
										M_DEPARTMENTDEPARTMENTID='$t[RETURID_DEPARTMENT]',
										RETURDETAILIDRETUR		='',
										LASTUPDATE				=CURRENT_TIMESTAMP,
										USERID					='$userid',
										IDGUDANG				='0',
										IDRAKGUDANG				='0'
									where KODEBARCODE in (
										select KODEBARCODE from RETUR_DETAIL_BARCODE
										where NORETUR_DETAIL='$t[NORETUR_DETAIL]'
										)");
						// oci_execute($barcodeCabang);
					}
					// oci_commit;
					$data['hasil']=1;
					$data['status']='SUCCESS';
					$data['ket']='RETUR NO $nosj Sudah dibatalkan...';
				}
				
			}
			$retur=$mysqli->query("update RETUR set 
									FLAGBATAL		='Y',
									RETURLASTUPDATE	=CURRENT_TIMESTAMP,
									RETURUSERNAME	='$userid',
									KET_BATAL		='$keterangan'
								where NORETUR='$nosj'");
			// oci_execute($retur);
			// oci_commit;
			echo json_encode($data);
		}
	break;

}
