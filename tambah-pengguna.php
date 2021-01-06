<?php

// Konfigurasi ID Pengguna
// => Cek ID Pengguna
$cari_id  = mysqli_query($koneksi, "SELECT id_pengguna FROM tabel_pengguna") or die(mysqli_error(""));
$data_id  = mysqli_fetch_array($cari_id);
$jumlah   = mysqli_num_rows($cari_id);
$tanggal  = date("ymd");
$date     = date("Y-m-d");

// => Buat ID Pengguna
if ($data_id) {
  $id     = (int) $jumlah;
  $id     = $jumlah + 1;
  $id_pg  = "$tanggal" . "01" . str_pad($id, 4, "0", STR_PAD_LEFT);
} else {
  $id_pg  = "$tanggal" . "01" . "0001";
}

// => Simpan Data
if (isset($_POST["btn_simpan_pengguna"])) {
  if (tambah_pengguna($_POST) > 0) {
    echo "<script>alert ('Penambahan data pengguna berhasil'); document.location.href = 'master-pengguna.php';</script>";
  } else {
    echo "<script>alert ('Penambahan data pengguna gagal'); document.location.href = 'master-pengguna.php';</script>";
  }
}

?>

<!-- Modal Tambah Pengguna -->
<div class="modal fade" id="tambah_pengguna">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Pengguna</h5>
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
            <div class="form-group row">
              <label for="id_pengguna" class="col-md-5 col-form-label">ID Pengguna</label>
              <div class="col-md-7">
                <input type="text" name="id_pengguna" id="id_pengguna" class="form-control" value="<?= $id_pg; ?>" readonly>
              </div>
            </div>
            <!-- Tanggal Daftar -->
            <div class="form-group row">
              <label for="tgl_daftar" class="col-md-5 col-form-label">Tanggal Daftar</label>
              <div class="col-md-7">
                <input type="date" name="tgl_daftar" id="tgl_daftar" class="form-control" value="<?= $date; ?>" required>
              </div>
            </div>
            <!-- Username Pengguna -->
            <div class="form-group row">
              <label for="username_pengguna" class="col-md-5 col-form-label">Nama Pengguna</label>
              <div class="col-md-7 input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-at"></i></span>
                </div>
                <input type="text" name="username_pengguna" id="username_pengguna" class="form-control text-lowercase" required autocomplete="off">
              </div>
            </div>
            <!-- Tipe Pengguna -->
            <div class="form-group row">
              <label for="tipe_pengguna" class="col-md-5 col-form-label">Tipe Pengguna</label>
              <div class="col-md-7">
                <select name="tipe_pengguna" id="tipe_pengguna" class="js-example-placeholder-single js-states form-control" required>
                  <option></option>
                  <option value="Admin">ADMIN</option>
                  <option value="Dokter">DOKTER</option>
                  <option value="Paramedis">PARAMEDIS</option>
                </select>
              </div>
            </div>
            <script>
              // Function Show & Hide Password
              function showpassword() {
                var input1 = document.getElementById("password_1");
                var input2 = document.getElementById("password_2");
                var icon1 = document.getElementById("icopass_1");
                var icon2 = document.getElementById("icopass_2");

                if (input1.type === "password") {
                  input1.type = "text";
                } else {
                  input1.type = "password";
                }

                if (icon1.className === "fa fa-lock") {
                  icon1.className = "fa fa-lock-open";
                } else {
                  icon1.className = "fa fa-lock";
                }

                if (input2.type === "password") {
                  input2.type = "text";
                } else {
                  input2.type = "password";
                }

                if (icon2.className === "fa fa-lock") {
                  icon2.className = "fa fa-lock-open";
                } else {
                  icon2.className = "fa fa-lock";
                }
              }
            </script>
            <!-- Password 1 -->
            <div class="form-group row">
              <label for="password_1" class="col-md-5 col-form-label">Kata Sandi Pengguna</label>
              <div class="col-md-7 input-group">
                <input type="password" name="password_1" id="password_1" class="form-control" required autocomplete="off">
                <div class="input-group-append">
                  <button type="button" class="btn btn-default" onclick="showpassword()"><i class="fa fa-lock" id="icopass_1"></i></button>
                </div>
              </div>
            </div>
            <!-- Konfirmasi Password -->
            <div class="form-group row">
              <label for="password_2" class="col-md-5 col-form-label">Konfirm Kata Sandi</label>
              <div class="col-md-7 input-group">
                <input type="password" name="password_2" id="password_2" class="form-control" required autocomplete="off">
                <div class="input-group-append">
                  <button type="button" class="btn btn-default" onclick="showpassword()"><i class="fa fa-lock" id="icopass_2"></i></button>
                </div>
              </div>
            </div>
            <!-- Kode Keamanan -->
            <?php

            // Buat kode angka dari 0 - 9
            $kode_angka = range(0, 9);
            // Mengacak kode angka
            shuffle($kode_angka);
            // Hasil kode angka 5 digit
            $hasil = array_rand($kode_angka, 5);
            $kode = implode("", $hasil);
            ?>
            <div class="form-group row">
              <label for="kode_keamanan" class="col-md-5 col-form-label">Kode Keamanan</label>
              <div class="col-md-5 input-group">
                <input type="text" name="kode_keamanan" id="kode_keamanan" class="form-control" value="<?= $kode; ?>" readonly>
                <div class="input-group-append">
                  <span class="input-group-text bg-info">Kode Anda</span>
                </div>
              </div>
            </div>
            <hr>
          </div>
          <div class="col-md-12 text-right">
            <button type="submit" name="btn_simpan_pengguna" id="btn_simpan_pengguna" class="btn btn-success" style="width: 100px;">
              <i class="fas fa-save"></i>&ensp;Simpan
            </button>
            <button type="reset" name="btn_reset_pengguna" id="btn_reset_pengguna" class="btn btn-danger" style="width: 100px;">
              <i class="fas fa-times"></i>&ensp;Batal
            </button>
          </div>
        </div>
      </form>
      <!-- /Modal Body -->
    </div>
  </div>
</div>
<!-- /Modal Tambah Pengguna -->