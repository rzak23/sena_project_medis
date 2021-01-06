<?php
$id         = $_GET["id"];
$ubah_medis = query("SELECT * FROM tabel_medis WHERE id_medis = '$id'")[0];

// Simpan Ubah Rekam Medis
if (isset($_POST["btn_ubah_medis"])) {
  if (ubah_medis($_POST) > 0) {
    echo "<script>alert ('Perubahan data rekam medis berhasil!'); document.location.href = 'rekam-medis.php'</script>";
  } else {
    echo "<script>alert ('Perubahan data rekam medis gagal!'); document.location.href = 'rekam-medis.php'</script>";
  }
}
?>
<!-- Ubah Data Rekam Medis -->
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Ubah Data Rekam Medis</h5>
      </div>
      <div class="card-body row">
        <div class="col-md-12">
          <form action="" method="post">
            <div class="row form-horizontal">
              <!-- Petugas Jaga -->
              <div class="col-md-5">
                <!-- ID Rekmed -->
                <div class="form-group row">
                  <label for="id_rekmed" class="col-md-4 col-form-label">Id Rekmed</label>
                  <div class="col-md-8">
                    <input type="text" name="id_rekmed" id="id_rekmed" class="form-control" value="<?= $ubah_medis["id_medis"]; ?>" readonly>
                  </div>
                </div>
                <!-- Tanggal Rekmed -->
                <div class="form-group row">
                  <label for="tgl_rekmed" class="col-md-4 col-form-label">Tanggal Rekmed</label>
                  <div class="col-md-8">
                    <input type="date" name="tgl_rekmed" id="tgl_rekmed" class="form-control" value="<?= $ubah_medis["tanggal_medis"]; ?>">
                  </div>
                </div>
                <!-- Dokter Rekmed -->
                <div class="form-group row">
                  <label for="dokter_medis" class="col-md-4 col-form-label">Dokter Jaga</label>
                  <div class="col-md-8">
                    <select name="dokter_medis" id="dokter_medis" class="js-example-placeholder-single js-states form-control" required>
                      <option></option>
                      <?php $dokter = query("SELECT * FROM tabel_dokter"); ?>
                      <?php foreach ($dokter as $dr) : ?>
                        <?php $select = ($dr["id_dokter"] == $ubah_medis["id_dokter"]) ? "selected" : ""; ?>
                        <option value="<?= $dr["id_dokter"]; ?>" <?= $select; ?>><?= $dr["nama_dokter"]; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <!-- Paramedis Rekmed -->
                <div class="form-group row">
                  <label for="param_medis" class="col-md-4 col-form-label">Paramedis Jaga</label>
                  <div class="col-md-8">
                    <select name="param_medis" id="param_medis" class="js-example-placeholder-single js-states form-control" required>
                      <option></option>
                      <?php $param = query("SELECT * FROM tabel_paramedis"); ?>
                      <?php foreach ($param as $pm) : ?>
                        <?php $select = ($pm["id_param"] == $ubah_medis["id_param"]) ? "selected" : ""; ?>
                        <option value="<?= $pm["id_param"]; ?>" <?= $select; ?>><?= $pm["nama_param"]; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <!-- Shift Jaga -->
                <div class="form-group row">
                  <label for="shift_medis" class="col-md-4 col-form-label">Shift Jaga</label>
                  <div class="col-md-8">
                    <select name="shift_medis" id="shift_medis" class="js-example-placeholder-single js-states form-control" required>
                      <option></option>
                      <?php
                      $select1 = ($ubah_medis["shift_medis"] == "Pagi") ? "selected" : "";
                      $select2 = ($ubah_medis["shift_medis"] == "Sore") ? "selected" : "";
                      $select3 = ($ubah_medis["shift_medis"] == "Malam") ? "selected" : "";
                      ?>
                      <option value="Pagi" <?= $select1; ?>>PAGI</option>
                      <option value="Sore" <?= $select2; ?>>SORE</option>
                      <option value="Malam" <?= $select3; ?>>MALAM</option>
                    </select>
                  </div>
                </div>
              </div>
              <!-- /Petugas Jaga -->
              <!-- Pasien Rekmed -->
              <div class="col-md-5">
                <!-- Nama Pasien -->
                <div class="form-group row">
                  <label for="nm_medis" class="col-md-4 col-form-label">Nama Pasien</label>
                  <div class="col-md-8">
                    <select name="nm_medis" id="nm_medis" class="js-example-placeholder-single js-states form-control" required onchange="changeValue(this.value)">
                      <option></option>
                      <?php
                      $pasien = query("SELECT * FROM tabel_pasien");
                      $jsArray  = "var data = new Array();\n";
                      ?>
                      <?php foreach ($pasien as $ps) : ?>
                        <?php $select = ($ps["id_pasien"] == $ubah_medis["id_pasien"]) ? "selected" : ""; ?>
                        <option value="<?= $ps["id_pasien"]; ?>" <?= $select; ?>><?= $ps["nama_pasien"]; ?></option>
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
                <?php $ps_detail = query("SELECT * FROM tabel_pasien WHERE id_pasien = " . $ubah_medis['id_pasien'] . "")[0]; ?>
                <!-- Jenis Kelamin Pasien -->
                <div class="form-group row">
                  <label for="jk_pasien" class="col-md-4 col-form-label">Jenis Kelamin</label>
                  <div class="col-md-8">
                    <input type="text" name="jk_medis" id="jk_medis" value="<?= $ps_detail["jns_kelamin_pasien"]; ?>" class="form-control" readonly>
                  </div>
                </div>
                <!-- Usia Pasien -->
                <div class="form-group row">
                  <label for="umur_pasien" class="col-md-4 col-form-label">Umur Pasien</label>
                  <div class="col-md-4 input-group">
                    <input type="text" name="umur_medis" id="umur_medis" value="<?= $ps_detail["umur_pasien"]; ?>" class="form-control" readonly onkeypress="return angka(event)">
                    <div class="input-group-append">
                      <span class="input-group-text">Tahun</span>
                    </div>
                  </div>
                </div>
                <!-- Alamat Pasien -->
                <div class="form-group row">
                  <label for="almt_pasien" class="col-md-4 col-form-label">Alamat Pasien</label>
                  <div class="col-md-8">
                    <input type="text" name="almt_medis" id="almt_medis" value="<?= $ps_detail["alamat_pasien"]; ?>" class="form-control" readonly>
                  </div>
                </div>
                <!-- Tipe Pasien -->
                <div class="form-group row">
                  <label for="tipe_medis" class="col-md-4 col-form-label">Tipe Pasien</label>
                  <div class="col-md-8">
                    <?php
                    $tipe1 = ($ubah_medis["tipe_pasien"] == "Umum") ? "selected" : "";
                    $tipe2 = ($ubah_medis["tipe_pasien"] == "Bpjs") ? "selected" : "";
                    $tipe3 = ($ubah_medis["tipe_pasien"] == "Aqua") ? "selected" : "";
                    ?>
                    <select name="tipe_medis" id="tipe_medis" class="js-example-placeholder-single js-states form-control" required>
                      <option></option>
                      <option value="Umum" <?= $tipe1; ?>>UMUM</option>
                      <option value="Bpjs" <?= $tipe2; ?>>BPJS</option>
                      <option value="Aqua" <?= $tipe3; ?>>AQUA</option>
                    </select>
                  </div>
                </div>
              </div>
              <!-- /Pasien Rekmed -->
              <div class="col-md-2">
                <button type="button" name="btn_tambah_pasien" id="btn_tambah_pasien" class="btn btn-block btn-default text-center" disabled style="height: 253px;">
                  <i class="fas fa-user-plus"></i><br>
                  Tambah Data Pasien Baru
                </button>
              </div>
            </div>

            <hr style="margin-top: 0px;">

            <!-- Diagnosa, Terapi & Biaya -->
            <div class="row">
              <div class="col-md-4">
                <div class="form-group row">
                  <label for="diag_rekmed" class="col-md-3 col-form-label">Diagnosa</label>
                  <div class="col-md-9">
                    <textarea name="diag_rekmed" id="diag_rekmed" cols="30" rows="2" class="form-control"><?= $ubah_medis["diagnosa_medis"]; ?></textarea>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group row">
                  <label for="terp_rekmed" class="col-md-3 coll-form-label">Terapi</label>
                  <div class="col-md-9">
                    <textarea name="terp_rekmed" id="terp_rekmed" cols="30" rows="2" class="form-control"><?= $ubah_medis["terapi_medis"]; ?></textarea>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group row">
                  <label for="biaya_medis" class="col-md-3 col-form-label">Biaya</label>
                  <div class="col-md-9 input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Rp.</span>
                    </div>
                    <?php $disable = ($tipe2 or $tipe3) ? "readonly" : ""; ?>
                    <input type="text" name="biaya_medis" id="biaya_medis" class="form-control" value="<?= number_format($ubah_medis["biaya_medis"], 0, ".", "."); ?>" <?= $disable; ?> required autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                  </div>
                </div>
              </div>
            </div>
            <hr style="margin-top: 0px;">
            <!-- /Diagnosa, Terapi & Biaya -->

            <!-- Tombol Save & Batal -->
            <div class="row">
              <div class="col-md-12 text-right">
                <button type="submit" name="btn_ubah_medis" id="btn_ubah_medis" class="btn btn-success" style="width: 110px;">
                  <i class="fas fa-save"></i>&emsp;Simpan
                </button>
                &emsp;
                <a href="?" name="batal_rekmed" id="batal_rekmed" class="btn btn-danger" style="width: 110px;">
                  <i class="fas fa-times"></i>&emsp;Batal
                </a>
              </div>
            </div>
            <!-- /Tombol Save & Batal -->
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /Ubah Data Rekam Medis -->
<script type="text/javascript">
  <?= $jsArray; ?>

  function changeValue(id_pasien) {
    document.getVal
    document.getElementById('almt_medis').value = data[id_pasien].almt;
    document.getElementById('jk_medis').value = data[id_pasien].jk;
    document.getElementById('umur_medis').value = data[id_pasien].umur;
  };
</script>