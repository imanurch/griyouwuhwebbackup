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

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Peringkat | Griyo Uwuh</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta content="Lihat peringkat tertinggi berdasarkan total bobot sampah yang terkumpul di TPS Griyo Uwuh" name="description" />
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
                <li class="breadcrumb-item"><img src="../assets/icon/Award.png" alt="" class="icon-bc" /></li>
                <li class="breadcrumb-item" aria-current="page">Peringkat</li>
              </ol>
            </nav>
          </div>
          <!-- end page title -->
        </div>
      </div>
    </header>

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
                <i class="bx"><img src="../assets/icon/awardactive.png" alt="" class="icon" /></i>
                <span class="menu-item" data-key="peringkat">Peringkat</span>
              </a>
            </li>

            <li class="position-absolute bottom-0 end-0">
              <a id="sa-warning" style="cursor: pointer;">
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
                    <i class="bx"><img src="../assets/icon/awardactive.png" alt="" class="icon" /></i>
                    <span class="menu-item" data-key="peringkat">Peringkat</span>
                  </a>
                </li>
                <li class="position-absolute bottom-0 end-0">
                  <a id="sa-warning" style="cursor: pointer;">
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
          <!-- DATA TABLE -->
          <div>
            <div class="card px-0" style="padding: 25px">
              <div>
                <table id="dtable-rank" class="nowrap table" style="width: 100%; font-size: 16px; border-color: #e9ffd6">
                  <thead>
                    <tr>
                      <th class="dt-head-center" style="border-top-left-radius: 7px">Peringkat</th>
                      <th class="dt-head-center">Nama</th>
                      <th class="dt-head-center">Email</th>
                      <th class="dt-head-center">Nomor Telepon</th>
                      <th class="dt-head-center" style="min-width:250px">Alamat</th>
                      <th class="dt-head-center" style="border-top-right-radius: 7px">Total Bobot (Kg)</th>
                    </tr>
                  </thead>
                  <tbody class="responsif-tb">
                    <?php
                    $rankData = getRankUsers();
                    for ($i = 0; $i < sizeof($rankData); $i++) {
                    ?>
                      <tr>
                        <td class="dt-center"><?= $i + 1 ?></td>
                        <td><?= $rankData[$i]['nama'] ?></td>
                        <td><?= $rankData[$i]['email'] ?></td>
                        <td class="dt-center"><?= $rankData[$i]['telp'] ?></td>
                        <td style="white-space: wrap; overflow: hidden;"><?= $rankData[$i]['alamat'] ?></td>
                        <td class="dt-center"><?= str_replace("@", ".", str_replace(".", ",", str_replace(",", "@", $rankData[$i]['bobot_kg']))) ?></td>
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