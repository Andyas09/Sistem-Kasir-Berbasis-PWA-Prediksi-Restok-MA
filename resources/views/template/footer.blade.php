
    
   
    
    <!-- Main Content Area -->
    <div class="content-wrapper">
      @yield('content')
    </div>

    <footer class="main-footer d-flex justify-content-between align-items-center px-3 py-2 text-white"
          style="background-color: rgba(73, 70, 70, 1);">
      <div><strong>&copy; <?= date('Y') ?> HNSM Store</strong></div>
      <div>Sistem Manajemen Kasir</div>
    </footer>

  </div>
  <!-- ./wrapper -->

  <script>
    function togglePosMenu(event) {
      event.preventDefault();
      let submenu = document.getElementById("subMenu");
      submenu.style.display = submenu.style.display === "none" ? "block" : "none";
    }
    
    function toggleStokMenu(event) {
      event.preventDefault();
      let submenu = document.getElementById("subMenuStok");
      submenu.style.display = (submenu.style.display === "none" || submenu.style.display === "")
        ? "block"
        : "none";
    }
    
    // Service Worker for PWA
    if ("serviceWorker" in navigator) {
      navigator.serviceWorker.register("/sw.js").then(
        (registration) => {
          console.log("Service worker registration succeeded:", registration);
        },
        (error) => {
          console.error(`Service worker registration failed: ${error}`);
        },
      );
    } else {
      console.error("Service workers are not supported.");
    }
  </script>

  <!-- jQuery UI 1.11.4 -->
  <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- ChartJS -->
  <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
  <!-- Sparkline -->
  <script src="{{ asset('assets/plugins/sparklines/sparkline.js') }}"></script>
  <!-- JQVMap -->
  <script src="{{ asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
  <!-- jQuery Knob Chart -->
  <script src="{{ asset('assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
  <!-- daterangepicker -->
  <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
  <!-- Summernote -->
  <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
  <!-- overlayScrollbars -->
  <script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>
  <!-- AdminLTE dashboard demo -->
  <script src="{{ asset('assets/dist/js/pages/dashboard.js') }}"></script>
  <!-- PWA Install -->
  <script src="{{ asset('pwa-install.js') }}"></script>
</body>
</html>