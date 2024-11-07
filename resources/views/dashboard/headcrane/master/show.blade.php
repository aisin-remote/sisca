@extends('dashboard.app')
@section('title', 'Data Head Crane')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Info Head Crane</h1>
        @if (Auth::user()->role === 'MTE' || Auth::user()->role === 'Admin')
            <a href="{{ route('head-crane.edit', $headcrane->id) }}" class="btn btn-warning">Edit</a>
        @endif
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
                <div class="h6 col-3">No Head Crane</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $headcrane->no_headcrane }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Area</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $headcrane->locations->location_name }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Plant</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $headcrane->plant }}</div>
            </div>
        </div>
    </div>
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Riwayat Check Sheet Head Crane</h1>
        <div class="form-group">
            <form action="{{ route('head-crane.show', $headcrane->id) }}" method="GET">
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
    <form action="{{ route('export.checksheetsheadcrane') }}" method="POST" class="col-md-6 mb-3">
        @method('POST')
        @csrf
        <div class="form-group mb-3">
            <label for="tahun">Download Checksheet Head Crane</label>
            <select name="tahun" id="tahun" class="form-control" required>
                @for ($year = $firstYear; $year <= $lastYear; $year++)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
            <!-- Tambahkan input hidden untuk no_tabung -->
            <input type="hidden" name="headcrane_number" value="{{ $headcrane->no_headcrane }}">
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
            <div class="table-responsive col-md-12 px-3 py-3">
                <table class="table table-striped table-sm" id="dtBasicExample">
                    <thead>
                        <tr>
                            <th rowspan="2" scope="col" class="text-center align-middle">#</th>
                            <th rowspan="2" scope="col" class="text-center align-middle">Tanggal</th>
                            <th rowspan="2" scope="col" class="text-center align-middle">No Head Crane</th>
                            <th colspan="9" scope="colgroup" class="text-center">Item Check</th>
                            <th rowspan="2" scope="col" class="text-center align-middle">Aksi</th>
                        </tr>
                        <tr>
                            <th class="text-center align-middle">Cross Travelling</th>
                            <th class="text-center align-middle">Long Travellin</th>
                            <th class="text-center align-middle">Button Up</th>
                            <th class="text-center align-middle">Button Down</th>
                            <th class="text-center align-middle">Button Push</th>
                            <th class="text-center align-middle">Wire Rope</th>
                            <th class="text-center align-middle">Block Hook</th>
                            <th class="text-center align-middle">Hom</th>
                            <th class="text-center align-middle">Emergency Stop</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheets as $checksheet)
                            <tr class="align-middle">
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="text-center align-middle">
                                    {{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                <td class="text-center align-middle">{{ $checksheet->headcrane_number }}</td>

                                @if ($checksheet->cross_travelling === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->cross_travelling }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->cross_travelling }}</td>
                                @endif

                                @if ($checksheet->long_travelling === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->long_travelling }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->long_travelling }}</td>
                                @endif

                                @if ($checksheet->button_up === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->button_up }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->button_up }}</td>
                                @endif

                                @if ($checksheet->button_down === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->button_down }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->button_down }}</td>
                                @endif

                                @if ($checksheet->button_push === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->button_push }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->button_push }}</td>
                                @endif

                                @if ($checksheet->wire_rope === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->wire_rope }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->wire_rope }}</td>
                                @endif

                                @if ($checksheet->block_hook === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->block_hook }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->block_hook }}</td>
                                @endif

                                @if ($checksheet->hom === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->hom }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->hom }}</td>
                                @endif

                                @if ($checksheet->emergency_stop === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->emergency_stop }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->emergency_stop }}</td>
                                @endif
                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('headcrane.checksheetheadcrane.show', $checksheet->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        @if (Auth::user()->role === 'MTE' || Auth::user()->role === 'Admin')
                                            <a href="{{ route('headcrane.checksheetheadcrane.edit', $checksheet->id) }}"
                                                class="badge bg-warning me-2">Edit</a>
                                            <form
                                                action="{{ route('headcrane.checksheetheadcrane.destroy', $checksheet->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge bg-danger border-0"
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet Head Crane?')">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <td colspan="18">Tidak ada data...</td>
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
