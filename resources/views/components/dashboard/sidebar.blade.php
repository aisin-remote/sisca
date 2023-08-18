<!-- Sidebar  -->
<nav id="sidebar">
    <div class="sidebar-header">
        <a class="navbar-brand d-flex justify-content-center" href="/">
            <img src="https://www.aisinindonesia.co.id/assetweb/image/logo/aisin-indonesia-logo.svg" alt="">
        </a>
    </div>
    <ul class="list-unstyled components">
        <li class="{{Request::is('dashboard/home*') ? 'active show' : ''}}">
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Home</a>
            <ul class="collapse list-unstyled {{ Request::is('dashboard/home*') ? 'show' : '' }}" id="homeSubmenu">
                <li class="{{ Request::is('dashboard/home/grafik-status*') ? 'active' : '' }}">
                    <a href="/dashboard/home/grafik-status">Grafik Status</a>
                </li>
                <li class="{{ Request::is('dashboard/home/checksheet-report-apar*') ? 'active' : '' }}">
                    <a href="/dashboard/home/checksheet-report-apar">Check Sheet Report Apar</a>
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
            <a href="#aparSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Apar</a>
            <ul class="collapse list-unstyled {{ Request::is('dashboard/apar*') ? 'show' : '' }}" id="aparSubmenu">
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
        <li class="{{Request::is('dashboard/hydrant*') ? 'active show' : ''}}">
            <a href="#hydrantSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Hydrant</a>
            <ul class="collapse list-unstyled {{ Request::is('dashboard/hydrant*') ? 'show' : '' }}" id="hydrantSubmenu">
                <li class="{{ Request::is('dashboard/hydrant/data-hydrant*') ? 'active' : '' }}">
                    <a class="nav-link" href="/dashboard/hydrant/data-hydrant">Data Hydrant</a>
                </li>
                <li class="{{ Request::is('dashboard/apar/data_location*') ? 'active' : '' }}">
                    <a class="nav_link" href="/dashboard/apar/data_location">Data Location</a>
                </li>
                {{-- <li>
                    <a href="#">Page 3</a>
                </li> --}}
            </ul>
        </li>
        <li class="{{Request::is('dashboard/nitrogen*') ? 'active show' : ''}}">
            <a href="#nitrogenSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Nitrogen</a>
            <ul class="collapse list-unstyled {{ Request::is('dashboard/nitrogen*') ? 'show' : '' }}" id="nitrogenSubmenu">
                <li class="{{ Request::is('dashboard/nitrogen/data-nitrogen*') ? 'active' : '' }}">
                    <a class="nav-link" href="/dashboard/nitrogen/data-nitrogen">Data Nitrogen</a>
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
