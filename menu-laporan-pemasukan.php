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
if (isset($_REQUEST["bulan_masuk"]) && ($_REQUEST["tahun_masuk"]) > 0) {
  $halaman        = "on";
  $tgl_awal       = $_REQUEST["bulan_masuk"];
  $tgl_akhir      = $_REQUEST["tahun_masuk"];
  $tanggal        = $tgl_akhir . "-" . $tgl_awal;
  $lap_kunjungan  = query("SELECT SUM(kunjungan) AS kunjung, 
                                  SUM(pasien_umum) AS umum, 
                                  SUM(pasien_bpjs) As bpjs, 
                                  SUM(pasien_aqua) AS aqua,
                                  SUM(total_biaya) AS total 
                          FROM tabel_rekap WHERE tanggal_rekap LIKE '%$tanggal%'")[0];
  $lap_pemasukan  = query("SELECT SUM(biaya_umum) AS umum,
                                  SUM(biaya_bpjs) AS bpjs,
                                  SUM(biaya_aqua) AS aqua,
                                  SUM(total_pemasukan) AS total
                          FROM tabel_pemasukan WHERE tanggal_pemasukan LIKE '%$tanggal%'")[0];
  $lap_pengeluaran  = query("SELECT * FROM tabel_pengeluaran WHERE tanggal_pengeluaran LIKE '%$tanggal%'")[0];
  $hal_link       = "?&bulan_masuk=$tgl_awal&tahun_masuk=$tgl_akhir";
  $kunjungan      = number_format($lap_kunjungan["kunjung"], 0, ".", ".");
  $umum           = number_format($lap_kunjungan["umum"], 0, ".", ".");
  $bpjs           = number_format($lap_kunjungan["bpjs"], 0, ".", ".");
  $aqua           = number_format($lap_kunjungan["aqua"], 0, ".", ".");
  $billing        = number_format($lap_kunjungan["total"], 0, ".", ".");
  $masuk_umum     = number_format($lap_pemasukan["umum"], 0, ".", ".");
  $masuk_bpjs     = number_format($lap_pemasukan["bpjs"], 0, ".", ".");
  $biaya          = query("SELECT biaya_bank FROM tabel_uang")[0];
  $masuk_aqua     = number_format(($lap_pemasukan["aqua"] - $biaya["biaya_bank"]), 0, ".", ".");
  $masuk_bill     = number_format(($lap_pemasukan["total"] - $biaya["biaya_bank"]), 0, ".", ".");
} else {
  $tgl_awal       = "";
  $tgl_akhir      = "";
  $tanggal        = null;
  $halaman        = "";
  $hal_link       = "?";
  $kunjungan      = 0;
  $umum           = 0;
  $bpjs           = 0;
  $aqua           = 0;
  $billing        = 0;
  $persen1        = 0;
  $persen2        = 0;
  $persen3        = 0;
  $masuk_umum     = 0;
  $masuk_bpjs     = 0;
  $masuk_aqua     = 0;
  $masuk_bill     = 0;
  $lap_pengeluaran["biaya_obat"] = 0;
  $lap_pengeluaran["biaya_gaji"] = 0;
  $lap_pengeluaran["biaya_harian"] = 0;
  $lap_pengeluaran["total_pengeluaran"] = 0;
}

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
              <span>Laporan Pemasukan Bersih</span>
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
      <!-- Laporan Pemasukan Bersih -->
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Laporan Pemasukan Bersih</h5>
            </div>
            <div class="card-body">
              <!-- Form Cari Data Laporan -->
              <form action="" method="post">
                <div class="row" style="margin-top: -10px;">
                  <!-- Pilih Bulan -->
                  <div class="col-md-5">
                    <div class="form-group row">
                      <label for="bulan_masuk" class="col-md-4 col-form-label">Bulan Laporan</label>
                      <div class="col-md-8">
                        <select name="bulan_masuk" id="bulan_masuk" class="js-example-placeholder-single js-states form-control">
                          <option></option>
                          <?php $select1 = ($tgl_awal == "01") ? "selected" : ""; ?>
                          <option value="01" <?= $select1; ?>>Januari</option>
                          <?php $select2 = ($tgl_awal == "02") ? "selected" : ""; ?>
                          <option value="02" <?= $select2; ?>>Pebruari</option>
                          <?php $select3 = ($tgl_awal == "03") ? "selected" : ""; ?>
                          <option value="03" <?= $select3; ?>>Maret</option>
                          <?php $select4 = ($tgl_awal == "04") ? "selected" : ""; ?>
                          <option value="04" <?= $select4; ?>>April</option>
                          <?php $select5 = ($tgl_awal == "05") ? "selected" : ""; ?>
                          <option value="05" <?= $select5; ?>>Mei</option>
                          <?php $select6 = ($tgl_awal == "06") ? "selected" : ""; ?>
                          <option value="06" <?= $select6; ?>>Juni</option>
                          <?php $select7 = ($tgl_awal == "07") ? "selected" : ""; ?>
                          <option value="07" <?= $select7; ?>>Juli</option>
                          <?php $select8 = ($tgl_awal == "08") ? "selected" : ""; ?>
                          <option value="08" <?= $select8; ?>>Agustus</option>
                          <?php $select9 = ($tgl_awal == "09") ? "selected" : ""; ?>
                          <option value="09" <?= $select9; ?>>September</option>
                          <?php $select10 = ($tgl_awal == "10") ? "selected" : ""; ?>
                          <option value="10" <?= $select10; ?>>Oktober</option>
                          <?php $select11 = ($tgl_awal == "11") ? "selected" : ""; ?>
                          <option value="11" <?= $select11; ?>>Nopember</option>
                          <?php $select12 = ($tgl_awal == "12") ? "selected" : ""; ?>
                          <option value="12" <?= $select12; ?>>Desember</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <!-- Pilih Tahun -->
                  <div class="col-md-5">
                    <div class="form-group row">
                      <label for="tahun_masuk" class="col-md-4 col-form-label">Tahun Laporan</label>
                      <div class="col-md-8">
                        <select name="tahun_masuk" id="tahun_masuk" class="js-example-placeholder-single js-states form-control">
                          <option></option>
                          <?php
                          $mulai = date('Y') - 20;
                          for ($i = $mulai; $i < $mulai + 100; $i++) {
                            echo '<option values="' . $i . '">' . $i . '</option>';
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <!-- Tombol Cari -->
                  <div class="col-md-2">
                    <?php if ($halaman == "on") : ?>
                      <a href="?" class="btn btn-block btn-info">Reset Pencarian</a>
                    <?php else : ?>
                      <button type="submit" name="btn_carimasuk" class="btn btn-block btn-info">
                        <i class="fas fa-search"></i>&emsp;Tampil Data
                      </button>
                    <?php endif; ?>
                  </div>
                </div>
                <hr style="margin-top: -5px;">
              </form>
              <!-- /Form Cari Data Laporan -->

              <!-- Data Pemasukan Bersih -->
              <div class="row" style="margin-top: -5px; margin-bottom: -10px;">
                <!-- Data Kunjungan -->
                <div class="col-md-4 border">
                  <h5 class="font-italic font-weight-bold text-blue">Data Kunjungan</h5>
                  <hr style="margin-top: -5px;">
                  <div class="form-group row" style="margin-top: -10px;">
                    <label class="col-md-5 col-form-label">Total Kunjungan</label>
                    <label class="col-md-1 col-form-label text-center">:</label>
                    <label class="col-md-6 col-form-label"><?= $kunjungan; ?> Pasien</label>
                  </div>
                  <div class="form-group row" style="margin-top: -20px;">
                    <label class="col-md-5 col-form-label">Pasien UMUM</label>
                    <label class="col-md-1 col-form-label text-center">:</label>
                    <?php
                    if (isset($lap_kunjungan["umum"]) > 0) {
                      $hasil1   = floatval(($lap_kunjungan["umum"] / $lap_kunjungan["kunjung"]) * 100);
                      $persen1  = round($hasil1, 1);
                    } else {
                      $persen1  = 0;
                    }
                    ?>
                    <label class="col-md-6 col-form-label"><?= $umum; ?> (<?= $persen1; ?>%)</label>
                  </div>
                  <div class="form-group row" style="margin-top: -20px;">
                    <label class="col-md-5 col-form-label">Pasien BPJS</label>
                    <label class="col-md-1 col-form-label text-center">:</label>
                    <?php
                    if (isset($lap_kunjungan["bpjs"]) > 0) {
                      $hasil2   = ($lap_kunjungan["bpjs"] / $lap_kunjungan["kunjung"]) * 100;
                      $persen2  = round($hasil2, 1);
                    } else {
                      $persen2  = 0;
                    }
                    ?>
                    <label class="col-md-5 col-form-label"><?= $bpjs; ?> (<?= $persen2; ?>%)</label>
                  </div>
                  <div class="form-group row" style="margin-top: -20px;">
                    <label class="col-md-5 col-form-label">Pasien AQUA</label>
                    <label class="col-md-1 col-form-label text-center">:</label>
                    <?php
                    if (isset($lap_kunjungan["aqua"]) > 0) {
                      $hasil3   = ($lap_kunjungan["aqua"] / $lap_kunjungan["kunjung"]) * 100;
                      $persen3  = round($hasil3, 1);
                    } else {
                      $persen3  = 0;
                    }
                    ?>
                    <label class="col-md-6 col-form-label"><?= $aqua; ?> (<?= $persen3; ?>%)</label>
                  </div>
                  <div class="form-group row" style="margin-top: -20px;">
                    <label class="col-md-5 col-form-label">Billing</label>
                    <label class="col-md-1 col-form-label text-center">:</label>
                    <label class="col-md-6 col-form-label">Rp. <?= $billing; ?></label>
                  </div>
                </div>
                <!-- Data Pemasukan -->
                <div class="col-md-4 border">
                  <h5 class="font-italic font-weight-bold text-green">Data Pemasukan</h5>
                  <hr style="margin-top: -5px;">
                  <div class="form-group row" style="margin-top: -10px;">
                    <label class="col-md-5 col-form-label">Billing UMUM</label>
                    <label class="col-md-1 col-form-label text-center">:</label>
                    <label class="col-md-6 col-form-label">Rp. <?= $masuk_umum; ?></label>
                  </div>
                  <div class="form-group row" style="margin-top: -20px;">
                    <label class="col-md-5 col-form-label">Billing BPJS</label>
                    <label class="col-md-1 col-form-label text-center">:</label>
                    <label class="col-md-6 col-form-label">Rp. <?= $masuk_bpjs; ?></label>
                    <?php $uang_bpjs  = query("SELECT uang_bpjs FROM tabel_uang")[0]; ?>
                    <p class="col-md-12 text-red text-left" style="margin-top: -5px; font-size: 10pt;">
                      Pasien BPJS x Rp. <?= number_format($uang_bpjs["uang_bpjs"], 0, ".", "."); ?>
                    </p>
                  </div>
                  <div class="form-group row" style="margin-top: -35px;">
                    <label class="col-md-5 col-form-label">Billing AQUA</label>
                    <label class="col-md-1 col-form-label text-center">:</label>
                    <label class="col-md-5 col-form-label">Rp. <?= $masuk_aqua; ?></label>
                    <?php
                    $uang_aqua  = query("SELECT uang_aqua FROM tabel_uang")[0];
                    $biaya_bank = query("SELECT biaya_bank FROM tabel_uang")[0];
                    ?>
                    <p class="col-md-12 text-red text-left" style="margin-top: -5px; font-size: 10pt;">
                      (Pasien AQUA x Rp. <?= number_format($uang_aqua["uang_aqua"], 0, '.', '.'); ?> ) - Rp. <?= number_format($biaya_bank["biaya_bank"], 0, '.', '.'); ?>
                    </p>
                  </div>
                  <div class="form-group row" style="margin-top: -35px;">
                    <label class="col-md-5 col-form-label">JML. Pemasukan</label>
                    <label class="col-md-1 col-form-label text-center">:</label>
                    <label class="col-md-6 col-form-label">Rp. <?= $masuk_bill; ?></label>
                    <p class="col-md-12 text-red text-left" style="margin-top: -5px; font-size: 10pt;">
                      ( Billing UMUM + Billing BPJS + Billing AQUA )
                    </p>
                  </div>
                </div>
                <!-- Data Pengeluaran -->
                <div class="col-md-4 border">
                  <h5 class="font-italic font-weight-bold text-red">Data Pengeluaran</h5>
                  <hr style="margin-top: -5px;">
                  <div class="form-group row" style="margin-top: -10px;">
                    <label class="col-md-6 col-form-label">Pembayaran Obat</label>
                    <label class="col-md-1 col-form-label text-center">:</label>
                    <label class="col-md-5 col-form-label">Rp. <?= number_format($lap_pengeluaran["biaya_obat"], 0, ".", "."); ?></label>
                  </div>
                  <div class="form-group row" style="margin-top: -20px;">
                    <label class="col-md-6 col-form-label">Gaji Pegawai</label>
                    <label class="col-md-1 col-form-label text-center">:</label>
                    <label class="col-md-5 col-form-label">Rp. <?= number_format($lap_pengeluaran["biaya_gaji"], 0, ".", "."); ?></label>
                  </div>
                  <div class="form-group row" style="margin-top: -20px;">
                    <label class="col-md-6 col-form-label">Pengeluaran Harian</label>
                    <label class="col-md-1 col-form-label text-center">:</label>
                    <label class="col-md-5 col-form-label">Rp. <?= number_format($lap_pengeluaran["biaya_harian"], 0, ".", "."); ?></label>
                  </div>
                  <div class="form-group row" style="margin-top: -20px;">
                    <label class="col-md-6 col-form-label">JML. Pengeluaran</label>
                    <label class="col-md-1 col-form-label text-center">:</label>
                    <label class="col-md-5 col-form-label">Rp. <?= number_format($lap_pengeluaran["total_pengeluaran"], 0, ".", "."); ?></label>
                  </div>
                </div>
                <!-- Total Pemasukan Bersih -->
                <div class="col-md-12 border">
                  <div class="form-group row mt-2" style="margin-bottom: -5px;">
                    <div class="col-md-4">
                      <?php
                      if ($tgl_awal == "01") {
                        $bulan = "Januari";
                      } elseif ($tgl_awal == "02") {
                        $bulan = "Pebruari";
                      } elseif ($tgl_awal == "03") {
                        $bulan = "Maret";
                      } elseif ($tgl_awal == "04") {
                        $bulan = "April";
                      } elseif ($tgl_awal == "05") {
                        $bulan = "Mei";
                      } elseif ($tgl_awal == "06") {
                        $bulan = "Juni";
                      } elseif ($tgl_awal == "07") {
                        $bulan = "Juli";
                      } elseif ($tgl_awal == "08") {
                        $bulan = "Agustus";
                      } elseif ($tgl_awal == "09") {
                        $bulan = "September";
                      } elseif ($tgl_awal == "10") {
                        $bulan = "Oktober";
                      } elseif ($tgl_awal == "11") {
                        $bulan = "Nopember";
                      } elseif ($tgl_awal == "12") {
                        $bulan = "Desember";
                      } else {
                        $bulan = "";
                      }
                      ?>
                      <h5 class="font-italic font-weight-bold">Pemasukan Bersih (<?= $bulan; ?> - <?= $tgl_akhir; ?>)</h5>
                    </div>
                    <div class="col-md-4">
                      <p class="text-danger text-center mt-1" style="font-size: 10pt;">(Jumlah Pemasukan - Jumlah Pengeluaran)</p>
                    </div>
                    <div class="col-md-4">
                      <?php
                      $bersih = 0;
                      if (isset($tanggal)) {
                        $bersih = ($lap_pemasukan["total"] - 5000) - $lap_pengeluaran["total_pengeluaran"];
                      }
                      ?>
                      <h5 class="font-weight-bold text-right">Rp. <?= number_format($bersih, 0, ".", "."); ?></h5>
                    </div>
                  </div>
                </div>
                <?php if (isset($_REQUEST["bulan_masuk"]) && ($_REQUEST["tahun_masuk"]) > 0) : ?>
                  <!-- Tombol Cetak -->
                  <div class="col-md-12 mt-2 text-center">
                    <a href="laporan-pemasukan.php<?= $hal_link; ?>" target="blank" class="btn btn-success">
                      <i class="fas fa-print"></i>&emsp;Cetak Laporan
                    </a>
                  </div>
                <?php else : ?>
                  <!-- Tombol Cetak -->
                  <div class="col-md-12 mt-2 text-center">
                    <a href="laporan-pemasukan.php<?= $hal_link; ?>" target="blank" class="btn btn-success disabled">
                      <i class="fas fa-print"></i>&emsp;Cetak Laporan
                    </a>
                  </div>
                <?php endif; ?>
              </div>
              <!-- /Data Pemasukan Bersih -->
            </div>
          </div>
        </div>
      </div>
      <!-- /Laporan Pemasukan Bersih -->
    </div>
  </section>
  <!-- /Main Content -->
</div>
<!-- /CONTENT -->

<?php

include "footer.php";

?>