$(document).ready(
  function(){
tampil_list();
});

$(".tambahsubdept").click(function(){
  clear ();
  $('#defaultModalLabel').text('Tambah Sub Department');
    $("#modalsubdepartment").modal('show');
  $('#modaldepartment').on('shown.bs.modal', function () {
  });
  $("#act").val('simpan');
  $('#save').text('SAVE');
});

$(document).on('click','.hapussubdepartment',function(){

var id = $(this).attr('data');
    var checkstr =  confirm('Are you sure want to delete?');
    if(checkstr == true){
    $.ajax({
        type: "POST", 
        url : "functions/sub_department/f_subdepartment.php", 
        data: "act=delete&id_subdepartment=" + id ,
        dataType: "json",     
        success: function(data){
         if(data){
          window.location.replace("index.php?page=sub_department");
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

$(document).on('click', '.editsubdepartment', function(){
  $('#defaultModalLabel').text('Edit Sub Department');
  id = $(this).attr('data');
    $.ajax({
        type: "POST", 
        url : "functions/sub_department/f_subdepartment.php", 
        data: "act=form&id_subdepartment=" + id ,
        dataType: "json",     
        success: function(data){
          if(data){       
	     $('#id_department').val(data.id_department).change();
	     $('#ruangan').val(data.id_ruangan).change();
	     $('#nama_subdep').val(data.nama_subdepartment).change();
	     $('#id_subdepartment').val(id);
             $('#act').val('update');
             $('#save').text('UPDATE');
          }
          else{
            alert("Error");
          }
        }   
      });
    $("#modalsubdepartment").modal('show');
});

function tampil_list () {
	$.ajax({
		type: 'POST',
		url: "functions/sub_department/show_subdepartment.php",
		data: "",
		success: function(hasil) {
		$('.restu').html(hasil);
		}
	});
}

function clear(){
  $('input[type=text].form-control').val('');
  $('select.clearform').val('0').change();
}

function add_subdep(){
  act = document.getElementById('act').value;
  id_subdepartment = document.getElementById('id_subdepartment').value;
  id_department = document.getElementById('id_department').value;
  ruangan = document.getElementById('ruangan').value;
  nama_subdep = document.getElementById('nama_subdep').value;
  userid = document.getElementById('username').value;
  alert(userid);
if(ruangan == 0){
    alert('ruangan masih kosong');
  }else if(id_department == 0){
    alert('Department masih kosong');
  }else if(nama_subdep == ''){
    alert('Nama Department masih kosong');
  }else{
	$.ajax({
    type: 'POST',
    url: "functions/sub_department/f_subdepartment.php",
    data:({act:act,nama_subdepartment:nama_subdep,id_ruangan:ruangan,userid:userid,id_department:id_department,id_subdepartment:id_subdepartment}),
    dataType:'json',
      success: function(data) {
        if(data.status == 'SUCCESS'){
	$("#modalsubdepartment").modal('hide');
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
