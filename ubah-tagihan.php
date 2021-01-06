<?php
$id       = $tg["id_tagihan"];
$tagihan  = query("SELECT * FROM tabel_obat WHERE id_tagihan = '$id'")[0];

// Simpan Data Rekap
if (isset($_POST["btn_ubah_tagihan"])) {
  if (ubah_tagihan($_POST) > 0) {
    echo "<script>alert ('Perubahan Data Tagihan Berhasil!'); document.location.href = 'tagihan-obat.php';</script>";
  } else {
    echo "<script>alert ('Perubahan Data Tagihan Gagal!'); document.location.href = 'tagihan-obat.php';</script>";
  }
}

?>
<!-- Modal Ubah Tagihan -->
<div class="modal fade" id="ubah_tagihan<?= $id; ?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Ubah Data Tagihan Obat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- /Modal Header -->
      <!-- Modal Body -->
      <form action="" method="post">
        <div class="modal-body row">
          <div class="col-md-12">
            <!-- ID Tagihan -->
            <div class="form-group row">
              <label for="id_tagihan" class="col-md-5 col-form-label">ID Tagihan</label>
              <div class="col-md-7">
                <input type="text" name="id_tagihan" id="id_tagihan" class="form-control" value="<?= $tagihan["id_tagihan"]; ?>" readonly>
              </div>
            </div>
            <!-- Nomor Nota -->
            <div class="form-group row">
              <label for="no_nota" class="col-md-5 col-form-label">No. Nota Tagihan</label>
              <div class="col-md-7">
                <input type="text" name="no_nota" id="no_nota" class="form-control" value="<?= $tagihan["nomor_nota"]; ?>" required autocomplete="off">
              </div>
            </div>
            <!-- Tanggal Tagihan -->
            <div class="form-group row">
              <label for="tgl_tagihan" class="col-md-5 col-form-label">Tanggal Tagihan</label>
              <div class="col-md-7">
                <input type="date" name="tgl_tagihan" id="tgl_tagihan" class="form-control" value="<?= $tagihan["tanggal_tagihan"]; ?>" required>
              </div>
            </div>
            <!-- Nama Apotek -->
            <div class="form-group row">
              <label for="nm_apotek" class="col-md-5 col-form-label">Nama Apotek</label>
              <div class="col-md-7">
                <input type="text" name="nm_apotek" id="nm_apotek" class="form-control text-lowercase" value="<?= $tagihan["nama_apotek"]; ?>" required autocomplete="off">
              </div>
            </div>
            <!-- Tagihan Obat -->
            <div class="form-group row">
              <label for="biaya_tagihan" class="col-md-5 col-form-label">Biaya Tagihan</label>
              <div class="col-md-7 input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Rp.</span>
                </div>
                <input type="text" name="biaya_tagihan" id="biaya_tagihan" class="form-control" value="<?= number_format($tagihan["biaya_tagihan"], 0, ".", "."); ?>" required autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
              </div>
            </div>
            <!-- Status Tagihan -->
            <div class="form-group row">
              <label for="status_tagihan" class="col-md-5 col-form-label">Status Tagihan</label>
              <div class="col-md-7">
                <input type="text" name="status_tagihan" id="status_tagihan" class="form-control" value="<?= $tagihan["status_tagihan"]; ?>" readonly>
              </div>
            </div>
            <hr>
          </div>
          <div class="col-md-12 text-right">
            <button type="submit" name="btn_ubah_tagihan" id="btn_ubah_tagihan" class="btn btn-success">
              <i class="fas fa-save"></i>&ensp;Simpan
            </button>
          </div>
        </div>
      </form>
      <!-- /Modal Body -->
    </div>
  </div>
</div>
<!-- /Modal Ubah Tagihan -->