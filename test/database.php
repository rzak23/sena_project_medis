<?php

// Koneksikan Database
$koneksi = mysqli_connect("localhost", "root", "", "db_rekam_medis");

// Ambil Data
function query($query)
{
  global $koneksi;
  $result = mysqli_query($koneksi, $query);
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}

// Konfigurasi Pada Tabel Pengguna
// ==> Tambah Data Pengguna
function tambah_pengguna($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_pengguna      = $data["id_pengguna"];
  $tanggal_pengguna = $data["tgl_daftar"];
  $nama_pengguna    = strtolower($data["username_pengguna"]);
  $tipe_pengguna    = strtoupper($data["tipe_pengguna"]);
  $kata_sandi       = mysqli_real_escape_string($koneksi, $data["password_1"]);
  $konfirm_sandi    = $data["password_2"];
  $kode             = $data["kode_keamanan"];
  // Cek Kesamaan Nama Pengguna
  $result = mysqli_query($koneksi, "SELECT nama_pengguna FROM tabel_pengguna WHERE nama_pengguna = '$nama_pengguna'");
  if (mysqli_fetch_assoc($result)) {
    echo "<script>alert ('Nama pengguna sudah ada!'); document.location.href = 'master-pengguna.php';</script>";
    return false;
  }
  // Cek Kesamaan Kata Sandi
  if ($kata_sandi !== $konfirm_sandi) {
    echo "<script>alert ('Kata sandi tidak sama, coba ulangi lagi!'), document.location.href = 'master-pengguna.php';</script>";
    return false;
  }
  // Enskripsi Kata Sandi
  $kata_sandi_baru = password_hash($kata_sandi, PASSWORD_DEFAULT);
  // Query Tambah Data Pengguna
  $query = "INSERT INTO tabel_pengguna VALUES 
            ('$id_pengguna',
            '$tanggal_pengguna',
            '$nama_pengguna',
            '$tipe_pengguna',
            '$kata_sandi_baru',
            '$kode')";
  mysqli_query($koneksi, $query);
  return mysqli_affected_rows($koneksi);
}
// ==> Ubah Kata Sandi
function sandi_pengguna($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_pengguna      = $data["id_pengguna"];
  $kata_sandi       = mysqli_real_escape_string($koneksi, $data["pass_new"]);
  $konfirm_sandi    = $data["confirm_newpass"];
  // Cek Kesamaan Kata Sandi
  if ($kata_sandi !== $konfirm_sandi) {
    echo "<script>alert ('Kata sandi tidak sama, coba ulangi lagi!'), document.location.href = 'master-pengguna.php';</script>";
    return false;
  }
  // Enskripsi Kata Sandi Baru
  $kata_sandi_baru = password_hash($kata_sandi, PASSWORD_DEFAULT);
  // Query Lupa Sandi
  $query = "UPDATE tabel_pengguna SET
            kata_sandi ='$kata_sandi_baru'
            WHERE id_pengguna = '$id_pengguna'";
  mysqli_query($koneksi, $query);
  return mysqli_affected_rows($koneksi);
}
// ==> Ubah Data Pengguna
function ubah_pengguna($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_pengguna      = $data["id_pengguna"];
  $nama_pengguna    = strtolower($data["username_pengguna"]);
  $tipe_pengguna    = strtoupper($data["tipe_pengguna"]);
  // Cek Username
  $result = mysqli_query($koneksi, "SELECT nama_pengguna FROM tabel_pengguna WHERE nama_pengguna = '$nama_pengguna'");
  if (mysqli_fetch_assoc($result)) {
    echo "<script>alert ('Nama pengguna sudah digunakan!');history.back(self);</script>";
    return false;
  }
  // Query Ubah Data Pengguna
  $query = "UPDATE tabel_pengguna SET
            nama_pengguna = '$nama_pengguna',
            tipe_pengguna = '$tipe_pengguna'
            WHERE id_pengguna = '$id_pengguna'";
  mysqli_query($koneksi, $query);
  return mysqli_affected_rows($koneksi);
}
// ==> Hapus Data Pengguna
function hapus_pengguna($data)
{
  global $koneksi;
  // Ambil Data Pengguna
  $id_pengguna = $data["id_pengguna"];
  mysqli_query($koneksi, "DELETE FROM tabel_pengguna WHERE id_pengguna = '$id_pengguna'");
  return mysqli_affected_rows($koneksi);
}

