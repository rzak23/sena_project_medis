<?php 

include "database.php";
$data_laporan = query("SELECT * FROM tabel_rekap WHERE tanggal_rekap BETWEEN '2020-12-29' AND '2020-12-30'");
$nomor = 1;
$i = 1;
foreach ($data_laporan as $dl) {
    if($i % 4 == 0){
        $nomor++;
        echo "<br>";
        echo $nomor . " ";
    } if($i==1){
        echo $nomor . " ";
    }
    $billing = number_format($dl["total_biaya"]);
    $dl["tanggal_rekap"] . " ";
    echo $dl["pasien_umum"] . " ";
    echo $dl["pasien_bpjs"] . " ";
    echo $dl["pasien_aqua"] . " ";
    echo $dl["kunjungan"] . " ";
    echo $billing . " ";
    $i++;
}

$umum             = query("SELECT SUM(pasien_umum) AS total_umum FROM tabel_rekap WHERE shift_rekap = 'pagi' AND tanggal_rekap BETWEEN '2020-12-29' AND '2020-12-30'")[0];
$total_umum       = number_format($umum["total_umum"], 0, ".", ".");
$bpjs             = query("SELECT SUM(pasien_bpjs) AS total_bpjs FROM tabel_rekap WHERE shift_rekap = 'pagi' AND tanggal_rekap BETWEEN '2020-12-29' AND '2020-12-30'")[0];
$total_bpjs       = number_format($bpjs["total_bpjs"], 0, ".", ".");
$aqua             = query("SELECT SUM(pasien_aqua) AS total_aqua FROM tabel_rekap WHERE shift_rekap = 'pagi' AND tanggal_rekap BETWEEN '2020-12-29' AND '2020-12-30'")[0];
$total_aqua       = number_format($aqua["total_aqua"], 0, ".", ".");
$kunjungan        = query("SELECT SUM(kunjungan) AS total_kunjungan FROM tabel_rekap WHERE shift_rekap = 'pagi' AND tanggal_rekap BETWEEN '2020-12-29' AND '2020-12-30'")[0];
$total_kunjungan  = number_format($kunjungan["total_kunjungan"], 0, ".", ".");
$bill             = query("SELECT SUM(total_biaya) AS total_bill FROM tabel_rekap WHERE shift_rekap = 'pagi' AND tanggal_rekap BETWEEN '2020-12-29' AND '2020-12-30'")[0];
$total_bill  = number_format($bill["total_bill"], 0, ".", ".");

echo "<br>";
echo "Total Umum Pagi = ".$total_umum."<br>";
echo "Total BPJS Pagi = ".$total_bpjs."<br>";
echo "Total Aqua  Pagi= ".$total_aqua."<br>";
echo "Total Kunjungan Pagi = ".$total_kunjungan."<br>";
echo "Total Bill Pagi = ".$total_bill."<br>";

$umum             = query("SELECT SUM(pasien_umum) AS total_umum FROM tabel_rekap WHERE shift_rekap = 'sore' AND tanggal_rekap BETWEEN '2020-12-29' AND '2020-12-30'")[0];
$total_umum_sore       = number_format($umum["total_umum"], 0, ".", ".");
$bpjs             = query("SELECT SUM(pasien_bpjs) AS total_bpjs FROM tabel_rekap WHERE shift_rekap = 'sore' AND tanggal_rekap BETWEEN '2020-12-29' AND '2020-12-30'")[0];
$total_bpjs_sore      = number_format($bpjs["total_bpjs"], 0, ".", ".");
$aqua             = query("SELECT SUM(pasien_aqua) AS total_aqua FROM tabel_rekap WHERE shift_rekap = 'sore' AND tanggal_rekap BETWEEN '2020-12-29' AND '2020-12-30'")[0];
$total_aqua_sore       = number_format($aqua["total_aqua"], 0, ".", ".");
$kunjungan        = query("SELECT SUM(kunjungan) AS total_kunjungan FROM tabel_rekap WHERE shift_rekap = 'sore' AND tanggal_rekap BETWEEN '2020-12-29' AND '2020-12-30'")[0];
$total_kunjungan_sore  = number_format($kunjungan["total_kunjungan"], 0, ".", ".");
$bill             = query("SELECT SUM(total_biaya) AS total_bill FROM tabel_rekap WHERE shift_rekap = 'sore' AND tanggal_rekap BETWEEN '2020-12-29' AND '2020-12-30'")[0];
$total_bill_sore  = number_format($bill["total_bill"], 0, ".", ".");

echo "<br>";
echo "Total Umum Sore = ".$total_umum_sore."<br>";
echo "Total BPJS Sore = ".$total_bpjs_sore ."<br>";
echo "Total Aqua  Sore= ".$total_aqua_sore."<br>";
echo "Total Kunjungan Sore = ".$total_kunjungan_sore."<br>";
echo "Total Bill Sore = ".$total_bill_sore."<br>";


$umum             = query("SELECT SUM(pasien_umum) AS total_umum FROM tabel_rekap WHERE shift_rekap = 'malam' AND tanggal_rekap BETWEEN '2020-12-29' AND '2020-12-30'")[0];
$total_umum_malam       = number_format($umum["total_umum"], 0, ".", ".");
$bpjs             = query("SELECT SUM(pasien_bpjs) AS total_bpjs FROM tabel_rekap WHERE shift_rekap = 'malam' AND tanggal_rekap BETWEEN '2020-12-29' AND '2020-12-30'")[0];
$total_bpjs_malam      = number_format($bpjs["total_bpjs"], 0, ".", ".");
$aqua             = query("SELECT SUM(pasien_aqua) AS total_aqua FROM tabel_rekap WHERE shift_rekap = 'malam' AND tanggal_rekap BETWEEN '2020-12-29' AND '2020-12-30'")[0];
$total_aqua_malam       = number_format($aqua["total_aqua"], 0, ".", ".");
$kunjungan        = query("SELECT SUM(kunjungan) AS total_kunjungan FROM tabel_rekap WHERE shift_rekap = 'malam' AND tanggal_rekap BETWEEN '2020-12-29' AND '2020-12-30'")[0];
$total_kunjungan_malam  = number_format($kunjungan["total_kunjungan"], 0, ".", ".");
$bill             = query("SELECT SUM(total_biaya) AS total_bill FROM tabel_rekap WHERE shift_rekap = 'malam' AND tanggal_rekap BETWEEN '2020-12-29' AND '2020-12-30'")[0];
$total_bill_malam  = number_format($bill["total_bill"], 0, ".", ".");

echo "<br>";
echo "Total Umum Sore = ".$total_umum_malam."<br>";
echo "Total BPJS Sore = ".$total_bpjs_malam ."<br>";
echo "Total Aqua  Sore= ".$total_aqua_malam."<br>";
echo "Total Kunjungan Sore = ".$total_kunjungan_malam."<br>";
echo "Total Bill Sore = ".$total_bill_malam."<br>";


?>
