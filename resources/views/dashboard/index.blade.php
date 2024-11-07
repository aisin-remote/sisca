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
            @if (auth()->user()->role === 'MTE')
                <div class="col-lg-6 mb-3">
                    <div class="card">
                        <div class="card-header text-center" style="background-color: #6d7fcc; color:white;">Head Crane
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="HeadCraneChart" class="img-fluid"></canvas>
                                <!-- Ganti id dengan yang berbeda -->
                            </div>
                        </div>
                    </div>
                </div>
            @else
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
                            <div class="">
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


                <!-- Grafik Tandu -->
                <div class="col-lg-6 mb-3">
                    <div class="card">
                        <div class="card-header text-center" style="background-color: #6d7fcc; color:white;">Tandu</div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="tanduChart" class="img-fluid"></canvas> <!-- Ganti id dengan yang berbeda -->
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Grafik Eyewasher -->
                <div class="col-lg-6 mb-3">
                    <div class="card">
                        <div class="card-header text-center" style="background-color: #6d7fcc; color:white;">Eye Washer
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="eyewasherChart" class="img-fluid"></canvas>
                                <!-- Ganti id dengan yang berbeda -->
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Grafik Sling -->
                <div class="col-lg-6 mb-3">
                    <div class="card">
                        <div class="card-header text-center" style="background-color: #6d7fcc; color:white;">Sling</div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="slingChart" class="img-fluid"></canvas> <!-- Ganti id dengan yang berbeda -->
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Grafik Tembin -->
                <div class="col-lg-6 mb-3">
                    <div class="card">
                        <div class="card-header text-center" style="background-color: #6d7fcc; color:white;">Tembin</div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="tembinChart" class="img-fluid"></canvas> <!-- Ganti id dengan yang berbeda -->
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Grafik Chain Block -->
                <div class="col-lg-6 mb-3">
                    <div class="card">
                        <div class="card-header text-center" style="background-color: #6d7fcc; color:white;">Chain Block
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="chainblockChart" class="img-fluid"></canvas>
                                <!-- Ganti id dengan yang berbeda -->
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Grafik Body Harnest -->
                <div class="col-lg-6 mb-3">
                    <div class="card">
                        <div class="card-header text-center" style="background-color: #6d7fcc; color:white;">Body Harnest
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="bodyharnestChart" class="img-fluid"></canvas>
                                <!-- Ganti id dengan yang berbeda -->
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Grafik Safety Belt -->
                <div class="col-lg-6 mb-3">
                    <div class="card">
                        <div class="card-header text-center" style="background-color: #6d7fcc; color:white;">Safety Belt
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="safetybeltChart" class="img-fluid"></canvas>
                                <!-- Ganti id dengan yang berbeda -->
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Grafik FACP -->
                <div class="col-lg-6 mb-3">
                    <div class="card">
                        <div class="card-header text-center" style="background-color: #6d7fcc; color:white;">FACP</div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="facpChart" class="img-fluid"></canvas> <!-- Ganti id dengan yang berbeda -->
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Grafik Head Crane -->
                <div class="col-lg-6 mb-3">
                    <div class="card">
                        <div class="card-header text-center" style="background-color: #6d7fcc; color:white;">Head Crane
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="HeadCraneChart" class="img-fluid"></canvas>
                                <!-- Ganti id dengan yang berbeda -->
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>


    @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'User')
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



            // Grafik Tandu


            var ctxTandu = document.getElementById('tanduChart').getContext('2d'); // Ganti id dengan yang sesuai
            var tanduChart = new Chart(ctxTandu, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($data_Tandu['labels']) !!},
                    datasets: [{
                        label: 'OK',
                        data: {!! json_encode($data_Tandu['okData_Tandu']) !!},
                        backgroundColor: 'rgba(0, 204, 68, 1)',
                        borderColor: 'rgba(0, 131, 51, 1)',
                        borderWidth: 1
                    }, {
                        label: 'NG',
                        data: {!! json_encode($data_Tandu['notOkData_Tandu']) !!},
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



            // Grafik Eyewasher


            var ctxEyewasher = document.getElementById('eyewasherChart').getContext('2d'); // Ganti id dengan yang sesuai
            var eyewasherChart = new Chart(ctxEyewasher, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($data_Eyewasher['labels']) !!},
                    datasets: [{
                        label: 'OK',
                        data: {!! json_encode($data_Eyewasher['okData_Eyewasher']) !!},
                        backgroundColor: 'rgba(0, 204, 68, 1)',
                        borderColor: 'rgba(0, 131, 51, 1)',
                        borderWidth: 1
                    }, {
                        label: 'NG',
                        data: {!! json_encode($data_Eyewasher['notOkData_Eyewasher']) !!},
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



            // Grafik Sling


            var ctxSling = document.getElementById('slingChart').getContext('2d'); // Ganti id dengan yang sesuai
            var slingChart = new Chart(ctxSling, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($data_Sling['labels']) !!},
                    datasets: [{
                        label: 'OK',
                        data: {!! json_encode($data_Sling['okData_Sling']) !!},
                        backgroundColor: 'rgba(0, 204, 68, 1)',
                        borderColor: 'rgba(0, 131, 51, 1)',
                        borderWidth: 1
                    }, {
                        label: 'NG',
                        data: {!! json_encode($data_Sling['notOkData_Sling']) !!},
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



            // Grafik Tembin


            var ctxTembin = document.getElementById('tembinChart').getContext('2d'); // Ganti id dengan yang sesuai
            var tembinChart = new Chart(ctxTembin, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($data_Tembin['labels']) !!},
                    datasets: [{
                        label: 'OK',
                        data: {!! json_encode($data_Tembin['okData_Tembin']) !!},
                        backgroundColor: 'rgba(0, 204, 68, 1)',
                        borderColor: 'rgba(0, 131, 51, 1)',
                        borderWidth: 1
                    }, {
                        label: 'NG',
                        data: {!! json_encode($data_Tembin['notOkData_Tembin']) !!},
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



            // Grafik Chain Block


            var ctxChainblock = document.getElementById('chainblockChart').getContext('2d'); // Ganti id dengan yang sesuai
            var chainblockChart = new Chart(ctxChainblock, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($data_Chainblock['labels']) !!},
                    datasets: [{
                        label: 'OK',
                        data: {!! json_encode($data_Chainblock['okData_Chainblock']) !!},
                        backgroundColor: 'rgba(0, 204, 68, 1)',
                        borderColor: 'rgba(0, 131, 51, 1)',
                        borderWidth: 1
                    }, {
                        label: 'NG',
                        data: {!! json_encode($data_Chainblock['notOkData_Chainblock']) !!},
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



            // Grafik Body Harnest


            var ctxBodyharnest = document.getElementById('bodyharnestChart').getContext('2d'); // Ganti id dengan yang sesuai
            var bodyharnestChart = new Chart(ctxBodyharnest, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($data_Bodyharnest['labels']) !!},
                    datasets: [{
                        label: 'OK',
                        data: {!! json_encode($data_Bodyharnest['okData_Bodyharnest']) !!},
                        backgroundColor: 'rgba(0, 204, 68, 1)',
                        borderColor: 'rgba(0, 131, 51, 1)',
                        borderWidth: 1
                    }, {
                        label: 'NG',
                        data: {!! json_encode($data_Bodyharnest['notOkData_Bodyharnest']) !!},
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



            // Grafik Safety Belt


            var ctxSafetybelt = document.getElementById('safetybeltChart').getContext('2d'); // Ganti id dengan yang sesuai
            var safetybeltChart = new Chart(ctxSafetybelt, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($data_Safetybelt['labels']) !!},
                    datasets: [{
                        label: 'OK',
                        data: {!! json_encode($data_Safetybelt['okData_Safetybelt']) !!},
                        backgroundColor: 'rgba(0, 204, 68, 1)',
                        borderColor: 'rgba(0, 131, 51, 1)',
                        borderWidth: 1
                    }, {
                        label: 'NG',
                        data: {!! json_encode($data_Safetybelt['notOkData_Safetybelt']) !!},
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

            // Grafik HeadCrane

            var ctxHeadCrane = document.getElementById('HeadCraneChart').getContext('2d'); // Ganti id dengan yang sesuai
            var HeadCraneChart = new Chart(ctxHeadCrane, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($data_HeadCrane['labels']) !!},
                    datasets: [{
                        label: 'OK',
                        data: {!! json_encode($data_HeadCrane['okData_HeadCrane']) !!},
                        backgroundColor: 'rgba(0, 204, 68, 1)',
                        borderColor: 'rgba(0, 131, 51, 1)',
                        borderWidth: 1
                    }, {
                        label: 'NG',
                        data: {!! json_encode($data_HeadCrane['notOkData_HeadCrane']) !!},
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

            // Grafik FACP


            var ctxFacp = document.getElementById('facpChart').getContext('2d');
            var facpChart = new Chart(ctxFacp, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($data_Facp['labels']) !!},
                    datasets: [{
                            label: 'OK Smoke Detector',
                            data: {!! json_encode($data_Facp['okData_Smoke_detector']) !!},
                            backgroundColor: 'rgba(0, 204, 68, 1)',
                            borderColor: 'rgba(0, 131, 51, 1)',
                            stack: 'Stack 0',
                        },
                        {
                            label: 'NG Smoke Detector',
                            data: {!! json_encode($data_Facp['notOkData_Smoke_detector']) !!},
                            backgroundColor: 'rgba(255, 0, 0, 0.5)',
                            borderColor: 'rgba(139, 0, 0, 1)',
                            stack: 'Stack 0',
                        },
                        {
                            label: 'OK Heat Detector',
                            data: {!! json_encode($data_Facp['okData_Heat_detector']) !!},
                            backgroundColor: 'rgba(0, 204, 68, 1)',
                            borderColor: 'rgba(0, 131, 51, 1)',
                            stack: 'Stack 1',
                        },
                        {
                            label: 'NG Heat Detector',
                            data: {!! json_encode($data_Facp['notOkData_Heat_detector']) !!},
                            backgroundColor: 'rgba(255, 0, 0, 0.5)',
                            borderColor: 'rgba(139, 0, 0, 1)',
                            stack: 'Stack 1',
                        },
                        {
                            label: 'OK Beam Detector',
                            data: {!! json_encode($data_Facp['okData_Beam_detector']) !!},
                            backgroundColor: 'rgba(0, 204, 68, 1)',
                            borderColor: 'rgba(0, 131, 51, 1)',
                            stack: 'Stack 2',
                        },
                        {
                            label: 'NG Beam Detector',
                            data: {!! json_encode($data_Facp['notOkData_Beam_detector']) !!},
                            backgroundColor: 'rgba(255, 0, 0, 0.5)',
                            borderColor: 'rgba(139, 0, 0, 1)',
                            stack: 'Stack 2',
                        },
                        {
                            label: 'OK Push Button',
                            data: {!! json_encode($data_Facp['okData_Push_button']) !!},
                            backgroundColor: 'rgba(0, 204, 68, 1)',
                            borderColor: 'rgba(0, 131, 51, 1)',
                            stack: 'Stack 3',
                        },
                        {
                            label: 'NG Push Button',
                            data: {!! json_encode($data_Facp['notOkData_Push_button']) !!},
                            backgroundColor: 'rgba(255, 0, 0, 0.5)',
                            borderColor: 'rgba(139, 0, 0, 1)',
                            stack: 'Stack 3',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    interaction: {
                        intersect: false,
                    },
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: true, // Matikan tampilan otomatis legenda
                            position: 'top',
                            labels: {
                                // Fungsi callback untuk menampilkan legenda sesuai kebutuhan
                                generateLabels: function(chart) {
                                    return [{
                                            text: 'OK',
                                            fillStyle: 'rgba(0, 204, 68, 1)',
                                            strokeStyle: 'rgba(0, 131, 51, 1)'
                                        },
                                        {
                                            text: 'NG',
                                            fillStyle: 'rgba(255, 0, 0, 0.5)',
                                            strokeStyle: 'rgba(139, 0, 0, 1)'
                                        }
                                    ];
                                }
                            }
                        }
                    }
                }
            });
        </script>
    @else
        <script>
            // Grafik HeadCrane

            var ctxHeadCrane = document.getElementById('HeadCraneChart').getContext('2d'); // Ganti id dengan yang sesuai
            var HeadCraneChart = new Chart(ctxHeadCrane, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($data_HeadCrane['labels']) !!},
                    datasets: [{
                        label: 'OK',
                        data: {!! json_encode($data_HeadCrane['okData_HeadCrane']) !!},
                        backgroundColor: 'rgba(0, 204, 68, 1)',
                        borderColor: 'rgba(0, 131, 51, 1)',
                        borderWidth: 1
                    }, {
                        label: 'NG',
                        data: {!! json_encode($data_HeadCrane['notOkData_HeadCrane']) !!},
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
    @endif
    {{-- @if (Auth::user()->role == 'MTE')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const today = new Date().toISOString().substr(0, 10);
                document.getElementById('tanggal_pengecekan').value = today;
            });
        </script>
    @endif --}}

@endsection
