<?php

if (!isset($_SESSION["login"])) {
  header("location:login.php");
  exit;
}

$nama_pengguna = $_SESSION["username"];
$tipe_pengguna = $_SESSION["tipe"];
?>

<!-- SIDEBAR -->
<aside class="main-sidebar sidebar-dark-success elevation-4">
  <!-- Logo & Nama -->
  <a href="index.php" class="brand-link navbar-success">
    <img src="dist/img/logo-system.png" alt="logo" class="brand-image img-circle elevation-3" style="opacity: 0.8;">
    <span class="brand-text font-weight-light">&ensp;
      <strong>SIREKMED - KPPM</strong>
    </span>
  </a>
  <!-- /Logo & Nama -->

  <!-- Sidebar Menu -->
  <div class="sidebar">
    <!-- User Login -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="dist/img/user.jpg" alt="icon-user" class="img-circle elevation-2">
      </div>
      <div class="info">
        <strong class="d-block ml-1 text-white" style="font-size: 12pt;"><?= ucwords($nama_pengguna); ?></strong>
      </div>
    </div>
    <!-- /User Login -->

    <!-- Menu System -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <?php if ($tipe_pengguna == "ADMIN") : ?>
          <!-- Menu Beranda -->
          <?php $active = ($page == "BERANDA") ? "active" : ""; ?>
          <li class="nav-item">
            <a href="index.php" class="nav-link <?= $active; ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Beranda</p>
            </a>
          </li>
          <!-- Menu Rekam Medis -->
          <?php $active = ($page == "REKAM MEDIS") ? "active" : ""; ?>
          <li class="nav-item">
            <a href="rekam-medis.php" class="nav-link <?= $active; ?>">
              <i class="nav-icon fas fa-heartbeat"></i>
              <p>Rekam Medis</p>
            </a>
          </li>
          <!-- Menu Data Rekam Medis -->
          <?php $active = ($page == "DATA REKAM MEDIS") ? "active" : ""; ?>
          <li class="nav-item">
            <a href="rekam-medis-data.php" class="nav-link <?= $active; ?>">
              <i class="nav-icon fas fa-book-medical"></i>
              <p>Data Rekam Medis</p>
            </a>
          </li>
          <!-- Menu Data Rekap Medis -->
          <?php $active = ($page == "DATA REKAP MEDIS") ? "active" : ""; ?>
          <li class="nav-item">
            <a href="rekap-medis.php" class="nav-link <?= $active; ?>">
              <i class="nav-icon fas fa-file-medical-alt"></i>
              <p>Data Rekap Medis</p>
            </a>
          </li>

          <?php

          if ($page == "DATA TAGIHAN OBAT") {
            $menu_active = "menu-open";
            $actives = "active";
          } elseif ($page == "DATA PEMBAYARAN OBAT") {
            $menu_active = "menu-open";
            $actives = "active";
          } else {
            $menu_active = "";
            $actives = "";
          }

          ?>

          <!-- Menu Transaksi Obat -->
          <li class="nav-item has-treeview <?= $menu_active; ?>">
            <a href="#" class="nav-link <?= $actives; ?>">
              <i class="nav-icon fas fa-pills"></i>
              <p>Transaksi Obat<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <!-- Menu Data Tagihan Obat -->
              <?php $active = ($page == "DATA TAGIHAN OBAT") ? "active" : ""; ?>
              <li class="nav-item">
                <a href="tagihan-obat.php" class="nav-link <?= $active; ?>">
                  <i class="nav-icon fas fa-file-invoice text-danger"></i>
                  <p>Data Tagihan Obat</p>
                </a>
              </li>
              <!-- Menu Data Pembayaran Obat -->
              <?php $active = ($page == "DATA PEMBAYARAN OBAT") ? "active" : ""; ?>
              <li class="nav-item">
                <a href="pembayaran-obat.php" class="nav-link <?= $active; ?>">
                  <i class="nav-icon fas fa-file-invoice-dollar text-success"></i>
                  <p>Data Pembayaran Obat</p>
                </a>
              </li>
            </ul>
          </li>

          <?php

          if ($page == "DATA PENGELUARAN MEDIS") {
            $menu_active = "menu-open";
            $actives = "active";
          } elseif ($page == "DATA PEMASUKAN MEDIS") {
            $menu_active = "menu-open";
            $actives = "active";
          } else {
            $menu_active = "";
            $actives = "";
          }

          ?>

          <!-- Menu Transaksi Medis -->
          <li class="nav-item has-treeview <?= $menu_active; ?>">
            <a href="#" class="nav-link <?= $actives; ?>">
              <i class="nav-icon fas fa-coins"></i>
              <p>Transaksi Medis<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <!-- Menu Data Pengeluaran Medis -->
              <?php $active = ($page == "DATA PENGELUARAN MEDIS") ? "active" : ""; ?>
              <li class="nav-item">
                <a href="pengeluaran-medis.php" class="nav-link <?= $active; ?>">
                  <i class="nav-icon fas fa-file-export text-danger"></i>
                  <p>Data Pengeluaran Medis</p>
                </a>
              </li>
              <!-- Menu Data Pemasukan Medis -->
              <?php $active = ($page == "DATA PEMASUKAN MEDIS") ? "active" : ""; ?>
              <li class="nav-item">
                <a href="pemasukan-medis.php" class="nav-link <?= $active; ?>">
                  <i class="nav-icon fas fa-file-import text-success"></i>
                  <p>Data Pemasukan Medis</p>
                </a>
              </li>
            </ul>
          </li>

          <?php

          if ($page == "DATA PENGGUNA") {
            $menu_active = "menu-open";
            $actives = "active";
          } elseif ($page == "DATA DOKTER") {
            $menu_active = "menu-open";
            $actives = "active";
          } elseif ($page == "DATA PARAMEDIS") {
            $menu_active = "menu-open";
            $actives = "active";
          } elseif ($page == "DATA PASIEN") {
            $menu_active = "menu-open";
            $actives = "active";
          } else {
            $menu_active = "";
            $actives = "";
          }

          ?>

          <!-- Menu Master -->
          <li class="nav-item has-treeview <?= $menu_active; ?>">
            <a href="#" class="nav-link <?= $actives; ?>">
              <i class="nav-icon fas fa-server"></i>
              <p>Master<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <!-- Menu Data Pengguna -->
              <?php $active = ($page == "DATA PENGGUNA") ? "active" : ""; ?>
              <li class="nav-item">
                <a href="master-pengguna.php" class="nav-link <?= $active; ?>">
                  <i class="nav-icon fas fa-user text-primary"></i>
                  <p>Data Pengguna</p>
                </a>
              </li>
              <!-- Menu Data Dokter -->
              <?php $active = ($page == "DATA DOKTER") ? "active" : ""; ?>
              <li class="nav-item">
                <a href="master-dokter.php" class="nav-link <?= $active; ?>">
                  <i class="nav-icon fas fa-user-md text-success"></i>
                  <p>Data Dokter</p>
                </a>
              </li>
              <!-- Menu Data Paramedis -->
              <?php $active = ($page == "DATA PARAMEDIS") ? "active" : ""; ?>
              <li class="nav-item">
                <a href="master-paramedis.php" class="nav-link <?= $active; ?>">
                  <i class="nav-icon fas fa-user-nurse text-info"></i>
                  <p>Data Paramedis</p>
                </a>
              </li>
              <!-- Menu Data Pasien -->
              <?php $active = ($page == "DATA PASIEN") ? "active" : ""; ?>
              <li class="nav-item">
                <a href="master-pasien.php" class="nav-link <?= $active; ?>">
                  <i class="nav-icon fas fa-user-injured text-danger"></i>
                  <p>Data Pasien</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- Menu Laporan Medis -->
          <?php $active = ($page == "DATA LAPORAN") ? "active" : ""; ?>
          <li class="nav-item">
            <a href="laporan.php" class="nav-link <?= $active; ?>">
              <i class="nav-icon fas fa-file"></i>
              <p>Laporan Medis</p>
            </a>
          </li>
          <!-- Menu Setting -->
          <?php $active = ($page == "DATA PENGATURAN") ? "active" : ""; ?>
          <li class="nav-item">
            <a href="pengaturan.php" class="nav-link <?= $active; ?>">
              <i class="nav-icon fas fa-cogs"></i>
              <p>Pengaturan</p>
            </a>
          </li>
        <?php elseif ($tipe_pengguna == "PARAMEDIS") : ?>
          <!-- Menu Beranda -->
          <?php $active = ($page == "BERANDA") ? "active" : ""; ?>
          <li class="nav-item">
            <a href="index.php" class="nav-link <?= $active; ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Beranda</p>
            </a>
          </li>
          <!-- Menu Rekam Medis -->
          <?php $active = ($page == "REKAM MEDIS") ? "active" : ""; ?>
          <li class="nav-item">
            <a href="rekam-medis.php" class="nav-link <?= $active; ?>">
              <i class="nav-icon fas fa-heartbeat"></i>
              <p>Rekam Medis</p>
            </a>
          </li>
          <!-- Menu Data Rekam Medis -->
          <?php $active = ($page == "DATA REKAM MEDIS") ? "active" : ""; ?>
          <li class="nav-item">
            <a href="rekam-medis-data.php" class="nav-link <?= $active; ?>">
              <i class="nav-icon fas fa-book-medical"></i>
              <p>Data Rekam Medis</p>
            </a>
          </li>
          <!-- Menu Data Rekap Medis -->
          <?php $active = ($page == "DATA REKAP MEDIS") ? "active" : ""; ?>
          <li class="nav-item">
            <a href="rekap-medis.php" class="nav-link <?= $active; ?>">
              <i class="nav-icon fas fa-file-medical-alt"></i>
              <p>Data Rekap Medis</p>
            </a>
          </li>
        <?php elseif ($tipe_pengguna == "DOKTER") : ?>
          <!-- Menu Beranda -->
          <?php $active = ($page == "BERANDA") ? "active" : ""; ?>
          <li class="nav-item">
            <a href="index.php" class="nav-link <?= $active; ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Beranda</p>
            </a>
          </li>
          <!-- Menu Laporan Medis -->
          <?php $active = ($page == "DATA LAPORAN") ? "active" : ""; ?>
          <li class="nav-item">
            <a href="laporan.php" class="nav-link <?= $active; ?>">
              <i class="nav-icon fas fa-file"></i>
              <p>Laporan Medis</p>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
    <!-- /Menu System -->
  </div>
  <!-- /Sidebar Menu -->
</aside>
<!-- /SIDEBAR -->