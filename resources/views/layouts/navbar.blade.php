<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="nav-icon fas fa-user-circle"></i>
        {{ Auth::user()->email }}
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <form action="{{ route('logout') }}" method="post">
          @csrf
          <button type="submit" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Log Out
          </button>
        </form>
      </div>
    </li>
  </ul>
</nav>