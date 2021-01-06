<?php
$id    = $pb["id_tagihan"];
$bayar = query("SELECT * FROM tabel_obat WHERE id_tagihan = '$id'")[0];


// Simpan Data Pembayaran
if (isset($_POST["btn_simpan_bayar"])) {
  if (pembayaran_tagihan($_POST) > 0) {
    echo "<script>alert ('Pembayaran data tagihan berhasil!'); document.location.href = 'pembayaran-obat.php';</script>";
  } else {
    echo "<script>alert ('Pembayaran data tagihan gagal!'); document.location.href = 'pembayaran-obat.php';</script>";
  }
}
?>
<!-- Modal Bayar Tagihan -->
<div class="modal fade" id="bayar_tagihan<?= $id; ?>">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Data Bayar Tagihan Obat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- /Modal Header -->
      <!-- Modal Body -->
      <form action="" method="post">
        <div class="modal-body row">
          <div class="col-md-12">
            <div class="row">
              <!-- Data Tagihan -->
              <div class="col-md-6 border">
                <div class="form-group text-bold row">
                  <legend class="col-md-4 col-form-label">ID Tagihan</legend>
                  <legend class="col-md-8 col-form-label">:&emsp;<?= $bayar["id_tagihan"]; ?></legend>
                </div>
                <div class="form-group text-bold row" style="margin-top: -25px;">
                  <legend class="col-md-4 col-form-label">No. Nota</legend>
                  <legend class="col-md-8 col-form-label">:&emsp;<?= $bayar["nomor_nota"]; ?></legend>
                </div>
                <div class="form-group text-bold row" style="margin-top: -25px;">
                  <legend class="col-md-4 col-form-label">Tgl. Tagihan</legend>
                  <legend class="col-md-8 col-form-label">:&emsp;<?= $bayar["tanggal_tagihan"]; ?></legend>
                </div>
                <div class="form-group text-bold row" style="margin-top: -25px;">
                  <legend class="col-md-4 col-form-label">Nama Apotek</legend>
                  <legend class="col-md-8 col-form-label">:&emsp;<?= $bayar["nama_apotek"]; ?></legend>
                </div>
                <div class="form-group text-bold row" style="margin-top: -25px;">
                  <legend class="col-md-4 col-form-label">Biaya Tagihan</legend>
                  <legend class="col-md-8 col-form-label">:&emsp;Rp. <?= number_format($bayar["biaya_tagihan"], 0, ".", "."); ?></legend>
                </div>
                <div class="form-group text-bold row" style="margin-top: -25px; margin-bottom: -2px;">
                  <legend class="col-md-4 col-form-label">Status Tagihan</legend>
                  <legend class="col-md-8 col-form-label">:&emsp;<?= $bayar["status_tagihan"]; ?></legend>
                </div>
              </div>
              <!-- Data Pembayaran Tagihan -->
              <div class="col-md-6">
                <!-- ID Tagihan -->
                <input type="text" name="id_tagihan" id="id_tagihan" value="<?= $bayar["id_tagihan"]; ?>" hidden>
                <!-- Tanggal Bayar -->
                <div class="form-group row">
                  <label for="tgl_bayar" class="col-md-4 col-form-label">Tgl. Bayar</label>
                  <div class="col-md-8">
                    <input type="date" name="tgl_bayar" id="tgl_bayar" value="<?= $tgl_obat; ?>" class="form-control" required>
                  </div>
                </div>
                <!-- Bayar Obat -->
                <div class="form-group row">
                  <label for="bayar_tagihan" class="col-md-4 col-form-label">Bayar Tagihan</label>
                  <div class="col-md-8 input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Rp.</span>
                    </div>
                    <input type="text" name="bayar_tagihan" id="bayar_tagihan" class="form-control" value="<?= number_format($bayar["bayar_tagihan"], 0, ".", "."); ?>" required autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                  </div>
                </div>
                <!-- Status Tagihan -->
                <div class="form-group row">
                  <label for="status_bayar" class="col-md-4 col-form-label">Status Tagihan</label>
                  <div class="col-md-8">
                    <select name="status_bayar" id="status_bayar" class="js-example-placeholder-single js-states form-control" required>
                      <?php
                      $select1 = ($bayar["status_tagihan"] == "Belum Dibayar") ? "selected" : "";
                      $select2 = ($bayar["status_tagihan"] == "Sudah Dibayar") ? "selected" : "";
                      ?>
                      <option value="Belum Dibayar" <?= $select1; ?>>Belum Dibayar</option>
                      <option value="Sudah Dibayar" <?= $select2; ?>>Sudah Dibayar</option>
                    </select>
                  </div>
                </div>
                <div class="text-right">
                  <button type="submit" name="btn_simpan_bayar" id="btn_simpan_bayar" class="btn btn-sm btn-success">
                    <i class="fas fa-save"></i>&ensp;Simpan
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
      <!-- /Modal Body -->
    </div>
  </div>
</div>
<!-- /Modal Bayar Tagihan -->