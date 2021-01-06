<?php
// Set Waktu
date_default_timezone_set('Asia/Kuala_Lumpur');
$tgl_pengeluaran    = date("Y-m-d");
// Konfigurasi Buat ID Pengeluaran
$tanggal            = date("ymd");
// => Cek ID Pengeluaran
$cari_id            = mysqli_query($koneksi, "SELECT id_pengeluaran FROM tabel_pengeluaran") or die(mysqli_error(""));
$data_id            = mysqli_fetch_array($cari_id);
$jumlah             = mysqli_num_rows($cari_id);
// => Buat Id Pengeluaran
if ($data_id) {
  $id               = (int) $jumlah;
  $id               = $jumlah + 1;
  $id_pengeluaran   = "$tanggal" . "09" . str_pad($id, 4, "0", STR_PAD_LEFT);
} else {
  $id_pengeluaran   = "$tanggal" . "09" . "0001";
}

// Simpan Tambah Data Pengeluaran
if (isset($_POST["btn_simpan_pengeluaran"])) {
  if (tambah_pengeluaran($_POST) > 0) {
    echo "<script>alert ('Penambahan data pengeluaran berhasil!'); document.location.href = 'pengeluaran-medis.php';</script>";
  } else {
    echo "<script>alert ('Penambahan data pengeluaran gagal!'); document.location.href = 'pengeluaran-medis.php';</script>";
  }
}
?>
<!-- Modal Tambah Pengeluaran -->
<div class="offset-3"></div>
<div class="col-md-6">
  <div class="card">
    <div class="card-header">
      <h5 class="card-title">Tambah Data Pengeluaran Medis</h5>
    </div>
    <div class="card-body">
      <form action="" method="post" name="autoSumForm">
        <div class="row">
          <div class="col-md-12">
            <!-- ID Pengeluaran -->
            <div class="row form-group">
              <label for="id_pengeluaran" class="col-md-5 col-form-label">ID Pengeluaran</label>
              <div class="col-md-7">
                <input type="text" name="id_pengeluaran" id="id_pengeluaran" class="form-control" value="<?= $id_pengeluaran; ?>" readonly>
              </div>
            </div>
            <!-- Tanggal Pengeluaran -->
            <div class="row form-group">
              <label for="tgl_pengeluaran" class="col-md-5 col-form-label">Tanggal Pengeluaran</label>
              <div class="col-md-7">
                <input type="date" name="tgl_pengeluaran" id="tgl_pengeluaran" class="form-control" value="<?= $tgl_pengeluaran; ?>" required>
              </div>
            </div>
            <!-- Biaya Pengeluaran Obat -->
            <div class="row form-group">
              <label for="biaya_obat" class="col-md-5 col-form-label">Biaya Pengeluaran Obat</label>
              <div class="col-md-7 input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Rp.</span>
                </div>
                <input type="text" name="biaya_obat" id="biaya_obat" class="form-control" value="" required autocomplete="off" onFocus="startCalc();" onBlur="stopCalc();" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
              </div>
            </div>
            <!-- Biaya Gaji Pegawai -->
            <div class="row form-group">
              <label for="biaya_gaji" class="col-md-5 col-form-label">Biaya Pengeluaran Gaji</label>
              <div class="col-md-7 input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Rp.</span>
                </div>
                <input type="text" name="biaya_gaji" id="biaya_gaji" class="form-control" value="" required autocomplete="off" onFocus="startCalc();" onBlur="stopCalc();" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
              </div>
            </div>
            <!-- Biaya Pengeluaran Harian -->
            <div class="row form-group">
              <label for="biaya_harian" class="col-md-5 col-form-label">Biaya Pengeluaran Harian</label>
              <div class="col-md-7 input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Rp.</span>
                </div>
                <input type="text" name="biaya_harian" id="biaya_harian" class="form-control" value="" required autocomplete="off" onFocus="startCalc();" onBlur="stopCalc();" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
              </div>
            </div>
            <!-- Total Biaya Pengeluaran -->
            <div class="row form-group">
              <label for="total_pengeluaran" class="col-md-5 col-form-label">Total Biaya Pengeluaran</label>
              <div class="col-md-7 input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Rp.</span>
                </div>
                <input type="text" name="total_pengeluaran" id="total_pengeluaran" class="form-control" value="" readonly>
              </div>
            </div>
            <hr style="margin-top: 0px;">
            <div class="row">
              <div class="col-md-6 text-left">
                <button type="reset" name="btn_reset_pengeluaran" id="btn_reset_pengeluaran" class="btn btn-info" style="width: 110px;">
                  <i class="fas fa-retweet"></i>&emsp;Reset
                </button>
              </div>
              <div class="col-md-6 text-right">
                <button type="submit" name="btn_simpan_pengeluaran" id="btn_simpan_pengeluaran" class="btn btn-success" style="width: 110px;">
                  <i class="fas fa-save"></i>&emsp;Simpan
                </button>
                <a href="?" name="btn_reset_pengeluaran" id="btn_reset_pengeluaran" class="btn btn-danger" style="width: 110px;">
                  <i class="fas fa-times"></i>&emsp;Batal
                </a>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="offset-3"></div>
<!-- Modal /Tambah Pengeluaran -->
<script>
  function startCalc() {
    interval = setInterval('calc()', 1);
  }

  function calc() {
    obat = bersihPemisah(document.autoSumForm.biaya_obat.value);
    gaji = bersihPemisah(document.autoSumForm.biaya_gaji.value);
    harian = bersihPemisah(document.autoSumForm.biaya_harian.value);
    hitung_total = (obat * 1) + (gaji * 1) + (harian * 1);
    document.autoSumForm.total_pengeluaran.value = tandaPemisahTitik(hitung_total);
  }

  function stopCalc() {
    clearInterval(interval);
  }
</script>