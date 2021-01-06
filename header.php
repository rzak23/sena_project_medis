<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- START KONFIGURASI CSS -->

  <!-- ==> Font Awesome <== -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- ==> Theme Style <== -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- ==> Select 2 <== -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- ==> Font Google <== -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">
  <!-- ==> Chart <== -->
  <script src="plugins/chart.js/Chart.min.js"></script>

  <!-- END KONFIGURASI CSS -->

  <!-- START JUDUL TAB BAR -->
  <title><?= $page; ?></title>
  <!-- END JUDUL TAB BAR -->

</head>

<body class="hold-transition sidebar-mini layout-fixed">

  <!-- ==> START WRAPPER <== -->
  <div class="wrapper">

    <!-- HEADER -->
    <!-- Icon Bars & Tanggal -->
    <nav class="main-header navbar navbar-expand navbar-green navbar-light">
      <!-- Left Navbar (Icon Bars) -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="#" class="nav-link" data-widget="pushmenu" role="button">
            <i class="fas fa-bars"></i>
          </a>
        </li>
      </ul>
      <!-- /Left Navbar -->
      <!-- Right Navbar -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item mt-1 mr-3">
          <?php
          date_default_timezone_set('Asia/Kuala_Lumpur');
          $jam    = date("H");
          $menit  = date("i");
          $tahun  = date("Y");
          $bulan  = date("m");
          $tgl    = date("d");
          $hari   = date("l");

          $pukul  = "$jam : $menit";

          if ($hari == "Sunday") {
            $haris = "Minggu";
          } elseif ($hari == "Monday") {
            $haris = "Senin";
          } elseif ($hari == "Tuesday") {
            $haris = "Selasa";
          } elseif ($hari == "Wednesday") {
            $haris = "Rabu";
          } elseif ($hari == "Thursday") {
            $haris = "Kamis";
          } elseif ($hari == "Friday") {
            $haris = "Jumat";
          } elseif ($hari == "Saturday") {
            $haris = "Sabtu";
          }

          if ($bulan == '01') {
            $bln = 'Januari';
          } elseif ($bulan == '02') {
            $bln = 'Pebruari';
          } elseif ($bulan == '03') {
            $bln = 'Maret';
          } elseif ($bulan == '04') {
            $bln = 'April';
          } elseif ($bulan == '05') {
            $bln = 'Mei';
          } elseif ($bulan == '06') {
            $bln = 'Juni';
          } elseif ($bulan == '07') {
            $bln = 'Juli';
          } elseif ($bulan == '08') {
            $bln = 'Agustus';
          } elseif ($bulan == '09') {
            $bln = 'September';
          } elseif ($bulan == '10') {
            $bln = 'Oktober';
          } elseif ($bulan == '11') {
            $bln = 'Nopember';
          } elseif ($bulan == '12') {
            $bln = 'Desember';
          }

          $tanggal = "$tgl $bln $tahun";
          ?>
          <a><?= $haris; ?>, <?= $tanggal; ?>&emsp;|&emsp;<?= $pukul; ?> WITA</a>
        </li>
        <li class="nav-item">
          <a href="logout.php" class="btn btn-sm btn-danger">
            <i class="fas fa-power-off"></i>&emsp;Keluar
          </a>
        </li>
      </ul>
      <!-- /Right Navbar -->
    </nav>
    <!-- /Icon Bars & Tanggal -->
    <!-- /HEADER -->