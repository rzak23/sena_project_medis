<?php
// include "database.php";
$tahun = date("Y");
// Data Januari
$januari    = $tahun . "-01";
$cek_jan    = query("SELECT COUNT(id_medis) AS dt FROM tabel_medis WHERE tanggal_medis LIKE '%$januari%'")[0];
if ($cek_jan["dt"] == "0") {
  $jan_umum = 0;
  $jan_bpjs = 0;
  $jan_aqua = 0;
} else {
  $data_jan1 = query("SELECT COUNT(id_medis) AS umum FROM tabel_medis WHERE tipe_pasien = 'Umum' AND tanggal_medis LIKE '%$januari%'");
  $data_jan2 = query("SELECT COUNT(id_medis) AS bpjs FROM tabel_medis WHERE tipe_pasien = 'Bpjs' AND tanggal_medis LIKE '%$januari%'")[0];
  $data_jan3 = query("SELECT COUNT(id_medis) AS aqua FROM tabel_medis WHERE tipe_pasien = 'Aqua' AND tanggal_medis LIKE '%$januari%'")[0];

  $jan_umum = intval($data_jan1["umum"]);
  $jan_bpjs = intval($data_jan2["bpjs"]);
  $jan_aqua = intval($data_jan3["aqua"]);
}
// Data Pebruari
$pebruari   = $tahun . "-02";
$cek_peb    = query("SELECT COUNT(id_medis) AS dt FROM tabel_medis WHERE tanggal_medis LIKE '%$pebruari%'")[0];
if ($cek_peb["dt"] == "0") {
  $peb_umum = 0;
  $peb_bpjs = 0;
  $peb_aqua = 0;
} else {
  $data_peb1 = query("SELECT COUNT(id_medis) AS umum FROM tabel_medis WHERE tipe_pasien = 'Umum' AND tanggal_medis LIKE '%$pebruari%'")[0];
  $data_peb2 = query("SELECT COUNT(id_medis) AS bpjs FROM tabel_medis WHERE tipe_pasien = 'Bpjs' AND tanggal_medis LIKE '%$pebruari%'")[0];
  $data_peb3 = query("SELECT COUNT(id_medis) AS aqua FROM tabel_medis WHERE tipe_pasien = 'Aqua' AND tanggal_medis LIKE '%$pebruari%'")[0];

  $peb_umum = intval($data_peb1["umum"]);
  $peb_bpjs = intval($data_peb2["bpjs"]);
  $peb_aqua = intval($data_peb3["aqua"]);
}
// Data Maret
$maret      = $tahun . "-03";
$cek_mar    = query("SELECT COUNT(id_medis) AS dt FROM tabel_medis WHERE tanggal_medis LIKE '%$maret%'")[0];
if ($cek_mar["dt"] == "0") {
  $mar_umum = 0;
  $mar_bpjs = 0;
  $mar_aqua = 0;
} else {
  $data_mar1 = query("SELECT COUNT(id_medis) AS umum FROM tabel_medis WHERE tipe_pasien = 'Umum' AND tanggal_medis LIKE '%$maret%'")[0];
  $data_mar2 = query("SELECT COUNT(id_medis) AS bpjs FROM tabel_medis WHERE tipe_pasien = 'Bpjs' AND tanggal_medis LIKE '%$maret%'")[0];
  $data_mar3 = query("SELECT COUNT(id_medis) AS aqua FROM tabel_medis WHERE tipe_pasien = 'Aqua' AND tanggal_medis LIKE '%$maret%'")[0];

  $mar_umum = intval($data_mar1["umum"]);
  $mar_bpjs = intval($data_mar2["bpjs"]);
  $mar_aqua = intval($data_mar3["aqua"]);
}
// Data April
$april      = $tahun . "-04";
$cek_apr    = query("SELECT COUNT(id_medis) AS dt FROM tabel_medis WHERE tanggal_medis LIKE '%$april%'")[0];
if ($cek_apr["dt"] == "0") {
  $apr_umum = 0;
  $apr_bpjs = 0;
  $apr_aqua = 0;
} else {
  $data_apr1 = query("SELECT COUNT(id_medis) AS umum FROM tabel_medis WHERE tipe_pasien = 'Umum' AND tanggal_medis LIKE '%$april%'")[0];
  $data_apr2 = query("SELECT COUNT(id_medis) AS bpjs FROM tabel_medis WHERE tipe_pasien = 'Bpjs' AND tanggal_medis LIKE '%$april%'")[0];
  $data_apr3 = query("SELECT COUNT(id_medis) AS aqua FROM tabel_medis WHERE tipe_pasien = 'Aqua' AND tanggal_medis LIKE '%$april%'")[0];

  $apr_umum = intval($data_apr1["umum"]);
  $apr_bpjs = intval($data_apr2["bpjs"]);
  $apr_aqua = intval($data_apr3["aqua"]);
}
// Data Mei
$mei        = $tahun . "-05";
$cek_mei    = query("SELECT COUNT(id_medis) AS dt FROM tabel_medis WHERE tanggal_medis LIKE '%$mei%'")[0];
if ($cek_mei["dt"] == "0") {
  $mei_umum = 0;
  $mei_bpjs = 0;
  $mei_aqua = 0;
} else {
  $data_mei1 = query("SELECT COUNT(id_medis) AS umum FROM tabel_medis WHERE tipe_pasien = 'Umum' AND tanggal_medis LIKE '%$mei%'")[0];
  $data_mei2 = query("SELECT COUNT(id_medis) AS bpjs FROM tabel_medis WHERE tipe_pasien = 'Bpjs' AND tanggal_medis LIKE '%$mei%'")[0];
  $data_mei3 = query("SELECT COUNT(id_medis) AS aqua FROM tabel_medis WHERE tipe_pasien = 'Aqua' AND tanggal_medis LIKE '%$mei%'")[0];

  $mei_umum = intval($data_mei1["umum"]);
  $mei_bpjs = intval($data_mei2["bpjs"]);
  $mei_aqua = intval($data_mei3["aqua"]);
}
// Data Juni
$juni       = $tahun . "-06";
$cek_jun    = query("SELECT COUNT(id_medis) AS dt FROM tabel_medis WHERE tanggal_medis LIKE '%$juni%'")[0];
if ($cek_jun["dt"] == "0") {
  $jun_umum = 0;
  $jun_bpjs = 0;
  $jun_aqua = 0;
} else {
  $data_jun1 = query("SELECT COUNT(id_medis) AS umum FROM tabel_medis WHERE tipe_pasien = 'Umum' AND tanggal_medis LIKE '%$juni%'")[0];
  $data_jun2 = query("SELECT COUNT(id_medis) AS bpjs FROM tabel_medis WHERE tipe_pasien = 'Bpjs' AND tanggal_medis LIKE '%$juni%'")[0];
  $data_jun3 = query("SELECT COUNT(id_medis) AS aqua FROM tabel_medis WHERE tipe_pasien = 'Aqua' AND tanggal_medis LIKE '%$juni%'")[0];

  $jun_umum = intval($data_jun1["umum"]);
  $jun_bpjs = intval($data_jun2["bpjs"]);
  $jun_aqua = intval($data_jun3["aqua"]);
}
// Data Juli
$juli       = $tahun . "-07";
$cek_jul    = query("SELECT COUNT(id_medis) AS dt FROM tabel_medis WHERE tanggal_medis LIKE '%$juli%'")[0];
if ($cek_jul["dt"] == "0") {
  $jul_umum = 0;
  $jul_bpjs = 0;
  $jul_aqua = 0;
} else {
  $data_jul1 = query("SELECT COUNT(id_medis) AS umum FROM tabel_medis WHERE tipe_pasien = 'Umum' AND tanggal_medis LIKE '%$juli%'")[0];
  $data_jul2 = query("SELECT COUNT(id_medis) AS bpjs FROM tabel_medis WHERE tipe_pasien = 'Bpjs' AND tanggal_medis LIKE '%$juli%'")[0];
  $data_jul3 = query("SELECT COUNT(id_medis) AS aqua FROM tabel_medis WHERE tipe_pasien = 'Aqua' AND tanggal_medis LIKE '%$juli%'")[0];

  $jul_umum = intval($data_jul1["umum"]);
  $jul_bpjs = intval($data_jul2["bpjs"]);
  $jul_aqua = intval($data_jul3["aqua"]);
}
// Data Agustus
$agustus    = $tahun . "-08";
$cek_agu    = query("SELECT COUNT(id_medis) AS dt FROM tabel_medis WHERE tanggal_medis LIKE '%$agustus%'")[0];
if ($cek_agu["dt"] == "0") {
  $agu_umum = 0;
  $agu_bpjs = 0;
  $agu_aqua = 0;
} else {
  $data_agu1 = query("SELECT COUNT(id_medis) AS umum FROM tabel_medis WHERE tipe_pasien = 'Umum' AND tanggal_medis LIKE '%$agustus%'")[0];
  $data_agu2 = query("SELECT COUNT(id_medis) AS bpjs FROM tabel_medis WHERE tipe_pasien = 'Bpjs' AND tanggal_medis LIKE '%$agustus%'")[0];
  $data_agu3 = query("SELECT COUNT(id_medis) AS aqua FROM tabel_medis WHERE tipe_pasien = 'Aqua' AND tanggal_medis LIKE '%$agustus%'")[0];

  $agu_umum = intval($data_agu1["umum"]);
  $agu_bpjs = intval($data_agu2["bpjs"]);
  $agu_aqua = intval($data_agu3["aqua"]);
}
// Data September
$september  = $tahun . "-09";
$cek_sep    = query("SELECT COUNT(id_medis) AS dt FROM tabel_medis WHERE tanggal_medis LIKE '%$september%'")[0];
if ($cek_sep["dt"] == "0") {
  $sep_umum = 0;
  $sep_bpjs = 0;
  $sep_aqua = 0;
} else {
  $data_sep1 = query("SELECT COUNT(id_medis) AS umum FROM tabel_medis WHERE tipe_pasien = 'Umum' AND tanggal_medis LIKE '%$september%'")[0];
  $data_sep2 = query("SELECT COUNT(id_medis) AS bpjs FROM tabel_medis WHERE tipe_pasien = 'Bpjs' AND tanggal_medis LIKE '%$september%'")[0];
  $data_sep3 = query("SELECT COUNT(id_medis) AS aqua FROM tabel_medis WHERE tipe_pasien = 'Aqua' AND tanggal_medis LIKE '%$september%'")[0];

  $sep_umum = intval($data_sep1["umum"]);
  $sep_bpjs = intval($data_sep2["bpjs"]);
  $sep_aqua = intval($data_sep3["aqua"]);
}
// Data Oktober
$oktober    = $tahun . "-10";
$cek_okt    = query("SELECT COUNT(id_medis) AS dt FROM tabel_medis WHERE tanggal_medis LIKE '%$oktober%'")[0];
if ($cek_okt["dt"] == "0") {
  $okt_umum = 0;
  $okt_bpjs = 0;
  $okt_aqua = 0;
} else {
  $data_okt1 = query("SELECT COUNT(id_medis) AS umum FROM tabel_medis WHERE tipe_pasien = 'Umum' AND tanggal_medis LIKE '%$oktober%'")[0];
  $data_okt2 = query("SELECT COUNT(id_medis) AS bpjs FROM tabel_medis WHERE tipe_pasien = 'Bpjs' AND tanggal_medis LIKE '%$oktober%'")[0];
  $data_okt3 = query("SELECT COUNT(id_medis) AS aqua FROM tabel_medis WHERE tipe_pasien = 'Aqua' AND tanggal_medis LIKE '%$oktober%'")[0];

  $okt_umum = intval($data_okt1["umum"]);
  $okt_bpjs = intval($data_okt2["bpjs"]);
  $okt_aqua = intval($data_okt3["aqua"]);
}
// Data Nopember
$nopember   = $tahun . "-11";
$cek_nop    = query("SELECT COUNT(id_medis) AS dt FROM tabel_medis WHERE tanggal_medis LIKE '%$nopember%'")[0];
if ($cek_nop["dt"] == "0") {
  $nop_umum = 0;
  $nop_bpjs = 0;
  $nop_aqua = 0;
} else {
  $data_nop1 = query("SELECT COUNT(id_medis) AS umum FROM tabel_medis WHERE tipe_pasien = 'Umum' AND tanggal_medis LIKE '%$nopember%'")[0];
  $data_nop2 = query("SELECT COUNT(id_medis) AS bpjs FROM tabel_medis WHERE tipe_pasien = 'Bpjs' AND tanggal_medis LIKE '%$nopember%'")[0];
  $data_nop3 = query("SELECT COUNT(id_medis) AS aqua FROM tabel_medis WHERE tipe_pasien = 'Aqua' AND tanggal_medis LIKE '%$nopember%'")[0];

  $nop_umum = intval($data_nop1["umum"]);
  $nop_bpjs = intval($data_nop2["bpjs"]);
  $nop_aqua = intval($data_nop3["aqua"]);
}
// Data Desember
$desember   = $tahun . "-12";
$cek_des    = query("SELECT COUNT(id_medis) AS dt FROM tabel_medis WHERE tanggal_medis LIKE '%$desember%'")[0];
if ($cek_des["dt"] == "0") {
  $des_umum = 0;
  $des_bpjs = 0;
  $des_aqua = 0;
} else {
  $data_des1 = query("SELECT COUNT(id_medis) AS umum FROM tabel_medis WHERE tipe_pasien = 'Umum' AND tanggal_medis LIKE '%$desember%'")[0];
  $data_des2 = query("SELECT COUNT(id_medis) AS bpjs FROM tabel_medis WHERE tipe_pasien = 'Bpjs' AND tanggal_medis LIKE '%$desember%'")[0];
  $data_des3 = query("SELECT COUNT(id_medis) AS aqua FROM tabel_medis WHERE tipe_pasien = 'Aqua' AND tanggal_medis LIKE '%$desember%'")[0];

  $des_umum = intval($data_des1["umum"]);
  $des_bpjs = intval($data_des2["bpjs"]);
  $des_aqua = intval($data_des3["aqua"]);
}

