<?php
$tipe_pengguna = $_SESSION["tipe"];
?>
<!-- Menu Laporan -->
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Menu Laporan</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <?php if ($tipe_pengguna == "ADMIN") : ?>
            <!-- Menu Laporan Harian -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <a href="menu-laporan-harian.php" class="info-box-icon btn bg-gradient-red elevation-1">
                  <i class="fas fa-file-invoice"></i>
                </a>
                <div class="info-box-content">
                  <span class="info-box-text">Rekapan Data</span>
                  <span class="info-box-text">Harian</span>
                </div>
              </div>
            </div>
            <!-- Menu Laporan Bulanan -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <a href="menu-laporan-bulanan.php" class="info-box-icon btn bg-gradient-orange elevation-1">
                  <i class="fas fa-file-invoice text-white"></i>
                </a>
                <div class="info-box-content">
                  <span class="info-box-text">Rekapan Data</span>
                  <span class="info-box-text">Bulanan</span>
                </div>
              </div>
            </div>
            <!-- Menu Laporan Gaji Dokter -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <a href="menu-laporan-gaji.php" class="info-box-icon btn bg-gradient-yellow elevation-1">
                  <i class="fas fa-file-invoice text-white"></i>
                </a>
                <div class="info-box-content">
                  <span class="info-box-text">Laporan Data</span>
                  <span class="info-box-text">Gaji Dokter</span>
                </div>
              </div>
            </div>
            <!-- Menu Laporan Pemasukan Bersih -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <a href="menu-laporan-pemasukan.php" class="info-box-icon btn bg-gradient-green elevation-1">
                  <i class="fas fa-file-invoice"></i>
                </a>
                <div class="info-box-content">
                  <span class="info-box-text">Laporan Data</span>
                  <span class="info-box-text">Pemasukan Bersih</span>
                </div>
              </div>
            </div>
            <!-- Menu Laporan Pembelian Obat -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <a href="menu-laporan-pembelian.php" class="info-box-icon btn bg-gradient-blue elevation-1">
                  <i class="fas fa-file-invoice"></i>
                </a>
                <div class="info-box-content">
                  <span class="info-box-text">Rekapan Data</span>
                  <span class="info-box-text">Pembelian Obat</span>
                </div>
              </div>
            </div>
            <!-- Menu Laporan Pembayaran Obat -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <a href="menu-laporan-pembayaran.php" class="info-box-icon btn bg-gradient-purple elevation-1">
                  <i class="fas fa-file-invoice"></i>
                </a>
                <div class="info-box-content">
                  <span class="info-box-text">Rekapan Data</span>
                  <span class="info-box-text">Pembayaran Obat</span>
                </div>
              </div>
            </div>
          <?php elseif ($tipe_pengguna == "DOKTER") : ?>
            <!-- Menu Laporan Harian -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <a href="#" class="info-box-icon btn bg-gradient-red elevation-1">
                  <i class="fas fa-file-invoice"></i>
                </a>
                <div class="info-box-content">
                  <span class="info-box-text">Rekapan Data</span>
                  <span class="info-box-text">Harian</span>
                </div>
              </div>
            </div>
            <!-- Menu Laporan Bulanan -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <a href="#" class="info-box-icon btn bg-gradient-orange elevation-1">
                  <i class="fas fa-file-invoice text-white"></i>
                </a>
                <div class="info-box-content">
                  <span class="info-box-text">Rekapan Data</span>
                  <span class="info-box-text">Bulanan</span>
                </div>
              </div>
            </div>
            <!-- Menu Laporan Gaji Dokter -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <a href="menu-laporan-gaji.php" class="info-box-icon btn bg-gradient-yellow elevation-1">
                  <i class="fas fa-file-invoice text-white"></i>
                </a>
                <div class="info-box-content">
                  <span class="info-box-text">Laporan Data</span>
                  <span class="info-box-text">Gaji Dokter</span>
                </div>
              </div>
            </div>
            <!-- Menu Laporan Pemasukan Bersih -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <a href="#" class="info-box-icon btn bg-gradient-green elevation-1">
                  <i class="fas fa-file-invoice"></i>
                </a>
                <div class="info-box-content">
                  <span class="info-box-text">Laporan Data</span>
                  <span class="info-box-text">Pemasukan Bersih</span>
                </div>
              </div>
            </div>
            <!-- Menu Laporan Pembelian Obat -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <a href="#" class="info-box-icon btn bg-gradient-blue elevation-1">
                  <i class="fas fa-file-invoice"></i>
                </a>
                <div class="info-box-content">
                  <span class="info-box-text">Rekapan Data</span>
                  <span class="info-box-text">Pembelian Obat</span>
                </div>
              </div>
            </div>
            <!-- Menu Laporan Pembayaran Obat -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <a href="#" class="info-box-icon btn bg-gradient-purple elevation-1">
                  <i class="fas fa-file-invoice"></i>
                </a>
                <div class="info-box-content">
                  <span class="info-box-text">Rekapan Data</span>
                  <span class="info-box-text">Pembayaran Obat</span>
                </div>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /Menu Laporan -->