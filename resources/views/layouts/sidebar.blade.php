<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('home') }}" class="brand-link">
    <img src="{{ asset('img/favicon.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">SDN Burengan 5</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link {{ Request::is('/', 'dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>
        @if (Auth::user()->role == 'Guru')
        <li class="nav-item {{ Request::is('jadwal', 'guru', 'kelas', 'mapel', 'siswa', 'user') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ Request::is('jadwal', 'guru', 'kelas', 'mapel', 'siswa', 'user') ? 'active' : '' }}">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              Master Data
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('jadwal.index') }}" class="nav-link {{ Request::is('jadwal') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt nav-icon"></i>
                <p>Jadwal</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('guru.index') }}" class="nav-link {{ Request::is('guru') ? 'active' : '' }}">
                <i class="fas fa-users nav-icon"></i>
                <p>Guru</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('kelas.index') }}" class="nav-link {{ Request::is('kelas') ? 'active' : '' }}">
                <i class="fas fa-home nav-icon"></i>
                <p>Kelas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('mapel.index') }}" class="nav-link {{ Request::is('mapel') ? 'active' : '' }}">
                <i class="fas fa-book nav-icon"></i>
                <p>Mapel</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('siswa.index') }}" class="nav-link {{ Request::is('siswa') ? 'active' : '' }}">
                <i class="fas fa-users nav-icon"></i>
                <p>Siswa</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="{{ route('absen.index') }}" class="nav-link {{ Request::is('absen') ? 'active' : '' }}">
            <i class="nav-icon fas fa-edit"></i>
            <p>Absensi Kelas</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('tugas.index') }}" class="nav-link {{ Request::is('tugas') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt nav-icon"></i>
            <p>Daftar Tugas</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('kuis.index') }}" class="nav-link {{ Request::is('kuis') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt nav-icon"></i>
            <p>Kuis</p>
          </a>
        </li>
        @else
        <li class="nav-item">
          <a href="{{ route('absen.index') }}" class="nav-link {{ Request::is('absen') ? 'active' : '' }}">
            <i class="nav-icon fas fa-edit"></i>
            <p>Absen Kelas</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('tugas.index') }}" class="nav-link {{ Request::is('tugas') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt nav-icon"></i>
            <p>Daftar Tugas</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('jadwal.index') }}" class="nav-link {{ Request::is('jadwal') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt nav-icon"></i>
            <p>Jadwal</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('kuis.index') }}" class="nav-link {{ Request::is('kuis') || Request::is('jawab') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt nav-icon"></i>
            <p>Kuis</p>
          </a>
        @endif
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>