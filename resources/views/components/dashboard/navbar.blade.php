
<!-- Page Content  -->
<div style="margin-left: 0px" class="content">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">

            <button type="button" id="sidebarCollapse" class="btn btn-info">
                <i class="fas fa-align-left"></i>
            </button>
            {{-- <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-align-justify"></i>
            </button> --}}
            <div class="btn-group">
                <form action="/logout" method="POST">
                    @csrf
                    <button type="button" class="btn aktif rounded border-0 mx-auto dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-person me-2"></i>Hallo! {{ auth()->user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="/dashboard/profile">Profile</a>
                        </li>
                        <li>
                            <button type="submit" class="dropdown-item" style="font-size: 14px;">Logout</button>
                        </li>
                    </ul>
                </form>
            </div>


        </div>
    </nav>
