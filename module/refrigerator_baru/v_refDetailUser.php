<?php 
$refgr_id = $_GET['rid'];
//echo $refgr_id;
$now=date('Y-m-d');
?>
<head>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/jquery/jquery.js"></script>
</head>
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" >
                        <a href="index.php?page=ref_detail&rid=<?php echo $refgr_id ?>" type="button" class="btn bg-cyan waves-effect right">Back to Refrigerator</a>
                    </div>
                </div>
                
            </div>
        </br>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                              Log Data
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="restu">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<script>
$(document).ready(
  function(){
  refgr_id = "<?php echo $refgr_id; ?>";
  now = "<?php echo $now; ?>";
  $('.restu').load("functions/refrigerator/show_log_user.php?rid="+refgr_id);
  //log.console(refgr_id);
});
</script>
