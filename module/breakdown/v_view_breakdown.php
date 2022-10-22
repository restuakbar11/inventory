<div class="row clearfix" >
	<input type="hidden" class="form-control date" name="no_breakdown" id="no_breakdown" value="<?php echo $_GET['id']?>" readonly style="background-color:#F0FFF0;">
	<input type="hidden" id="act" name="act" value="<?php echo $_GET['act']?>">
	
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
        <div class="card">
            <div class="header">
                <h2>
                    DETAIL ITEM
                </h2>
                   
            </div>
            <div class="body">
				<div class="show_detail_item"></div>
				
				
				<a href="?page=breakdown" class="btn btn-danger waves-effect">Kembali</a>
			</div>
		</div>
	</div>
</div>


<!-- Default Size modal-->
	<div class="modal fade" id="modaldetailbarcode" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="defaultModalLabel"></h4>
				</div>
				<div class="modal-body">
					<div class="show_detail_barcode"></div>
					<div id="wait" style="display:none;width:70px;height:70px;border:0px solid black;position:absolute;top:50%;left:45%;padding:2px;">
						<img src='images/loading.gif' width="70" height="70" />
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CLOSE</button>
				</div>
			</div>
		</div>
	</div>

<!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

<script>
$(document).ready(function(){
		tampil_checkout();
		//selectGudang();
});

function tampil_checkout() {
		var no_breakdown =$('#no_breakdown').val();
		var act =$('#act').val();
		$.ajax({
				type: 'POST',
				url: "functions/breakdown/show_detail_item.php",
				data: "no_breakdown="+no_breakdown+"&act="+act,
				success: function(hasil) {
					$('.show_detail_item').html(hasil);
				}
		});
}

$(document).on('click', '.viewbarcode', function(){
		$(document).ajaxStart(function(){
			$("#wait").css("display", "block");
		});
		$(document).ajaxComplete(function(){
			$("#wait").css("display", "none");
		});
		$('#defaultModalLabel').text('Detail Barcode');
		var nobreakdown_detail = $(this).attr('data');
		$.ajax({
					type: 'POST',
					url: "functions/breakdown/show_detail_barcode.php",
					data: "nobreakdown_detail="+nobreakdown_detail,
					success: function(hasil) {
						$('.show_detail_barcode').html(hasil);
					}
			});
		$("#modaldetailbarcode").modal('show');
});
</script>

<style>
.modal-header{
    background-color: orange;
}
.modal-title{
    color: white;
}
.close{
    color: white;
}
.modal-footer{
    background-color: #A9A9A9;
}
</style>