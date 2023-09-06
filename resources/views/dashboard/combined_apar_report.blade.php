@extends('dashboard.app')
@section('title', 'All APAR Report')

@section('content')
<div class="container">
    <div>
        <form class="form-inline" method="GET" action="{{ route('home.checksheet.apar') }}">
            <div class="input-group mb-3">
                <label class="input-group-text" for="selected_year">Pilih Tahun:</label>
                <select class="form-select" name="selected_year" id="selected_year">
                    <option value="select" selected disabled>Select</option>
                    @php
                    $currentYear = date('Y');
                    for ($year = $currentYear - 5; $year <= $currentYear; $year++) { echo "<option value=\" $year\">$year</option>";
                        }
                        @endphp
                </select>
            </div>
            <button type="submit" class="btn btn-success ml-2">Tampilkan</button>
        </form>

        @if(request()->has('selected_year'))
        <p class="mt-2">Data untuk tahun {{ request('selected_year') }}</p>
        @endif
    </div>

    <br>
    <hr>

    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 col-lg-12">
        <h3>All APAR Report</h3>
        <div class="form-group">
            <form action="{{ route('export.checksheetsapar') }}" method="POST">
                @method('POST')
                @csrf
                <label for="tahun">Download Check Sheet Apar</label>
                <div class="input-group">
                    <select name="tahun" id="tahun" class="form-control">
                        @php
                        $currentYear = date('Y');
                        for ($year = $currentYear - 5; $year <= $currentYear; $year++) { echo "<option value=\" $year\">$year</option>";
                            }
                            @endphp
                    </select>
                    <button class="btn btn-primary" id="filterButton">Download</button>
                </div>
            </form>
        </div>

        {{-- <form action="{{ route('apar.show', $apar->id) }}" method="GET">
            <label for="tanggal_filter">Filter Tanggal:</label>
            <input type="date" name="tanggal_filter" id="tanggal_filter">
            <button type="submit" class="btn btn-primary">Filter</button>
        </form> --}}

    </div>
    <table class="text-center table table-striped">
        <thead class="align-middle">
            <tr>
                <th rowspan="2">Tag Number</th>
                <th rowspan="2">Type</th>
                <th rowspan="2">Location</th>
                <th colspan="12">Month</th>
            </tr>
            <tr>
                @for ($month = 1; $month <= 12; $month++) <th>{{ $month }}</th>
                    @endfor
            </tr>
        </thead>
        <tbody>
            @foreach ($aparData as $apar)
            <tr>
                <td>{{ $apar['apar_number'] }}</td>
                <td>{{ $apar['type'] }}</td>
                <td>{{ $apar['location_name'] }}</td>
                @for ($month = 1; $month <= 12; $month++) <td>
                    @if (isset($apar['months'][$month]))
                    @if (in_array('OK', $apar['months'][$month]))
                    <span class="badge bg-success">OK</span>
                    @else
                    @php
                    $issueCodes = implode('+', $apar['months'][$month]);
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
    <div class="card">
        <div class="card-body">
          <p class="card-title"><strong>Keterangan Kerusakan:</strong></p>
          <div class="container">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <td scope="col">1. Pressure</td>
                            <td scope="col">= a</td>
                            <td scope="col"></td>
                            <td scope="col">4. Tabung</td>
                            <td scope="col">= d</td>
                            <td scope="col"></td>
                            <td scope="col">7. Kadar Konsentrat</td>
                            <td scope="col">= g</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="col">2. Lock Pin</td>
                            <td scope="col">= b</td>
                            <td scope="col"></td>
                            <td scope="col">5. Corong/Nozzle</td>
                            <td scope="col">= e</td>
                            <td scope="col"></td>
                            <td scope="col">8. Berat APAR</td>
                            <td scope="col">= H</td>
                        </tr>
                        <tr>
                            <td scope="col">3. Regulator</td>
                            <td scope="col">= c</td>
                            <td scope="col"></td>
                            <td scope="col">6. Hose</td>
                            <td scope="col">= f</td>
                            <td scope="col"></td>
                            <td scope="col">9. Isi Ulang</td>
                            <td scope="col">= a+b</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
      </div>
</div>
@endsection
