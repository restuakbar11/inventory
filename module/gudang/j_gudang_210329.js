$(document).ready(
  function(){
   
tampil_list();
    $(".tambahgudang").click(function(){
      clear ();
      $('#defaultModalLabel').text('Tambah Gudang');
        $("#modalitem").modal('show');
      
      $("#act").val('add');
      $('#save').text('SAVE');
    });

});

function tampil_list () {
      
  $('.restu').load("functions/gudang/show_gudang.php");
    } 
$("#save").click(function(){
  var item = {};
  $(".gudang").each(function(k,v){
      item[$(this).attr('name')] = $(this).is(':checkbox:checked') == true ? 'Y': $(this).val();
  });
 
});

$(document).on('click','.hapusgudang',function(){

    var id = $(this).attr('data');
    var checkstr =  confirm('Are you sure want to delete?');
    if(checkstr == true){
    $.ajax({
        type: "POST", 
        url : "functions/gudang/f_gudang.php", 
        data: "act=delete&id_gudang=" + id ,
        dataType: "json",     
        success: function(data){
         if(data.status=='SUCCESS'){
          Swal.fire({
            title: 'Berhasil Terhapus..!!',
            text: "Akan Menutup Dalam 2 Detik!!!",
            confirmButtonColor: "#80C8FE",
            type: "success",
            timer: 3500,
            confirmButtonText: "Ya",
            showConfirmButton: true
          });
          tampil_list();
          // $('.tampildata2').load("modul/mod_ord_regular/tampil_bhp.php?notrans="+notrans);
        }else{
          Swal.fire({
            title: 'GAGAL MENGHAPUS..!!',
            text: "Akan Menutup Dalam 2 Detik!!!",
            confirmButtonColor: "#80C8FE",
            type: "success",
            timer: 3500,
            confirmButtonText: "Ya",
            showConfirmButton: true
          });
        }
        }   
    });
    } else{
    return false;
    }
});
$(document).on('click', '.editgudang', function(){
	$('#defaultModalLabel').text('Edit Gudang');
	var id_gudang = $(this).attr('data');
    $.ajax({
				type: "POST", 
				url : "functions/gudang/f_gudang.php", 
                data: "act=form&id_gudang=" + id_gudang ,
                dataType: "json",			
            	success: function(data){
					if(data){
					//	$('#iditem').val(data.IDITEM).attr('disabled','true');
						$('#id_gudang').val(data.ID_GUDANG);
						$('#namagudang').val(data.NAMAGUDANG);
						$('select[name=id_department]').val(data.ID_DEPARTMENT).change().attr('disabled','true');
            if(data.ISKULKAS=='Y'){
              console.log('ss')
              $(':checkbox').prop('checked','true');
            }
            else if(data.ISKULKAS=='N'){
              console.log('yy')
              $(':checkbox').removeAttr('checked');
            }
						
						$('#act').val('update');
						$('#save').text('UPDATE');
					}
					else{
						alert("Error");
					}
				}		
			});
    $("#modalitem").modal('show');
});
function clear(){
  $(':checkbox').removeAttr('checked');
  $('select').change().removeAttr('disabled');
  $('input[type=text].form-control').val('');
  $('input[id=id_gudang].form-control').val('');
  $('input[type="password"].form-control').val('');
}

function add_gudang(){
id_department = document.getElementById('id_department').value;
namagudang= document.getElementById('namagudang').value;
act = document.getElementById('act').value;
if(id_department == 0){
 alert('Department masih kosong');
}else if(namagudang == ''){
 alert('Nama Gudang masih kosong');
}else{
  var item = {};
  $(".gudang").each(function(k,v){
      item[$(this).attr('name')] = $(this).is(':checkbox:checked') == true ? 'Y': $(this).val();
  });

   $.ajax({
      type: "POST", 
      url : "functions/gudang/f_gudang.php", 
              data: {item:item},
              dataType: "json",			
            success: function(data){
        if(data){
          if(data.status=='FAILED') {
            Swal.fire({
              title: 'GAGAL',
              text: data.status,
              type: 'warning',
              confirmButtonColor: "red",
              showCancelButton: false,
              allowOutsideClick: false,
              position: 'top'
            })
            $('#modalitem').modal('hide');
          } else {
            $('#modalitem').modal('hide');
            tampil_list();
            document.getElementById('sukses').style.display='block';
            if(act=='add') {
              $('#pesan').text('Insert Success!');
            } else {
              $('#pesan').text('Update Success!');
            }
          } 
        }
        else{
          alert("Error..");
        }
      }		
  });
}

}
