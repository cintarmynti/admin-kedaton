<div class="page-sidebar">
  <ul class="list-unstyled accordion-menu">
    <li class="sidebar-title">
        Saldo
    </li>
    <li>
        <a href=""><h4 id="total-balance"></h4> </a>
    </li>
    <li class="sidebar-title">
      Main
    </li>
    <li class="{{ Request::is('dashboard*') ? 'active-page' : '' }}">
      <a href="{{route('dashboard.index')}}"><i data-feather="home"></i>Dashboard <div class="alert-circle"></div></a>
    </li>

    <li class="{{ Request::is('cluster') ? 'active-page' : '' }}" class="active-page">
        <a href="{{route('cluster')}}"><i data-feather="file-plus"></i>Cluster</a>
    </li>

    <li class="{{ Request::is('properti*') ? 'active-page' : '' }}">
      <a href="{{route('properti')}}"><i data-feather="home"></i>Properti</a>
    </li>

    {{-- <li  class="{{ Request::is('admin') ? 'active-page' : '' }}">
    <a href="{{route('admin.index')}}"><i data-feather="home"></i>Admin</a>
    </li> --}}

    <li class="{{ Request::is('user*') ? 'active-page' : '' }}">
      <a href="{{route('user')}}"><i data-feather="user"></i>Penghuni</a>
    </li>
    {{--
      <li class="{{ Request::is('rumah-pengguna*') ? 'active-page' : '' }}">
    <a href="/rumah-pengguna"><i data-feather="user-check"></i>Rumah Pengguna</a>
    </li> --}}




    <li class="{{ Request::is('listing*') ? 'active-page' : '' }}">
      <a href="{{route('listing')}}"><i data-feather="book-open"></i>Listing</a>
    </li>

    <li class="{{ Request::is('splash-screen*') ? 'active-page' : '' }}">
      <a href="/splash-screen"><i data-feather="repeat"></i>Splash Screen</a>
    </li>


    <li class="{{ Request::is('banner*') ? 'active-page' : '' }}">
      <a href="{{route('banner')}}"><i data-feather="monitor"></i>Banner</a>
    </li>


    {{-- <li class="{{ Request::is('promo*') ? 'active-page' : '' }}" class="active-page">
    <a href="{{route('promo')}}"><i data-feather="paperclip"></i>Promo</a>
    </li> --}}

    <li class="{{ Request::is('ipkl*') ? 'active-page' : '' }}" class="active-page">
      <a href="{{route('ipkl')}}"><i data-feather="archive"></i>Pembayaran IPKL</a>
    </li>

    {{-- <li class="{{ Request::is('layanan*') ? 'active-page' : '' }}" class="active-page">
    <a href="{{route('layanan')}}"><i data-feather="archive"></i>Pembayaran Layanan</a>
    </li> --}}


    <li class="{{ Request::is('blog*') ? 'active-page' : '' }}" class="active-page">
      <a href="{{route('blog')}}"><i data-feather="file"></i>Blog</a>
    </li>

    <!-- <li class="{{ Request::is('renovasi*') ? 'active-page' : '' }}">
      <a href="{{route('renovasi')}}"><i data-feather="tool"></i>Otoritas Renovasi</a>
    </li> -->
    <li class="{{ Request::is('complain*') ? 'active-page' : '' }}">
      <a href="{{route('complain')}}"><i data-feather="alert-triangle"></i>Laporan Complain</a>
    </li>
    <li class="{{ Request::is('panic-button*') ? 'active-page' : '' }}">
      <a href="{{route('panic')}}"><i data-feather="activity"></i>Laporan Panic Button</a>
    </li>

    {{-- <li class="{{ Request::is('iuran') ? 'active-page' : '' }}">
    <a href="{{route('iuran')}}"><i data-feather="calendar"></i>Iuran</a>
    </li>
    <li class="{{ Request::is('bayar') ? 'active-page' : '' }}">
      <a href="{{route('bayar')}}"><i data-feather="user"></i>bayar</a>
    </li> --}}
  </ul>
</div>
