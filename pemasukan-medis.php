<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("location:login.php");
  exit;
}

$page = "DATA PEMASUKAN MEDIS";
$tgl_pemasukan  = date("Y-m-d");

include "header.php";
include "sidebar.php";
include "database.php";

// Pagination Tabel
$hal_aktif        = (isset($_REQUEST["hal"])) ? $_REQUEST["hal"] : 1;
$limit_data       = 10;
$limit_start      = ($hal_aktif - 1) * $limit_data;
if (isset($_REQUEST["tglawal_cari"]) && ($_REQUEST["tglakhir_cari"]) > 0) {
  $tgl_awal       = $_REQUEST["tglawal_cari"];
  $tgl_akhir      = $_REQUEST["tglakhir_cari"];
  $datas          = query("SELECT * FROM tabel_pemasukan WHERE tanggal_pemasukan
                            BETWEEN '$tgl_awal' AND '$tgl_akhir'");
  $jml_data       = count($datas);
  $pemasukan      = query("SELECT * FROM tabel_pemasukan WHERE tanggal_pemasukan
                            BETWEEN '$tgl_awal' AND '$tgl_akhir'
                            ORDER BY tanggal_pemasukan DESC LIMIT $limit_start, $limit_data");
  $hal_link       = "?tglawal_cari=$tgl_awal&tglakhir_cari=$tgl_akhir";
  $halaman        = "on";

  // Hitung Jumlah Pemasukan
  $pemasukan1     = query("SELECT COUNT(id_pemasukan) AS jml FROM tabel_pemasukan
                            WHERE tanggal_pemasukan BETWEEN '$tgl_awal' AND '$tgl_akhir'")[0];
  $hasil1         = number_format($pemasukan1["jml"], 0, ".", ".");

  // Hitung Total Pemasukan
  $pemasukan2     = query("SELECT SUM(total_pemasukan) AS total FROM tabel_pemasukan
                            WHERE tanggal_pemasukan BETWEEN '$tgl_awal' AND '$tgl_akhir'")[0];
  $hasil2         = number_format($pemasukan2["total"], 0, ".", ".");
} else {
  $tgl_awal       = "";
  $tgl_akhir      = "";
  $datas          = query("SELECT * FROM tabel_pemasukan");
  $jml_data       = count($datas);
  $pemasukan      = query("SELECT * FROM tabel_pemasukan ORDER BY tanggal_pemasukan DESC
                            LIMIT $limit_start, $limit_data");
  $hal_link       = "?";
  $halaman        = "";

  // Hitung Jumlah Pemasukan
  $pemasukan1     = query("SELECT COUNT(id_pemasukan) AS jml FROM tabel_pemasukan")[0];
  $hasil1         = number_format($pemasukan1["jml"], 0, ".", ".");

  // Hitung Total Pemasukan
  $pemasukan2     = query("SELECT SUM(total_pemasukan) AS total FROM tabel_pemasukan")[0];
  $hasil2         = number_format($pemasukan2["total"], 0, ".", ".");
}

$jml_halaman      = ceil($jml_data / $limit_data);
if ($jml_halaman <= 1) {
  $jml_nomor      = 0;
} else {
  $jml_nomor      = ($jml_halaman < 3) ? $jml_halaman - 1 : 1;
}
$nomor_awal       = ($hal_aktif > $jml_nomor) ? $hal_aktif - $jml_nomor : 1;
$nomor_akhir      = ($hal_aktif < ($jml_halaman - $jml_nomor)) ? $hal_aktif + $jml_nomor : $jml_halaman;

?>

<!-- CONTENT -->
<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <!-- Nama Halaman -->
        <div class="col-md-6">
          <h4>Halaman Pemasukan Medis</h4>
        </div>
        <!-- Menu Halaman -->
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="index.php">Beranda</a>
            </li>
            <?php if (isset($_GET["aksi"]) > 0) : ?>
              <?php if ($_GET["aksi"] == "tambah") : ?>
                <li class="breadcrumb-item">
                  <a href="pemasukan-medis.php">Data Pemasukan Medis</a>
                </li>
                <li class="breadcrumb-item">
                  <span>Tambah Data Pemasukan</span>
                </li>
              <?php elseif ($_GET["aksi"] == "ubah") : ?>
                <li class="breadcrumb-item">
                  <a href="pemasukan-medis.php">Data Pemasukan Medis</a>
                </li>
                <li class="breadcrumb-item">
                  <span>Ubah Data Pemasukan</span>
                </li>
              <?php endif; ?>
            <?php else : ?>
              <li class="breadcrumb-item">
                <span>Data Pemasukan Medis</span>
              </li>
            <?php endif; ?>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- /Content Header -->

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Form Data Pemasukan Medis -->
      <div class="row">
        <?php if (isset($_GET["aksi"]) > 0) : ?>
          <?php if ($_GET["aksi"] == "tambah") : ?>
            <?php include "tambah-pemasukan.php"; ?>
          <?php elseif ($_GET["aksi"] == "ubah") : ?>
            <?php include "ubah-pemasukan.php"; ?>
          <?php endif; ?>
        <?php endif; ?>
      </div>
      <!-- /Form Data Pemasukan Medis -->
      <!-- Tabel Data Tagihan Obat -->
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Data Pemasukan Medis</h5>
            </div>
            <div class="card-body" style="margin-bottom: -20px;">
              <form action="" method="post">
                <div class="row" style="margin-top: -10px;">
                  <div class="col-md-2">
                    <a href="?aksi=tambah" class="btn btn-primary">
                      <i class="fas fa-plus-square"></i>&ensp;Tambah Data
                    </a>
                  </div>
                  <?php if ($halaman == "on") : ?>
                    <div class="col-md-8 form-horizontal">
                      <div class="row">
                        <div class="offset-1 col-md-2 text-center">
                          <legend class="col-form-label">Tanggal</legend>
                        </div>
                        <div class="col-md-4">
                          <input type="date" name="tglawal_cari" id="tglawal_cari" class="form-control" value="<?= $tgl_awal; ?>" readonly style="font-size: 15px;">
                        </div>
                        <div class="col-md-1">
                          <legend class="col-form-label text-center">S/D</legend>
                        </div>
                        <div class="col-md-4">
                          <input type="date" name="tglakhir_cari" id="tglakhir_cari" class="form-control" value="<?= $tgl_akhir; ?>" readonly style="font-size: 15px;">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <a href="?" name="btn_caripemasukan" id="btn_caripemasukan" class="btn btn-block btn-info">
                        <i class="fas fa-retweet"></i>&emsp;Reset Data
                      </a>
                    </div>
                  <?php else : ?>
                    <div class="col-md-8 form-horizontal">
                      <div class="row">
                        <div class="offset-1 col-md-2 text-center">
                          <legend class="col-form-label">Tanggal</legend>
                        </div>
                        <div class="col-md-4">
                          <input type="date" name="tglawal_cari" id="tglawal_cari" class="form-control" style="font-size: 15px;">
                        </div>
                        <div class="col-md-1">
                          <legend class="col-form-label text-center">S/D</legend>
                        </div>
                        <div class="col-md-4">
                          <input type="date" name="tglakhir_cari" id="tglakhir_cari" class="form-control" style="font-size: 15px;">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <button type="submit" name="btn_caripemasukan" id="btn_caripemasukan" class="btn btn-block btn-info">
                        <i class="fas fa-search"></i>&emsp;Cari Data
                      </button>
                    </div>
                  <?php endif; ?>
                </div>
              </form>
              <!-- Tabel Data -->
              <div class="row mt-2">
                <div class="col-md-12">
                  <table class="table table-sm table-bordered">
                    <thead class="text-center bg-success">
                      <th style="color: black;">NO.</th>
                      <th style="color: black;">TANGGAL</th>
                      <th style="color: black;">PEMASUKAN UMUM</th>
                      <th style="color: black;">PEMASUKAN BPJS</th>
                      <th style="color: black;">PEMASUKAN AQUA</th>
                      <th style="color: black;">TOTAL PEMASUKAN</th>
                      <th style="color: black;">AKSI</th>
                    </thead>
                    <?php $mulai = $limit_data * ($hal_aktif - 1); ?>
                    <?php $number = $mulai + 1; ?>
                    <?php foreach ($pemasukan as $pk) : ?>
                      <tbody>
                        <tr>
                          <td width="50" class="text-center"><?= $number; ?></td>
                          <td width="100" class="text-center"><?= $pk["tanggal_pemasukan"]; ?></td>
                          <td>Rp.&emsp;<?= number_format($pk["biaya_umum"], 0, ".", "."); ?></td>
                          <td>Rp.&emsp;<?= number_format($pk["biaya_bpjs"], 0, ".", "."); ?></td>
                          <td>Rp.&emsp;<?= number_format($pk["biaya_aqua"], 0, ".", "."); ?></td>
                          <td>Rp.&emsp;<?= number_format($pk["total_pemasukan"], 0, ".", "."); ?></td>
                          <td width="75">
                            <a href="?aksi=ubah&id=<?= $pk["id_pemasukan"]; ?>" class="btn btn-sm btn-warning" style="width: 75px;">
                              <i class="fas fa-edit"></i>&ensp;Ubah
                            </a>
                          </td>
                        </tr>
                        <?php $number++; ?>
                      <?php endforeach; ?>
                      </tbody>
                  </table>
                </div>
              </div>
              <!-- /Tabel Data -->

              <!-- Informasi Data Tagihan Obat -->
              <div class="row" style="margin-top: -5px;">
                <!-- Informasi Data -->
                <div class="col-md-3">
                  <table class="justify-content-start">
                    <tr>
                      <td width="150">Data Pemasukan</td>
                      <td>&emsp;:&emsp;</td>
                      <td><?= $hasil1; ?></td>
                    </tr>
                  </table>
                </div>
                <div class="col-md-4">
                  <table class="justify-content-start">
                    <tr>
                      <td width="150">Total Pemasukan</td>
                      <td>&emsp;:&emsp;</td>
                      <td>Rp. <?= $hasil2; ?></td>
                    </tr>
                  </table>
                </div>
                <!-- Pagination Tabel -->
                <div class="col-md-5">
                  <nav class="float-right">
                    <ul class="pagination pagination-sm">
                      <?php if ($hal_aktif == $jml_halaman) : ?>
                        <?php if ($jml_halaman == 1) : ?>
                          <li class="page-item disabled"><a href="<?= $hal_link; ?>&hal=<?= $hal_aktif - 1; ?>" class="page-link"><i class="fas fa-angle-left"></i></a></li>
                        <?php else : ?>
                          <li class="page-item"><a href="<?= $hal_link; ?>&hal=1" class="page-link">Kembali Ke Awal</a></li>
                          <li class="page-item"><a href="<?= $hal_link; ?>&hal=<?= $hal_aktif - 1; ?>" class="page-link"><i class="fas fa-angle-left"></i></a></li>
                        <?php endif; ?>
                      <?php elseif ($hal_aktif > 1) : ?>
                        <li class="page-item"><a href="<?= $hal_link; ?>&hal=1" class="page-link">Kembali Ke Awal</a></li>
                        <li class="page-item"><a href="<?= $hal_link; ?>&hal=<?= $hal_aktif - 1; ?>" class="page-link"><i class="fas fa-angle-left"></i></a></li>
                      <?php else : ?>
                        <li class="page-item disabled"><a href="#" class="page-link"><i class="fas fa-angle-left"></i></a></li>
                      <?php endif; ?>

                      <?php for ($i = $nomor_awal; $i <= $nomor_akhir; $i++) : ?>
                        <?php if ($i == $hal_aktif) : ?>
                          <li class="page-item active"><a href="<?= $hal_link; ?>&hal=<?= $i; ?>" class="page-link"><?= $i; ?></a></li>
                        <?php else : ?>
                          <li class="page-item"><a href="<?= $hal_link; ?>&hal=<?= $i; ?>" class="page-link"><?= $i; ?></a></li>
                        <?php endif; ?>
                      <?php endfor; ?>

                      <?php if ($hal_aktif < $jml_halaman) : ?>
                        <li class="page-item"><a href="<?= $hal_link; ?>&hal=<?= $hal_aktif + 1; ?>" class="page-link"><i class="fas fa-angle-right"></i></a></li>
                      <?php else : ?>
                        <li class="page-item disabled"><a href="#" class="page-link"><i class="fas fa-angle-right"></i></a></li>
                      <?php endif; ?>
                    </ul>
                  </nav>
                </div>
              </div>
              <!-- /Informasi Data Tagihan Obat -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /Tabel Data Tagihan Obat -->
</div>
</section>
<!-- /Main Content -->
</div>
<!-- /CONTENT -->

<?php

include "footer.php";

?>