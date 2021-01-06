<?php

$id       = $ps["id_pasien"];
$pasien   = query("SELECT * FROM tabel_pasien WHERE id_pasien = '$id'")[0];

// Simpan Ubah Data Pasien
if (isset($_POST["btn_ubah_pasien"])) {
  if (ubah_pasien($_POST) > 0) {
    echo "<script>alert ('Perubahan data pasein berhasil!'); document.location.href = 'master-pasien.php';</script>";
  } else {
    echo "<script>alert ('Perubahan data pasein gagal!'); document.location.href = 'master-pasien.php';</script>";
  }
}

?>
<!-- Modal Ubah Pasien -->
<div class="modal fade" id="ubah_pasien<?= $pasien["id_pasien"]; ?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Ubah Data Pasien</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- /Modal Header -->
      <!-- Modal Body -->
      <form action="" method="post">
        <div class="modal-body row">
          <div class="col-md-12">
            <!-- ID Pasien -->
            <div class="form-group row">
              <label for="id_pasien" class="col-md-4 col-form-label">ID Pasien</label>
              <div class="col-md-8">
                <input type="text" name="id_pasien" id="id_pasien" class="form-control" value="<?= $pasien["id_pasien"]; ?>" readonly>
              </div>
            </div>
            <!-- Nama Pasien -->
            <div class="form-group row">
              <label for="nm_pasien" class="col-md-4 col-form-label">Nama Pasien</label>
              <div class="col-md-8">
                <input type="text" name="nm_pasien" id="nm_pasien" class="form-control text-lowercase" value="<?= $pasien["nama_pasien"]; ?>" required autocomplete="off">
              </div>
            </div>
            <!-- Jenis Kelamin Pasien -->
            <div class="form-group row">
              <label class="col-md-4 col-form-label">Jenis Kelamin</label>
              <div class="col-md-8 mt-2">
                <?php
                $laki_laki = ($pasien["jns_kelamin_pasien"] == "Laki-Laki") ? "checked" : "";
                $perempuan = ($pasien["jns_kelamin_pasien"] == "Perempuan") ? "checked" : "";
                ?>
                <div class="form-check form-check-inline">
                  <input type="radio" name="jk_pasien" id="laki-laki" class="form-check-input" value="Laki-Laki" <?= $laki_laki; ?> required>
                  <label for="laki-laki" class="form-check-label">Laki-laki</label>
                </div>
                <div class="form-check form-check-inline">
                  <input type="radio" name="jk_pasien" id="perempuan" class="form-check-input" value="Perempuan" <?= $perempuan; ?> required>
                  <label for="perempuan" class="form-check-label">Perempuan</label>
                </div>
              </div>
            </div>
            <!-- Umur Pasien -->
            <div class="form-group row">
              <label for="umur_pasien" class="col-md-4 col-form-label">Umur Pasien</label>
              <div class="col-md-4 input-group">
                <input type="text" name="umur_pasien" id="umur_pasien" class="form-control" value="<?= $pasien["umur_pasien"]; ?>" required autocomplete="off" onkeypress="return angka(event)">
                <div class="input-group-append">
                  <span class="input-group-text">Tahun</span>
                </div>
              </div>
            </div>
            <!-- Alamat Pasien -->
            <div class="form-group row">
              <label for="almt_pasien" class="col-md-4 col-form-label">Alamat Pasien</label>
              <div class="col-md-8">
                <input type="text" name="almt_pasien" id="almt_pasien" class="form-control text-lowercase" value="<?= $pasien["alamat_pasien"]; ?>" required autocomplete="off">
              </div>
            </div>
            <hr>
          </div>
          <div class="col-md-12 text-right">
            <button type="submit" name="btn_ubah_pasien" id="btn_ubah_pasien" class="btn btn-success" style="width: 100px;">
              <i class="fas fa-save"></i>&ensp;Simpan
            </button>
          </div>
        </div>
      </form>
      <!-- /Modal Body -->
    </div>
  </div>
</div>
<!-- /Modal Ubah Pasien -->