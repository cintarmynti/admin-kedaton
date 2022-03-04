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

            <li class="nnav-item">  <i data-feather="bell"></i></a></li>
          <li class="nav-item dropdown">
              {{-- ini tanda  --}}

            <a class="nav-link profile-dropdown" href="#" id="profileDropDown" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ Auth::user()->name }} </a>
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