?>
<script>
  $(function() {
    var GrapMedisCanvas = $('#medis_grafik').get(0).getContext('2d');
    var GrapMedisData = {
      labels: ['Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nop', 'Des'],
      datasets: [{
          label: 'UMUM',
          backgroundColor: 'rgba(220,53,69,0.9)',
          borderColor: 'rgba(220,53,69,1)',
          pointRadius: false,
          pointColor: '#3B8BBA',
          pointStrokeColor: 'rgba(220,53,69,1.5)',
          pointHighlightFill: '#FFFFFF',
          pointHighlightStroke: 'rgba(220,53,69,1.5)',
          data: [<?= $jan_umum ?>, <?= $peb_umum ?>, <?= $mar_umum ?>, <?= $apr_umum ?>, <?= $mei_umum ?>, <?= $jun_umum ?>, <?= $jul_umum ?>, <?= $agu_umum ?>, <?= $sep_umum ?>, <?= $okt_umum ?>, <?= $nop_umum ?>, <?= $des_umum ?>]
        },
        {
          label: 'BPJS',
          backgroundColor: 'rgba(40,167,69,0.9)',
          borderColor: 'rgba(40,167,69,1)',
          pointRadius: false,
          pointColor: '#C1C7D1',
          pointStrokeColor: 'rgba(40,167,69,1.5)',
          pointHighlightFill: '#FFFFFF',
          pointHighlightStroke: 'rgba(40,167,69,1.5)',
          data: [<?= $jan_bpjs ?>, <?= $peb_bpjs ?>, <?= $mar_bpjs ?>, <?= $apr_bpjs ?>, <?= $mei_bpjs ?>, <?= $jun_bpjs ?>, <?= $jul_bpjs ?>, <?= $agu_bpjs ?>, <?= $sep_bpjs ?>, <?= $okt_bpjs ?>, <?= $nop_bpjs ?>, <?= $des_bpjs ?>]
        },
        {
          label: 'AQUA',
          backgroundColor: 'rgba(0,123,255,0.9)',
          borderColor: 'rgba(0,123,255,1)',
          pointRadius: false,
          pointColor: '#C1C7D1',
          pointStrokeColor: 'rgba(0,123,255,1.5)',
          pointHighlightFill: '#FFFFFF',
          pointHighlightStroke: 'rgba(0,123,255,1.5)',
          data: [<?= $jan_aqua ?>, <?= $peb_aqua ?>, <?= $mar_aqua ?>, <?= $apr_aqua ?>, <?= $mei_aqua ?>, <?= $jun_aqua ?>, <?= $jul_aqua ?>, <?= $agu_aqua ?>, <?= $sep_aqua ?>, <?= $okt_aqua ?>, <?= $nop_aqua ?>, <?= $des_aqua ?>]
        }
      ]
    }

    var GrapMedisOptions = {
      responsive: true,
      maintainAspectRatio: false,
      datasetFill: false
    }

    var GrapMedis = new Chart(GrapMedisCanvas, {
      type: 'bar',
      data: GrapMedisData,
      options: GrapMedisOptions
    })
  });
</script>