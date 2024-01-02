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


//update data tracking
if (isset($_POST['updateTracking'])) {
  $tahap1 = updateTrackingAnorganik("terkumpul di tps", $_POST['ton1'], $_POST['kg1'], $_POST['ons1'], $_POST['gram1']);
  if ($tahap1) {
    $tahap2 = updateTrackingAnorganik("proses pemilahan", $_POST['ton2'], $_POST['kg2'], $_POST['ons2'], $_POST['gram2']);
    if ($tahap2) {
      $tahap3 = updateTrackingAnorganik("produk terjual", $_POST['ton3'], $_POST['kg3'], $_POST['ons3'], $_POST['gram3']);
      if ($tahap3) {
        $tahap4 = updateTrackingAnorganik("disalurkan ke tpa", $_POST['ton4'], $_POST['kg4'], $_POST['ons4'], $_POST['gram4']);
        if ($tahap4) {
          echo "<script>alert('Tracking Sampah Anorganik berhasil diperbaharui!')</script>";
          header('refresh:0; url=anorganik');
        } else {
          echo "<script>alert('Tracking Sampah Anorganik Tahap 'Disalurkan ke TPA' gagal. Mohon ulangi.')</script>";
          header('refresh:0; url=anorganik');
        }
      } else {
        echo "<script>alert('Tracking Sampah Anorganik Tahap 'Olahan terjual' gagal. Mohon ulangi.')</script>";
        header('refresh:0; url=anorganik');
      }
    } else {
      echo "<script>alert('Tracking Sampah Anorganik Tahap 'Proses Pemilahan' gagal. Mohon ulangi.')</script>";
      header('refresh:0; url=anorganik');
    }
  } else {
    echo "<script>alert('Tracking Sampah Anorganik Tahap 'Terkumpul di TPS' gagal. Mohon ulangi.')</script>";
    header('refresh:0; url=anorganik');
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Tracking Anorganik | Griyo Uwuh</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta content="Tracking pengelolaan sampah anorganik di TPS Griyo Uwuh" name="description" />
  <link rel="icon" type="image/x-icon" href="../assets/icon/Logo.png">
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../scss/custom.css" />
  <link rel="stylesheet" href="../assets/css/app.min.css" />
  <link rel="stylesheet" href="../assets/css/icons.min.css" />

  <!-- css layout -->
  <link rel="stylesheet" href="../style/layout.css" />
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
                <li class="breadcrumb-item"><img src="../assets/icon/analytics.png" alt="" class="icon-bc" /></li>
                <li class="breadcrumb-item" aria-current="page">Kelola Tracking</li>
                <li class="breadcrumb-item" aria-current="page">Sampah Anorganik</li>
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
                <i class="bx"><img src="../assets/icon/Trash.png" alt="" class="icon" /></i>
                <span class="menu-item" data-key="setoran">Kelola Setoran</span>
              </a>
            </li>

            <li>
              <a href="javascript: void(0);">
                <i class="bx"><img src="../assets/icon/analyticsactive.png" alt="" class="icon" /></i>
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
                    <i class="bx"><img src="../assets/icon/Trash.png" alt="" class="icon" /></i>
                    <span class="menu-item" data-key="setoran">Kelola Setoran</span>
                  </a>
                </li>

                <li>
                  <a href="javascript: void(0);">
                    <i class="bx"><img src="../assets/icon/analyticsactive.png" alt="" class="icon" /></i>
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
        <div class="container-fluid container-tracking">
          <!-- TRACKING -->
          <!-- MODALS -->
          <div>
            <!-- Input Bobot Modal Button -->
            <button class="mb-0 btn-track" data-bs-toggle="modal" data-bs-target="#modalinput">Tambah Bobot Sampah Anorganik</button>

            <!-- Input Bobot Modal -->
            <div class="modal fade" id="modalinput" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalinputLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content text-fontdark">
                  <div class="modal-header" style="border-color: #c9e7af; padding: 17px 33px">
                    <h5 class="modal-title display-subheading fw-semibold" id="modalinputLabel">Tambah Bobot Sampah Anorganik</h5>
                    <img src="../assets/icon/Close.png" alt="" data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer" />
                  </div>
                  <div class="modal-body justify-content-center" style="padding: 29px 33px">
                    <div>
                      <form action="" method="post">
                        <div class="align-items-center" style="padding-bottom: 25px">
                          <label for="" class="display-subheading" style="margin-right: 20px">Terkumpul di TPS</label>
                          <div class="flexmodal justify-content-around pt-2">
                            <div class="flexmodal1">
                              <div class="d-flex align-items-center">
                                <input type="text" class="form-control text-fontdark text-center bg-secondary w-input" id="" name="ton1" value="0" style="margin-right: 10px; border-color: #c9e7af" />
                                <label for="" class="display-textfield satuan" style="margin-right: 10px">Ton</label>
                              </div>
                              <div class="d-flex align-items-center">
                                <input type="text" class="form-control text-fontdark text-center bg-secondary w-input" id="" name="kg1" value="0" style="margin-right: 10px; border-color: #c9e7af" />
                                <label for="" class="display-textfield satuan" style="margin-right: 10px">Kg</label>
                              </div>
                            </div>
                            <div class="flexmodal1">
                              <div class="d-flex align-items-center">
                                <input type="text" class="form-control text-fontdark text-center bg-secondary w-input" id="" name="ons1" value="0" style="margin-right: 10px; border-color: #c9e7af" />
                                <label for="" class="display-textfield satuan" style="margin-right: 10px">Ons</label>
                              </div>
                              <div class="d-flex align-items-center">
                                <input type="text" class="form-control text-fontdark text-center bg-secondary w-input" id="" name="gram1" value="0" style="margin-right: 10px; border-color: #c9e7af" />
                                <label for="" class="display-textfield satuan" style="margin-right: 10px">G</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="align-items-center" style="padding-bottom: 25px">
                          <label for="" class="display-subheading" style="margin-right: 20px">Proses Pemilahan</label>
                          <div class="flexmodal justify-content-around pt-2">
                            <div class="flexmodal1">
                              <div class="d-flex align-items-center">
                                <input type="text" class="form-control text-fontdark text-center bg-secondary w-input" id="" name="ton2" value="0" style="margin-right: 10px; border-color: #c9e7af" />
                                <label for="" class="display-textfield satuan" style="margin-right: 10px">Ton</label>
                              </div>
                              <div class="d-flex align-items-center">
                                <input type="text" class="form-control text-fontdark text-center bg-secondary w-input" id="" name="kg2" value="0" style="margin-right: 10px; border-color: #c9e7af" />
                                <label for="" class="display-textfield satuan" style="margin-right: 10px">Kg</label>
                              </div>
                            </div>
                            <div class="flexmodal1">
                              <div class="d-flex align-items-center">
                                <input type="text" class="form-control text-fontdark text-center bg-secondary w-input" id="" name="ons2" value="0" style="margin-right: 10px; border-color: #c9e7af" />
                                <label for="" class="display-textfield satuan" style="margin-right: 10px">Ons</label>
                              </div>
                              <div class="d-flex align-items-center">
                                <input type="text" class="form-control text-fontdark text-center bg-secondary w-input" id="" name="gram2" value="0" style="margin-right: 10px; border-color: #c9e7af" />
                                <label for="" class="display-textfield satuan" style="margin-right: 10px">G</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="align-items-center" style="padding-bottom: 25px">
                          <label for="" class="display-subheading" style="margin-right: 20px">Olahan Terjual</label>
                          <div class="flexmodal justify-content-around pt-2">
                            <div class="flexmodal1">
                              <div class="d-flex align-items-center">
                                <input type="text" class="form-control text-fontdark text-center bg-secondary w-input" id="" name="ton3" value="0" style="margin-right: 10px; border-color: #c9e7af" />
                                <label for="" class="display-textfield satuan" style="margin-right: 10px">Ton</label>
                              </div>
                              <div class="d-flex align-items-center">
                                <input type="text" class="form-control text-fontdark text-center bg-secondary w-input" id="" name="kg3" value="0" style="margin-right: 10px; border-color: #c9e7af" />
                                <label for="" class="display-textfield satuan" style="margin-right: 10px">Kg</label>
                              </div>
                            </div>
                            <div class="flexmodal1">
                              <div class="d-flex align-items-center">
                                <input type="text" class="form-control text-fontdark text-center bg-secondary w-input" id="" name="ons3" value="0" style="margin-right: 10px; border-color: #c9e7af" />
                                <label for="" class="display-textfield satuan" style="margin-right: 10px">Ons</label>
                              </div>
                              <div class="d-flex align-items-center">
                                <input type="text" class="form-control text-fontdark text-center bg-secondary w-input" id="" name="gram3" value="0" style="margin-right: 10px; border-color: #c9e7af" />
                                <label for="" class="display-textfield satuan" style="margin-right: 10px">G</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="align-items-center" style="padding-bottom: 0px">
                          <label for="" class="display-subheading" style="margin-right: 20px">Disalurkan ke TPA</label>
                          <div class="flexmodal justify-content-around pt-2">
                            <div class="flexmodal1">
                              <div class="d-flex align-items-center">
                                <input type="text" class="form-control text-fontdark text-center bg-secondary w-input" id="" name="ton4" value="0" style="margin-right: 10px; border-color: #c9e7af" />
                                <label for="" class="display-textfield satuan" style="margin-right: 10px">Ton</label>
                              </div>
                              <div class="d-flex align-items-center">
                                <input type="text" class="form-control text-fontdark text-center bg-secondary w-input" id="" name="kg4" value="0" style="margin-right: 10px; border-color: #c9e7af" />
                                <label for="" class="display-textfield satuan" style="margin-right: 10px">Kg</label>
                              </div>
                            </div>
                            <div class="flexmodal1">
                              <div class="d-flex align-items-center">
                                <input type="text" class="form-control text-fontdark text-center bg-secondary w-input" id="" name="ons4" value="0" style="margin-right: 10px; border-color: #c9e7af" />
                                <label for="" class="display-textfield satuan" style="margin-right: 10px">Ons</label>
                              </div>
                              <div class="d-flex align-items-center">
                                <input type="text" class="form-control text-fontdark text-center bg-secondary w-input" id="" name="gram4" value="0" style="margin-right: 10px; border-color: #c9e7af" />
                                <label for="" class="display-textfield satuan" style="margin-right: 10px">G</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-button">
                          <button type="button" class="btn btn-red text-fontlight" data-bs-dismiss="modal" style="padding: 6px 20px">Batal</button>
                          <button type="submit" class="btn btn-fontdark text-fontlight" style="padding: 6px 20px" name="updateTracking">Simpan</button>
                        </div>
                      </form>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>

          <div class="y-gap-layout">
            <div class="card card-4" style="margin-bottom: 14px">
              <div class="card-body bcard-4">
                <div>
                  <div class="order-track">
                    <div class="">
                      <img src="../assets/pic/tps.png" alt="" class="imgr" />
                    </div>

                    <div class="gap-track">
                      <p class="mb-0 fw-bolder fontr">Terkumpul di TPS</p>
                      <div class="flexr-2 align-items-center">
                        <div class="flexr">
                          <div class="d-flex align-items-center">
                            <p class="mb-0 fontr-2 font-ton fw-bolder track-num"><?= $trackingData[0]['ton'] ?></p>
                            <p class="mb-0 fontr-3 fw-medium track-word">Ton</p>
                          </div>
                          <div class="d-flex align-items-center">
                            <p class="mb-0 fontr-2 font-kg fw-bolder track-num"><?= $trackingData[0]['kg'] ?></p>
                            <p class="mb-0 fontr-3 fw-medium track-word">Kilogram</p>
                          </div>
                        </div>
                        <div class="flexr">
                          <div class="d-flex align-items-center">
                            <p class="mb-0 fontr-2 font-ons fw-bolder track-num"><?= $trackingData[0]['ons'] ?></p>
                            <p class="mb-0 fontr-3 fw-medium track-word">Ons</p>
                          </div>
                          <div class="d-flex align-items-center">
                            <p class="mb-0 fontr-2 font-gr fw-bolder track-num"><?= $trackingData[0]['gram'] ?></p>
                            <p class="mb-0 fontr-3 fw-medium track-word">Gram</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card card-4" style="margin-bottom: 14px">
              <div class="card-body bcard-4">
                <div>
                  <div class="order-track">
                    <div class="">
                      <img src="../assets/pic/pilah.png" alt="" class="imgr" />
                    </div>

                    <div class="gap-track">
                      <p class="mb-0 fw-bolder fontr">Proses Pemilahan</p>
                      <div class="flexr-2 align-items-center">
                        <div class="flexr">
                          <div class="d-flex align-items-center">
                            <p class="mb-0 fontr-2 font-ton fw-bolder track-num"><?= $trackingData[1]['ton'] ?></p>
                            <p class="mb-0 fontr-3 fw-medium track-word">Ton</p>
                          </div>
                          <div class="d-flex align-items-center">
                            <p class="mb-0 fontr-2 font-kg fw-bolder track-num"><?= $trackingData[1]['kg'] ?></p>
                            <p class="mb-0 fontr-3 fw-medium track-word">Kilogram</p>
                          </div>
                        </div>
                        <div class="flexr">
                          <div class="d-flex align-items-center">
                            <p class="mb-0 fontr-2 font-ons fw-bolder track-num"><?= $trackingData[1]['ons'] ?></p>
                            <p class="mb-0 fontr-3 fw-medium track-word">Ons</p>
                          </div>
                          <div class="d-flex align-items-center">
                            <p class="mb-0 fontr-2 font-gr fw-bolder track-num"><?= $trackingData[1]['gram'] ?></p>
                            <p class="mb-0 fontr-3 fw-medium track-word">Gram</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card card-4" style="margin-bottom: 14px">
              <div class="card-body bcard-4">
                <div>
                  <div class="order-track">
                    <div class="">
                      <img src="../assets/pic/jual.png" alt="" class="imgr" />
                    </div>

                    <div class="gap-track">
                      <p class="mb-0 fw-bolder fontr">Olahan Terjual</p>
                      <div class="flexr-2 align-items-center">
                        <div class="flexr">
                          <div class="d-flex align-items-center">
                            <p class="mb-0 fontr-2 font-ton fw-bolder track-num"><?= $trackingData[2]['ton'] ?></p>
                            <p class="mb-0 fontr-3 fw-medium track-word">Ton</p>
                          </div>
                          <div class="d-flex align-items-center">
                            <p class="mb-0 fontr-2 font-kg fw-bolder track-num"><?= $trackingData[2]['kg'] ?></p>
                            <p class="mb-0 fontr-3 fw-medium track-word">Kilogram</p>
                          </div>
                        </div>
                        <div class="flexr">
                          <div class="d-flex align-items-center">
                            <p class="mb-0 fontr-2 font-ons fw-bolder track-num"><?= $trackingData[2]['ons'] ?></p>
                            <p class="mb-0 fontr-3 fw-medium track-word">Ons</p>
                          </div>
                          <div class="d-flex align-items-center">
                            <p class="mb-0 fontr-2 font-gr fw-bolder track-num"><?= $trackingData[2]['gram'] ?></p>
                            <p class="mb-0 fontr-3 fw-medium track-word">Gram</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card card-4" style="margin-bottom: 14px">
              <div class="card-body bcard-4">
                <div>
                  <div class="order-track">
                    <div class="">
                      <img src="../assets/pic/tpa.png" alt="" class="imgr" />
                    </div>

                    <div class="gap-track">
                      <p class="mb-0 fw-bolder fontr">Disalurkan ke TPA</p>
                      <div class="flexr-2 align-items-center">
                        <div class="flexr">
                          <div class="d-flex align-items-center">
                            <p class="mb-0 fontr-2 font-ton fw-bolder track-num"><?= $trackingData[3]['ton'] ?></p>
                            <p class="mb-0 fontr-3 fw-medium track-word">Ton</p>
                          </div>
                          <div class="d-flex align-items-center">
                            <p class="mb-0 fontr-2 font-kg fw-bolder track-num"><?= $trackingData[3]['kg'] ?></p>
                            <p class="mb-0 fontr-3 fw-medium track-word">Kilogram</p>
                          </div>
                        </div>
                        <div class="flexr">
                          <div class="d-flex align-items-center">
                            <p class="mb-0 fontr-2 font-ons fw-bolder track-num"><?= $trackingData[3]['ons'] ?></p>
                            <p class="mb-0 fontr-3 fw-medium track-word">Ons</p>
                          </div>
                          <div class="d-flex align-items-center">
                            <p class="mb-0 fontr-2 font-gr fw-bolder track-num"><?= $trackingData[3]['gram'] ?></p>
                            <p class="mb-0 fontr-3 fw-medium track-word">Gram</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- end row -->
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
  <!-- Sweet Alerts js -->
  <script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>
  <!-- Sweet alert init js-->
  <script src="../assets/js/sweet-alerts.init.js"></script>
  <!-- script loader -->
  <script src="../script/loader.js"></script>

</body>
</html>