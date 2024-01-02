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

<!-- GET RIWAYAT ORGANIK DAN ANORGANIK-->
<?php
$currentYear = date("Y");
if ($_GET['year'] != null) {
  $currentYear = $_GET['year'];
} else {
  $_GET['year'] = date("Y");
}

// GET RIWAYAT ORGANIK
$riwayatOrganik = getRiwayatOrganikBulan($currentYear);

$dataRiwayatOrganikBulan = array(
  'Januari' => 0,
  'Februari' => 0,
  'Maret' => 0,
  'April' => 0,
  'Mei' => 0,
  'Juni' => 0,
  'Juli' => 0,
  'Agustus' => 0,
  'September' => 0,
  'Oktober' => 0,
  'November' => 0,
  'Desember' => 0,
);
for ($i = 0; $i < sizeof($riwayatOrganik); $i++) {
  $bobotTotal = 0;
  $bobotTon = $riwayatOrganik[$i]['ton'];
  $bobotKG = $riwayatOrganik[$i]['kg'];
  $bobotOns = $riwayatOrganik[$i]['ons'];
  $bobotGram = $riwayatOrganik[$i]['gram'];

  $bobotTotal += $bobotKG;
  if ($bobotTon > 0) {
    $bobotTotal += $bobotTon * 1000;
  }
  if ($bobotOns > 0) {
    $bobotTotal += $bobotOns / 10;
  }
  if ($bobotGram > 0) {
    $bobotTotal += $bobotGram / 1000;
  }

  $dataRiwayatOrganikBulan[$riwayatOrganik[$i]['bulan']] = $bobotTotal;
}

// GET RIWAYAT ANORGANIK
$riwayatAnorganik = getRiwayatAnorganikBulan($currentYear);

$dataRiwayatAnorganikBulan = array(
  'Januari' => 0,
  'Februari' => 0,
  'Maret' => 0,
  'April' => 0,
  'Mei' => 0,
  'Juni' => 0,
  'Juli' => 0,
  'Agustus' => 0,
  'September' => 0,
  'Oktober' => 0,
  'November' => 0,
  'Desember' => 0,
);
for ($i = 0; $i < sizeof($riwayatAnorganik); $i++) {
  $bobotTotal = 0;
  $bobotTon = $riwayatAnorganik[$i]['ton'];
  $bobotKG = $riwayatAnorganik[$i]['kg'];
  $bobotOns = $riwayatAnorganik[$i]['ons'];
  $bobotGram = $riwayatAnorganik[$i]['gram'];

  $bobotTotal += $bobotKG;
  if ($bobotTon > 0) {
    $bobotTotal += $bobotTon * 1000;
  }
  if ($bobotOns > 0) {
    $bobotTotal += $bobotOns / 10;
  }
  if ($bobotGram > 0) {
    $bobotTotal += $bobotGram / 1000;
  }

  $dataRiwayatAnorganikBulan[$riwayatAnorganik[$i]['bulan']] = $bobotTotal;
}
?>

<script type="text/javascript">
  var dataRiwayatOrganik = '<?php echo json_encode($dataRiwayatOrganikBulan) ?>';
  var dataRiwayatAnorganik = '<?php echo json_encode($dataRiwayatAnorganikBulan) ?>';
