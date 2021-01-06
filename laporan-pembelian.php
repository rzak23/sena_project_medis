<?php
// Menambahkan Plugin FPDF
include "plugins/fpdf/fpdf.php";

// Get Data Tanggal
$awal     = $_REQUEST["awal_beli"];
$akhir    = $_REQUEST["akhir_beli"];
$bulan    = substr($awal, 5, 2);
$tahun    = substr($akhir, 0, 4);
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
$pdf->Cell(0, 0.8, "LAPORAN REKAPITULASI PEMBELIAN OBAT", 0, 0, 'C');
// Bulan & Tahun Laporan
$pdf->Ln(0.65);
$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 0.8, "BULAN: " . $bulans . " / " . $tahun, 0, 0, 'C');
include "database.php";

// Tabel Laporan
// ==> Header Tabel
$pdf->Ln(1);
$pdf->SetX(1);
$pdf->SetFont('Times', 'B', 12);
$pdf->SetLineWidth(0.03);
$pdf->Cell(1.25, 0.75, 'NO.', 1, 0, 'C');
$pdf->Cell(3.4, 0.75, 'TGL. FAKTUR', 1, 0, 'C');
$pdf->Cell(9, 0.75, 'NAMA APOTEK', 1, 0, 'C');
$pdf->Cell(5, 0.75, 'BIAYA TAGIHAN', 1, 0, 'C');
// ==> Main Tabel
$pembelian  = query("SELECT * FROM tabel_obat WHERE status_tagihan = 'Belum Dibayar' AND tanggal_tagihan BETWEEN '$awal' AND '$akhir'");
// var_dump($pembelian);
$pdf->Ln();
$pdf->SetFont('Times', '', 12);
$nomor = 1;
foreach ($pembelian as $beli) {
  $pdf->Cell(1.25, 0.75, $nomor, 1, 0, 'C');
  $pdf->Cell(3.4, 0.75, $beli["tanggal_tagihan"], 1, 0, 'C');
  $pdf->Cell(9, 0.75, '  ' . $beli["nama_apotek"], 1, 0, 'L');
  $pdf->Cell(5, 0.75, '  Rp. ' . number_format($beli["biaya_tagihan"], 0, ".", "."), 1, 0, 'L');
  $nomor++;
  $pdf->Ln();
}
$pdf->SetFont('Times', 'B', 12);
$total = query("SELECT SUM(biaya_tagihan) AS tagihan FROM tabel_obat WHERE status_tagihan = 'Belum Dibayar' AND tanggal_tagihan BETWEEN '$awal' AND '$akhir'")[0];
$pdf->Cell(13.65, 0.75, 'TOTAL TAGIHAN OBAT', 1, 0, 'C');
$pdf->Cell(5, 0.75, '  Rp. ' . number_format($total["tagihan"], 0, ".", "."), 1, 0, 'L');


// Cetak Laporan
$pdf->Output('Laporan_Pemasukan_' . $bulans . $tahun . '.pdf', 'I');
