$(document).ready(
  function(){
tampil_list();

});

$(document).on('click','.hapuskulkas',function(){

    var id = $(this).attr('data');
    var checkstr =  confirm('Are you sure want to delete?');
    if(checkstr == true){
    $.ajax({
        type: "POST", 
        url : "functions/kulkas/f_kulkas.php", 
        data: "act=delete&kode_kulkas=" + id ,
        dataType: "json",     
        success: function(data){
         if(data){
	window.location.replace("index.php?page=kulkas");
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

$(document).on('click', '.tambahkulkas', function(){
  clear();
  $('#defaultModalLabel').text('Tambah Kulkas');
    $("#modalkulkas").modal('show');
  $('#modalkulkas').on('shown.bs.modal', function () {
  });
  $("#act").val('simpan');
  $('#save').text('SAVE');
});

$(document).on('click', '.editkulkas', function(){
  $('#defaultModalLabel').text('Edit Kulkas');
  id = $(this).attr('data');
    $.ajax({
        type: "POST", 
        url : "functions/kulkas/f_kulkas.php", 
                data: "act=form&kode_kulkas=" + id ,
                dataType: "json",     
              success: function(data){
          if(data){
             $('#kode_kulkas').val(data.kd_kulkas).attr('disabled','true');
	     $('#type_kulkas').val(data.id_typekulkas).change();
	     $('#id_gudang').val(data.id_gudang).change();
             $('#ip_kulkas').val(data.ip_kulkas);
             $('#act').val('update');
             $('#save').text('UPDATE');
          }
          else{
            alert("Error");
          }
        }   
      });
    $("#modalkulkas").modal('show');
});
	
function clear(){
  $('input[type=text].clearform').val('');
  $('select.clearform').val('0').change();
$('#kode_kulkas').removeAttr('disabled');
}

function tampil_list () {
	$.ajax({
		type: 'POST',
		url: "functions/kulkas/show_kulkas.php",
		data: "",
		success: function(hasil) {
			$('.restu').html(hasil);
		}
	});
}


function add_kulkas(){

  act = document.getElementById('act').value;
  kode_kulkas = document.getElementById('kode_kulkas').value;
  id_gudang = document.getElementById('id_gudang').value;
  //nama_kulkas = document.getElementById('nama_kulkas').value;
  id_typekulkas = document.getElementById('type_kulkas').value;
  ip_kulkas = document.getElementById('ip_kulkas').value;
userid = document.getElementById('username').value;
if(kode_kulkas == ''){
  alert('Kode Kulkas masih kosong');
}
else if(id_gudang == 0){
  alert('Nama Gudang masih kosong');
}
else if(id_typekulkas == 0){
  alert('Type Kulkas masih kosong');
}else if(ip_kulkas == ''){
  alert('IP Kulkas masih kosong');
}else{
    $.ajax({
    type: 'POST',
    url: "functions/kulkas/f_kulkas.php",
    //data:({act:act,kode_kulkas:kode_kulkas,nama_kulkas:nama_kulkas,id_typekulkas:id_typekulkas,ip_kulkas:ip_kulkas,userid:userid}),
	data:({act:act,kode_kulkas:kode_kulkas,id_typekulkas:id_typekulkas,ip_kulkas:ip_kulkas,id_gudang:id_gudang,userid:userid}),
    dataType:'json',
      success: function(data) {
	if(data.status == 'SUCCESS'){
	$('#modalkulkas').modal('hide');
  	document.getElementById('sukses').style.display='block';
              if(act=='simpan') {
                $('#pesan').text('Insert Success!');
		clear();
              } else {
                $('#pesan').text('Update Success!');
		clear();
              } 
	tampil_list();
        }else{
          swal({
              title: "<a style='font-size:large;'>Gagal Simpan</a>",
              text: data.status,
              confirmButtonColor: "#80C8FE",
              type: "error",
              timer: 3500,
              confirmButtonText: "Ya",
              showConfirmButton: true
            });
        }
	}
    })  
}
}


