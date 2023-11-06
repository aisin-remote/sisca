@extends('dashboard.app')
@section('title', 'All Nitrogen Report')

@section('content')
    <form class="form-inline mb-5 col-lg-12" method="GET" action="{{ route('home.checksheet.nitrogen') }}">
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
        <h3>All Nitrogen Report</h3>
        <div class="form-group">
            {{-- <form action="{{ route('export.checksheetshydrant') }}" method="POST">
                @method('POST')
                @csrf
                <label for="tahun">Download Check Sheet Apar</label>
                <div class="input-group">
                    <select name="tahun" id="tahun" class="form-control">
                        @php
                            // Inisialisasi array untuk menyimpan tahun-tahun yang tersedia
                            $years = [];

                            // Loop melalui data checksheet apar untuk mendapatkan tahun-tahun unik
                            foreach ($hydrantData as $hydrant) {
                                $year = date('Y', strtotime($hydrant['tanggal_pengecekan']));
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
            </form> --}}
        </div>
    </div>
        <div class="card rounded-bottom-0 mb-0 col-lg-12">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-sm col-lg-12" id="dtBasicExample" style="width: 100%">
                        <thead>
                            <tr class="text-center align-middle">
                                <th rowspan="2">#</th>
                                <th rowspan="2">No Tabung</th>
                                <th rowspan="2">Location</th>
                                <th rowspan="2">Plant</th>
                                <th colspan="12">Month</th>
                            </tr>
                            <tr>
                                @for ($month = 1; $month <= 12; $month++)
                                    <th class="text-center">{{ $month }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nitrogenData as $nitrogen)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $nitrogen['tabung_number'] }}</td>
                                    <td>{{ $nitrogen['location_name'] }}</td>
                                    <td>{{ $nitrogen['plant'] }}</td>
                                    @for ($month = 1; $month <= 12; $month++)
                                        <td>
                                            @if (isset($nitrogen['months'][$month]))
                                                @if (in_array('OK', $nitrogen['months'][$month]))
                                                    <span class="badge bg-success">OK</span>
                                                @else
                                                    @php
                                                        $issueCodes = implode('+', $nitrogen['months'][$month]);
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
                        <td scope="col">1. Indikator System Power</td>
                        <td scope="col">= a</td>
                        <td scope="col">4. Pressure Pilot</td>
                        <td scope="col">= d</td>
                        <td scope="col">7. Pressure No 3</td>
                        <td scope="col">= g</td>
                    </tr>
                    <tr>
                        <td scope="col">2. Selector Mode Automatic</td>
                        <td scope="col">= b</td>
                        <td scope="col">5. Pressure No 1</td>
                        <td scope="col">= e</td>
                        <td scope="col">8. Pressure No 4</td>
                        <td scope="col">= h</td>
                    </tr>
                    <tr>
                        <td scope="col">3. Pintu Tabung</td>
                        <td scope="col">= c</td>
                        <td scope="col">6. Pressure No 2</td>
                        <td scope="col">= f</td>
                        <td scope="col">9. Pressure No 5</td>
                        <td scope="col">= i</td>
                    </tr>
                </tbody>
            </table>
            </div>
            {{-- </div> --}}
        </div>
    </div>

@endsection
