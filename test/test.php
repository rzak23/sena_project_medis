<?php 

$jam          = 21;
$menit        = 01;

$tgl_medis    = date("Y-m-d");
$tanggal      = date("ymd");

// $waktu  = "$jam : $menit";
  if ($jam < 12) {
    if ($menit >= 0 && $menit <= 60) {
      $waktu = "Pagi";
    }
  }if ($jam == 12) {
    if ($menit >= 0 && $menit <= 30) {
      $waktu = "Pagi";
    } if ($menit > 30 && $menit <= 60) {
      $waktu = "Siang";
    }
  } elseif ($jam >= 13 && $jam < 18) {
    if ($menit >= 0 && $menit < 60) {
      $waktu = "Siang";
    }
  } elseif ($jam >= 18 || $jam <= 7) {
    if ($menit < 30 || $menit >= 0) {
      $waktu = "Sore";
    }
  }

  echo $tgl_medis;
  /*
  $date = date("ymd");
  echo $date;
  */
?>