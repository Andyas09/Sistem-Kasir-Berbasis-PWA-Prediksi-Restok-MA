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

    