$(document).ready(
  function () {

    var loading = $("#loading");
    var tampilkan = $("#tampilkan");
    function tampildata() {
      tampilkan.hide();
      loading.fadeIn();
      var barcode = $("#kode_barcode").val();

      $.ajax({
        type: "POST",
        url: "functions/checkin_barang/show_detailchecikin.php",
        data: "aksi=tampil&kode_barcode=" + barcode,
        success: function (data) {
          loading.fadeOut();
          tampilkan.html(data);
          tampilkan.fadeIn(2000);
        }
      });
    }

    tampildata();
    $("#id_gudang").change(function () {
      var id_gudang = $("#id_gudang").val();

      $.ajax({
        type: "POST",
        url: "functions/rakgudang/queryGetRakGudang.php",
        data: "id_gudang=" + id_gudang,
        success: function (data) {
          $('.rak').html(data);
        }
      });
    });
    $('#kode_barcode').bind('keypress', function (e) {
      var code = e.keyCode || e.which;
      var barcode = $("#kode_barcode").val();
      var M_DEPARTMENTDEPARTMENTID = $("#id_department").val();
      var IDGUDANG = $("#id_gudang").val();
      var IDRAKGUDANG = $("#id_rakgudang").val();

      if (code == 13) {
        if (IDGUDANG == 0) {
          Swal.fire({
            title: 'Error',
            text: 'Lokasi Penyimpan Tidak Boleh Kosong',
            type: 'error',
            confirmButtonColor: "red",
            showCancelButton: false,
            allowOutsideClick: false,
            position: 'top'
          })
        }
        else if (IDRAKGUDANG == '' || IDRAKGUDANG == 0) {
          Swal.fire({
            title: 'Error ',
            text: 'Rak Tidak Boleh Kosong',
            type: 'error',
            confirmButtonColor: "red",
            showCancelButton: false,
            allowOutsideClick: false,
            position: 'top'
          })
        }
        else if (barcode == '') {
          Swal.fire({
            title: 'Error ',
            text: 'Kode Barcode Tidak Boleh Kosong',
            type: 'error',
            confirmButtonColor: "red",
            showCancelButton: false,
            allowOutsideClick: false,
            position: 'top'
          })
        }
        else {
          $.ajax({
            type: "POST",
            url: "functions/checkin_barang/show_detailchecikin.php",
            data: "aksi=save&kode_barcode=" + barcode + "&M_DEPARTMENTDEPARTMENTID=" + M_DEPARTMENTDEPARTMENTID + "&IDGUDANG=" +
              IDGUDANG + "&IDRAKGUDANG=" + IDRAKGUDANG,
            dataType: "json",
            success: function (data) {
              if (data.status == 'StockInsert') {
                Swal.fire({
                  title: 'Sukses ',
                  text: 'Semua Barang Berhasil Masuk Stock',
                  type: 'success',
                  confirmButtonColor: "red",
                  showCancelButton: false,
                  allowOutsideClick: false,
                  position: 'top'
                })
              }
              else if (data.status == 'StockUpdate') {
                Swal.fire({
                  title: 'Update',
                  text: 'Stock Barang Sudah Ditambahkan',
                  type: 'success',
                  confirmButtonColor: "red",
                  showCancelButton: false,
                  allowOutsideClick: false,
                  position: 'top'
                })
              }
              else if (data.status == 'error') {
                Swal.fire({
                  title: 'GAGAL',
                  text: 'Kode Barcode Tidak Ditemukan..',
                  type: 'error',
                  confirmButtonColor: "red",
                  showCancelButton: false,
                  allowOutsideClick: false,
                  position: 'top'
                })
              }
              else {
                Swal.fire({
                  title: 'Sukses',
                  text: 'Barcode Berhasil CheckIn',
                  type: 'success',
                  confirmButtonColor: "red",
                  showCancelButton: false,
                  allowOutsideClick: false,
                  position: 'top'
                })
              }
              tampildata();
              $("#kode_barcode").val('');
              $("#kode_barcode").focus();
            }
          });
        }
      }

    });
  });

function clear() {
  $('input[type=text].form-control').val('');
  $('input[type="password"].form-control').val('');
  $('select.form-control').val('').change;
}

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
        document.getElementById('smpn_header').style.visibility = 'hidden';
      }
    })

  }
}

function simpan_detail() {
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
    data: ({ act: act, flag: flag, item_id: id_item, lot_number: lot, qty: qty, ed: ed, satuan_id: id_satuan, nosj: brg_masuk, userid: userid }),
    dataType: 'json',
    success: function (data) {
      $('.detail_tabel').load("functions/barang_masuk/show_detailbarangmasuk.php");
    }
  })
}