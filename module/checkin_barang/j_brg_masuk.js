$(document).ready(
  function(){
$('.restu').load("functions/barang_masuk/show_barangmasuk.php");
$('#act').val('simpan');
$('#addItem').fadeOut('slow');

$("#supplier").change(function(){ 
   a = $("#supplier").val();
  var explode = a.split('-');
id_supp = explode[0];
  alamat = explode[1];
  $('#alamat').val(alamat);
  $('#id_supplier').val(id_supp);
  

    });

$("#item").change(function(){ 
   b = $("#item").val();
  var explode = b.split('/');
  id_item = explode[0];
  id_satuan = explode[1];
  $('#id_item').val(id_item);
  $('#id_satuan').val(id_satuan);
});

});

function clear(){
  $('input[type=text].form-control').val('');
  $('input[type="password"].form-control').val('');
  $('select.form-control').val('').change;
}

function simpan_header(){
act = document.getElementById('act').value;
  flag = document.getElementById('flag').value;
  brg_masuk = document.getElementById('brg_masuk').value;
  tgl_masuk = document.getElementById('tgl_masuk').value;
  department = document.getElementById('department').value;
  supplier = document.getElementById('id_supplier').value;
  catatan = document.getElementById('catatan').value;
  userid = document.getElementById('userid').value; 

  if (brg_masuk == '') {
    Swal.fire({
      title: 'Isi Nomor Surat Jalan Terlebih Dahulu ',
      text: "Akan Menutup Dalam 2 Detik!!!",
      confirmButtonColor: "#80C8FE",
      type: "info",
      timer: 3500,
      confirmButtonText: "Ya",
      showConfirmButton: true
    });
  }else if(supplier == '' || supplier == '0'){
    Swal.fire({
      title: 'Pilih Supplier Terlebih Dahulu ',
      text: "Akan Menutup Dalam 2 Detik!!!",
      confirmButtonColor: "#80C8FE",
      type: "info",
      timer: 3500,
      confirmButtonText: "Ya",
      showConfirmButton: true
    });
  }else{
 $.ajax({
    type: 'POST',
    url: "functions/barang_masuk/f_barangmasuk.php",
    data:({act:act,flag:flag,supplier_id:supplier,department_id:department,nosj:brg_masuk,note:catatan,tanggal_masuk:tgl_masuk,userid:userid}),
    dataType:'json',
      success: function(data) {
         $('#addItem').fadeIn('slow');
         document.getElementById('smpn_header').style.visibility = 'hidden';
      }
    }) 

  }
}

function simpan_detail(){
  act = document.getElementById('act').value;
  flag = 'DETAIL';
  brg_masuk = document.getElementById('brg_masuk').value;
  ed = document.getElementById('ed').value
  id_item = document.getElementById('id_item').value;
  id_satuan = document.getElementById('id_satuan').value;
  qty = document.getElementById('qty').value;
  lot = document.getElementById('lot').value;
  userid = document.getElementById('userid').value;

  $.ajax({
    type: 'POST',
    url: "functions/barang_masuk/f_barangmasuk.php",
    data:({act:act,flag:flag,item_id:id_item,lot_number:lot,qty:qty,ed:ed,satuan_id:id_satuan,nosj:brg_masuk,userid:userid}),
    dataType:'json',
      success: function(data) {
        $('.detail_tabel').load("functions/barang_masuk/show_detailbarangmasuk.php");
      }
    }) 
}