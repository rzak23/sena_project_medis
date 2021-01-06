$(document).ready(function () {
  // Select Dokter Jaga
  var sesdata = sessionStorage.getItem('dokterku');
  $('#dokter_medis').select2({
    theme: 'bootstrap4',
    placeholder: 'Pilih Dokter Jaga',
    allowClear: true,
    if(sesdata){
      $('#dokter_medis').val(sesdata);
      $('#dokter_medis').select2().trigger('change');
    }
  });
  $('#dokter_rekap').select2({
    theme: 'bootstrap4',
    placeholder: 'Pilih Dokter Jaga',
    allowClear: true
  });
  // Select Paramedis Jaga
  var sesparam = sessionStorage.getItem('paramku');
  $('#param_medis').select2({
    theme: 'bootstrap4',
    placeholder: 'Pilih Paramedis Jaga',
    allowClear: true
    if(sesparam){
      $('#param_medis').val(sesparam);
      $('#param_medis').select2().trigger('change');
    }
  });
  // Select Shift Jaga
  var sesjaga = sessionStorage.getItem('shiftku');
  $('#shift_medis').select2({
    theme: 'bootstrap4',
    placeholder: 'Pilih Shift Jaga',
    allowClear: true
    if(sesjaga){
      $('#shift_medis').val(sesjaga);
      $('#shift_medis').select2().trigger('change');
    }
  });
  // Select Shift Rekap
  $('#shift_rekap').select2({
    theme: 'bootstrap4',
    placeholder: 'Pilih Shift Rekap',
    allowClear: true
  })

  // Select Nama Pasien Rekmed
  $('#nm_medis').select2({
    theme: 'bootstrap4',
    placeholder: 'Pilih Nama Pasien',
    allowClear: true
  });
  // Select Tipe Pasien Rekmed
  $('#tipe_medis').select2({
    theme: 'bootstrap4',
    placeholder: 'Pilih Tipe Pasien',
    allowClear: true
  });
  // Select Dokter Rekap

  // Select Tipe Pengguna
  $('#tipe_pengguna').select2({
    theme: 'bootstrap4',
    placeholder: 'Pilih Tipe Pengguna',
    allowClear: true
  });
  // Select Dokter Gaji
  $('#dokter_gaji').select2({
    theme: 'bootstrap4',
    placeholder: 'Pilih Data Dokter',
    allowClear: true
  });
  // Select Bulan Pemasukan
  $('#bulan_masuk').select2({
    theme: 'bootstrap4',
    placeholder: 'Pilih Bulan Laporan',
    allowClear: true
  });
  // Select Tahun Pemasukan
  $('#tahun_masuk').select2({
    theme: 'bootstrap4',
    placeholder: 'Pilih Tahun Laporan',
    allowClear: true
  });
});

// Ganti Value Biaya Sesuai Tipe Pasien
$(document).ready(function () {
  $("#tipe_medis").change(function () {
    var tp_pasien = $("#tipe_medis").val();
    if (tp_pasien == "Umum") {
      // hapus atribut disabled
      $("#biaya_medis").removeAttr('readonly');
      // hapus nilai biaya
      $("#biaya_medis").removeAttr('value');
    } else if (tp_pasien == "Bpjs") {
      // isi atribut disables
      $("#biaya_medis").attr('readonly', true);
      // isi nilai biaya
      $("#biaya_medis").val("0");
    } else if (tp_pasien == "Aqua") {
      // isi atribut disabled
      $("#biaya_medis").attr('readonly', true);
      // isi nilai biaya
      $("#biaya_medis").val("0");
    }
  });
});