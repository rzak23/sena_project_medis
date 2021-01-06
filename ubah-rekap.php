<?php
$id     = $_GET["id"];
$rekap  = query("SELECT rk.*, dr.* FROM 
                  (tabel_rekap rk INNER JOIN tabel_dokter dr 
                  ON rk.id_dokter = dr.id_dokter)
                WHERE rk.id_rekap = '$id'")[0];

// Simpan Data Rekap
if (isset($_POST["btn_ubah_rekap"])) {
  if (ubah_rekap($_POST) > 0) {
    echo "<script>alert ('Perubahan Data Rekap Berhasil!'); document.location.href = 'rekap-medis.php';</script>";
  } else {
    echo "<script>alert ('Perubahan Data Rekap Gagal!'); document.location.href = 'rekap-medis.php';</script>";
  }
}

?>
<!-- Ubah Data Rekap Medis -->
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Ubah Data Rekap Medis</h5>
      </div>
      <div class="card-body row">
        <div class="col-md-12">
          <form action="" method="post" name="autoSumForm">
            <div class="row form-horizontal">
              <div class="col-md-5">
                <input type="text" name="id_rekap" id="id_rekap" value="<?= $rekap["id_rekap"]; ?>" hidden>
                <!-- Tanggal Rekap -->
                <div class="form-group row">
                  <label for="tgl_rekap" class="col-md-4 col-form-label">Tanggal Rekap</label>
                  <div class="col-md-8">
                    <input type="date" name="tgl_rekap" id="tgl_rekap" class="form-control" value="<?= $rekap["tanggal_rekap"]; ?>" required autocomplete="off" readonly>
                  </div>
                </div>
                <!-- Shift Jaga -->
                <div class="form-group row">
                  <label for="shift_rekap" class="col-md-4 col-form-label">Shift Jaga</label>
                  <div class="col-md-8">
                    <select name="shift_rekap" id="shift_rekap" class="js-example-placeholder-single js-states form-control" required>
                      <option></option>
                      <?php
                      $select1 = ($rekap["shift_rekap"] == "Pagi") ? "selected" : "";
                      $select2 = ($rekap["shift_rekap"] == "Sore") ? "selected" : "";
                      $select3 = ($rekap["shift_rekap"] == "Malam") ? "selected" : "";
                      ?>
                      <option value="Pagi" <?= $select1; ?>>Pagi</option>
                      <option value="Sore" <?= $select2; ?>>Sore</option>
                      <option value="Malam" <?= $select3; ?>>Malam</option>
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
                        <?php $select = ($rekap["id_dokter"] == $dr["id_dokter"]) ? "selected" : ""; ?>
                        <option value="<?= $dr["id_dokter"]; ?>" <?= $select; ?>><?= $dr["nama_dokter"]; ?></option>
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
                    <input type="text" name="biaya_rekap" id="biaya_rekap" class="form-control" value="<?= number_format($rekap["total_biaya"], 0, ".", "."); ?>" required autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                  </div>
                </div>
              </div>
              <div class="col-md-2"></div>
              <div class="col-md-5">
                <!-- Jumlah Pasien Umum -->
                <div class="form-group row">
                  <label for="umum_rekap" class="col-md-5 col-form-label">Jumlah Pasien UMUM</label>
                  <div class="col-md-7 input-group">
                    <input type="text" name="umum_rekap" id="umum_rekap" class="form-control" value="<?= $rekap["pasien_umum"]; ?>" required autocomplete="off" onFocus="startCalc();" onBlur="stopCalc();" onkeypress="return angka(event)">
                    <div class="input-group-append">
                      <span class="input-group-text">Orang</span>
                    </div>
                  </div>
                </div>
                <!-- Jumlah Pasien Bpjs -->
                <div class="form-group row">
                  <label for="bpjs_rekap" class="col-md-5 col-form-label">Jumlah Pasien BPJS</label>
                  <div class="col-md-7 input-group">
                    <input type="text" name="bpjs_rekap" id="bpjs_rekap" class="form-control" value="<?= $rekap["pasien_bpjs"]; ?>" required autocomplete="off" onFocus="startCalc();" onBlur="stopCalc();" onkeypress="return angka(event)">
                    <div class="input-group-append">
                      <span class="input-group-text">Orang</span>
                    </div>
                  </div>
                </div>
                <!-- Jumlah Pasien Aqua -->
                <div class="form-group row">
                  <label for="aqua_rekap" class="col-md-5 col-form-label">Jumlah Pasien AQUA</label>
                  <div class="col-md-7 input-group">
                    <input type="text" name="aqua_rekap" id="aqua_rekap" class="form-control" value="<?= $rekap["pasien_aqua"]; ?>" required autocomplete="off" onFocus="startCalc();" onBlur="stopCalc();" onkeypress="return angka(event)">
                    <div class="input-group-append">
                      <span class="input-group-text">Orang</span>
                    </div>
                  </div>
                </div>
                <!-- Jumlah Total Pasien -->
                <div class="form-group row">
                  <label for="total_rekap" class="col-md-5 col-form-label">Total Kunjungan</label>
                  <div class="col-md-7 input-group">
                    <input type="text" name="total_rekap" id="total_rekap" class="form-control" value=" <?= $rekap["kunjungan"]; ?>" readonly>
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
                <button type="submit" name="btn_ubah_rekap" id="btn_ubah_rekap" class="btn btn-success" style="width: 110px;">
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
<!-- /Ubah Data Rekap Medis -->

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