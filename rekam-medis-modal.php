<?php

$id     = $rm["id_medis"];
$medis  = query("SELECT rm.*, dr.*, pm.*, ps.* FROM (((tabel_medis rm
                  INNER JOIN tabel_dokter dr    ON rm.id_dokter = dr.id_dokter)
                  INNER JOIN tabel_paramedis pm ON rm.id_param  = pm.id_param)
                  INNER JOIN tabel_pasien ps    ON rm.id_pasien = ps.id_pasien)
                WHERE rm.id_medis = '$id'")[0];

?>
<!-- Modal Rekmed Info -->
<div class="modal fade" id="info_medis<?= $medis["id_medis"]; ?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Info Data Rekam Medis</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Modal Body -->
      <form action="" method="post">
        <div class="modal-body row">
          <div class="col-md-12">
            <table class="table-sm justify-content-center">
              <tr>
                <td width="175">&emsp;ID Rekmed</td>
                <td width="25" class="text-center">:</td>
                <td width="300"><?= $medis["id_medis"]; ?>&emsp;</td>
              </tr>
              <tr>
                <td width="175">&emsp;Tanggal</td>
                <td width="25" class="text-center">:</td>
                <td width="300"><?= $medis["tanggal_medis"]; ?>&emsp;</td>
              </tr>
              <tr>
                <td width="175">&emsp;Dokter Jaga</td>
                <td width="25" class="text-center">:</td>
                <td width="300"><?= $medis["nama_dokter"]; ?>&emsp;</td>
              </tr>
              <tr>
                <td width="175">&emsp;Paramedis Jaga</td>
                <td width="25" class="text-center">:</td>
                <td width="300"><?= $medis["nama_param"]; ?>&emsp;</td>
              </tr>
              <tr>
                <td width="175">&emsp;Shift Jaga</td>
                <td width="25" class="text-center">:</td>
                <td width="300"><?= $medis["shift_medis"]; ?>&emsp;</td>
              </tr>
              <tr>
                <td width="175">&emsp;Nama Pasien</td>
                <td width="25" class="text-center">:</td>
                <td width="300"><?= $medis["nama_pasien"]; ?>&emsp;</td>
              </tr>
              <tr>
                <td width="175">&emsp;Jenis Kelamin</td>
                <td width="25" class="text-center">:</td>
                <td width="300"><?= $medis["jns_kelamin_pasien"]; ?>&emsp;</td>
              </tr>
              <tr>
                <td width="175">&emsp;Alamat Pasien</td>
                <td width="25" class="text-center">:</td>
                <td width="300"><?= $medis["alamat_pasien"]; ?>&emsp;</td>
              </tr>
              <tr>
                <td width="175">&emsp;Umur Pasien</td>
                <td width="25" class="text-center">:</td>
                <td width="300"><?= $medis["umur_pasien"]; ?> Tahun&emsp;</td>
              </tr>
              <tr>
                <td width="175">&emsp;Tipe Pasien</td>
                <td width="25" class="text-center">:</td>
                <td width="300"><?= $medis["tipe_pasien"]; ?>&emsp;</td>
              </tr>
              <tr>
                <td width="175">&emsp;Diagnosa</td>
                <td width="25" class="text-center">:</td>
                <td width="300"><?= $medis["diagnosa_medis"]; ?>&emsp;</td>
              </tr>
              <tr>
                <td width="175">&emsp;Terapi</td>
                <td width="25" class="text-center">:</td>
                <td width="300"><?= $medis["terapi_medis"]; ?>&emsp;</td>
              </tr>
              <tr>
                <td width="175">&emsp;Biaya Medis</td>
                <td width="25" class="text-center">:</td>
                <td width="300">Rp. <?= number_format($medis["biaya_medis"], 0, ".", "."); ?>&emsp;</td>
              </tr>
            </table>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /Modal Rekmed Info -->