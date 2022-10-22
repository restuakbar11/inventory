
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th width="1%">No</th>
				<th>Menu Header</th>
				<th width="40%">Nama Menu</th>
				<th width="10%">Action</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			$no=1;
			$user2 =$mysqli->query( "SELECT MENUSUBID,MENUSUBNAMA,MENUNAMA
									FROM M_MENUSUB s
									JOIN M_MENU m ON m.MENUID=s.MENUID
									WHERE MENUSUBID NOT IN (SELECT MENUSUBID FROM M_USERGROUPACCESS WHERE USERGROUPID='$_POST[id]' )
									ORDER BY MENUURUT,MENUSUBURUT ASC ");
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) { ?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['MENUNAMA'] ?></td>
					<td><?php echo $r['MENUSUBNAMA'] ?></td>
					<td>
						<center>
							<div class="btn-group">
							<a href="#" class="btn btn-success tambah" data="<?php echo $r['MENUSUBID']?>" title="Detail">Tambah <i class="fa fa-plus"></i></a>
							</div>
						</center>
					</td>
				</tr>
				<?php
				$no++;
			} ?>
			
		</tbody>
	</table>
