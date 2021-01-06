<?php

// Set Waktu
date_default_timezone_set('Asia/Kuala_Lumpur');

// Konfigurasi Buat ID Rekap
$tanggal      = date("ymd");
// => Cek ID Rekap
$cari_id      = mysqli_query($koneksi, "SELECT id_tagihan FROM tabel_obat") or die(mysqli_error(""));
$data_id      = mysqli_fetch_array($cari_id);
$jumlah       = mysqli_num_rows($cari_id);
// => Buat Id Rekap
if ($data_id) {
  $id         = (int) $jumlah;
  $id         = $jumlah + 1;
  $id_tagihan  = "$tanggal" . "08" . str_pad($id, 4, "0", STR_PAD_LEFT);
} else {
  $id_tagihan  = "$tanggal" . "08" . "0001";
}

// Simpan Data Rekap
if (isset($_POST["btn_simpan_tagihan"])) {
  if (tambah_tagihan($_POST) > 0) {
    echo "<script>alert ('Penambahan Data Tagihan Berhasil!'); document.location.href = 'tagihan-obat.php';</script>";
  } else {
    echo "<script>alert ('Penambahan Data Tagihan Gagal!'); document.location.href = 'tagihan-obat.php';</script>";
  }
}

?>
<!-- Modal Tambah Tagihan -->
<div class="modal fade" id="tambah_tagihan">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Tagihan Obat</h5>
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
                <input type="text" name="id_tagihan" id="id_tagihan" class="form-control" value="<?= $id_tagihan; ?>" readonly>
              </div>
            </div>
            <!-- Nomor Nota -->
            <div class="form-group row">
              <label for="no_nota" class="col-md-5 col-form-label">No. Nota Tagihan</label>
              <div class="col-md-7">
                <input type="text" name="no_nota" id="no_nota" class="form-control" required autocomplete="off">
              </div>
            </div>
            <!-- Tanggal Tagihan -->
            <div class="form-group row">
              <label for="tgl_tagihan" class="col-md-5 col-form-label">Tanggal Tagihan</label>
              <div class="col-md-7">
                <input type="date" name="tgl_tagihan" id="tgl_tagihan" class="form-control" value="<?= $tgl_obat; ?>" required>
              </div>
            </div>
            <!-- Nama Apotek -->
            <div class="form-group row">
              <label for="nm_apotek" class="col-md-5 col-form-label">Nama Apotek</label>
              <div class="col-md-7">
                <input type="text" name="nm_apotek" id="nm_apotek" class="form-control text-lowercase" required autocomplete="off">
              </div>
            </div>
            <!-- Tagihan Obat -->
            <div class="form-group row">
              <label for="biaya_tagihan" class="col-md-5 col-form-label">Biaya Tagihan</label>
              <div class="col-md-7 input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Rp.</span>
                </div>
                <input type="text" name="biaya_tagihan" id="biaya_tagihan" class="form-control" required autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
              </div>
            </div>
            <!-- Status Tagihan -->
            <div class="form-group row">
              <label for="status_tagihan" class="col-md-5 col-form-label">Status Tagihan</label>
              <div class="col-md-7">
                <input type="text" name="status_tagihan" id="status_tagihan" class="form-control" value="Belum Dibayar" readonly>
              </div>
            </div>
            <hr>
          </div>
          <div class="col-md-12 text-right">
            <button type="submit" name="btn_simpan_tagihan" id="btn_simpan_tagihan" class="btn btn-success">
              <i class="fas fa-save"></i>&ensp;Simpan
            </button>
          </div>
        </div>
      </form>
      <!-- /Modal Body -->
    </div>
  </div>
</div>
<!-- /Modal Tambah Tagihan -->