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
if (isset($_REQUEST["awal_gaji"]) && ($_REQUEST["akhir_gaji"]) > 0) {
  $halaman        = "on";
  $tgl_awal       = $_REQUEST["awal_gaji"];
  $tgl_akhir      = $_REQUEST["akhir_gaji"];
  $id_dokter      = $_REQUEST["dokter_gaji"];
  $jml_data       = count(query("SELECT * FROM tabel_rekap WHERE 
                                  tanggal_rekap BETWEEN '$tgl_awal' AND '$tgl_akhir' AND 
                                  id_dokter = '$id_dokter'"));
  $laporan_gaji   = query("SELECT * FROM tabel_rekap WHERE 
                            tanggal_rekap BETWEEN '$tgl_awal' AND '$tgl_akhir' AND
                            id_dokter = '$id_dokter' LIMIT $limit_start, $limit_data");
  $data           = count($laporan_gaji);
  $hal_link       = "?halaman=on&dokter_gaji=$id_dokter&awal_gaji=$tgl_awal&akhir_gaji=$tgl_akhir";
  $hal_link2      = "?dokter_gaji=$id_dokter&awal_gaji=$tgl_awal&akhir_gaji=$tgl_akhir";
} else {
  $tgl_awal       = null;
  $tgl_akhir      = null;
  $halaman        = "";
  $jml_data       = 0;
  $laporan_gaji   = [];
  $data           = 0;
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
              <span>Laporan Gaji Dokter</span>
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
      <!-- Laporan Gaji -->
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Rekapan Data Harian</h5>
            </div>
            <div class="card-body">
              <!-- Form Cari Data Laporan -->
              <form action="" method="post">
                <div class="row" style="margin-top: -10px;">
                  <!-- Pilih Dokter -->
                  <div class="col-md-3">
                    <select name="dokter_gaji" id="dokter_gaji" class="js-example-placeholder-single js-states form-control">
                      <option></option>
                      <?php $dokter = query("SELECT * FROM tabel_dokter"); ?>
                      <?php foreach ($dokter as $dr) : ?>
                        <?php $select = ($dr["id_dokter"] == $id_dokter) ? "selected" : ""; ?>
                        <option value="<?= $dr["id_dokter"]; ?>" <?= $select; ?>><?= $dr["nama_dokter"]; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <!-- Tanggal Awal -->
                  <div class="col-md-3">
                    <div class="form-group row">
                      <label for="awal_gaji" class="col-md-4 col-form-label text-center">Awal</label>
                      <div class="col-md-8">
                        <input type="date" name="awal_gaji" id="awal_gaji" class="form-control" value="<?= $tgl_awal; ?>">
                      </div>
                    </div>
                  </div>
                  <!-- Tanggal Akhir -->
                  <div class="col-md-3">
                    <div class="form-group row">
                      <label for="akhir_gaji" class="col-md-4 col-form-label text-center">Akhir</label>
                      <div class="col-md-8">
                        <input type="date" name="akhir_gaji" id="akhir_gaji" class="form-control" value="<?= $tgl_akhir; ?>">
                      </div>
                    </div>
                  </div>
                  <!-- Tombol Cari -->
                  <div class="col-md-3">
                    <?php if ($halaman == "on") : ?>
                      <a href="?" class="btn btn-block btn-info">Reset Pencarian</a>
                    <?php else : ?>
                      <button type="submit" name="btn_carigaji" class="btn btn-block btn-info">
                        <i class="fas fa-search"></i>&emsp;Tampil Data
                      </button>
                    <?php endif; ?>
                  </div>
                </div>
                <hr style="margin-top: -5px;">
              </form>
              <!-- /Form Cari Data Laporan -->

              <!-- Tabel Data Laporan Gaji -->
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-sm table-bordered">
                    <thead class="text-center bg-gradient-yellow">
                      <th>NO.</th>
                      <th>TANGGAL</th>
                      <th>SHIFT</th>
                      <th>PASIEN UMUM</th>
                      <th>PASIEN BPJS</th>
                      <th>PASIEN AQUA</th>
                      <th>TOTAL PASIEN</th>
                      <th>BILLING</th>
                    </thead>
                    <?php
                    $mulai = $limit_data * ($hal_aktif - 1);
                    $number = $mulai + 1;
                    ?>
                    <?php foreach ($laporan_gaji as $lg) : ?>
                      <tbody>
                        <tr>
                          <td width="50" class="text-center"><?= $number; ?></td>
                          <td width="75" class="text-center"><?= $lg["tanggal_rekap"]; ?></td>
                          <td width="75" class="text-center"><?= $lg["shift_rekap"]; ?></td>
                          <td width="125" class="text-center"><?= $lg["pasien_umum"]; ?></td>
                          <td width="125" class="text-center"><?= $lg["pasien_bpjs"]; ?></td>
                          <td width="125" class="text-center"><?= $lg["pasien_aqua"]; ?></td>
                          <td width="125" class="text-center"><?= $lg["kunjungan"]; ?></td>
                          <td width="125" class="text-left">&ensp;Rp. <?= number_format($lg["total_biaya"], 0, ".", "."); ?></td>
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
                  <a href="laporan-gaji.php<?= $hal_link2; ?>" target="blank" class="btn btn-sm btn-success">
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
              <!-- /Tabel Data Laporan Gaji -->
            </div>
          </div>
        </div>
      </div>
      <!-- /Laporan Gaji -->
    </div>
  </section>
  <!-- /Main Content -->
</div>
<!-- /CONTENT -->

<?php

include "footer.php";

?>