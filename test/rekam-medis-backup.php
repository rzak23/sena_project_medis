<?php
session_start();

if (!isset($_SESSION["login"])) {
  header("location:login.php");
  exit;
}

$page = "REKAM MEDIS";

// Set Waktu
date_default_timezone_set('Asia/Kuala_Lumpur');
$tgl_medis    = date("Y-m-d");
$jam          = date("H");
$menit        = date("i");
// $jam          = 16;
// $menit        = 59;

// $waktu  = "$jam : $menit";
if ($jam < 17) {
  if ($menit >= 30 || $menit < 60) {
    $waktu = "Pagi";
  }
} elseif ($jam >= 16 && $jam <= 19) {
  if ($menit >= 0 && $menit < 60) {
    $waktu = "Sore";
  }
} elseif ($jam > 19 || $jam <= 7) {
  if ($menit < 30 || $menit >= 0) {
    $waktu = "Malam";
  }
}

include "header.php";
include "sidebar.php";
include "database.php";

// Pagination Tabel
$hal_aktif          = (isset($_REQUEST["hal"])) ? $_REQUEST["hal"] : 1;
$limit_data         = 10;
$limit_start        = ($hal_aktif - 1) * $limit_data;
if (isset($_REQUEST["cari_rekmed"]) > 0) {
  $cari_data        = $_REQUEST["cari_rekmed"];
  $datas            = query("SELECT rm.*, ps.* FROM (tabel_medis rm 
                            INNER JOIN tabel_pasien ps ON rm.id_pasien = ps.id_pasien)
                            WHERE rm.tipe_pasien    LIKE '%$cari_data%'  OR
                                  rm.diagnosa_medis LIKE '%$cari_data%'  OR
                                  ps.nama_pasien    LIKE '%$cari_data%'  AND
                                  rm.tanggal_medis  =    '$tgl_medis'");
  $jml_data         = count($datas);
  $rekam_medis      = query("SELECT rm.*, ps.* FROM (tabel_medis rm
                              INNER JOIN tabel_pasien ps ON rm.id_pasien = ps.id_pasien)
                              WHERE rm.tipe_pasien    LIKE  '%$cari_data%'   OR
                                    rm.diagnosa_medis LIKE  '%$cari_data%'   OR
                                    ps.nama_pasien    LIKE  '%$cari_data%'  AND
                                    rm.tanggal_medis  =     '$tgl_medis'
                              ORDER BY rm.id_medis DESC LIMIT $limit_start, $limit_data");
  $hal_link       = "?cari_rekmed=$cari_data";
  $halaman        = "on";
} else {
  $cari_data      = "";
  $datas          = query("SELECT rm.*, ps.* FROM (tabel_medis rm INNER JOIN tabel_pasien ps
                          ON rm.id_pasien = ps.id_pasien) WHERE rm.tanggal_medis = '$tgl_medis'");
  $jml_data       = count($datas);
  $rekam_medis    = query("SELECT rm.*, ps.* FROM (tabel_medis rm INNER JOIN tabel_pasien ps
                              ON rm.id_pasien = ps.id_pasien)
                              WHERE rm.tanggal_medis  = '$tgl_medis'
                                    ORDER BY rm.id_medis DESC LIMIT $limit_start, $limit_data");
  $hal_link       = "?";
  $halaman        = "";
}

$jml_halaman        = ceil($jml_data / $limit_data);
if ($jml_halaman <= 1) {
  $jml_nomor  = 0;
} else {
  $jml_nomor  = ($jml_halaman < 3) ? $jml_halaman - 1 : 1;
}
$nomor_awal   = ($hal_aktif > $jml_nomor) ? $hal_aktif - $jml_nomor : 1;
$nomor_akhir  = ($hal_aktif < ($jml_halaman - $jml_nomor)) ? $hal_aktif + $jml_nomor : $jml_halaman;

include "tambah-rekap-auto.php";

?>

