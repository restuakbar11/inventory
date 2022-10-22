$(document).ready(
  function(){
$('.restu').load("functions/rak_kulkas/show_rakkulkas.php");
$('#act').val('simpan');
});

$(document).on('click','.hapusrakkulkas',function(){

    var id = $(this).attr('data');
    var checkstr =  confirm('Are you sure want to delete?');
    if(checkstr == true){ 
    $.ajax({
        type: "POST", 
        url : "functions/rak_kulkas/f_rakkulkas.php", 
        data: "act=delete&kode_rakkulkas=" + id ,
        dataType: "json",     
        success: function(data){
         if(data){
          window.location.replace("index.php?page=rakKulkas");
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

function clear(){
  $('input[type=text].form-control').val('');
  $('input[type="password"].form-control').val('');
  $('select.form-control').val('');
}

function add_rak(){
  act = document.getElementById('act').value;
  kode_rak= document.getElementById('kode_rak').value;
  kulkas = document.getElementById('type_kulkas').value;
  nama_rak = document.getElementById('nama_rak').value;
jenis_rak = document.getElementById('jenis_rak').value;
  userid = document.getElementById('username').value;
  if(kode_rak == ''){
    alert('Kode Rak Kulkas masih kosong');
  }else if(nama_rak == ''){
    alert('Nama Rak masih kosong');
  }else if(kulkas == '0'){
    alert('Kulkas masih kosong');
  }else if(jenis_rak == ''){
    alert('Jenis Rak masih kosong');
  }else{
    
     $.ajax({
     type: 'POST',
     url: "functions/rak_kulkas/f_rakkulkas.php",
     data:({act:act,kode_rakkulkas:kode_rak,nama_rakkulkas:nama_rak,kulkas:kulkas,jenis_rakkulkas:jenis_rak,userid:userid}),
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
