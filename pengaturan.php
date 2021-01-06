<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("location:login.php");
  exit;
}

$page = "DATA PENGATURAN";

include "header.php";
include "sidebar.php";
include "database.php";

$id       = "200701" . "05" . "0001";
$uang     = query("SELECT * FROM tabel_uang")[0];
$uang1    = number_format($uang["uang_hadir"], 0, ".", ".");
$uang2    = number_format($uang["uang_bpjs"], 0, ".", ".");
$uang3    = number_format($uang["uang_aqua"], 0, ".", ".");
$uang4    = number_format($uang["biaya_bank"], 0, ".", ".");

// Simpan Data Uang
if (isset($_POST["btn_pengaturan"])) {
  if (set_uang($_POST) > 0) {
    echo "<script>alert ('Pengaturan uang berhasil disimpan!'); document.location.href = 'pengaturan.php';</script>";
  } else {
    echo "<script>alert ('Pengaturan uang gagal disimpan!'); document.location.href = 'pengaturan.php';</script>";
  }
}

?>

<!-- CONTENT -->
<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <!-- Nama Halaman -->
        <div class="col-md-6">
          <h4>Halaman Pengaturan</h4>
        </div>
        <!-- Menu Halaman -->
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="index.php">Beranda</a>
            </li>
            <li class="breadcrumb-item">
              <span>Pengaturan</span>
            </li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- /Content Header -->

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- Form Set Pengaturan -->
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Set Pengaturan</h5>
            </div>
            <div class="card-body">
              <!-- Form Pengaturan -->
              <form action="" method="post">
                <div class="row">
                  <div class="col-md-12" style="margin-bottom: -7px;">
                    <input type="text" name="id_uang" id="id_uang" value="<?= $id; ?>" hidden>
                    <!-- Uang Hadir -->
                    <div class="form-group row">
                      <label for="uang_hadir" class="col-md-4 col-form-label">Uang Hadir</label>
                      <div class="col-md-8 input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Rp.</span>
                        </div>
                        <input type="text" name="uang_hadir" id="uang_hadir" class="form-control" value="<?= $uang1; ?>" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                      </div>
                    </div>
                    <!-- Uang BPJS -->
                    <div class="form-group row">
                      <label for="uang_bpjs" class="col-md-4 col-form-label">Uang BPJS</label>
                      <div class="col-md-8 input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Rp.</span>
                        </div>
                        <input type="text" name="uang_bpjs" id="uang_bpjs" class="form-control" value="<?= $uang2; ?>" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                      </div>
                    </div>
                    <!-- Uang AQUA -->
                    <div class="form-group row">
                      <label for="uang_aqua" class="col-md-4 col-form-label">Uang AQUA</label>
                      <div class="col-md-8 input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Rp.</span>
                        </div>
                        <input type="text" name="uang_aqua" id="uang_aqua" class="form-control" value="<?= $uang3; ?>" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                      </div>
                    </div>
                    <!-- Uang Bank -->
                    <div class="form-group row">
                      <label for="biaya_bank" class="col-md-4 col-form-label">Biaya Bank</label>
                      <div class="col-md-8 input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Rp.</span>
                        </div>
                        <input type="text" name="biaya_bank" id="biaya_bank" class="form-control" value="<?= $uang4; ?>" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                      </div>
                    </div>
                    <hr>
                  </div>
                  <!-- Tombl Simpan -->
                  <div class="col-md-12 text-right">
                    <button type="submit" name="btn_pengaturan" id="btn_pengaturan" class="btn btn-sm btn-success">
                      <i class="fas fa-save"></i>&emsp;Simpan
                    </button>
                  </div>
                </div>
              </form>
              <!-- /Form Pengaturan -->
            </div>
          </div>
        </div>
        <!-- /Form Set Pengaturan -->

        <!-- Tampil Set Pengaturan -->
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Data Pengaturan</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12" style="margin-bottom: 24px;">
                  <div class="form-group row" style="margin-top: -5px;">
                    <label class="col-md-6 col-form-label" style="font-size: 14pt;">Uang Kehadiran Dokter</label>
                    <label class="col-md-1 col-form-label text-center" style="font-size: 14pt;">:</label>
                    <label class="col-md-5 col-form-label" style="font-size: 14pt;">Rp. <?= number_format($uang["uang_hadir"], 0, ".", "."); ?></label>
                  </div>
                  <div class="form-group row" style="margin-top: -5px;">
                    <label class="col-md-6 col-form-label" style="font-size: 14pt;">Uang Pembayaran BPJS</label>
                    <label class="col-md-1 col-form-label text-center" style="font-size: 14pt;">:</label>
                    <label class="col-md-5 col-form-label" style="font-size: 14pt;">Rp. <?= number_format($uang["uang_bpjs"], 0, ".", "."); ?></label>
                  </div>
                  <div class="form-group row" style="margin-top: -5px;">
                    <label class="col-md-6 col-form-label" style="font-size: 14pt;">Uang Pembayaran AQUA</label>
                    <label class="col-md-1 col-form-label text-center" style="font-size: 14pt;">:</label>
                    <label class="col-md-5 col-form-label" style="font-size: 14pt;">Rp. <?= number_format($uang["uang_aqua"], 0, ".", "."); ?></label>
                  </div>
                  <div class="form-group row" style="margin-top: -5px; margin-bottom: 20px;">
                    <label class="col-md-6 col-form-label" style="font-size: 14pt;">Biaya Admin Bank</label>
                    <label class="col-md-1 col-form-label text-center" style="font-size: 14pt;">:</label>
                    <label class="col-md-5 col-form-label" style="font-size: 14pt;">Rp. <?= number_format($uang["biaya_bank"], 0, ".", "."); ?></label>
                  </div>
                  <hr>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /Tampil Set Pengaturan -->
      </div>
    </div>
  </section>
  <!-- /Main Content -->
</div>
<!-- /CONTENT -->

<?php include "footer.php"; ?>