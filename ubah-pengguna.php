<?php

// Ambil Data ID Tabel
$id       = $pg["id_pengguna"];
$pengguna = query("SELECT * FROM tabel_pengguna WHERE id_pengguna = '$id'")[0];
// Simpan Ubah Data Pengguna
if (isset($_POST["btn_ubah_pengguna"]) > 0) {
  if (ubah_pengguna($_POST)) {
    echo "<script>alert ('Perubahan data pengguna berhasil!'); document.location.href = 'master-pengguna.php';</script>";
  } else {
    echo "<script>alert ('Perubahan data pengguna gagal!'); document.location.href = 'master-pengguna.php';</script>";
  }
}

?>
<!-- Modal Ubah Pengguna -->
<div class="modal fade" id="ubah_pengguna<?= $id; ?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Ubah Data Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- /Modal Header -->
      <!-- Modal Body -->
      <form action="" method="post">
        <div class="modal-body row">
          <div class="col-md-12">
            <!-- ID Pengguna -->
            <div class="form-group row">
              <label for="id_pengguna" class="col-md-5 col-form-label">ID Pengguna</label>
              <div class="col-md-7">
                <input type="text" name="id_pengguna" id="id_pengguna" class="form-control" value="<?= $pengguna["id_pengguna"]; ?>" readonly>
              </div>
            </div>
            <!-- Tanggal Daftar -->
            <div class="form-group row">
              <label class="col-md-5 col-form-label">Tanggal Daftar</label>
              <div class="col-md-7">
                <input type="date" class="form-control" value="<?= $pengguna["tanggal_pengguna"]; ?>" readonly>
              </div>
            </div>
            <!-- Username Pengguna -->
            <div class="form-group row">
              <label for="username_pengguna" class="col-md-5 col-form-label">Nama Pengguna</label>
              <div class="col-md-7 input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-at"></i></span>
                </div>
                <input type="text" name="username_pengguna" id="username_pengguna" class="form-control text-lowercase" value="<?= $pengguna["nama_pengguna"]; ?>" required autocomplete="off">
              </div>
            </div>
            <!-- Tipe Pengguna -->
            <div class="form-group row">
              <label for="tipe_pengguna" class="col-md-5 col-form-label">Tipe Pengguna</label>
              <div class="col-md-7">
                <select name="tipe_pengguna" id="tipe_pengguna" class="js-example-placeholder-single js-states form-control" required>
                  <option value="Admin" <?php if ($pengguna["tipe_pengguna"] == "ADMIN") {
                                          echo "selected";
                                        } ?>>ADMIN</option>
                  <option value="Dokter" <?php if ($pengguna["tipe_pengguna"] == "DOKTER") {
                                            echo "selected";
                                          } ?>>DOKTER</option>
                  <option value="Paramedis" <?php if ($pengguna["tipe_pengguna"] == "PARAMEDIS") {
                                              echo "selected";
                                            } ?>>PARAMEDIS</option>
                </select>
              </div>
            </div>
            <!-- Kode Keamanan -->
            <div class="form-group row">
              <label class="col-md-5 col-form-label">Kode Keamanan</label>
              <div class="col-md-5 input-group">
                <input type="text" class="form-control" value="<?= $pengguna["kode_keamanan"]; ?>" disabled>
                <div class="input-group-append">
                  <span class="input-group-text bg-info">Kode Anda</span>
                </div>
              </div>
            </div>
            <hr>
          </div>
          <div class="col-md-12 text-right">
            <button type="submit" name="btn_ubah_pengguna" id="btn_ubah_pengguna" class="btn btn-success" style="width: 100px;">
              <i class="fas fa-save"></i>&ensp;Simpan
            </button>
          </div>
        </div>
      </form>
      <!-- /Modal Body -->
    </div>
  </div>
</div>
<!-- /Modal Ubah Pengguna -->