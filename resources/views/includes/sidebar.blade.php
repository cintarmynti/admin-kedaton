<div class="page-sidebar">
    <ul class="list-unstyled accordion-menu">
      <li class="sidebar-title">
        Main
      </li>
      <li  class="{{ Request::is('dashboard') ? 'active-page' : '' }}">
        <a href="{{route('dashboard.index')}}"><i data-feather="home"></i>Dashboard</a>
      </li>

      <li class="{{ Request::is('user') ? 'active-page' : '' }}">
        <a href="{{route('user')}}"><i data-feather="inbox"></i>User</a>
      </li>
      <li class="{{ Request::is('listing') ? 'active-page' : '' }}">
        <a href="{{route('listing')}}"><i data-feather="calendar"></i>Listing</a>
      </li>
      <li class="{{ Request::is('banner') ? 'active-page' : '' }}">
        <a href="{{route('banner')}}"><i data-feather="user"></i>Banner</a>
      </li>


      <li class="{{ Request::is('promo') ? 'active-page' : '' }}" class="active-page">
        <a href="{{route('promo')}}"><i data-feather="home"></i>Promo</a>
      </li>

      <li class="{{ Request::is('renovasi') ? 'active-page' : '' }}">
        <a href="{{route('renovasi')}}"><i data-feather="inbox"></i>Otoritas Renovasi</a>
      </li>
      <li class="{{ Request::is('complain') ? 'active-page' : '' }}">
        <a href="{{route('complain')}}"><i data-feather="calendar"></i>Laporan Complain</a>
      </li>
      <li class="{{ Request::is('panic') ? 'active-page' : '' }}">
        <a href="{{route('panic')}}"><i data-feather="user"></i>Laporan Panic Button</a>
      </li>

      <li class="{{ Request::is('iuran') ? 'active-page' : '' }}">
        <a href="{{route('iuran')}}"><i data-feather="calendar"></i>Iuran</a>
      </li>
      <li class="{{ Request::is('bayar') ? 'active-page' : '' }}">
        <a href="{{route('bayar')}}"><i data-feather="user"></i>bayar</a>
      </li>
    </ul>
</div>
