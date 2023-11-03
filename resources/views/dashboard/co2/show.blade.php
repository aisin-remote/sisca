@extends('dashboard.app')
@section('title', 'Data Co2')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Info Co2</h1>
        @can('admin')
            <a href="{{ route('co2.edit', $co2->id) }}" class="btn btn-warning">Edit</a>
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
                <div class="col-6 text-muted">{{ $co2->no_tabung }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Location</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $co2->locations->location_name }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Plant</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $co2->plant }}</div>
            </div>
        </div>
    </div>
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Riwayat Check Sheet Co2</h1>
        <div class="form-group">
            <form action="{{ route('co2.show', $co2->id) }}" method="GET">
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
    <form action="{{ route('export.checksheetstabung.co2') }}" method="POST" class="col-md-6 mb-3">
        @method('POST')
        @csrf
        <div class="form-group mb-3">
            <label for="tahun">Download Checksheet Co2</label>
            <select name="tahun" id="tahun" class="form-control" required>
                @for ($year = $firstYear; $year <= $lastYear; $year++)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
            <!-- Tambahkan input hidden untuk no_tabung -->
            <input type="hidden" name="tabung_number" value="{{ $co2->no_tabung }}">
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
                            <th colspan="6" scope="colgroup" class="text-center">Item Check</th>
                            <th rowspan="2" scope="col" class="text-center align-middle">Aksi</th>
                        </tr>
                        <tr>
                            <th class="text-center align-middle">Cover</th>
                            <th class="text-center align-middle">Tabung</th>
                            <th class="text-center align-middle">Lock Pin</th>
                            <th class="text-center align-middle">Segel Lock Pin</th>
                            <th class="text-center align-middle">Kebocoran Regulator Tabung</th>
                            <th class="text-center align-middle">Selang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheets as $checksheet)
                            <tr class="align-middle">
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="text-center align-middle">
                                    {{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                <td class="text-center align-middle">{{ $checksheet->tabung_number }}</td>

                                @if ($checksheet->cover === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->cover }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->cover }}</td>
                                @endif

                                @if ($checksheet->tabung === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->tabung }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->tabung }}</td>
                                @endif

                                @if ($checksheet->lock_pin === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->lock_pin }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->lock_pin }}</td>
                                @endif

                                @if ($checksheet->segel_lock_pin === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->segel_lock_pin }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->segel_lock_pin }}</td>
                                @endif

                                @if ($checksheet->kebocoran_regulator_tabung === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->kebocoran_regulator_tabung }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->kebocoran_regulator_tabung }}</td>
                                @endif

                                @if ($checksheet->selang === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->selang }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->selang }}</td>
                                @endif

                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('co2.checksheetco2.show', $checksheet->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        @can('admin')
                                            <a href="{{ route('co2.checksheetco2.edit', $checksheet->id) }}"
                                                class="badge bg-warning me-2">Edit</a>
                                            <form action="{{ route('co2.checksheetco2.destroy', $checksheet->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge bg-danger border-0"
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet Co2?')">Delete</button>
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
