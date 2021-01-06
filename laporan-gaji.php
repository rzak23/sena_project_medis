<?php
// Menambahkan Plugin FPDF
include "plugins/fpdf/fpdf.php";

// Get Data Tanggal
$awal   = $_REQUEST["awal_gaji"];
$akhir  = $_REQUEST["akhir_gaji"];
$id_dr  = $_REQUEST["dokter_gaji"];
// Set Bulan & Tahun
$bulan  = substr($awal, 5, 2);
$tahun  = substr($akhir, 0, 4);

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

include "database.php";

// Judul Laporan
$pdf->Ln(0.25);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(0, 0.8, "LAPORAN GAJI DOKTER", 0, 0, 'C');
// Bulan & Tahun Laporan
$pdf->Ln(0.65);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(0, 0.8, "BULAN: " . $bulans . " / " . $tahun, 0, 0, 'C');
// Nama Dokter
$dokter = query("SELECT * FROM tabel_dokter WHERE id_dokter = '$id_dr'")[0];
$pdf->Ln(0.65);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Times', 'BU', 12);
$pdf->Cell(0, 0.8, "Nama Dokter : " . $dokter["nama_dokter"], 0, 0, 'C');
// Tabel Laporan
// ==> Header Tabel
$pdf->Ln(1);
$pdf->SetFont('Times', 'B', 10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetLineWidth(0.03);
$pdf->Cell(1.25, 0.75, 'NO.', 1, 0, 'C');
$pdf->Cell(3, 0.75, 'TANGGAL', 1, 0, 'C');
$pdf->Cell(1.75, 0.75, 'SHIFT', 1, 0, 'C');
$pdf->Cell(2, 0.75, 'UMUM', 1, 0, 'C');
$pdf->Cell(2, 0.75, 'BPJS', 1, 0, 'C');
$pdf->Cell(2, 0.75, 'AQUA', 1, 0, 'C');
$pdf->Cell(2.75, 0.75, 'KUNJUNGAN', 1, 0, 'C');
$pdf->Cell(3.75, 0.75, 'BILLING', 1, 0, 'C');
// ==> Main Tabel
$pdf->Ln();
$pdf->SetFont('Times', '', 10);
$data_laporan = query("SELECT * FROM tabel_rekap WHERE tanggal_rekap BETWEEN '$awal' AND '$akhir' AND id_dokter = '$id_dr'");
$nomor = 1;
foreach ($data_laporan as $dl) {
  $billing = number_format($dl["total_biaya"], 0, ".", ".");
  $pdf->Cell(1.25, 0.5, $nomor, 1, 0, 'C');
  $pdf->Cell(3, 0.5, $dl["tanggal_rekap"], 1, 0, 'C');
  $pdf->Cell(1.75, 0.5, "  " . $dl["shift_rekap"], 1, 0, 'L');
  $pdf->Cell(2, 0.5, $dl["pasien_umum"], 1, 0, 'C');
  $pdf->Cell(2, 0.5, $dl["pasien_bpjs"], 1, 0, 'C');
  $pdf->Cell(2, 0.5, $dl["pasien_aqua"], 1, 0, 'C');
  $pdf->Cell(2.75, 0.5, $dl["kunjungan"], 1, 0, 'C');
  $pdf->Cell(3.75, 0.5, '  Rp. ' . $billing, 1, 0, 'L');
  $nomor++;
  $pdf->Ln();
}

$umum             = query("SELECT SUM(pasien_umum) AS total_umum FROM tabel_rekap WHERE tanggal_rekap BETWEEN '$awal' AND '$akhir' AND id_dokter = '$id_dr'")[0];
$total_umum       = number_format($umum["total_umum"], 0, ".", ".");
$bpjs             = query("SELECT SUM(pasien_bpjs) AS total_bpjs FROM tabel_rekap WHERE tanggal_rekap BETWEEN '$awal' AND '$akhir' AND id_dokter = '$id_dr'")[0];
$total_bpjs       = number_format($bpjs["total_bpjs"], 0, ".", ".");
$aqua             = query("SELECT SUM(pasien_aqua) AS total_aqua FROM tabel_rekap WHERE tanggal_rekap BETWEEN '$awal' AND '$akhir' AND id_dokter = '$id_dr'")[0];
$total_aqua       = number_format($aqua["total_aqua"], 0, ".", ".");
$kunjungan        = query("SELECT SUM(kunjungan) AS total_kunjungan FROM tabel_rekap WHERE tanggal_rekap BETWEEN '$awal' AND '$akhir' AND id_dokter = '$id_dr'")[0];
$total_kunjungan  = number_format($kunjungan["total_kunjungan"], 0, ".", ".");
$bill             = query("SELECT SUM(total_biaya) AS total_bill FROM tabel_rekap WHERE tanggal_rekap BETWEEN '$awal' AND '$akhir' AND id_dokter = '$id_dr'")[0];
$total_bill  = number_format($bill["total_bill"], 0, ".", ".");

$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(6, 0.5, 'TOTAL KESELURUHAN', 1, 0, 'C');
$pdf->Cell(2, 0.5, $total_umum, 1, 0, 'C');
$pdf->Cell(2, 0.5, $total_bpjs, 1, 0, 'C');
$pdf->Cell(2, 0.5, $total_aqua, 1, 0, 'C');
$pdf->Cell(2.75, 0.5, $total_kunjungan, 1, 0, 'C');
$pdf->Cell(3.75, 0.5, '  Rp. ' . $total_bill, 1, 0, 'L');

// Hitungan Uang
$uang       = query("SELECT * FROM tabel_uang")[0];
$pdf->Ln(2);
$pdf->SetFont('Times', '', 10);
$pdf->Cell(7, 0.75, 'Pasien Umum', 0, 0, 'L');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(5, 0.75, ' Rp. ' . $total_bill, 0, 0, 'L');
$pdf->Ln(0.5);
$biaya_bpjs = $bpjs["total_bpjs"] * $uang["uang_bpjs"];
$pdf->SetFont('Times', '', 10);
$pdf->Cell(7, 0.75, 'Pasien Bpjs', 0, 0, 'L');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(5, 0.75, ' Rp. ' . number_format($biaya_bpjs, 0, ".", "."), 0, 0, 'L');
$pdf->Ln(0.5);
$biaya_aqua = $aqua["total_aqua"] * $uang["uang_aqua"];
$pdf->SetFont('Times', '', 10);
$pdf->Cell(7, 0.75, 'Pasien Aqua', 0, 0, 'L');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(5, 0.75, ' Rp. ' . number_format($biaya_aqua, 0, ".", "."), 0, 0, 'L');
$pdf->Ln(0.5);
$biaya_total = $bill["total_bill"] + $biaya_bpjs + $biaya_aqua;
$pdf->SetFont('Times', 'BU', 10);
$pdf->Cell(7, 0.75, 'TOTAL (Umum + Bpjs + Aqua)', 0, 0, 'L');
$pdf->SetFont('Times', 'BU', 10);
$pdf->Cell(5, 0.75, ' Rp. ' . number_format($biaya_total, 0, ".", "."), 0, 0, 'L');
$pdf->Ln(1);
$biaya_obat = $biaya_total * 0.35;
$pdf->SetFont('Times', '', 10);
$pdf->Cell(7, 0.75, 'Obat', 0, 0, 'L');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(5, 0.75, ' Rp. ' . number_format($biaya_obat, 0, ".", "."), 0, 0, 'L');
$pdf->Ln(0.5);
$biaya_akhir = $biaya_total - $biaya_obat;
$pdf->SetFont('Times', 'BU', 10);
$pdf->Cell(7, 0.75, '(Total - Obat)', 0, 0, 'L');
$pdf->SetFont('Times', 'BU', 10);
$pdf->Cell(5, 0.75, ' Rp. ' . number_format($biaya_akhir, 0, ".", "."), 0, 0, 'L');
$pdf->Ln(1);
$biaya_fee = ($biaya_total - $biaya_obat) * 0.2;
$pdf->SetFont('Times', '', 10);
$pdf->Cell(7, 0.75, 'Fee (20%)', 0, 0, 'L');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(5, 0.75, ' Rp. ' . number_format($biaya_fee, 0, ".", "."), 0, 0, 'L');
$pdf->Ln(0.5);
$biaya_hadir = (count($data_laporan)) * $uang["uang_hadir"];
$pdf->SetFont('Times', '', 10);
$pdf->Cell(7, 0.75, 'Uang Kehadiran (' . count($data_laporan) . 'x)', 0, 0, 'L');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(5, 0.75, ' Rp. ' . number_format($biaya_hadir, 0, ".", "."), 0, 0, 'L');
$pdf->Ln(0.5);
$gaji_dokter = $biaya_fee + $biaya_hadir;
$pdf->SetFont('Times', 'BU', 10);
$pdf->Cell(7, 0.75, 'GAJI (Fee 20% + Kehadiran)', 0, 0, 'L');
$pdf->SetFont('Times', 'BU', 10);
$pdf->Cell(5, 0.75, ' Rp. ' . number_format($gaji_dokter, 0, ".", "."), 0, 0, 'L');



// Cetak Laporan
$pdf->Output('Laporan_Harian_' . $bulans . $tahun . '.pdf', 'I');
