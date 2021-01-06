<?php

$id         = $pm["id_param"];
$paramedis  = query("SELECT id_param, nama_param FROM tabel_paramedis WHERE id_param = '$id'")[0];

// Simpan Hapus Data Paramedis
if (isset($_POST["btn_hapus_param"])) {
  if (hapus_paramedis($_POST) > 0) {
    echo "<script>alert ('Penghapusan data paramedis berhasil!'); document.location.href = 'master-paramedis.php';</script>";
  } else {
    echo "<script>alert ('Penghapusan data paramedis gagal!'); document.location.href = 'master-paramedis.php';</script>";
  }
}

?>
<!-- Modal Hapus Paramedis -->
<div class="modal fade" id="hapus_param<?= $paramedis["id_param"]; ?>">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Hapus Data Paramedis</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- /Modal Header -->
      <!-- Modal Body -->
      <form action="" method="post">
        <div class="modal-body row">
          <div class="col-md-12 text-center">
            <input type="text" name="id_param" id="id_param" value="<?= $paramedis["id_param"]; ?>" hidden>
            <p class="text-bold">Anda akan menghapus data</p>
            <p class="text-bold text-danger"><?= $paramedis["nama_param"]; ?> ?</p>
            <hr>
          </div>
          <div class="col-md-12 text-right">
            <button type="submit" name="btn_hapus_param" id="btn_hapus_param" class="btn btn-success" style="width: 100px;">
              <i class="fas fa-check-circle"></i>&emsp;Iya
            </button>
          </div>
        </div>
      </form>
      <!-- /Modal Body -->
    </div>
  </div>
</div>
<!-- /Modal Hapus Paramedis -->