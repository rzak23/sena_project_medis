<?php

// Ambil Data ID Tabel
$id         = $pg["id_pengguna"];
$pengguna   = query("SELECT * FROM tabel_pengguna WHERE id_pengguna = '$id'")[0];
// Simpan Lupa Kata Sandi
if (isset($_POST["btn_simpan_sandibaru"]) > 0) {
  if (sandi_pengguna($_POST)) {
    echo "<script>alert ('Penggantian kata sandi baru berhasil!'); document.location.href = 'master-pengguna.php';</script>";
  } else {
    echo "<script>alert ('Penggantian kata sandi baru gagal!'); document.location.href = 'master-pengguna.php';</script>";
  }
}

?>
<!-- Modal Lupa Kata Sandi -->
<div class="modal fade" id="lupa_sandi<?= $id; ?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Kata Sandi Baru</h5>
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
            <input type="text" name="id_pengguna" id="id_pengguna" class="form-control" value="<?= $pengguna["id_pengguna"]; ?>" hidden>
            <!-- Username Pengguna -->
            <div class="form-group row">
              <label class="col-md-5 col-form-label">Nama Pengguna</label>
              <div class="col-md-7 input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-at"></i></span>
                </div>
                <input type="text" class="form-control" value="<?= $pengguna["nama_pengguna"]; ?>" readonly>
              </div>
            </div>
            <!-- Tipe Pengguna -->
            <div class="form-group row">
              <label class="col-md-5 col-form-label">Tipe Pengguna</label>
              <div class="col-md-7">
                <input type="text" class="form-control" value="<?= $pengguna["tipe_pengguna"]; ?>" readonly>
              </div>
            </div>
            <!-- Password 1 -->
            <div class="form-group row">
              <label for="pass_new" class="col-md-5 col-form-label">Kata Sandi Baru</label>
              <div class="col-md-7">
                <input type="text" name="pass_new" id="pass_new" class="form-control" required autocomplete="off">
              </div>
            </div>
            <!-- Konfirmasi Password -->
            <div class="form-group row">
              <label for="confirm_newpass" class="col-md-5 col-form-label">Konfirm Kata Sandi</label>
              <div class="col-md-7">
                <input type="text" name="confirm_newpass" id="confirm_newpass" class="form-control" required autocomplete="off">
              </div>
            </div>
            <hr>
          </div>
          <div class="col-md-12 text-right">
            <button type="submit" name="btn_simpan_sandibaru" id="btn_simpan_sandibaru" class="btn btn-success" style="width: 100px;">
              <i class="fas fa-save"></i>&ensp;Simpan
            </button>
          </div>
        </div>
      </form>
      <!-- /Modal Body -->
    </div>
  </div>
</div>
<!-- /Modal Lupa Kata Sandi -->