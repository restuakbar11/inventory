$(document).ready(
  function () {
    //$('.restu').load("functions/barang_masuk/show_barangmasuk.php");
    tampil_list();

    $("#supplier").change(function () {
      a = $("#supplier").val();
      var explode = a.split('-');
      id_supp = explode[0];
      alamat = explode[1];
      $('#alamat').val(alamat);
      $('#id_supplier').val(id_supp);


    });

    $("#item").change(function () {
      b = $("#item").val();

      $.ajax({
        type: "POST",
        url: "functions/satuan/querySatuan.php",
        data: "iditem=" + b,
        success: function (result) {
          $('.querySatuan').html(result);
        }

      });
    });

  });

$(".add").click(function () {
  clear();
  window.location.replace("index.php?page=add_brg_masuk");

});

//$(document).on('click','.generate',function(){
//    var id = $(this).attr('data');
//    var explode = id.split('&');
//    nosj = explode[0];
//    id_item = explode[1];
//    a = 1;
//    window.location.replace("index.php?page=ctk_barcode&nosj="+id+"&id_item="+id_item+"&generate="+a);
//});

$(document).on('click', '.generate', function () {
  var id = $(this).attr('data');
  var explode = id.split('&');
  nosj = explode[0];
  id_item = explode[1];
  nosj_detail = explode[2];
  $.ajax({
    type: "POST",
    url: "functions/barang_masuk/f_generate_barcode.php",
    data: "act=generate_barcode&nobarangmasuk_detail=" + nosj_detail + "&id_item=" + id_item,
    dataType: "json",
    success: function (data) {

      if (data.hasil == 0) {
        Swal.fire({
          title: data.status,
          text: data.ket,
          confirmButtonColor: "#80C8FE",
          type: "error",
          timer: 3500,
          confirmButtonText: "Ya",
          showConfirmButton: true
        });
        $('#det_barcode').fadeOut('slow');
      } else {
        Swal.fire({
          title: data.status,
          text: data.ket,
          confirmButtonColor: "#80C8FE",
          type: "success",
          timer: 3500,
          confirmButtonText: "Ya",
          showConfirmButton: true
        });
        window.location.replace("index.php?page=ctk_barcode&nosj=" + id + "&id_item=" + id_item + "&generate=" + a);
      }
    }
  });
});

$(document).on('click', '.generate', function () {
  var id = $(this).attr('data');
  var explode = id.split('&');
  nosj = explode[0];
  nosj_detail = explode[1];
  a = 1;
  //window.location.replace("index.php?page=ctk_barcode&nosj="+id+"&id_item="+id_item+"&generate="+a);
});

$(document).on('click', '.view', function () {
  var id = $(this).attr('data');
  window.location.replace("index.php?page=ctk_barcode&aksi=view&nosj=" + id);
});

$(document).on('click', '.viewdetail', function () {
  var id = $(this).attr('data');
  window.location.replace("index.php?page=ctk_barcode&aksi=generate&nosj=" + id);
});

$(document).on('click', '.printbarcode', function () {
  var id = $(this).attr('data');
  var explode = id.split('&');
  nosj = explode[0];
  id_item = explode[1];
});

$(document).on('click', '.inputitem', function () {
  var id = $(this).attr('data');
  var explode = id.split('&');
  nosj = explode[0];
  supplier = explode[1];
  window.location.replace("index.php?page=add_brg_masuk&nosj=" + nosj + "&idsupplier=" + supplier);
});

$(document).on('click', '.hapusbrgmasuk', function () {

  var id = $(this).attr('data');
  var checkstr = confirm('Are you sure want to delete?');
  if (checkstr == true) {
    $.ajax({
      type: "POST",
      url: "functions/barang_masuk/f_barangmasuk.php",
      data: "act=delete&nosj=" + id,
      dataType: "json",
      success: function (data) {
        window.location.replace("index.php?page=brg_masuk");
      }
    });
  } else {
    return false;
  }
});

