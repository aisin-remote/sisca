<!-- Sidebar  -->
<nav id="sidebar">
    <div class="sidebar-header">
        <a class="navbar-brand d-flex justify-content-center" href="/">
            <img src="https://www.aisinindonesia.co.id/assetweb/image/logo/aisin-indonesia-logo.svg" alt="">
        </a>
    </div>
    <ul class="list-unstyled components">
        <li class="">
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Home</a>
            <ul class="collapse list-unstyled" id="homeSubmenu">
                <li>
                    <a href="#">Home 1</a>
                </li>
                <li>
                    <a href="#">Home 2</a>
                </li>
                <li>
                    <a href="#">Home 3</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#">About</a>
        </li>
        <li class="{{Request::is('dashboard/apar*') ? 'active show' : ''}}">
            <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Apar</a>
            <ul class="collapse list-unstyled {{ Request::is('dashboard/apar*') ? 'show' : '' }}" id="pageSubmenu">
                <li class="{{ Request::is('dashboard/apar/data_apar*') ? 'active' : '' }}">
                    <a class="nav-link" href="/dashboard/apar/data_apar">Data Apar</a>
                </li>
                <li class="{{ Request::is('dashboard/apar/data_location*') ? 'active' : '' }}">
                    <a class="nav_link" href="/dashboard/apar/data_location">Data Location</a>
                </li>
                {{-- <li>
                    <a href="#">Page 3</a>
                </li> --}}
            </ul>
        </li>
    </ul>
</nav>
