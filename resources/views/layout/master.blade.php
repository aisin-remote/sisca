<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PT Aisin Indonesia | @yield('title')</title>

    <!-- Text Poppins -->
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

    <!-- Logo only -->
    <link rel="icon" href="https://www.aisinindonesia.co.id/asset/img/aii.ico">

    <!-- CSS & JS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

    <!-- CSS-->
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-md" style="background-color: #FCFCFC;">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="https://www.aisinindonesia.co.id/assetweb/image/logo/aisin-indonesia-logo.svg" alt="">
            </a>
            <div class="position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <button class="navbar-toggler position-absolute end-0 me-3"type="button" data-bs-toggle="collapse"
                        data-bs-target="#btn">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
            </div>
            <div class="collapse navbar-collapse justify-content-center" id="btn">
                <ul class="navbar-nav ms-auto">

                    @auth
                        <li class="nav-item">
                            <a class="nav-link mx-2" href="/"><i class="bi bi-info-square"></i> Informasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-2" href="/"><i class="bi bi-bezier"></i> Jenis</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-2" href="/"><i class="bi bi-app-indicator"></i> Fungsi</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Hallo! {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/dashboard" style="font-size: 14px"><i class="bi bi-layout-text-sidebar-reverse"></i> Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="/logout" method="POST">
                                        @csrf
                                        <button type="submit" style="font-size: 14px;" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>

                    @else
                        <li class="nav-item">
                            <a class="nav-link mx-2" href="/"><i class="bi bi-info-square"></i> Informasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-2" href="/"><i class="bi bi-bezier"></i> Jenis</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-2" href="/"><i class="bi bi-app-indicator"></i> Fungsi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-2" href="/login"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                        </li>

                    @endauth

                </ul>
            </div>
        </div>
    </nav>

    <div class="container pt-4 bg-white">
        <div class="row">
            <div class="col-lg-12">
                @yield('content')
            </div>
        </div>
    </div>

    <button id="scrollToTopBtn">
        <i class="bi bi-chevron-up"></i>
    </button>

    <!-- JavaScript link -->
    <script src="/js/script.js"></script>

    <!-- Link ke JS Bootstrap (Popper.js dan jQuery) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
