<?php

$id         = $pm["id_param"];
$paramedis  = query("SELECT * FROM tabel_paramedis WHERE id_param = '$id'")[0];

// Simpan Ubah Data
if (isset($_POST["btn_ubah_param"])) {
  if (ubah_paramedis($_POST) > 0) {
    echo "<script>alert ('Perubahan data paramedis berhasil!'); document.location.href = 'master-paramedis.php';</script>";
  } else {
    echo "<script>alert ('Perubahan data paramedis gagal!'); document.location.href = 'master-paramedis.php';</script>";
  }
}

?>
<!-- Modal Ubah Paramedis -->
<div class="modal fade" id="ubah_param<?= $paramedis["id_param"]; ?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Ubah Data Paramedis</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- /Modal Header -->
      <!-- Modal Body -->
      <form action="" method="post">
        <div class="modal-body row">
          <div class="col-md-12">
            <!-- ID Paramedis -->
            <div class="form-group row">
              <label for=id_param" class="col-md-4 col-form-label">ID Paramedis</label>
              <div class="col-md-8">
                <input type="text" name="id_param" id="id_param" class="form-control" value="<?= $paramedis["id_param"]; ?>" readonly>
              </div>
            </div>
            <!-- Nama Paramedis -->
            <div class="form-group row">
              <label for="nm_paramedis" class="col-md-4 col-form-label">Nama Paramedis</label>
              <div class="col-md-8">
                <input type="text" name="nm_param" id="nm_param" class="form-control text-lowercase" value="<?= $paramedis["nama_param"]; ?>" required autocomplete="off">
              </div>
            </div>
            <!-- Jenis Kelamin Paramedis -->
            <div class="form-group row">
              <label class="col-md-4 col-form-label">Jenis Kelamin</label>
              <div class="col-md-8 mt-2">
                <?php
                $laki_laki = ($paramedis["jns_kelamin_param"] == "Laki-Laki") ? "checked" : "";
                $perempuan = ($paramedis["jns_kelamin_param"] == "Perempuan") ? "checked" : "";
                ?>
                <div class="form-check form-check-inline">
                  <input type="radio" name="jk_param" id="laki-laki" value="Laki-Laki" class="form-check-input" <?= $laki_laki; ?> required>
                  <label for="laki-laki" class="form-check-label">Laki-laki</label>
                </div>
                <div class="form-check form-check-inline">
                  <input type="radio" name="jk_param" id="perempuan" value="Perempuan" class="form-check-input" <?= $perempuan; ?> required>
                  <label for="perempuan" class="form-check-label">Perempuan</label>
                </div>
              </div>
            </div>
            <!-- Alamat Paramedis -->
            <div class="form-group row">
              <label for="almt_param" class="col-md-4 col-form-label">Alamat Paramedis</label>
              <div class="col-md-8">
                <input type="text" name="almt_param" id="almt_param" class="form-control text-lowercase" value="<?= $paramedis["alamat_param"]; ?>" required autocomplete="off">
              </div>
            </div>
            <!-- Telepon Paramedis -->
            <div class="form-group row">
              <label for="telp_param" class="col-md-4 col-form-label">Telepon Paramedis</label>
              <div class="col-md-8">
                <input type="text" name="telp_param" id="telp_param" class="form-control" value="<?= $paramedis["telepon_param"]; ?>" required autocomplete="off" onkeypress="return angka(event)">
              </div>
            </div>
            <hr>
          </div>
          <div class="col-md-12 text-right">
            <button type="submit" name="btn_ubah_param" id="btn_ubah_param" class="btn btn-success" style="width: 100px;">
              <i class="fas fa-save"></i>&ensp;Simpan
            </button>
          </div>
        </div>
      </form>
      <!-- /Modal Body -->
    </div>
  </div>
</div>
<!-- /Modal Ubah Paramedis -->