<?php
// Konfigurasi Buat ID Medis
$tanggal      = date("ymd");
$date         = date("Y-m-d");

$lastId;
$id_medis;

//ambil ID Medis dari database
$cariId  = mysqli_query($koneksi, "SELECT MAX(id_medis) as idAkhir FROM tabel_medis") or die(mysqli_error(""));
while($row = mysqli_fetch_array($cariId)){
  $lastId = $row['idAkhir'];
}

// => Buat ID Medis
if ($lastId!=0) {
  $id_medis = $lastId + 1;
} else {
  $id_medis   = "$tanggal" . "06" . "0000001";
}

if (isset($_POST["btn_simpan_medis"])) {
  if (tambah_medis($_POST) > 0) {
    echo "<script>alert ('Penambahan data rekam medis berhasil!'); document.location.href = 'rekam-medis-data.php';</script>";
  } else {
    echo "<script>alert ('Penambahan data rekam medis gagal!'); document.location.href = 'rekam-medis-data.php';</script>";
  }
}

include "tambah-pasien-medis.php";

?>
<!-- Tambah Data Rekam Medis -->
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Tambah Data Rekam Medis</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <form action="" method="post">
              <div class="row">
                <!-- Petugas Jaga -->
                <div class="col-md-5">
                  <!-- ID Medis -->
                  <div class="form-group row">
                    <label for="id_medis" class="col-md-4 col-form-label">ID Medis</label>
                    <div class="col-md-8">
                      <input type="text" name="id_medis" id="id_medis" class="form-control" value="<?= $id_medis; ?>" readonly>
                    </div>
                  </div>
                  <!-- Tanggal Medis -->
                  <div class="form-group row">
                    <label for="tgl_medis" class="col-md-4 col-form-label">Tanggal Medis</label>
                    <div class="col-md-8">
                      <input type="date" name="tgl_medis" id="tgl_medis" class="form-control" value="<?= $date; ?>" required>
                    </div>
                  </div>
                  <!-- Dokter Medis -->
                  <div class="form-group row">
                    <label for="dokter_medis" class="col-md-4 col-form-label">Dokter Jaga</label>
                    <div class="col-md-8">
                      <select name="dokter_medis" id="dokter_medis" class="js-example-placeholder-single js-states form-control" required>
                        <option></option>
                        <?php $dokter = query("SELECT * FROM tabel_dokter"); ?>
                        <?php foreach ($dokter as $dr) : ?>
                          <option value="<?= $dr["id_dokter"]; ?>"><?= $dr["nama_dokter"]; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <!-- Paramedis Medis -->
                  <div class="form-group row">
                    <label for="param_medis" class="col-md-4 col-form-label">Paramedis Jaga</label>
                    <div class="col-md-8">
                      <select name="param_medis" id="param_medis" class="js-example-placeholder-single js-states form-control" required>
                        <option></option>
                        <?php $paramedis = query("SELECT * FROM tabel_paramedis"); ?>
                        <?php foreach ($paramedis as $pm) : ?>
                          <option value="<?= $pm["id_param"]; ?>"><?= $pm["nama_param"]; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <!-- Shift Medis -->
                  <div class="form-group row">
                    <label for="shift_medis" class="col-md-4 col-form-label">Shift Medis</label>
                    <div class="col-md-8">
                      <select name="shift_medis" id="shift_medis" class="js-example-placeholder-single js-states form-control" required>
                        <option></option>
                        <option value="Pagi">Pagi</option>
                        <option value="Siang">Siang</option>
                        <option value="Sore">Sore</option>
                      </select>
                    </div>
                  </div>
                </div>
                <!-- /Petugas Jaga -->

                <!-- Pasien Jaga -->
                <div class="col-md-5">
                  <!-- Nama Pasien -->
                  <div class="form-group row">
                    <label for="nm_medis" class="col-md-4 col-form-label">Nama Pasien</label>
                    <div class="col-md-8">
                      <select name="nm_medis" id="nm_medis" class="js-example-placeholder-single js-states form-control" required onchange="changeValue(this.value)">
                        <option></option>
                        <?php
                        $pasien   = query("SELECT * FROM tabel_pasien");
                        $jsArray  = "var data = new Array();\n";
                        ?>
                        <?php foreach ($pasien as $ps) : ?>
                          <option value="<?= $ps["id_pasien"]; ?>"><?= $ps["nama_pasien"]; ?></option>
                          <?php
                          $jsArray .= "data['" . $ps['id_pasien'] . "'] = 
                          {id: '" . addslashes($ps['id_pasien']) . "',
                          jk: '" . addslashes($ps['jns_kelamin_pasien']) . "',
                          umur: '" . addslashes($ps['umur_pasien']) . "',
                          almt: '" . addslashes($ps['alamat_pasien']) . "'};\n";
                          ?>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <!-- Jenis Kelamin Pasien -->
                  <div class="form-group row">
                    <label for="jk_medis" class="col-md-4 col-form-label">Jenis Kelamin</label>
                    <div class="col-md-8">
                      <input type="text" name="jk_medis" id="jk_medis" class="form-control" readonly>
                    </div>
                  </div>
                  <!-- Umur Pasien -->
                  <div class="form-group row">
                    <label for="umur_medis" class="col-md-4 col-form-label">Umur Pasien</label>
                    <div class="col-md-5 input-group">
                      <input type="text" name="umur_medis" id="umur_medis" class="form-control" readonly>
                      <div class="input-group-append">
                        <span class="input-group-text">Tahun</span>
                      </div>
                    </div>
                  </div>
                  <!-- Alamat Pasien -->
                  <div class="form-group row">
                    <label for="almt_medis" class="col-md-4 col-form-label">Alamat Pasien</label>
                    <div class="col-md-8">
                      <input type="text" name="almt_medis" id="almt_medis" class="form-control" readonly>
                    </div>
                  </div>
                  <!-- Tipe Pasien -->
                  <div class="form-group row">
                    <label for="tipe_medis" class="col-md-4 col-form-label">Tipe Pasien</label>
                    <div class="col-md-8">
                      <select name="tipe_medis" id="tipe_medis" class="js-example-placeholder-single js-states form-control" required>
                        <option></option>
                        <option value="Umum">Umum</option>
                        <option value="Bpjs">Bpjs</option>
                        <option value="Aqua">Aqua</option>
                      </select>
                    </div>
                  </div>
                </div>
                <!-- /Pasien Jaga -->
                <div class="col-md-2">
                  <button type="button" name="btn_tambah_pasien" id="btn_tambah_pasien" class="btn btn-block btn-primary text-center" data-toggle="modal" data-target="#tambah_pasien" style="height: 253px;">
                    <i class="fas fa-user-plus"></i><br>
                    Tambah Data Pasien Baru
                  </button>
                </div>
              </div>
              <hr style="margin-top: 0px;">
              <div class="row">
                <!-- Diagnosa Medis -->
                <div class="col-md-4">
                  <div class="form-group row">
                    <label for="diagnosa_medis" class="col-md-3 col-form-label">Diagnosa</label>
                    <div class="col-md-9">
                      <textarea name="diagnosa_medis" id="diagnosa_medis" cols="30" rows="2" class="form-control text-lowercase"></textarea>
                    </div>
                  </div>
                </div>
                <!-- Terapi Medis -->
                <div class="col-md-4">
                  <div class="form-group row">
                    <label for="terapi_medis" class="col-md-3 col-form-label">Terapi</label>
                    <div class="col-md-9">
                      <textarea name="terapi_medis" id="terapi_medis" cols="30" rows="2" class="form-control text-lowercase"></textarea>
                    </div>
                  </div>
                </div>
                <!-- Biaya Medis -->
                <div class="col-md-4">
                  <div class="form-group row">
                    <label for="biaya_medis" class="col-md-3 col-form-label">Biaya</label>
                    <div class="col-md-9 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Rp.</span>
                      </div>
                      <input type="text" name="biaya_medis" id="biaya_medis" class="form-control" required autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                    </div>
                  </div>
                </div>
              </div>
              <hr style="margin-top: 0px;">
              <div class="row">
                <div class="col-md-12 text-right">
                  <button type="submit" name="btn_simpan_medis" id="btn_simpan_medis" class="btn btn-success" style="width: 125px;">
                    <i class="fas fa-save"></i>&emsp;Simpan
                  </button>
                  &emsp;
                  <button type="reset" name="btn_reset_medis" id="btn_reset_medis" class="btn btn-danger" style="width: 125px;">
                    <i class="fas fa-times-circle"></i>&emsp;Batal
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /Tambah Data Rekam Medis -->
<script type="text/javascript">
  <?= $jsArray; ?>

  function changeValue(id_pasien) {
    document.getVal
    document.getElementById('almt_medis').value = data[id_pasien].almt;
    document.getElementById('jk_medis').value = data[id_pasien].jk;
    document.getElementById('umur_medis').value = data[id_pasien].umur;
  };
</script>
<script type="text/javascript">
  function eraseText() {
    document.getElementById('pasien_medis').value = "";
    document.getElementById('alamat_medis').value = "";
    document.getElementById('jeniskelamin').value = "";
    document.getElementById('umur').value = "";
  }
</script>