<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("location:login.php");
  exit;
}

$page = "DATA PENGGUNA";

include "header.php";
include "sidebar.php";
include "database.php";

// ==> Pagination Tabel
$hal_aktif            = (isset($_REQUEST["hal"])) ? $_REQUEST["hal"] : 1;
$limit_data           = 10;
$limit_start          = ($hal_aktif - 1) * $limit_data;
if (isset($_REQUEST["cari_pengguna"]) > 0) {
  $cari_data          = $_REQUEST["cari_pengguna"];
  $datas              = query("SELECT * FROM tabel_pengguna WHERE
                                tanggal_pengguna  LIKE  '%$cari_data%'  OR
                                nama_pengguna     LIKE  '%$cari_data%'  OR
                                tipe_pengguna     LIKE  '%$cari_data%'  OR
                                kode_keamanan     LIKE  '%$cari_data%'");
  $jml_data           = count($datas);
  $pengguna           = query("SELECT * FROM tabel_pengguna WHERE
                                tanggal_pengguna  LIKE  '%$cari_data%'  OR
                                nama_pengguna     LIKE  '%$cari_data%'  OR
                                tipe_pengguna     LIKE  '%$cari_data%'  OR
                                kode_keamanan     LIKE  '%$cari_data%'
                                LIMIT $limit_start, $limit_data");
  $hal_link           = "?cari_pengguna=$cari_data";
  $halaman            = "on";
} else {
  $cari_data          = "";
  $datas              = query("SELECT * FROM tabel_pengguna");
  $jml_data           = count($datas);
  $pengguna           = query("SELECT * FROM tabel_pengguna LIMIT $limit_start, $limit_data");
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

include "tambah-pengguna.php";

?>

<!-- CONTENT -->
<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <!-- Nama Halaman -->
        <div class="col-md-6">
          <h4>Halaman Pengguna</h4>
        </div>
        <!-- Menu Halaman -->
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="index.php">Beranda</a>
            </li>
            <li class="breadcrumb-item">
              <span>Data Pengguna</span>
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
              <h5 class="card-title">Data Pengguna</h5>
            </div>
            <div class="card-body" style="margin-bottom: -20px;">
              <form action="" method="post">
                <div class="row" style="margin-top: -10px;">
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah_pengguna">
                      <i class="fas fa-plus-square"></i>&ensp;Tambah Data
                    </button>
                  </div>
                  <div class="offset-4 col-md-6">
                    <div class="input-group">
                      <?php if ($halaman == "on") : ?>
                        <input type="text" name="cari_pengguna" id="cari_pengguna" class="form-control" value="<?= $cari_data; ?>" readonly autocomplete="off">
                        <div class="input-group-append">
                          <a href="?" name="btn_caripengguna" id="btn_caripengguna" class="btn btn-info">
                            <i class="fas fa-retweet"></i>&emsp;Reset Data
                          </a>
                        </div>
                      <?php else : ?>
                        <input type="text" name="cari_pengguna" id="cari_pengguna" class="form-control" placeholder="Cari data pengguna" autocomplete="off">
                        <div class="input-group-append">
                          <button type="submit" name="btn_caripengguna" id="btn_caripengguna" class="btn btn-info">
                            <i class="fas fa-search"></i>&emsp;Cari Data
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
                      <th style="color: black;">TGL DAFTAR</th>
                      <th style="color: black;">USERNAME</th>
                      <th style="color: black;">TIPE PENGGUNA</th>
                      <th style="color: black;">KODE KEAMANAN</th>
                      <th style="color: black;">AKSI</th>
                    </thead>
                    <?php
                    $mulai = $limit_data * ($hal_aktif - 1);
                    $number = $mulai + 1;
                    ?>
                    <?php foreach ($pengguna as $pg) : ?>
                      <tbody>
                        <tr>
                          <td width="50" class="text-center"><?= $number; ?></td>
                          <td width="125" class="text-center"><?= $pg["tanggal_pengguna"]; ?></td>
                          <td>&emsp;<?= $pg["nama_pengguna"]; ?></td>
                          <td width="150" class="text-center"><?= $pg["tipe_pengguna"]; ?></td>
                          <td width="200" class="text-center"><?= $pg["kode_keamanan"]; ?></td>
                          <td width="300">
                            <?php if ($pg["tipe_pengguna"] == "ADMIN") : ?>
                              <button type="button" class="btn btn-sm btn-success btn-block mb-1" data-toggle="modal" data-target="#lupa_sandi<?= $pg["id_pengguna"]; ?>">
                                <i class="fas fa-key"></i>&ensp;Lupa Sandi
                              </button>
                            <?php else : ?>
                              <button type="button" class="btn btn-sm btn-success mb-1" data-toggle="modal" data-target="#lupa_sandi<?= $pg["id_pengguna"]; ?>" style="width: 125px;">
                                <i class="fas fa-key"></i>&ensp;Lupa Sandi
                              </button>
                              <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#ubah_pengguna<?= $pg["id_pengguna"]; ?>" style="width: 75px;">
                                <i class="fas fa-edit"></i>&ensp;Ubah
                              </button>
                              <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapus_pengguna<?= $pg["id_pengguna"]; ?>" style="width: 80px;">
                                <i class="fas fa-trash"></i>&ensp;Hapus
                              </button>
                            <?php endif; ?>
                          </td>
                          <?php include "sandi-pengguna.php" ?>
                          <?php include "ubah-pengguna.php" ?>
                          <?php include "hapus-pengguna.php" ?>
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