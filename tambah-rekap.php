<?php

// Set Waktu
date_default_timezone_set('Asia/Kuala_Lumpur');
$tgl_rekap  = date("Y-m-d");

// Konfigurasi Buat ID Rekap
$tanggal      = date("ymd");
// => Cek ID Rekap
$cari_id      = mysqli_query($koneksi, "SELECT id_rekap FROM tabel_rekap") or die(mysqli_error(""));
$data_id      = mysqli_fetch_array($cari_id);
$jumlah       = mysqli_num_rows($cari_id);
// => Buat Id Rekap
if ($data_id) {
  $id         = (int) $jumlah;
  $id         = $jumlah + 1;
  $id_rekap   = "$tanggal" . "07" . str_pad($id, 7, "0", STR_PAD_LEFT);
} else {
  $id_rekap   = "$tanggal" . "07" . "0000001";
}

// Simpan Data Rekap
if (isset($_POST["btn_simpan_rekap"])) {
  if (tambah_rekap($_POST) > 0) {
    echo "<script>alert ('Penambahan Data Rekap Berhasil!'); document.location.href = 'rekap-medis.php';</script>";
  } else {
    echo "<script>alert ('Penambahan Data Rekap Gagal!'); document.location.href = 'rekap-medis.php';</script>";
  }
}

?>
<!-- Tambah Data Rekap Medis -->
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Tambah Data Rekap Medis</h5>
      </div>
      <div class="card-body row">
        <div class="col-md-12">
          <form action="" method="post" name="autoSumForm">
            <div class="row form-horizontal">
              <div class="col-md-5">
                <input type="text" name="id_rekap" id="id_rekap" class="form-control" value="<?= $id_rekap; ?>" hidden>
                <!-- Tanggal Rekap -->
                <div class="form-group row">
                  <label for="tgl_rekap" class="col-md-4 col-form-label">Tanggal Rekap</label>
                  <div class="col-md-8">
                    <input type="date" name="tgl_rekap" id="tgl_rekap" class="form-control" value="<?= $tgl_rekap; ?>" required autocomplete="off">
                  </div>
                </div>
                <!-- Shift Jaga -->
                <div class="form-group row">
                  <label for="shift_rekap" class="col-md-4 col-form-label">Shift Jaga</label>
                  <div class="col-md-8">
                    <select name="shift_rekap" id="shift_rekap" class="js-example-placeholder-single js-states form-control" required>
                      <option></option>
                      <option value="Pagi">Pagi</option>
                      <option value="Siang">Siang</option>
                      <option value="Sore">Sore</option>
                    </select>
                  </div>
                </div>
                <!-- Dokter Jaga -->
                <div class="form-group row">
                  <label for="dokter_rekap" class="col-md-4 col-form-label">Dokter Jaga</label>
                  <div class="col-md-8">
                    <select name="dokter_rekap" id="dokter_rekap" class="js-example-placeholder-single js-states form-control" required>
                      <option></option>
                      <?php $dokter = query("SELECT * FROM tabel_dokter"); ?>
                      <?php foreach ($dokter as $dr) : ?>
                        <option value="<?= $dr["id_dokter"]; ?>"><?= $dr["nama_dokter"]; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <!-- Jumlah Biaya Medis -->
                <div class="form-group row">
                  <label for="biaya_rekap" class="col-md-4 col-form-label">Jumlah Biaya</label>
                  <div class="col-md-8 input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Rp.</span>
                    </div>
                    <input type="text" name="biaya_rekap" id="biaya_rekap" class="form-control" required autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                  </div>
                </div>
              </div>
              <div class="col-md-2"></div>
              <div class="col-md-5">
                <!-- Jumlah Pasien Umum -->
                <div class="form-group row">
                  <label for="umum_rekap" class="col-md-5 col-form-label">Jumlah Pasien UMUM</label>
                  <div class="col-md-7 input-group">
                    <input type="text" name="umum_rekap" id="umum_rekap" class="form-control" required autocomplete="off" onFocus="startCalc();" onBlur="stopCalc();" onkeypress="return angka(event)">
                    <div class="input-group-append">
                      <span class="input-group-text">Orang</span>
                    </div>
                  </div>
                </div>
                <!-- Jumlah Pasien Bpjs -->
                <div class="form-group row">
                  <label for="bpjs_rekap" class="col-md-5 col-form-label">Jumlah Pasien BPJS</label>
                  <div class="col-md-7 input-group">
                    <input type="text" name="bpjs_rekap" id="bpjs_rekap" class="form-control" required autocomplete="off" onFocus="startCalc();" onBlur="stopCalc();" onkeypress="return angka(event)">
                    <div class="input-group-append">
                      <span class="input-group-text">Orang</span>
                    </div>
                  </div>
                </div>
                <!-- Jumlah Pasien Aqua -->
                <div class="form-group row">
                  <label for="aqua_rekap" class="col-md-5 col-form-label">Jumlah Pasien AQUA</label>
                  <div class="col-md-7 input-group">
                    <input type="text" name="aqua_rekap" id="aqua_rekap" class="form-control" required autocomplete="off" onFocus="startCalc();" onBlur="stopCalc();" onkeypress="return angka(event)">
                    <div class="input-group-append">
                      <span class="input-group-text">Orang</span>
                    </div>
                  </div>
                </div>
                <!-- Jumlah Total Pasien -->
                <div class="form-group row">
                  <label for="total_rekap" class="col-md-5 col-form-label">Total Kunjungan</label>
                  <div class="col-md-7 input-group">
                    <input type="text" name="total_rekap" id="total_rekap" class="form-control" readonly>
                    <div class="input-group-append">
                      <span class="input-group-text">Orang</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 text-right">
                <hr style="margin-top: 0px;">
                <button type="submit" name="btn_simpan_rekap" id="btn_simpan_rekap" class="btn btn-success" style="width: 110px;">
                  <i class="fas fa-save"></i>&ensp;Simpan
                </button>
                &ensp;
                <button type="reset" name="reset_rekap" id="reset_rekap" class="btn btn-danger" style="width: 110px;">
                  <i class="fas fa-times"></i>&ensp;Batal
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /Tambah Data Rekap Medis -->

<script>
  function startCalc() {
    interval = setInterval("calc()", 1);
  }

  function calc() {
    umum = document.autoSumForm.umum_rekap.value;
    bpjs = document.autoSumForm.bpjs_rekap.value;
    aqua = document.autoSumForm.aqua_rekap.value;
    document.autoSumForm.total_rekap.value = (umum * 1) + (bpjs * 1) + (aqua * 1);
  }

  function stopCalc() {
    clearInterval(interval);
  }
</script>