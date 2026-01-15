<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>HNSM Store</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="manifest" href="{{ asset('/manifest.json') }}">
  <meta name="theme-color" content="#000B49">
  <link rel="apple-touch-icon" href="{{ asset('assets/logo/logo.jpeg') }}">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet"
    href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
  <!-- jQuery -->
  <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

  <!-- Bootstrap 4 -->
  <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- AdminLTE -->
  <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>

</head>
<style>
  .btn-logout {
    background-color: red;
    color: black;
    border: none;
    padding: 3px 12px;
    border-radius: 4px;
    font-weight: bold;
    cursor: pointer;
  }

  .btn-logout:hover {
    background-color: darkred;
    color: white;
  }

  /* Responsive for iPad */
  @media (max-width: 1024px) {

    /* Navbar adjustments */
    .navbar-nav {
      flex-wrap: wrap;
    }

    .nav-link.text-white.font-weight-bold {
      font-size: 0.9rem;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 200px;
    }

    /* Clock adjustments */
    #clock {
      font-size: 0.85rem;
      padding: 0.25rem 0.5rem;
    }

    /* Notification bell */
    .nav-item.dropdown .nav-link .fa-bell {
      font-size: 1.2rem;
    }

    /* Sidebar adjustments */
    .main-sidebar {
      width: 230px !important;
    }

    .sidebar {
      padding-top: 10px;
    }

    .brand-link {
      padding: 10px 0.5rem;
    }

    .brand-link img {
      height: 40px !important;
    }

    .nav-sidebar .nav-link p {
      font-size: 0.9rem;
    }

    .nav-sidebar .nav-link i {
      font-size: 1rem;
      min-width: 25px;
    }

    /* Content wrapper */
    .content-wrapper {
      margin-left: 230px !important;
    }

    /* Footer adjustments */
    .main-footer {
      padding: 8px 15px !important;
      font-size: 0.85rem;
    }

    .main-footer div {
      margin: 2px 0;
    }

    /* Dropdown menus */
    .dropdown-menu {
      min-width: 250px;
      font-size: 0.9rem;
    }

    /* Fullscreen icon */
    .fa-expand-arrows-alt {
      font-size: 1.2rem;
    }

    /* User menu icon */
    .fa-user-circle {
      font-size: 1.3rem;
    }
  }

  @media (max-width: 768px) {

    /* Tablet portrait adjustments */
    .navbar {
      padding: 0.3rem 0.5rem;
    }

    .nav-link.text-white.font-weight-bold {
      max-width: 150px;
      font-size: 0.8rem;
    }

    #clock {
      font-size: 0.75rem;
      display: none;
      /* Hide clock on smaller screens to save space */
    }

    .brand-link img {
      height: 35px !important;
    }

    .nav-sidebar .nav-link {
      padding: 0.5rem 0.75rem;
    }

    .nav-sidebar .nav-link p {
      font-size: 0.85rem;
    }

    /* Submenu items */
    .nav-treeview .nav-link {
      padding-left: 30px !important;
    }

    .nav-treeview .nav-link i {
      font-size: 0.9rem;
    }

    /* Footer on small screens */
    .main-footer {
      flex-direction: column;
      text-align: center;
      padding: 6px 10px !important;
    }

    .main-footer div {
      margin: 3px 0;
    }

    /* Show clock in dropdown on mobile */
    .navbar-nav .nav-item .nav-link#clock {
      display: none;
    }

    /* Notification badge */
    .navbar-badge {
      font-size: 0.6rem;
      padding: 2px 4px;
      right: 5px;
      top: 5px;
    }
  }

  @media (min-width: 769px) and (max-width: 1024px) {

    /* Landscape iPad optimizations */
    .nav-link.text-white.font-weight-bold {
      max-width: 300px;
    }

    #clock {
      font-size: 0.9rem;
    }

    .sidebar {
      overflow-y: auto;
      max-height: calc(100vh - 120px);
    }

    /* Better touch targets for iPad */
    .nav-link {
      padding: 0.75rem 1rem;
    }

    .dropdown-toggle::after {
      margin-left: 0.5em;
    }

    /* Larger tap targets for submenu items */
    .nav-treeview .nav-link {
      padding: 0.6rem 1rem 0.6rem 35px;
    }
  }

  /* Additional responsive utilities */
  .text-ipad-hide {
    display: none;
  }

  @media (max-width: 1024px) {
    .text-ipad-hide {
      display: inline;
    }

    .text-ipad-show {
      display: none;
    }
  }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- NAVBAR -->
    <nav class="main-header navbar navbar-expand navbar-dark" style="background-color:#000B49;">

      <!-- LEFT -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button">
            <i class="fas fa-bars"></i>
          </a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
          <span class="nav-link text-white font-weight-bold">
            <span class="text-ipad-show">Sistem Kasir & Manajemen Stok</span>
            <span class="text-ipad-hide">HNSM Store</span>
          </span>
        </li>
      </ul>

      <!-- RIGHT -->
      <ul class="navbar-nav ml-auto">

        <!-- JAM -->
        <li class="nav-item d-none d-md-block">
          <span class="nav-link text-white" id="clock"></span>
        </li>

        <!-- NOTIFIKASI -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell text-white"></i>
            <span class="badge badge-danger navbar-badge">3</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header">Notifikasi</span>

            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-exclamation-triangle text-warning mr-2"></i>
              Stok Sabun hampir habis
            </a>

            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-shopping-cart text-success mr-2"></i>
              Transaksi baru
            </a>

            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">
              Lihat Semua
            </a>
          </div>
        </li>

        <!-- FULLSCREEN -->
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt text-white"></i>
          </a>
        </li>

        <!-- USER -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-user-circle text-white"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <span class="dropdown-item-text font-weight-bold">
              {{ Auth::user()->nama ?? '-' }}
              <small class="d-block text-muted">{{ Auth::user()->role->nama_role ?? 'Administrator' }}</small>
            </span>

            <div class="dropdown-divider"></div>
            <a href="{{ route('profil.index') }}" class="dropdown-item">
              <i class="fas fa-user mr-2"></i> Profil
            </a>

            <div class="dropdown-divider"></div>

            <a href="#" class="dropdown-item text-danger"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </div>
        </li>

      </ul>
    </nav>

    <!-- SCRIPT JAM REALTIME -->
    <script>
      function updateClock() {
        const now = new Date();
        const options = {
          weekday: 'short',
          year: 'numeric',
          month: 'short',
          day: 'numeric',
          hour: '2-digit',
          minute: '2-digit',
          second: '2-digit'
        };
        document.getElementById('clock').innerHTML =
          now.toLocaleDateString('id-ID', options);
      }
      setInterval(updateClock, 1000);
      updateClock();

      // iPad specific touch enhancements
      document.addEventListener('DOMContentLoaded', function () {
        // Better touch support for dropdowns on iPad
        $('.dropdown-toggle').on('click touchstart', function (e) {
          e.preventDefault();
          $(this).dropdown('toggle');
        });

        // Prevent double tap zoom on buttons
        $('.nav-link, .dropdown-item').on('touchstart', function (e) {
          if ($(this).hasClass('dropdown-toggle')) {
            return;
          }
          var $link = $(this);
          var href = $link.attr('href');
          if (href && href !== '#') {
            window.location = href;
          }
        });
      });
    </script>

    