// Konfigurasi Pada Tabel Dokter
// ==> Tambah Data Dokter
function tambah_dokter($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_dokter            = $data["id_dokter"];
  $nama_dokter          = ucwords($data["nm_dokter"]);
  $jns_kelamin_dokter   = $data["jk_dokter"];
  $alamat_dokter        = ucwords($data["almt_dokter"]);
  $telepon_dokter       = $data["telp_dokter"];
  // Query Tambah Data Dokter
  $query = "INSERT INTO tabel_dokter VALUES 
            ('$id_dokter',
            '$nama_dokter',
            '$jns_kelamin_dokter',
            '$alamat_dokter',
            '$telepon_dokter')";
  mysqli_query($koneksi, $query);
  return mysqli_affected_rows($koneksi);
}
// ==> Ubah Data Dokter
function ubah_dokter($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_dokter            = $data["id_dokter"];
  $nama_dokter          = ucwords($data["nm_dokter"]);
  $jns_kelamin_dokter   = $data["jk_dokter"];
  $alamat_dokter        = ucwords($data["almt_dokter"]);
  $telepon_dokter       = $data["telp_dokter"];
  // Query Ubah Data Dokter
  $query = "UPDATE tabel_dokter SET
            nama_dokter         = '$nama_dokter',
            jns_kelamin_dokter  = '$jns_kelamin_dokter',
            alamat_dokter       = '$alamat_dokter',
            telepon_dokter      = '$telepon_dokter'
            WHERE id_dokter = '$id_dokter'";
  mysqli_query($koneksi, $query);
  return mysqli_affected_rows($koneksi);
}
// ==> Hapus Data Dokter
function hapus_dokter($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_dokter  = $data["id_dokter"];
  // Query Hapus Data Dokter
  mysqli_query($koneksi, "DELETE FROM tabel_dokter WHERE id_dokter = '$id_dokter'");
  return mysqli_affected_rows($koneksi);
}

// Konfigurasi Pada Tabel Paramedis
// ==> Tambah Data Paramedis
function tambah_paramedis($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_param           = $data["id_param"];
  $nama_param         = ucwords($data["nm_param"]);
  $jns_kelamin_param  = $data["jk_param"];
  $alamat_param       = ucwords($data["almt_param"]);
  $telepon_param      = $data["telp_param"];
  // Query Tambah Data Paramedis
  $query = "INSERT INTO tabel_paramedis VALUES
            ('$id_param',
            '$nama_param',
            '$jns_kelamin_param',
            '$alamat_param',
            '$telepon_param')";
  mysqli_query($koneksi, $query);
  return mysqli_affected_rows($koneksi);
}
// ==> Ubah Data Paramedis
function ubah_paramedis($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_param           = $data["id_param"];
  $nama_param         = ucwords($data["nm_param"]);
  $jns_kelamin_param  = $data["jk_param"];
  $alamat_param       = ucwords($data["almt_param"]);
  $telepon_param      = $data["telp_param"];
  // Query Ubah Data Paramedis
  $query = "UPDATE tabel_paramedis SET
            nama_param        = '$nama_param',
            jns_kelamin_param = '$jns_kelamin_param',
            alamat_param      = '$alamat_param',
            telepon_param     = '$telepon_param'
            WHERE id_param    = '$id_param'";
  mysqli_query($koneksi, $query);
  return mysqli_affected_rows($koneksi);
}
// ==> Hapus Data Paramedis
function hapus_paramedis($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_param = $data["id_param"];
  // Query Hapus Data Paramedis
  mysqli_query($koneksi, "DELETE FROM tabel_paramedis WHERE id_param = '$id_param'");
  return mysqli_affected_rows($koneksi);
}

