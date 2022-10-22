
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
		<thead bgcolor="yellow">
			<tr>
				<th width="2%">No</th>
				<th width="10%">Kode Item</th>
				<th>Nama Item</th>
				<th width="20%">Satuan</th>
				<th width="20%">Kelompok Item</th>
				<th width="10%">Action</th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			include '../../config/connect.php';
			$no=1;
			
			$sql =$mysqli->query( "SELECT IDITEM,NAMAITEM,REPLACE(ITEM_IDSATUAN,'^',',') as IDSATUAN
										FROM M_ITEM WHERE ITEM_ISACTIVE='Y' 
										ORDER BY NAMAITEM ASC");
			// oci_execute($sql);
			while ($a =mysqli_fetch_array($sql)) {
				$satuan2 =array();
				$satuan =explode(',',$a['IDSATUAN']);
				foreach ($satuan as $nilai1) {
					array_push ($satuan2,"'". $nilai1."'");
				}
				//print_r ($satuan2);
				$arr_id = $mysqli->query( "SELECT IDITEM,NAMAITEM,NAMAKELOMPOKITEM,group_concat(NAMASATUAN) AS NAMASATUAN
											FROM M_ITEM i 
											JOIN M_KELOMPOKITEM k ON k.IDKELOMPOKITEM=i.ITEM_IDKELOMPOKITEM
											JOIN M_SATUAN s ON s.IDSATUAN IN (".join(", ",$satuan2).")
											WHERE ITEM_ISACTIVE='Y' AND IDITEM='$a[IDITEM]'
											GROUP BY IDITEM,NAMAITEM,NAMAKELOMPOKITEM
											ORDER BY NAMAITEM ASC");
				//echo $arr_id;
				// oci_execute($arr_id);
				//echo $arr_id;
				$r =mysqli_fetch_array($arr_id);
				?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $r['IDITEM'] ?></td>
					<td><?php echo $r['NAMAITEM'] ?></td>
					<td><?php echo $r['NAMASATUAN'] ?></td>
					<td><?php echo $r['NAMAKELOMPOKITEM'] ?></td>
					<td>
						<center>
							<div class="btn-group">
							<a href="#" class="btn btn-info edititem" data="<?php echo $r['IDITEM']?>" data-toggle="modal" title="Edit"><i class="fa fa-edit"></i></a>
							<a href="#" class="btn btn-danger hapusitem" data="<?php echo $r['IDITEM']?>" title="Hapus"><i class="fa fa-trash"></i></a>
							</div>
						</center>
					</td>
				</tr>
				<?php
				$satuan2='';
				$no++;
			} ?>
			
		</tbody>
	</table>

    <!-- Custom Js -->
    <script src="js/pages/tables/jquery-datatable.js"></script>