<?php

require_once "../functions/functions.php";

//session
session_start();
if (isset($_SESSION['id_admin']) == null) {
  header("Location:logout");
  exit();
}

//timeout session
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
  // last request was more than 30 minutes ago
  session_unset();     // unset $_SESSION variable for the run-time 
  session_destroy();   // destroy session data in storage
  echo "<script>alert('Sesi anda habis. Silakan log in ulang!')</script>";
  header('refresh:0; url=logout');
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

//get data tracking 
$trackingData = getTrackingAnorganik();

//add user
if (isset($_POST['addData'])) {
  $result = addUser($_POST['nama'], $_POST['email'], $_POST['telp'], $_POST['pass'], $_POST['alamat'], $_POST['jenis_pelanggan']);
  if ($result) {
    echo "<script>alert('Berhasil menambah pelanggan!')</script>";
    header('refresh:0; url=pengguna');
  } else {
    echo "<script>alert('Gagal menambah pelanggan. Mohon Ulangi.')</script>";
    header('refresh:0; url=pengguna');
  }
}

//update user
if (isset($_POST['updateUser'])) {
  $cekEmail = false;
  $cekTelp = false;
  if ($_POST['email'] !=  $_POST['emailLama']) {
    if (cekEmailUser($_POST['email']) == 1) {
      $email = $_POST['email'];
      $cekEmail = true;
    } else {
      echo "<script>alert('Email sudah digunakan!')</script>";
    }
  } else {
    $email = $_POST['email'];
    $cekEmail = true;
  }
  if ($_POST['telp'] !=  $_POST['telpLama']) {
    if (cekTelpUser($_POST['telp']) == 1) {
      $telp = $_POST['telp'];
      $cekTelp = true;
    } else {
      echo "<script>alert('Nomor telepon sudah digunakan!')</script>";
    }
  } else {
    $telp = $_POST['telp'];
    $cekTelp = true;
  }

  if ($cekEmail == true && $cekTelp == true) {
    $result = updateDataUSer($_POST['id_user'], $_POST['nama'], $email, $telp, $_POST['passBaru'], $_POST['alamat'], $_POST['jenis_pelanggan']);
    if ($result) {
      echo "<script>alert('Berhasil mengedit data pelanggan!')</script>";
      header('refresh:0; url=pengguna');
    } else {
      echo "<script>alert('Edit data pelanggan gagal. Mohon Ulangi.')</script>";
      header('refresh:0; url=pengguna');
    }
  } else {
    echo "<script>alert('Edit data pelanggan gagal. Mohon Ulangi.')</script>";
    header('refresh:0; url=pengguna');
  }
}

