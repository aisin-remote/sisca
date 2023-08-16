<!-- Page Content  -->
<div id="content">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">

            <button type="button" id="sidebarCollapse" class="btn btn-info">
                <i class="fas fa-align-left"></i>
                <span>ON/OFF Sidebar</span>
            </button>
            {{-- <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-align-justify"></i>
            </button> --}}
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" style="font-size: 14px;" class="btn aktif rounded border-0 mx-auto">Logout</button>
            </form>
        </div>
    </nav>
