<head>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/jquery/jquery.js"></script>
	<style>
	 .restu{
		padding-top: 20px;
	 }
	</style>
</head>
        <div class="container-fluid">
            

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                              MASTER GEDUNG
							  <a href="index.php?page=master_data" type="button" class="btn bg-cyan waves-effect right">Back to Master Data</a>
                            </h2>
                            </div>
                        <div class="body">
						<a href="#" class="btn btn-success tambahgedung"><i class="material-icons">add</i>  Tambah Data</a>
                            <div class="restu"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modalgedung" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel"></h4>
                    <div class="alert alert-success alert-dismissible" id="sukses" style="width:300px; height:50px; float:right; display:none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color:white;">&times;</button>
                        <h4><i class="icon fa fa-check"></i> <label id="pesan"></label></h4>
                </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Nama Gedung*</label>
                        <div class="col-sm-8 ">
                            <div class="form-line">
                                <input type="text" class="form-control" name="nama_gedung" id="nama_gedung" >
                                <input type="hidden" class="form-control" name="id_gedung" id="id_gedung" >
                            </div>
                        </div></br>
                        <label for="inputEmail3" class="col-sm-4 control-label">Jumlah Lantai*</label>
                        <div class="col-sm-8 ">
                            <div class="form-line">
                                <input type="number" class="form-control clearform" name="jumlah_lantai" id="jumlah_lantai" maxlength="2" placeholder="Jumlah Lantai">
                                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>" >
                                <input type="hidden" name="act" id="act">
                            </div>
                        </div></br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary waves-effect" type="button" id="save" onclick="javascript:add_gedung();"></button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

<script src="module/gedung/j_gedung.js"></script>
