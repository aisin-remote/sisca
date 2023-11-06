@extends('dashboard.app')
@section('title', 'Data Eyewasher')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Info Eyewasher</h1>
        @can('admin')
            <a href="{{ route('eye-washer.edit', $eyewasher->id) }}" class="btn btn-warning">Edit</a>
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
                <div class="col-6 text-muted">{{ $eyewasher->no_eyewasher }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Location</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $eyewasher->locations->location_name }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Plant</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $eyewasher->plant }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Type</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $eyewasher->type }}</div>
            </div>
        </div>
    </div>
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Riwayat Check Sheet Eyewasher</h1>
        <div class="form-group">
            <form action="{{ route('eye-washer.show', $eyewasher->id) }}" method="GET">
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

    @if ($eyewasher->type === 'Eyewasher')
        <form action="{{ route('export.checksheetseyewasher') }}" method="POST" class="col-md-6 mb-3">
            @method('POST')
            @csrf
            <div class="form-group mb-3">
                <label for="tahun">Download Checksheet Eyewasher</label>
                <select name="tahun" id="tahun" class="form-control" required>
                    @for ($year = $firstYear; $year <= $lastYear; $year++)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
                <!-- Tambahkan input hidden untuk hydrant_number -->
                <input type="hidden" name="eyewasher_number" value="{{ $eyewasher->no_eyewasher }}">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-download"></i> | Download</button>
        </form>
    @elseif ($eyewasher->type === 'Shower')
        <form action="{{ route('export.checksheetsshower') }}" method="POST" class="col-md-6 mb-3">
            @method('POST')
            @csrf
            <div class="form-group mb-3">
                <label for="tahun">Download Checksheet Eyewasher</label>
                <select name="tahun" id="tahun" class="form-control" required>
                    @for ($year = $firstYear; $year <= $lastYear; $year++)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
                <!-- Tambahkan input hidden untuk no_hydrant -->
                <input type="hidden" name="eyewasher_number" value="{{ $eyewasher->no_eyewasher }}">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-download"></i> | Download</button>
        </form>
    @endif

    @if (session()->has('success1'))
        <div class="mt-2 alert alert-success col-lg-12">
            {{ session()->get('success1') }}
        </div>
    @endif
    @if ($eyewasher->type === 'Eyewasher')
        <div class="card">
            <div class="card-body">
                <div class="table-responsive col-lg-12 mt-3">
                    <table class="table table-striped table-sm" id="dtBasicExample">
                        <thead>
                            <tr>
                                <th rowspan="2" scope="col" class="text-center align-middle">#</th>
                                <th rowspan="2" scope="col" class="text-center align-middle">Tanggal</th>
                                <th rowspan="2" scope="col" class="text-center align-middle">Eyewasher Number</th>
                                <th colspan="5" scope="colgroup" class="text-center">Item Check</th>
                                <th rowspan="2" scope="col" class="text-center align-middle">Aksi</th>
                            </tr>
                            <tr>
                                <th class="text-center align-middle">Pijakan</th>
                                <th class="text-center align-middle">Pipa Saluran Air</th>
                                <th class="text-center align-middle">Wastafel</th>
                                <th class="text-center align-middle">Kran Air</th>
                                <th class="text-center align-middle">Tuas</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($checksheets as $checksheet)
                                <tr class="align-middle">
                                    <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                    <td class="text-center align-middle">
                                        {{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                    <td class="text-center align-middle">{{ $checksheet->eyewasher_number }}</td>

                                    @if ($checksheet->pijakan === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->pijakan }}
                                        </td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->pijakan }}
                                        </td>
                                    @endif

                                    @if ($checksheet->pipa_saluran_air === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->pipa_saluran_air }}
                                        </td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->pipa_saluran_air }}
                                        </td>
                                    @endif

                                    @if ($checksheet->wastafel === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->wastafel }}
                                        </td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->wastafel }}
                                        </td>
                                    @endif

                                    @if ($checksheet->kran_air === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->kran_air }}
                                        </td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->kran_air }}
                                        </td>
                                    @endif

                                    @if ($checksheet->tuas === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->tuas }}
                                        </td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->tuas }}
                                        </td>
                                    @endif

                                    <td class="text-center align-middle">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a href="{{ route('eyewasher.checksheeteyewasher.show', $checksheet->id) }}"
                                                class="badge bg-info me-2">Info</a>
                                            @can('admin')
                                                <a href="{{ route('eyewasher.checksheeteyewasher.edit', $checksheet->id) }}"
                                                    class="badge bg-warning me-2">Edit</a>
                                                <form
                                                    action="{{ route('eyewasher.checksheeteyewasher.destroy', $checksheet->id) }}"
                                                    method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="badge bg-danger border-0"
                                                        onclick="return confirm('Ingin menghapus Data Check Sheet Eyewasher?')">Delete</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <td colspan="14">Tidak ada data...</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @elseif ($eyewasher->type === 'Shower')
        <div class="card">
            <div class="card-body">
                <div class="table-responsive col-lg-12 mt-3">
                    <table class="table table-striped table-sm" id="dtBasicExample">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center align-middle" scope="col">#</th>
                                <th rowspan="2" class="text-center align-middle" scope="col">Tanggal</th>
                                <th rowspan="2" class="text-center align-middle" scope="col">Eyewasher Number</th>
                                <th colspan="8" scope="colgroup" class="text-center">Item Check</th>
                                <th rowspan="2" class="text-center align-middle" scope="col">Aksi</th>
                            </tr>
                            <tr>
                                <th class="text-center align-middle" scope="col">Instalation Base</th>
                                <th class="text-center align-middle" scope="col">Pipa Saluran Air</th>
                                <th class="text-center align-middle" scope="col">Wastafel Eye Wash</th>
                                <th class="text-center align-middle" scope="col">Kran Eye Wash</th>
                                <th class="text-center align-middle" scope="col">Tuas Eye Wash</th>
                                <th class="text-center align-middle" scope="col">Tuas Shower</th>
                                <th class="text-center align-middle" scope="col">Sign</th>
                                <th class="text-center align-middle" scope="col">Shower Head</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($checksheets as $checksheet)
                                <tr class="align-middle text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                    <td>{{ $checksheet->eyewasher_number }}</td>

                                    @if ($checksheet->instalation_base === 'NG')
                                        <td class="text-danger fw-bolder">
                                            {{ $checksheet->instalation_base }}
                                        </td>
                                    @else
                                        <td>{{ $checksheet->instalation_base }}
                                        </td>
                                    @endif

                                    @if ($checksheet->pipa_saluran_air === 'NG')
                                        <td class="text-danger fw-bolder">
                                            {{ $checksheet->pipa_saluran_air }}
                                        </td>
                                    @else
                                        <td>{{ $checksheet->pipa_saluran_air }}
                                        </td>
                                    @endif

                                    @if ($checksheet->wastafel_eye_wash === 'NG')
                                        <td class="text-danger fw-bolder">
                                            {{ $checksheet->wastafel_eye_wash }}
                                        </td>
                                    @else
                                        <td>{{ $checksheet->wastafel_eye_wash }}
                                        </td>
                                    @endif

                                    @if ($checksheet->kran_eye_wash === 'NG')
                                        <td class="text-danger fw-bolder">
                                            {{ $checksheet->kran_eye_wash }}
                                        </td>
                                    @else
                                        <td>{{ $checksheet->kran_eye_wash }}
                                        </td>
                                    @endif

                                    @if ($checksheet->tuas_eye_wash === 'NG')
                                        <td class="text-danger fw-bolder">
                                            {{ $checksheet->tuas_eye_wash }}
                                        </td>
                                    @else
                                        <td>{{ $checksheet->tuas_eye_wash }}
                                        </td>
                                    @endif

                                    @if ($checksheet->tuas_shower === 'NG')
                                        <td class="text-danger fw-bolder">
                                            {{ $checksheet->tuas_shower }}
                                        </td>
                                    @else
                                        <td>{{ $checksheet->tuas_shower }}
                                        </td>
                                    @endif

                                    @if ($checksheet->sign === 'NG')
                                        <td class="text-danger fw-bolder">
                                            {{ $checksheet->sign }}
                                        </td>
                                    @else
                                        <td>{{ $checksheet->sign }}
                                        </td>
                                    @endif

                                    @if ($checksheet->shower_head === 'NG')
                                        <td class="text-danger fw-bolder">
                                            {{ $checksheet->shower_head }}
                                        </td>
                                    @else
                                        <td>{{ $checksheet->shower_head }}
                                        </td>
                                    @endif

                                    <td class="text-center align-middle">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a href="{{ route('eyewasher.checksheetshower.show', $checksheet->id) }}"
                                                class="badge bg-info me-2">Info</a>
                                            @can('admin')
                                                <a href="{{ route('eyewasher.checksheetshower.edit', $checksheet->id) }}"
                                                    class="badge bg-warning me-2">Edit</a>
                                                <form
                                                    action="{{ route('eyewasher.checksheetshower.destroy', $checksheet->id) }}"
                                                    method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="badge bg-danger border-0"
                                                        onclick="return confirm('Ingin menghapus Data Check Sheet Eyewasher?')">Delete</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <td colspan="12">Tidak ada data...</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <p>Type dari Eyewasher tidak ditemukan</p>
    @endif

    <script>
        document.getElementById('filterButton').addEventListener('click', function() {
            var selectedDate = document.getElementById('filterDate').value;
            // Lakukan sesuatu dengan tanggal yang dipilih, misalnya memicu filter
            console.log('Tanggal yang dipilih:', selectedDate);
        });
    </script>

@endsection
