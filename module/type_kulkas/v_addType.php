<div class="row clearfix">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="card">
            <div class="header">
                <h2>
                    INPUT MASTER TYPE KULKAS
                </h2>
                   
            </div>
            <div class="body">
                <form method="POST">
                   <div class="form-group form-float">
                        <div class="form-line">
                           <input type="text" class="form-control" name="nama_kulkas" id="nama_kulkas" maxlength="10" minlength="3">
                           <label class="form-label">Nama Kulkas</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                        <input type="text" class="form-control" name="type_kulkas" id="type_kulkas" min="10"  >
                            <label class="form-label">Type Kulkas</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="file" class="form-control" name="fileupload" id="fileupload" >
                        </div>
                    </div>
                        
                    <button class="btn btn-primary waves-effect" type="button" onclick="javascript:add_type();">SUBMIT</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="module/type_kulkas/j_addType.js"></script>
