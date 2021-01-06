<?php

// menggunakan fpdf
require 'plugins/pdf/fpdf.php';
// ukuran kertas
$pdf = new FPDF("P", "cm", array(10.5, 14.8));
// ukuran margin
$pdf->SetMargins(0.25, .025, 0.25, 0.25);
$pdf->AliasNbPages();
$pdf->AddPage();
// Logo
$pdf->Image('dist/img/icon.png', 0.5, 0.5, 1.75, 1.75);
// Judul
$pdf->SetX(2.25);
$pdf->SetFont('Times', 'B', '12');
$pdf->Cell(0, 2, "KLINIK PRATAMA PAYANA MEDICA", 0, 1, 'C');
$pdf->SetX(2.25);
$pdf->SetFont('Times', '', '8');
$pdf->Cell(0, -0.95, "Jl. I Gst. Ngurah Rai, Carangsari, Petang, Badung, Bali (80353)", 0, 1, 'C');
$pdf->Cell(2.25);
$pdf->SetFont('Times', '', '8');
$pdf->Cell(0, 1.7, "Telp. 0812 3456 7890", 0, 1, 'C');
// Garis Batas
$pdf->SetLineWidth(0.1);
$pdf->Line(0.5, 2.35, 10, 2.35);
$pdf->SetLineWidth(0.05);
$pdf->Line(0.5, 2.50, 10, 2.50);
// Isi 
// ==> Ambil ID Medis
$id   = $_GET["id"];
// ==> Koneksi Database
include "database.php";
// ==> Konfigurasi Data Medis
$medis  = query("SELECT rm.*, dr.*, pm.*, ps.* FROM (((tabel_medis rm
                  INNER JOIN tabel_dokter dr    ON rm.id_dokter = dr.id_dokter)
                  INNER JOIN tabel_paramedis pm ON rm.id_param  = pm.id_param)
                  INNER JOIN tabel_pasien ps    ON rm.id_pasien = ps.id_pasien)
                WHERE rm.id_medis = '$id'")[0];

$pdf->SetMargins(0.5, .025, 0.25, 0.25);
$pdf->Ln(0.25);
$pdf->SetFont('Times', '', '10');
$pdf->Cell(2.40, 0.8, 'No. Faktur', 0, 0, 'L');
$pdf->Cell(0.05, 0.8, ':', 0, 0, 'C');
$pdf->Cell(2.55, 0.8, "  " . $medis['id_medis'], 0, 0, 'L');
$pdf->Ln(0.75);
$pdf->Cell(2.40, 0.8, 'Tanggal', 0, 0, 'L');
$pdf->Cell(0.05, 0.8, ':', 0, 0, 'C');
$pdf->Cell(2.55, 0.8, "  " . $medis["shift_medis"] . ", " . $medis["tanggal_medis"], 0, 0, 'L');
$pdf->Ln(0.75);
$pdf->Cell(2.40, 0.8, 'Nama Dokter', 0, 0, 'L');
$pdf->Cell(0.05, 0.8, ':', 0, 0, 'C');
$pdf->Cell(2.55, 0.8, "  " . $medis["nama_dokter"], 0, 0, 'L');
$pdf->Ln(0.75);
$pdf->Cell(2.40, 0.8, 'Nama Pasien', 0, 0, 'L');
$pdf->Cell(0.05, 0.8, ':', 0, 0, 'C');
$pdf->Cell(2.55, 0.8, "  " . $medis["nama_pasien"], 0, 0, 'L');
$pdf->Ln(0.75);
$pdf->Cell(2.40, 0.8, 'Tipe Pasien', 0, 0, 'L');
$pdf->Cell(0.05, 0.8, ':', 0, 0, 'C');
$pdf->Cell(2.55, 0.8, "  " . $medis["tipe_pasien"], 0, 0, 'L');
$pdf->Ln(0.75);
$pdf->Cell(2.40, 0.8, 'Jenis Kelamin', 0, 0, 'L');
$pdf->Cell(0.05, 0.8, ':', 0, 0, 'C');
$pdf->Cell(2.55, 0.8, "  " . $medis["jns_kelamin_pasien"], 0, 0, 'L');
$pdf->Ln(0.75);
$pdf->Cell(2.40, 0.8, 'Umur Pasien', 0, 0, 'L');
$pdf->Cell(0.05, 0.8, ':', 0, 0, 'C');
$pdf->Cell(2.55, 0.8, "  " . $medis["umur_pasien"] . " Tahun", 0, 0, 'L');
$pdf->Ln(0.75);
$pdf->Cell(2.40, 0.8, 'Alamat Pasien', 0, 0, 'L');
$pdf->Cell(0.05, 0.8, ':', 0, 0, 'C');
$pdf->Cell(2.55, 0.8, "  " . $medis["alamat_pasien"], 0, 0, 'L');
$pdf->Ln(0.75);
$pdf->Cell(2.40, 0.8, 'Diagnosa', 0, 0, 'L');
$pdf->Cell(0.05, 0.8, ':', 0, 0, 'C');
$pdf->Cell(2.55, 0.8, "  " . $medis["diagnosa_medis"], 0, 0, 'L');
$pdf->Ln(0.75);
$pdf->Cell(2.40, 0.8, 'Terapi', 0, 0, 'L');
$pdf->Cell(0.05, 0.8, ':', 0, 0, 'C');
$pdf->Cell(2.55, 0.8, "  " . $medis["terapi_medis"], 0, 0, 'L');
$pdf->Ln(0.75);
$pdf->Cell(2.40, 0.8, 'Biaya Periksa', 0, 0, 'L');
$pdf->Cell(0.05, 0.8, ':', 0, 0, 'C');
$pdf->Cell(2.55, 0.8, "  Rp. " . number_format($medis["biaya_medis"], 0, ".", "."), 0, 0, 'L');
$pdf->Ln(0.75);



// Print Out
$pdf->Output("faktur_pemeriksaan_" . $medis['id_medis'] . ".pdf", "I");
