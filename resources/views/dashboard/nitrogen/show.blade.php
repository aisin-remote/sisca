@extends('dashboard.app')
@section('title', 'Data Nitrogen')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Info Nitrogen</h1>
        @can('admin')
            <a href="{{ route('nitrogen.edit', $nitrogen->id) }}" class="btn btn-warning">Edit</a>
        @endcan
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-12">
            {{ session()->get('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger col-lg-12">
            {{ session()->get('error') }}
        </div>
    @endif
    <div class="card col-lg-6 mb-4">
        <div class="card-body">
            <div class="row">
                <div class="h6 col-3">Nama</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $nitrogen->no_tabung }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Location</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $nitrogen->locations->location_name }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Plant</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $nitrogen->plant }}</div>
            </div>
        </div>
    </div>
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Riwayat Check Sheet Nitrogen</h1>
        <div class="form-group">
            <form action="{{ route('nitrogen.show', $nitrogen->id) }}" method="GET">
                <label for="tahun_filter">Filter Tahun:</label>
                <div class="input-group">
                    <select name="tahun_filter" id="tahun_filter" class="form-control">
                        @for ($year = $firstYear; $year <= $lastYear; $year++)
                            <option value="{{ $year }}" {{ request('tahun_filter') == $year ? 'selected' : '' }}>
                                {{ $year }}</option>
                        @endfor
                    </select>
                    <button class="btn btn-success" id="filterButton">Filter</button>
                </div>
            </form>
        </div>

    </div>
    <form action="{{ route('export.checksheetsnitrogen') }}" method="POST" class="col-md-6 mb-3">
        @method('POST')
        @csrf
        <div class="form-group mb-3">
            <label for="tahun">Download Checksheet Nitrogen</label>
            <select name="tahun" id="tahun" class="form-control" required>
                @for ($year = $firstYear; $year <= $lastYear; $year++)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
            <!-- Tambahkan input hidden untuk no_tabung -->
            <input type="hidden" name="tabung_number" value="{{ $nitrogen->no_tabung }}">
        </div>
        <button type="submit" class="btn btn-primary"><i class="bi bi-download"></i> | Download</button>
    </form>

    @if (session()->has('success1'))
        <div class="mt-2 alert alert-success col-lg-12">
            {{ session()->get('success1') }}
        </div>
    @endif
    <div class="card">
        <div class="card-table">
            <div class="table-responsive col-lg-12 mt-3">
                <table class="table table-striped table-sm" id="dtBasicExample">
                    <thead>
                        <tr>
                            <th rowspan="2" scope="col" class="text-center align-middle">#</th>
                            <th rowspan="2" scope="col" class="text-center align-middle">Tanggal</th>
                            <th rowspan="2" scope="col" class="text-center align-middle">No Tabung</th>
                            <th colspan="9" scope="colgroup" class="text-center">Item Check</th>
                            <th rowspan="2" scope="col" class="text-center align-middle">Aksi</th>
                        </tr>
                        <tr>
                            <th class="text-center align-middle">Indikator System Power</th>
                            <th class="text-center align-middle">Selector Mode Automatic</th>
                            <th class="text-center align-middle">Pintu Tabung</th>
                            <th class="text-center align-middle">Pressure Tabung Pilot Nitrogen</th>
                            <th class="text-center align-middle">Pressure Tabung Nitrogen No 1</th>
                            <th class="text-center align-middle">Pressure Tabung Nitrogen No 2</th>
                            <th class="text-center align-middle">Pressure Tabung Nitrogen No 3</th>
                            <th class="text-center align-middle">Pressure Tabung Nitrogen No 4</th>
                            <th class="text-center align-middle">Pressure Tabung Nitrogen No 5</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheets as $checksheet)
                            <tr class="align-middle">
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="text-center align-middle">
                                    {{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                <td class="text-center align-middle">{{ $checksheet->tabung_number }}</td>

                                @if ($checksheet->operasional === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->operasional }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->operasional }}</td>
                                @endif

                                @if ($checksheet->selector_mode === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->selector_mode }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->selector_mode }}</td>
                                @endif

                                @if ($checksheet->pintu_tabung === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->pintu_tabung }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->pintu_tabung }}</td>
                                @endif

                                @if ($checksheet->pressure_pilot === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->pressure_pilot }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->pressure_pilot }}</td>
                                @endif

                                @if ($checksheet->pressure_no1 === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->pressure_no1 }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->pressure_no1 }}</td>
                                @endif

                                @if ($checksheet->pressure_no2 === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->pressure_no2 }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->pressure_no2 }}</td>
                                @endif

                                @if ($checksheet->pressure_no3 === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->pressure_no3 }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->pressure_no3 }}</td>
                                @endif

                                @if ($checksheet->pressure_no4 === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->pressure_no4 }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->pressure_no4 }}</td>
                                @endif

                                @if ($checksheet->pressure_no5 === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->pressure_no5 }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->pressure_no5 }}</td>
                                @endif

                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('nitrogen.checksheetnitrogen.show', $checksheet->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        @can('admin')
                                            <a href="{{ route('nitrogen.checksheetnitrogen.edit', $checksheet->id) }}"
                                                class="badge bg-warning me-2">Edit</a>
                                            <form action="{{ route('nitrogen.checksheetnitrogen.destroy', $checksheet->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge bg-danger border-0"
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet Nitrogen?')">Delete</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <td colspan="13">Tidak ada data...</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script>
        document.getElementById('filterButton').addEventListener('click', function() {
            var selectedDate = document.getElementById('filterDate').value;
            // Lakukan sesuatu dengan tanggal yang dipilih, misalnya memicu filter
            console.log('Tanggal yang dipilih:', selectedDate);
        });
    </script>

@endsection