</script>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Beranda | Griyo Uwuh</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta content="Lihat ringkasan dan grafik dari pengelolaan di TPS Griyo Uwuh" name="description" />
  <link rel="icon" type="image/x-icon" href="../assets/icon/Logo.png">
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../scss/custom.css" />
  <link rel="stylesheet" href="../assets/css/app.min.css" />
  <link rel="stylesheet" href="../assets/css/icons.min.css" />
  <link rel="stylesheet" href="../style/layout.css" />
  <link rel="stylesheet" href="../style/card.css" />
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
                <li class="breadcrumb-item"><img src="../assets/icon/home.png" alt="" class="icon-bc" /></li>
                <li class="breadcrumb-item" aria-current="page">Beranda</li>
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
                <i class="bx"><img src="../assets/icon/homeactive.png" alt="" class="icon" /></i>
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
                <i class="bx"><img src="../assets/icon/Award.png" alt="" class="icon" /></i>
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
            <i class="bx align-middle"><img src="../assets/icon/home.png" alt="" class="icon-menu" /></i>
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
                    <i class="bx"><img src="../assets/icon/homeactive.png" alt="" class="icon" /></i>
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
                    <i class="bx"><img src="../assets/icon/Award.png" alt="" class="icon" /></i>
                    <span class="menu-item" data-key="peringkat">Peringkat</span>
                  </a>
                </li>

                <li class="position-absolute bottom-0 end-0">
                  <a href="logout" id="sa-warning" style="cursor: pointer;">
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
          <div>
            <div class="flexr-dash2">
              <div class="">
                <div class="flexr-dash">
                  <div class="card-dash">
                    <div class="card card-1">
                      <div class="card-body bcard-1">
                        <div>
                          <div class="d-flex align-items-center">
                            <div class="text-center">
                              <h1 class="mb-0 fw-bold dash-num"><?= str_replace("@", ".", str_replace(".", ",", str_replace(",", "@", getOrganikGlobalTon()))) ?></h1>
                              <h6 class="mb-0 fw-bold dash-ket">Ton</h6>
                            </div>

                            <div class="ms-2">
                              <h6 class="mb-0 display-cardtitle dash-word">Sampah Organik</h6>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-dash">
                    <div class="card card-1">
                      <div class="card-body bcard-1">
                        <div>
                          <div class="d-flex align-items-center">
                            <div class="text-center">
                              <h1 class="mb-0 fw-bold dash-num"><?= str_replace("@", ".", str_replace(".", ",", str_replace(",", "@", getAnorganikGlobalTon()))) ?></h1>
                              <h6 class="mb-0 fw-bold dash-ket">Ton</h6>
                            </div>

                            <div class="ms-2">
                              <h6 class="mb-0 display-cardtitle dash-word">Sampah Anorganik</h6>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="flexr-dash">
                  <div class="card-dash">
                    <div class="card card-1">
                      <div class="card-body bcard-1-1">
                        <div>
                          <div class="d-flex align-items-center">
                            <div class="text-center">
                              <h1 class="mb-0 fw-bold dash-num"><?= getTotalUser(); ?></h1>
                            </div>

                            <div class="ms-2">
                              <h6 class="mb-0 display-cardtitle dash-word">Pengguna</h6>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-dash">
                    <div class="card card-1">
                      <div class="card-body bcard-1-1">
                        <div>
                          <div class="d-flex align-items-center">
                            <div class="text-center">
                              <h1 class="mb-0 fw-bold dash-num"><?= getTotalSetoranPending() ?></h1>
                            </div>

                            <div class="ms-2">
                              <h6 class="mb-0 display-cardtitle dash-word">Setoran Aktif</h6>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="py-2 px-0 dash-imgr"><img src="../assets/pic/banner.png" alt="" class="img-fluid" /></div>
            </div>
          </div>

          <!-- GRAFIK  -->
          <div class="row y-gap-layout">
            <div class="col">
              <div class="card">
                <div class="card-header bg-white">
                  <div class="d-flex justify-content-between">
                    <p class="card-title p-3 mb-0 display-textfield text-fontdark" style="font-weight: 450">Grafik Total Sampah Tahunan yang Terkumpul di TPS (Kilogram)</p>
                    <div class="d-flex align-items-center">
                      <p class="display-textfield pe-2 pt-3">Tahun</p>
                      <a class="btn btn-outline-secondarydark dropdown-toggle p-1 m-2 display-textfield" style="height: fit-content" class="btn btn-outline-secondarydark dropdown-toggle py-1 px-2 m-2" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"><?= $currentYear ?></a>
                      <ul class="dropdown-menu display-textfield" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="beranda?year=2023">2023</a></li>
                        <li><a class="dropdown-item" href="beranda?year=2024">2024</a></li>
                        <li><a class="dropdown-item" href="beranda?year=2025">2025</a></li>
                        <li><a class="dropdown-item" href="beranda?year=2026">2026</a></li>
                        <li><a class="dropdown-item" href="beranda?year=2027">2027</a></li>
                        <li><a class="dropdown-item" href="beranda?year=2028">2028</a></li>
                        <li><a class="dropdown-item" href="beranda?year=2029">2029</a></li>
                        <li><a class="dropdown-item" href="beranda?year=2030">2030</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body"  onresize="responsiveFont()">
                  <canvas id="lineChart" class="chartjs-chart" data-colors='["rgba(234, 170, 170, 0.59)", "#F86956", "rgba(156, 158, 209, 0.65)", "#363853"]' style="display: block; box-sizing: border-box; height: 350px"></canvas>
                </div>
              </div>
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
  <!-- Chart JS -->
  <script src="../assets/libs/chart.min.js"></script>
  <!-- chart script -->
  <script src="../script/chart.js"></script>
  <!-- Sweet Alerts js -->
  <script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>
  <!-- Sweet alert init js-->
  <script src="../assets/js/sweet-alerts.init.js"></script>
  <!-- script loader -->
  <script src="../script/loader.js"></script>

</body>
</html>