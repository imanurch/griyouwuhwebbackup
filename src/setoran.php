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
  echo "<script>alert('Sesi anda habis. Silakan login ulang!')</script>";
  header('refresh:0; url=logout');
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

//get data tracking 
$trackingData = getTrackingAnorganik();

//update data setoran pending
if (isset($_POST['submitSetoranPending'])) {
  $update = updateSetoran($_POST['id_setoran'], $_POST['jenis_sampah'], $_POST['ton'], $_POST['kg'], $_POST['ons'], $_POST['gram']);
  if ($update) {
    echo "<script>alert('Setoran berhasil diverifikasi!')</script>";
    header('refresh:0; url=setoran');
  } else {
    echo "<script>alert('Setoran gagal diverifikasi. Mohon ulangi.')</script>";
    header('refresh:0; url=setoran');
  }
}

//update data setoran done
if (isset($_POST['submitSetoranDone'])) {
  $update = updateSetoranDone($_POST['id_setoran'], $_POST['jenis_sampah'], $_POST['ton'], $_POST['kg'], $_POST['ons'], $_POST['gram'], $_POST['bobotLama']);
  if ($update) {
    echo "<script>alert('Data Setoran berhasil diperbaharui!')</script>";
    header('refresh:0; url=setoran');
  } else {
    echo "<script>alert('Data setoran gagal diperbaharui. Mohon ulangi.')</script>";
    header('refresh:0; url=setoran');
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Kelola Setoran | Griyo Uwuh</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta content="Lihat setoran dan verifikasi bobot pelanggan Griyo Uwuh" name="description" />
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
            <a href="beranda.php" class="logo">
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
                <li class="breadcrumb-item"><img src="../assets/icon/Trash.png" alt="" class="icon-bc" /></li>
                <li class="breadcrumb-item" aria-current="page">Kelola Setoran</li>
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
                <i class="bx"><img src="../assets/icon/User.png" alt="" class="icon" /></i>
                <span class="menu-item" data-key="pengguna">Kelola Pengguna</span>
              </a>
            </li>

            <li>
              <a href="setoran">
                <i class="bx"><img src="../assets/icon/trash-2active.png" alt="" class="icon" /></i>
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
                    <i class="bx"><img src="../assets/icon/User.png" alt="" class="icon" /></i>
                    <span class="menu-item" data-key="pengguna">Kelola Pengguna</span>
                  </a>
                </li>
                <li>
                  <a href="setoran">
                    <i class="bx"><img src="../assets/icon/trash-2active.png" alt="" class="icon" /></i>
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
          <div class="flexr-setor">
            <div class="card card-setor">
              <div class="card-body bcard-setor">
                <div>
                  <div class="d-flex align-items-center">
                    <div class="">
                      <p class="mb-0 fw-bold setor-num"><?= getTotalSetoranPending() ?></p>
                    </div>

                    <div class="ms-3">
                      <p class="mb-0 setor-word">Belum Verifikasi</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card card-setor">
              <div class="card-body bcard-setor">
                <div>
                  <div class="d-flex align-items-center">
                    <div class="">
                      <p class="mb-0 fw-bold setor-num"><?= getTotalSetoranDone() ?></p>
                    </div>

                    <div class="ms-3">
                      <p class="mb-0 setor-word">Sudah Verifikasi</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- DATA TABLE -->
          <!-- data setoran pending -->
          <div class="y-gap-layout">
            <div class="card px-0" style="padding: 25px">
              <div>
                <table id="dtablenotverif" class="nowrap table" style="width: 100%; font-size: 16px; border-color: #e9ffd6">
                  <div class="scroll">
                    <thead>
                      <tr>
                        <th class="dt-head-center" style="border-top-left-radius: 7px">ID Setoran</th>
                        <th class="dt-head-center">Nama</th>
                        <th class="dt-head-center">Total Bobot (Kg)</th>
                        <th class="dt-head-center" style="border-top-right-radius: 7px">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $setoranPending = getSetoranPending();
                      for ($i = 0; $i < sizeof($setoranPending); $i++) {
                      ?>
                        <tr>
                          <td class="dt-center"><?= $setoranPending[$i]['id_setoran'] ?></td>
                          <td><?= $setoranPending[$i]['nama'] ?></td>
                          <td class="dt-center"><?= str_replace("@", ".", str_replace(".", ",", str_replace(",", "@", $setoranPending[$i]['bobot']))) ?></td>
                          <td class="dt-center">
                            <a href="#modalnotverifbobot<?= $setoranPending[$i]['id_setoran'] ?>" data-bs-toggle="modal" data-bs-target="#modalnotverifbobot<?= $setoranPending[$i]['id_setoran'] ?>"><img src="../assets/icon/Edit.png" alt="" style="cursor: pointer; padding-right: 3px" class="icon-btn" /></a>
                          </td>

                          <!-- Not Verif Bobot Modal -->
                          <?php $setoranPendingUser = getSetoranPendingUser($setoranPending[$i]['id_setoran']) ?>
                          <div class="modal fade" id="modalnotverifbobot<?= $setoranPendingUser['id_setoran'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalnotverifbobotLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                              <div class="modal-content text-fontdark">
                                <div class="modal-header" style="border-color: #c9e7af; padding: 17px 33px">
                                  <h5 class="modal-title display-subheading fw-semibold" id="modalverifbobotLabel">Verifikasi Bobot Pelanggan</h5>
                                  <img src="../assets/icon/Close.png" alt="" data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer" />
                                </div>
                                <div class="modal-body justify-content-center" style="padding: 29px 33px">
                                  <div>
                                    <form action="" method="POST">
                                      <div class="flexmodal align-items-center" style="padding-bottom: 15px">
                                        <label for="" class="display-subheading" style="min-width: 170px; margin-right: 20px">ID Setoran</label>
                                        <input type="text" class="form-control text-fontdark" id="" name="id_setoran" value="<?= $setoranPendingUser['id_setoran'] ?>" style="margin-right: 11px" disabled />
                                        <input type="hidden" class="form-control text-fontdark" id="" name="id_setoran" value="<?= $setoranPendingUser['id_setoran'] ?>" style="margin-right: 11px" />
                                      </div>
                                      <div class="flexmodal align-items-center" style="padding-bottom: 15px">
                                        <label for="" class="display-subheading" style="min-width: 170px; margin-right: 20px">Nama Pelanggan</label>
                                        <input type="text" class="form-control text-fontdark" id="" name="nama" value="<?= $setoranPendingUser['nama'] ?>" style="margin-right: 11px" disabled />
                                        <input type="hidden" class="form-control text-fontdark" id="" name="nama" value="<?= $setoranPendingUser['nama'] ?>" style="margin-right: 11px" />
                                      </div>
                                      <div class="flexmodal align-items-center" style="padding-bottom: 15px">
                                        <label for="" class="display-subheading margin-label">Jenis Setoran</label>
                                        <select class="form-select text-fontdark bg-secondary w-drpdown" aria-label="" style="border-color: #c9e7af" name="jenis_sampah">
                                          <option style="display: none;" selected value="<?= $setoranPendingUser['jenis_sampah'] ?>"><?= ucfirst($setoranPendingUser['jenis_sampah']) ?></option>
                                          <option value="organik">Organik</option>
                                          <option value="anorganik">Anorganik</option>
                                        </select>
                                      </div>
                                      <div class="align-items-center" style="padding-bottom: 0px">
                                        <label for="" class="display-subheading" style="margin-right: 20px">Total Bobot Setoran</label>
                                        <div class="flexmodal align-items-end justify-content-around pt-2">
                                          <div class="flexmodal1">
                                            <div class="d-flex align-items-center">
                                              <input type="text" class="form-control text-fontdark text-center bg-secondary w-input" id="" name="ton" value="<?= $setoranPendingUser['ton'] ?>" style="margin-right: 10px; border-color: #c9e7af" />
                                              <label for="" class="display-textfield satuan" style="margin-right: 10px">Ton</label>
                                            </div>
                                            <div class="d-flex align-items-center">
                                              <input type="text" class="form-control text-fontdark text-center bg-secondary w-input" id="" name="kg" value="<?= $setoranPendingUser['kg'] ?>" style="margin-right: 10px; border-color: #c9e7af" />
                                              <label for="" class="display-textfield satuan" style="margin-right: 10px">Kg</label>
                                            </div>
                                          </div>
                                          <div class="flexmodal1">
                                            <div class="d-flex align-items-center">
                                              <input type="text" class="form-control text-fontdark text-center bg-secondary w-input" id="" name="ons" value="<?= $setoranPendingUser['ons'] ?>" style="margin-right: 10px; border-color: #c9e7af" />
                                              <label for="" class="display-textfield satuan" style="margin-right: 10px">Ons</label>
                                            </div>
                                            <div class="d-flex align-items-center">
                                              <input type="text" class="form-control text-fontdark text-center bg-secondary w-input" id="" name="gram" value="<?= $setoranPendingUser['gram'] ?>" style="margin-right: 10px; border-color: #c9e7af" />
                                              <label for="" class="display-textfield satuan" style="margin-right: 10px">G</label>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="modal-button">
                                        <button type="button" class="btn btn-red text-fontlight" data-bs-dismiss="modal" style="padding: 6px 20px">Batal</button>
                                        <button type="submit" class="btn btn-fontdark text-fontlight" style="padding: 6px 20px" name="submitSetoranPending">Simpan</button>
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
                  </div>
                </table>

              </div>
            </div>
          </div>

          <!-- data setoran done -->
          <div class="y-gap-layout">
            <div class="card px-0" style="padding: 25px">
              <div>
                <table id="dtableverif" class="nowrap table" style="width: 100%; font-size: 16px; border-color: #e9ffd6">
                  <thead>
                    <tr>
                      <th class="dt-head-center" style="border-top-left-radius: 7px">ID Setoran</th>
                      <th class="dt-head-center">Nama</th>
                      <th class="dt-head-center">Total Bobot (Kg)</th>
                      <th class="dt-head-center" style="border-top-right-radius: 7px">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $setoranDonde = getSetoranDone();
                    for ($i = 0; $i < sizeof($setoranDonde); $i++) {
                    ?>
                      <tr>
                        <td class="dt-center"><?= $setoranDonde[$i]['id_setoran'] ?></td>
                        <td><?= $setoranDonde[$i]['nama'] ?></td>
                        <td class="dt-center"><?= str_replace("@", ".", str_replace(".", ",", str_replace(",", "@", $setoranDonde[$i]['bobot']))) ?></td>
                        <td class="dt-center">
                          <img src="../assets/icon/Edit.png" alt="" data-bs-toggle="modal" data-bs-target="#modalverifbobot<?= $setoranDonde[$i]['id_setoran'] ?>" style="cursor: pointer; padding-right: 3px" class="icon-btn" />
                        </td>
                        <!-- Verif Bobot Modal -->
                        <?php $setoranDoneUser = getSetoranDoneUser($setoranDonde[$i]['id_setoran']) ?>
                        <div class="modal fade" id="modalverifbobot<?= $setoranDoneUser['id_setoran'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalverifbobotLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                            <div class="modal-content text-fontdark">
                              <div class="modal-header" style="border-color: #c9e7af; padding: 17px 33px">
                                <h5 class="modal-title display-subheading fw-semibold" id="modalverifbobotLabel">Verifikasi Bobot Pelanggan</h5>
                                <img src="../assets/icon/Close.png" alt="" data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer" />
                              </div>
                              <div class="modal-body justify-content-center" style="padding: 29px 33px">
                                <div>
                                  <form action="" method="POST">
                                    <input type="hidden" name="bobotLama" value="<?= $setoranDonde[$i]['bobot'] ?>">
                                    <div class="flexmodal align-items-center" style="padding-bottom: 15px">
                                      <label for="" class="display-subheading" style="min-width: 170px; margin-right: 20px">ID Setoran</label>
                                      <input type="text" class="form-control text-fontdark" id="" name="id_setoran" value="<?= $setoranDoneUser['id_setoran'] ?>" style="margin-right: 11px" disabled />
                                      <input type="hidden" name="id_setoran" value="<?= $setoranDoneUser['id_setoran'] ?>" />
                                    </div>
                                    <div class="flexmodal align-items-center" style="padding-bottom: 15px">
                                      <label for="" class="display-subheading" style="min-width: 170px; margin-right: 20px">Nama Pelanggan</label>
                                      <input type="text" class="form-control text-fontdark" id="" name="nama" value="<?= $setoranDoneUser['nama'] ?>" style="margin-right: 11px" disabled />
                                    </div>
                                    <div class="flexmodal align-items-center" style="padding-bottom: 15px">
                                      <label for="" class="display-subheading margin-label">Jenis Setoran</label>
                                      <select class="form-select text-fontdark bg-secondary w-drpdown" aria-label="" style="border-color: #c9e7af" name="jenis_sampah">
                                        <option style="display: none;" selected value="<?= $setoranDoneUser['jenis_sampah'] ?>"><?= ucfirst($setoranDoneUser['jenis_sampah']) ?></option>
                                        <option value="organik">Organik</option>
                                        <option value="anorganik">Anorganik</option>
                                      </select>
                                    </div>
                                    <div class="align-items-center" style="padding-bottom: 0px">
                                      <label for="" class="display-subheading" style="margin-right: 20px">Total Bobot Setoran</label>
                                      <div class="flexmodal align-items-end justify-content-around pt-2">
                                        <div class="flexmodal1">
                                          <div class="d-flex align-items-center">
                                            <input type="text" class="form-control text-fontdark text-center bg-secondary w-input w-input" id="" name="ton" value="<?= $setoranDoneUser['ton'] ?>" style="margin-right: 10px; border-color: #c9e7af" />
                                            <label for="" class="display-textfield satuan" style="margin-right: 10px">Ton</label>
                                          </div>
                                          <div class="d-flex align-items-center">
                                            <input type="text" class="form-control text-fontdark text-center bg-secondary w-input" id="" name="kg" value="<?= $setoranDoneUser['kg'] ?>" style="margin-right: 10px; border-color: #c9e7af" />
                                            <label for="" class="display-textfield satuan" style="margin-right: 10px">Kg</label>
                                          </div>
                                        </div>
                                        <div class="flexmodal1">
                                          <div class="d-flex align-items-center">
                                            <input type="text" class="form-control text-fontdark text-center bg-secondary w-input" id="" name="ons" value="<?= $setoranDoneUser['ons'] ?>" style="margin-right: 10px; border-color: #c9e7af" />
                                            <label for="" class="display-textfield satuan" style="margin-right: 10px">Ons</label>
                                          </div>
                                          <div class="d-flex align-items-center">
                                            <input type="text" class="form-control text-fontdark text-center bg-secondary w-input" id="" name="gram" value="<?= $setoranDoneUser['gram'] ?>" style="margin-right: 10px; border-color: #c9e7af" />
                                            <label for="" class="display-textfield satuan" style="margin-right: 10px">G</label>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="modal-button">
                                      <button type="button" class="btn btn-red text-fontlight" data-bs-dismiss="modal" style="padding: 6px 20px">Batal</button>
                                      <button type="submit" class="btn btn-fontdark text-fontlight" style="padding: 6px 20px" name="submitSetoranDone">Simpan</button>
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
  <!-- script loader -->
  <script src="../script/loader.js"></script>

</body>
</html>