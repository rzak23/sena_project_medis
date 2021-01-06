<?php
// Menambahkan Plugin FPDF
include "plugins/fpdf/fpdf.php";

// Get Data Tanggal
$bulan    = $_REQUEST["bulan_masuk"];
$tahun    = $_REQUEST["tahun_masuk"];
$tanggal  = $tahun . "-" . $bulan;

if ($bulan == "01") {
  $bulans = "JANUARI";
} elseif ($bulan == "02") {
  $bulans = "PEBRUARI";
} elseif ($bulan == "03") {
  $bulans = "MARET";
} elseif ($bulan == "04") {
  $bulans = "APRIL";
} elseif ($bulan == "05") {
  $bulans = "MEI";
} elseif ($bulan == "06") {
  $bulans = "JUNI";
} elseif ($bulan == "07") {
  $bulans = "JULI";
} elseif ($bulan == "08") {
  $bulans = "AGUSTUS";
} elseif ($bulan == "09") {
  $bulans = "SEPTEMBER";
} elseif ($bulan == "10") {
  $bulans = "OKTOBER";
} elseif ($bulan == "11") {
  $bulans = "NOPEMBER";
} elseif ($bulan == "12") {
  $bulans = "DESEMBER";
}


// Set Ukuran Kertas Laporan
$pdf  = new FPDF("P", "cm", array(21.0, 29.7));

// Set Margin Laporan
$pdf->SetMargins(1, 1, 1, 1);
$pdf->AliasNbPages();
$pdf->AddPage();

// Logo
$pdf->Image('dist/img/logo.png', 1, 1.85, 5.4, 2.036);
// Kop Laporan
$pdf->SetX(4);
$pdf->SetFont('Times', 'B', 16);
$pdf->Cell(15.75, 2.15, "KLINIK PRATAMA PAYANA MEDICA", 0, 1, 'R');
$pdf->SetX(4);
$pdf->SetFont('Times', '', 12);
$pdf->Cell(15.75, -0.75, "Br. Samuan Kawan, Desa Carangsari, Petang, Badung, Bali (80353)", 0, 1, 'R');
$pdf->SetX(4);
$pdf->SetFont('Times', '', 12);
$pdf->Cell(15.75, 2, "Telp. 0821 3456 7890", 0, 1, 'R');
// Garis Batas Kop Surat
$pdf->SetLineWidth(0.1);
$pdf->Line(1, 4.15, 19.65, 4.15);
$pdf->SetLineWidth(0.075);
$pdf->Line(1, 4.3, 19.65, 4.3);

