<?php
session_start();
include ('../../config/connect.php');
date_default_timezone_set('Asia/Jakarta');
$tgl =date('Y-m-d');
$now =date('Y-m-d H:i:s');
$data_array=array();
$username		=$_SESSION['username'];
switch ($_POST['act']){


    case "simpan":
		$FLAG = $_POST['flag'];
		//$M_DEPARTMENTID = $_POST['department_id'];
		$USERID = $_POST['userid'];
		$NO_BARANGMASUK = $_POST['nosj'];
        /*
		$M_ITEMID = $_POST['item_id'];
		$LOT_NUMBER = $_POST['lot_number'];
		$QTY = $_POST['qty'];
		$EXPIRED_DATE = $_POST['ed'];
		*/
		if($FLAG == 'HEADER'){
			$M_SUPPLIERID = $_POST['supplier_id'];
			$NOTE = $_POST['note'];
			$TANGGAL_MASUK = $_POST['tanggal_masuk'];
			
			//cek apakah data sudah ada?
			$check = $mysqli->query( "SELECT * FROM BARANG_MASUK where NOBARANGMASUK = '$NO_BARANGMASUK'");
			// oci_execute($check);
			$count = mysqli_num_rows($check);
			
			if($count > 0){
            	$return = array('status'=> 'FAILED : Nomor Surat Jalan sudah ada, mohon di cek kembali di daftar barang masuk');               
			} else {		
				$sql = "INSERT INTO BARANG_MASUK (NOBARANGMASUK,BARANGMASUKM_SUPPLIERID,BARANGMASUKNOTE,BARANGMASUKTANGGAL,BARANGMASUKLASTUPDATE,USERID) 
				values ('$NO_BARANGMASUK','$M_SUPPLIERID','$NOTE','$TANGGAL_MASUK','$now','$USERID')";
				//echo $sql;
				$simpan =$mysqli->query( $sql);
				// oci_execute($simpan);
				// oci_commit($oci);
				if(!$simpan)
					{
						$return = array('status'=> 'FAILED');
					} else {
						//insert into barang_masuk_detail
						
						$return = array('status'=> 'SUCCESS');
					}   
			}				
		} else if($FLAG=='DETAIL'){
			$M_ITEMID = $_POST['item_id'];
			$LOT_NUMBER = $_POST['lot_number'];
			$QTY = $_POST['qty'];
			$EXPIRED_DATE = $_POST['ed'];
			$M_SATUANID = $_POST['satuan_id'];
			
			//echo $NEWEDDATE;
			
			//Cek sequence NOBARANGMASUKDETAIL
			$cek = "SELECT MAX(substr(NOBARANGMASUK_DETAIL,-1,3)) AS MAXDETAIL from BARANG_MASUK_DETAIL WHERE NOBARANGMASUK = '$NO_BARANGMASUK'";
			//echo $cek.'<br>';
			$exec = $mysqli->query($cek);
			// oci_execute($exec);
			$r=mysqli_fetch_array($exec);
			
			//tambahkan 1
			$SJDetail = $r['MAXDETAIL']+1;
			$SJDetailSeq= str_pad($SJDetail,3,'0',STR_PAD_LEFT);
			$NOBARANGMASUK_DETAIL = $NO_BARANGMASUK.'-'.$SJDetailSeq;
			
			$sql = "INSERT INTO BARANG_MASUK_DETAIL (NOBARANGMASUK,NOBARANGMASUK_DETAIL,BARANGMASUKDETAILM_ITEMID,BARANGMASUKDETAILM_SATUANID,
			BARANGMASUKDETAILM_ITEMSTOCKLOTNUMBER,BARANGMASUKDETAILQTY,BARANGMASUKDETAIL_ED,BARANGMASUKDETAILLASTUPDATE,USERID) 
			values ('$NO_BARANGMASUK','$NOBARANGMASUK_DETAIL','$M_ITEMID','$M_SATUANID','$LOT_NUMBER','$QTY','$EXPIRED_DATE','$now','$USERID')";
			
			//echo $sql.'<br>';
			$simpan =$mysqli->query( $sql);
            // oci_execute($simpan);
            // oci_commit($oci);
            if(!$simpan)
                {
                    $return = array('status'=> 'FAILED');
                } else {
					//insert into barang_masuk_detail
					
                    $return = array('status'=> 'SUCCESS');
                } 
		}
           /*$return['NO_BARANGMASUK'] =$NO_BARANGMASUK;
           $return['NOBARANGMASUK_DETAIL'] =$NOBARANGMASUK_DETAIL;
           $return['M_ITEMID'] =$M_ITEMID;
           $return['M_SATUANID'] =$M_SATUANID;
           $return['LOT_NUMBER'] =$LOT_NUMBER;
           $return['QTY'] =$QTY;
           $return['EXPIRED_DATE'] =$EXPIRED_DATE;
           $return['now'] =$now;
           $return['USERID'] =$USERID;*/
        echo json_encode($return);		
    break;
    
    
    case "delete":
	
	$NO_BARANGMASUK = $_POST['nosj'];
	$sql="UPDATE BARANG_MASUK SET BARANGMASUKISACTIVE='N',
		BARANGMASUKLASTUPDATE = '$now',
		USERID = '$username'
		where NOBARANGMASUK = '$NO_BARANGMASUK'";
		
		//echo $sql;
		$delete =$mysqli->query( $sql);
        // oci_execute($delete);
        // oci_commit($oci);
		if(!$delete)
        {
            $return = array('status'=> 'FAILED');
        } else {
            $return = array('status'=> 'SUCCESS', 'tes'=>$username);
        }
        echo json_encode($return);
	break;
	
	case "delete_item":
	
	$NOBARANGMASUK_DETAIL = $_POST['nosj_detail'];
	$USERID = $_POST['userid'];
	
	$sql="UPDATE BARANG_MASUK_DETAIL SET BARANGMASUKDETAILISACTIVE='N',
		BARANGMASUKDETAILLASTUPDATE = '$now',
		USERID = '$USERID'
		where NOBARANGMASUK_DETAIL = '$NOBARANGMASUK_DETAIL'";
		
		//echo $sql;
		$delete =$mysqli->query( $sql);
        // oci_execute($delete);
        // oci_commit($oci);
		if(!$delete)
        {
            $return = array('status'=> 'FAILED');
        } else {
            $return = array('status'=> 'SUCCESS');
        }
        echo json_encode($return);
	break;
	
	
	case "update_header" :
		$tgl =date('Y-m-d',strtotime($_POST['tanggal_masuk']));
		$sql ="UPDATE BARANG_MASUK SET 
					BARANGMASUKM_SUPPLIERID	='$_POST[supplier_id]',
					BARANGMASUKNOTE			='$_POST[note]',
					BARANGMASUKTANGGAL		='$tgl',
					BARANGMASUKLASTUPDATE	='$now',
					USERID					='$_POST[userid]'
				WHERE NOBARANGMASUK='$_POST[nosj]' ";
		$update =$mysqli->query( $sql);
        // oci_execute($update);
        // oci_commit($oci);
		if(!$update)
        {
            $return = array('status'=> 'FAILED');
        } else {
            $return = array('status'=> 'SUCCESS');
        }
        echo json_encode($return);
	break;

	case "pembatalan":
		$NOBARANGMASUK = $_POST['nosj'];
		$USERID = $_POST['userid'];
		$KET = $_POST['keterangan'];
		$sql ="UPDATE BARANG_MASUK SET 
					FLAGBATAL	='Y',
					KETERANGAN	='$KET',
					USERID		='$USERID'
				WHERE NOBARANGMASUK='$NOBARANGMASUK' ";
		$update =$mysqli->query( $sql);
        // oci_execute($update);
        // oci_commit($oci);

		if(!$update)
        {
            $return = array('status'=> 'FAILED');
        } else {
            $sql = "SELECT KODEBARCODE,BARANGMASUKDETAILIDMASUK, FLAGGUDANG, TAGDETAILIDTAG FROM M_ITEMBARCODE WHERE barangmasukdetailidmasuk like '%$NOBARANGMASUK%'";
			$load =$mysqli->query( $sql);
			// oci_execute($load);
			$nilai = 0;
			$kondisi = 0;
			$nilai_tag = 0;
			while ($r =mysqli_fetch_array($load)){
				$flag_gudang = $r['FLAGGUDANG'];
				$tag = $r['TAGDETAILIDTAG'];
				$kd_barcode = $r['KODEBARCODE'];
				$brg_detail = $r['BARANGMASUKDETAILIDMASUK'];
				if ($flag_gudang == 0) { // langsung barcode isActive N
					$sqlUpdate ="UPDATE M_ITEMBARCODE SET BARCODEISACTIVE	='N' 
					WHERE BARANGMASUKDETAILIDMASUK='$brg_detail' ";
						$updateBarcode =$mysqli->query( $sqlUpdate);
        				// oci_execute($updateBarcode);
        				// oci_commit($oci);
					$return = array('status'=> 'SUCCESS', 'info' => 'BARANG BERHASIL DIBATALKAN');
					echo json_encode($return);
				}else{ // CEK SUDAH DI TAG ATAU BELUM
					if ($tag == '') { // update item stock dan barcode isActive N
						$nilai = 0;
						
					}else{
						$nilai = 1;
						
					}
				} $kondisi = $kondisi+$nilai;
			}

				if ($kondisi == 0) {
					// BARCODE NON AKTIF
					$sqlUpdate ="UPDATE M_ITEMBARCODE SET BARCODEISACTIVE	='N' 
					WHERE BARANGMASUKDETAILIDMASUK='$brg_detail' ";
						$updateBarcode =$mysqli->query( $sqlUpdate);
        				// oci_execute($updateBarcode);
        				// oci_commit($oci);

        			// PENGURANGAN STOK
        				include '../department/queryDepartmentUtama.php';
						$d =mysqli_fetch_array($queryGetDepartment);
						$idDepartmentUtama =$d['ID_DEPARTMENT'];
						
						$tampil =$mysqli->query( "SELECT NOBARANGMASUK_DETAIL, BARANGMASUKDETAILM_ITEMID,BARANGMASUKDETAILM_SATUANID,
							BARANGMASUKDETAILM_ITEMSTOCKLOTNUMBER,BARANGMASUKDETAILQTY FROM barang_masuk_detail where NOBARANGMASUK='$NOBARANGMASUK' ");
						// oci_execute($tampil);
						while ($t =mysqli_fetch_array($tampil)) {
							$stokBarang = $t['BARANGMASUKDETAILQTY'];
							$brgmasukdetail = $t['NOBARANGMASUK_DETAIL'];
							$itemStock =$mysqli->query ( "SELECT * FROM ITEMSTOCK WHERE ITEMSTOCK_IDITEM='$t[BARANGMASUKDETAILM_ITEMID]' AND ITEMSTOCK_IDSATUAN='$t[BARANGMASUKDETAILM_SATUANID]' AND ITEMSTOCK_LOTNUMBER='$t[BARANGMASUKDETAILM_ITEMSTOCKLOTNUMBER]' AND 
															ITEMSTOCK_IDDEPARTMENT='$idDepartmentUtama' ");
							// oci_execute($itemStock);
							$i =mysqli_fetch_array($itemStock);
							$idItemStock =$i['IDITEMSTOCK'];
							$stock_awal =$i['ITEMSTOCK_STOCK'];
							$stock_akhir =$stock_awal - $stokBarang;
							// UPDATE STOK ITEM
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
										('$now','$idItemStock','$idDepartmentUtama','$stock_awal','0','$stokBarang','$stock_akhir','BATAL','$brgmasukdetail')
											");
							// oci_execute($input);
							// oci_commit;
						}

					$return = array('status'=> 'SUCCESS', 'info' => 'BARANG BERHASIL DIBATALKAN', 'brgmasuk' => $brgmasukdetail, 'kondisi'=> 'BELUM TAG');
					echo json_encode($return);
				}else{
					$ambil_tag = "SELECT TAGDETAILIDTAG FROM M_ITEMBARCODE WHERE barangmasukdetailidmasuk like '%$NOBARANGMASUK%' group by TAGDETAILIDTAG";
					$load_tag =$mysqli->query( $ambil_tag);
					// oci_execute($load_tag);
					$nilai_tag = 0;
					while ($id_tag =mysqli_fetch_array($load_tag)){
						$no_tag = $id_tag['TAGDETAILIDTAG'];
						$cek = "SELECT b.TAGISACTIVE FROM TAG_DETAIL a 
						inner join TAG b on a.NOTAG=b.NOTAG WHERE NOTAG_DETAIL = '$no_tag'";
							$exec = $mysqli->query($cek);
							// oci_execute($exec);
							$r=mysqli_fetch_array($exec);
							$isActivTAG = $r['TAGISACTIVE'];
							
							if ($isActivTAG == 'Y') {
								$nilai_tag = 1;
												
							 }else{ 
							 	$nilai_tag = 0;
							 	
							} $kondisi_tag = $kondisi_tag + $nilai_tag;
							

					}

					if ($kondisi_tag == 0) {
						// BARCODE NONAKTIF
						 	$sqlUpdate ="UPDATE M_ITEMBARCODE SET BARCODEISACTIVE	='N' 
						 	WHERE BARANGMASUKDETAILIDMASUK='$brg_detail' ";
							$updateBarcode =$mysqli->query( $sqlUpdate);
        					// oci_execute($updateBarcode);
        					// oci_commit($oci);

        					// PENGURANGAN STOK 
        				include '../department/queryDepartmentUtama.php';
						$d =mysqli_fetch_array($queryGetDepartment);
						$idDepartmentUtama =$d['ID_DEPARTMENT'];
						
						$tampil =$mysqli->query( "SELECT NOBARANGMASUK_DETAIL, BARANGMASUKDETAILM_ITEMID,BARANGMASUKDETAILM_SATUANID,
							BARANGMASUKDETAILM_ITEMSTOCKLOTNUMBER,BARANGMASUKDETAILQTY FROM barang_masuk_detail where NOBARANGMASUK='$NOBARANGMASUK' ");
						// oci_execute($tampil);
						while ($t =mysqli_fetch_array($tampil)) {
							$stokBarang = $t['BARANGMASUKDETAILQTY'];
							$brgmasukdetail = $t['NOBARANGMASUK_DETAIL'];
							$itemStock =$mysqli->query ( "SELECT * FROM ITEMSTOCK WHERE ITEMSTOCK_IDITEM='$t[BARANGMASUKDETAILM_ITEMID]' AND ITEMSTOCK_IDSATUAN='$t[BARANGMASUKDETAILM_SATUANID]' AND ITEMSTOCK_LOTNUMBER='$t[BARANGMASUKDETAILM_ITEMSTOCKLOTNUMBER]' AND 
															ITEMSTOCK_IDDEPARTMENT='$idDepartmentUtama' ");
							// oci_execute($itemStock);
							$i =mysqli_fetch_array($itemStock);
							$idItemStock =$i['IDITEMSTOCK'];
							$stock_awal =$i['ITEMSTOCK_STOCK'];
							$stock_akhir =$stock_awal - $stokBarang;
							// UPDATE STOK ITEM
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
										('$now','$idItemStock','$idDepartmentUtama','$stock_awal','0','$stokBarang','$stock_akhir','BATAL','$brgmasukdetail')
											");
							// oci_execute($input);
							// oci_commit;
						}
						$return = array('status'=> 'SUCCESS', 'info' => 'BARANG BERHASIL DIBATALKAN', 'brgmasuk' => $brgmasukdetail, 'kondisi'=> 'TAG STATUS N');
						echo json_encode($return);
					}else{
						$return = array('status'=> 'SUCCESS', 'info' => 'BARANG ADA YANG SUDAH DI TAG',  'kondisi'=> 'TAG STATUS Y');
						echo json_encode($return);
					}
				}
			
        }
	break;

}
?>