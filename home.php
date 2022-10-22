<?php
include 'config/connect.php';
session_start();


?>
<div class="container-fluid">


            <div class="row clearfix">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="card">
                        <div class="header" style="background-color: red;">
                            <h2 style="color: white">
                                <center>Barang ED</center>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th width="20%">Tanggal ED</th>
                                            <th>Nama Item</th>
                                            <th>Lot Number</th>
                                            <th>Satuan</th>
                                            <th>Department</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $dateNow = date("Y-m-d");
                                $sed = $mysqli->query( "SELECT a.ITEMSTOCK_ED, b.NAMAITEM, c.NAMASATUAN, a.ITEMSTOCK_LOTNUMBER, d.NAMA_DEPARTMENT FROM ITEMSTOCK a
                                    inner join M_ITEM b on a.ITEMSTOCK_IDITEM=b.IDITEM
                                    Inner join M_SATUAN c on a.ITEMSTOCK_IDSATUAN=c.IDSATUAN
                                    Inner join M_DEPARTMENT d on a.ITEMSTOCK_IDDEPARTMENT = d.ID_DEPARTMENT
                                    WHERE a.ITEMSTOCK_ED <= '$dateNow' AND a.ITEMSTOCK_ED != '0000-00-00'
                                    order by a.ITEMSTOCK_ED asc");
                                while($n =mysqli_fetch_array($sed)) { ?>
                                    <tr>
                                        <td><?php echo $n['ITEMSTOCK_ED'] ?></td>
                                        <td><?php echo $n['NAMAITEM'] ?></td>
                                        <td><?php echo $n['ITEMSTOCK_LOTNUMBER'] ?></td>
                                        <td><?php echo $n['NAMASATUAN'] ?></td>
                                        <td><?php echo $n['NAMA_DEPARTMENT'] ?></td>

                                    </tr>
                                <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="card">
                        <div class="header" style="background-color: yellow;">
                            <h2>
                                <center>Barang sebulan sebelum ED</center>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th width="20%">Tanggal ED</th>
                                            <th>Nama Item</th>
                                            <th>Lot Number</th>
                                            <th>Satuan</th>
                                            <th>Department</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                $sed = $mysqli->query( "SELECT a.ITEMSTOCK_ED, b.NAMAITEM, c.NAMASATUAN, a.ITEMSTOCK_LOTNUMBER, d.NAMA_DEPARTMENT FROM ITEMSTOCK a
                                    inner join M_ITEM b on a.ITEMSTOCK_IDITEM=b.IDITEM
                                    Inner join M_SATUAN c on a.ITEMSTOCK_IDSATUAN=c.IDSATUAN
                                    Inner join M_DEPARTMENT d on a.ITEMSTOCK_IDDEPARTMENT = d.ID_DEPARTMENT
                                    WHERE datediff(a.ITEMSTOCK_ED, now()) <= 30 and datediff(a.ITEMSTOCK_ED, now()) >= 0
                                    order by a.ITEMSTOCK_ED asc");
                                while($n =mysqli_fetch_array($sed)) { ?>
                                    <tr>
                                        <td><?php echo $n['ITEMSTOCK_ED'] ?></td>
                                        <td><?php echo $n['NAMAITEM'] ?></td>
                                        <td><?php echo $n['ITEMSTOCK_LOTNUMBER'] ?></td>
                                        <td><?php echo $n['NAMASATUAN'] ?></td>
                                        <td><?php echo $n['NAMA_DEPARTMENT'] ?></td>

                                    </tr>
                                <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
</div>