// Konfigurasi Tabel Data Pasien
// ==> Tambah Data Pasien
function tambah_pasien($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_pasien          = $data["id_pasien"];
  $nama_pasien        = ucwords($data["nm_pasien"]);
  $jns_kelamin_pasien = $data["jk_pasien"];
  $umur_pasien        = $data["umur_pasien"];
  $alamat_pasien      = ucwords($data["almt_pasien"]);
  // Query Tambah Data Pasien
  $query  = "INSERT INTO tabel_pasien VALUES
            ('$id_pasien',
            '$nama_pasien',
            '$jns_kelamin_pasien',
            '$umur_pasien',
            '$alamat_pasien')";
  mysqli_query($koneksi, $query);
  return mysqli_affected_rows($koneksi);
}
// ==> Ubah Data Pasien
function ubah_pasien($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_pasien          = $data["id_pasien"];
  $nama_pasien        = ucwords($data["nm_pasien"]);
  $jns_kelamin_pasien = $data["jk_pasien"];
  $umur_pasien        = $data["umur_pasien"];
  $alamat_pasien      = ucwords($data["almt_pasien"]);
  // Query Ubah Data Pasien
  $query = "UPDATE tabel_pasien SET
            nama_pasien         = '$nama_pasien',
            jns_kelamin_pasien  = '$jns_kelamin_pasien',
            umur_pasien         = '$umur_pasien',
            alamat_pasien       = '$alamat_pasien'
            WHERE id_pasien     = '$id_pasien'";
  mysqli_query($koneksi, $query);
  return mysqli_affected_rows($koneksi);
}

// Konfigurasi Tabel Data Uang
// ==> Tambah & Ubah Data Uang
function set_uang($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_uang      = $data["id_uang"];
  $uang_hadir   = str_replace(".", "", $data["uang_hadir"]);
  $uang_bpjs    = str_replace(".", "", $data["uang_bpjs"]);
  $uang_aqua    = str_replace(".", "", $data["uang_aqua"]);
  $biaya_bank   = str_replace(".", "", $data["biaya_bank"]);
  // Query Set Uang
  $query = "UPDATE tabel_uang SET 
            uang_hadir    = '$uang_hadir', 
            uang_bpjs     = '$uang_bpjs', 
            uang_aqua     = '$uang_aqua',
            biaya_bank    = '$biaya_bank'
            WHERE id_uang = '$id_uang'";
  mysqli_query($koneksi, $query);
  return mysqli_affected_rows($koneksi);
}

