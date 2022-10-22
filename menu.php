<?php 
$grup =$arr['USERGROUPID'];
?>

	<ul class="list">
		<li class="header">MAIN NAVIGATION</li>
		<li class="">
			<a href="index.php" class="hovermenu">
				<i class="material-icons">home</i>
				<span>Home</span>
			</a>
		</li>
		<?php 
		$menu =$mysqli->query( "SELECT m.MENUID,m.MENUNAMA,m.MENUICON,m.MENULINK,m.MENUURUT,CASE 
								WHEN m.MENULINK IS NULL THEN '0'
								WHEN m.MENULINK='' THEN '0'
								ELSE '1'
								END AS STATUS
									FROM M_MENU m
									JOIN M_MENUSUB s ON s.MENUID=m.MENUID
									JOIN M_USERGROUPACCESS a ON a.MENUSUBID=s.MENUSUBID
									WHERE a.USERGROUPID='$grup'
									GROUP BY m.MENUID,m.MENUNAMA,m.MENUICON,m.MENULINK,m.MENUURUT
									ORDER BY MENUURUT ASC");
		
		while($m =mysqli_fetch_array($menu)) {
			$menuID =$m['MENUID']; ?>
			<li>
				<?php
				if($m['STATUS']==1) { ?>
					<a href="<?php echo $m['MENULINK']?>" class="hovermenu">
						<i class="material-icons"><?php echo $m['MENUICON']?></i>
							<span><?php echo $m['MENUNAMA']?></span>
					</a>
					<?php
				} else { ?>
					<a href="javascript:void(0);" class="menu-toggle hovermenu">
						<i class="material-icons"><?php echo $m['MENUICON']?></i>
						<span><?php echo $m['MENUNAMA']?></span>
					</a>
					<ul class="ml-menu">
						<?php 
						$menusub =$mysqli->query( "SELECT *
														FROM M_MENUSUB s
														JOIN M_USERGROUPACCESS a ON a.MENUSUBID=s.MENUSUBID
														WHERE s.MENUID='$menuID' AND a.USERGROUPID='$grup'
														ORDER BY s.MENUSUBURUT ASC");
						
						while($ms =mysqli_fetch_array($menusub)) { ?>
							<li>
								<a href="<?php echo $ms['MENUSUBLINK']?>"  class="hovermenu">
									<i class="material-icons " ><?php echo $ms['MENUSUBICON']?></i> 
									<span><?php echo $ms['MENUSUBNAMA']?></span>
								</a>
							</li>
							<?php
						} ?>
					
					</ul>
					<?php 
				} ?>
			</li>
			<?php 
		} ?>
		
	</ul>






<!--<ul class="list">
     <li class="header">MAIN NAVIGATION</li>
        <li class="">
            <a href="index.php" class="hovermenu">
                <i class="material-icons">home</i>
                    <span>Home</span>
            </a>
        </li>
        <li>
            <a href="index.php?page=master_data" class="hovermenu">
                <i class="material-icons">widgets</i>
                    <span>Master Data</span>
            </a>
			<a href="index.php?page=refrigerator" class="hovermenu">
                <i class="material-icons">view_list</i>
                    <span>Refrigerator Map</span>
            </a>
            <a href="javascript:void(0);" class="menu-toggle hovermenu">
                <i class="material-icons">view_list</i>
                <span>Transaksi</span>
            </a>
            <ul class="ml-menu">
                <li>
                    <a href="index.php?page=brg_masuk" class="hovermenu">Barang Masuk</a>
                </li>
                <li>
                    <a href="index.php?page=checkin_brg" class="hovermenu">Check In Barang</a>
                </li>
                <li>
                    <a href="index.php?page=tag" class="hovermenu">TAG</a>
                </li>
				<li>
                    <a href="index.php?page=penerimaan_tag" class="hovermenu">Penerimaan TAG</a>
                </li>
                <li>
                    <a href="index.php?page=brg_keluar" class="hovermenu">Barang Keluar</a>
                </li>
            </ul>
        </li>                    
</ul>-->


<style>
	.hovermenu:hover {
		background-color: #E6E6FA;
	}
</style>