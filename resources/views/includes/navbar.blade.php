<nav class="navbar navbar-expand-lg d-flex justify-content-between">
  <div class="" id="navbarNav">
    <ul class="navbar-nav" id="leftNav">
      <li class="nav-item">
        <a class="nav-link" id="sidebar-toggle" href="#"><i data-feather="arrow-left"></i></a>
      </li>

    </ul>
  </div>
  <div class="logo">
    <img src="{{asset('assets/images/kedaton-logo.png')}}" height="40px" alt="">
  </div>
  <div class="" id="headerNav">
    <ul class="navbar-nav">
      <li class="nav-item dropdown">

        <div class="dropdown-menu dropdown-menu-end dropdown-lg search-drop-menu" aria-labelledby="searchDropDown">
          <form>
            <input class="form-control" type="text" placeholder="Type something.." aria-label="Search">
          </form>
          <h6 class="dropdown-header">Recent Searches</h6>

        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link" href="#" id="notificationsDropDown" data-bs-toggle="dropdown" aria-expanded="false"> <i data-feather="bell"></i> <span class="badge badge-danger" id="total-notif"></span></a>
        <div class="dropdown-menu dropdown-menu-end notif-drop-menu" aria-labelledby="notificationsDropDown">
          <h6 class="dropdown-header">Notifications</h6>
          <div id="notif">

          </div>
          {{-- <a href="#">
            <div class="header-notif">
              <div class="notif-text">
                <p class="bold-notif-text" id="header-notif"></p>
                <small id="jam-notif"></small>
              </div>
            </div>
          </a> --}}
          {{-- <a href="#">
            <div class="header-notif">
              <div class="notif-text">
                <p class="bold-notif-text">Si A telah menambahkan si B sebagai penyewa di properti KX34</p>
                <small>19:00</small>
              </div>
            </div>
          </a>
          <a href="#">
            <div class="header-notif">
              <div class="notif-text">
                <p class="bold-notif-text">Si A telah membayar tagihan IPKL bulan Maret 2022</p>
                <small>19:00</small>
              </div>
            </div>
          </a> --}}
        </div>
      </li>

      <li class="nav-item dropdown">
        {{-- ini tanda  --}}

        <a class="nav-link " href="#" id="profileDropDown" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ Auth::user()->name }} </a>
        <div class="dropdown-menu dropdown-menu-end profile-drop-menu">

          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();" href="#"><i data-feather="log-out"></i>Logout</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        </div>
      </li>
    </ul>
  </div>
</nav>