<!-- CONTENT -->
<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <!-- Nama Halaman -->
        <div class="col-md-6">
          <h4>Halaman Rekam Medis</h4>
        </div>
        <!-- Menu Halaman -->
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="index.php">Beranda</a>
            </li>
            <?php if (isset($_GET["aksi"]) > 0) : ?>
              <?php if ($_GET["aksi"] == "ubah") : ?>
                <li class="breadcrumb-item">
                  <a href="rekam-medis.php">Rekam Medis</a>
                </li>
                <li class="breadcrumb-item">
                  <span>Ubah Data Rekam Medis</span>
                </li>
              <?php endif; ?>
            <?php else : ?>
              <li class="breadcrumb-item">
                <span>Tambah Rekam Medis</span>
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
      <?php if (isset($_GET["aksi"]) > 0) : ?>
        <?php if ($_GET["aksi"] == "ubah") : ?>
          <?php include "ubah-medis.php"; ?>
        <?php endif; ?>
      <?php else : ?>
        <?php include "tambah-medis.php"; ?>
      <?php endif; ?>

      <!-- Tabel Data Rekam Medis -->
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Tabel Data Rekam Medis (Hari ini)</h5>
            </div>
            <div class="card-body">
              <form action="" method="post">
                <div class="row" style="margin-top: -10px;">
                  <!-- Pencarian Data Rekmed -->
                  <div class="col-md-6">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah_rekap1">
                      Rekap Data (Hari Ini)
                    </button>
                  </div>
                  <div class="col-md-6 input-group">
                    <?php if ($halaman == "on") : ?>
                      <input type="text" name="cari_rekmed" id="cari_rekmed" class="form-control" value="<?= $cari_data; ?>" readonly autocomplete="off">
                      <div class="input-group-append">
                        <a href="?" name="btn_carirekmed" id="btn_carirekmed" class="btn btn-info">
                          <i class="fas fa-retweet"></i>&emsp;Reset Data
                        </a>
                      </div>
                    <?php else : ?>
                      <input type="text" name="cari_rekmed" id="cari_rekmed" class="form-control" placeholder="Pencarian data rekam medis" value="<?= $cari_data; ?>" autocomplete="off">
                      <div class="input-group-append">
                        <button type="submit" name="btn_carirekmed" id="btn_carirekmed" class="btn btn-info">
                          <i class="fas fa-search"></i>&emsp;Cari Data
                        </button>
                      </div>
                    <?php endif; ?>
                  </div>
                  <!-- /Pencarian Data Rekmed -->
                </div>
              </form>

              <!-- Tabel Data Rekmed -->
              <div class="row mt-2">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                      <thead class="text-center bg-success">
                        <th style="color: black;">NO.</th>
                        <th style="color: black;">TANGGAL</th>
                        <th style="color: black;">SHIFT</th>
                        <th style="color: black;">NAMA PASIEN</th>
                        <th style="color: black;">TIPE</th>
                        <th style="color: black;">DIAGNOSA PASIEN</th>
                        <th style="color: black;">AKSI</th>
                      </thead>
                      <?php $mulai = $limit_data * ($hal_aktif - 1); ?>
                      <?php $number = $mulai + 1; ?>
                      <?php foreach ($rekam_medis as $rm) : ?>
                        <tbody>
                          <tr>
                            <td width="50" class="text-center"><?= $number; ?></td>
                            <td width="110" class="text-center"><?= $rm["tanggal_medis"]; ?></td>
                            <td width="75" class="text-center"><?= $rm["shift_medis"]; ?></td>
                            <td><?= $rm["nama_pasien"]; ?></td>
                            <td width="75" class="text-center"><?= $rm["tipe_pasien"]; ?></td>
                            <td><?= $rm["diagnosa_medis"]; ?></td>
                            <td width="245">
                              <!-- Tombol Info -->
                              <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#info_medis<?= $rm["id_medis"]; ?>" style="width: 75px;">
                                <i class="fas fa-info-circle"></i>&ensp;Info
                              </button>
                              <?php include "rekam-medis-modal.php"; ?>
                              <!-- Tombol Ubah -->
                              <a href="?aksi=ubah&id=<?= $rm["id_medis"]; ?>" class="btn btn-sm btn-warning" style="width: 75px;">
                                <i class="fas fa-edit"></i>&ensp;Ubah
                              </a>
                              <!-- Tombol Cetak -->
                              <a href="cetak-faktur.php?id=<?= $rm["id_medis"]; ?>" class="btn btn-sm btn-success" target="blank" style="width: 75px;">
                                <i class="fas fa-print"></i>&ensp;Cetak
                              </a>
                            </td>
                          </tr>
                          <?php $number++; ?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- /Tabel Data Rekmed -->

              <!-- Informasi Jumlah Data Rekmed & Pagination-->
              <div class="row">
                <!-- Info Jumlah Data -->
                <div class="col-md-7 row">
                  <?php require "hitung.php"; ?>
                  <div class="col-md-6">
                    <table class="justify-content-start">
                      <tr>
                        <td>Tanggal</td>
                        <td>&emsp;:&emsp;</td>
                        <?php $tgl_sekarang = date("d / m / Y"); ?>
                        <td><?= $tgl_sekarang; ?></td>
                      </tr>
                      <tr>
                        <td>Shift Jaga</td>
                        <td>&emsp;:&emsp;</td>
                        <td><?= $waktu; ?></td>
                      </tr>
                      <tr>
                        <td>Jumlah Kunjungan</td>
                        <td>&emsp;:&emsp;</td>
                        <td><?= $kunjungan; ?>&emsp;Orang</td>
                      </tr>
                      <tr>
                        <td>Total Biaya Medis</td>
                        <td>&emsp;:&emsp;</td>
                        <td>Rp. <?= $total_bill; ?></td>
                      </tr>
                    </table>
                  </div>
                  <div class="col-md-6">
                    <table class="justify-content-start">
                      <tr>
                        <td>Jml Pasien Umum</td>
                        <td>&emsp;:&emsp;</td>
                        <td><?= $umum; ?>&emsp;Orang</td>
                      </tr>
                      <tr>
                        <td>Jml Pasien Bpjs</td>
                        <td>&emsp;:&emsp;</td>
                        <td><?= $bpjs; ?>&emsp;Orang</td>
                      </tr>
                      <tr>
                        <td>Jml Pasien Aqua</td>
                        <td>&emsp;:&emsp;</td>
                        <td><?= $aqua; ?>&emsp;Orang</td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- Pagination -->
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
              <!-- /Informasi Jumlah Data Rekmed & Pagination -->
            </div>
          </div>
        </div>
      </div>
      <!-- /Tabel Data Rekam Medis -->
    </div>
  </section>
  <!-- /Main Content -->
</div>
<!-- /CONTENT -->

<?php

include "footer.php";

?>