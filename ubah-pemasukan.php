<?php
$id       = $_GET["id"];
$data_pk  = query("SELECT * FROM tabel_pemasukan WHERE id_pemasukan = '$id'")[0];

// Simpan Ubah Data Pemasukan
if (isset($_POST["btn_ubah_pemasukan"]) > 0) {
  if (ubah_pemasukan($_POST)) {
    echo "<script>alert ('Perubahan data pemasukan berhasil!'); document.location.href = 'pemasukan-medis.php';</script>";
  } else {
    echo "<script>alert ('Perubahan data pemasukan gagal!'); document.location.href = 'pemasukan-medis.php';</script>";
  }
}
?>
<!-- Modal Ubah Pemasukan -->
<div class="offset-3"></div>
<div class="col-md-6">
  <div class="card">
    <div class="card-header">
      <h5 class="card-title">Ubah Data Pemasukan Medis</h5>
    </div>
    <div class="card-body">
      <form action="" method="post" name="autoSumForm">
        <div class="row">
          <div class="col-md-12">
            <!-- ID Pemasukan -->
            <div class="row form-group">
              <label for="id_pemasukan" class="col-md-5 col-form-label">ID Pemasukan</label>
              <div class="col-md-7">
                <input type="text" name="id_pemasukan" id="id_pemasukan" class="form-control" value="<?= $data_pk["id_pemasukan"]; ?>" readonly>
              </div>
            </div>
            <!-- Tanggal Pemasukan -->
            <div class="row form-group">
              <label for="tgl_pemasukan" class="col-md-5 col-form-label">Tanggal Pemasukan</label>
              <div class="col-md-7">
                <input type="date" name="tgl_pemasukan" id="tgl_pemasukan" class="form-control" value="<?= $data_pk["tanggal_pemasukan"]; ?>" required>
              </div>
            </div>
            <!-- Total Pemasukan UMUM -->
            <div class="row form-group">
              <label for="biaya_umum" class="col-md-5 col-form-label">Pemasukan Bill UMUM</label>
              <div class="col-md-7 input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Rp.</span>
                </div>
                <input type="text" name="biaya_umum" id="biaya_umum" class="form-control" value="<?= number_format($data_pk["biaya_umum"], 0, ".", "."); ?>" required autocomplete="off" onFocus="startCalc();" onBlur="stopCalc();" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
              </div>
            </div>
            <!-- Total Pemasukan BPJS -->
            <div class="row form-group">
              <label for="biaya_bpjs" class="col-md-5 col-form-label">Pemasukan Bill BPJS</label>
              <div class="col-md-7 input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Rp.</span>
                </div>
                <input type="text" name="biaya_bpjs" id="biaya_bpjs" class="form-control" value="<?= number_format($data_pk["biaya_bpjs"], 0, ".", "."); ?>" required autocomplete="off" onFocus="startCalc();" onBlur="stopCalc();" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
              </div>
            </div>
            <!-- Total Pemasukan AQUA -->
            <div class="row form-group">
              <label for="biaya_aqua" class="col-md-5 col-form-label">Pemasukan Bill AQUA</label>
              <div class="col-md-7 input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Rp.</span>
                </div>
                <input type="text" name="biaya_aqua" id="biaya_aqua" class="form-control" value="<?= number_format($data_pk["biaya_aqua"], 0, ".", "."); ?>" required autocomplete="off" onFocus="startCalc();" onBlur="stopCalc();" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
              </div>
            </div>
            <!-- Total Semua Pemasukan -->
            <div class="row form-group">
              <label for="total_pemasukan" class="col-md-5 col-form-label">Total Pemasukan Bill</label>
              <div class="col-md-7 input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Rp.</span>
                </div>
                <input type="text" name="total_pemasukan" id="total_pemasukan" class="form-control" value="<?= number_format($data_pk["total_pemasukan"], 0, ".", "."); ?>" readonly>
              </div>
            </div>
            <hr style="margin-top: 0px;">
            <div class="row">
              <div class="col-md-12 text-right">
                <button type="submit" name="btn_ubah_pemasukan" id="btn_ubah_pemasukan" class="btn btn-success" style="width: 110px;">
                  <i class="fas fa-save"></i>&emsp;Simpan
                </button>
                <a href="?" name="btn_reset_pemasukan" id="btn_reset_pemasukan" class="btn btn-danger" style="width: 110px;">
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
<!-- /Modal Ubah Pemasukan -->
<script>
  function startCalc() {
    interval = setInterval("calc()", 1);
  }

  function calc() {
    umum = bersihPemisah(document.autoSumForm.biaya_umum.value);
    bpjs = bersihPemisah(document.autoSumForm.biaya_bpjs.value);
    aqua = bersihPemisah(document.autoSumForm.biaya_aqua.value);
    hitung_total = (umum * 1) + (bpjs * 1) + (aqua * 1);
    document.autoSumForm.total_pemasukan.value = tandaPemisahTitik(hitung_total);
  }

  function stopCalc() {
    clearInterval(interval);
  }
</script>