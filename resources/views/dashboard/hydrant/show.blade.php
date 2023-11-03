@extends('dashboard.app')
@section('title', 'Data Hydrant')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Info Hydrant</h1>
        @can('admin')
            <a href="{{ route('hydrant.edit', $hydrant->id) }}" class="btn btn-warning">Edit</a>
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
                <div class="col-6 text-muted">{{ $hydrant->no_hydrant }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Location</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $hydrant->locations->location_name }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Type</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $hydrant->type }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Zona</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $hydrant->zona }}</div>
            </div>
        </div>
    </div>
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Riwayat Check Sheet Hydrant</h1>
        <div class="form-group">
            <form action="{{ route('hydrant.show', $hydrant->id) }}" method="GET">
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

    @if ($hydrant->type === 'Indoor')
        <form action="{{ route('export.checksheetsindoor') }}" method="POST" class="col-md-6 mb-3">
            @method('POST')
            @csrf
            <div class="form-group mb-3">
                <label for="tahun">Download Checksheet Hydrant</label>
                <select name="tahun" id="tahun" class="form-control" required>
                    @for ($year = $firstYear; $year <= $lastYear; $year++)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
                <!-- Tambahkan input hidden untuk hydrant_number -->
                <input type="hidden" name="hydrant_number" value="{{ $hydrant->no_hydrant }}">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-download"></i> | Download</button>
        </form>
    @elseif ($hydrant->type === 'Outdoor')
        <form action="{{ route('export.checksheetsoutdoor') }}" method="POST" class="col-md-6 mb-3">
            @method('POST')
            @csrf
            <div class="form-group mb-3">
                <label for="tahun">Download Checksheet Hydrant</label>
                <select name="tahun" id="tahun" class="form-control" required>
                    @for ($year = $firstYear; $year <= $lastYear; $year++)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
                <!-- Tambahkan input hidden untuk no_hydrant -->
                <input type="hidden" name="hydrant_number" value="{{ $hydrant->no_hydrant }}">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-download"></i> | Download</button>
        </form>
    @endif

    @if (session()->has('success1'))
        <div class="mt-2 alert alert-success col-lg-12">
            {{ session()->get('success1') }}
        </div>
    @endif
    @if ($hydrant->type === 'Indoor')
        <div class="card">
            <div class="card-body">
                <div class="table-responsive col-lg-12 mt-3">
                    <table class="table table-striped table-sm" id="dtBasicExample1">
                        <thead>
                            <tr>
                                <th rowspan="2" scope="col" class="text-center align-middle">#</th>
                                <th rowspan="2" scope="col" class="text-center align-middle">Tanggal</th>
                                <th rowspan="2" scope="col" class="text-center align-middle">Hydrant Number</th>
                                <th colspan="9" scope="colgroup" class="text-center">Item Check</th>
                                <th rowspan="2" scope="col" class="text-center align-middle">Aksi</th>
                            </tr>
                            <tr>
                                <th class="text-center align-middle">Pintu Hydrant</th>
                                <th class="text-center align-middle">Lampu</th>
                                <th class="text-center align-middle">Tombol Emergency</th>
                                <th class="text-center align-middle">Nozzle</th>
                                <th class="text-center align-middle">Selang</th>
                                <th class="text-center align-middle">Valve</th>
                                <th class="text-center align-middle">Coupling/Sambungan</th>
                                <th class="text-center align-middle">Pressure</th>
                                <th class="text-center align-middle">Kopling/Kupla</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($checksheets as $checksheet)
                                <tr class="align-middle">
                                    <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                    <td class="text-center align-middle">
                                        {{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                    <td class="text-center align-middle">{{ $checksheet->hydrant_number }}</td>

                                    @if ($checksheet->pintu === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->pintu }}</td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->pintu }}</td>
                                    @endif

                                    @if ($checksheet->lampu === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->lampu }}</td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->lampu }}</td>
                                    @endif

                                    @if ($checksheet->emergency === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->emergency }}</td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->emergency }}</td>
                                    @endif

                                    @if ($checksheet->nozzle === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->nozzle }}</td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->nozzle }}</td>
                                    @endif

                                    @if ($checksheet->selang === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->selang }}</td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->selang }}</td>
                                    @endif

                                    @if ($checksheet->valve === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->valve }}</td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->valve }}</td>
                                    @endif

                                    @if ($checksheet->coupling === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->coupling }}</td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->coupling }}</td>
                                    @endif

                                    @if ($checksheet->pressure === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->pressure }}</td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->pressure }}</td>
                                    @endif

                                    @if ($checksheet->kupla === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->kupla }}</td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->kupla }}</td>
                                    @endif

                                    <td class="text-center align-middle">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a href="{{ route('hydrant.checksheetindoor.show', $checksheet->id) }}"
                                                class="badge bg-info me-2">Info</a>
                                            @can('admin')
                                                <a href="{{ route('hydrant.checksheetindoor.edit', $checksheet->id) }}"
                                                    class="badge bg-warning me-2">Edit</a>
                                                <form
                                                    action="{{ route('hydrant.checksheetindoor.destroy', $checksheet->id) }}"
                                                    method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="badge bg-danger border-0"
                                                        onclick="return confirm('Ingin menghapus Data Check Sheet Hydrant Indoor?')">Delete</button>
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
    @elseif ($hydrant->type === 'Outdoor')
        <div class="card">
            <div class="card-body">
                <div class="table-responsive col-lg-12 mt-3">
                    <table class="table table-striped table-sm" id="dtBasicExample2">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center align-middle" scope="col">#</th>
                                <th rowspan="2" class="text-center align-middle" scope="col">Tanggal</th>
                                <th rowspan="2" class="text-center align-middle" scope="col">Tag Number</th>
                                <th colspan="8" scope="colgroup" class="text-center">Item Check</th>
                                <th rowspan="2" class="text-center align-middle" scope="col">Aksi</th>
                            </tr>
                            <tr>
                                <th class="text-center align-middle" scope="col">Pintu</th>
                                <th class="text-center align-middle" scope="col">Nozzle</th>
                                <th class="text-center align-middle" scope="col">Selang</th>
                                <th class="text-center align-middle" scope="col">Tuas Pilar</th>
                                <th class="text-center align-middle" scope="col">Pilar</th>
                                <th class="text-center align-middle" scope="col">Penutup Pilar</th>
                                <th class="text-center align-middle" scope="col">Rantai Penutup Pilar</th>
                                <th class="text-center align-middle" scope="col">Kopling/Kupla</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($checksheets as $checksheet)
                                <tr class="align-middle text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                    <td>{{ $checksheet->hydrant_number }}</td>

                                    @if ($checksheet->pintu === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->pintu }}</td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->pintu }}</td>
                                    @endif

                                    @if ($checksheet->nozzle === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->nozzle }}</td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->nozzle }}</td>
                                    @endif

                                    @if ($checksheet->selang === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->selang }}</td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->selang }}</td>
                                    @endif

                                    @if ($checksheet->tuas === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->tuas }}</td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->tuas }}</td>
                                    @endif

                                    @if ($checksheet->pilar === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->pilar }}</td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->pilar }}</td>
                                    @endif

                                    @if ($checksheet->penutup === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->penutup }}</td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->penutup }}</td>
                                    @endif

                                    @if ($checksheet->rantai === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->rantai }}</td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->rantai }}</td>
                                    @endif

                                    @if ($checksheet->kupla === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->kupla }}</td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->kupla }}</td>
                                    @endif

                                    <td class="text-center align-middle">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a href="{{ route('hydrant.checksheetoutdoor.show', $checksheet->id) }}"
                                                class="badge bg-info me-2">Info</a>
                                            @can('admin')
                                                <a href="{{ route('hydrant.checksheetoutdoor.edit', $checksheet->id) }}"
                                                    class="badge bg-warning me-2">Edit</a>
                                                <form
                                                    action="{{ route('hydrant.checksheetoutdoor.destroy', $checksheet->id) }}"
                                                    method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="badge bg-danger border-0"
                                                        onclick="return confirm('Ingin menghapus Data Check Sheet Hydrant Outdoor?')">Delete</button>
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
        <p>Type dari Hydrant tidak ditemukan</p>
    @endif

    <script>
        document.getElementById('filterButton').addEventListener('click', function() {
            var selectedDate = document.getElementById('filterDate').value;
            // Lakukan sesuatu dengan tanggal yang dipilih, misalnya memicu filter
            console.log('Tanggal yang dipilih:', selectedDate);
        });

        $(document).ready(function() {
            var table1 = $('#dtBasicExample1').DataTable();
            var table2 = $('#dtBasicExample2').DataTable();
        });
    </script>

@endsection
