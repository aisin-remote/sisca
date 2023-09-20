@extends('dashboard.app')
@section('title', 'Home')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Dashboard</h1>
        <div class="btn-group">
            <button type="button" class="btn btn-success dropdown-toggle caret-none" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                Pilih Tahun
            </button>
            <div class="dropdown-menu">
                @foreach ($availableYears as $year)
                    <a class="dropdown-item" href="{{ route('dashboard.index', ['year' => $year]) }}">{{ $year }}</a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="row">

            <!-- Grafik Apar -->
            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header text-center" style="background-color: #6d7fcc; color:white;">Apar</div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="barChart" class="img-fluid"></canvas>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Grafik Hydrant -->
            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header text-center" style="background-color: #6d7fcc; color:white;">Hydrant</div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="hydrantChart" class="img-fluid"></canvas> <!-- Ganti id dengan yang berbeda -->
                        </div>
                    </div>
                </div>
            </div>


            <!-- Grafik Nitrogen -->
            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header text-center" style="background-color: #6d7fcc; color:white;">Nitrogen</div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="nitrogenChart" class="img-fluid"></canvas> <!-- Ganti id dengan yang berbeda -->
                        </div>
                    </div>
                </div>
            </div>


            <!-- Grafik Co2 -->
            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header text-center" style="background-color: #6d7fcc; color:white;">Co2</div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="co2Chart" class="img-fluid"></canvas> <!-- Ganti id dengan yang berbeda -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <script>
        // Grafik Apar


        var ctx = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($data_Apar['labels']) !!},
                datasets: [{
                    label: 'OK',
                    data: {!! json_encode($data_Apar['okData_Apar']) !!},
                    backgroundColor: 'rgba(0, 204, 68, 1)',
                    borderColor: 'rgba(0, 131, 51, 1)',
                    borderWidth: 1
                }, {
                    label: 'NG',
                    data: {!! json_encode($data_Apar['notOkData_Apar']) !!},
                    backgroundColor: 'rgba(255, 0, 0, 0.5)',
                    borderColor: 'rgba(139, 0, 0, 1)',
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



        // Grafik Hydrant


        var ctxHydrant = document.getElementById('hydrantChart').getContext('2d'); // Ganti id dengan yang sesuai
        var hydrantChart = new Chart(ctxHydrant, {
            type: 'bar',
            data: {
                labels: {!! json_encode($data_Hydrant['labels']) !!},
                datasets: [{
                    label: 'OK',
                    data: {!! json_encode($data_Hydrant['okData_Hydrant']) !!},
                    backgroundColor: 'rgba(0, 204, 68, 1)',
                    borderColor: 'rgba(0, 131, 51, 1)',
                    borderWidth: 1
                }, {
                    label: 'NG',
                    data: {!! json_encode($data_Hydrant['notOkData_Hydrant']) !!},
                    backgroundColor: 'rgba(255, 0, 0, 0.5)',
                    borderColor: 'rgba(139, 0, 0, 1)',
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



        // Grafik Nitrogen


        var ctxNitrogen = document.getElementById('nitrogenChart').getContext('2d'); // Ganti id dengan yang sesuai
        var nitrogenChart = new Chart(ctxNitrogen, {
            type: 'bar',
            data: {
                labels: {!! json_encode($data_Nitrogen['labels']) !!},
                datasets: [{
                    label: 'OK',
                    data: {!! json_encode($data_Nitrogen['okData_Nitrogen']) !!},
                    backgroundColor: 'rgba(0, 204, 68, 1)',
                    borderColor: 'rgba(0, 131, 51, 1)',
                    borderWidth: 1
                }, {
                    label: 'NG',
                    data: {!! json_encode($data_Nitrogen['notOkData_Nitrogen']) !!},
                    backgroundColor: 'rgba(255, 0, 0, 0.5)',
                    borderColor: 'rgba(139, 0, 0, 1)',
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



        // Grafik Co2


        var ctxCo2 = document.getElementById('co2Chart').getContext('2d'); // Ganti id dengan yang sesuai
        var co2Chart = new Chart(ctxCo2, {
            type: 'bar',
            data: {
                labels: {!! json_encode($data_Tabungco2['labels']) !!},
                datasets: [{
                    label: 'OK',
                    data: {!! json_encode($data_Tabungco2['okData_Tabungco2']) !!},
                    backgroundColor: 'rgba(0, 204, 68, 1)',
                    borderColor: 'rgba(0, 131, 51, 1)',
                    borderWidth: 1
                }, {
                    label: 'NG',
                    data: {!! json_encode($data_Tabungco2['notOkData_Tabungco2']) !!},
                    backgroundColor: 'rgba(255, 0, 0, 0.5)',
                    borderColor: 'rgba(139, 0, 0, 1)',
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
