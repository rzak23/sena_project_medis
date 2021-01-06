<?php

$id       = $dr["id_dokter"];
$dokter = query("SELECT * FROM tabel_dokter WHERE id_dokter = '$id'")[0];

// Simpan Ubah Data
if (isset($_POST["btn_ubah_dokter"])) {
  if (ubah_dokter($_POST) > 0) {
    echo "<script>alert ('Perubahan data dokter berhasil!'); document.location.href = 'master-dokter.php';</script>";
  } else {
    echo "<script>alert ('Perubahan data dokter gagal!'); document.location.href = 'master-dokter.php';</script>";
  }
}

?>
<!-- Modal Ubah Dokter -->
<div class="modal fade" id="ubah_dokter<?= $id; ?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Ubah Data Dokter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- /Modal Header -->
      <!-- Modal Body -->
      <form action="" method="post">
        <div class="modal-body row">
          <div class="col-md-12">
            <!-- ID Dokter -->
            <div class="form-group row">
              <label for="id_dokter" class="col-md-4 col-form-label">ID Dokter</label>
              <div class="col-md-8">
                <input type="text" name="id_dokter" id="id_dokter" class="form-control" value="<?= $dokter["id_dokter"]; ?>" readonly>
              </div>
            </div>
            <!-- Nama Dokter -->
            <div class="form-group row">
              <label for="nm_dokter" class="col-md-4 col-form-label">Nama Dokter</label>
              <div class="col-md-8">
                <input type="text" name="nm_dokter" id="nm_dokter" class="form-control text-lowercase" value="<?= $dokter["nama_dokter"]; ?>" required autocomplete="off">
              </div>
            </div>
            <!-- Jenis Kelamin Dokter -->
            <div class="form-group row">
              <label class="col-md-4 col-form-label">Jenis Kelamin</label>
              <div class="col-md-8 mt-2">
                <?php
                $laki_laki = ($dokter["jns_kelamin_dokter"] == "Laki-Laki") ? "checked" : "";
                $perempuan = ($dokter["jns_kelamin_dokter"] == "Perempuan") ? "checked" : "";
                ?>
                <div class="form-check form-check-inline">
                  <input type="radio" name="jk_dokter" id="laki-laki" class="form-check-input" value="Laki-Laki" <?= $laki_laki; ?> required>
                  <label for="laki-laki" class="form-check-label">Laki-laki</label>
                </div>
                <div class="form-check form-check-inline">
                  <input type="radio" name="jk_dokter" id="perempuan" class="form-check-input" value="Perempuan" <?= $perempuan; ?> required>
                  <label for="perempuan" class="form-check-label">Perempuan</label>
                </div>
              </div>
            </div>
            <!-- Alamat Dokter -->
            <div class="form-group row">
              <label for="almt_dokter" class="col-md-4 col-form-label">Alamat Dokter</label>
              <div class="col-md-8">
                <input type="text" name="almt_dokter" id="almt_dokter" class="form-control text-lowercase" value="<?= $dokter["alamat_dokter"]; ?>" required autocomplete="off">
              </div>
            </div>
            <!-- Telepon Dokter -->
            <div class="form-group row">
              <label for="telp_dokter" class="col-md-4 col-form-label">Telepon Dokter</label>
              <div class="col-md-8">
                <input type="text" name="telp_dokter" id="telp_dokter" class="form-control" value="<?= $dokter["telepon_dokter"]; ?>" required autocomplete="off" onkeypress="return angka(event)">
              </div>
            </div>
            <hr>
          </div>
          <div class="col-md-12 text-right">
            <button type="submit" name="btn_ubah_dokter" id="btn_ubah_dokter" class="btn btn-success" style="width: 100px;">
              <i class="fas fa-save"></i>&ensp;Simpan
            </button>
          </div>
        </div>
      </form>
      <!-- /Modal Body -->
    </div>
  </div>
</div>
<!-- /Modal Ubah Dokter -->