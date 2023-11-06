@extends('dashboard.app')
@section('title', 'All FACP Report')

@section('content')
    <form class="form-inline mb-5 col-lg-12" method="GET" action="{{ route('home.checksheet.facp') }}">
        <div class="input-group mb-3">
            <label class="input-group-text" for="selected_year">Pilih Tahun:</label>
            <select class="form-select" name="selected_year" id="selected_year">
                <option value="select" selected disabled>Select</option>
                @php
                    $currentYear = date('Y');
                    for ($year = $currentYear - 5; $year <= $currentYear; $year++) {
                        echo "<option value=\" $year\">$year</option>";
                    }
                @endphp
            </select>
        </div>
        <button type="submit" class="btn btn-success ml-2">Tampilkan</button>
    </form>

    @if (request()->has('selected_year'))
        <p class="mt-2">Data untuk tahun {{ request('selected_year') }}</p>
    @endif

    <div
        class="d-flex justify-content-between flex-wrap flex-lg-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h3>All FACP Report</h3>
        <div class="form-group">
            <form action="{{ route('export.checksheetsfacp') }}" method="POST">
                @method('POST')
                @csrf
                <label for="tahun">Download Check Sheet FACP</label>
                <div class="input-group">
                    <select name="tahun" id="tahun" class="form-control">
                        @php
                            // Inisialisasi array untuk menyimpan tahun-tahun yang tersedia
                            $years = [];

                            // Loop melalui data checksheet apar untuk mendapatkan tahun-tahun unik
                            foreach ($facpData as $facp) {
                                $year = date('Y', strtotime($facp['tanggal_pengecekan']));
                                if (!in_array($year, $years)) {
                                    $years[] = $year;
                                }
                            }

                            // Urutkan tahun-tahun dalam urutan terbalik (terbaru ke terlama)
                            rsort($years);

                            // Buat opsi-opsi pada elemen select
                            foreach ($years as $year) {
                                echo "<option value=\"$year\">$year</option>";
                            }
                        @endphp
                    </select>
                    <button class="btn btn-primary" id="filterButton">Download</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card rounded-bottom-0 mb-0 col-lg-12">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-sm col-lg-12" id="dtBasicExample" style="width: 100%">
                    <thead>
                        <tr class="text-center align-middle">
                            <th rowspan="2">#</th>
                            <th rowspan="2">No Zona</th>
                            <th colspan="12">Month</th>
                        </tr>
                        <tr>
                            @for ($month = 1; $month <= 12; $month++)
                                <th class="text-center">{{ $month }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($facpData as $facp)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $facp['zona_number'] }}</td>
                                @for ($month = 1; $month <= 12; $month++)
                                    <td>
                                        @if (isset($facp['months'][$month]))
                                            @if (in_array('OK', $facp['months'][$month]))
                                                <span class="badge bg-success">OK</span>
                                            @else
                                                @php
                                                    $issueCodes = implode('+', $facp['months'][$month]);
                                                @endphp
                                                <span class="badge bg-danger">{{ $issueCodes }}</span>
                                            @endif
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="card rounded-top-0 mt-0 col-lg-12">
        <div class="card-body">
            <p class="card-title"><strong>Keterangan Kerusakan:</strong></p>
            {{-- <div class="container"> --}}
            <div class="table-responsive">
                <table class="table table-sm table-borderless">
                    <tbody>
                        <tr>
                            <td scope="col">1. Smoke Detector</td>
                            <td scope="col">= a</td>
                            <td scope="col">3. Beam Detector</td>
                            <td scope="col">= c</td>
                        </tr>
                        <tr>
                            <td scope="col">2. Heat Detector</td>
                            <td scope="col">= b</td>
                            <td scope="col">4. Push Button</td>
                            <td scope="col">= d</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- </div> --}}
        </div>
    </div>

@endsection
