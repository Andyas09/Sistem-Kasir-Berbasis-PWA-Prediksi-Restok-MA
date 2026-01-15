 @php
      $role = Auth::user()->role->nama_role;
    @endphp
 <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #000B49;">
      <!-- Brand Logo -->
      <a href="{{ route('dashboard.index') }}" class="brand-link text-center">
        <img src="{{ asset('assets/logo/logo.jpeg') }}" alt="HNSM Store" style="height: 50px; width: auto;">
      </a>

      <!-- Sidebar -->
      <div class="sidebar"> 
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">

            <!-- Dashboard -->
            @if($role === 'Admin')
              <li class="nav-item">
                <a href="{{ route('dashboard.index') }}"
                  class="nav-link {{ ($Dashboard ?? '') == 'dashboard' ? 'active' : '' }}">
                  <i class="nav-icon fas fa-tachometer-alt text-white"></i>
                  <p class="text-white">Dashboard</p>
                </a>
              </li>
            @endif

            <li class="nav-item {{ $posActive ?? false ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ $posActive ?? false ? 'active' : '' }}" onclick="togglePosMenu(event)">
                <i class="nav-icon fas fa-cash-register"></i>
                <p class="text-white">
                  Point of Sale
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>

              <ul class="nav nav-treeview" id="subMenu"
                style="{{ ($posActive ?? false) ? 'display:block;' : 'display:none;' }}">

                <li class="nav-item">
                  <a href="{{ route('pos.transaksi') }}"
                    class="nav-link {{ ($activePos ?? '') == 'pos-transaksi' ? 'active' : '' }}"
                    style="padding-left: 35px;">
                    <i class="fas fa-shopping-cart nav-icon"></i>
                    <p>Transaksi</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('pos.daftar') }}"
                    class="nav-link {{ ($activePos ?? '') == 'pos-daftar' ? 'active' : '' }}" style="padding-left: 35px;">
                    <i class="fas fa-list nav-icon"></i>
                    <p>Daftar Transaksi</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('pos.retur') }}"
                    class="nav-link {{ ($activePos ?? '') == 'pos-retur' ? 'active' : '' }}" style="padding-left: 35px;">
                    <i class="fas fa-undo nav-icon"></i>
                    <p>Retur Barang</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('pos.hold') }}" class="nav-link {{ ($activePos ?? '') == 'pos-hold' ? 'active' : '' }}"
                    style="padding-left: 35px;">
                    <i class="fas fa-pause-circle nav-icon"></i>
                    <p>Hold Transaksi</p>
                  </a>
                </li>

              </ul>
            </li>


            <!-- Produk -->
            <li class="nav-item">
              <a href="{{ route('produk.index') }}"
                class="nav-link {{ ($activeProduk ?? '') == 'produk' ? 'active' : '' }}">
                <i class="nav-icon fas fa-box"></i>
                <p class="text-white">Produk</p>
              </a>
            </li>

            @if($role === 'Admin')
            <!-- Stok -->
            <li class="nav-item {{ $stokActive ?? false ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ $stokActive ?? false ? 'active' : '' }}" onclick="toggleStokMenu(event)">
                <i class="nav-icon fas fa-boxes"></i>
                <p class="text-white">
                  Stok
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>

              <ul class="nav nav-treeview" id="subMenuStok" style="display: {{ $stokActive ?? false ? 'block' : 'none' }};">

                <li class="nav-item">
                  <a href="{{ route('stok.masuk') }}"
                    class="nav-link {{ ($activePage ?? '') == 'stok-masuk' ? 'active' : '' }}" style="padding-left: 35px;">
                    <i class="fas fa-arrow-circle-down nav-icon"></i>
                    <p>Stok Masuk</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('stok.keluar') }}"
                    class="nav-link {{ ($activePage ?? '') == 'stok-keluar' ? 'active' : '' }}" style="padding-left: 35px;">
                    <i class="fas fa-arrow-circle-up nav-icon"></i>
                    <p>Stok Keluar</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('stok.opname') }}"
                    class="nav-link {{ ($activePage ?? '') == 'stok-opname' ? 'active' : '' }}" style="padding-left: 35px;">
                    <i class="fas fa-clipboard-check nav-icon"></i>
                    <p>Stock Opname</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('stok.prediksi') }}"
                    class="nav-link {{ ($activePage ?? '') == 'stok-prediksi' ? 'active' : '' }}"
                    style="padding-left: 35px;">
                    <i class="nav-icon fas fa-chart-line"></i>
                    <p>Prediksi Restok</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('stok.riwayat') }}"
                    class="nav-link {{ ($activePage ?? '') == 'stok-riwayat' ? 'active' : '' }}"
                    style="padding-left: 35px;">
                    <i class="fas fa-history nav-icon"></i>
                    <p>Riwayat Stok</p>
                  </a>
                </li>

              </ul>
            </li>
            @endif
            
            <!-- Laporan -->
            <li class="nav-item">
              <a href="{{ route('laporan.index') }}"
                class="nav-link {{ ($activeLaporan ?? '') == 'laporan' ? 'active' : '' }}">
                <i class="nav-icon fas fa-file-alt"></i>
                <p class="text-white">Laporan</p>
              </a>
            </li>
            
            <!-- Pengguna & Hak Akses -->
            @if(auth()->user()->isAdmin())
            <li class="nav-item">
              <a href="{{ route('pengguna.index') }}"
                class="nav-link {{ ($activePengguna ?? '') == 'pengguna' ? 'active' : '' }}">
                <i class="nav-icon fas fa-users-cog"></i>
                <p class="text-white">Pengguna & Hak Akses</p>
              </a>
            </li>
            @endif
            
            <!-- Pengaturan Sistem -->
            @if($role === 'Admin')
            <li class="nav-item">
              <a href="{{ route('pengaturan.index') }}"
                class="nav-link {{ ($activePengaturan ?? '') == 'pengaturan' ? 'active' : '' }}">
                <i class="nav-icon fas fa-cogs"></i>
                <p class="text-white">Pengaturan Sistem</p>
              </a>
            </li>
            @endif

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>