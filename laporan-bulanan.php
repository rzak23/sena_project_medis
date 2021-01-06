<?php
// Menambahkan Plugin FPDF
include "plugins/fpdf/fpdf.php";

// Get Data Tanggal
$awal   = $_REQUEST["awal"];
$akhir  = $_REQUEST["akhir"];
// Set Bulan & Tahun
$bulan  = substr($awal, 5, 2);
$tahun  = substr($akhir, 0, 4);
$bulans;

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
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(0, 0.8, "LAPORAN KUNJUNGAN BULANAN KLINIK", 0, 0, 'C');
// Bulan & Tahun Laporan
$pdf->Ln(0.65);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(0, 0.8, "BULAN: Desember / " . $tahun, 0, 0, 'C');

// Tabel Laporan
// ==> Header Tabel
$pdf->Ln(1);
$pdf->SetFont('Times', 'B', 10);
$pdf->SetLineWidth(0.03);
$pdf->Cell(1.25, 0.75, 'NO.', 1, 0, 'C');
$pdf->Cell(3, 0.75, 'TANGGAL', 1, 0, 'C');
$pdf->Cell(2.75, 0.75, 'PASIEN UMUM', 1, 0, 'C');
$pdf->Cell(2.75, 0.75, 'PASIEN BPJS', 1, 0, 'C');
$pdf->Cell(2.75, 0.75, 'PASIEN AQUA', 1, 0, 'C');
$pdf->Cell(2.75, 0.75, 'KUNJUNGAN', 1, 0, 'C');
$pdf->Cell(3.5, 0.75, 'BILLING', 1, 0, 'C');
// ==> Main Tabel
$pdf->Ln();
$pdf->SetFont('Times', '', 10);
include "database.php";
$data_laporan = query("SELECT tanggal_rekap, 
                        SUM(pasien_umum) AS umum, 
                        SUM(pasien_bpjs) AS bpjs, 
                        SUM(pasien_aqua) AS aqua,
                        SUM(kunjungan) AS kunjungan,
                        SUM(total_biaya) AS jml_biaya
                        FROM tabel_rekap WHERE tanggal_rekap BETWEEN '$awal' AND '$akhir' 
                        GROUP BY tanggal_rekap");
$nomor = 1;
foreach ($data_laporan as $dl) {
  $billing = number_format($dl["jml_biaya"], 0, ".", ".");
  $pdf->Cell(1.25, 0.5, $nomor, 1, 0, 'C');
  $pdf->Cell(3, 0.5, $dl["tanggal_rekap"], 1, 0, 'C');
  $pdf->Cell(2.75, 0.5, $dl["umum"], 1, 0, 'C');
  $pdf->Cell(2.75, 0.5, $dl["bpjs"], 1, 0, 'C');
  $pdf->Cell(2.75, 0.5, $dl["aqua"], 1, 0, 'C');
  $pdf->Cell(2.75, 0.5, $dl["kunjungan"], 1, 0, 'C');
  $pdf->Cell(3.5, 0.5, '  Rp. ' . $billing, 1, 0, 'L');
  $nomor++;
  $pdf->Ln();
}

$umum             = query("SELECT SUM(pasien_umum) AS total_umum FROM tabel_rekap WHERE tanggal_rekap BETWEEN '$awal' AND '$akhir'")[0];
$total_umum       = number_format($umum["total_umum"], 0, ".", ".");
$bpjs             = query("SELECT SUM(pasien_bpjs) AS total_bpjs FROM tabel_rekap WHERE tanggal_rekap BETWEEN '$awal' AND '$akhir'")[0];
$total_bpjs       = number_format($bpjs["total_bpjs"], 0, ".", ".");
$aqua             = query("SELECT SUM(pasien_aqua) AS total_aqua FROM tabel_rekap WHERE tanggal_rekap BETWEEN '$awal' AND '$akhir'")[0];
$total_aqua       = number_format($aqua["total_aqua"], 0, ".", ".");
$kunjungan        = query("SELECT SUM(kunjungan) AS total_kunjungan FROM tabel_rekap WHERE tanggal_rekap BETWEEN '$awal' AND '$akhir'")[0];
$total_kunjungan  = number_format($kunjungan["total_kunjungan"], 0, ".", ".");
$bill             = query("SELECT SUM(total_biaya) AS total_bill FROM tabel_rekap WHERE tanggal_rekap BETWEEN '$awal' AND '$akhir'")[0];
$total_bill  = number_format($bill["total_bill"], 0, ".", ".");

$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(4.25, 0.5, 'TOTAL KESELURUHAN', 1, 0, 'C');
$pdf->Cell(2.75, 0.5, $total_umum, 1, 0, 'C');
$pdf->Cell(2.75, 0.5, $total_bpjs, 1, 0, 'C');
$pdf->Cell(2.75, 0.5, $total_aqua, 1, 0, 'C');
$pdf->Cell(2.75, 0.5, $total_kunjungan, 1, 0, 'C');
$pdf->Cell(3.5, 0.5, '  Rp. ' . $total_bill, 1, 0, 'L');


// Cetak Laporan
$pdf->Output('Laporan_Harian_Desember' . $tahun . '.pdf', 'I');
