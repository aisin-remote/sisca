<!-- Sidebar  -->
<nav id="sidebar">
    <div class="sidebar-header">
        <a class="navbar-brand d-flex justify-content-center" href="/">
            <img src="/foto/logo-sisca.png" alt="Logo AIIA" class="img-fluid" style="max-width: 200px; height: auto;"
                id="logo-sidebar">
        </a>
    </div>
    <ul class="list-unstyled components">
        <li class="{{ Request::is('dashboard') ? 'active show' : '' }} menu">
            <a class="nav_link" href="/dashboard">
                <span style="display: flex; justify-content: space-between; align-items: center;">
                    <i class="bi bi-bar-chart-line-fill" style="margin-left: 9px;"></i>
                    Dashboard
                    <i class="fas fa-chevron-down" style="opacity: 0;"></i>
                </span>
            </a>
        </li>

        <li class="{{ Request::is('dashboard/location*') ? 'active show' : '' }} menu">
            <a href="#locationSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <span style="display: flex; justify-content: space-between; align-items: center;">
                    <i class="bi bi-pin-map-fill"></i> Location
                    <i class="fas fa-chevron-down"></i>
                </span>
            </a>
            <ul class="collapse list-unstyled {{ Request::is('dashboard/location*') ? 'show' : '' }}"
                id="locationSubmenu">
                <li class="{{ Request::is('dashboard/location/all-equipment*') ? 'active' : '' }} submenu">
                    <a class="nav-link" href="/dashboard/location/all-equipment">All Equipment</a>
                </li>
                <li class="{{ Request::is('dashboard/location/apar*') ? 'active' : '' }} submenu">
                    <a class="nav-link" href="/dashboard/location/apar">Apar</a>
                </li>
                <li class="{{ Request::is('dashboard/location/hydrant*') ? 'active' : '' }} submenu">
                    <a class="nav-link" href="/dashboard/location/hydrant">Hydrant</a>
                </li>
            </ul>
        </li>
        <li class="{{ Request::is('dashboard/master*') ? 'active show' : '' }} menu">
            <a href="#masterSubmenu" aria-controls="masterSubmenu" data-toggle="collapse" aria-expanded="false"
                class="dropdown-toggle">
                <span style="display: flex; justify-content: space-between; align-items: center;">
                    <i class="bi bi-database-fill-add"></i> Master
                    <i class="fas fa-chevron-down"></i>
                </span>
            </a>
            <ul class="collapse list-unstyled {{ Request::is('dashboard/master*') ? 'show' : '' }}" id="masterSubmenu">
                @if (Auth::user()->role == 'MTE')
                    <li class="{{ Request::is('dashboard/master/location*') ? 'active' : '' }} submenu">
                        <a href="/dashboard/master/location">Location</a>
                    </li>
                    <!-- Menampilkan hanya submenu Head Crane untuk peran mte -->
                    <li class="{{ Request::is('dashboard/master/head-crane*') ? 'active' : '' }} submenu">
                        <a href="/dashboard/master/head-crane">Head Crane</a>
                    </li>
                @else
                    <li class="{{ Request::is('dashboard/master/location*') ? 'active' : '' }} submenu">
                        <a href="/dashboard/master/location">Location</a>
                    </li>
                    <li class="{{ Request::is('dashboard/master/apar*') ? 'active' : '' }} submenu">
                        <a href="/dashboard/master/apar">Apar</a>
                    </li>
                    <li class="{{ Request::is('dashboard/master/hydrant*') ? 'active' : '' }} submenu">
                        <a href="/dashboard/master/hydrant">Hydrant</a>
                    </li>
                    <li class="{{ Request::is('dashboard/master/nitrogen*') ? 'active' : '' }} submenu">
                        <a href="/dashboard/master/nitrogen">Nitrogen</a>
                    </li>
                    <li class="{{ Request::is('dashboard/master/co2*') ? 'active' : '' }} submenu">
                        <a href="/dashboard/master/co2">Co2</a>
                    </li>
                    <li class="{{ Request::is('dashboard/master/tandu*') ? 'active' : '' }} submenu">
                        <a href="/dashboard/master/tandu">Tandu</a>
                    </li>
                    <li class="{{ Request::is('dashboard/master/eye-washer*') ? 'active' : '' }} submenu">
                        <a href="/dashboard/master/eye-washer">Eye Washer</a>
                    </li>
                    <li class="{{ Request::is('dashboard/master/sling*') ? 'active' : '' }} submenu">
                        <a href="/dashboard/master/sling">Sling</a>
                    </li>
                    <li class="{{ Request::is('dashboard/master/tembin*') ? 'active' : '' }} submenu">
                        <a href="/dashboard/master/tembin">Tembin</a>
                    </li>
                    <li class="{{ Request::is('dashboard/master/chain-block*') ? 'active' : '' }} submenu">
                        <a href="/dashboard/master/chain-block">Chain Block</a>
                    </li>
                    <li class="{{ Request::is('dashboard/master/body-harnest*') ? 'active' : '' }} submenu">
                        <a href="/dashboard/master/body-harnest">Body Harnest</a>
                    </li>
                    <li class="{{ Request::is('dashboard/master/safety-belt*') ? 'active' : '' }} submenu">
                        <a href="/dashboard/master/safety-belt">Safety Belt</a>
                    </li>
                    <li class="{{ Request::is('dashboard/master/facp*') ? 'active' : '' }} submenu">
                        <a href="/dashboard/master/facp">FACP</a>
                    </li>
                    <li class="{{ Request::is('dashboard/master/head-crane*') ? 'active' : '' }} submenu">
                        <a href="/dashboard/master/head-crane">Head Crane</a>
                    </li>
                @endif
            </ul>
        </li>
        <li class="{{ Request::is('dashboard/check-sheet*') ? 'active show' : '' }} menu">
            <a href="#checksheetSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <span style="display: flex; justify-content: space-between; align-items: center;">
                    <i class="bi bi-clipboard2-check-fill"></i> Check Sheet
                    <i class="fas fa-chevron-down"></i>
                </span>
            </a>
            <ul class="collapse list-unstyled {{ Request::is('dashboard/check-sheet*') ? 'show' : '' }}"
                id="checksheetSubmenu">
                @if (Auth::user()->role == 'MTE')
                    <!-- Menampilkan hanya submenu Head Crane untuk peran mte -->
                    <li class="{{ Request::is('dashboard/check-sheet/head-crane*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/check-sheet/head-crane">Head Crane</a>
                    </li>
                @else
                    <li class="{{ Request::is('dashboard/check-sheet/apar*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/check-sheet/apar">Apar</a>
                    </li>
                    <li class="{{ Request::is('dashboard/check-sheet/hydrant*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/check-sheet/hydrant">Hydrant</a>
                    </li>
                    <li class="{{ Request::is('dashboard/check-sheet/nitrogen*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/check-sheet/nitrogen">Nitrogen</a>
                    </li>
                    <li class="{{ Request::is('dashboard/check-sheet/co2*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/check-sheet/co2">Co2</a>
                    </li>
                    <li class="{{ Request::is('dashboard/check-sheet/tandu*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/check-sheet/tandu">Tandu</a>
                    </li>
                    <li class="{{ Request::is('dashboard/check-sheet/eye-washer*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/check-sheet/eye-washer">Eye Washer</a>
                    </li>
                    <li class="{{ Request::is('dashboard/check-sheet/sling*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/check-sheet/sling">Sling</a>
                    </li>
                    <li class="{{ Request::is('dashboard/check-sheet/tembin*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/check-sheet/tembin">Tembin</a>
                    </li>
                    <li class="{{ Request::is('dashboard/check-sheet/chainblock*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/check-sheet/chainblock">Chain Block</a>
                    </li>
                    <li class="{{ Request::is('dashboard/check-sheet/bodyharnest*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/check-sheet/bodyharnest">Body Harnest</a>
                    </li>
                    <li class="{{ Request::is('dashboard/check-sheet/safetybelt*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/check-sheet/safetybelt">Safety Belt</a>
                    </li>
                    <li class="{{ Request::is('dashboard/check-sheet/facp*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/check-sheet/facp">FACP</a>
                    </li>
                    <li class="{{ Request::is('dashboard/check-sheet/head-crane*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/check-sheet/head-crane">Head Crane</a>
                    </li>
                @endif
            </ul>
        </li>
        <li class="{{ Request::is('dashboard/report*') ? 'active show' : '' }}">
            <a href="#reportSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <span style="display: flex; justify-content: space-between; align-items: center;">
                    <i class="bi bi-exclamation-triangle-fill"></i> Report
                    <i class="fas fa-chevron-down"></i>
                </span>
            </a>
            <ul class="collapse list-unstyled {{ Request::is('dashboard/report*') ? 'show' : '' }}"
                id="reportSubmenu">
                @if (Auth::user()->role == 'MTE')
                    <!-- Menampilkan hanya submenu Head Crane untuk peran mte -->
                    <li class="{{ Request::is('dashboard/report/headcrane*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/report/headcrane">Head Crane</a>
                    </li>
                @else
                    <li class="{{ Request::is('dashboard/report/apar*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/report/apar">Apar</a>
                    </li>
                    <li class="{{ Request::is('dashboard/report/hydrant*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/report/hydrant">Hydrant</a>
                    </li>
                    <li class="{{ Request::is('dashboard/report/nitrogen*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/report/nitrogen">Nitrogen</a>
                    </li>
                    <li class="{{ Request::is('dashboard/report/co2*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/report/co2">Co2</a>
                    </li>
                    <li class="{{ Request::is('dashboard/report/tandu*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/report/tandu">Tandu</a>
                    </li>
                    <li class="{{ Request::is('dashboard/report/eyewasher*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/report/eyewasher">Eye Washer</a>
                    </li>
                    <li class="{{ Request::is('dashboard/report/sling*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/report/sling">Sling</a>
                    </li>
                    <li class="{{ Request::is('dashboard/report/tembin*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/report/tembin">Tembin</a>
                    </li>
                    <li class="{{ Request::is('dashboard/report/chainblock*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/report/chainblock">Chain Block</a>
                    </li>
                    <li class="{{ Request::is('dashboard/report/bodyharnest*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/report/bodyharnest">Body Harnest</a>
                    </li>
                    <li class="{{ Request::is('dashboard/report/safetybelt*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/report/safetybelt">Safety Belt</a>
                    </li>
                    <li class="{{ Request::is('dashboard/report/facp*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/report/facp">FACP</a>
                    </li>
                    <li class="{{ Request::is('dashboard/report/headcrane*') ? 'active' : '' }} submenu">
                        <a class="nav-link" href="/dashboard/report/headcrane">Head Crane</a>
                    </li>
                @endif
            </ul>
        </li>
    </ul>
</nav>
