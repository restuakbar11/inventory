<?php
error_reporting(0);
include "../../config/connect.php";
session_start();
include "../numbering/f_numbering.php";
$conn ="../../config/connect.php";


date_default_timezone_set('Asia/Jakarta');
$now			=date('Y-m-d H:i:s');
$username		=$_SESSION['username'];
$id_department	=$_SESSION['id_department'];


switch ($_POST['act']){
	
	case "save_header":
		if($_POST['aksi']=='add') {
			$cek_name =$mysqli->query( "SELECT * FROM BARANG_KELUAR WHERE NOBARANGKELUAR='$_POST[no_barang_keluar]' ");
			// oci_execute($cek_name);
			$jml =mysqli_num_rows($cek_name);
			
			if($jml>0) {
				$data['hasil']=0;
			} else {
				$number =Numbering('Barang Keluar', $conn);
				$tgl =date('Y-m-d',strtotime($_POST['tanggal']));
				$input =$mysqli->query( "INSERT INTO BARANG_KELUAR 
											(NOBARANGKELUAR,BARANGKELUARID_SUBDEPARTMENT,BARANGKELUARTANGGAL,BARANGKELUARNOTE,BARANGKELUARUSERNAME,BARANGKELUARLASTUPDATE,BARANGKELUARID_DEPARTMENT)
											VALUES
											('$number','$_POST[id_subdepartment]','$tgl','$_POST[note]','$username','$now','$id_department')
											") ;
					// oci_execute($input);
					// oci_commit;
					$data['hasil']=1;
					$data['tgl']=$tgl;
			}
		} else if($_POST['aksi']=='update') {
			$tgl =date('Y-m-d',strtotime($_POST['tanggal']));
			$update =$mysqli->query( "UPDATE BARANG_KELUAR SET 
											BARANGKELUARID_SUBDEPARTMENT	='$_POST[id_subdepartment]',
											BARANGKELUARTANGGAL				='$tgl',
											BARANGKELUARNOTE				='$_POST[note]',
											BARANGKELUARUSERNAME			='$username',
											BARANGKELUARLASTUPDATE			='$now'
										WHERE NOBARANGKELUAR='$_POST[no_barang_keluar]' ");
			// oci_execute($update);
			// oci_commit;
			$data['hasil']=1;
		}
		
		echo json_encode($data);
    break;
	
	
	
	case "getHeader":
		$sql =$mysqli->query( "SELECT * FROM BARANG_KELUAR WHERE NOBARANGKELUAR='$_POST[no_barang_keluar]' ");
		// oci_execute($sql);
		$r =mysqli_fetch_array($sql);
		
		$tgl =date('Y-m-d',strtotime($r['BARANGKELUARTANGGAL']));
		$data['BARANGKELUARID_SUBDEPARTMENT']	=$r['BARANGKELUARID_SUBDEPARTMENT'];
		$data['BARANGKELUARTANGGAL']			=$tgl;
		$data['BARANGKELUARNOTE']				=$r['BARANGKELUARNOTE'];
		echo json_encode($data);
    break;
	
	
	
	case "save_item":
		$cek =$mysqli->query( "SELECT NOBARANGKELUAR,NOBARANGKELUARDETAIL,count(NOBARANGKELUARDETAIL) as JML 
								FROM BARANG_KELUAR_DETAIL 
								WHERE NOBARANGKELUAR='$_POST[no_barang_keluar]' AND BARANGKELUARDETAILIDITEM='$_POST[id_item]' AND BARANGKELUARDETAILIDSATUAN='$_POST[id_satuan]'
								AND BARANGKELUARDETAILLOT_NUMBER='$_POST[lot_number]' AND BARANGKELUARDETAILED='$_POST[ed]' AND BARANGKELUARDETAILISACTIVE='Y' 
								GROUP BY NOBARANGKELUARDETAIL,NOBARANGKELUAR");
		// oci_execute($cek);
		$r =mysqli_fetch_array($cek);
		
		if($r['JML']!='') {
			$update =$mysqli->query( "UPDATE BARANG_KELUAR_DETAIL SET 
											BARANGKELUARDETAILQTY		='$_POST[qty]',
											BARANGKELUARDETAILUSERNAME	='$username',
											BARANGKELUARDETAILLASTUPDATE	='$now'
										WHERE NOBARANGKELUARDETAIL='$r[NOBARANGKELUARDETAIL]' ");
			// oci_execute($update);
			// oci_commit;
			$data['hasil']=1;
			$data['jml']=$r['JML'];
		} else {
			$no_max =$mysqli->query( "SELECT *
										FROM
										(
											SELECT NOBARANGKELUAR,NOBARANGKELUARDETAIL,SUBSTR(NOBARANGKELUARDETAIL,-3,3) AS COUNTER
											FROM BARANG_KELUAR_DETAIL 
											WHERE NOBARANGKELUAR='$_POST[no_barang_keluar]'
											ORDER BY NOBARANGKELUARDETAIL DESC
										) a
										
										ORDER BY NOBARANGKELUARDETAIL DESC
										LIMIT 1");
			// oci_execute($no_max);
			$n =mysqli_fetch_array($no_max);
			$seq =$n['COUNTER'] + 1;
			$counter =str_pad($seq,3,'0',STR_PAD_LEFT); 
			$nobarang_keluar_detail =$_POST['no_barang_keluar'].'-'.$counter;
			
			
			$input =$mysqli->query( "INSERT INTO BARANG_KELUAR_DETAIL
									(NOBARANGKELUAR,BARANGKELUARDETAILIDITEM,BARANGKELUARDETAILIDSATUAN,BARANGKELUARDETAILLOT_NUMBER,BARANGKELUARDETAILQTY,BARANGKELUARDETAILED,
										BARANGKELUARDETAILUSERNAME,BARANGKELUARDETAILLASTUPDATE,NOBARANGKELUARDETAIL) VALUES
									('$_POST[no_barang_keluar]','$_POST[id_item]','$_POST[id_satuan]','$_POST[lot_number]','$_POST[qty]','$_POST[ed]',
										'$username','$now','$nobarang_keluar_detail')");
			// oci_execute($input);
			// oci_commit;
			$data['hasil']=1;
			$data['no']=$nobarang_keluar_detail;
		}
		echo json_encode($data);
	break;
	
	
	
	case "hapusitem":
		$update =$mysqli->query ( "UPDATE BARANG_KELUAR_DETAIL SET 
										BARANGKELUARDETAILISACTIVE 	='N',
										BARANGKELUARDETAILUSERNAME	='$username',
										BARANGKELUARDETAILLASTUPDATE	='$now'
									WHERE NOBARANGKELUARDETAIL='$_POST[nobarang_keluar_detail]' ");
		// oci_execute($update);
		// oci_commit;
		$data['hasil']=1;
		echo json_encode($data);
	break;
	
	
	
	case "hapusbarangkeluar":
		$update =$mysqli->query ( "UPDATE BARANG_KELUAR SET 
										BARANGKELUARISACTIVE 	='N',
										BARANGKELUARUSERNAME	='$username',
										BARANGKELUARLASTUPDATE	='$now'
									WHERE NOBARANGKELUAR='$_POST[no_barang_keluar]' ");
		// oci_execute($update);
		// oci_commit;
		$data['hasil']=1;
		echo json_encode($data);
	break;
	
	
	
	case "validasi_barang_keluar":
		//cek apakah transaksi barang_keluar sudah di validasi
		$cek_validasi =$mysqli->query( "SELECT * FROM BARANG_KELUAR WHERE NOBARANGKELUAR='$_POST[no_barang_keluar]' ");
		// oci_execute($cek_validasi);
		$cv =mysqli_fetch_array($cek_validasi);
		
		if($cv['BARANGKELUARVALIDASI']=='Y' OR $cv['BARANGKELUARVALIDASI']=='C') {
			$data['hasil']=0;
			$data['judul']='WARNING';
			$data['status']='warning';
			$data['ket']='Transaksi ini Sudah di Validasi...';
		} else {
			//mencari id_department dari no_barang_keluar ini
			$department =$mysqli->query( "SELECT NOBARANGKELUAR,BARANGKELUARID_DEPARTMENT 
											FROM BARANG_KELUAR 
											WHERE NOBARANGKELUAR='$_POST[no_barang_keluar]' ");
			// oci_execute($department);
			$d =mysqli_fetch_array($department);
			$id_department =$d['BARANGKELUARID_DEPARTMENT'];
			
			$tampil =$mysqli->query( "SELECT * FROM BARANG_KELUAR_DETAIL WHERE NOBARANGKELUAR='$_POST[no_barang_keluar]' AND BARANGKELUARDETAILISACTIVE='Y' ");
			// oci_execute($tampil);
			while ($t =mysqli_fetch_array($tampil)) {
				//mengurangi stock di department dari subdepartment tujuan
				$itemStock =$mysqli->query ( "SELECT * FROM ITEMSTOCK WHERE ITEMSTOCK_IDITEM='$t[BARANGKELUARDETAILIDITEM]' AND ITEMSTOCK_IDSATUAN='$t[BARANGKELUARDETAILIDSATUAN]' AND 
											ITEMSTOCK_LOTNUMBER='$t[BARANGKELUARDETAILLOT_NUMBER]' AND DATE(ITEMSTOCK_ED)='$t[BARANGKELUARDETAILED]' AND 
											ITEMSTOCK_IDDEPARTMENT='$id_department' ");
				// oci_execute($itemStock);
				$i =mysqli_fetch_array($itemStock);
				$idItemStock =$i['IDITEMSTOCK'];
				$stock_awal =$i['ITEMSTOCK_STOCK'];
				
				$stock_akhir =$stock_awal - $t['BARANGKELUARDETAILQTY'];
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
											('$now','$idItemStock','$id_department','$stock_awal','0','$t[BARANGKELUARDETAILQTY]','$stock_akhir','BARANG KELUAR','$_POST[no_barang_keluar]')
											");
				// oci_execute($input);
				// oci_commit;
			}
			//ubah flag validasi barang_keluar
			$update2 =$mysqli->query ( "UPDATE BARANG_KELUAR SET 
											BARANGKELUARVALIDASI 	='Y',
											BARANGKELUARUSERNAME	='$username',
											BARANGKELUARLASTUPDATE	='$now'
										WHERE NOBARANGKELUAR='$_POST[no_barang_keluar]' ");
			// oci_execute($update2);
			// oci_commit;
			
			$data['hasil']=1;
		}
		
		echo json_encode($data);
	break;
	
	
	
	case "checkout_barcode":
		//cek apakah kode barcode ada/valid sesuai dengan id_department barang_keluar
		$cek =$mysqli->query( "SELECT * 
								FROM BARANG_KELUAR k 
								JOIN M_ITEMBARCODE b ON M_DEPARTMENTDEPARTMENTID=k.BARANGKELUARID_DEPARTMENT AND BARCODEISACTIVE='Y'
								WHERE KODEBARCODE='$_POST[barcode]' AND NOBARANGKELUAR='$_POST[no_barang_keluar]' ");
		// oci_execute($cek);
		$cek_jml =mysqli_num_rows($cek);
		
		if($cek_jml==0) {
			$data['hasil']=0;
			$data['judul']='ERROR';
			$data['status']='error';
			$data['ket']='Kode Barcode Tidak Valid/Sudah Tidak Aktif...';
		} else {
			//mencari nobarang_keluar_detail dan cek apakah qty sudah terpenuhi
			$tag_detail =$mysqli->query( "SELECT KODEBARCODE,t.NOBARANGKELUAR,NOBARANGKELUARDETAIL,BARANGKELUARID_SUBDEPARTMENT,BARANGKELUARID_DEPARTMENT,
											BARANGKELUARDETAILQTY,BARANGKELUARDETAILTERPENUHI
												FROM M_ITEMBARCODE b 
												JOIN BARANG_KELUAR_DETAIL d ON d.BARANGKELUARDETAILIDITEM=b.M_ITEMIDITEM AND d.BARANGKELUARDETAILIDSATUAN=b.M_SATUANIDSATUAN AND 
													d.BARANGKELUARDETAILLOT_NUMBER=b.LOT_NUMBER AND d.BARANGKELUARDETAILISACTIVE='Y' 
												JOIN BARANG_KELUAR t ON t.NOBARANGKELUAR=d.NOBARANGKELUAR
												WHERE d.NOBARANGKELUAR='$_POST[no_barang_keluar]' AND b.KODEBARCODE='$_POST[barcode]' ");
			// oci_execute($tag_detail);
			$r =mysqli_fetch_array($tag_detail);
			$nobarang_keluar_detail =$r['NOBARANGKELUARDETAIL'];
			$id_subdepartment		=$r['BARANGKELUARID_SUBDEPARTMENT'];
			$id_department 			=$r['BARANGKELUARID_DEPARTMENT'];
			$qty 					=$r['BARANGKELUARDETAILQTY'];
			$qtyterpenuhi 			=$r['BARANGKELUARDETAILTERPENUHI'];
			
			if($qty==$qtyterpenuhi) {
				$data['hasil']=0;
				$data['judul']='WARNING';
				$data['status']='warning';
				$data['ket']='Kode Barcode Item ini sudah terpenuhi..';
			} else {
				//cek barcode apakah sudah discan ke BARANG_KELUAR_DETAIL_BARCODE dengan nobarang_keluar_detail diatas
				$cek_barcode =$mysqli->query( "SELECT * FROM BARANG_KELUAR_DETAIL_BARCODE WHERE NOBARANGKELUARDETAIL='$nobarang_keluar_detail' AND 
												KODEBARCODE='$_POST[barcode]' AND ISACTIVE='Y' ");
				// oci_execute($cek_barcode);
				$jml =mysqli_num_rows($cek_barcode);
				
				if($jml>0) {
					$data['hasil']=0;
					$data['judul']='WARNING';
					$data['status']='warning';
					$data['ket']='Kode Barcode sudah di check out..';
				} else {
					//mengubah barcodeisactive menjadi 'N' pada M_ITEMBARCODE
					$itembarcode =$mysqli->query( "UPDATE M_ITEMBARCODE SET 
														BARANGKELUARDETAILIDKELUAR	='$nobarang_keluar_detail',
														BARCODEISACTIVE				='N',
														USERID						='$username',
														LASTUPDATE					='$now'
													WHERE KODEBARCODE='$_POST[barcode]' ");
					// oci_execute($itembarcode);
					// oci_commit;
					
					//input data barcode ke BARANG_KELUAR_DETAIL_BARCODE
					$tagbarcode =$mysqli->query( "INSERT INTO BARANG_KELUAR_DETAIL_BARCODE
												(NOBARANGKELUARDETAIL,KODEBARCODE,LASTUPDATE,USERNAME) VALUES
												('$nobarang_keluar_detail','$_POST[barcode]','$now','$username')
												");
					// oci_execute($tagbarcode);
					// oci_commit;
					
					//mengubah qty terpenuhi dari BARANG_KELUAR_DETAIL
					$hasil =$qtyterpenuhi + 1;
					$updatedetail =$mysqli->query( "UPDATE BARANG_KELUAR_DETAIL SET 
														BARANGKELUARDETAILTERPENUHI		='$hasil',
														BARANGKELUARDETAILUSERNAME		='$username',
														BARANGKELUARDETAILLASTUPDATE	='$now'
													WHERE NOBARANGKELUARDETAIL='$nobarang_keluar_detail' ");
					// oci_execute($updatedetail);
					// oci_commit;
					
					//mengubah barangkeluarvalidasi menjadi 'C' pada table BARANG_KELUAR jika sudah terpenuhi semua
					$cek_validasi =$mysqli->query( "SELECT COUNT(NOBARANGKELUAR) AS TOTAL,SUM(NILAI) AS NILAI
													FROM
													(
														SELECT NOBARANGKELUAR,BARANGKELUARDETAILQTY,BARANGKELUARDETAILTERPENUHI,CASE 
														WHEN BARANGKELUARDETAILQTY=BARANGKELUARDETAILTERPENUHI THEN 1 ELSE 0 END NILAI
														FROM BARANG_KELUAR_DETAIL 
														WHERE NOBARANGKELUAR='$_POST[no_barang_keluar]'
													) s
													GROUP BY NOBARANGKELUAR");
					// oci_execute($cek_validasi);
					$v =mysqli_fetch_array($cek_validasi);
					if($v['TOTAL']==$v['NILAI']) {
						$update_validasi =$mysqli->query( "UPDATE BARANG_KELUAR SET 
																BARANGKELUARVALIDASI	='C',
																BARANGKELUARLASTUPDATE	='$now'
															WHERE NOBARANGKELUAR='$_POST[no_barang_keluar]' ");
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

	case 'pembatalan':
		$NOBARANGKELUAR = $_POST['nosj'];
		$USERID = $_POST['userid'];
		$KET = $_POST['keterangan'];
		$sql ="UPDATE BARANG_KELUAR SET 
					BARANGKELUARFLAGBATAL	='Y',
					BARANGKELUARKETERANGAN	='$KET',
					BARANGKELUARUSERNAME		='$USERID'
				WHERE NOBARANGKELUAR='$NOBARANGKELUAR' ";
				$update =$mysqli->query( $sql);
		        // oci_execute($update);
		        // oci_commit($oci);		

		$ambilDetail = "SELECT NOBARANGKELUARDETAIL, BARANGKELUARDETAILIDITEM, BARANGKELUARDETAILIDSATUAN, BARANGKELUARDETAILLOT_NUMBER, BARANGKELUARDETAILQTY, BARANGKELUARID_DEPARTMENT from BARANG_KELUAR a
			inner join BARANG_KELUAR_DETAIL b on a.NOBARANGKELUAR=b.NOBARANGKELUAR
			where a.NOBARANGKELUAR='$NOBARANGKELUAR'";
			$load =$mysqli->query( $ambilDetail);
			// oci_execute($load);
			while ($r =mysqli_fetch_array($load)){
				$nobarang_keluar_detail = $r['NOBARANGKELUARDETAIL'];
				$stokBarang = $r['BARANGKELUARDETAILQTY'];
				$departmentKeluar = $r['BARANGKELUARID_DEPARTMENT'];
				$lotKeluar = $r['BARANGKELUARDETAILLOT_NUMBER'];
				$satuanKeluar = $r['BARANGKELUARDETAILIDSATUAN'];
				$itemKeluar = $r['BARANGKELUARDETAILIDITEM'];
				// update barcode menjadi aktif
				$UpdateBarcode ="UPDATE M_ITEMBARCODE SET 
					BARCODEISACTIVE	='Y'
				WHERE BARANGKELUARDETAILIDKELUAR='$nobarang_keluar_detail' ";
				$update2 =$mysqli->query( $UpdateBarcode);
		        // oci_execute($update2);
		        // oci_commit($oci);

		        // update penambahan stok
		        $itemStock =$mysqli->query ( "SELECT * FROM ITEMSTOCK WHERE ITEMSTOCK_IDITEM='$itemKeluar' AND ITEMSTOCK_IDSATUAN='$satuanKeluar' AND ITEMSTOCK_LOTNUMBER='$lotKeluar' AND ITEMSTOCK_IDDEPARTMENT='$departmentKeluar' ");
				// oci_execute($itemStock);
				$i =mysqli_fetch_array($itemStock);

				$idItemStock =$i['IDITEMSTOCK'];
				$stock_awal =$i['ITEMSTOCK_STOCK'];
				$stock_akhir =$stock_awal + $stokBarang;
				$update =$mysqli->query ( "UPDATE ITEMSTOCK SET
										ITEMSTOCK_STOCK			='$stock_akhir',
										ITEMSTOCK_USERNAME		='$username',
										ITEMSTOCK_LASTUPDATE	='$now'
										WHERE IDITEMSTOCK='$idItemStock' ");
				// oci_execute($update);
				// oci_commit;

				// INSERT TRANSAKSI HISTORY
				$input =$mysqli->query( "INSERT INTO ITEMSTOCK_HISTORY 
								(TANGGAL,IDITEMSTOCK,DEPARTMENTID,STOCKAWAL,STOCKIN,STOCKOUT,STOCKAKHIR,CATATAN,NOTRANSAKSI) VALUES
							('$now','$idItemStock','$departmentKeluar','$stock_awal','0','$stokBarang','$stock_akhir','BATAL BARANG KELUAR','$nobarang_keluar_detail')
								");
				// oci_execute($input);
				// oci_commit;
				
				if(!$input)
                {
                    $return = array('status'=> 'FAILED','info'=>'Gagal melakukan pembatalan');
                } else {
				$return = array('status'=> 'SUCCESS','info'=>'Berhasil melakukan pembatalan');
					echo json_encode($return);
                }
		    }
	break;
	
}