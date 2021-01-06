<?php

$id       = $dr["id_dokter"];
$dokter   = query("SELECT id_dokter, nama_dokter FROM tabel_dokter WHERE id_dokter = '$id'")[0];

// Simpan Hapus Data
if (isset($_POST["btn_hapus_dokter"])) {
  if (hapus_dokter($_POST) > 0) {
    echo "<script>alert ('Penghapusan data dokter berhasil!'); document.location.href = 'master-dokter.php';</script>";
  } else {
    echo "<script>alert ('Penghapusan data dokter gagal!'); document.location.href = 'master-dokter.php';</script>";
  }
}
?>
<!-- Modal Hapus Dokter -->
<div class="modal fade" id="hapus_dokter<?= $id; ?>">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Hapus Data Dokter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- /Modal Header -->
      <!-- Modal Body -->
      <form action="" method="post">
        <div class="modal-body row">
          <div class="col-md-12 text-center">
            <input type="text" name="id_dokter" id="id_dokter" value="<?= $dokter["id_dokter"]; ?>" hidden>
            <p class="text-bold">Anda akan menghapus data</p>
            <p class="text-bold text-danger"><?= $dokter["nama_dokter"]; ?> ?</p>
            <hr>
          </div>
          <div class="col-md-12 text-right">
            <button type="submit" name="btn_hapus_dokter" id="btn_hapus_dokter" class="btn btn-success" style="width: 100px;">
              <i class="fas fa-check-circle"></i>&emsp;Iya
            </button>
          </div>
        </div>
      </form>
      <!-- /Modal Body -->
    </div>
  </div>
</div>
<!-- /Modal Hapus Dokter -->