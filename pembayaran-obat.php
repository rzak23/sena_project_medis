<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("location:login.php");
  exit;
}

$page = "DATA PEMBAYARAN OBAT";

$tgl_obat = date("Y-m-d");

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
  $cari_data      = "";
  $datas          = query("SELECT * FROM tabel_obat WHERE
                            (tanggal_tagihan  BETWEEN '$tgl_awal' AND '$tgl_akhir') OR
                            (tanggal_bayar    BETWEEN '$tgl_awal' AND '$tgl_akhir')");
  $jml_data       = count($datas);
  $pembayaran     = query("SELECT * FROM tabel_obat WHERE
                            (tanggal_tagihan  BETWEEN '$tgl_awal' AND '$tgl_akhir') OR
                            (tanggal_bayar    BETWEEN '$tgl_awal' AND '$tgl_akhir')
                            ORDER BY id_tagihan DESC LIMIT $limit_start, $limit_data");
  $hal_link       = "?tglawal_cari=$tgl_awal&tglakhir_cari=$tgl_akhir";
  $halaman        = "on";

  // Hitung Jumlah Tagihan
  $jml_tagihan      = query("SELECT COUNT(id_tagihan) AS tagihan FROM tabel_obat 
                              WHERE status_tagihan  = 'Belum Dibayar' AND
                                    ((tanggal_tagihan BETWEEN '$tgl_awal' AND '$tgl_akhir') OR
                                    (tanggal_bayar BETWEEN '$tgl_awal' AND '$tgl_akhir'))")[0];
  $hasil1           = number_format($jml_tagihan["tagihan"], 0, ".", ".");

  // Hitung Jumlah Pembayaran
  $jml_pembayaran   = query("SELECT COUNT(id_tagihan) AS pembayaran FROM tabel_obat
                              WHERE status_tagihan  = 'Sudah Dibayar' AND
                                    ((tanggal_tagihan BETWEEN '$tgl_awal' AND '$tgl_akhir') OR
                                    (tanggal_bayar BETWEEN '$tgl_awal' AND '$tgl_akhir'))")[0];
  $hasil2           = number_format($jml_pembayaran["pembayaran"], 0, ".", ".");

  // Hitung Total Tagihan
  $total_tagihan    = query("SELECT SUM(biaya_tagihan) AS tagihan FROM tabel_obat
                              WHERE status_tagihan  = 'Belum Dibayar' AND
                                    ((tanggal_tagihan BETWEEN '$tgl_awal' AND '$tgl_akhir') OR
                                    (tanggal_bayar BETWEEN '$tgl_awal' AND '$tgl_akhir'))")[0];
  $hasil3           = number_format($total_tagihan["tagihan"], 0, ".", ".");

  // Hitung Total Pembayaran
  $total_pembayaran = query("SELECT SUM(bayar_tagihan) AS bayar FROM tabel_obat
                              WHERE status_tagihan  = 'Sudah Dibayar' AND
                                    ((tanggal_tagihan BETWEEN '$tgl_awal' AND '$tgl_akhir') OR
                                    (tanggal_bayar BETWEEN '$tgl_awal' AND '$tgl_akhir'))")[0];
  $hasil4           = number_format($total_pembayaran["bayar"], 0, ".", ".");
} elseif (isset($_REQUEST["cari_pembayaran"]) > 0) {
  $tgl_awal         = "";
  $tgl_akhir        = "";
  $cari_data        = $_REQUEST["cari_pembayaran"];
  $datas            = query("SELECT * FROM tabel_obat WHERE
                              nomor_nota      LIKE  '%$cari_data%'  OR
                              nama_apotek     LIKE  '%$cari_data%'  OR
                              status_tagihan  LIKE  '%$cari_data%'");
  $jml_data         = count($datas);
  $pembayaran       = query("SELECT * FROM tabel_obat WHERE
                              nomor_nota      LIKE  '%$cari_data%'  OR
                              nama_apotek     LIKE  '%$cari_data%'  OR
                              status_tagihan  LIKE  '%$cari_data%'
                              ORDER BY id_tagihan DESC
                              LIMIT $limit_start, $limit_data");
  $hal_link         = "?cari_pembayaran=$cari_data";
  $halaman          = "on";

  // Hitung Jumlah Tagihan
  $jml_tagihan      = query("SELECT COUNT(id_tagihan) AS tagihan FROM tabel_obat 
                              WHERE status_tagihan  = 'Belum Dibayar' AND
                                    (nomor_nota     LIKE  '%$cari_data%'  OR
                                    nama_apotek     LIKE  '%$cari_data%'  OR
                                    status_tagihan  LIKE  '%$cari_data%')")[0];
  $hasil1           = number_format($jml_tagihan["tagihan"], 0, ".", ".");

  // Hitung Jumlah Pembayaran
  $jml_pembayaran   = query("SELECT COUNT(id_tagihan) AS pembayaran FROM tabel_obat
                              WHERE status_tagihan  = 'Sudah Dibayar' AND
                                    (nomor_nota     LIKE  '%$cari_data%'  OR
                                    nama_apotek     LIKE  '%$cari_data%'  OR
                                    status_tagihan  LIKE  '%$cari_data%')")[0];
  $hasil2           = number_format($jml_pembayaran["pembayaran"], 0, ".", ".");

  // Hitung Total Tagihan
  $total_tagihan    = query("SELECT SUM(biaya_tagihan) AS tagihan FROM tabel_obat
                              WHERE status_tagihan  = 'Belum Dibayar' AND
                                    (nomor_nota     LIKE  '%$cari_data%'  OR
                                    nama_apotek     LIKE  '%$cari_data%'  OR
                                    status_tagihan  LIKE  '%$cari_data%')")[0];
  $hasil3           = number_format($total_tagihan["tagihan"], 0, ".", ".");

  // Hitung Total Pembayaran
  $total_pembayaran = query("SELECT SUM(bayar_tagihan) AS bayar FROM tabel_obat
                              WHERE status_tagihan  = 'Sudah Dibayar' AND
                                    (nomor_nota     LIKE  '%$cari_data%'  OR
                                    nama_apotek     LIKE  '%$cari_data%'  OR
                                    status_tagihan  LIKE  '%$cari_data%')")[0];
  $hasil4           = number_format($total_pembayaran["bayar"], 0, ".", ".");
} else {
  $tgl_awal         = "";
  $tgl_akhir        = "";
  $cari_data        = "";
  $datas            = query("SELECT * FROM tabel_obat");
  $jml_data         = count($datas);
  $pembayaran       = query("SELECT * FROM tabel_obat ORDER BY id_tagihan DESC LIMIT $limit_start, $limit_data");
  $hal_link         = "?";
  $halaman          = "";

  // Hitung Jumlah Tagihan
  $jml_tagihan      = query("SELECT COUNT(id_tagihan) AS tagihan FROM tabel_obat WHERE status_tagihan = 'Belum Dibayar'")[0];
  $hasil1           = number_format($jml_tagihan["tagihan"], 0, ".", ".");

  // Hitung Jumlah Pembayaran
  $jml_pembayaran   = query("SELECT COUNT(id_tagihan) AS pembayaran FROM tabel_obat WHERE status_tagihan = 'Sudah Dibayar'")[0];
  $hasil2           = number_format($jml_pembayaran["pembayaran"], 0, ".", ".");

  // Hitung Total Tagihan
  $total_tagihan    = query("SELECT SUM(biaya_tagihan) AS tagihan FROM tabel_obat WHERE status_tagihan = 'Belum Dibayar'")[0];
  $hasil3           = number_format($total_tagihan["tagihan"], 0, ".", ".");

  // Hitung Total Pembayaran
  $total_pembayaran = query("SELECT SUM(bayar_tagihan) AS bayar FROM tabel_obat WHERE status_tagihan = 'Sudah Dibayar'")[0];
  $hasil4           = number_format($total_pembayaran["bayar"], 0, ".", ".");
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
          <h4>Halaman Pembayaran Obat</h4>
        </div>
        <!-- Menu Halaman -->
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="index.php">Beranda</a>
            </li>
            <li class="breadcrumb-item">
              <span>Data Pembayaran Obat</span>
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
      <!-- Tabel Data Tagihan Obat -->
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Data Pembayaran Obat</h5>
            </div>
            <div class="card-body" style="margin-bottom: -20px;">
              <form action="" method="post">
                <div class="row" style="margin-top: -10px;">
                  <div class="offset-1"></div>
                  <?php if ($halaman == "on") : ?>
                    <div class="col-md-6 form-horizontal">
                      <div class="row">
                        <div class="col-md-2 text-center">
                          <legend class="col-form-label">Tanggal</legend>
                        </div>
                        <div class="col-md-4">
                          <input type="date" name="tglawal_cari" id="tglawal_cari" class="form-control" value="<?= $tgl_awal; ?>" readonly style="font-size: 15px;">
                        </div>
                        <div class="col-md-2">
                          <legend class="col-form-label text-center">S/D</legend>
                        </div>
                        <div class="col-md-4">
                          <input type="date" name="tglakhir_cari" id="tglakhir_cari" class="form-control" value="<?= $tgl_akhir; ?>" readonly style="font-size: 15px;">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="input-group">
                        <input type="text" name="cari_pembayaran" id="cari_pembayaran" class="form-control" placeholder="Cari Data Pembayaran" value="<?= $cari_data; ?>" readonly autocomplete="off">
                        <div class="input-group-append">
                          <a href="?" name="btn_caripembayaran" id="btn_caripembayaran" class="btn btn-info">
                            <i class="fas fa-retweet"></i>&emsp;Reset
                          </a>
                        </div>
                      </div>
                    </div>
                  <?php else : ?>
                    <div class="col-md-6 form-horizontal">
                      <div class="row">
                        <div class="col-md-2 text-center">
                          <legend class="col-form-label">Tanggal</legend>
                        </div>
                        <div class="col-md-4">
                          <input type="date" name="tglawal_cari" id="tglawal_cari" class="form-control" style="font-size: 15px;">
                        </div>
                        <div class="col-md-2">
                          <legend class="col-form-label text-center">S/D</legend>
                        </div>
                        <div class="col-md-4">
                          <input type="date" name="tglakhir_cari" id="tglakhir_cari" class="form-control" style="font-size: 15px;">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="input-group">
                        <input type="text" name="cari_pembayaran" id="cari_pembayaran" class="form-control" placeholder="Cari Data Pembayaran" autocomplete="off">
                        <div class="input-group-append">
                          <button type="submit" name="btn_caripembayaran" id="btn_caripembayaran" class="btn btn-info">
                            <i class="fas fa-search"></i>&emsp;Cari
                          </button>
                        </div>
                      </div>
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
                      <th style="color: black;">TGL NOTA</th>
                      <th style="color: black;">TGL BAYAR</th>
                      <th style="color: black;">NO. NOTA</th>
                      <th style="color: black;">NAMA APOTEK</th>
                      <th style="color: black;">BIAYA TAGIHAN</th>
                      <th style="color: black;">STATUS</th>
                      <th style="color: black;">AKSI</th>
                    </thead>
                    <?php $mulai = $limit_data * ($hal_aktif - 1); ?>
                    <?php $number = $mulai + 1; ?>
                    <?php foreach ($pembayaran as $pb) : ?>
                      <tbody>
                        <tr>
                          <td width="50" class="text-center"><?= $number; ?></td>
                          <td width="100" class="text-center"><?= $pb["tanggal_tagihan"]; ?></td>
                          <td width="100" class="text-center"><?= $pb["tanggal_bayar"]; ?></td>
                          <td width="200" class="text-center"><?= $pb["nomor_nota"]; ?></td>
                          <td><?= $pb["nama_apotek"]; ?></td>
                          <td width="150">Rp. <?= number_format($pb["biaya_tagihan"], 0, ".", "."); ?></td>
                          <?php $status = ($pb["status_tagihan"] == 'Belum Dibayar') ? "text-danger" : "text-success"; ?>
                          <td width="125" class="<?= $status; ?> text-center"><?= $pb["status_tagihan"]; ?></td>
                          <td width="75">
                            <?php if ($pb["status_tagihan"] == "Belum Dibayar") : ?>
                              <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#bayar_tagihan<?= $pb["id_tagihan"]; ?>" style="width: 75px;">
                                <i class="fas fa-dollar-sign"></i>&ensp;Bayar
                              </button>
                            <?php else : ?>
                              <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#bayar_tagihan<?= $pb["id_tagihan"]; ?>" style="width: 75px;">
                                <i class="fas fa-edit"></i>&ensp;Ubah
                              </button>
                            <?php endif; ?>
                            <?php include "bayar-obat.php" ?>
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
              <div class="row mb-3" style="margin-top: -5px;">
                <!-- Informasi Data -->
                <div class="col-md-3">
                  <table class="justify-content-start">
                    <tr class="text-danger">
                      <td>Jumlah Tagihan</td>
                      <td>&emsp;:&emsp;</td>
                      <td><?= $hasil1; ?></td>
                    </tr>
                    <tr class="text-success">
                      <td>Jumlah Pembayaran</td>
                      <td>&emsp;:&emsp;</td>
                      <td><?= $hasil2; ?></td>
                    </tr>
                  </table>
                </div>
                <div class="col-md-5">
                  <table class="justify-content-start">
                    <tr class="text-danger">
                      <td>Belum Dibayar</td>
                      <td>&emsp;:&emsp;</td>
                      <td>Rp. <?= $hasil3; ?></td>
                    </tr>
                    <tr class="text-success">
                      <td>Sudah Dibayar</td>
                      <td>&emsp;:&emsp;</td>
                      <td>Rp. <?= $hasil4; ?></td>
                    </tr>
                  </table>
                </div>
                <!-- Pagination Tabel -->
                <div class="col-md-4">
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