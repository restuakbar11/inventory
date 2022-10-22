<?php
session_start ();
$username = $_SESSION['username'];
?>
<head>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/jquery/jquery.js"></script>
</head>
<div class="row clearfix">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="card">
            <div class="header">
                <h2>
                    INPUT BARANG MASUK
                </h2>
                   
            </div>
            <div class="body" class="ui-widget">
                <form method="POST" >
                    <div class="form-group form-float">
                            <div class="form-line">
                               <input type="text" class="form-control" name="brg_masuk" id="brg_masuk">
                               <input type="hidden" name="act" id="act">
                               <input type="hidden" name="userid" id="userid" value="<?php echo $username ?>">
                               <label class="form-label">No. Surat Jalan</label>
                        </div>
                       <!--  <div class="help-info">Ex: A0001</div> -->
                    </div>

                    <div class="form-group form-float">
                            <div class="form-line" id="bs_datepicker_container">
                                <input type="text" data-date-format="yyyy-mm-dd" class="form-control" name="tgl_masuk" id="tgl_masuk" value="<?php echo date('Y-m-d');?>" >
                                <input type="hidden" name="department" id="department" value="4">
                            </div>
                    </div>
                    
                    <div class="form-group form-float">
                        <div class="form-line">
                             <select class="form-control" name="supplier" id="supplier">
                                <option value="0">-- PILIH SUPPLIER --</option>
                                <?php
                            include 'functions/itemsupplier/querySupplier.php';
                            while ($u =mysqli_fetch_array($querySupplier)) { ?>
                                <option style="align:center;" value="<?php echo $u['IDSUPPLIER']?>-<?php echo $u['ADDRESSSUPPLIER']?>"><?php echo $u['NAMASUPPLIER']?></option>
                            <?php
                            } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" name="alamat" id="alamat" disabled>
                                <input type="hidden" name="id_supplier" id="id_supplier" disabled>
                                <input type="hidden" name="flag" id="flag" value="HEADER">
                            </div>
                    </div>
                    
                     <div class="form-group form-float">
                            <div class="form-line">
                                <textarea rows="4" class="form-control no-resize" placeholder="Please type what you want..." id="catatan" name="catatan"></textarea>
                            </div>
                    </div>
                        
                    <button class="btn btn-primary waves-effect" id="smpn_header" type="button" onclick="javascript:simpan_header();">NEXT<i class="material-icons">forward</i></button> 
                </form></br>
            </div>
        </div>
    </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" id="addItem">
        <div class="card">
            <div class="header">
                <h2>
                    INPUT ITEM DISINI
                </h2>
                   
            </div>
            <div class="body">
                <form method="POST">

                    <div class="form-group form-float">
                            <div class="form-line">
                                <select class="form-control" name="item" id="item" data-live-search="on">
                                    <option value="0">-- PILIH ITEM --</option>
                                    <?php
                                include 'functions/itemsupplier/queryItem.php';
                                while ($u =mysqli_fetch_array($queryItem)) { ?>
                                    <option style="align:center;" value="<?php echo $u['IDITEM']?>/<?php echo$u['ITEM_IDSATUAN'] ?>"><?php echo $u['NAMAITEM']?></option>
                                <?php
                                } ?>
                                </select>
                            </div>
                    </div>
                    <div class="form-group form-float">
                            <div class="form-line" id="bs_datepicker_container">
                                <input type="text" data-date-format="yyyy-mm-dd" class="form-control" name="ed" id="ed" value="<?php echo date('Y-m-d');?>" >
                                <label>Expire Date</label>
                            </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="hidden" class="form-control" name="id_item" id="id_item">
                            <input type="hidden" class="form-control" name="id_satuan" id="id_satuan">
                               <input type="number" class="form-control" name="qty" id="qty">
                               <label>Quantity</label>
                        </div>
                    </div> 
                    <div class="form-group form-float">
                        <div class="form-line">
                               <input type="text" class="form-control" name="lot" id="lot">
                               <label class="form-label">Lot Number</label>
                        </div>
                    </div> 
                    <button class="btn btn-primary waves-effect" id="smpn_header" type="button" onclick="javascript:simpan_detail();">Add Item<i class="material-icons">forward</i></button>                     
                </form>
                 <div class="detail_tabel"></div>
                           
            </div>
        </div>
    </div>
</div>
<script src="module/barang_masuk/j_brg_masuk.js"></script>
