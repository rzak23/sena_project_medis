<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("location:login.php");
  exit;
}

$page = "DATA LAPORAN";

include "header.php";
include "sidebar.php";

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
            <?php if (isset($_GET["aksi"]) > 0) : ?>
              <?php if ($_GET["aksi"] == "laporan-harian") : ?>
                <li class="breadcrumb-item">
                  <a href="laporan.php">Menu Laporan</a>
                </li>
                <li class="breadcrumb-item">
                  <span>Rekapan Data Harian</span>
                </li>
              <?php elseif ($_GET["aksi"] == "laporan-bulanan") : ?>
                <li class="breadcrumb-item">
                  <a href="laporan.php">Menu Laporan</a>
                </li>
                <li class="breadcrumb-item">
                  <span>Rekapan Data Bulanan</span>
                </li>
              <?php elseif ($_GET["aksi"] == "laporan-gaji") : ?>
                <li class="breadcrumb-item">
                  <a href="laporan.php">Menu Laporan</a>
                </li>
                <li class="breadcrumb-item">
                  <span>Laporan Gaji Dokter</span>
                </li>
              <?php elseif ($_GET["aksi"] == "laporan-pemasukan-bersih") : ?>
                <li class="breadcrumb-item">
                  <a href="laporan.php">Menu Laporan</a>
                </li>
                <li class="breadcrumb-item">
                  <span>Laporan Pemasukan Bersih</span>
                </li>
              <?php elseif ($_GET["aksi"] == "laporan-beli-obat") : ?>
                <li class="breadcrumb-item">
                  <a href="laporan.php">Menu Laporan</a>
                </li>
                <li class="breadcrumb-item">
                  <span>Rekapan Pembelian Obat</span>
                </li>
              <?php elseif ($_GET["aksi"] == "laporan-bayar-obat") : ?>
                <li class="breadcrumb-item">
                  <a href="laporan.php">Menu Laporan</a>
                </li>
                <li class="breadcrumb-item">
                  <span>Rekapan Pembayaran Obat</span>
                </li>
              <?php endif; ?>
            <?php else : ?>
              <li class="breadcrumb-item">
                <span>Menu Laporan</span>
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
      <?php

      if (isset($_GET["aksi"]) > 0) {
        if ($_GET["aksi"] == "laporan-harian") {
          include "menu-laporan-harian.php";
        } elseif ($_GET["aksi"] == "laporan-bulanan") {
          include "menu-laporan-bulanan.php";
        } elseif ($_GET["aksi"] == "laporan-gaji") {
          include "menu-laporan-gaji.php";
        } elseif ($_GET["aksi"] == "laporan-pemasukan-bersih") {
          include "menu-laporan-pemasukan.php";
        } elseif ($_GET["aksi"] == "laporan-beli-obat") {
          include "menu-laporan-pembelian.php";
        } elseif ($_GET["aksi"] == "laporan-bayar-obat") {
          include "menu-laporan-pembayaran.php";
        }
      } else {
        include "menu-laporan.php";
      }

      ?>
    </div>
  </section>
  <!-- /Main Content -->
</div>
<!-- /CONTENT -->

<?php

include "footer.php";

?>