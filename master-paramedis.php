<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("location:login.php");
  exit;
}

$page = "DATA PARAMEDIS";

include "header.php";
include "sidebar.php";
include "database.php";
// Pagination Tabel
$hal_aktif            = (isset($_REQUEST["hal"])) ? $_REQUEST["hal"] : 1;
$limit_data           = 10;
$limit_start          = ($hal_aktif - 1) * $limit_data;
if (isset($_REQUEST["cari_param"]) > 0) {
  $cari_data          = $_REQUEST["cari_param"];
  $datas              = query("SELECT * FROM tabel_paramedis WHERE
                                nama_param         LIKE  '%$cari_data%'  OR
                                jns_kelamin_param  LIKE  '%$cari_data%'  OR
                                alamat_param       LIKE  '%$cari_data%'  OR
                                telepon_param      LIKE  '%$cari_data%'");
  $jml_data           = count($datas);
  $paramedis          = query("SELECT * FROM tabel_paramedis WHERE
                                nama_param         LIKE  '%$cari_data%'  OR
                                jns_kelamin_param  LIKE  '%$cari_data%'  OR
                                alamat_param       LIKE  '%$cari_data%'  OR
                                telepon_param      LIKE  '%$cari_data%'
                                LIMIT $limit_start, $limit_data");
  $hal_link           = "?cari_param=$cari_data";
  $halaman            = "on";
} else {
  $cari_data          = "";
  $datas              = query("SELECT * FROM tabel_paramedis");
  $jml_data           = count($datas);
  $paramedis          = query("SELECT * FROM tabel_paramedis LIMIT $limit_start, $limit_data");
  $hal_link           = "?";
  $halaman            = "";
}

$jml_halaman      = ceil($jml_data / $limit_data);
if ($jml_halaman <= 1) {
  $jml_nomor      = 0;
} else {
  $jml_nomor      = ($jml_halaman < 3) ? $jml_halaman - 1 : 1;
}
$nomor_awal       = ($hal_aktif > $jml_nomor) ? $hal_aktif - $jml_nomor : 1;
$nomor_akhir      = ($hal_aktif < ($jml_halaman - $jml_nomor)) ? $hal_aktif + $jml_nomor : $jml_halaman;

include "tambah-paramedis.php";

?>

<!-- CONTENT -->
<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <!-- Nama Halaman -->
        <div class="col-md-6">
          <h4>Halaman Paramedis</h4>
        </div>
        <!-- Menu Halaman -->
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="index.php">Beranda</a>
            </li>
            <li class="breadcrumb-item">
              <span>Data Paramedis</span>
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
      <!-- Tabel Data Paramedis -->
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Data Paramedis</h5>
            </div>
            <div class="card-body" style="margin-bottom: -20px;">
              <form action="" method="post">
                <div class="row" style="margin-top: -10px;">
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah_param">
                      <i class="fas fa-plus-square"></i>&ensp;Tambah Data
                    </button>
                  </div>
                  <div class="offset-4 col-md-6">
                    <div class="input-group">
                      <?php if ($halaman == "on") : ?>
                        <input type="text" name="cari_param" id="cari_param" class="form-control" value="<?= $cari_data; ?>" readonly autocomplete="off">
                        <div class="input-group-append">
                          <a href="?" name="btn_cariparam" id="btn_cariparam" class="btn btn-info">
                            <i class="fas fa-retweet"></i>&emsp;Reset Data
                          </a>
                        </div>
                      <?php else : ?>
                        <input type="text" name="cari_param" id="cari_param" class="form-control" placeholder="Cari data paramedis" autocomplete="off">
                        <div class="input-group-append">
                          <button type="submit" name="btn_cariparam" id="btn_cariparam" class="btn btn-info">
                            <i class="fas fa-search"></i>&emsp; Cari Data
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
                      <th style="color: black;">NAMA PARAMEDIS</th>
                      <th style="color: black;">JENIS KELAMIN</th>
                      <th style="color: black;">ALAMAT</th>
                      <th style="color: black;">NO. TELEPON</th>
                      <th style="color: black;">AKSI</th>
                    </thead>
                    <?php
                    $mulai = $limit_data * ($hal_aktif - 1);
                    $number = $mulai + 1;
                    ?>
                    <?php foreach ($paramedis as $pm) : ?>
                      <tbody>
                        <tr>
                          <td width="50" class="text-center"><?= $number; ?></td>
                          <td><?= $pm["nama_param"]; ?></td>
                          <td width="150" class="text-center"><?= $pm["jns_kelamin_param"]; ?></td>
                          <td><?= $pm["alamat_param"]; ?></td>
                          <td width="125" class="text-center"><?= $pm["telepon_param"]; ?></td>
                          <td width="170">
                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#ubah_param<?= $pm["id_param"]; ?>" style="width: 75px;">
                              <i class="fas fa-edit"></i>&ensp;Ubah
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapus_param<?= $pm["id_param"]; ?>" style="width: 80px;">
                              <i class="fas fa-trash"></i>&ensp;Hapus
                            </button>
                          </td>
                          <?php include "ubah-paramedis.php" ?>
                          <?php include "hapus-paramedis.php" ?>
                        </tr>
                        <?php $number++; ?>
                      <?php endforeach; ?>
                      </tbody>
                  </table>
                </div>
              </div>
              <!-- /Tabel Data -->

              <!-- Paggination Data Paramedis -->
              <div class="row" style="margin-top: -5px;">
                <!-- Pagination Tabel -->
                <div class="offset-6 col-md-6">
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
              <!-- /Paggination Data Paramedis -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /Tabel Data Paramedis -->
</div>
</section>
<!-- /Main Content -->
</div>
<!-- /CONTENT -->

<?php

include "footer.php";

?>