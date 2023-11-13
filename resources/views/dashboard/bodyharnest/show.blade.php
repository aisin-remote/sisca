@extends('dashboard.app')
@section('title', 'Data Body Harnest')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Info Body Harnest</h1>
        @can('admin')
            <a href="{{ route('body-harnest.edit', $bodyharnest->id) }}" class="btn btn-warning">Edit</a>
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
                <div class="h6 col-3">No Body Harnest</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $bodyharnest->no_bodyharnest }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Area</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $bodyharnest->locations->location_name }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Plant</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $bodyharnest->plant }}</div>
            </div>
        </div>
    </div>
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Riwayat Check Sheet Body Harnest</h1>
        <div class="form-group">
            <form action="{{ route('body-harnest.show', $bodyharnest->id) }}" method="GET">
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
    <form action="{{ route('export.checksheetsbodyharnest') }}" method="POST" class="col-md-6 mb-3">
        @method('POST')
        @csrf
        <div class="form-group mb-3">
            <label for="tahun">Download Checksheet Body Harnest</label>
            <select name="tahun" id="tahun" class="form-control" required>
                @for ($year = $firstYear; $year <= $lastYear; $year++)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
            <!-- Tambahkan input hidden untuk no_tabung -->
            <input type="hidden" name="bodyharnest_number" value="{{ $bodyharnest->no_bodyharnest }}">
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
                            <th rowspan="2" scope="col" class="text-center align-middle">No Body Harnest</th>
                            <th colspan="10" scope="colgroup" class="text-center">Item Check</th>
                            <th rowspan="2" scope="col" class="text-center align-middle">Aksi</th>
                        </tr>
                        <tr>
                            <th class="text-center align-middle">Shoulder Straps</th>
                            <th class="text-center align-middle">Hook</th>
                            <th class="text-center align-middle">Buckles Waist</th>
                            <th class="text-center align-middle">Buckles Chest</th>
                            <th class="text-center align-middle">Leg Straps</th>
                            <th class="text-center align-middle">Buckles Leg</th>
                            <th class="text-center align-middle">Back D-Ring</th>
                            <th class="text-center align-middle">Carabiner</th>
                            <th class="text-center align-middle">Straps/Rope</th>
                            <th class="text-center align-middle">Shock Absorber</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheets as $checksheet)
                            <tr class="align-middle">
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="text-center align-middle">
                                    {{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                <td class="text-center align-middle">{{ $checksheet->bodyharnest_number }}</td>

                                @if ($checksheet->shoulder_straps === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->shoulder_straps }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->shoulder_straps }}</td>
                                @endif

                                @if ($checksheet->hook === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->hook }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->hook }}</td>
                                @endif

                                @if ($checksheet->buckles_waist === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->buckles_waist }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->buckles_waist }}</td>
                                @endif

                                @if ($checksheet->buckles_chest === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->buckles_chest }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->buckles_chest }}</td>
                                @endif

                                @if ($checksheet->leg_straps === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->leg_straps }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->leg_straps }}</td>
                                @endif

                                @if ($checksheet->buckles_leg === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->buckles_leg }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->buckles_leg }}</td>
                                @endif

                                @if ($checksheet->back_d_ring === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->back_d_ring }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->back_d_ring }}</td>
                                @endif

                                @if ($checksheet->carabiner === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->carabiner }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->carabiner }}</td>
                                @endif

                                @if ($checksheet->straps_rope === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->straps_rope }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->straps_rope }}</td>
                                @endif

                                @if ($checksheet->shock_absorber === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->shock_absorber }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->shock_absorber }}</td>
                                @endif

                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('bodyharnest.checksheetbodyharnest.show', $checksheet->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        @can('admin')
                                            <a href="{{ route('bodyharnest.checksheetbodyharnest.edit', $checksheet->id) }}"
                                                class="badge bg-warning me-2">Edit</a>
                                            <form
                                                action="{{ route('bodyharnest.checksheetbodyharnest.destroy', $checksheet->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge bg-danger border-0"
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet Body Harnest?')">Delete</button>
                                            </form>
                                        @endcan
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
