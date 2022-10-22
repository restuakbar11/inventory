$(document).ready(
  function(){
tampil_list();
});

$(".tambahdepartment").click(function(){
  clear ();
  $('#defaultModalLabel').text('Tambah Department');
    $("#modaldepartment").modal('show');
  $('#modaldepartment').on('shown.bs.modal', function () {
  });
  $("#act").val('simpan');
  $('#save').text('SAVE');
});

$(document).on('click','.hapusdepartment',function(){

    var id = $(this).attr('data');
    var checkstr =  confirm('Are you sure want to delete?');
    if(checkstr == true){
    $.ajax({
        type: "POST", 
        url : "functions/department/f_department.php", 
        data: "act=delete&id_department=" + id ,
        dataType: "json",     
        success: function(data){
         if(data){
          window.location.replace("index.php?page=department");
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

$(document).on('click', '.editdepartment', function(){
  $('#defaultModalLabel').text('Edit Department');
  id = $(this).attr('data');
    $.ajax({
        type: "POST", 
        url : "functions/department/f_department.php", 
        data: "act=form&id_department=" + id ,
        dataType: "json",     
        success: function(data){
          if(data){        
	     $('#nama_department').val(data.nama_department);
	     $('#id_department').val(id);
             $('#act').val('update');
             $('#save').text('UPDATE');
          }
          else{
            alert("Error");
          }
        }   
      });
    $("#modaldepartment").modal('show');
});

function tampil_list () {
	$.ajax({
		type: 'POST',
		url: "functions/department/show_department.php",
		data: "",
		success: function(hasil) {
		$('.restu').html(hasil);
		}
	});
}

function clear(){
  $('input[type=text].form-control').val('');
  $('select.form-control').val('');
}

function add_department(){
  act = document.getElementById('act').value;
  id_department = document.getElementById('id_department').value;
  nama_department = document.getElementById('nama_department').value;
  userid = document.getElementById('username').value;

  if(nama_department == ''){
    alert('Nama Department masih kosong');
  }else{
    $.ajax({
    type: 'POST',
    url: "functions/department/f_department.php",
    data:({act:act,nama_department:nama_department,userid:userid,id_department:id_department}),
    dataType:'json',
      success: function(data) {
	if(data.status == 'SUCCESS'){
	$("#modaldepartment").modal('hide');
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
