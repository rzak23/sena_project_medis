<?php

// Konfigurasi ID Paramedis
// => Cek ID Paramedis
$cari_id    = mysqli_query($koneksi, "SELECT id_param FROM tabel_paramedis") or die(mysqli_error(""));
$data_id    = mysqli_fetch_array($cari_id);
$jumlah     = mysqli_num_rows($cari_id);
$tanggal    = date("ymd");
$date       = date("Y-m-d");

// Buat ID Paramedis
if ($data_id) {
  $id     = (int) $jumlah;
  $id     = $jumlah + 1;
  $id_pm  = "$tanggal" . "03" . str_pad($id, 4, "0", STR_PAD_LEFT);
} else {
  $id_pm  = "$tanggal" . "03" . "0001";
}

// Simpan Data
if (isset($_POST["btn_simpan_param"])) {
  if (tambah_paramedis($_POST) > 0) {
    echo "<script>alert ('Penambahan data paramedis berhasil!'); document.location.href = 'master-paramedis.php';</script>";
  } else {
    echo "<script>alert ('Penambahan data paramedis gagal!'); document.location.href = 'master-paramedis.php';</script>";
  }
}

?>
<!-- Modal Tambah Paramedis -->
<div class="modal fade" id="tambah_param">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Paramedis</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- /Modal Header -->
      <!-- Modal Body -->
      <form action="" method="post">
        <div class="modal-body row">
          <div class="col-md-12">
            <!-- ID Paramedis -->
            <div class="form-group row">
              <label for="id_param" class="col-md-4 col-form-label">ID Paramedis</label>
              <div class="col-md-8">
                <input type="text" name="id_param" id="id_param" class="form-control" value="<?= $id_pm; ?>" readonly>
              </div>
            </div>
            <!-- Nama Paramedis -->
            <div class="form-group row">
              <label for="nm_param" class="col-md-4 col-form-label">Nama Paramedis</label>
              <div class="col-md-8">
                <input type="text" name="nm_param" id="nm_param" class="form-control text-lowercase" required autocomplete="off">
              </div>
            </div>
            <!-- Jenis Kelamin Paramedis -->
            <div class="form-group row">
              <label class="col-md-4 col-form-label">Jenis Kelamin</label>
              <div class="col-md-8 mt-2">
                <div class="form-check form-check-inline">
                  <input type="radio" name="jk_param" id="laki-laki" value="Laki-Laki" class="form-check-input" required>
                  <label for="laki-laki" class="form-check-label">Laki-laki</label>
                </div>
                <div class="form-check form-check-inline">
                  <input type="radio" name="jk_param" id="perempuan" value="Perempuan" class="form-check-input" required>
                  <label for="perempuan" class="form-check-label">Perempuan</label>
                </div>
              </div>
            </div>
            <!-- Alamat Paramedis -->
            <div class="form-group row">
              <label for="almt_param" class="col-md-4 col-form-label">Alamat Paramedis</label>
              <div class="col-md-8">
                <input type="text" name="almt_param" id="almt_param" class="form-control text-lowercase" required autocomplete="off">
              </div>
            </div>
            <!-- Telepon Paramedis -->
            <div class="form-group row">
              <label for="telp_param" class="col-md-4 col-form-label">Telepon Paramedis</label>
              <div class="col-md-8">
                <input type="text" name="telp_param" id="telp_param" class="form-control" required autocomplete="off" onkeypress="return angka(event)">
              </div>
            </div>
            <hr>
          </div>
          <div class="col-md-12 text-right">
            <button type="submit" name="btn_simpan_param" id="btn_simpan_param" class="btn btn-success" style="width: 100px;">
              <i class="fas fa-save"></i>&ensp;Simpan
            </button>
            <button type="reset" name="btn_reset_param" id="btn_reset_param" class="btn btn-danger" style="width: 100px;">
              <i class="fas fa-times"></i>&ensp;Batal
            </button>
          </div>
        </div>
      </form>
      <!-- /Modal Body -->
    </div>
  </div>
</div>
<!-- /Modal Tambah Paramedis -->