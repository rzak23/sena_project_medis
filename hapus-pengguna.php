<?php

$id       = $pg["id_pengguna"];
$pengguna = query("SELECT * FROM tabel_pengguna WHERE id_pengguna = '$id'")[0];

// Simpan Penghapusan Data Pengguna
if (isset($_POST["btn_hapus_pengguna"]) > 0) {
  if (hapus_pengguna($_POST)) {
    echo "<script>alert ('Penghapusan data pengguna berhasil!'); document.location.href = 'master-pengguna.php';</script>";
  } else {
    echo "<script>alert ('Penghapusan data pengguna gagal!'); document.location.href = 'master-pengguna.php';</script>";
  }
}

?>
<!-- Modal Hapus Pengguna -->
<div class="modal fade" id="hapus_pengguna<?= $id; ?>">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Hapus Data Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- /Modal Header -->
      <!-- Modal Body -->
      <form action="" method="post">
        <div class="modal-body row">
          <div class="col-md-12 text-center">
            <input type="text" name="id_pengguna" id="id_pengguna" value="<?= $pengguna["id_pengguna"]; ?>" hidden>
            <p class="text-bold">Anda akan menghapus data</p>
            <p class="text-bold">Nama pengguna : <span class="text-danger"><?= $pengguna["nama_pengguna"]; ?></span> ?</p>
            <hr>
          </div>
          <div class="col-md-12 text-right">
            <button type="submit" name="btn_hapus_pengguna" id="btn_hapus_pengguna" class="btn btn-success" style="width: 100px;">
              <i class="fas fa-check-circle"></i>&emsp;Iya
            </button>
          </div>
        </div>
      </form>
      <!-- /Modal Body -->
    </div>
  </div>
</div>
<!-- /Modal Hapus Pengguna -->