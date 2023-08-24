@extends('dashboard.app')
@section('title', 'Data Apar')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Info Apar</h1>
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
            <form action="{{ route('data_apar.show', $apar->id) }}" method="GET">
            <label for="tanggal_filter">Filter Tanggal:</label>
            <div class="input-group">
                <input type="date" name="tanggal_filter" class="form-control" id="tanggal_filter">
                <button class="btn btn-success" id="filterButton">Filter</button>
            </div>
            </form>
        </div>
        {{-- <form action="{{ route('data_apar.show', $apar->id) }}" method="GET">
            <label for="tanggal_filter">Filter Tanggal:</label>
            <input type="date" name="tanggal_filter" id="tanggal_filter">
            <button type="submit" class="btn btn-primary">Filter</button>
        </form> --}}

    </div>
    @if (session()->has('success1'))
        <div class="alert alert-success col-lg-12">
            {{ session()->get('success1') }}
        </div>
    @endif
    @if ($apar->type === 'co2' || $apar->type === 'af11e')
        <div class="table-responsive col-lg-12">
            <table class="table table-striped table-sm">
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
                            <td class="text-center align-middle">{{ $checksheet->pressure }}</td>
                            <td class="text-center align-middle">{{ $checksheet->hose }}</td>
                            <td class="text-center align-middle">{{ $checksheet->corong }}</td>
                            <td class="text-center align-middle">{{ $checksheet->tabung }}</td>
                            <td class="text-center align-middle">{{ $checksheet->regulator }}</td>
                            <td class="text-center align-middle">{{ $checksheet->lock_pin }}</td>
                            <td class="text-center align-middle">{{ $checksheet->berat_tabung }}</td>
                            <td class="text-center align-middle">
                                <div class="d-flex align-items-center justify-content-center">
                                    <a href="{{ route('apar.checksheetco2.edit', $checksheet->id) }}"
                                        class="badge bg-warning me-2">Edit</a>
                                    <form action="{{ route('apar.checksheetco2.destroy', $checksheet->id) }}" method="POST"
                                        class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="badge bg-danger border-0"
                                            onclick="return confirm('Ingin menghapus Data Check Sheet Apar Co2?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <td colspan="12">Tidak ada data...</td>
                    @endforelse
                </tbody>
            </table>
        </div>
    @elseif ($apar->type === 'powder')
    <div class="table-responsive col-lg-12">
        <table class="table table-striped table-sm">
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
                        <td>{{ $checksheet->pressure }}</td>
                        <td>{{ $checksheet->hose }}</td>
                        <td>{{ $checksheet->tabung }}</td>
                        <td>{{ $checksheet->regulator }}</td>
                        <td>{{ $checksheet->lock_pin }}</td>
                        <td>{{ $checksheet->powder }}</td>
                        <td class="text-center align-middle">
                            <div class="d-flex align-items-center justify-content-center">
                                <a href="{{ route('apar.checksheetpowder.edit', $checksheet->id) }}"
                                    class="badge bg-warning me-2">Edit</a>
                                <form action="{{ route('apar.checksheetpowder.destroy', $checksheet->id) }}" method="POST"
                                    class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="badge bg-danger border-0"
                                        onclick="return confirm('Ingin menghapus Data Check Sheet Apar Powder?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <td colspan="12">Tidak ada data...</td>
                @endforelse
            </tbody>
        </table>
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