// Konfigurasi Tabel Data Rekam Medis
// ==> Tambah Data Rekam Medis
function tambah_medis($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_medis         = $data["id_medis"];
  $tanggal_medis    = $data["tgl_medis"];
  $id_dokter        = $data["dokter_medis"];
  $id_param         = $data["param_medis"];
  $shift_medis      = $data["shift_medis"];
  $id_paseien       = $data["nm_medis"];
  $tipe_pasien      = $data["tipe_medis"];
  $diagnosa_medis   = ucwords($data["diagnosa_medis"]);
  $terapi_medis     = ucwords($data["terapi_medis"]);
  $biaya_medis      = intval(str_replace(".", "", $data["biaya_medis"]));
  // Query Tambah Data Rekam Medis
  $query = "INSERT INTO tabel_medis VALUES
              ('$id_medis',
              '$tanggal_medis',
              '$id_dokter',
              '$id_param',
              '$shift_medis',
              '$id_paseien',
              '$tipe_pasien',
              '$diagnosa_medis',
              '$terapi_medis',
              '$biaya_medis')";
  mysqli_query($koneksi, $query);
  return mysqli_affected_rows($koneksi);
}
// ==> Tambah Data Rekap Auto
function tambah_rekap_auto($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_rekap       = $data["id_rekap"];
  $tanggal_rekap  = $data["tgl_rekap"];
  $shift_rekap    = $data["shift_rekap1"];
  $id_dokter      = $data["dokter_rekap1"];
  $pasien_umum    = intval($data["umum_rekap"]);
  $pasien_bpjs    = intval($data["bpjs_rekap"]);
  $pasien_aqua    = intval($data["aqua_rekap"]);
  $kunjungan      = intval($data["jml_pasien"]);
  $total_biaya    = intval(str_replace(".", "", $data["jml_biaya"]));
  // Query Tambah Data Rekap Auto
  $query = "INSERT INTO tabel_rekap VALUES 
            ('$id_rekap',
            '$tanggal_rekap',
            '$shift_rekap',
            '$id_dokter',
            '$pasien_umum',
            '$pasien_bpjs',
            '$pasien_aqua',
            '$kunjungan',
            '$total_biaya')";
  mysqli_query($koneksi, $query);
  return mysqli_affected_rows($koneksi);
}
// ==> Ubah Data Rekam Medis
function ubah_medis($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_medis       = $data["id_rekmed"];
  $tanggal_medis  = $data["tgl_rekmed"];
  $id_dokter      = $data["dokter_medis"];
  $id_param       = $data["param_medis"];
  $shift_medis    = $data["shift_medis"];
  $id_pasien      = $data["nm_medis"];
  $tipe_pasien    = $data["tipe_medis"];
  $diagnosa_medis = ucwords($data["diag_rekmed"]);
  $terapi_medis   = ucwords($data["terp_rekmed"]);
  $biaya_medis    = intval(str_replace(".", "", $data["biaya_medis"]));
  // Query Ubah Data Rekam Medis
  $query = "UPDATE tabel_medis SET
            tanggal_medis   = '$tanggal_medis',
            id_dokter       = '$id_dokter',
            id_param        = '$id_param',
            shift_medis     = '$shift_medis',
            id_pasien       = '$id_pasien',
            tipe_pasien     = '$tipe_pasien',
            diagnosa_medis  = '$diagnosa_medis',
            terapi_medis    = '$terapi_medis',
            biaya_medis     = '$biaya_medis'
            WHERE id_medis  = '$id_medis'";
  mysqli_query($koneksi, $query);
  return mysqli_affected_rows($koneksi);
}

// Konfigurasi Tabel Data Rekap
// ==> Tambah Rekap Medis
function tambah_rekap($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_rekap       = $data["id_rekap"];
  $tanggal_rekap  = $data["tgl_rekap"];
  $shift_rekap    = $data["shift_rekap"];
  $id_dokter      = $data["dokter_rekap"];
  $pasien_umum    = intval($data["umum_rekap"]);
  $pasien_bpjs    = intval($data["bpjs_rekap"]);
  $pasien_aqua    = intval($data["aqua_rekap"]);
  $kunjungan      = intval($data["total_rekap"]);
  $total_biaya    = intval(str_replace(".", "", $data["biaya_rekap"]));
  // Query Tambah Data Rekap
  $query = "INSERT INTO tabel_rekap VALUES
            ('$id_rekap', 
            '$tanggal_rekap', 
            '$shift_rekap', 
            '$id_dokter', 
            '$pasien_umum', 
            '$pasien_bpjs', 
            '$pasien_aqua', 
            '$kunjungan', 
            '$total_biaya')";
  mysqli_query($koneksi, $query);
  return mysqli_affected_rows($koneksi);
}
// ==> Ubah Rekap Medis
function ubah_rekap($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_rekap       = $data["id_rekap"];
  $tanggal_rekap  = $data["tgl_rekap"];
  $shift_rekap    = $data["shift_rekap"];
  $id_dokter      = $data["dokter_rekap"];
  $pasien_umum    = intval($data["umum_rekap"]);
  $pasien_bpjs    = intval($data["bpjs_rekap"]);
  $pasien_aqua    = intval($data["aqua_rekap"]);
  $kunjungan      = intval($data["total_rekap"]);
  $total_biaya    = intval(str_replace(".", "", $data["biaya_rekap"]));
  // Query Ubah Data Rekap
  $query = "UPDATE tabel_rekap SET
              tanggal_rekap = '$tanggal_rekap', 
              shift_rekap   = '$shift_rekap',
              id_dokter     = '$id_dokter',
              pasien_umum   = '$pasien_umum',
              pasien_bpjs   = '$pasien_bpjs',
              pasien_aqua   = '$pasien_aqua',
              kunjungan     = '$kunjungan',
              total_biaya   = '$total_biaya'
            WHERE id_rekap  = '$id_rekap'";
  mysqli_query($koneksi, $query);
  return mysqli_affected_rows($koneksi);
}

