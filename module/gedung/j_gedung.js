$(document).ready(
  function(){
tampil_list();
});

$(".tambahgedung").click(function(){
  clear ();
  $('#defaultModalLabel').text('Tambah Gedung');
    $("#modalgedung").modal('show');
  $('#modaldepartment').on('shown.bs.modal', function () {
  });
  $("#act").val('simpan');
  $('#save').text('SAVE');
});

$(document).on('click','.hapusgedung',function(){

    var id = $(this).attr('data');
    var checkstr =  confirm('Are you sure want to delete?');
    if(checkstr == true){
    $.ajax({
        type: "POST", 
        url : "functions/gedung/f_gedung.php", 
        data: "act=delete&id_gedung=" + id ,
        dataType: "json",     
        success: function(data){
         if(data){
         window.location.replace("index.php?page=gedung");
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

$(document).on('click', '.editgedung', function(){
  $('#defaultModalLabel').text('Edit Gedung');
  id = $(this).attr('data');
    $.ajax({
        type: "POST", 
        url : "functions/gedung/f_gedung.php", 
        data: "act=form&id_gedung=" + id ,
        dataType: "json",     
        success: function(data){
          if(data){        
	     $('#nama_gedung').val(data.nm_gedung).change();
             $('#jumlah_lantai').val(data.jml_lantai);
	     $('#id_gedung').val(id);
             $('#act').val('update');
             $('#save').text('UPDATE');
          }
          else{
            alert("Error");
          }
        }   
      });
    $("#modalgedung").modal('show');
});

function tampil_list () {
	$.ajax({
		type: 'POST',
		url: "functions/gedung/show_gedung.php",
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

function add_gedung(){
  act = document.getElementById('act').value;
  id_gedung= document.getElementById('id_gedung').value;
  jumlah_lantai = document.getElementById('jumlah_lantai').value;
  nama_gedung = document.getElementById('nama_gedung').value;
  userid = document.getElementById('username').value;
  if(jumlah_lantai == 0){
    alert('Jumlah Lantai masih kosong');
  }else if(nama_gedung == ''){
    alert('Nama Gedung masih kosong');
  }else{
    $.ajax({
    type: 'POST',
    url: "functions/gedung/f_gedung.php",
    data:({act:act,id_gedung:id_gedung,jumlah_lantai:jumlah_lantai,nama_gedung:nama_gedung,userid:userid}),
    dataType:'json',
      success: function(data) {
	if(data.status == 'SUCCESS'){
          document.getElementById('sukses').style.display='block';
              if(act=='simpan') {
                $('#pesan').text('Insert Success!');
		clear();
              } else {
                $('#pesan').text('Update Success!');
		clear();
              }  
	window.location.replace("index.php?page=gedung");          
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