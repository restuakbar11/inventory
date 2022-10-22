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
			$number =Numbering('Tag', $conn);
			$cek_name =$mysqli->query( "SELECT * FROM TAG WHERE NOTAG='$number' ");
			// oci_execute($cek_name);
			$jml =mysqli_num_rows($cek_name);
			
			if($jml>0) {
				$data['hasil']=0;
			} else {
				$tgl =date('Y-m-d',strtotime($_POST['tanggal']));
				$input =$mysqli->query( "INSERT INTO TAG 
											(NOTAG,TAGID_DEPARTMENT,TAGTANGGAL,TAGNOTE,TAGUSERNAME,TAGLASTUPDATE) VALUES
											('$number','$_POST[id_department]','$tgl','$_POST[note]','$username','$now')
											") ;
					// oci_execute($input);
					// oci_commit;
					$data['hasil']=1;
					$data['tgl']=$tgl;
			}
		} else if($_POST['aksi']=='update') {
			$tgl =date('Y-m-d',strtotime($_POST['tanggal']));
			$update =$mysqli->query( "UPDATE TAG SET 
											TAGID_DEPARTMENT	='$_POST[id_department]',
											TAGTANGGAL			='$tgl',
											TAGNOTE				='$_POST[note]',
											TAGUSERNAME			='$username',
											TAGLASTUPDATE		='$now'
										WHERE NOTAG='$_POST[no_tag]' ");
			// oci_execute($update);
			// oci_commit;
			$data['hasil']=1;
		}
		
		echo json_encode($data);
    break;
	
	
	
	case "getHeader":
		$sql =$mysqli->query( "SELECT * FROM TAG WHERE NOTAG='$_POST[no_tag]' ");
		// oci_execute($sql);
		$r =mysqli_fetch_array($sql);
		
		$tgl =date('Y-m-d',strtotime($r['TAGTANGGAL']));
		$data['TAGID_DEPARTMENT']	=$r['TAGID_DEPARTMENT'];
		$data['TAGTANGGAL']				=$tgl;
		$data['TAGNOTE']				=$r['TAGNOTE'];
		echo json_encode($data);
    break;
	
	
	
	case "save_item":
		$cek =$mysqli->query( "SELECT NOTAG,NOTAG_DETAIL,count(NOTAG_DETAIL) as JML 
								FROM TAG_DETAIL 
								WHERE NOTAG='$_POST[no_tag]' AND TAGDETAILM_ITEMID='$_POST[id_item]' AND TAGDETAILM_SATUANID='$_POST[id_satuan]'
								AND TAGDETAILM_ITEMSTOCKLOTNUMBER='$_POST[lot_number]' AND TAGDETAILED='$_POST[ed]' AND TAGDETAILISACTIVE='Y' 
								GROUP BY NOTAG_DETAIL,NOTAG");
		// oci_execute($cek);
		$r =mysqli_fetch_array($cek);
		
		if($r['JML']!='') {
			$update =$mysqli->query( "UPDATE TAG_DETAIL SET 
											TAGDETAILQTY		='$_POST[qty]',
											TAGDETAILUSERNAME	='$username',
											TAGDETAILLASTUPDATE	='$now'
										WHERE NOTAG_DETAIL='$r[NOTAG_DETAIL]' ");
			// oci_execute($update);
			// oci_commit;
			$data['hasil']=1;
			$data['jml']=$r['JML'];
		} else {
			$no_max =$mysqli->query( "SELECT *
										FROM
										(
											SELECT NOTAG,NOTAG_DETAIL,SUBSTR(NOTAG_DETAIL,-3,3) AS COUNTER
												FROM TAG_DETAIL 
												WHERE NOTAG='$_POST[no_tag]'
												ORDER BY NOTAG_DETAIL DESC
										) a
										
										ORDER BY NOTAG_DETAIL DESC
										LIMIT 1");
			// oci_execute($no_max);
			$n =mysqli_fetch_array($no_max);
			$seq =$n['COUNTER'] + 1;
			$counter =str_pad($seq,3,'0',STR_PAD_LEFT); 
			$notag_detail =$_POST['no_tag'].'-'.$counter;
			
			
			$input =$mysqli->query( "INSERT INTO TAG_DETAIL
									(NOTAG,TAGDETAILM_ITEMID,TAGDETAILM_SATUANID,TAGDETAILM_ITEMSTOCKLOTNUMBER,TAGDETAILQTY,TAGDETAILED,TAGDETAILUSERNAME,
										TAGDETAILLASTUPDATE,NOTAG_DETAIL) VALUES
									('$_POST[no_tag]','$_POST[id_item]','$_POST[id_satuan]','$_POST[lot_number]','$_POST[qty]','$_POST[ed]','$username',
										'$now','$notag_detail')");
			// oci_execute($input);
			// oci_commit;
			$data['hasil']=1;
			$data['no']=$notag_detail;
		}
		echo json_encode($data);
	break;
	
	
	
	case "hapusitem":
		$update =$mysqli->query ( "UPDATE TAG_DETAIL SET 
										TAGDETAILISACTIVE 	='N',
										TAGDETAILUSERNAME	='$username',
										TAGDETAILLASTUPDATE	='$now'
									WHERE NOTAG_DETAIL='$_POST[notag_detail]' ");
		// oci_execute($update);
		// oci_commit;
		$data['hasil']=1;
		echo json_encode($data);
	break;
	
	
	
	case "hapustag":
		$update =$mysqli->query ( "UPDATE TAG SET 
										TAGISACTIVE 	='N',
										TAGUSERNAME		='$username',
										TAGLASTUPDATE	='$now'
									WHERE NOTAG='$_POST[no_tag]' ");
		// oci_execute($update);
		// oci_commit;
		$data['hasil']=1;
		echo json_encode($data);
	break;
	
	
	
	case "validasi_tag":
		//cek apakah tag sudah di validasi
		$cek_tagvalidasi =$mysqli->query( "SELECT * FROM TAG WHERE NOTAG='$_POST[no_tag]' ");
		// oci_execute($cek_tagvalidasi);
		$ct =mysqli_fetch_array($cek_tagvalidasi);
		
		if($ct['TAGVALIDASI']=='Y' OR $ct['TAGVALIDASI']=='C') {
			$data['hasil']=0;
			$data['judul']='WARNING';
			$data['status']='warning';
			$data['ket']='Transaksi TAG Sudah di Validasi...';
		} else {
			//mengurangi stock di department gudang (41)
			include '../department/queryDepartmentUtama.php';
			$d =mysqli_fetch_array($queryGetDepartment);
			$idDepartmentUtama =$d['ID_DEPARTMENT'];
			
			$tampil =$mysqli->query( "SELECT * FROM TAG_DETAIL WHERE NOTAG='$_POST[no_tag]' AND TAGDETAILISACTIVE='Y' ");
			// oci_execute($tampil);
			while ($t =mysqli_fetch_array($tampil)) {
				$itemStock =$mysqli->query ( "SELECT * FROM ITEMSTOCK WHERE ITEMSTOCK_IDITEM='$t[TAGDETAILM_ITEMID]' AND ITEMSTOCK_IDSATUAN='$t[TAGDETAILM_SATUANID]' AND 
												ITEMSTOCK_LOTNUMBER='$t[TAGDETAILM_ITEMSTOCKLOTNUMBER]' AND DATE(ITEMSTOCK_ED)='$t[TAGDETAILED]' AND 
												ITEMSTOCK_IDDEPARTMENT='$idDepartmentUtama' ");
				// oci_execute($itemStock);
				$i =mysqli_fetch_array($itemStock);
				$idItemStock =$i['IDITEMSTOCK'];
				$stock_awal =$i['ITEMSTOCK_STOCK'];
				
				$stock_akhir =$stock_awal - $t['TAGDETAILQTY'];
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
											('$now','$idItemStock','$idDepartmentUtama','$stock_awal','0','$t[TAGDETAILQTY]','$stock_akhir','TAG KELUAR','$_POST[no_tag]')
											");
				// oci_execute($input);
				// oci_commit;
			}
			
			//ubah flag validasi tag
			$update2 =$mysqli->query ( "UPDATE TAG SET 
											TAGVALIDASI 	='Y',
											TAGUSERNAME		='$username',
											TAGLASTUPDATE	='$now'
										WHERE NOTAG='$_POST[no_tag]' ");
			// oci_execute($update2);
			// oci_commit;
			
			$data['hasil']=1;
		}
		echo json_encode($data);
	break;
	
	
	
	case "checkout_barcode":
		//cek apakah kode barcode ada/valid dari id_department asal (department gudang 41)
		include '../department/queryDepartmentUtama.php';
		$d =mysqli_fetch_array($queryGetDepartment);
		$idDepartmentUtama =$d['ID_DEPARTMENT'];
		
		$cek =$mysqli->query( "SELECT * FROM M_ITEMBARCODE WHERE KODEBARCODE='$_POST[barcode]' AND M_DEPARTMENTDEPARTMENTID='$idDepartmentUtama' AND BARCODEISACTIVE='Y' ");
		// oci_execute($cek);
		$cek_jml =mysqli_num_rows($cek);
		
		if($cek_jml==0) {
			$data['hasil']=0;
			$data['judul']='ERROR';
			$data['status']='error';
			$data['ket']='Kode Barcode tidak Valid...';
		} else {
			//mencari notag_detail,id_department tujuan dan cek apakah qty sudah terpenuhi
			$tag_detail =$mysqli->query( "SELECT KODEBARCODE,t.NOTAG,NOTAG_DETAIL,TAGID_DEPARTMENT,TAGDETAILQTY,TAGDETAILTERPENUHI
												FROM M_ITEMBARCODE b 
												JOIN TAG_DETAIL d ON d.TAGDETAILM_ITEMID=b.M_ITEMIDITEM AND d.TAGDETAILM_SATUANID=b.M_SATUANIDSATUAN AND 
													d.TAGDETAILM_ITEMSTOCKLOTNUMBER=b.LOT_NUMBER AND d.TAGDETAILISACTIVE='Y' 
												JOIN TAG t ON t.NOTAG=d.NOTAG
												WHERE d.NOTAG='$_POST[no_tag]' AND b.KODEBARCODE='$_POST[barcode]' ");
			// oci_execute($tag_detail);
			$r =mysqli_fetch_array($tag_detail);
			$notag_detail =$r['NOTAG_DETAIL'];
			$id_department =$r['TAGID_DEPARTMENT'];
			$qty =$r['TAGDETAILQTY'];
			$qtyterpenuhi =$r['TAGDETAILTERPENUHI'];
			
			if($qty==$qtyterpenuhi) {
				$data['hasil']=0;
				$data['judul']='WARNING';
				$data['status']='warning';
				$data['ket']='Kode Barcode Item ini sudah terpenuhi..';
			} else {
				//cek barcode apakah sudah discan ke TAG_DETAIL_BARCODE dengan notag_detail diatas
				$cek_barcode =$mysqli->query( "SELECT * FROM TAG_DETAIL_BARCODE WHERE NOTAG_DETAIL='$notag_detail' AND KODEBARCODE='$_POST[barcode]' AND ISACTIVE='Y' ");
				// oci_execute($cek_barcode);
				$jml =mysqli_num_rows($cek_barcode);
				
				if($jml>0) {
					$data['hasil']=0;
					$data['judul']='WARNING';
					$data['status']='warning';
					$data['ket']='Kode Barcode sudah di check out..';
				} else {
					//mengubah id department pada M_ITEMBARCODE
					$itembarcode =$mysqli->query( "UPDATE M_ITEMBARCODE SET 
														M_DEPARTMENTDEPARTMENTID	='$id_department',
														TAGDETAILIDTAG				='$notag_detail',
														IDGUDANG					='0',
														IDRAKGUDANG					='0',
														USERID						='$username',
														LASTUPDATE					='$now'
													WHERE KODEBARCODE='$_POST[barcode]' ");
					// oci_execute($itembarcode);
					// oci_commit;
					
					//input data barcode ke TAG_DETAIL_BARCODE
					$tagbarcode =$mysqli->query( "INSERT INTO TAG_DETAIL_BARCODE
												(NOTAG_DETAIL,KODEBARCODE,LASTUPDATE,USERNAME) VALUES
												('$notag_detail','$_POST[barcode]','$now','$username')
												");
					// oci_execute($tagbarcode);
					// oci_commit;
					
					//mengubah qty terpenuhi dari TAG_DETAIL
					$hasil =$qtyterpenuhi + 1;
					$updatedetail =$mysqli->query( "UPDATE TAG_DETAIL SET 
														TAGDETAILTERPENUHI	='$hasil',
														TAGDETAILUSERNAME	='$username',
														TAGDETAILLASTUPDATE	='$now'
													WHERE NOTAG_DETAIL='$notag_detail' ");
					// oci_execute($updatedetail);
					// oci_commit;
					
					//mengubah tagvalidasi menjadi 'C' pada table TAG jika sudah terpenuhi semua
					$cek_validasi =$mysqli->query( "SELECT COUNT(NOTAG) AS TOTAL,SUM(NILAI) AS NILAI
													FROM
													(
														SELECT NOTAG,TAGDETAILQTY,TAGDETAILTERPENUHI,CASE WHEN TAGDETAILQTY=TAGDETAILTERPENUHI THEN 1 ELSE 0 END NILAI
														FROM TAG_DETAIL 
														WHERE NOTAG='$_POST[no_tag]' AND TAGDETAILISACTIVE='Y'
													) s
													GROUP BY NOTAG");
					// oci_execute($cek_validasi);
					$v =mysqli_fetch_array($cek_validasi);
					if($v['TOTAL']==$v['NILAI']) {
						$update_validasi =$mysqli->query( "UPDATE TAG SET 
																TAGVALIDASI		='C',
																TAGLASTUPDATE	='$now'
															WHERE NOTAG='$_POST[no_tag]' ");
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
		$cek_batal =$mysqli->query( "SELECT NOTAG,FLAGBATAL,SUM(NILAI_BARANGKELUAR) AS NILAI_BARANGKELUAR,
		SUM(NILAI_BREAKDOWN) AS NILAI_BREAKDOWN,SUM(NILAI_RETUR) AS NILAI_RETUR
		FROM
		(                                    
			SELECT a.NOTAG,a.FLAGBATAL,
			CASE WHEN d.BARANGKELUARDETAILIDKELUAR is NOT NULL AND f.BARANGKELUARISACTIVE='Y' AND f.BARANGKELUARFLAGBATAL='N' AND d.BARCODEISACTIVE='N' THEN 1
			ELSE 0 END AS NILAI_BARANGKELUAR,
			CASE WHEN d.BREAKDOWNDETAILIDBREAKDOWN is NOT NULL AND h.ISACTIVE='Y' and h.FLAGBATAL='N' THEN 1
			ELSE 0 END AS NILAI_BREAKDOWN,
			CASE WHEN d.RETURDETAILIDRETUR is NOT NULL AND r.RETURISACTIVE='Y' and r.FLAGBATAL='N' THEN 1
			ELSE 0 END AS NILAI_RETUR
			FROM TAG a
			JOIN TAG_DETAIL b ON b.NOTAG=a.NOTAG AND b.TAGDETAILISACTIVE='Y'
			left JOIN TAG_DETAIL_BARCODE c ON c.NOTAG_DETAIL=b.NOTAG_DETAIL AND c.ISACTIVE='Y'
			left JOIN M_ITEMBARCODE d ON d.KODEBARCODE=c.KODEBARCODE
			LEFT JOIN BARANG_KELUAR_DETAIL e ON e.NOBARANGKELUARDETAIL=d.BARANGKELUARDETAILIDKELUAR
			LEFT JOIN BARANG_KELUAR f ON f.NOBARANGKELUAR=e.NOBARANGKELUAR
			left join BREAKDOWN_DETAIL g ON g.NOBREAKDOWNDETAIL=d.BREAKDOWNDETAILIDBREAKDOWN
			LEFT JOIN BREAKDOWN h ON h.NOBREAKDOWN=g.NOBREAKDOWN
			LEFT JOIN RETUR_DETAIL rd ON rd.NORETUR_DETAIL=d.RETURDETAILIDRETUR
			LEFT JOIN RETUR r ON r.NORETUR=rd.NORETUR
			WHERE b.NOTAG='$nosj'
		)a
		GROUP BY NOTAG,FLAGBATAL");
		// oci_execute($cek_batal);
		$cv =mysqli_fetch_array($cek_batal);
		
		if($cv['FLAGBATAL']=='Y') {
			$data['hasil']=0;
			$data['judul']='WARNING';
			$data['status']='warning';
			$data['ket']='Transaksi ini Sudah di Batal...';
		} else if($cv['NILAI_BARANGKELUAR']>0) {
			$data['hasil']=0;
			$data['judul']='WARNING';
			$data['status']='warning';
			$data['ket']='Kode barcode sudah ada yang digunakan transaksi BARANG KELUAR...';
		} else if($cv['NILAI_BREAKDOWN']>0) {
			$data['hasil']=0;
			$data['judul']='WARNING';
			$data['status']='warning';
			$data['ket']='Kode barcode sudah ada yang digunakan transaksi BREAKDOWN...';
		} else if($cv['NILAI_RETUR']>0) {
			$data['hasil']=0;
			$data['judul']='WARNING';
			$data['status']='warning';
			$data['ket']='Kode barcode sudah ada yang digunakan transaksi RETUR...';
		} else {
			include '../department/queryDepartmentUtama.php';
			$zz =mysqli_fetch_array($queryGetDepartment);
			$iddepartmenpusat=$zz['ID_DEPARTMENT'];
			
			$tampil =$mysqli->query( "SELECT a.NOTAG,a.TAGID_DEPARTMENT,a.TAGTERIMA,d.TAGDETAILM_ITEMID,d.TAGDETAILM_SATUANID,d.TAGDETAILM_ITEMSTOCKLOTNUMBER,
			d.TAGDETAILQTY,d.TAGDETAILED,d.NOTAG_DETAIL,d.TAGDETAILTERPENUHI,d.TAGDETAILTERIMA
			FROM TAG_DETAIL d
			join TAG a on a.NOTAG=d.NOTAG and a.TAGISACTIVE='Y'
			WHERE a.NOTAG='$nosj' AND d.TAGDETAILISACTIVE='Y' ");
			// oci_execute($tampil);
			while ($t =mysqli_fetch_array($tampil)) {
				
				$itempusat=$mysqli->query("select IDITEMSTOCK,ITEMSTOCK_STOCK from ITEMSTOCK 
				WHERE ITEMSTOCK_IDITEM='$t[TAGDETAILM_ITEMID]' AND ITEMSTOCK_IDSATUAN='$t[TAGDETAILM_SATUANID]' AND 
				ITEMSTOCK_LOTNUMBER='$t[TAGDETAILM_ITEMSTOCKLOTNUMBER]' AND 
				ITEMSTOCK_IDDEPARTMENT='$iddepartmenpusat'");
				// oci_execute($itempusat);
				$ip=mysqli_fetch_array($itempusat);
				$iditemstockpusat=$ip['IDITEMSTOCK'];
				$stock_awalpusat =$ip['ITEMSTOCK_STOCK'];
				$stock_akhirpusat =$stock_awalpusat + $t['TAGDETAILQTY'];
				//mengembalikan/menambah stock di department dengan qty awal
				if($t['TAGTERIMA']=='Y'){
					
				$itemcabang=$mysqli->query("select IDITEMSTOCK,ITEMSTOCK_STOCK from ITEMSTOCK 
				WHERE ITEMSTOCK_IDITEM='$t[TAGDETAILM_ITEMID]' AND ITEMSTOCK_IDSATUAN='$t[TAGDETAILM_SATUANID]' AND 
				ITEMSTOCK_LOTNUMBER='$t[TAGDETAILM_ITEMSTOCKLOTNUMBER]' AND 
				ITEMSTOCK_IDDEPARTMENT='$t[TAGID_DEPARTMENT]'");
				// oci_execute($itemcabang);
				$ic=mysqli_fetch_array($itemcabang);
				$iditemstock=$ic['IDITEMSTOCK'];
				$stock_awal =$ic['ITEMSTOCK_STOCK'];
				$stock_akhir =$stock_awal - $t['TAGDETAILQTY'];

				$hasilcabang=$mysqli->query("update ITEMSTOCK set ITEMSTOCK_STOCK=ITEMSTOCK_STOCK-$t[TAGDETAILQTY],
				ITEMSTOCK_LASTUPDATE=CURRENT_TIMESTAMP,
				ITEMSTOCK_USERNAME='$userid'
				where IDITEMSTOCK=$iditemstock");
				// oci_execute($hasilcabang);

				$historycabang=$mysqli->query("INSERT INTO ITEMSTOCK_HISTORY 
				(TANGGAL,IDITEMSTOCK,DEPARTMENTID,STOCKAWAL,STOCKIN,STOCKOUT,STOCKAKHIR,
				CATATAN,NOTRANSAKSI) VALUES
				(CURRENT_TIMESTAMP,'$iditemstock','$t[TAGID_DEPARTMENT]','$stock_awal','0','$t[TAGDETAILQTY]','$stock_akhir',
				'BATAL PENERIMAAN TAG','$nosj')
				");
				// oci_execute($historycabang);

				$hasilpusat=$mysqli->query("update ITEMSTOCK set ITEMSTOCK_STOCK=ITEMSTOCK_STOCK+$t[TAGDETAILQTY],
				ITEMSTOCK_LASTUPDATE=CURRENT_TIMESTAMP,
				ITEMSTOCK_USERNAME='$userid'
				where IDITEMSTOCK='$iditemstockpusat'");
				// oci_execute($hasilpusat);
				
				$historypusat=$mysqli->query("INSERT INTO ITEMSTOCK_HISTORY 
				(TANGGAL,IDITEMSTOCK,DEPARTMENTID,STOCKAWAL,STOCKIN,STOCKOUT,STOCKAKHIR,
				CATATAN,NOTRANSAKSI) VALUES
				(CURRENT_TIMESTAMP,'$iditemstockpusat','$iddepartmenpusat','$stock_awalpusat','$t[TAGDETAILQTY]','0','$stock_akhirpusat',
				'BATAL TAG','$nosj')
				");
				// oci_execute($historypusat);

				$barcodepusat=$mysqli->query("update M_ITEMBARCODE set M_DEPARTMENTDEPARTMENTID=$iddepartmenpusat,
						LASTUPDATE=CURRENT_TIMESTAMP,
						USERID='$userid',
						IDGUDANG='0',
						IDRAKGUDANG='0'
						where KODEBARCODE in (
							select KODEBARCODE from TAG_DETAIL_BARCODE
							where NOTAG_DETAIL='$t[NOTAG_DETAIL]'
							)");
				// oci_execute($barcodepusat);
				
				// oci_commit;
				$data['hasil']=1;
				$data['status']='SUCCESS';
				$data['ket']='TAG NO $nosj Sudah dibatalkan...';
				}
				else{
					$hasilpusat=$mysqli->query("update ITEMSTOCK set ITEMSTOCK_STOCK=ITEMSTOCK_STOCK+$t[TAGDETAILQTY],
					ITEMSTOCK_LASTUPDATE=CURRENT_TIMESTAMP,
					ITEMSTOCK_USERNAME='$userid'
					where IDITEMSTOCK=$iditemstockpusat");
					// oci_execute($hasilpusat);
					
					$historypusat=$mysqli->query("INSERT INTO ITEMSTOCK_HISTORY 
					(TANGGAL,IDITEMSTOCK,DEPARTMENTID,STOCKAWAL,STOCKIN,STOCKOUT,STOCKAKHIR,
					CATATAN,NOTRANSAKSI) VALUES
					(CURRENT_TIMESTAMP,'$iditemstockpusat','$iddepartmenpusat','$stock_awalpusat','$t[TAGDETAILQTY]','0','$stock_akhirpusat',
					'BATAL TAG','$nosj')
					");
				// oci_execute($historypusat);
					if($t['TAGDETAILTERPENUHI'] > 0)
					{
						$barcodepusat=$mysqli->query("update M_ITEMBARCODE 
						set M_DEPARTMENTDEPARTMENTID=$iddepartmenpusat,
						LASTUPDATE=CURRENT_TIMESTAMP,
						USERID='$userid',
						IDGUDANG='0',
						IDRAKGUDANG='0'
						where KODEBARCODE in (
							select KODEBARCODE from TAG_DETAIL_BARCODE
							where NOTAG_DETAIL='$t[NOTAG_DETAIL]'
							)");
						// oci_execute($barcodepusat);
					}
					// oci_commit;
					$data['hasil']=1;
					$data['status']='SUCCESS';
					$data['ket']='TAG NO $nosj Sudah dibatalkan...';
				}
				
			}
			$tag=$mysqli->query("update TAG set FLAGBATAL='Y',
			TAGLASTUPDATE=CURRENT_TIMESTAMP,
			TAGUSERNAME='$userid',
			TAGNOTE='$keterangan'
			where NOTAG='$nosj'");
			// oci_execute($tag);
			// oci_commit;
			echo json_encode($data);
		}
	break;

}