//delete user
$response = "";
if (isset($_POST['deleteUserByID'])) {
  // $response = deleteUser($_POST['id_user']);
  // $status = $response['status'];
  // $message = $response['message'];
  $response = deleteUser($_POST['id_user']);
  if ($response == 1) {
    echo "<script>alert('Hapus User Berhasil!')</script>";
    header('refresh:0; url=pengguna');
  } else {
    echo "<script>alert('Hapus User Gagal!')</script>";
    header('refresh:0; url=pengguna');
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Kelola Pengguna | Griyo Uwuh</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta content="Lihat daftar pengguna dari aplikasi Griyo Uwuh" name="description" />
  <link rel="icon" type="image/x-icon" href="../assets/icon/Logo.png">
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../scss/custom.css" />
  <link rel="stylesheet" href="../assets/css/app.min.css" />
  <link rel="stylesheet" href="../assets/css/icons.min.css" />

  <!-- css layout -->
  <link rel="stylesheet" href="../style/layout.css" />
  <!-- css table -->
  <link rel="stylesheet" href="../style/datatable.css" />
  <link rel="stylesheet" href="../assets/css/responsive.dataTables.min.css" />
  <!-- css card -->
  <link rel="stylesheet" href="../style/card.css" />
  <!-- Sweet Alert-->
  <link rel="stylesheet" href="../assets/libs/sweetalert2/sweetalert2.min.css" />
  <!-- lib modal edit -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body style="font-family: 'Poppins'">
  <div id="loader" class="bg-secondarylight" style="top: 0; left: 0; position: fixed; width: 100%; height: 100%; z-index: 9999; display:flex; justify-content: center; align-items: center;">
    <div class="spinner-border" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
  <!-- Begin page -->
  <div id="layout-wrapper">
    <header id="page-topbar" class="isvertical-topbar">
      <div class="navbar-header">
        <div class="d-flex">
          <!-- LOGO -->
          <div class="navbar-brand-box">
            <a href="beranda" class="logo">
              <span class="logo-lg">
                <img src="../assets/icon/Logo.png" alt="" height="30" />
              </span>
              <span class="logo-sm">
                <img src="../assets/icon/Logo.png" alt="" height="26" />
              </span>
            </a>
          </div>

          <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn">
            <i class="bx align-middle"><img src="../assets/icon/menu.png" alt="" class="icon-menu" /></i>
          </button>

          <!-- start page title -->
          <div class="page-title-box align-self-center d-none d-sm-block">
            <nav aria-label="breadcrumb" class="pt-3">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><img src="../assets/icon/User.png" alt="" class="icon-bc" /></li>
                <li class="breadcrumb-item" aria-current="page">Kelola Pengguna</li>
              </ol>
            </nav>
          </div>
          <!-- end page title -->
        </div>
      </div>
    </header>
    <!-- ========== Left Sidebar Start ========== -->
    <div class="vertical-menu">
      <!-- LOGO -->
      <div class="navbar-brand-box">
        <a href="beranda" class="logo">
          <span class="logo-lg">
            <img src="../assets/icon/Logo.png" alt="" height="30" />
            <span class="ps-2 text-fontdark display-subheading fw-semibold">GRIYO UWUH</span>
          </span>
          <span class="logo-sm">
            <img src="../assets/icon/Logo.png" alt="" height="26" />
          </span>
        </a>
      </div>
      <button type="button" class="btn btn-sm px-3 font-size-24 header-item vertical-menu-btn">
        <i class="bx align-middle"><img src="../assets/icon/menu.png" alt="" class="icon-menu" /></i>
      </button>

      <div data-simplebar class="sidebar-menu-scroll">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
          <!-- Left Menu Start -->
          <ul class="metismenu list-unstyled" id="side-menu">
            <li>
              <a href="beranda">
                <i class="bx"><img src="../assets/icon/home.png" alt="" class="icon" /></i>
                <span class="menu-item" data-key="beranda">Beranda</span>
              </a>
            </li>

            <li>
              <a href="pengguna">
                <i class="bx"><img src="../assets/icon/useractive.png" alt="" class="icon" /></i>
                <span class="menu-item" data-key="pengguna">Kelola Pengguna</span>
              </a>
            </li>

            <li>
              <a href="setoran">
                <i class="bx"><img src="../assets/icon/Trash.png" alt="" class="icon" /></i>
                <span class="menu-item" data-key="setoran">Kelola Setoran</span>
              </a>
            </li>

            <li>
              <a href="javascript: void(0); " style="background-color: #fff; color: #25581d">
                <i class="bx"><img src="../assets/icon/analytics.png" alt="" class="icon" /></i>
                <span class="menu-item" data-key="tracking">Kelola Tracking</span>
              </a>
              <ul class="sub-menu" aria-expanded="false">
                <li><a href="organik" data-key="organik">Sampah Organik</a></li>
                <li><a href="anorganik" data-key="anorganik">Sampah Anorganik</a></li>
              </ul>
            </li>

            <li>
              <a href="peringkat">
                <i class="bx"><img src="../assets/icon/Award.png" alt="" class="icon" /></i>
                <span class="menu-item" data-key="peringkat">Peringkat</span>
              </a>
            </li>

            <li class="position-absolute bottom-0 end-0">
              <a id="sa-warning" style="cursor: pointer">
                <i class="bx"><img src="../assets/icon/Logout.png" alt="" class="icon-out" /></i>
                <span class="menu-item" data-key="logout">Logout</span>
              </a>
            </li>
          </ul>
        </div>
        <!-- Sidebar -->
      </div>
    </div>
    <!-- Left Sidebar End -->
    <header class="ishorizontal-topbar">
      <div class="navbar-header">
        <div class="d-flex">
          <!-- LOGO -->
          <div class="navbar-brand-box">
            <a href="beranda" class="logo">
              <span class="logo-lg">
                <img src="../assets/icon/Logo.png" alt="" height="30" />
              </span>
              <span class="logo-sm">
                <img src="../assets/icon/Logo.png" alt="" height="26" />
              </span>
            </a>
          </div>

          <button type="button" class="btn btn-sm px-3 font-size-24 header-item vertical-menu-btn">
            <i class="bx align-middle"><img src="../assets/icon/menu.png" alt="" class="icon-menu" /></i>
          </button>
        </div>
      </div>

      <div class="topnav">
        <div class="container-fluid">
          <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
              <ul class="navbar-nav">
                <li>
                  <a href="beranda">
                    <i class="bx"><img src="../assets/icon/home.png" alt="" class="icon" /></i>
                    <span class="menu-item" data-key="beranda">Beranda</span>
                  </a>
                </li>

                <li>
                  <a href="pengguna">
                    <i class="bx"><img src="../assets/icon/useractive.png" alt="" class="icon" /></i>
                    <span class="menu-item" data-key="pengguna">Kelola Pengguna</span>
                  </a>
                </li>

                <li>
                  <a href="setoran">
                    <i class="bx"><img src="../assets/icon/Trash.png" alt="" class="icon" /></i>
                    <span class="menu-item" data-key="setoran">Kelola Setoran</span>
                  </a>
                </li>

                <li>
                  <a href="javascript: void(0);" style="background-color: #fff; color: #25581d">
                    <i class="bx"><img src="../assets/icon/analytics.png" alt="" class="icon" /></i>
                    <span class="menu-item" data-key="tracking">Kelola Tracking</span>
                  </a>
                  <ul class="sub-menu" aria-expanded="false">
                    <li><a href="organik" data-key="organik">Sampah Organik</a></li>
                    <li><a href="anorganik" data-key="anorganik">Sampah Anorganik</a></li>
                  </ul>
                </li>

                <li>
                  <a href="peringkat">
                    <i class="bx"><img src="../assets/icon/Award.png" alt="" class="icon" /></i>
                    <span class="menu-item" data-key="peringkat">Peringkat</span>
                  </a>
                </li>

                <li class="position-absolute bottom-0 end-0">
                  <a id="sa-warning" style="cursor: pointer">
                    <i class="bx"><img src="../assets/icon/Logout.png" alt="" class="icon-out" /></i>
                    <span class="menu-item" data-key="logout">Logout</span>
                  </a>
                </li>
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </header>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
      <div class="page-content">
        <div class="container-fluid">
          <div class="flexr-user">
            <div class="flexr-1">
              <div class="card card-2">
                <div class="card-body bcard-2">
                  <div>
                    <div class="d-flex align-items-center">
                      <div class="">
                        <p class="mb-0 fw-bold user-num"><?= getTotalUserGratis() ?></p>
                      </div>

                      <div class="ms-3">
                        <p class="mb-0 user-word">Pengguna Gratis</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card card-2">
                <div class="card-body bcard-2">
                  <div>
                    <div class="d-flex align-items-center">
                      <div class="">
                        <p class="mb-0 fw-bold user-num"><?= getTotalUserBerbayar() ?></p>
                      </div>

                      <div class="ms-3">
                        <p class="mb-0 user-word">Pengguna Berbayar</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="d-absolute text-center">
              <button class="mb-0 btn-user bg-fontdark text-white" data-bs-toggle="modal" data-bs-target="#modalinput">
                <div class="d-flex align-items-center">
                  <div class="">
                    <p class="mb-0 b-img"><img src="../assets/icon/User-plus.png" alt="" style="height: 50px; display: block; margin: auto" /></p>
                  </div>

                  <div class="ms-3">
                    <p class="mb-0 user-word">Tambah Pengguna</p>
                  </div>
                </div>
              </button>
            </div>
          </div>

          <div>
            <!-- Add User Modal -->
            <div class="modal fade" id="modalinput" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalinputLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content text-fontdark">
                  <div class="modal-header" style="border-color: #c9e7af; padding: 17px 33px">
                    <h5 class="modal-title display-subheading fw-semibold" id="modalinputLabel">Tambah Data Pengguna</h5>
                    <img src="../assets/icon/Close.png" alt="" data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer" />
                  </div>
                  <div class="modal-body justify-content-center" style="padding: 29px 33px">
                    <div>
                      <form action="" method="POST">
                        <div class="flexmodal align-items-center" style="padding-bottom: 15px">
                          <label for="" class="display-subheading" style="min-width: 180px; margin-right: 20px">Nama</label>
                          <input type="text" class="form-control text-fontdark bg-secondary" id="" name="nama" value="" style="border-color: #c9e7af" required />
                        </div>
                        <div class="flexmodal align-items-center" style="padding-bottom: 15px">
                          <label for="" class="display-subheading" style="min-width: 180px; margin-right: 20px">Email</label>
                          <input type="email" class="form-control text-fontdark bg-secondary" id="" name="email" value="" style="border-color: #c9e7af" />
                        </div>
                        <div class="flexmodal align-items-center" style="padding-bottom: 15px">
                          <label for="" class="display-subheading" style="min-width: 180px; margin-right: 20px">Nomor Telepon</label>
                          <input type="numb" class="form-control text-fontdark bg-secondary" id="" name="telp" value="" style="border-color: #c9e7af" />
                        </div>
                        <div class="flexmodal align-items-center" style="padding-bottom: 15px">
                          <label for="" class="display-subheading" style="min-width: 180px; margin-right: 20px">Password</label>
                          <div class="position-relative auth-pass-inputgroup input-custom-icon" style="width:100%">
                            <input type="password" class="form-control text-fontdark bg-secondary" id="password-input" name="pass" value="" style="border-color: #c9e7af" required />
                            <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon" onclick="ikon()">
                              <div id="eyeon" style="display: none"><img src="../assets/icon/eye-outline.svg" alt="" /></div>
                              <div id="eyeoff" style="display: none"><img src="../assets/icon/eye-off-outline.svg" alt="" /></div>
                              <div id="eye"><img src="../assets/icon/eye-off-outline.svg" alt="" /></div>
                            </button>
                          </div>
                        </div>
                        <div class="flexmodal" style="padding-bottom: 15px">
                          <label for="" class="display-subheading" style="min-width: 180px; margin-right: 20px">Alamat</label>
                          <textarea rows="3" class="form-control text-fontdark bg-secondary" id="" name="alamat" value="" style="border-color: #c9e7af"></textarea>
                        </div>
                        <div class="flexmodal align-items-center">
                          <label for="" class="display-subheading" style="min-width: 180px; margin-right: 20px">Jenis Pelanggan</label>
                          <select class="form-select text-fontdark bg-secondary w-drpdown" aria-label="" style="border-color: #c9e7af" name="jenis_pelanggan">
                            <option value="gratis">Gratis</option>
                            <option value="berbayar">Berbayar</option>
                          </select>
                        </div>
                        <div class="modal-button">
                          <button type="button" class="btn btn-red text-fontlight" data-bs-dismiss="modal" style="padding: 6px 20px">Batal</button>
                          <button type="submit" class="btn btn-fontdark text-fontlight" style="padding: 6px 20px" name="addData">Simpan</button>
                        </div>
                      </form>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>

          <!-- DATA TABLE -->
          <div class="y-gap-layout">
            <div class="card px-0" style="padding: 25px">
              <table id="dtable-user" class="nowrap table" style="width: 100%; font-size: 16px; border-color: #e9ffd6">
                <thead>
                  <tr>
                    <th class="dt-head-center" style="border-top-left-radius: 7px">ID Pengguna</th>
                    <th class="dt-head-center">Nama</th>
                    <th class="dt-head-center">Email</th>
                    <th class="dt-head-center">Nomor Telepon</th>
                    <th class="dt-head-center" style="min-width:250px">Alamat</th>
                    <th class="dt-head-center">Jenis</th>
                    <th class="dt-head-center" style="border-top-right-radius: 7px">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $usersData = getUsers();
                  for ($i = 0; $i < sizeof($usersData); $i++) {
                  ?>
                    <tr>
                      <td class="dt-center"><?= $usersData[$i]['id_user'] ?></td>
                      <td><?= $usersData[$i]['nama'] ?></td>
                      <td><?= $usersData[$i]['email'] ?></td>
                      <td class="dt-center"><?= $usersData[$i]['telp'] ?></td>
                      <td style="white-space: wrap; overflow: hidden;"><?= $usersData[$i]['alamat'] ?></td>
                      <td class="dt-center"><button class="btn-table bg-<?= $usersData[$i]['jenis_pelanggan'] ?>" style="cursor: default; color: #25581d"><?= ucfirst($usersData[$i]['jenis_pelanggan']) ?></button></td>
                      <td class="dt-center">
                        <img src="../assets/icon/Edit.png" alt="" data-bs-toggle="modal" data-bs-target="#modalverif<?= $usersData[$i]['id_user'] ?>" style="cursor: pointer; padding-right: 3px" class="icon-btn" />
                        <img src="../assets/icon/Trash-2.png" alt="" data-bs-toggle="modal" data-bs-target="#modalhapus<?= $usersData[$i]['id_user'] ?>" style="cursor: pointer" class="icon-btn" />
                      </td>

                      <!-- Verif Edit Modal -->
                      <div class="modal fade" id="modalverif<?= $usersData[$i]['id_user'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalverifLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                          <div class="modal-content text-fontdark">
                            <div class="modal-header" style="border-color: #c9e7af; padding: 17px 33px">
                              <h5 class="modal-title display-subheading fw-semibold" id="modalverifLabel">Verifikasi Ubah Data Pengguna</h5>
                              <img src="../assets/icon/Close.png" alt="" data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer" />
                            </div>
                            <div class="modal-body justify-content-center" style="padding: 29px 33px">
                              <div>
                                <form action="" method="POST">
                                  <div class="flexmodal align-items-center" style="padding-bottom: 15px">
                                    <input type="hidden" name="id_user" value="<?= $usersData[$i]['id_user'] ?>">
                                    <label for="" class="display-subheading" style="min-width: 220px">Email/Nomor Telepon</label>
                                    <input type="text" class="form-control text-fontdark bg-secondary" id="" name="emailtelp" value="" style="border-color: #c9e7af" required />
                                  </div>
                                  <div class="flexmodal align-items-center" style="padding-bottom: 15px">
                                    <label for="" class="display-subheading" style="min-width: 220px">Password Lama</label>
                                    <div class="position-relative auth-pass-inputgroup input-custom-icon" style="width:100%">
                                      <input type="password" class="form-control text-fontdark bg-secondary" id="password-input-verif" name="pass" value="" style="border-color: #c9e7af" required />
                                      <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon" onclick="ikonverif()">
                                        <div id="eyeon-verif" style="display: none"><img src="../assets/icon/eye-outline.svg" alt="" /></div>
                                        <div id="eyeoff-verif" style="display: none"><img src="../assets/icon/eye-off-outline.svg" alt="" /></div>
                                        <div id="eye-verif"><img src="../assets/icon/eye-off-outline.svg" alt="" /></div>
                                      </button>
                                    </div>
                                  </div>
                                  <a href="" data-bs-target="#modalizin<?= $usersData[$i]['id_user'] ?>" data-bs-toggle="modal" data-bs-dismiss="modal" class="text-wireframe4">Lupa password</a>
                                  <div class="modal-button">
                                    <button type="button" class="btn btn-red text-fontlight" data-bs-dismiss="modal" style="padding: 6px 20px">Batal</button>
                                    <button type="submit" class="btn btn-fontdark text-fontlight" style="padding: 6px 20px" name="submitVerif">Simpan</button>
                                  </div>
                                </form>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>

                      <?php
                      //buat btn verif
                      if (isset($_POST['submitVerif'])) {
                        $id_user = $_POST['id_user'];
                        if ((cekUserEmail("$_POST[emailtelp]", "$_POST[pass]") == 1 || cekUserTelp("$_POST[emailtelp]", "$_POST[pass]") == 1)) {
                          echo "<script type='text/javascript'>
                          $(document).ready(function(){
                          $('#modaledit$id_user').modal('show');
                          });
                          </script>";
                        } else {
                          echo "<script type='text/javascript'>
                          $(document).ready(function(){
                          $('#modalverif_ulang$id_user').modal('show');
                          });
                          </script>";
                        }
                      }
                      ?>

                      <!-- Verif Edit Modal Ulang -->
                      <div class="modal fade" id="modalverif_ulang<?= $usersData[$i]['id_user'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalverifLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                          <div class="modal-content text-fontdark">
                            <div class="modal-header" style="border-color: #c9e7af; padding: 17px 33px">
                              <h5 class="modal-title display-subheading fw-semibold" id="modalverifLabel">Verifikasi Ubah Data Pengguna</h5>
                              <img src="../assets/icon/Close.png" alt="" data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer" />
                            </div>
                            <div class="modal-body justify-content-center" style="padding: 29px 33px">
                              <div>
                                <form action="" method="POST">
                                  <p class="text-red py-2 display-text1">Email atau password tidak sesuai, silakan coba kembali</p>
                                  <div class="flexmodal align-items-center" style="padding-bottom: 15px">
                                    <input type="hidden" name="id_user" value="<?= $usersData[$i]['id_user'] ?>">
                                    <label for="" class="display-subheading" style="min-width: 220px">Email/Nomor Telepon</label>
                                    <input type="text" class="form-control text-fontdark bg-secondary" id="" name="emailtelp" value="" style="border-color: #c9e7af" required />
                                  </div>
                                  <div class="flexmodal align-items-center" style="padding-bottom: 15px">
                                    <label for="" class="display-subheading" style="min-width: 220px">Password Lama</label>
                                    <div class="position-relative auth-pass-inputgroup input-custom-icon" style="width:100%">
                                      <input type="password" class="form-control text-fontdark bg-secondary" id="password-input-verifu" name="pass" value="" style="border-color: #c9e7af" required />
                                      <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon" onclick="ikonverifu()">
                                        <div id="eyeon-verifu" style="display: none"><img src="../assets/icon/eye-outline.svg" alt="" /></div>
                                        <div id="eyeoff-verifu" style="display: none"><img src="../assets/icon/eye-off-outline.svg" alt="" /></div>
                                        <div id="eye-verifu"><img src="../assets/icon/eye-off-outline.svg" alt="" /></div>
                                      </button>
                                    </div>
                                  </div>
                                  <a href="" data-bs-target="#modalizin<?= $usersData[$i]['id_user'] ?>" data-bs-toggle="modal" data-bs-dismiss="modal" class="text-wireframe4">Lupa password</a>
                                  <div class="modal-button">
                                    <button type="button" class="btn btn-red text-fontlight" data-bs-dismiss="modal" style="padding: 6px 20px">Batal</button>
                                    <button type="submit" class="btn btn-fontdark text-fontlight" style="padding: 6px 20px" name="submitVerif">Simpan</button>                                    
                                  </div>
                                </form>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>

                      <!-- Kode Izin Modal-->
                      <div class="modal fade" id="modalizin<?= $usersData[$i]['id_user'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalizinLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                          <div class="modal-content text-fontdark">
                            <div class="modal-header" style="border-color: #c9e7af; padding: 17px 33px">
                              <h5 class="modal-title display-subheading fw-semibold" id="modalverifLabel">Perizinan Ubah Data Pengguna</h5>
                              <img src="../assets/icon/Close.png" alt="" data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer" />
                            </div>
                            <div class="modal-body justify-content-center" style="padding: 29px 33px">
                              <div>
                                <form action="" method="post">
                                  <input type="hidden" name="id_user" value="<?= $usersData[$i]['id_user'] ?>">
                                  <div class="flexmodal align-items-center">
                                    <label for="" class="display-subheading" style="min-width: 150px">Kode Perizinan</label>
                                    <div class="position-relative auth-pass-inputgroup input-custom-icon" style="width:100%">
                                      <input type="password" class="form-control text-fontdark bg-secondary" id="password-input-izin" name="kode" value="" style="border-color: #c9e7af" required />
                                      <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon" onclick="ikonizin()">
                                        <div id="eyeon-izin" style="display: none"><img src="../assets/icon/eye-outline.svg" alt="" /></div>
                                        <div id="eyeoff-izin" style="display: none"><img src="../assets/icon/eye-off-outline.svg" alt="" /></div>
                                        <div id="eye-izin"><img src="../assets/icon/eye-off-outline.svg" alt="" /></div>
                                      </button>
                                    </div>
                                  </div>
                                  <div class="modal-button">
                                    <button type="button" class="btn btn-red text-fontlight" style="padding: 6px 20px" data-bs-target="#modalverif<?= $usersData[$i]['id_user'] ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Kembali</button>
                                    <button type="submit" class="btn btn-fontdark text-fontlight" style="padding: 6px 20px" data-bs-toggle="modal" data-bs-dismiss="modal" name="submitKode">
                                      Verifikasi
                                    </button>
                                  </div>
                                </form>
                              </div>

                            </div>
                          </div>
                        </div>
                      </div>

                      <?php
                      //buat btn kode izin
                      if (isset($_POST['submitKode'])) {
                        $id_user = $_POST['id_user'];
                        if (loginAdmin($_SESSION['id_admin'], $_POST['kode']) != false) {
                          echo "<script type='text/javascript'>
                          $(document).ready(function(){
                          $('#modaledit$id_user').modal('show');
                          });
                          </script>";
                        } else {
                          echo "<script type='text/javascript'>
                          $(document).ready(function(){
                          $('#modalizin_ulang$id_user').modal('show');
                          });
                          </script>";
                        }
                      }
                      ?>

                      <!-- Kode Izin Modal Ulang-->
                      <div class="modal fade" id="modalizin_ulang<?= $usersData[$i]['id_user'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalizinLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                          <div class="modal-content text-fontdark">
                            <div class="modal-header" style="border-color: #c9e7af; padding: 17px 33px">
                              <h5 class="modal-title display-subheading fw-semibold" id="modalverifLabel">Perizinan Ubah Data Pengguna</h5>
                              <img src="../assets/icon/Close.png" alt="" data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer" />
                            </div>
                            <div class="modal-body justify-content-center" style="padding: 29px 33px">
                              <div>
                                <form action="" method="post">
                                  <input type="hidden" name="id_user" value="<?= $usersData[$i]['id_user'] ?>">
                                  <p class="text-red py-2 display-text1">Kode tidak sesuai, silakan coba kembali</p>
                                  <div class="flexmodal align-items-center">
                                    <label for="" class="display-subheading" style="min-width: 150px">Kode Perizinan</label>
                                    <div class="position-relative auth-pass-inputgroup input-custom-icon" style="width:100%">
                                      <input type="password" class="form-control text-fontdark bg-secondary" id="password-input-izinu" name="kode" value="" style="border-color: #c9e7af" required />
                                      <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon" onclick="ikonizinu()">
                                        <div id="eyeon-izinu" style="display: none"><img src="../assets/icon/eye-outline.svg" alt="" /></div>
                                        <div id="eyeoff-izinu" style="display: none"><img src="../assets/icon/eye-off-outline.svg" alt="" /></div>
                                        <div id="eye-izinu"><img src="../assets/icon/eye-off-outline.svg" alt="" /></div>
                                      </button>
                                    </div>
                                  </div>
                                  <div class="modal-button">
                                    <button type="button" class="btn btn-red text-fontlight" style="padding: 6px 20px" data-bs-target="#modalverif<?= $usersData[$i]['id_user'] ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Kembali</button>
                                    <button type="submit" class="btn btn-fontdark text-fontlight" style="padding: 6px 20px" data-bs-toggle="modal" data-bs-dismiss="modal" name="submitKode">
                                      Verifikasi
                                    </button>
                                  </div>
                                </form>
                              </div>

                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Edit User Modal -->
                      <div class="modal fade" id="modaledit<?= $usersData[$i]['id_user'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modaleditLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                          <div class="modal-content text-fontdark">
                            <div class="modal-header" style="border-color: #c9e7af; padding: 17px 33px">
                              <h5 class="modal-title display-subheading fw-semibold" id="modaleditLabel">Ubah Data Pengguna</h5>
                              <img src="../assets/icon/Close.png" alt="" data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer" />
                            </div>
                            <div class="modal-body justify-content-center" style="padding: 29px 33px">
                              <div>
                                <form action="" method="post">
                                  <input type="hidden" value="<?= $usersData[$i]['id_user'] ?>" name="id_user">
                                  <input type="hidden" value="<?= $usersData[$i]['email'] ?>" name="emailLama">
                                  <input type="hidden" value="<?= $usersData[$i]['telp'] ?>" name="telpLama">
                                  <div class="flexmodal align-items-center" style="padding-bottom: 15px">
                                    <label for="" class="display-subheading" style="min-width: 180px; margin-right: 20px">Nama</label>
                                    <input type="text" class="form-control text-fontdark bg-secondary" id="" name="nama" value="<?= $usersData[$i]['nama'] ?>" style="margin-right: 11px; border-color: #c9e7af" required />
                                  </div>
                                  <div class="flexmodal align-items-center" style="padding-bottom: 15px">
                                    <label for="" class="display-subheading" style="min-width: 180px; margin-right: 20px">Email</label>
                                    <input type="email" class="form-control text-fontdark bg-secondary" id="" name="email" value="<?= $usersData[$i]['email'] ?>" style="margin-right: 11px; border-color: #c9e7af" />
                                  </div>
                                  <div class="flexmodal align-items-center" style="padding-bottom: 15px">
                                    <label for="" class="display-subheading" style="min-width: 180px; margin-right: 20px">Nomor Telepon</label>
                                    <input type="text" class="form-control text-fontdark bg-secondary" id="" name="telp" value="<?= $usersData[$i]['telp'] ?>" style="margin-right: 11px; border-color: #c9e7af" />
                                  </div>
                                  <div class="flexmodal align-items-center" style="padding-bottom: 15px">
                                    <label for="" class="display-subheading" style="min-width: 180px; margin-right: 20px">Password Baru</label>
                                    <div class="position-relative auth-pass-inputgroup input-custom-icon" style="width:100%">
                                      <input type="password" class="form-control text-fontdark bg-secondary" id="password-input-edit" name="passBaru" value="" style="margin-right: 11px; border-color: #c9e7af" required />
                                      <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon" onclick="ikonedit()">
                                        <div id="eyeon-edit" style="display: none"><img src="../assets/icon/eye-outline.svg" alt="" /></div>
                                        <div id="eyeoff-edit" style="display: none"><img src="../assets/icon/eye-off-outline.svg" alt="" /></div>
                                        <div id="eye-edit"><img src="../assets/icon/eye-off-outline.svg" alt="" /></div>
                                      </button>
                                    </div>
                                  </div>
                                  <div class="flexmodal" style="padding-bottom: 15px">
                                    <label for="" class="display-subheading" style="min-width: 180px; margin-right: 20px">Alamat</label>
                                    <textarea rows="3" class="form-control text-fontdark bg-secondary" id="" name="alamat" value="<?= $usersData[$i]['alamat'] ?>" style="margin-right: 11px; border-color: #c9e7af"><?= $usersData[$i]['alamat'] ?></textarea>
                                  </div>
                                  <div class="flexmodal align-items-center" style="padding-bottom: 15px">
                                    <label for="" class="display-subheading" style="min-width: 180px; margin-right: 20px">Jenis Pelanggan</label>
                                    <select class="form-select text-fontdark bg-secondary w-drpdown" aria-label="" style="border-color: #c9e7af" name="jenis_pelanggan">
                                      <option style="display: none;" selected value="<?= $usersData[$i]['jenis_pelanggan'] ?>"><?= ucfirst($usersData[$i]['jenis_pelanggan']) ?></option>
                                      <option value="gratis">Gratis</option>
                                      <option value="berbayar">Berbayar</option>
                                    </select>
                                  </div>
                                  <div class="modal-button">
                                    <button type="button" class="btn btn-red text-fontlight" data-bs-dismiss="modal" style="padding: 6px 20px">Batal</button>
                                    <button type="submit" class="btn btn-fontdark text-fontlight" style="padding: 6px 20px" name="updateUser">Simpan</button>
                                  </div>
                                </form>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>

                      <!-- Delete User Modal -->
                      <?php
                      $id_user = $usersData[$i]['id_user']
                      ?>
                      <div class="modal fade" id="modalhapus<?= $id_user ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalhapusLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                          <div class="modal-content text-fontdark">
                            <div class="modal-header" style="border-color: #c9e7af; padding: 17px 33px">
                              <h5 class="modal-title display-subheading fw-semibold" id="modalhapusLabel">
                                Yakin menghapus data berikut? <br />Data yang dihapus <span class="text-red">tidak bisa dikembalikan</span> lagi
                              </h5>
                              <img src="../assets/icon/Close.png" alt="" data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer" />
                            </div>
                            <div class="modal-body justify-content-center" style="padding: 29px 33px">
                              <div>
                                <form action="" method="POST">
                                  <input type="hidden" id="" name="id_user" value="<?= $id_user ?>" />
                                  <div class="flexmodal align-items-center" style="padding-bottom: 15px">
                                    <label for="" class="display-subheading" style="min-width: 180px; margin-right: 20px">Nama</label>
                                    <input type="text" class="form-control text-fontdark" id="" name="" value="<?= $usersData[$i]['nama'] ?>" style="margin-right: 11px; border-color: #c9e7af" disabled />
                                  </div>
                                  <div class="flexmodal align-items-center" style="padding-bottom: 15px">
                                    <label for="" class="display-subheading" style="min-width: 180px; margin-right: 20px">Email</label>
                                    <input type="text" class="form-control text-fontdark" id="" name="" value="<?= $usersData[$i]['email'] ?>" style="margin-right: 11px; border-color: #c9e7af" disabled />
                                  </div>
                                  <div class="flexmodal align-items-center" style="padding-bottom: 15px">
                                    <label for="" class="display-subheading" style="min-width: 180px; margin-right: 20px">Nomor Telepon</label>
                                    <input type="text" class="form-control text-fontdark" id="" name="" value="<?= $usersData[$i]['telp'] ?>" style="margin-right: 11px; border-color: #c9e7af" disabled />
                                  </div>
                                  <div class="flexmodal" style="padding-bottom: 15px">
                                    <label for="" class="display-subheading" style="min-width: 180px; margin-right: 20px">Alamat</label>
                                    <textarea rows="3" class="form-control text-fontdark" id="" name="" value="<?= $usersData[$i]['alamat'] ?>" style="margin-right: 11px; border-color: #c9e7af" disabled><?= ucfirst($usersData[$i]['alamat']) ?></textarea>
                                  </div>
                                  <div class="flexmodal" style="padding-bottom: 15px">
                                    <label for="" class="display-subheading" style="min-width: 180px; margin-right: 20px">Jenis Pelanggan</label>
                                    <input type="text" class="form-control text-fontdark" id="" name="" value="<?= ucfirst($usersData[$i]['jenis_pelanggan']) ?>" style="margin-right: 11px; border-color: #c9e7af" disabled />
                                  </div>
                                  <div class="modal-button">
                                    <button type="button" class="btn btn-red text-fontlight" data-bs-dismiss="modal" style="padding: 6px 20px">Batal</button>
                                    <button type="submit" class="btn btn-fontdark text-fontlight" style="padding: 6px 20px" name="deleteUserByID">Hapus</button>
                                  </div>
                                </form>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>

                    </tr>
                  <?php
                  }
                  ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- container-fluid -->
      </div>
      <!-- End Page-content -->
    </div>
    <!-- end main content-->
  </div>
  <!-- END layout-wrapper -->

  <!-- javascript -->
  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/libs/metismenujs/metismenujs.min.js"></script>
  <script src="../assets/libs/simplebar/simplebar.min.js"></script>
  <script src="../assets/libs/eva-icons/eva.min.js"></script>
  <script src="../assets/js/dashboard.init.js"></script>
  <script src="../assets/js/app.js"></script>
  <!-- data tables -->
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
  <script src="../node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="../node_modules/datatables.net/js/dataTables.bootstrap5.min.js"></script>
  <script src="../script/table.js"></script>
  <!-- Sweet Alerts js -->
  <script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>
  <!-- Sweet alert init js-->
  <script src="../assets/js/sweet-alerts.init.js"></script>
  <!-- password script -->
  <script src="../script/password.js"></script>
  <!-- script loader -->
  <script src="../script/loader.js"></script>

</body>
</html>