<?php
// Set Waktu
date_default_timezone_set('Asia/Kuala_Lumpur');
$tgl_rekap  = date("Y-m-d");
$jam        = date("H");
$menit      = date("i");
$waktu_rekap;

// $waktu  = "$jam : $menit";
if ($jam < 12) {
  if ($menit >= 0 && $menit <= 60) {
    $waktu_rekap = "Pagi";
  }
}if ($jam == 12) {
  if ($menit >= 0 && $menit <= 30) {
    $waktu_rekap = "Pagi";
  } if ($menit > 30 && $menit <= 60) {
    $waktu_rekap = "Siang";
  }
} elseif ($jam >= 13 && $jam < 18) {
  if ($menit >= 0 && $menit < 60) {
    $waktu_rekap = "Siang";
  }
} elseif ($jam >= 18 || $jam <= 7) {
  if ($menit < 30 || $menit >= 0) {
    $waktu_rekap = "Sore";
  }
} 

  // Konfigurasi Buat ID Rekap
  $tanggal      = date("ymd");
  $lastId;
  $id_rekap;

  //ambil ID Medis dari database
  $cariId  = mysqli_query($koneksi, "SELECT MAX(id_rekap) as idAkhir FROM tabel_rekap") or die(mysqli_error(""));
  while($row = mysqli_fetch_array($cariId)){
   $lastId = $row['idAkhir'];
  }

  // => Buat ID Medis
  if ($lastId!=0) {
    $id_rekap = $lastId + 1;
  } else {
    $id_rekap   = "$tanggal" . "07" . "0000001";
  }

// Simpan Data Rekap
if (isset($_POST["btn_simpan_rekap"])) {
  if (tambah_rekap_auto($_POST) > 0) {
    echo "<script>alert ('Penambahan Data Rekap Berhasil!'); document.location.href = 'rekam-medis.php';</script>";
  } else {
    echo "<script>alert ('Penambahan Data Rekap Gagal!'); document.location.href = 'rekam-medis.php';</script>";
  }
}
?>
<!-- Modal Tambah Rekap Rekmed (Auto) -->
<div class="modal fade" id="tambah_rekap1">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Tambah Rekap Medis</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Modal Body -->
      <form action="" method="post" id="form">
        <div class="modal-body row">
          <div class="col-md-12">
            <input type="text" name="id_rekap" id="id_rekap" value="<?= $id_rekap; ?>" hidden>
            <!-- Tanggal -->
            <div class="form-group row">
              <label for="tgl_rekap" class="col-md-5 col-form-label">Tanggal Rekap<span class="text-danger">*</span></label>
              <div class="col-md-7">
                <input type="date" name="tgl_rekap" id="tgl_rekap" class="form-control" value="<?= $tgl_rekap; ?>" readonly>
              </div>
            </div>
            <!-- Shift -->
            <div class="form-group row">
              <label for="shift_rekap" class="col-md-5 col-form-label">Shift Rekap</label>
                <div class="col-md-7">
                  <select name="shift_rekap1" onchange="gantiShift();" id="shift_rekap1" class="js-example-placeholder-single js-states form-control" required>
                    <option></option>
                    <option value="Pagi">Pagi</option>
                    <option value="Siang">Siang</option>
                    <option value="Sore">Sore</option>
                  </select>
                </div>
            </div>
            <!-- Dokter -->
            <div class="form-group row">
              <label for="dokter_rekap1" class="col-md-5 col-form-label">Dokter Jaga<span class="text-danger">*</span></label>
              <div class="col-md-7">
                <input type="text" name="dokter_rekap1" id="dokter_rekap1" class="form-control" value="" hidden>
                <input type="text" class="form-control" id="dokter_nama" value="" readonly>
              </div>
            </div>
            <!-- Jumlah Umum -->
            <div class="form-group row">
              <label for="umum_rekap" class="col-md-5 col-form-label">Pasien UMUM<span class="text-danger">*</span></label>
              <div class="col-md-4 input-group">
                <input type="text" name="umum_rekap" id="umum_rekap" class="form-control text-center" value="" readonly>
                <div class="input-group-append">
                  <span class="input-group-text">Orang</span>
                </div>
              </div>
            </div>
            <!-- Jumlah Bpjs -->
            <div class="form-group row">
              <label for="bpjs_rekap" class="col-md-5 col-form-label">Pasien BPJS<span class="text-danger">*</span></label>
              <div class="col-md-4 input-group">
                <input type="text" name="bpjs_rekap" id="bpjs_rekap" class="form-control text-center" value="" readonly>
                <div class="input-group-append">
                  <span class="input-group-text">Orang</span>
                </div>
              </div>
            </div>
            <!-- Jumlah Aqua  -->
            <div class="form-group row">
              <label for="aqua_rekap" class="col-md-5 col-form-label">Pasien AQUA<span class="text-danger">*</span></label>
              <div class="col-md-4 input-group">
                <input type="text" name="aqua_rekap" id="aqua_rekap" class="form-control text-center" value="" readonly>
                <div class="input-group-append">
                  <span class="input-group-text">Orang</span>
                </div>
              </div>
            </div>
            <!-- Jumlah Pasien -->
            <div class="form-group row">
              <label for="jml_pasien" class="col-md-5 col-form-label">Jumlah Pasien<span class="text-danger">*</span></label>
              <div class="col-md-4 input-group">
                <input type="text" name="jml_pasien" id="jml_pasien" class="form-control text-center" value="" readonly>
                <div class="input-group-append">
                  <span class="input-group-text">Orang</span>
                </div>
              </div>
            </div>
            <!-- Jumlah Biaya -->
            <div class="form-group row">
              <label for="jml_biaya" class="col-md-5 col-form-label">Jumlah Biaya<span class="text-danger">*</span></label>
              <div class="col-md-7 input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Rp.</span>
                </div>
                <input type="text" name="jml_biaya" id="jml_biaya" class="form-control" value="" readonly>
              </div>
            </div>
            <hr>
          </div>
          <!-- Tombol Simpan -->
          <div class="col-md-12 text-right">
            <button type="submit" name="btn_simpan_rekap" id="btn_simpan_rekap" class="btn btn-success">
              <i class="fas fa-save"></i>&ensp;Simpan
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  
  var $shiftRekap;

  function gantiShift($shiftPilih){
    var shiftRekap = document.getElementById('shift_rekap1').value;
    var tgl = document.getElementById('tgl_rekap').value;
    
    $.ajax({
        url: "hitung-rekap.php",
        type:"post",
        dataType: 'json',
        data:{
        	shift:shiftRekap,
        	tgl:tgl
        },
        cache:false,
        success:function(result){
          	$('#jml_biaya').val(result['biaya']);
          	$('#aqua_rekap').val(result['cntAqua']);
          	$('#bpjs_rekap').val(result['cntBpjs']);
          	$('#umum_rekap').val(result['cntUmum']);
          	$('#jml_pasien').val(result['cntKunjungan']);
          	if(result['dokter'] == null || result['dokter'] == ""){
          		$('#dokter_nama').val('');
          		$('#dokter_rekap1').val('');
          	}else{
          		$('#dokter_nama').val(result['dokter'][0]['nama_dokter']);
          		$('#dokter_rekap1').val(result['dokter'][0]['id_dokter']);
          	}
          	// console.log(result['dokter'][0]['nama_dokter']);
        }
    });

    /*
    sessionStorage.setItem('waktuRekap',$shiftRekap);
    alert($shiftRekap);
    */
  }



</script>
<!-- /Modal Tambah Rekap Rekmed (Auto) -->