$(document).ready(
  function(){
tampil_list();


});

$("#gedung").change(function(){ 
   b = $("#gedung").val();

  $.ajax({
      type: "POST", 
      url: "functions/lantai/queryLantai.php", 
      data: "idgedung="+b,
      success: function(result) { 
       $('.queryLantai').html(result);
        }  

    });
});

$(".tambahruangan").click(function(){
  clear ();
  $('#defaultModalLabel').text('Tambah Ruangan');
    $("#modalruangan").modal('show');
  $('#modalruangan').on('shown.bs.modal', function () {
  });
  $("#act").val('simpan');
  $('#save').text('SAVE');
});

$(document).on('click','.hapusruangan',function(){

    var id = $(this).attr('data');
    var checkstr =  confirm('Are you sure want to delete?');
    if(checkstr == true){ 
    $.ajax({
        type: "POST", 
        url : "functions/ruangan/f_ruangan.php", 
        data: "act=delete&id_ruangan=" + id ,
        dataType: "json",     
        success: function(data){
         if(data){
          window.location.replace("index.php?page=ruangan");
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

$(document).on('click', '.editruangan', function(){
  $('#defaultModalLabel').text('Edit Ruangan');
  id = $(this).attr('data');
    $.ajax({
        type: "POST", 
        url : "functions/ruangan/f_ruangan.php", 
        data: "act=form&id_ruangan=" + id ,
        dataType: "json",     
        success: function(data){
          if(data){          
	     $('#gedung').val(data.id_gedung).change();
             $('#nama_ruangan').val(data.nm_ruangan);
	     $('#id_ruangan').val(id);
	     $('#lantai').val(data.lantai);
             $('#act').val('update');
             $('#save').text('UPDATE');
          }
          else{
            alert("Error");
          }
        }   
      });
    $("#modalruangan").modal('show');
});

function tampil_list () {
	$.ajax({
		type: 'POST',
		url: "functions/ruangan/show_ruangan.php",
		data: "",
		success: function(hasil) {
		$('.restu').html(hasil);
		}
	});
}

function clear(){
  $('input[type=text].form-control').val('');
  $('select.clearform').val('0').change();
  $('input[type=number].clearform').val('0');
}

function add_ruangan(){
  act = document.getElementById('act').value;
id_ruangan = document.getElementById('id_ruangan').value;
  gedung = document.getElementById('gedung').value;
  nama_ruangan = document.getElementById('nama_ruangan').value;
  lantai = document.getElementById('lantai').value;
  userid = document.getElementById('username').value;
  if(gedung == ''){
    alert('Kode Gedung masih kosong');
  }else if(nama_ruangan == ''){
    alert('Nama Gedung masih kosong');
  }else if(lantai == ''){
    alert('Lantai masih kosong');
  }else{
    $.ajax({
    type: 'POST',
    url: "functions/ruangan/f_ruangan.php",
    data:({act:act,id_ruangan:id_ruangan,gedung:gedung,nama_ruangan:nama_ruangan,lantai:lantai,userid:userid}),
    dataType:'json',
      success: function(data) {
	if(data.status == 'SUCCESS'){
	$("#modalruangan").modal('hide');
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
            Swal.fire({
              title: 'WARNING',
              text: data.status,
              type: 'warning',
              confirmButtonColor: "red",
              showCancelButton: false,
              allowOutsideClick: false,
              position: 'top'
            })
        }
      }
    }) 
  }
}
