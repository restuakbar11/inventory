<?php 
$refgr_id = urldecode($_GET['rid']);
//echo $refgr_id;
$now=date('Y-m-d');

$query1 = "SELECT * FROM (select k.kode_kulkas, k.nama_kulkas,gu.NAMAGUDANG, t.image_url,t.nama_typekulkas, k.ip_kulkas,s.nama_subdepartment, d.nama_department,r.nama_ruangan,r.lantai, g.nama_gedung,
l.cold_room,l.min_temp,l.max_temp
from m_kulkas k
left join m_gudang gu ON gu.id_gudang = k.id_gudang
left join m_typekulkas t on t.id_typekulkas = k.id_typekulkas
left join m_subdepartmentkulkas sk on sk.kode_kulkas=k.kode_kulkas
left join m_subdepartment s on s.id_subdepartment = sk.id_subdepartment
left join m_department d on d.id_department = s.id_department
left join m_ruangan r on r.id_ruangan=s.id_ruangan
left join m_gedung g on g.id_gedung = r.id_gedung
left join kulkas_data_log l on l.kode_kulkas = k.kode_kulkas
WHERE k.kode_kulkas = '$refgr_id') where rownum = 1 ";												


/*detail refri */
$load = $mysqli->query( $query1);
// oci_execute($load);
$r = mysqli_fetch_array($load);
?>
<head>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/jquery/jquery.js"></script>
</head>
        <div class="container-fluid">
			<div class="block-header">
                <h2>DETAIL DEVICE LOG
                 <a href="index.php?page=ref_detail&rid=<?php echo $refgr_id ?>" type="button" class="btn bg-cyan waves-effect right">Back to Refrigerator Map</a></h2>
            </div>
        </br>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                              Log Data
                            </h2>
                            
							<h4>
							<?php echo $r['NAMAGUDANG']; ?><br>
							</h4>
							<?php echo $r['NAMA_RUANGAN']; ?> <br>
							<small><?php echo $r['NAMA_GEDUNG']. ' Lantai '.$r['LANTAI']; ?></small>
                        </div>
                        <div class="body">
                            <div class="restu">                                
                            </div>
                        </div>
						
						<div class="body">
							<div class="flot">                                
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
  $('.restu').load("functions/refrigerator/show_log.php?rid="+refgr_id+"&date="+now);
  $('.flot').load("functions/refrigerator/show_log_flot.php?rid="+refgr_id+"&date="+now);
  //log.console(refgr_id);
});
</script>