$(document).on('click', '.hapusbarangmasukdetail', function () {

  var id = $(this).attr('data');
  var explode = id.split('&');
  nosj_detail = explode[0];
  userid = explode[1];
  var explode1 = nosj_detail.split('-');
  nosj = explode1[0];
  //alert(nosj);
  var checkstr = confirm('Are you sure want to delete?');
  if (checkstr == true) {
    $.ajax({
      type: "POST",
      url: "functions/barang_masuk/f_barangmasuk.php",
      data: "act=delete_item&nosj_detail=" + nosj_detail + "&userid=" + userid,
      dataType: "json",
      success: function (data) {
        if (data) {
          Swal.fire({
            title: 'Berhasil Terhapus..!!',
            text: "Akan Menutup Dalam 2 Detik!!!",
            confirmButtonColor: "#80C8FE",
            type: "success",
            timer: 3500,
            confirmButtonText: "Ya",
            showConfirmButton: true
          });
          $('.detail_tabel').load("functions/barang_masuk/show_detailbarangmasuk.php?nosj=" + nosj);
        } else {
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
  } else {
    return false;
  }
});

$(document).on('click', '.batal_masuk', function () {
  var id = $(this).attr('data');
  window.location.replace("index.php?page=batal_masuk&nosj=" + id);
});

function tampil_list() {
  $(document).ajaxStart(function () {
    $("#waiting").css("display", "block");
  });
  $(document).ajaxComplete(function () {
    $("#waiting").css("display", "none");
  });
  var startdate = $("#startdate").val();
  var finishdate = $("#finishdate").val();
  $.ajax({
    type: 'POST',
    url: "functions/barang_masuk/show_barangmasuk.php",
    data: "startdate=" + startdate + "&finishdate=" + finishdate,
    success: function (hasil) {
      $('.restu').html(hasil);
    }
  });
}

function clear() {
  $('input[type=text].form-control').val('');
  $('input[type="password"].form-control').val('');
  $('select.form-control').val('').change;
}

$(document).ready(function () {
  $('#startdate').on('changeDate', function () {
    tampil_list();
  });
  $('#finishdate').on('changeDate', function () {
    tampil_list();
  });
});


function simpan_header() {
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
  } else if (supplier == '' || supplier == '0') {
    Swal.fire({
      title: 'Pilih Supplier Terlebih Dahulu ',
      text: "Akan Menutup Dalam 2 Detik!!!",
      confirmButtonColor: "#80C8FE",
      type: "info",
      timer: 3500,
      confirmButtonText: "Ya",
      showConfirmButton: true
    });
  } else {
    $.ajax({
      type: 'POST',
      url: "functions/barang_masuk/f_barangmasuk.php",
      data: ({ act: act, flag: flag, supplier_id: supplier, department_id: department, nosj: brg_masuk, note: catatan, tanggal_masuk: tgl_masuk, userid: userid }),
      dataType: 'json',
      success: function (data) {
        $('#addItem').fadeIn('slow');
        $('#detailItem').fadeIn('slow');
        document.getElementById('smpn_header').style.visibility = 'hidden';
        $('.detail_tabel').load("functions/barang_masuk/show_detailbarangmasuk.php?nosj=" + brg_masuk);
      }
    })

  }
}

function simpan_detail() {
  act = 'simpan';
  flag = 'DETAIL';
  brg_masuk = document.getElementById('brg_masuk').value;
  ed = document.getElementById('ed').value
  id_item = document.getElementById('item').value;
  id_satuan = document.getElementById('satuan').value;
  qty = document.getElementById('qty').value;
  lot = document.getElementById('lot').value;
  userid = document.getElementById('userid').value;
  if (id_item == 0) {
    alert('Item masih kosong');
  } else if (id_satuan == 0) {
    alert('Satuan masih kosong');
  } else if (qty == 0 || qty == '') {
    alert('Quantity masih kosong');
  } else if (lot == '') {
    alert('Lot masih kosong');
  } else {
    var checkstr = confirm('Yakin ingin menambah item?');
    if (checkstr == true) {
      $.ajax({
        type: 'POST',
        url: "functions/barang_masuk/f_barangmasuk.php",
        data: ({ act: act, flag: flag, item_id: id_item, lot_number: lot, qty: qty, ed: ed, satuan_id: id_satuan, nosj: brg_masuk, userid: userid }),
        dataType: "json",
        success: function (data) {
          if (data.status == 'SUCCESS') {
            Swal.fire({
              title: 'Berhasil Tambah Item..!!',
              text: "Akan Menutup Dalam 2 Detik!!!",
              confirmButtonColor: "#80C8FE",
              type: "success",
              timer: 2000,
              confirmButtonText: "Ya",
              showConfirmButton: true
            });
            $('.detail_tabel').load("functions/barang_masuk/show_detailbarangmasuk.php?nosj=" + brg_masuk);
          } else {
            Swal.fire({
              title: 'GAGAL Tambah Item..!!',
              text: "Akan Menutup Dalam 2 Detik!!!",
              confirmButtonColor: "#80C8FE",
              type: "success",
              timer: 2000,
              confirmButtonText: "Ya",
              showConfirmButton: true
            });
          }
        }
      })
    } else {
      return false;
    }
  }


}

function cekuser(a) {
  re = /^[A-Za-z0-9\=/-]{1,}$/;
  return re.test(a);
}

function validation() //function validasi
{
  var brg_masuk = document.getElementById("brg_masuk").value;

  if (!cekuser(brg_masuk)) {
    Swal.fire({
      title: 'WARNING',
      text: 'TIDAK BOLEH MENGGUNAKAN SPASI ATAU KARAKTER ASING',
      type: 'warning',
      showCancelButton: false,
      allowOutsideClick: false,
      position: 'top'
    })
    clear();
    brg_masuk.focus();
    return false;
  } else {
  }

}

function number() {
  var validasiAngka = /^[0-9]+$/;
  var qty = document.getElementById("qty");
  if (qty.value.match(validasiAngka)) {
  } else {
    Swal.fire({
      title: 'WARNING',
      text: 'FORMAT HARUS ANGKA',
      type: 'warning',
      showCancelButton: false,
      allowOutsideClick: false,
      position: 'top'
    })
    qty.value = "";
    qty.focus();
    return false;
  }
}