$(document).ready(function () {
  // Ganti Field Select2 -> Input
  $("#tambah").click(function () {
    $("#pilih_pasien").select2('destroy');
    $("#pilih_pasien").hide();
    $("#tambah").attr('disabled', 'true');
    $("#kembali").removeAttr('disabled');
    $(".tambah").append("<input type='text' name='nm_pasien' id='nm_pasien' class='form-control' required autocomplete='off'>");
  });

  // Ganti Field Input -> Select2
  $("#kembali").click(function () {
    $("#tambah").removeAttr('disabled');
    $("#kembali").attr('disabled', 'true');
    $("#nm_pasien").remove();
    $("#pilih_pasien").show();
    $("#pilih_pasien").select2({
      theme: 'bootstrap4',
      placeholder: 'Pilih Nama Pasien',
      allowClear: true
    });
  });
});