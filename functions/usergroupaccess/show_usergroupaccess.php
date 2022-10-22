
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">No</th>
				<th>Nama</th>
				<th width="18%">Action</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			$no=1;
			$user2 =$mysqli->query( "SELECT * FROM M_USERGROUP 
										WHERE USERGROUPISACTIVE='Y'
										ORDER BY USERGROUPNAMA ASC ");
			// oci_execute($user2);
			while ($r =mysqli_fetch_array($user2)) { ?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['USERGROUPNAMA'] ?></td>
					<td>
						<center>
							<div class="btn-group">
							<a href="#" class="btn btn-info detail" data="<?php echo $r['USERGROUPID']?>" nama="<?php echo $r['USERGROUPNAMA']?>">Detail <i class="fa fa-eye"></i></a>
							</div>
						</center>
					</td>
				</tr>
				<?php
				$no++;
			} ?>
			
		</tbody>
	</table>

    <!-- Custom Js -->
    <script src="js/pages/tables/jquery-datatable.js"></script>