<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("location:login.php");
  exit;
}

$page = "DATA LAPORAN";

include "header.php";
include "sidebar.php";
include "database.php";

// Pagination
$hal_aktif        = (isset($_REQUEST["hal"])) ? $_REQUEST["hal"] : 1;
$limit_data       = 10;
$limit_start      = ($hal_aktif - 1) * $limit_data;
if (isset($_REQUEST["awal_bayar"]) && ($_REQUEST["akhir_bayar"]) > 0) {
  $halaman        = "on";
  $tgl_awal       = $_REQUEST["awal_bayar"];
  $tgl_akhir      = $_REQUEST["akhir_bayar"];
  $jml_data       = count(query("SELECT * FROM tabel_obat WHERE status_tagihan = 'Sudah Dibayar' AND tanggal_tagihan BETWEEN '$tgl_awal' AND '$tgl_akhir'"));
  $laporan_bayar  = query("SELECT * FROM tabel_obat WHERE status_tagihan = 'Sudah Dibayar' AND tanggal_tagihan BETWEEN '$tgl_awal' AND '$tgl_akhir' LIMIT $limit_start, $limit_data");
  $data           = count($laporan_bayar);
  $hal_link       = "?halaman=on&awal_bayar=$tgl_awal&akhir_bayar=$tgl_akhir";
  $hal_cetak      = "?awal_bayar=$tgl_awal&akhir_bayar=$tgl_akhir";
} else {
  $tgl_awal         = null;
  $tgl_akhir        = null;
  $halaman          = "";
  $jml_data         = 0;
  $laporan_bayar    = [];
  $data             = 0;
  $hal_cetak        = "";
}
$jml_halaman      = ceil($jml_data / $limit_data);
$jml_nomor        = 2;
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
          <h4>Halaman Laporan</h4>
        </div>
        <!-- Menu Halaman -->
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="index.php">Beranda</a>
            </li>
            <li class="breadcrumb-item">
              <a href="laporan.php">Menu Laporan</a>
            </li>
            <li class="breadcrumb-item">
              <span>Rekapan Pembayaran Obat</span>
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
      <!-- Laporan Pembelian Obat -->
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Rekapan Pembayaran Obat</h5>
            </div>
            <div class="card-body">
              <!-- Form Cari Data Laporan -->
              <form action="" method="post">
                <div class="row" style="margin-top: -10px;">
                  <!-- Tanggal Awal -->
                  <div class="col-md-5">
                    <div class="form-group row">
                      <label for="awal_bayar" class="col-md-4 col-form-label">Tanggal Awal</label>
                      <div class="col-md-8">
                        <input type="date" name="awal_bayar" id="awal_bayar" value="<?= $tgl_awal; ?>" class="form-control">
                      </div>
                    </div>
                  </div>
                  <!-- Tanggal Akhir -->
                  <div class="col-md-5">
                    <div class="form-group row">
                      <label for="akhir_bayar" class="col-md-4 col-form-label">Tanggal Akhir</label>
                      <div class="col-md-8">
                        <input type="date" name="akhir_bayar" id="akhir_bayar" value="<?= $tgl_akhir; ?>" class="form-control">
                      </div>
                    </div>
                  </div>
                  <!-- Tombol Cari -->
                  <div class="col-md-2">
                    <?php if ($halaman == "on") : ?>
                      <a href="?" class="btn btn-block btn-info">Reset Pencarian</a>
                    <?php else : ?>
                      <button type="submit" name="cari_bayar" id="cari_bayar" class="btn btn-block btn-info">
                        <i class="fas fa-search"></i>&emsp;Tampil Data
                      </button>
                    <?php endif; ?>
                  </div>
                </div>
                <hr style="margin-top: -5px;">
              </form>
              <!-- /Form Cari Data Laporan -->

              <!-- Tabel Data Laporan Pembelian Obat -->
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-sm table-bordered">
                    <thead class="text-center bg-gradient-purple">
                      <th>NO.</th>
                      <th>TANGGAL FAKTUR</th>
                      <th>TANGGAL BAYAR</th>
                      <th>NAMA APOTEK</th>
                      <th>STATUS FAKTUR</th>
                      <th>JUMLAH PEMBAYARAN</th>
                    </thead>
                    <?php
                    $mulai = $limit_data * ($hal_aktif - 1);
                    $number = $mulai + 1;
                    ?>
                    <?php foreach ($laporan_bayar as $bayar) : ?>
                      <tbody>
                        <tr>
                          <td width="50" class="text-center"><?= $number; ?></td>
                          <td width="150" class="text-center"><?= $bayar["tanggal_tagihan"]; ?></td>
                          <td width="150" class="text-center"><?= $bayar["tanggal_bayar"]; ?></td>
                          <td>&ensp;<?= $bayar["nama_apotek"]; ?></td>
                          <td width="150" class="text-center"><?= $bayar["status_tagihan"]; ?></td>
                          <td width="200" class="text-center">Rp. <?= number_format($bayar["bayar_tagihan"], 0, ".", "."); ?></td>
                        </tr>
                        <?php $number++; ?>
                      <?php endforeach; ?>
                      </tbody>
                  </table>
                </div>
              </div>
              <div class="row">
                <!-- Info Jumlah Data -->
                <div class="col-md-6">
                  <h6>Jumlah Data :&emsp;<b style="font-size: 14pt;"><?= $data; ?></b>&emsp;item</h6>
                  <a href="laporan-pembayaran.php<?= $hal_cetak; ?>" target="blank" class="btn btn-sm btn-success">
                    <i class="fas fa-print"></i>&emsp;Cetak Laporan
                  </a>
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
              <!-- /Tabel Data Laporan Pembelian Obat -->
            </div>
          </div>
        </div>
      </div>
      <!-- /Laporan Pembelian Obat -->
    </div>
  </section>
  <!-- /Main Content -->
</div>
<!-- /CONTENT -->

<?php

include "footer.php";

?>