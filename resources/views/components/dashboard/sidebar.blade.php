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
            </ul>
        </li>
        <li class="{{ Request::is('dashboard/location*') ? 'active show' : '' }}">
            <a class="nav_link" href="/dashboard/location">Location</a>
        </li>
        <li class="{{Request::is('dashboard/apar*') ? 'active show' : ''}}">
            <a href="#aparSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Apar</a>
            <ul class="collapse list-unstyled {{ Request::is('dashboard/apar*') ? 'show' : '' }}" id="aparSubmenu">
                <li class="{{ Request::is('dashboard/apar/data_apar*') ? 'active' : '' }}">
                    <a class="nav-link" href="/dashboard/apar/data_apar">Data Apar</a>
                </li>
                <li class="{{ Request::is('dashboard/apar/checksheet*') ? 'active' : '' }}">
                    <a class="nav_link" href="/dashboard/apar/checksheet">Check Sheet Apar</a>
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
            </ul>
        </li>
        <li class="{{Request::is('dashboard/nitrogen*') ? 'active show' : ''}}">
            <a href="#nitrogenSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Nitrogen</a>
            <ul class="collapse list-unstyled {{ Request::is('dashboard/nitrogen*') ? 'show' : '' }}" id="nitrogenSubmenu">
                <li class="{{ Request::is('dashboard/nitrogen/data-nitrogen*') ? 'active' : '' }}">
                    <a class="nav-link" href="/dashboard/nitrogen/data-nitrogen">Data Nitrogen</a>
                </li>
            </ul>
        </li>
        <li class="{{Request::is('dashboard/co2*') ? 'active show' : ''}}">
            <a href="#co2Submenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Co2</a>
            <ul class="collapse list-unstyled {{ Request::is('dashboard/co2*') ? 'show' : '' }}" id="co2Submenu">
                <li class="{{ Request::is('dashboard/co2/data-co2*') ? 'active' : '' }}">
                    <a class="nav-link" href="/dashboard/co2/data-co2">Data Co2</a>
                </li>
            </ul>
        </li>
        <li class="{{Request::is('dashboard/tandu*') ? 'active show' : ''}}">
            <a href="#tanduSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Tandu</a>
            <ul class="collapse list-unstyled {{ Request::is('dashboard/tandu*') ? 'show' : '' }}" id="tanduSubmenu">
                <li class="{{ Request::is('dashboard/tandu/data-tandu*') ? 'active' : '' }}">
                    <a class="nav-link" href="/dashboard/tandu/data-tandu">Data Tandu</a>
                </li>
            </ul>
        </li>
        <li class="{{Request::is('dashboard/eyewasher*') ? 'active show' : ''}}">
            <a href="#eyewasherSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Eye Washer</a>
            <ul class="collapse list-unstyled {{ Request::is('dashboard/eyewasher*') ? 'show' : '' }}" id="eyewasherSubmenu">
                <li class="{{ Request::is('dashboard/eyewasher/data-eyewasher*') ? 'active' : '' }}">
                    <a class="nav-link" href="/dashboard/eyewasher/data-eyewasher">Data Eye Washer</a>
                </li>
            </ul>
        </li>
        <li class="{{Request::is('dashboard/sling*') ? 'active show' : ''}}">
            <a href="#slingSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Sling</a>
            <ul class="collapse list-unstyled {{ Request::is('dashboard/sling*') ? 'show' : '' }}" id="slingSubmenu">
                <li class="{{ Request::is('dashboard/sling/data-sling*') ? 'active' : '' }}">
                    <a class="nav-link" href="/dashboard/sling/data-sling">Data Sling</a>
                </li>
            </ul>
        </li>
        <li class="{{Request::is('dashboard/tembin*') ? 'active show' : ''}}">
            <a href="#tembinSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Tembin</a>
            <ul class="collapse list-unstyled {{ Request::is('dashboard/tembin*') ? 'show' : '' }}" id="tembinSubmenu">
                <li class="{{ Request::is('dashboard/tembin/data-tembin*') ? 'active' : '' }}">
                    <a class="nav-link" href="/dashboard/tembin/data-tembin">Data Tembin</a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
