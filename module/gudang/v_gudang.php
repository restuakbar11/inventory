<?php
session_start ();
$username = $_SESSION['username'];
?>
<head>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/jquery/jquery.js"></script>
</head>
<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						DATA GUDANG
						<a href="index.php?page=master_data" type="button" class="btn bg-cyan waves-effect right">Back to Master Data</a>
					</h2>
				</div>
					
				<div class="body">
					
					<div class="alert alert-success alert-dismissible" id="sukses" style="width:300px; height:50px; float:right; display:none;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color:white;">&times;</button>
						<h4><i class="icon fa fa-check"></i> <label id="pesan"></label></h4>
					</div>
					
					<a href="#" class="btn btn-success tambahgudang" data-toggle="modal" ><i class="material-icons">add</i> Tambah Data</a></br></br>
					
					<div class="restu"></div>
					<div id="waiting" style="display:none;width:70px;height:70px;border:0px solid black;position:absolute;top:50%;left:45%;padding:2px;">
						<img src='images/loading.gif' width="70" height="70" />
					</div>
					
				</div>
			</div>
		</div>
	</div>
        <!-- Default Size modal-->
    <div class="modal fade" id="modalitem" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="defaultModalLabel"></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Departemen</label>
                        <div class="col-sm-8 ">
							<div class="form-line">
                            <select class="form-control gudang" name="id_department" id="id_department">
                            	<option value="0">-- PILIH DEPARTMENT --</option>
                                <?php
                            include 'functions/department/queryGetDepartment.php';
                            while ($u =mysqli_fetch_array($queryGetDepartment)) { ?>
                                <option style="align:center;" value="<?php echo $u['ID_DEPARTMENT'] ;?>" ><?php echo $u['NAMA_DEPARTMENT'] ;?></option>
                            <?php
                            } ?>
                            </select>
                            </div>
						</div></br>
						<label for="inputEmail3" class="col-sm-4 control-label">Nama Gudang</label>
						<div class="col-sm-8 ">
                        <div class="form-line">
							<input type="text" class="form-control gudang" name="namagudang" id="namagudang" >  <input type="hidden" class="form-control clearform gudang" name="act" id="act" >
                                <input class="gudang" type="hidden" name="userid" id="userid" value="<?php echo $username; ?>" >
							    <input class="gudang form-control" type="hidden" name="id_gudang" id="id_gudang" >
							
                           </div>
                        </div></br></br></br>
                        <label for="inputEmail3" class="col-sm-4 control-label">Is Kulkas</label>
                        <div class="col-sm-8 ">
							
                        <input type="checkbox" id="basic_checkbox_2" class="filled-in" id="iskulkas" name="iskulkas" value="Y" />
                                <label for="basic_checkbox_2">*) CheckList Jika Tergolong Kulkas</label>
                           
						</div></br></br>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary waves-effect" id="save" ></button>
					<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CLOSE</button>
				</div>
			</div>
		</div>
	</div>


<script src="module/gudang/j_gudang.js"></script>
