<?php
session_start();
include "database.php";
if (isset($_REQUEST["btn_masuk"]) > 0) {
  $username   = $_REQUEST["username"];
  $password   = $_REQUEST["password"];
  $cek_login  = mysqli_query($koneksi, "SELECT * FROM tabel_pengguna WHERE nama_pengguna = '$username'");
  if (mysqli_num_rows($cek_login) > 0) {
    $result   = mysqli_fetch_assoc($cek_login);
    if (password_verify($password, $result["kata_sandi"])) {
      $_SESSION["login"]    = true;
      $_SESSION["username"] = $result["nama_pengguna"];
      $_SESSION["tipe"]     = $result["tipe_pengguna"];
      header("location:index.php");
      exit;
    } else {
      $pesan    = "salah1";
    }
  } else {
    $pesan    = "salah2";
  }
} else {
  $pesan      = "kosong";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- ==> Font Awesome <== -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- ==> Theme Style <== -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <title>LOGIN (SIREKMED | KPPM)</title>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- Form Login -->
    <div class="card">
      <div class="card-body login-card-body">
        <!-- Logo Klinik -->
        <div class="login-logo">
          <img src="dist/img/logo-transparan.png" alt="Logo Klinik" width="225" height="85.5">
        </div>
        <!-- /Logo Klinik -->

        <!-- Pesan Login -->
        <?php if ($pesan == "salah1") : ?>
          <p class="text-center font-italic text-danger">Kata sandi anda salah !</p>
        <?php elseif ($pesan == "salah2") : ?>
          <p class="text-center font-italic text-danger">Nama pengguna anda salah !</p>
        <?php else : ?>
          <p class="text-center font-italic font-weight-bold">Masukan akun untuk memulai sistem !</p>
        <?php endif; ?>
        <form action="" method="post">
          <!-- Input Username -->
          <div class="input-group mb-3">
            <?php
            if ($pesan == "salah1") {
              $isi  = $username;
            } else {
              $isi  = "";
            }
            ?>
            <input type="text" name="username" id="username" class="form-control text-lowercase" placeholder="Nama Pengguna" value="<?= $isi; ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <!-- Input Password -->
          <div class="input-group mb-3">
            <input type="password" name="password" id="password" class="form-control" placeholder="kata sandi">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <!-- Tombol Login -->
            <div class="col-12 text-right">
              <button type="submit" id="btn_masuk" name="btn_masuk" class="btn btn-primary" style="width: 125px;">
                <i class="fas fa-sign-in-alt"></i>&emsp;Masuk
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- /Form Login -->
  </div>
</body>

<!-- ==> JQuery <== -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- ==> Bootstrap 4 <== -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ==> Theme Style <== -->
<script src="dist/js/adminlte.min.js"></script>

</html>