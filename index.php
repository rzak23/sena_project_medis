<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("location:login.php");
  exit;
}

$page = "BERANDA";

include "header.php";
include "sidebar.php";
include "database.php";

?>
<!-- CONTENT -->
<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <!-- Nama Halaman -->
        <div class="col-md-6">
          <h4>Halaman Beranda</h4>
        </div>
        <!-- Menu Halaman -->
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="index.php">Beranda</a>
            </li>
            <li class="breadcrumb-item">
              <span>Linimasa</span>
            </li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- /Content Header -->

  <!-- Main Content -->
  <section class="content">
    <!-- Info Box -->
    <div class="row">
      <?php
      $dokter   = query("SELECT COUNT(id_dokter)    AS jml FROM tabel_dokter")[0];
      $param    = query("SELECT COUNT(id_param)     AS jml FROM tabel_paramedis")[0];
      $pasien   = query("SELECT COUNT(id_pasien)    AS jml FROM tabel_pasien")[0];
      $pengguna = query("SELECT COUNT(id_pengguna)  AS jml FROM tabel_pengguna")[0];
      ?>
      <!-- Info Box Dokter -->
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-success elevation-1">
            <i class="fas fa-user-md"></i>
          </span>
          <div class="info-box-content">
            <span class="info-box-text">Dokter</span>
            <span class="info-box-number"><?= $dokter["jml"]; ?> orang</span>
          </div>
        </div>
      </div>
      <!-- Info Box Paramedis -->
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-info elevation-1">
            <i class="fas fa-user-md"></i>
          </span>
          <div class="info-box-content">
            <span class="info-box-text">Paramedis</span>
            <span class="info-box-number"><?= $param["jml"]; ?> orang</span>
          </div>
        </div>
      </div>
      <!-- Info Box Pasien -->
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-danger elevation-1">
            <i class="fas fa-user-md"></i>
          </span>
          <div class="info-box-content">
            <span class="info-box-text">Pasien</span>
            <span class="info-box-number"><?= $pasien["jml"]; ?> orang</span>
          </div>
        </div>
      </div>
      <!-- Info Box Pengguna -->
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-primary elevation-1">
            <i class="fas fa-user-md"></i>
          </span>
          <div class="info-box-content">
            <span class="info-box-text">Pengguna</span>
            <span class="info-box-number"><?= $pengguna["jml"]; ?> orang</span>
          </div>
        </div>
      </div>
    </div>
    <!-- /Info Box -->

    <!-- Info Grafik -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Data Kunjungan Klinik</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <!-- Info Grafik Kunjungan Setahun -->
              <div class="col-md-8">
                <p class="text-center">
                  <strong>Grafik Kunjungan Tahun 2020</strong>
                </p>
                <div class="chart">
                  <canvas id="medis_grafik" height="200" style="height: 245px;"></canvas>
                </div>
              </div>
              <!-- Info Detail Grafik Kunjungan -->
              <div class="col-md-4">
                <p class="text-center">
                  <strong>Detail Grafik Kunjungan</strong>
                </p>
                <?php
                $tgl_data       = date("Y");
                $jml_umum       = query("SELECT COUNT(id_medis)  AS umum     FROM tabel_medis WHERE tipe_pasien = 'Umum' AND tanggal_medis LIKE '%$tgl_data%'")[0];
                $jml_bpjs       = query("SELECT COUNT(id_medis)  AS bpjs     FROM tabel_medis WHERE tipe_pasien = 'Bpjs' AND tanggal_medis LIKE '%$tgl_data%'")[0];
                $jml_aqua       = query("SELECT COUNT(id_medis)  AS aqua     FROM tabel_medis WHERE tipe_pasien = 'Aqua' AND tanggal_medis LIKE '%$tgl_data%'")[0];
                $jml_kunjungan  = query("SELECT COUNT(id_medis)  AS kunjung  FROM tabel_medis WHERE tanggal_medis LIKE '%$tgl_data%'")[0];

                if ($jml_umum["umum"] == 0 && $jml_bpjs["bpjs"] == 0 && $jml_aqua["aqua"] == 0 && $jml_kunjungan["kunjung"] == 0) {
                  $persen1 = 0;
                  $persen2 = 0;
                  $persen3 = 0;
                  $persen4 = 0;
                } else {
                  $persen1        = round(($jml_umum["umum"] / $jml_kunjungan["kunjung"]) * 100, 1);
                  $persen2        = round(($jml_bpjs["bpjs"] / $jml_kunjungan["kunjung"]) * 100, 1);
                  $persen3        = round(($jml_aqua["aqua"] / $jml_kunjungan["kunjung"]) * 100, 1);
                  $persen4        = 100;
                }
                ?>
                <!-- Pasien Umum -->
                <div class="progress-group mt-5">
                  Pasien UMUM
                  <span class="float-right"><b><?= number_format($jml_umum["umum"], 0, ".", "."); ?> Orang</b></span>
                  <div class="progress progress-sm">
                    <div class="progress-bar bg-danger" style="width: <?= $persen1; ?>%;"></div>
                  </div>
                </div>
                <!-- Pasien Bpjs -->
                <div class="progress-group">
                  Pasien BPJS
                  <span class="float-right"><b><?= number_format($jml_bpjs["bpjs"], 0, ".", "."); ?> Orang</b></span>
                  <div class="progress progress-sm">
                    <div class="progress-bar bg-success" style="width: <?= $persen2; ?>%;"></div>
                  </div>
                </div>
                <!-- Pasein Aqua -->
                <div class="progress-group">
                  Pasien AQUA
                  <span class="float-right"><b><?= number_format($jml_aqua["aqua"], 0, ".", "."); ?> Orang</b></span>
                  <div class="progress progress-sm">
                    <div class="progress-bar bg-primary" style="width: <?= $persen3; ?>%;"></div>
                  </div>
                </div>
                <!-- Total Kunjungang -->
                <div class="progress-group">
                  Total Kunjungan Pasien
                  <span class="float-right"><b><?= number_format($jml_kunjungan["kunjung"], 0, ".", "."); ?> Orang</b></span>
                  <div class="progress progress-sm">
                    <div class="progress-bar bg-secondary" style="width: <?= $persen4; ?>%;"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /Info Grafik -->
  </section>
  <!-- /Main Content -->
</div>
<!-- /CONTENT -->

<?php

include "footer.php";
include "chart.php";

?>