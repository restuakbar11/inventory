$(document).ready(
  function(){
    tampil_list();
});
function tampil_list () {
  $('.restu').load("functions/sub_departmentkulkas/show_subdepartment_kulkas.php");
    } 

$(".tambahsubdkulkas").click(function(){
  clear ();
$("#no_billing").prop("disabled", false);
  $('#defaultModalLabel').text('Tambah Subdepartment Kulkas');
    $("#modalsubdkulkas").modal('show');
  $('#modalsubdkulkas').on('shown.bs.modal', function () {
  });
  $("#act").val('simpan');
  $('#save').text('SAVE');
});

$(document).on('click','.hapussubdepartmentkulkas',function(){

var id = $(this).attr('data');
    var checkstr =  confirm('Are you sure want to delete?');
    if(checkstr == true){
    $.ajax({
        type: "POST", 
        url : "functions/sub_departmentkulkas/f_subdepartmentkulkas.php", 
        data: "act=delete&kode_kulkas=" + id,
        dataType: "json",     
        success: function(data){
         if(data){
          window.location.replace("index.php?page=sub_department_kulkas");
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

$(document).on('click', '.editsubdepartmentkulkas', function(){
  $('#defaultModalLabel').text('Edit Subdepartment Kulkas');
  id = $(this).attr('data');
id_subDept = $(this).attr('id_subDept');
    $.ajax({
        type: "POST", 
        url : "functions/sub_departmentkulkas/f_subdepartmentkulkas.php", 
                data: "act=form&kode_kulkas=" + id + "&id_subDept=" + id_subDept,
                dataType: "json",     
              success: function(data){
          if(data){            
	     $('#id_subdepartment').val(data.id_subdepartment).change();
             $('#kode_kulkas').val(data.kd_kulkas).change();
	$("#kode_kulkas").prop("disabled", true);
             $('#act').val('update');
             $('#save').text('UPDATE');
          }
          else{
            alert("Error");
          }
        }   
      });
    $("#modalsubdkulkas").modal('show');
});

function clear(){
  $('input[type=text].form-control').val('');
  $('select.clearform').val('0').change();
}


function add_subdeptkulkas(){
  act = document.getElementById('act').value;
  id_subdepartment = document.getElementById('id_subdepartment').value;
  kode_kulkas = document.getElementById('kode_kulkas').value;
  userid = document.getElementById('username').value;
  if(kode_kulkas == 0){
     alert('Kode Kulkas masih kosong');
  }
  else if(id_subdepartment == 0){
     alert('Nama subd department masih kosong');
  }else{
     $.ajax({
    type: 'POST',
    url: "functions/sub_departmentkulkas/f_subdepartmentkulkas.php",
    data:({act:act,id_subdepartment:id_subdepartment,kode_kulkas:kode_kulkas,userid:userid}),
    dataType:'json',
      success: function(data) {
        if(data.status == 'SUCCESS'){
          
          $('#modalsubdkulkas').modal('hide');
          tampil_list();
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