// Konfogurasi Tabel Data Obat
// ==> Tambah Data Tagihan
function tambah_tagihan($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_tagihan       = $data["id_tagihan"];
  $nomor_nota       = $data["no_nota"];
  $tanggal_tagihan  = $data["tgl_tagihan"];
  $tanggal_bayar    = "";
  $nama_apotek      = ucwords($data["nm_apotek"]);
  $biaya_tagihan    = intval(str_replace(".", "", $data["biaya_tagihan"]));
  $bayar_tagihan    = 0;
  $status_tagihan   = $data["status_tagihan"];
  // Query Tambah Data Tagihan
  $query = "INSERT INTO tabel_obat VALUES(
            '$id_tagihan',
            '$nomor_nota',
            '$tanggal_tagihan',
            '$tanggal_bayar',
            '$nama_apotek',
            '$biaya_tagihan',
            '$bayar_tagihan',
            '$status_tagihan')";
  mysqli_query($koneksi, $query);
  return mysqli_affected_rows($koneksi);
}
// ==> Ubah Data Tagihan
function ubah_tagihan($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_tagihan       = $data["id_tagihan"];
  $nomor_nota       = $data["no_nota"];
  $tanggal_tagihan  = $data["tgl_tagihan"];
  $nama_apotek      = ucwords($data["nm_apotek"]);
  $biaya_tagihan    = intval(str_replace(".", "", $data["biaya_tagihan"]));
  $status_tagihan   = $data["status_tagihan"];
  // Query Ubah Data Tagihan
  $query = "UPDATE tabel_obat SET
            nomor_nota        = '$nomor_nota',
            tanggal_tagihan   = '$tanggal_tagihan',
            nama_apotek       = '$nama_apotek',
            biaya_tagihan     = '$biaya_tagihan',
            status_tagihan    = '$status_tagihan'
            WHERE id_tagihan  = '$id_tagihan'";
  mysqli_query($koneksi, $query);
  return mysqli_affected_rows($koneksi);
}
// ==> Tambah Data Pembayaran
function pembayaran_tagihan($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_tagihan       = $data["id_tagihan"];
  $tanggal_bayar    = $data["tgl_bayar"];
  $bayar_tagihan    = intval(str_replace(".", "", $data["bayar_tagihan"]));
  $status_tagihan   = $data["status_bayar"];
  // Query Tambah Data Pembayaran
  $query = "UPDATE tabel_obat SET
            tanggal_bayar     = '$tanggal_bayar',
            bayar_tagihan     = '$bayar_tagihan',
            status_tagihan    = '$status_tagihan'
            WHERE id_tagihan  = '$id_tagihan'";
  mysqli_query($koneksi, $query);
  return mysqli_affected_rows($koneksi);
}

