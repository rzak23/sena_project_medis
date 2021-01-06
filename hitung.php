<?php
// Total Bill Rekam Medis
$biaya      = query("SELECT SUM(biaya_medis) AS biaya FROM tabel_medis WHERE 
                    tanggal_medis = '$tgl_medis' AND shift_medis = '$waktu'")[0];
$total_bill = number_format($biaya["biaya"], 0, ".", ".");
// Total Jumlah Kunjungan
$kunjungan = count(query("SELECT * FROM tabel_medis WHERE tanggal_medis = '$tgl_medis' AND shift_medis = '$waktu'"));
// Jumlah Pasien UMUM
$umum = count(query("SELECT * FROM tabel_medis WHERE tanggal_medis = '$tgl_medis' AND shift_medis = '$waktu' AND tipe_pasien = 'Umum'"));
// Jumlah Pasien BPJS
$bpjs = count(query("SELECT * FROM tabel_medis WHERE tanggal_medis = '$tgl_medis' AND shift_medis = '$waktu' AND tipe_pasien = 'Bpjs'"));
// Jumlah Pasien AQUA
$aqua = count(query("SELECT * FROM tabel_medis WHERE tanggal_medis = '$tgl_medis' AND shift_medis = '$waktu' AND tipe_pasien = 'Aqua'"));
