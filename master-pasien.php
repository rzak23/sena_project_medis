<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("location:login.php");
  exit;
}

$page = "DATA PASIEN";

include "header.php";
include "sidebar.php";
include "database.php";
// Pagination Tabel
$hal_aktif            = (isset($_REQUEST["hal"])) ? $_REQUEST["hal"] : 1;
$limit_data           = 10;
$limit_start          = ($hal_aktif - 1) * $limit_data;
if (isset($_REQUEST["cari_pasien"]) > 0) {
  $cari_data          = $_REQUEST["cari_pasien"];
  $datas              = query("SELECT * FROM tabel_pasien WHERE
                                nama_pasien         LIKE  '%$cari_data%'  OR
                                jns_kelamin_pasien  LIKE  '%$cari_data%'  OR
                                alamat_pasien       LIKE  '%$cari_data%'  OR
                                umur_pasien         LIKE  '%$cari_data%'");
  $jml_data           = count($datas);
  $pasien             = query("SELECT * FROM tabel_pasien WHERE
                                nama_pasien         LIKE  '%$cari_data%'  OR
                                jns_kelamin_pasien  LIKE  '%$cari_data%'  OR
                                alamat_pasien       LIKE  '%$cari_data%'  OR
                                umur_pasien         LIKE  '%$cari_data%'
                                LIMIT $limit_start, $limit_data");
  $hal_link           = "?cari_pasien=$cari_data";
  $halaman            = "on";

  // Hitung Jumlah Pasien
  $jumlah_pasien      = query("SELECT COUNT(id_pasien) AS jml FROM tabel_pasien WHERE
                                nama_pasien         LIKE  '%$cari_data%'  OR
                                jns_kelamin_pasien  LIKE  '%$cari_data%'  OR
                                alamat_pasien       LIKE  '%$cari_data%'  OR
                                umur_pasien         LIKE  '%$cari_data%'")[0];
  $jml_pasien         = number_format($jumlah_pasien["jml"], 0, ".", ".");
} else {
  $cari_data          = "";
  $datas              = query("SELECT * FROM tabel_pasien");
  $jml_data           = count($datas);
  $pasien             = query("SELECT * FROM tabel_pasien LIMIT $limit_start, $limit_data");
  $hal_link           = "?";
  $halaman            = "";

  // Hitung Jumlah Pasien
  $jumlah_pasien      = query("SELECT COUNT(id_pasien) AS jml FROM tabel_pasien")[0];
  $jml_pasien         = number_format($jumlah_pasien["jml"], 0, ".", ".");
}

$jml_halaman      = ceil($jml_data / $limit_data);
if ($jml_halaman <= 1) {
  $jml_nomor      = 0;
} else {
  $jml_nomor      = ($jml_halaman < 3) ? $jml_halaman - 1 : 1;
}
$nomor_awal       = ($hal_aktif > $jml_nomor) ? $hal_aktif - $jml_nomor : 1;
$nomor_akhir      = ($hal_aktif < ($jml_halaman - $jml_nomor)) ? $hal_aktif + $jml_nomor : $jml_halaman;

include "tambah-pasien.php";

?>

<!-- CONTENT -->
<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <!-- Nama Halaman -->
        <div class="col-md-6">
          <h4>Halaman Pasien</h4>
        </div>
        <!-- Menu Halaman -->
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="index.php">Beranda</a>
            </li>
            <li class="breadcrumb-item">
              <span>Data Pasien</span>
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
      <!-- Tabel Data Pasien -->
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Data Pasien</h5>
            </div>
            <div class="card-body" style="margin-bottom: -20px;">
              <form action="" method="post">
                <div class="row" style="margin-top: -10px;">
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah_pasien">
                      <i class="fas fa-plus-square"></i>&ensp;Tambah Data
                    </button>
                  </div>
                  <div class="offset-4 col-md-6">
                    <div class="input-group">
                      <?php if ($halaman == "on") : ?>
                        <input type="text" name="cari_pasien" id="cari_pasien" class="form-control" value="<?= $cari_data; ?>" readonly autocomplete="off">
                        <div class="input-group-append">
                          <a href="?" name="btn_caripasien" id="btn_caripasien" class="btn btn-info">
                            <i class="fas fa-retweet"></i>&emsp;Reset Data
                          </a>
                        </div>
                      <?php else : ?>
                        <input type="text" name="cari_pasien" id="cari_pasien" class="form-control" placeholder="Cari data pasien" autocomplete="off">
                        <div class="input-group-append">
                          <button type="submit" name="btn_caripasien" id="btn_caripasien" class="btn btn-info">
                            <i class="fas fa-search"></i>&emsp;cari Data
                          </button>
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </form>
              <!-- Tabel Data -->
              <div class="row mt-2">
                <div class="col-md-12">
                  <table class="table table-sm table-bordered">
                    <thead class="text-center bg-success">
                      <th style="color: black;">NO.</th>
                      <th style="color: black;">NAMA LENGKAP (KTP)</th>
                      <th style="color: black;">JENIS KELAMIN</th>
                      <th style="color: black;">UMUR</th>
                      <th style="color: black;">ALAMAT (KTP)</th>
                      <th style="color: black;">AKSI</th>
                    </thead>
                    <?php $mulai = $limit_data * ($hal_aktif - 1); ?>
                    <?php $number = $mulai + 1; ?>
                    <?php foreach ($pasien as $ps) : ?>
                      <tbody>
                        <tr>
                          <td width="50" class="text-center"><?= $number; ?></td>
                          <td><?= $ps["nama_pasien"]; ?></td>
                          <td width="150" class="text-center"><?= $ps["jns_kelamin_pasien"]; ?></td>
                          <td width="75" class="text-center"><?= $ps["umur_pasien"]; ?></td>
                          <td><?= $ps["alamat_pasien"]; ?></td>
                          <td width="75">
                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#ubah_pasien<?= $ps["id_pasien"]; ?>" style="width: 75px;">
                              <i class="fas fa-edit"></i>&ensp;Ubah
                            </button>
                          </td>
                          <?php include "ubah-pasien.php" ?>
                        </tr>
                        <?php $number++; ?>
                      <?php endforeach; ?>
                      </tbody>
                  </table>
                </div>
              </div>
              <!-- /Tabel Data -->

              <!-- Paggination Data Pasien -->
              <div class="row" style="margin-top: -5px;">
                <!-- Pagination Tabel -->
                <div class="col-md-6">
                  <h5>Jumlah Data : <?= $jml_pasien; ?> Pasien</h5>
                </div>
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
              <!-- /Paggination Data Pasien -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /Tabel Data Pasien -->
</div>
</section>
<!-- /Main Content -->
</div>
<!-- /CONTENT -->

<?php

include "footer.php";

?>