// Konfigurasi Tabel Data Pengeluaran
// ==> Tambah Data Pengeluaran
function tambah_pengeluaran($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_pengeluaran       = $data["id_pengeluaran"];
  $tanggal_pengeluaran  = $data["tgl_pengeluaran"];
  $biaya_obat           = intval(str_replace(".", "", $data["biaya_obat"]));
  $biaya_gaji           = intval(str_replace(".", "", $data["biaya_gaji"]));
  $biaya_harian         = intval(str_replace(".", "", $data["biaya_harian"]));
  $total_pengeluaran    = intval(str_replace(".", "", $data["total_pengeluaran"]));
  // Query Tambah Data Pengeluaran
  $query = "INSERT INTO tabel_pengeluaran VALUES (
            '$id_pengeluaran',
            '$tanggal_pengeluaran',
            '$biaya_obat',
            '$biaya_gaji',
            '$biaya_harian',
            '$total_pengeluaran')";
  mysqli_query($koneksi, $query);
  return mysqli_affected_rows($koneksi);
}
// ==> Ubah Data Pengeluaran
function ubah_pengeluaran($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_pengeluaran       = $data["id_pengeluaran"];
  $tanggal_pengeluaran  = $data["tgl_pengeluaran"];
  $biaya_obat           = intval(str_replace(".", "", $data["biaya_obat"]));
  $biaya_gaji           = intval(str_replace(".", "", $data["biaya_gaji"]));
  $biaya_harian         = intval(str_replace(".", "", $data["biaya_harian"]));
  $total_pengeluaran    = intval(str_replace(".", "", $data["total_pengeluaran"]));
  // Query Ubah Data Pengeluaran
  $query = "UPDATE tabel_pengeluaran SET
            tanggal_pengeluaran   = '$tanggal_pengeluaran',
            biaya_obat            = '$biaya_obat',
            biaya_gaji            = '$biaya_gaji',
            biaya_harian          = '$biaya_harian',
            total_pengeluaran     = '$total_pengeluaran'
            WHERE id_pengeluaran  = '$id_pengeluaran'";
  mysqli_query($koneksi, $query);
  return mysqli_affected_rows($koneksi);
}

// Konfigurasi Tabel Data Pemasukan
// Tambah Data Pemasukan
function tambah_pemasukan($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_pemasukan       = $data["id_pemasukan"];
  $tanggal_pemasukan  = $data["tgl_pemasukan"];
  $biaya_umum         = intval(str_replace(".", "", $data["biaya_umum"]));
  $biaya_bpjs         = intval(str_replace(".", "", $data["biaya_bpjs"]));
  $biaya_aqua         = intval(str_replace(".", "", $data["biaya_aqua"]));
  $total_pemasukan    = intval(str_replace(".", "", $data["total_pemasukan"]));
  // Query Tambah Data Pemasukan
  $query = "INSERT INTO tabel_pemasukan VALUES (
            '$id_pemasukan',
            '$tanggal_pemasukan',
            '$biaya_umum',
            '$biaya_bpjs',
            '$biaya_aqua',
            '$total_pemasukan')";
  mysqli_query($koneksi, $query);
  return mysqli_affected_rows($koneksi);
}
// Ubah Data Pemasukan
function ubah_pemasukan($data)
{
  global $koneksi;
  // Ambil Data Dari Form
  $id_pemasukan       = $data["id_pemasukan"];
  $tanggal_pemasukan  = $data["tgl_pemasukan"];
  $biaya_umum         = intval(str_replace(".", "", $data["biaya_umum"]));
  $biaya_bpjs         = intval(str_replace(".", "", $data["biaya_bpjs"]));
  $biaya_aqua         = intval(str_replace(".", "", $data["biaya_aqua"]));
  $total_pemasukan    = intval(str_replace(".", "", $data["total_pemasukan"]));
  // Query Ubah Data Pemasukan
  $query = "UPDATE tabel_pemasukan SET
            tanggal_pemasukan   = '$tanggal_pemasukan',
            biaya_umum          = '$biaya_umum',
            biaya_bpjs          = '$biaya_bpjs',
            biaya_aqua          = '$biaya_aqua',
            total_pemasukan     = '$total_pemasukan'
            WHERE id_pemasukan  = '$id_pemasukan'";
  mysqli_query($koneksi, $query);
  return mysqli_affected_rows($koneksi);
}
