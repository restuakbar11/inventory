<?php
session_start ();
include "../../config/connect.php";

date_default_timezone_set('Asia/Jakarta');
$now			=date('Y-m-d H:i:s');

$kodebarcode=$_POST['kode_barcode'];

$username = $_SESSION['username'];
if($_POST['aksi']=='tampil'){
    $lisquery=$mysqli->query("select M_ITEMIDITEM from M_ITEMBARCODE
    where KODEBARCODE='$kodebarcode'");
    // oci_execute($lisquery);
    $i=mysqli_fetch_array($lisquery);
    $tanggal=date('Y-m-d');
    echo '
<table class="table table-bordered">
    <thead>
    <tr style="align:center;">
        <th width="15%">Barcode</th>
        <th width="10%">Kode Item</th>
        <th>Nama Item</th>
        <th width="6%">Satuan</th>
        <th width="15%">Lot Number</th>
        <th width="7%">ED</th>
        <th>Lokasi</th>
        <th>Tgl Scan</th>
    </tr>
    <tbody
    </tbody>
    </thead>';
    $hasil=$mysqli->query("select IDITEM,NAMAITEM,c.BARANGMASUKDETAIL_ED,c.BARANGMASUKDETAILM_ITEMSTOCKLOTNUMBER,
    d.NAMASATUAN,KODEBARCODE,NAMAGUDANG,NAMARAKGUDANG,a.KODEBARCODE,TANGGALCHECKINMASUK as TGL
    from M_ITEMBARCODE a
    join M_ITEM b on a.M_ITEMIDITEM=b.IDITEM
    join BARANG_MASUK_DETAIL c on c.NOBARANGMASUK_DETAIL=a.BARANGMASUKDETAILIDMASUK and BARANGMASUKDETAILISACTIVE='Y'
    join M_SATUAN d on c.BARANGMASUKDETAILM_SATUANID=d.IDSATUAN and d.SATUANISACTIVE='Y'
    join M_GUDANG e on e.ID_GUDANG=a.IDGUDANG
    join M_DEPARTMENT g on g.ID_DEPARTMENT=a.M_DEPARTMENTDEPARTMENTID
    join M_RAKGUDANG f on f.ID_RAKGUDANG=a.IDRAKGUDANG
    where date_format(TANGGALCHECKINMASUK,'%Y-%m-%d')='$tanggal' and M_ITEMIDITEM='$i[M_ITEMIDITEM]' ");
    // oci_execute($hasil);

echo"
    <tbody>";
    while($r=mysqli_fetch_array($hasil)){
        echo "<tr>
        
                    <td>$r[KODEBARCODE]</td>
                    <td>$r[IDITEM]</td>
                    <td>$r[NAMAITEM]</td>
                    <td>$r[NAMASATUAN]</td>
                    <td>$r[BARANGMASUKDETAILM_ITEMSTOCKLOTNUMBER]</td>
                    <td>$r[BARANGMASUKDETAIL_ED]</td>
                    <td>$r[NAMAGUDANG]</br>
                    <small>$r[NAMARAKGUDANG]</small></td>
                    <td>$r[TGL]</td>
              </tr>";
    }
            
    echo"</tbody>
</table>";
}
else if($_POST['aksi']=='save'){
    $M_DEPARTMENTDEPARTMENTID=$_POST['M_DEPARTMENTDEPARTMENTID'];
    $IDGUDANG=$_POST['IDGUDANG'];
    $IDRAKGUDANG=$_POST['IDRAKGUDANG'];

    $getbarang="select NOBARANGMASUK,BARANGMASUKDETAILIDMASUK,M_ITEMIDITEM,FLAGGUDANG,ED,LOT_NUMBER,M_SATUANIDSATUAN,M_DEPARTMENTDEPARTMENTID
				from M_ITEMBARCODE i
				JOIN BARANG_MASUK_DETAIL b ON b.NOBARANGMASUK_DETAIL=i.BARANGMASUKDETAILIDMASUK AND BARANGMASUKDETAILISACTIVE='Y'
				where KODEBARCODE='$kodebarcode' and TAGDETAILIDTAG is NULL";
    $databarang=$mysqli->query($getbarang);
    // oci_execute($databarang);
    $w = mysqli_fetch_array($databarang);
    $cek_kode =mysqli_num_rows($databarang);
    if($cek_kode>0){
        if($w['FLAGGUDANG']!=2){
        $simpan=$mysqli->query("update M_ITEMBARCODE set TANGGALCHECKINMASUK=CURRENT_TIMESTAMP,
                                            M_DEPARTMENTDEPARTMENTID='$M_DEPARTMENTDEPARTMENTID',
                                            IDGUDANG='$IDGUDANG',
                                            IDRAKGUDANG='$IDRAKGUDANG',
                                            LASTUPDATE=CURRENT_TIMESTAMP,
                                            USERID='$username',
                                            FLAGGUDANG=1
                    where KODEBARCODE='$kodebarcode'");
        
        }
        else{
        $simpan=$mysqli->query("update M_ITEMBARCODE set TANGGALCHECKINMASUK=CURRENT_TIMESTAMP,
            M_DEPARTMENTDEPARTMENTID='$M_DEPARTMENTDEPARTMENTID',
            IDGUDANG='$IDGUDANG',
            IDRAKGUDANG='$IDRAKGUDANG',
            LASTUPDATE=CURRENT_TIMESTAMP,
            USERID='$username'
    where KODEBARCODE='$kodebarcode'");    
        }
        
        // oci_execute($simpan);
        // oci_commit($oci);
        $query="select count(FLAGGUDANG) as JML_MASUKGUDANG,BARANGMASUKDETAILQTY from M_ITEMBARCODE a
        join BARANG_MASUK_DETAIL c on c.NOBARANGMASUK_DETAIL=a.BARANGMASUKDETAILIDMASUK and BARANGMASUKDETAILISACTIVE='Y'
        join M_SATUAN d on c.BARANGMASUKDETAILM_SATUANID=d.IDSATUAN and d.SATUANISACTIVE='Y'
        where FLAGGUDANG=1 and M_ITEMIDITEM='$w[M_ITEMIDITEM]' and LOT_NUMBER='$w[LOT_NUMBER]' and M_SATUANIDSATUAN='$w[M_SATUANIDSATUAN]'  and BARANGMASUKDETAILIDMASUK='$w[BARANGMASUKDETAILIDMASUK]'
        group by FLAGGUDANG,BARANGMASUKDETAILQTY";
        $hasil=$mysqli->query($query);
        // oci_execute($hasil);
        $data=mysqli_fetch_array($hasil);

        $jml_gudang=$data['JML_MASUKGUDANG'];
        $jml_qty=$data['BARANGMASUKDETAILQTY'];
        if($jml_gudang==$jml_qty and ($jml_gudang!='' or $jml_gudang != null)){
        $querybarang=$mysqli->query("select * from ITEMSTOCK 
            where ITEMSTOCK_IDITEM='$w[M_ITEMIDITEM]' and ITEMSTOCK_LOTNUMBER='$w[LOT_NUMBER]' and ITEMSTOCK_IDSATUAN='$w[M_SATUANIDSATUAN]' and ITEMSTOCK_IDDEPARTMENT='$M_DEPARTMENTDEPARTMENTID'");
            // oci_execute($querybarang);
            $jml=mysqli_num_rows($querybarang);
        $querybarcode=$mysqli->query("update M_ITEMBARCODE 
        set FLAGGUDANG=2 
        where M_ITEMIDITEM='$w[M_ITEMIDITEM]' and LOT_NUMBER='$w[LOT_NUMBER]' and M_SATUANIDSATUAN='$w[M_SATUANIDSATUAN]' and BARANGMASUKDETAILIDMASUK='$w[BARANGMASUKDETAILIDMASUK]'");
            // oci_execute($querybarcode);
            // oci_commit($oci);

            if($jml > 0){
                //mencari iditemstock
                $id_itemstock =$mysqli->query( "SELECT * FROM ITEMSTOCK WHERE ITEMSTOCK_IDITEM='$w[M_ITEMIDITEM]' AND ITEMSTOCK_IDSATUAN='$w[M_SATUANIDSATUAN]' 
                                                AND ITEMSTOCK_LOTNUMBER='$w[LOT_NUMBER]' AND ITEMSTOCK_IDDEPARTMENT='$M_DEPARTMENTDEPARTMENTID' ");
                // oci_execute($id_itemstock);
                $s =mysqli_fetch_array($id_itemstock);
                $iditemstock =$s['IDITEMSTOCK'];
                $stock_awal =$s['ITEMSTOCK_STOCK'];
                $stock_akhir =$stock_awal + $jml_qty;
                
                //update stock
                $insertbarang=$mysqli->query("update ITEMSTOCK set ITEMSTOCK_STOCK='$stock_akhir',
                                            ITEMSTOCK_USERNAME='$username',
                                            ITEMSTOCK_LASTUPDATE=CURRENT_TIMESTAMP
                        where ITEMSTOCK_IDITEM='$w[M_ITEMIDITEM]' and ITEMSTOCK_LOTNUMBER='$w[LOT_NUMBER]' and ITEMSTOCK_IDSATUAN='$w[M_SATUANIDSATUAN]' and ITEMSTOCK_IDDEPARTMENT='$M_DEPARTMENTDEPARTMENTID'");
                // oci_execute($insertbarang);
                // oci_commit($oci);
                
                //insert item stock history
                $input =$mysqli->query( "INSERT INTO ITEMSTOCK_HISTORY 
                                            (TANGGAL,IDITEMSTOCK,DEPARTMENTID,STOCKAWAL,STOCKIN,STOCKOUT,STOCKAKHIR,
                                            CATATAN,NOTRANSAKSI) VALUES
                                            ('$now','$iditemstock','$M_DEPARTMENTDEPARTMENTID','$stock_awal','$jml_qty','0','$stock_akhir',
                                            'BARANG MASUK','$w[NOBARANGMASUK]')
                                            ");
                // oci_execute($input);
                // oci_commit;
                $ok='StockUpdate';
            }
            else {
                $updatebarang=$mysqli->query("insert into ITEMSTOCK (ITEMSTOCK_IDITEM,ITEMSTOCK_LOTNUMBER,ITEMSTOCK_ED,ITEMSTOCK_IDSATUAN,ITEMSTOCK_IDDEPARTMENT,ITEMSTOCK_STOCK,ITEMSTOCK_USERNAME,ITEMSTOCK_LASTUPDATE)
                                    values
                                    ('$w[M_ITEMIDITEM]','$w[LOT_NUMBER]','$w[ED]','$w[M_SATUANIDSATUAN]','$M_DEPARTMENTDEPARTMENTID','$jml_qty','$username',CURRENT_TIMESTAMP)");
                // oci_execute($updatebarang);
                // oci_commit($oci);
                
                //mencari iditemstock max
                $id_max =$mysqli->query( "SELECT max(IDITEMSTOCK) AS IDITEMSTOCK FROM ITEMSTOCK");
                // oci_execute($id_max);
                $m =mysqli_fetch_array($id_max);
                $iditemstock =$m['IDITEMSTOCK'];
                
                //insert item stock history
                $input =$mysqli->query( "INSERT INTO ITEMSTOCK_HISTORY 
                                            (TANGGAL,IDITEMSTOCK,DEPARTMENTID,STOCKAWAL,STOCKIN,STOCKOUT,STOCKAKHIR,
                                            CATATAN,NOTRANSAKSI) VALUES
                                            ('$now','$iditemstock','$M_DEPARTMENTDEPARTMENTID','0','$jml_qty','0','$jml_qty',
                                            'BARANG MASUK','$w[NOBARANGMASUK]')
                                            ");
                // oci_execute($input);
                // oci_commit;
                $ok='StockInsert';
            }
        }
        else {
            $ok='Barcodesukses';
        }
    } else {
        $ok ='error';
    }
    $return['status'] = $ok;
    echo json_encode($return);
    
}
?>