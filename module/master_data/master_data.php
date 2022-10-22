<?php
include 'config/connect.php';
session_start();
$menuGroup = $_SESSION['grupMasterID'];


?>
        <div class="container-fluid">


            <div class="row clearfix">
            	 <?php
                    $master =$mysqli->query( "SELECT ms.MASTERNAME from M_USERMASTERACCES  ua
                        join M_MASTER ms on ua.master_id=ms.master_id
                        where mastergroup_id = '$menuGroup' and ua.master_id=1
                        group by MASTERNAME");
                    // oci_execute($master);
                    $m =mysqli_fetch_array($master);
                    $menu = $m['MASTERNAME'];
					
                ?>
                <?php if ($menu != ''){
					?>
                	                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <div class="card">
                        <div class="header" style="background-color: #1f91f3">
                            <h2 style="color: white">
                               <center><?php echo $menu; ?></center>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                            <?php
                                $master =$mysqli->query( "SELECT ms.* from M_USERMASTERACCES  ua
                                    join M_MASTERSUB ms on ua.mastersub_id=ms.mastersub_id
                                    where mastergroup_id = $menuGroup and ua.master_id=1
									ORDER BY MASTERSUB_URUT ASC");
                                // oci_execute($master);
                                while($m =mysqli_fetch_array($master)) {
                                    echo '<center><a href="'.$m['MASTERSUB_LINK'].'" style="background-color: #FFC107" class="btn btn-block btn-lg waves-effect"><h4>'.$m['MASTERSUB_NAME'].'</h4></a></center></br>';
                                }
							
                            ?>
                           
                            </br>
							<center>
								<a href="#" style="background-color: #FFDEAD " class=" demo-3">
									<span data-text="Gedung > Ruangan > 
											Gudang > Kulkas > 
											Sub Departemen > Sub Dept Kulkas">
										<h4><i class="fa fa-info-circle"></i> Alur Pengisian </h4></span></a>
							</center>
<!--
                            <center><a href="index.php?page=rakKulkas" style="background-color: #FFC107" class="btn btn-block btn-lg waves-effect right" type="button"><h4>Rak Kulkas</h4></a></center>
-->
                            </div>
                        </div>
                    </div>
                </div>
               <?php }else{}?>


               <?php
                    $master2 =$mysqli->query( "SELECT ms.MASTERNAME from M_USERMASTERACCES  ua
                        join M_MASTER ms on ua.master_id=ms.master_id
                        where mastergroup_id = '$menuGroup' and ua.master_id=2
                        group by MASTERNAME");
                    // oci_execute($master2);
                    $m =mysqli_fetch_array($master2);
                    $menu2 = $m['MASTERNAME'];
                ?>
                <?php if($menu2 != ''){?>
                	 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <div class="card">
                        <div class="header" style="background-color: #1f91f3">
                            <h2 style="color: white">
                            
                                <center><?php echo $menu2; ?></center>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">  <!-- amber -->
                            <?php
                                $master2a =$mysqli->query( "SELECT ms.* from M_USERMASTERACCES  ua
                                    join M_MASTERSUB ms on ua.mastersub_id=ms.mastersub_id
                                    where mastergroup_id = $menuGroup and ua.master_id=2
									ORDER BY MASTERSUB_URUT ASC");
                                // oci_execute($master2a);
                                while($m =mysqli_fetch_array($master2a)) {
                                    echo '<center><a href="'.$m['MASTERSUB_LINK'].'" style="background-color: #FFC107" class="btn btn-block btn-lg waves-effect"><h4>'.$m['MASTERSUB_NAME'].'</h4></a></center></br>';
                                }
                            ?>
							
							</br>
							<center>
								<a href="#" style="background-color: #FFDEAD " class=" demo-3">
									<span data-text="Grup Pengguna > Pengguna > 
											Akses Grup Pengguna">
										<h4><i class="fa fa-info-circle"></i> Alur Pengisian </h4></span></a>
							</center>
							
                            </div>
                        </div>
                    </div>
                </div>
                <?php }else{} ?>
               

                <?php
	                $master3 =$mysqli->query( "SELECT ms.MASTERNAME from M_USERMASTERACCES  ua
	                    join M_MASTER ms on ua.master_id=ms.master_id
	                    where mastergroup_id = '$menuGroup' and ua.master_id=3
	                    group by MASTERNAME");
	                // oci_execute($master3);
	                $m =mysqli_fetch_array($master3);
	                $menu3 = $m['MASTERNAME'];
            	?>
            	<?php if ($menu3 != '') {?>
            		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <div class="card">
                        <div class="header" style="background-color: #1f91f3">
                            <h2 style="color: white">
                                
                                <center><?php echo $menu3; ?></center>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                            <?php
                                $master3a =$mysqli->query( "SELECT ms.* from M_USERMASTERACCES  ua
                                    join M_MASTERSUB ms on ua.mastersub_id=ms.mastersub_id
                                    where mastergroup_id = $menuGroup and ua.master_id=3
									ORDER BY MASTERSUB_URUT ASC");
                                // oci_execute($master3a);
                                while($m =mysqli_fetch_array($master3a)) {
                                    echo '<center><a href="'.$m['MASTERSUB_LINK'].'" style="background-color: #FFC107" class="btn btn-block btn-lg waves-effect"><h4>'.$m['MASTERSUB_NAME'].'</h4></a></center></br>';
                                }
                            ?>
							
							</br>
							<center>
								<a href="#" style="background-color: #FFDEAD " class=" demo-3">
									<span data-text="Departemen > Ruangan > 
													Sub Departemen > Gudang > Rak Gudang">
										<h4><i class="fa fa-info-circle"></i> Alur Pengisian </h4></span></a>
							</center>
							
                           </div>
                        </div>
                    </div>
                </div>
            	<?php }else{} ?>
                

            	<?php
                    $master4 =$mysqli->query( "SELECT ms.MASTERNAME from M_USERMASTERACCES  ua
                        join M_MASTER ms on ua.master_id=ms.master_id
                        where mastergroup_id = '$menuGroup' and ua.master_id=4
                        group by MASTERNAME");
                    // oci_execute($master4);
                    $m =mysqli_fetch_array($master4);
                    $menu4 = $m['MASTERNAME'];
            	?>
            	<?php if ($menu4 != '') { ?>
            		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <div class="card">
                        <div class="header" style="background-color: #1f91f3">
                            <h2 style="color: white">
                                
                                <center><?php echo $menu4; ?></center>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">  <!-- amber -->
                            <?php
                                $master4a=$mysqli->query( "SELECT ms.* from M_USERMASTERACCES  ua
                                    join M_MASTERSUB ms on ua.mastersub_id=ms.mastersub_id
                                    where mastergroup_id = $menuGroup and ua.master_id=4
									ORDER BY MASTERSUB_URUT ASC");
                                // oci_execute($master4a);
                                while($m =mysqli_fetch_array($master4a)) {
                                    echo '<center><a href="'.$m['MASTERSUB_LINK'].'" style="background-color: #FFC107" class="btn btn-block btn-lg waves-effect"><h4>'.$m['MASTERSUB_NAME'].'</h4></a></center></br>';
                                }
                            ?>
							
							</br>
							<center>
								<a href="#" style="background-color: #FFDEAD " class=" demo-3">
									<span data-text="Suplier > Satuan > 
													Kelompok Item > Item > Item Suplier">
										<h4><i class="fa fa-info-circle"></i> Alur Pengisian </h4></span></a>
							</center>
							
                            </div>
                        </div>
                    </div>
                </div>
            	<?php }else{} ?>
				
            </div>
        </div>

<!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>
<script src="module/rak_kulkas/j_rakKulkas.js"></script>

<style>
.demo-3 {
  //color: #fff;
  display: inline-block;
  text-decoration: none;
  overflow: hidden;
  vertical-align: top;
   background: #FFDEAD;
   width : 100%;
   min-height : 75px;
  -webkit-perspective: 600px;
  -moz-perspective: 600px;
  -ms-perspective: 600px;
  perspective: 600px;
  -webkit-perspective-origin: 50% 50%;
  -moz-perspective-origin: 50% 50%;
  -ms-perspective-origin: 50% 50%;
  perspective-origin: 50% 50%;
}
 .demo-3:hover span {
  background: #FFDEAD;
  -webkit-transform: translate3d(0px, 0px, -30px) rotateX(90deg);
  -moz-transform: translate3d(0px, 0px, -30px) rotateX(90deg);
  -ms-transform: translate3d(0px, 0px, -30px) rotateX(90deg);
  transform: translate3d(0px, 0px, -30px) rotateX(90deg);
}
  .demo-3 span {
  display: block;
  position: relative;
  padding: 10px 20px;
  -webkit-transition: all 0.3s ease;
  -moz-transition: all 0.3s ease;
  -ms-transition: all 0.3s ease;
  transition: all 0.3s ease;
  -webkit-transform-origin: 50% 0%;
  -moz-transform-origin: 50% 0%;
  -ms-transform-origin: 50% 0%;
  transform-origin: 50% 0%;
  -webkit-transform-style: preserve-3d;
  -moz-transform-style: preserve-3d;
  -ms-transform-style: preserve-3d;
  transform-style: preserve-3d;
}
 
 .demo-3 span:after {
  content: attr(data-text);
  align:center;
  min-height : 76px;
  -webkit-font-smoothing: antialiased;
  padding: 10px 10px;
  color: #fff;
  background: #F08080;
  display: block;
  position: absolute;
 
  left: 0;
  top: 0;
  -webkit-transform-origin: 50% 0%;
  -moz-transform-origin: 50% 0%;
  -ms-transform-origin: 50% 0%;
  transform-origin: 50% 0%;
  -webkit-transform: translate3d(0px, 105%, 0px) rotateX(-90deg);
  -moz-transform: translate3d(0px, 105%, 0px) rotateX(-90deg);
  -ms-transform: translate3d(0px, 105%, 0px) rotateX(-90deg);
  transform: translate3d(0px, 105%, 0px) rotateX(-90deg);
}
</style>