<?php

require_once "functions/functions.php";

session_start();

if (isset($_POST['submitLogin'])) {
  $result = loginAdmin($_POST['id_admin'], $_POST['pass']);
  if ($result != false) {
    $_SESSION['id_admin'] = $result;
    header("Location:src/beranda");
  } else {
    echo "<script>alert('Ups, maaf ID Admin atau password salah!')</script>";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Landing | Griyo Uwuh</title>
  <meta content="Hello World" name="description" />
  <link rel="icon" type="image/x-icon" href="assets/icon/Logo.png">
  <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="scss/custom.css" />
  <link rel="stylesheet" href="style/layout.css" />
</head>

<body class="bg-landing" style="font-family: 'Poppins'">
  <div class="lay-landing">
    <div class="header-landing align-items-center">
      <img class="logo-landing" src="assets/icon/Logo.png" alt="" />
      <p class="text-fontdark fw-semibold mb-0 logo-landing-nama" style="padding-left: 17px">GRIYO UWUH</p>
    </div>
    <div style="padding-top: 20px">
      <h1 class="text-fontdark mb-0 landing-title" style="font-weight: 800">MEMILAH SAMPAH SEJAK KINI, <br />UNTUK HIDUP LEBIH BERARTI</h1>
    </div>
    <div style="padding-top: 40px">
      <a href="" class="bg-fontdark text-fontlight display-heading1 border-0 btn-landing" style="border-radius: 14px; text-decoration: none" data-bs-toggle="modal" data-bs-target="#modalinput">Masuk</a>
    </div>
  </div>

  <div class="modal fade" id="modalinput" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalinputLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-login" role="document">
      <div class="modal-content text-fontdark">
        <div>
          <div class="card text-fontdark p-0" style="border-radius: 25 px;">
            <div class="card-body" style="padding: 50px 40px">
              <div class="d-flex logo">
                <img src="assets/icon/Logo.png" alt="" height="40" />
                <p class="text-fontdark fw-semibold mb-0" style="font-size: 30px; padding-left: 17px">GRIYO UWUH</p>
              </div>
              <div style="margin-top: 30px">
                <h5 class="display-title1 fw-bolder">Selamat Datang !</h5>
                <p class="display-text1">Lengkapi form untuk masuk sebagai admin</p>
              </div>
              <div style="margin-top: 24px">
                <form action="" method="POST">
                  <div>
                    <label class="form-label display-subheading" for="username">ID Admin</label>
                    <div class="position-relative input-custom-icon">
                      <input type="text" class="form-control text-fontdark" id="username" placeholder="Masukkan ID Admin" style="border-color: #c9e7af" name="id_admin" required />
                    </div>
                  </div>

                  <div style="margin-top: 14px">
                    <label class="form-label display-subheading" for="password-input">Password</label>
                    <div class="position-relative auth-pass-inputgroup input-custom-icon">
                      <input type="password" class="form-control text-fontdark" id="password-input" placeholder="Masukkan password" style="border-color: #c9e7af" name="pass" required />
                      <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon" onclick="ikon()">
                        <div id="eyeon" style="display: none"><img src="assets/icon/eye-outline.svg" alt="" /></div>
                        <div id="eyeoff" style="display: none"><img src="assets/icon/eye-off-outline.svg" alt="" /></div>
                        <div id="eye"><img src="assets/icon/eye-off-outline.svg" alt="" /></div>
                      </button>
                    </div>
                  </div>

                  <div style="margin-top: 24px">
                    <button class="btn btn-secondarydark w-100 waves-effect waves-light display-heading1 text-fontdark" type="submit" style="border-radius: 7px" name="submitLogin">Masuk</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- javascript -->
  <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- password script -->
  <script src="script/password.js"></script>

</body>
</html>