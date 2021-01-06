<?php

// Konfigurasi ID Pasien
// => Cek ID Pasien
$cari_id    = mysqli_query($koneksi, "SELECT id_pasien FROM tabel_pasien") or die(mysqli_error(""));
$data_id    = mysqli_fetch_array($cari_id);
$jumlah     = mysqli_num_rows($cari_id);
$tanggal    = date("ymd");

// => Buat ID Pasien
if ($data_id) {
  $id     = (int) $jumlah;
  $id     = $jumlah + 1;
  $id_ps  = "$tanggal" . "04" . str_pad($id, 6, "0", STR_PAD_LEFT);
} else {
  $id_ps  = "$tanggal" . "04" . "000001";
}

// => Simpan Data
if (isset($_POST["btn_simpan_pasien"])) {
  if (tambah_pasien($_POST) > 0) {
    echo "<script>alert ('Penambahan data pasien berhasil!'); document.location.href = 'master-pasien.php';</script>";
  } else {
    echo "<script>alert ('Penambahan data pasien gagal!'); document.location.href = 'master-pasien.php';</script>";
  }
}
?>
<!-- Modal Tambah Pasien -->
<div class="modal fade" id="tambah_pasien">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Pasien</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- /Modal Header -->
      <!-- Modal Body -->
      <form action="" method="post">
        <div class="modal-body row">
          <div class="col-md-12">
            <!-- ID Pasien -->
            <div class="form-group row">
              <label for="id_pasien" class="col-md-4 col-form-label">ID Pasien</label>
              <div class="col-md-8">
                <input type="text" name="id_pasien" id="id_pasien" class="form-control" value="<?= $id_ps; ?>" readonly>
              </div>
            </div>
            <!-- Nama Pasien -->
            <div class="form-group row">
              <label for="nm_pasien" class="col-md-4 col-form-label">Nama Pasien</label>
              <div class="col-md-8">
                <input type="text" name="nm_pasien" id="nm_pasien" class="form-control text-lowercase" required autocomplete="off">
              </div>
            </div>
            <!-- Jenis Kelamin Pasien -->
            <div class="form-group row">
              <label class="col-md-4 col-form-label">Jenis Kelamin</label>
              <div class="col-md-8 mt-2">
                <div class="form-check form-check-inline">
                  <input type="radio" name="jk_pasien" id="laki-laki" value="Laki-Laki" class="form-check-input" required>
                  <label for="laki-laki" class="form-check-label">Laki-laki</label>
                </div>
                <div class="form-check form-check-inline">
                  <input type="radio" name="jk_pasien" id="perempuan" value="Perempuan" class="form-check-input" required>
                  <label for="perempuan" class="form-check-label">Perempuan</label>
                </div>
              </div>
            </div>
            <!-- Umur Pasien -->
            <div class="form-group row">
              <label for="umur_pasien" class="col-md-4 col-form-label">Umur Pasien</label>
              <div class="col-md-4 input-group">
                <input type="text" name="umur_pasien" id="umur_pasien" class="form-control" required autocomplete="off" onkeypress="return angka(event)">
                <div class="input-group-append">
                  <span class="input-group-text">Tahun</span>
                </div>
              </div>
            </div>
            <!-- Alamat Pasien -->
            <div class="form-group row">
              <label for="almt_pasien" class="col-md-4 col-form-label">Alamat Pasien</label>
              <div class="col-md-8">
                <input type="text" name="almt_pasien" id="almt_pasien" class="form-control text-lowercase" required autocomplete="off">
              </div>
            </div>
            <hr>
          </div>
          <div class="col-md-12 text-right">
            <button type="submit" name="btn_simpan_pasien" id="btn_simpan_pasien" class="btn btn-success" style="width: 100px;">
              <i class="fas fa-save"></i>&ensp;Simpan
            </button>
            <button type="reset" name="btn_reset_pasien" id="btn_reset_pasien" class="btn btn-danger" style="width: 100px;">
              <i class="fas fa-times"></i>&ensp;Batal
            </button>
          </div>
        </div>
      </form>
      <!-- /Modal Body -->
    </div>
  </div>
</div>
<!-- /Modal Tambah Pasien -->