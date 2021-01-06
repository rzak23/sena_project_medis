<?php

// Konfigurasi ID Dokter
// => Cek ID Dokter
$cari_id  = mysqli_query($koneksi, "SELECT id_dokter FROM tabel_dokter ") or die(mysqli_error(""));
$data_id  = mysqli_fetch_array($cari_id);
$jumlah   = mysqli_num_rows($cari_id);
$tanggal  = date("ymd");
$date     = date("Y-m-d");

// Buat ID Dokter
if ($data_id) {
  $id     = (int) $jumlah;
  $id     = $jumlah + 1;
  $id_dr  = "$tanggal" . "02" . str_pad($id, 4, "0", STR_PAD_LEFT);
} else {
  $id_dr  = "$tanggal" . "02" . "0001";
}

// Simpan Data
if (isset($_POST["btn_simpan_dokter"])) {
  if (tambah_dokter($_POST) > 0) {
    echo "<script>alert ('Penambahan data dokter berhasil!'); document.location.href = 'master-dokter.php';</script>";
  } else {
    echo "<script>alert ('Penambahan data dokter gagal!'); document.location.href = 'master-dokter.php';</script>";
  }
}

?>
<!-- Modal Tambah Dokter -->
<div class="modal fade" id="tambah_dokter">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Dokter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- /Modal Header -->
      <!-- Modal Body -->
      <form action="" method="post">
        <div class="modal-body row">
          <div class="col-md-12">
            <!-- ID Dokter -->
            <div class="form-group row">
              <label for="id_dokter" class="col-md-4 col-form-label">ID Dokter</label>
              <div class="col-md-8">
                <input type="text" name="id_dokter" id="id_dokter" class="form-control" value="<?= $id_dr; ?>" readonly>
              </div>
            </div>
            <!-- Nama Dokter -->
            <div class="form-group row">
              <label for="nm_dokter" class="col-md-4 col-form-label">Nama Dokter</label>
              <div class="col-md-8">
                <input type="text" name="nm_dokter" id="nm_dokter" class="form-control text-lowercase" required autocomplete="off">
              </div>
            </div>
            <!-- Jenis Kelamin Dokter -->
            <div class="form-group row">
              <label class="col-md-4 col-form-label">Jenis Kelamin</label>
              <div class="col-md-8 mt-2">
                <div class="form-check form-check-inline">
                  <input type="radio" name="jk_dokter" id="laki-laki" value="Laki-Laki" class="form-check-input" required>
                  <label for="laki-laki" class="form-check-label">Laki-laki</label>
                </div>
                <div class="form-check form-check-inline">
                  <input type="radio" name="jk_dokter" id="perempuan" value="Perempuan" class="form-check-input" required>
                  <label for="perempuan" class="form-check-label">Perempuan</label>
                </div>
              </div>
            </div>
            <!-- Alamat Dokter -->
            <div class="form-group row">
              <label for="almt_dokter" class="col-md-4 col-form-label">Alamat Dokter</label>
              <div class="col-md-8">
                <input type="text" name="almt_dokter" id="almt_dokter" class="form-control text-lowercase" required autocomplete="off">
              </div>
            </div>
            <!-- Telepon Dokter -->
            <div class="form-group row">
              <label for="telp_dokter" class="col-md-4 col-form-label">Telepon Dokter</label>
              <div class="col-md-8">
                <input type="text" name="telp_dokter" id="telp_dokter" class="form-control" required autocomplete="off" onkeypress="return angka(event)">
              </div>
            </div>
            <hr>
          </div>
          <div class="col-md-12 text-right">
            <button type="submit" name="btn_simpan_dokter" id="btn_simpan_dokter" class="btn btn-success" style="width: 100px;">
              <i class="fas fa-save"></i>&ensp;Simpan
            </button>
            <button type="reset" name="btn_reset_dokter" id="btn_reset_dokter" class="btn btn-danger" style="width: 100px;">
              <i class="fas fa-times"></i>&ensp;Batal
            </button>
          </div>
        </div>
      </form>
      <!-- /Modal Body -->
    </div>
  </div>
</div>
<!-- /Modal Tambah Dokter -->