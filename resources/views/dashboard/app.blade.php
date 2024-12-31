<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PT AIIA | @yield('title')</title>

    <!-- Logo only -->
    <link rel="icon" href="/foto/aii.ico">

    {{-- CSS & JS Bootstrap --}}
    <link href="{{ asset('dist/css/bootstrap.min.css') }}" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="{{ asset('dist/js/bootstrap.bundle.min.js') }}"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="{{ asset('dist/css/bootstrap-icons.css') }}">


    {{-- CSS & JS Self --}}
    <link rel="stylesheet" href="/css/style1.css">
    <script src="/js/script.js"></script>

    <!-- Font Awesome JS -->
    <script defer src="{{ asset('dist/js/solid.js') }}"
        integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous">
    </script>
    <script defer src="{{ asset('dist/js/fontawesome.js') }}"
        integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous">
    </script>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="{{ asset('dist/js/jquery-3.3.1.slim.min.js') }}"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <!-- Popper.JS -->
    <script src="{{ asset('dist/js/popper.min.js') }}"
        integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous">
    </script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('dist/js/bootstrap.min.js') }}"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous">
    </script>
    {{-- Chart JS --}}
    <script src="{{ asset('dist/js/chart.js') }}"></script>

    {{-- ajax JS --}}
    <script src="{{ asset('dist/js/webcam.min.js') }}"></script>

    {{-- Data Table --}}
    <!-- File CSS -->
    <link rel="stylesheet" href="{{ asset('dist/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/responsive.bootstrap4.min.css') }}">

    <!-- File JavaScript -->
    <script src="{{ asset('dist/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dist/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dist/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dist/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- Feather Icons -->
    <script src="{{ asset('dist/js/feather.min.js') }}"></script>



</head>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <x-dashboard.sidebar />

        <!-- Navbar  -->
        <div id="content">
            <x-dashboard.navbar />

            @yield('content')
            <button id="scrollToTopBtn">
                <i class="bi bi-arrow-up"></i>
            </button>
        </div>
        {{-- Footer --}}
        <x-dashboard.footer />
    </div>

    <script>
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
                $('#content').toggleClass('active');
                $('#footer').toggleClass('active')
                $('body').toggleClass('sidebar-active'); // Tambahkan ini
            });
        });

        // test
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().substr(0, 10);
            document.getElementById('tanggal_pengecekan').value = today;
        });

        function previewImage(inputId, previewClass) {
            const image = document.querySelector(`#${inputId}`);
            const imgPreview = document.querySelector(`.${previewClass}`);

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        document.getElementById('scrollToTopBtn').addEventListener('click', function() {
            // Scroll kembali ke atas halaman
            window.scrollTo({
                top: 0,
                behavior: 'smooth' // Gunakan 'smooth' untuk animasi scroll
            });
        });

        function zoom(e) {
            var zoomer = e.currentTarget;
            e.offsetX ? offsetX = e.offsetX : offsetX = e.touches[0].pageX
            e.offsetY ? offsetY = e.offsetY : offsetX = e.touches[0].pageX
            x = offsetX / zoomer.offsetWidth * 100
            y = offsetY / zoomer.offsetHeight * 100
            zoomer.style.backgroundPosition = x + '% ' + y + '%';
        }

        $(document).ready(function() {
            var table = $('#dtBasicExample').DataTable();
        });

        feather.replace();
    </script>
</body>

</html>