// Judul Laporan
$pdf->Ln(0.25);
$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 0.8, "LAPORAN PEMASUKAN BERSIH KLINIK", 0, 0, 'C');
// Bulan & Tahun Laporan
$pdf->Ln(0.65);
$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 0.8, "BULAN: " . $bulans . " / " . $tahun, 0, 0, 'C');
include "database.php";
// Tabel Laporan
// ==> Header 1 Tabel
$pdf->Ln(1);
$pdf->SetX(1);
$pdf->SetFont('Times', 'B', 12);
$pdf->SetLineWidth(0.03);
$pdf->Cell(18.65, 0.75, '1.  JUMLAH KUNJUNGAN PASIEN', 1, 0, 'L');
$pdf->Ln();
$pdf->Cell(6.65, 0.75, 'JENIS PASIEN', 1, 0, 'C');
$pdf->Cell(6, 1.5, 'TOTAL KUNJUNGAN', 1, 0, 'C');
$pdf->Cell(6, 1.5, 'BILLING', 1, 0, 'C');
$pdf->Ln(0.75);
$pdf->Cell(2.2, 0.75, 'UMUM', 1, 0, 'C');
$pdf->Cell(2.2, 0.75, 'BPJS', 1, 0, 'C');
$pdf->Cell(2.25, 0.75, 'AQUA', 1, 0, 'C');
// ==> Main 1 Tabel
$kunjungan  = query("SELECT SUM(pasien_umum) AS umum,
                            SUM(pasien_bpjs) AS bpjs,
                            SUM(pasien_aqua) AS aqua,
                            SUM(kunjungan) AS kunjung,
                            SUM(total_biaya) AS billing
                    FROM tabel_rekap WHERE tanggal_rekap LIKE '%$tanggal%'")[0];
// var_dump($kunjungan);
$pdf->Ln();
$pdf->SetFont('Times', '', 12);
$pdf->Cell(2.2, 0.75, number_format($kunjungan["umum"], 0, ".", "."), 1, 0, 'C');
$pdf->Cell(2.2, 0.75, number_format($kunjungan["bpjs"], 0, ".", "."), 1, 0, 'C');
$pdf->Cell(2.25, 0.75, number_format($kunjungan["aqua"], 0, ".", "."), 1, 0, 'C');
$pdf->Cell(6, 0.75, number_format($kunjungan["kunjung"], 0, ".", "."), 1, 0, 'C');
$pdf->Cell(6, 1.5, '   Rp. ' . number_format($kunjungan["billing"], 0, ".", "."), 1, 0, 'L');
$pdf->Ln(0.75);
if ($kunjungan["umum"] == 0 && $kunjungan["bpjs"] == 0 && $kunjungan["aqua"] == 0) {
  $persen1  = 0;
  $persen2  = 0;
  $persen3  = 0;
} else {
  $persen1  = ($kunjungan["umum"] / $kunjungan["kunjung"]) * 100;
  $persen2  = ($kunjungan["bpjs"] / $kunjungan["kunjung"]) * 100;
  $persen3  = ($kunjungan["aqua"] / $kunjungan["kunjung"]) * 100;
}
$pdf->SetFont('Times', '', 12);
$pdf->Cell(2.2, 0.75, round($persen1, 1) . '%', 1, 0, 'C');
$pdf->Cell(2.2, 0.75, round($persen2, 1) . '%', 1, 0, 'C');
$pdf->Cell(2.25, 0.75, round($persen3, 1) . '%', 1, 0, 'C');
$pdf->Cell(6, 0.75, '100%', 1, 0, 'C');
// ==> Header 2 Tabel
$pdf->Ln();
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(18.65, 0.75, '2.  JUMLAH PEMASUKAN KLINIK', 1, 0, 'L');
$pdf->Ln();
$pdf->Cell(4.4, 0.75, 'JENIS BILLING', 1, 0, 'C');
$pdf->Cell(8.25, 0.75, 'RINCIAN BILLING', 1, 0, 'C');
$pdf->Cell(6, 0.75, 'TOTAL BILLING', 1, 0, 'C');
// ==> Main 2 Tabel
$pemasukan  = query("SELECT  SUM(biaya_umum) AS umum,
                            SUM(biaya_bpjs) AS bpjs,
                            SUM(biaya_aqua) AS aqua,
                            SUM(total_pemasukan) AS total
                    FROM tabel_pemasukan WHERE tanggal_pemasukan LIKE '%$tanggal%'")[0];
$uang       = query("SELECT * FROM tabel_uang")[0];
// var_dump($pemasukan);
$pdf->Ln();
$pdf->SetFont('Times', '', 12);
$pdf->Cell(4.4, 0.75, '  Billing UMUM', 1, 0, 'L');
$pdf->Cell(8.25, 0.75, '  -', 1, 0, 'L');
$pdf->Cell(6, 0.75, '  Rp. ' . number_format($pemasukan["umum"], 0, ".", "."), 1, 0, 'L');
$pdf->Ln();
$pdf->Cell(4.4, 0.75, '  Billing BPJS', 1, 0, 'L');
$pdf->Cell(8.25, 0.75, '  ' . number_format($kunjungan["bpjs"], 0, ".", ".") . " Form x Rp. " . number_format($uang["uang_bpjs"], 0, ".", "."), 1, 0, 'L');
$hasil1   = $kunjungan["bpjs"] * $uang["uang_bpjs"];
$pdf->Cell(6, 0.75, '  Rp. ' . number_format($hasil1, 0, ".", "."), 1, 0, 'L');
$pdf->Ln();
$pdf->Cell(4.4, 1.5, '  Billing AQUA', 1, 0, 'L');
$hasil    = $kunjungan["aqua"] * $uang["uang_aqua"];
$pdf->Cell(8.25, 0.75, '  ' . number_format($kunjungan["aqua"], 0, ".", ".") . ' Form x Rp. ' . number_format($uang["uang_aqua"], 0, ".", ".") . ' = Rp. ' . number_format($hasil, 0, ".", "."), 1, 0, 'L');
$hasil2   = $hasil - 5000;
$pdf->Cell(6, 1.5, '  Rp. ' . number_format($hasil2, 0, ".", "."), 1, 0, 'L');
$pdf->Ln(0.75);
$pdf->SetX(5.4);
$pdf->Cell(8.25, 0.75, '  Dikurangi biaya transfer bank Rp. ' . number_format($uang["biaya_bank"], 0, '.', '.'), 1, 0, 'L');
$pdf->Ln();
$pdf->Cell(12.65, 0.75, 'JUMLAH TOTAL PEMASUKAN', 1, 0, 'C');
$total_hasil    = $pemasukan["total"] - $uang["biaya_bank"];
$pdf->Cell(6, 0.75, '  Rp. ' . number_format($total_hasil, 0, ".", "."), 1, 0, 'L');
// ==> Header 3 Tabel
$pdf->Ln();
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(18.65, 0.75, '3.  JUMLAH PENGELUARAN KLINIK', 1, 0, 'L');
$pdf->Ln();
$pdf->Cell(6.65, 0.75, 'JENIS PENGELUARAN', 1, 0, 'C');
$pdf->Cell(6, 0.75, 'RINCIAN PENGELUARAN', 1, 0, 'C');
$pdf->Cell(6, 0.75, 'TOTAL PENGELUARAN', 1, 0, 'C');
// ==> Main 3 Tabel
$pengeluaran  = query("SELECT * FROM tabel_pengeluaran WHERE tanggal_pengeluaran LIKE '%$tanggal%'")[0];
// var_dump($pengeluaran);
$pdf->Ln();
$pdf->SetFont('Times', '', 12);
$pdf->Cell(6.65, 0.75, '  Pembayaran Obat', 1, 0, 'L');
$pdf->Cell(6, 0.75, '  - ', 1, 0, 'L');
$pdf->Cell(6, 0.75, '  Rp. ' . number_format($pengeluaran["biaya_obat"], 0, ".", "."), 1, 0, 'L');
$pdf->Ln();
$pdf->Cell(6.65, 0.75, '  Gaji Pegawai Klinik', 1, 0, 'L');
$pdf->Cell(6, 0.75, '  - ', 1, 0, 'L');
$pdf->Cell(6, 0.75, '  Rp. ' . number_format($pengeluaran["biaya_gaji"], 0, ".", "."), 1, 0, 'L');
$pdf->Ln();
$pdf->Cell(6.65, 0.75, '  Pengeluaran Harian', 1, 0, 'L');
$pdf->Cell(6, 0.75, '  - ', 1, 0, 'L');
$pdf->Cell(6, 0.75, '  Rp. ' . number_format($pengeluaran["biaya_harian"], 0, ".", "."), 1, 0, 'L');
$pdf->Ln();
$pdf->Cell(12.65, 0.75, 'JUMLAH TOTAL PENGELUARAN', 1, 0, 'C');
$pdf->Cell(6, 0.75, '  Rp. ' . number_format($pengeluaran["total_pengeluaran"], 0, ".", "."), 1, 0, 'L');
// ==> Header 4 Tabel
$pdf->Ln();
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(18.65, 0.75, '4.  JUMLAH PEMASUKAN BERSIH KLINIK', 1, 0, 'L');
$pdf->Ln();
$pdf->SetFont('Times', '', 12);
$pdf->Cell(12.65, 0.75, '(Jumlah Pemasukan - Jumlah Pengeluaran)', 1, 0, 'C');
$pdf->SetFont('Times', 'B', 12);
$bersih   = $total_hasil - $pengeluaran["total_pengeluaran"];
$pdf->Cell(6, 0.75, '  Rp. ' . number_format($bersih, 0, ".", "."), 1, 0, 'L');

// Cetak Laporan
$pdf->Output('Laporan_Pemasukan_' . $bulans . $tahun . '.pdf', 'I');
