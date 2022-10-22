$(document).ready(
  function(){
    function tampildata(){
      var id_department=$("#id_department").val();
      var id_rakgudang=$("#id_rakgudang").val();
    
      $.ajax({
        type: "POST",
        url: "functions/gudang/queryGetGudangAll.php",
        data: "id_department=" + id_department+ "&id_rakgudang="+id_rakgudang,
        success: function(data){
           $('.gudang').html(data);
        }   
      });
    }
    
tampil_list();
    tampildata();
    $(".tambahrakgudang").click(function(){
      clear ();
      $('#defaultModalLabel').text('Tambah Rak');
        $("#modalitem").modal('show');
      
      $("#act").val('add');
      $('#save').text('SAVE');
    });
    $("#id_department").change(function(){
      var id_department=$("#id_department").val();
      var id_rakgudang=$("#id_rakgudang").val();
     
    $.ajax({
      type: "POST",
      url: "functions/gudang/queryGetGudangAll.php",
      data: "id_department=" + id_department+ "&id_rakgudang="+id_rakgudang,
      success: function(data){
         $('.gudang').html(data);
      } 
    });
    });


});

function tampil_list () {
      
  $('.restu').load("functions/rakgudang/show_rakgudang.php");
    } 

$("#save").click(function(){
  var item = {};
  $(".rakgudang").each(function(k,v){
      item[$(this).attr('name')] = $(this).val();
      //item[$(this).attr('name')] = $(this).is(':checkbox:checked') == true ? '1': $(this).val();
  });
  
});

$(document).on('click','.hapusrakgudang',function(){

    var id = $(this).attr('data');
    var checkstr =  confirm('Are you sure want to delete?');
    if(checkstr == true){
    $.ajax({
        type: "POST", 
        url : "functions/rakgudang/f_rakgudang.php", 
        data: "act=delete&id_rakgudang=" + id ,
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
//window.location.replace("index.php?page=rakgudang");
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
$(document).on('click', '.editrakgudang', function(){
	$('#defaultModalLabel').text('Edit Rak');
	var id_rakgudang = $(this).attr('data');
    $.ajax({
				type: "POST", 
				url : "functions/rakgudang/f_rakgudang.php", 
                data: "act=form&id_rakgudang=" + id_rakgudang ,
                dataType: "json",			
            	success: function(data){
					if(data){
					//	$('#iditem').val(data.IDITEM).attr('disabled','true');
						$('#id_rakgudang').val(data.ID_RAKGUDANG);
						$('#namarakgudang').val(data.NAMARAKGUDANG);
						$('select[name=id_department]').val(data.ID_DEPARTMENT).change().attr('disabled','true');
						
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
  $('select').change().removeAttr('disabled');
  $('input[type=text].form-control').val('');
  $('input[id=id_rakgudang].form-control').val('');
  $('input[type="password"].form-control').val('');
}

function add_rak(){
  act = document.getElementById('act').value;
  id_department = document.getElementById('id_department').value;
  userid = document.getElementById('username').value;
  id_gudang = document.getElementById('id_gudang').value;
namarakgudang = document.getElementById('namarakgudang').value;
idrakgudang = document.getElementById('id_rakgudang').value;

if(id_department == 0){
    alert('Department masih kosong');
  }else if(id_gudang == 0){
    alert('Gudang masih kosong');
  }else if(namarakgudang == ''){
    alert('Nama Rak Gudang masih kosong');
  }else{
   $.ajax({
      type: "POST", 
      url : "functions/rakgudang/f_rakgudang.php", 
              data: {act:act,idrakgudang :idrakgudang,id_department:id_department,id_gudang:id_gudang,namarakgudang:namarakgudang,userid:userid},
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
