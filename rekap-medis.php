<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("location:login.php");
  exit;
}

$page         = "DATA REKAP MEDIS";

$tgl_rekap    = date("Y-m-d");

include "header.php";
include "sidebar.php";
include "database.php";

// Pagination Tabel
$hal_aktif          = (isset($_REQUEST["hal"])) ? $_REQUEST["hal"] : 1;
$limit_data         = 10;
$limit_start        = ($hal_aktif - 1) * $limit_data;
if (isset($_REQUEST["cari_rekap"]) > 0) {
  $cari_data        = $_REQUEST["cari_rekap"];
  $datas            = query("SELECT rk.*, dr.* FROM (tabel_rekap rk INNER JOIN tabel_dokter dr
                            ON rk.id_dokter = dr.id_dokter)
                            WHERE rk.tanggal_rekap  LIKE  '%$cari_data%'  OR
                                  rk.shift_rekap    LIKE  '%$cari_data%'  OR
                                  dr.nama_dokter    LIKE  '%$cari_data%'");
  $jml_data         = count($datas);
  $rekap_medis      = query("SELECT rk.*, dr.* FROM (tabel_rekap rk INNER JOIN tabel_dokter dr
                              ON rk.id_dokter = dr.id_dokter)
                              WHERE rk.tanggal_rekap  LIKE  '%$cari_data%'  OR
                                    rk.shift_rekap    LIKE  '%$cari_data%'  OR
                                    dr.nama_dokter    LIKE  '%$cari_data%'
                              ORDER BY rk.id_rekap DESC LIMIT $limit_start, $limit_data");
  $hal_link         = "?cari_rekap=$cari_data";
  $halaman          = "on";

  // Hitung Total Rekap Billing
  $biaya2           = query("SELECT SUM(rk.total_biaya) AS biaya FROM (tabel_rekap rk INNER JOIN tabel_dokter dr
                            ON rk.id_dokter = dr.id_dokter)
                            WHERE rk.tanggal_rekap  LIKE  '%$cari_data%'  OR
                                  rk.shift_rekap    LIKE  '%$cari_data%'  OR
                                  dr.nama_dokter    LIKE  '%$cari_data%'")[0];
  $total_biaya2     = number_format($biaya2["biaya"], 0, ".", ".");

  // Hitung Total Rekap Kunjungan
  $kunjungan        = query("SELECT SUM(rk.kunjungan) AS kunjung FROM (tabel_rekap rk INNER JOIN tabel_dokter dr
                            ON rk.id_dokter = dr.id_dokter)
                            WHERE rk.tanggal_rekap  LIKE  '%$cari_data%'  OR
                                  rk.shift_rekap    LIKE  '%$cari_data%'  OR
                                  dr.nama_dokter    LIKE  '%$cari_data%'")[0];
  $total_kunjungan  = number_format($kunjungan["kunjung"], 0, ".", ".");

  // Hitung Total Rekap Umum
  $pasien_umum      = query("SELECT SUM(rk.pasien_umum) AS umum FROM (tabel_rekap rk INNER JOIN tabel_dokter dr
                              ON rk.id_dokter = dr.id_dokter)
                              WHERE rk.tanggal_rekap  LIKE  '%$cari_data%'  OR
                                    rk.shift_rekap    LIKE  '%$cari_data%'  OR
                                    dr.nama_dokter    LIKE  '%$cari_data%'")[0];
  $total_umum       = number_format($pasien_umum["umum"], 0, ".", ".");

  // Hitung Total Rekap Bpjs
  $pasien_bpjs      = query("SELECT SUM(rk.pasien_bpjs) AS bpjs FROM (tabel_rekap rk INNER JOIN tabel_dokter dr
                              ON rk.id_dokter = dr.id_dokter)
                              WHERE rk.tanggal_rekap  LIKE  '%$cari_data%'  OR
                                    rk.shift_rekap    LIKE  '%$cari_data%'  OR
                                    dr.nama_dokter    LIKE  '%$cari_data%'")[0];
  $total_bpjs       = number_format($pasien_bpjs["bpjs"], 0, ".", ".");

  // Hitung Total Rekap Aqua
  $pasien_aqua      = query("SELECT SUM(rk.pasien_aqua) AS aqua FROM (tabel_rekap rk INNER JOIN tabel_dokter dr
                              ON rk.id_dokter = dr.id_dokter)
                              WHERE rk.tanggal_rekap  LIKE  '%$cari_data%'  OR
                                    rk.shift_rekap    LIKE  '%$cari_data%'  OR
                                    dr.nama_dokter    LIKE  '%$cari_data%'")[0];
  $total_aqua       = number_format($pasien_aqua["aqua"], 0, ".", ".");
} else {
  $cari_data        = "";
  $datas            = query("SELECT * FROM tabel_rekap");
  $jml_data         = count($datas);
  $rekap_medis      = query("SELECT rk.*, dr.* FROM (tabel_rekap rk INNER JOIN tabel_dokter dr
                              ON rk.id_dokter = dr.id_dokter)
                              ORDER BY rk.id_rekap DESC LIMIT $limit_start, $limit_data");
  $hal_link         = "?";
  $halaman          = "";

  // Hitung Total Rekap Billing
  $biaya2           = query("SELECT SUM(total_biaya) AS biaya FROM tabel_rekap")[0];
  $total_biaya2     = number_format($biaya2["biaya"], 0, ".", ".");

  // Hitung Total Rekap Kunjungan
  $kunjungan        = query("SELECT SUM(kunjungan) AS kunjung FROM tabel_rekap")[0];
  $total_kunjungan  = number_format($kunjungan["kunjung"], 0, ".", ".");

  // Hitung Total Rekap Umum
  $pasien_umum      = query("SELECT SUM(pasien_umum) AS umum FROM tabel_rekap")[0];
  $total_umum       = number_format($pasien_umum["umum"], 0, ".", ".");

  // Hitung Total Rekap Bpjs
  $pasien_bpjs      = query("SELECT SUM(pasien_bpjs) AS bpjs FROM tabel_rekap")[0];
  $total_bpjs       = number_format($pasien_bpjs["bpjs"], 0, ".", ".");

  // Hitung Total Rekap Aqua
  $pasien_aqua      = query("SELECT SUM(pasien_aqua) AS aqua FROM tabel_rekap")[0];
  $total_aqua       = number_format($pasien_aqua["aqua"], 0, ".", ".");
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
          <h4>Halaman Data Rekap Medis</h4>
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
                  <a href="rekap-medis.php">Data Rekap Medis</a>
                </li>
                <li class="breadcrumb-item">
                  <span>Tambah Rekap Medis</span>
                </li>
              <?php elseif ($_GET["aksi"] == "ubah") : ?>
                <li class="breadcrumb-item">
                  <a href="rekap-medis.php">Data Rekap Medis</a>
                </li>
                <li class="breadcrumb-item">
                  <span>Ubah Rekap Medis</span>
                </li>
              <?php endif; ?>
            <?php else : ?>
              <li class="breadcrumb-item">
                <span>Data Rekap Medis</span>
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
        <?php if ($_GET["aksi"] == "tambah") : ?>
          <?php include "tambah-rekap.php"; ?>
        <?php elseif ($_GET["aksi"] == "ubah") : ?>
          <?php include "ubah-rekap.php"; ?>
        <?php endif; ?>
      <?php endif; ?>

      <!-- Tabel Data Rekam Medis -->
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Tabel Data Rekap Medis</h5>
            </div>
            <div class="card-body">
              <form action="" method="post">
                <div class="row">
                  <!-- Tombol Tambah Data Rekmed -->
                  <div class="col-md-6">
                    <a href="?aksi=tambah" class="btn btn-primary">
                      <i class="fas fa-plus-square"></i>&ensp;Tambah Data
                    </a>
                  </div>
                  <!-- /Tombol Tambah Data Rekmed -->
                  <!-- Pencarian Data Rekmed -->
                  <div class="col-md-6 input-group">
                    <?php if ($halaman == "on") : ?>
                      <input type="text" name="cari_rekap" id="cari_rekap" class="form-control" value="<?= $cari_data; ?>" readonly autocomplete="off">
                      <div class="input-group-append">
                        <a href="?" name="btn_carirekap" id="btn_carirekap" class="btn btn-info">
                          <i class="fas fa-retweet"></i>&emsp;Reset
                        </a>
                      </div>
                    <?php else : ?>
                      <input type="text" name="cari_rekap" id="cari_rekap" class="form-control" placeholder="Cari Data Rekap" autocomplete="off">
                      <div class="input-group-append">
                        <button type="submit" name="btn_carirekap" id="btn_carirekap" class="btn btn-info">
                          <i class="fas fa-search"></i>&emsp;Cari
                        </button>
                      </div>
                    <?php endif; ?>
                  </div>
                  <!-- /Pencarian Data Rekmed -->
                </div>
              </form>

              <!-- Tabel Data Rekmed -->
              <div class="row mt-3">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                      <thead class="text-center bg-success">
                        <th style="color: black;">NO.</th>
                        <th style="color: black;">TANGGAL</th>
                        <th style="color: black;">SHIFT</th>
                        <th style="color: black;">NAMA DOKTER</th>
                        <th style="color: black;">UMUM</th>
                        <th style="color: black;">BPJS</th>
                        <th style="color: black;">AQUA</th>
                        <th style="color: black;">TOTAL PASIEN</th>
                        <th style="color: black;">JUMLAH BIAYA</th>
                        <th style="color: black;">AKSI</th>
                      </thead>
                      <?php $mulai = $limit_data * ($hal_aktif - 1); ?>
                      <?php $number = $mulai + 1; ?>
                      <?php foreach ($rekap_medis as $rk) : ?>
                        <tbody>
                          <tr>
                            <td width="50" class="text-center"><?= $number; ?></td>
                            <td width="110" class="text-center"><?= $rk["tanggal_rekap"]; ?></td>
                            <td width="60" class="text-center"><?= $rk["shift_rekap"]; ?></td>
                            <td><?= $rk["nama_dokter"]; ?></td>
                            <td width="60" class="text-center"><?= $rk["pasien_umum"]; ?></td>
                            <td width="60" class="text-center"><?= $rk["pasien_bpjs"]; ?></td>
                            <td width="60" class="text-center"><?= $rk["pasien_aqua"]; ?></td>
                            <td width="125" class="text-center"><?= $rk["kunjungan"]; ?></td>
                            <td width="150" class="text-left">&ensp;Rp. <?= number_format($rk["total_biaya"], 0, ".", "."); ?></td>
                            <td width="77">
                              <!-- Tombol Ubah -->
                              <a href="?aksi=ubah&id=<?= $rk["id_rekap"]; ?>" class="btn btn-sm btn-warning" style="width: 75px;">
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
              </div>
              <!-- /Tabel Data Rekmed -->

              <!-- Informasi Jumlah Data Rekmed & Pagination-->
              <div class="row">
                <!-- Info Jumlah Data -->
                <div class="col-md-6">
                  <table class="justify-content-start">
                    <tr>
                      <td>Jumlah Pasien UMUM</td>
                      <td>&emsp;:&emsp;</td>
                      <td><?= $total_umum; ?></td>
                    </tr>
                    <tr>
                      <td>Jumlah Pasien BPJS</td>
                      <td>&emsp;:&emsp;</td>
                      <td><?= $total_bpjs; ?></td>
                    </tr>
                    <tr>
                      <td>Jumlah Pasien AQUA</td>
                      <td>&emsp;:&emsp;</td>
                      <td><?= $total_aqua; ?></td>
                    </tr>
                    <tr>
                      <td>Jumlah Kunjungan</td>
                      <td>&emsp;:&emsp;</td>
                      <td><?= $total_kunjungan; ?></td>
                    </tr>
                    <tr>
                      <td>Total Biaya Medis</td>
                      <td>&emsp;:&emsp;</td>
                      <td>Rp. <?= $total_biaya2; ?></td>
                    </tr>
                  </table>
                </div>
                <!-- Pagination -->
                <div class="col-md-6">
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