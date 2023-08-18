@extends('dashboard.app')
@section('title', 'Home')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Grafik Status</h1>
            <div class="btn-group">
                <button type="button" class="btn btn-success dropdown-toggle caret-none" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Pilih Tahun
                </button>
                <div class="dropdown-menu">
                    @foreach ($availableYears as $year)
                        <a class="dropdown-item"
                            href="{{ route('dashboard.index', ['year' => $year]) }}">{{ $year }}</a>
                    @endforeach
                </div>
            </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-header" style="background-color: #6d7fcc; color:white;">Apar</div>
                <div class="card-body">
                    <div class="chart-container my-0" style="position: relative; height: 400px;">
                        <canvas id="barChart" class="img-fluid my-0"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Skrip JavaScript Chart.js di sini
    </script>



    <script>
        var ctx = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($data['labels']) !!},
                datasets: [{
                    label: 'OK',
                    data: {!! json_encode($data['okData']) !!},
                    backgroundColor: 'rgba(0, 204, 68, 1)',
                    borderColor: 'rgba(0, 131, 51, 1)',
                    borderWidth: 1
                }, {
                    label: 'NG',
                    data: {!! json_encode($data['notOkData']) !!},
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'top' // Atur posisi keterangan (legend)
                    }
                }
            }
        });
    </script>

@endsection
