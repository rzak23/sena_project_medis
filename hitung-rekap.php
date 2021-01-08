<?php
include 'test/database.php';

$shift = $_POST['shift'];
$tgl = $_POST['tgl'];
$biaya      = query("SELECT SUM(biaya_medis) AS biaya FROM tabel_medis WHERE 
                    tanggal_medis = '$tgl' AND shift_medis = '$shift'")[0];
$total = number_format($biaya["biaya"], 0, ".", ".");
// Total Jumlah Kunjungan
$tpengunjung = count(query("SELECT * FROM tabel_medis WHERE tanggal_medis = '$tgl' AND shift_medis = '$shift'"));
// Jumlah Pasien UMUM
$tumum = count(query("SELECT * FROM tabel_medis WHERE tanggal_medis = '$tgl' AND shift_medis = '$shift' AND tipe_pasien = 'Umum'"));
// Jumlah Pasien BPJS
$tbpjs = count(query("SELECT * FROM tabel_medis WHERE tanggal_medis = '$tgl' AND shift_medis = '$shift' AND tipe_pasien = 'Bpjs'"));
// Jumlah Pasien AQUA
$taqua = count(query("SELECT * FROM tabel_medis WHERE tanggal_medis = '$tgl' AND shift_medis = '$shift' AND tipe_pasien = 'Aqua'"));
// Dokter
$dokter = query("SELECT tabel_dokter.nama_dokter,tabel_dokter.id_dokter FROM tabel_medis LEFT JOIN tabel_dokter ON tabel_medis.id_dokter=tabel_dokter.id_dokter WHERE tanggal_medis='$tgl' AND shift_medis='$shift' GROUP BY nama_dokter");

$result = [
	'biaya' => $total,
	'cntKunjungan' => $tpengunjung,
	'cntUmum' => $tumum,
	'cntBpjs' => $tbpjs,
	'cntAqua' => $taqua,
	'dokter' => $dokter,
];
echo json_encode($result);