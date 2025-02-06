@extends('dashboard.app')
@section('title', 'All Head Crane Report')

@section('content')
    <form class="form-inline mb-5 col-lg-12" method="GET" action="{{ route('home.checksheet.headcrane') }}">
        <div class="input-group mb-3">
            <label class="input-group-text" for="selected_year">Pilih Tahun:</label>
            <select class="form-select" name="selected_year" id="selected_year">
                <option value="select" selected disabled>Select</option>
                @php
                    $currentYear = date('Y');
                    for ($year = $currentYear - 5; $year <= $currentYear; $year++) {
                        echo "<option value=\"$year\">$year</option>";
                    }
                @endphp
            </select>
        </div>
        <button type="submit" class="btn btn-success ml-2">Tampilkan</button>
    </form>

    @if (request()->has('selected_year'))
        <p class="mt-2">Data untuk tahun {{ request('selected_year') }}</p>
    @endif

    <div class="d-flex justify-content-between flex-wrap flex-lg-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h3>All Head Crane Report</h3>
        <div class="form-group">
            <form action="{{ route('export.checksheetsheadcrane') }}" method="POST">
                @method('POST')
                @csrf
                <label for="tahun">Download Check Sheet HeadCrane</label>
                <div class="input-group">
                    <select name="bulan" id="bulan" class="form-control">
                        @php
                            // Inisialisasi array untuk menyimpan bulan yang tersedia
                            $months = [];
                
                            // Loop melalui data checksheet apar untuk mendapatkan bulan unik
                            foreach ($headcraneData as $headcrane) {
                                $month = date('F', strtotime($headcrane['tanggal_pengecekan'])); // Nama bulan (January, February, dst.)
                                $monthNum = date('m', strtotime($headcrane['tanggal_pengecekan'])); // Angka bulan (01, 02, dst.)
                
                                if (!isset($months[$monthNum])) {
                                    $months[$monthNum] = $month;
                                }
                            }
                
                            // Urutkan bulan berdasarkan angka bulan (terbaru ke terlama)
                            krsort($months);
                
                            // Buat opsi-opsi pada elemen select
                            foreach ($months as $num => $name) {
                                echo "<option value=\"$num\">$name</option>";
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
                            <th rowspan="2">No Head Crane</th>
                            <th colspan="12">Month</th>
                        </tr>
                        <tr>
                            @for ($month = 1; $month <= 12; $month++)
                                <th class="text-center">{{ $month }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($headcraneData as $headcrane)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $headcrane['no_headcrane'] }}</td> <!-- Display the no_headcrane -->
                                @for ($month = 1; $month <= 12; $month++)
                                    <td>
                                        @if (isset($headcrane['months'][$month])) <!-- Check if data exists for this month -->
                                            @foreach ($headcrane['months'][$month] as $itemCheck => $statusCodes)
                                                @if ($statusCodes[0] !== 'OK') <!-- Only display non-OK items -->
                                                    @php
                                                        $issueCodes = implode('+', $statusCodes);
                                                    @endphp
                                                    <span class="badge bg-danger">{{ $issueCodes }}</span>
                                                @endif
                                            @endforeach
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
            <div class="table-responsive">
                <table class="table table-sm table-borderless">
                    <tbody>
                        <tr>
                            <td scope="col">1. Visual Check</td>
                            <td scope="col">= a</td>
                            <td scope="col">5. Down Direction</td>
                            <td scope="col">= e</td>
                            <td scope="col">9. Horn</td>
                            <td scope="col">= i</td>
                        </tr>
                        <tr>
                            <td scope="col">2. Cross Traveling</td>
                            <td scope="col">= b</td>
                            <td scope="col">6. Pendant Hoist</td>
                            <td scope="col">= f</td>
                            <td scope="col">10. Emergency Stop</td>
                            <td scope="col">= j</td>
                        </tr>
                        <tr>
                            <td scope="col">3. Long Traveling</td>
                            <td scope="col">= c</td>
                            <td scope="col">7. Wire Rope / Chain</td>
                            <td scope="col">= g</td>
                        </tr>
                        <tr>
                            <td scope="col">4. Up Direction</td>
                            <td scope="col">= d</td>
                            <td scope="col">8. Block Hook</td>
                            <td scope="col">= h</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

