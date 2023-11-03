@extends('dashboard.app')
@section('title', 'Data Apar')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Info Apar</h1>
        @can('admin')
            <a href="{{ route('apar.edit', $apar->id) }}" class="btn btn-warning">Edit</a>
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
                <div class="col-6 text-muted">{{ $apar->tag_number }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Location</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $apar->locations->location_name }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Expired</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $apar->expired }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Post</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $apar->post }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Type</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $apar->type }}</div>
            </div>
        </div>
    </div>
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Riwayat Check Sheet Apar</h1>
        <div class="form-group">
            <form action="{{ route('apar.show', $apar->id) }}" method="GET">
                <label for="tahun_filter">Filter Tahun:</label>
                <div class="input-group">
                    <select name="tahun_filter" id="tahun_filter" class="form-control">
                        @for ($year = $firstYear; $year <= $lastYear; $year++)
                            <option value="{{ $year }}" {{ request('tahun_filter') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                    <button class="btn btn-success" id="filterButton">Filter</button>
                </div>
            </form>
        </div>

        {{-- <form action="{{ route('apar.show', $apar->id) }}" method="GET">
            <label for="tanggal_filter">Filter Tanggal:</label>
            <input type="date" name="tanggal_filter" id="tanggal_filter">
            <button type="submit" class="btn btn-primary">Filter</button>
        </form> --}}

    </div>
    @if ($apar->type  === 'co2')
        <form action="{{ route('export.checksheetsco2') }}" method="POST" class="col-md-6 mb-3">
            @method('POST')
            @csrf
            <div class="form-group mb-3">
                <label for="tahun">Download Checksheet Apar</label>
                <select name="tahun" id="tahun" class="form-control" required>
                    @for ($year = $firstYear; $year <= $lastYear; $year++)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
                <!-- Tambahkan input hidden untuk tag_number -->
            <input type="hidden" name="tag_number" value="{{ $apar->tag_number }}">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-download"></i> | Download</button>
        </form>
    @elseif ($apar->type  === 'af11e')
        <form action="{{ route('export.checksheetsco2') }}" method="POST" class="col-md-6">
            @method('POST')
            @csrf
            <div class="form-group mb-3">
                <label for="tahun">Download Checksheet Apar</label>
                <select name="tahun" id="tahun" class="form-control" required>
                    @for ($year = $firstYear; $year <= $lastYear; $year++)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
                <!-- Tambahkan input hidden untuk tag_number -->
            <input type="hidden" name="tag_number" value="{{ $apar->tag_number }}">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-download"></i> | Download</button>
        </form>
    @elseif ($apar->type  === 'powder')
        <form action="{{ route('export.checksheetspowder') }}" method="POST" class="col-md-6 mb-3">
            @method('POST')
            @csrf
            <div class="form-group mb-3">
                <label for="tahun">Download Checksheet Apar</label>
                <select name="tahun" id="tahun" class="form-control" required>
                    @for ($year = $firstYear; $year <= $lastYear; $year++)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
                <!-- Tambahkan input hidden untuk tag_number -->
            <input type="hidden" name="tag_number" value="{{ $apar->tag_number }}">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-download"></i> | Download</button>
        </form>
    @endif

    @if (session()->has('success1'))
        <div class="mt-2 alert alert-success col-lg-12">
            {{ session()->get('success1') }}
        </div>
    @endif
    @if ($apar->type === 'co2' || $apar->type === 'af11e')
    <div class="card">
        <div class="card-table">
            <div class="table-responsive col-lg-12 mt-3">
                <table class="table table-striped table-sm" id="dtBasicExample">
                    <thead>
                        <tr>
                            <th rowspan="2" scope="col" class="text-center align-middle">#</th>
                            <th rowspan="2" scope="col" class="text-center align-middle">Tanggal</th>
                            <th rowspan="2" scope="col" class="text-center align-middle">Tag Number</th>
                            <th colspan="7" scope="colgroup" class="text-center">Item Check</th>
                            <th rowspan="2" scope="col" class="text-center align-middle">Aksi</th>
                        </tr>
                        <tr>
                            <th class="text-center align-middle">Pressure</th>
                            <th class="text-center align-middle">Hose</th>
                            <th class="text-center align-middle">Corong</th>
                            <th class="text-center align-middle">Tabung</th>
                            <th class="text-center align-middle">Regulator</th>
                            <th class="text-center align-middle">Lock Pin</th>
                            <th class="text-center align-middle">Berat Tabung</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheets as $checksheet)
                            <tr class="align-middle">
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="text-center align-middle">{{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                <td class="text-center align-middle">{{ $checksheet->apar_number }}</td>

                                @if ($checksheet->pressure === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->pressure }}</td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->pressure }}</td>
                                @endif

                                @if ($checksheet->hose === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->hose }}</td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->hose }}</td>
                                @endif

                                @if ($checksheet->corong === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->corong }}</td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->corong }}</td>
                                @endif

                                @if ($checksheet->tabung === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->tabung }}</td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->tabung }}</td>
                                @endif

                                @if ($checksheet->regulator === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->regulator }}</td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->regulator }}</td>
                                @endif

                                @if ($checksheet->lock_pin === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->lock_pin }}</td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->lock_pin }}</td>
                                @endif

                                @if ($checksheet->berat_tabung === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->berat_tabung }}</td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->berat_tabung }}</td>
                                @endif

                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('apar.checksheetco2.show', $checksheet->id) }}" class="badge bg-info me-2">Info</a>
                                        @can('admin')
                                            <a href="{{ route('apar.checksheetco2.edit', $checksheet->id) }}"
                                                class="badge bg-warning me-2">Edit</a>
                                            <form action="{{ route('apar.checksheetco2.destroy', $checksheet->id) }}" method="POST"
                                                class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge bg-danger border-0"
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet Apar Co2?')">Delete</button>
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
    @elseif ($apar->type === 'powder')
    <div class="card">
        <div class="card-table">
            <div class="table-responsive col-lg-12 mt-3">
                <table class="table table-striped table-sm" id="dtBasicExample">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-center align-middle" scope="col">#</th>
                            <th rowspan="2" class="text-center align-middle" scope="col">Tanggal</th>
                            <th rowspan="2" class="text-center align-middle" scope="col">Tag Number</th>
                            <th colspan="6" scope="colgroup" class="text-center">Item Check</th>
                            <th rowspan="2" class="text-center align-middle" scope="col">Aksi</th>
                        </tr>
                        <tr>
                            <th class="text-center align-middle" scope="col">Pressure</th>
                            <th class="text-center align-middle" scope="col">Hose</th>
                            <th class="text-center align-middle" scope="col">Tabung</th>
                            <th class="text-center align-middle" scope="col">Regulator</th>
                            <th class="text-center align-middle" scope="col">Lock Pin</th>
                            <th class="text-center align-middle" scope="col">Powder</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheets as $checksheet)
                            <tr class="align-middle text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                <td>{{ $checksheet->apar_number }}</td>

                                @if ($checksheet->pressure === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->pressure }}</td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->pressure }}</td>
                                @endif

                                @if ($checksheet->hose === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->hose }}</td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->hose }}</td>
                                @endif

                                @if ($checksheet->tabung === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->tabung }}</td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->tabung }}</td>
                                @endif

                                @if ($checksheet->regulator === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->regulator }}</td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->regulator }}</td>
                                @endif

                                @if ($checksheet->lock_pin === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->lock_pin }}</td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->lock_pin }}</td>
                                @endif

                                @if ($checksheet->powder === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">{{ $checksheet->powder }}</td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->powder }}</td>
                                @endif

                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('apar.checksheetpowder.show', $checksheet->id) }}" class="badge bg-info me-2">Info</a>
                                        @can('admin')
                                            <a href="{{ route('apar.checksheetpowder.edit', $checksheet->id) }}"
                                                class="badge bg-warning me-2">Edit</a>
                                            <form action="{{ route('apar.checksheetpowder.destroy', $checksheet->id) }}" method="POST"
                                                class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge bg-danger border-0"
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet Apar Powder?')">Delete</button>
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
        <p>Type dari Apar tidak ditemukan</p>
    @endif

    <script>
        document.getElementById('filterButton').addEventListener('click', function () {
            var selectedDate = document.getElementById('filterDate').value;
            // Lakukan sesuatu dengan tanggal yang dipilih, misalnya memicu filter
            console.log('Tanggal yang dipilih:', selectedDate);
        });
    </script>

@endsection
