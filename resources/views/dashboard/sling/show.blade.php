@extends('dashboard.app')
@section('title', 'Data Sling')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Info Sling</h1>
        <a href="{{ route('sling.edit', $sling->id) }}" class="btn btn-warning">Edit</a>
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
                <div class="col-6 text-muted">{{ $sling->no_sling }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Area</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $sling->locations->location_name }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Plant</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $sling->plant }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Type</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $sling->type }}</div>
            </div>
        </div>
    </div>
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Riwayat Check Sheet Sling</h1>
        <div class="form-group">
            <form action="{{ route('sling.show', $sling->id) }}" method="GET">
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

    @if ($sling->type === 'Sling Wire')
        <form action="{{ route('export.checksheetseyewasher') }}" method="POST" class="col-md-6 mb-3">
            @method('POST')
            @csrf
            <div class="form-group mb-3">
                <label for="tahun">Download Checksheet Sling</label>
                <select name="tahun" id="tahun" class="form-control" required>
                    @for ($year = $firstYear; $year <= $lastYear; $year++)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
                <!-- Tambahkan input hidden untuk hydrant_number -->
                <input type="hidden" name="sling_number" value="{{ $sling->no_sling }}">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-download"></i> | Download</button>
        </form>
    @elseif ($sling->type === 'Sling Belt')
        <form action="{{ route('export.checksheetsshower') }}" method="POST" class="col-md-6 mb-3">
            @method('POST')
            @csrf
            <div class="form-group mb-3">
                <label for="tahun">Download Checksheet Sling</label>
                <select name="tahun" id="tahun" class="form-control" required>
                    @for ($year = $firstYear; $year <= $lastYear; $year++)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
                <!-- Tambahkan input hidden untuk no_hydrant -->
                <input type="hidden" name="sling_number" value="{{ $sling->no_sling }}">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-download"></i> | Download</button>
        </form>
    @endif

    @if (session()->has('success1'))
        <div class="mt-2 alert alert-success col-lg-12">
            {{ session()->get('success1') }}
        </div>
    @endif
    @if ($sling->type === 'Sling Wire')
        <div class="card">
            <div class="card-body">
                <div class="table-responsive col-lg-12 mt-3">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th rowspan="2" scope="col" class="text-center align-middle">#</th>
                                <th rowspan="2" scope="col" class="text-center align-middle">Tanggal</th>
                                <th rowspan="2" scope="col" class="text-center align-middle">Sling Number</th>
                                <th colspan="9" scope="colgroup" class="text-center">Item Check</th>
                                <th rowspan="2" scope="col" class="text-center align-middle">Aksi</th>
                            </tr>
                            <tr>
                                <th class="text-center align-middle">Serabut Wire</th>
                                <th class="text-center align-middle">Bagian Wire 1</th>
                                <th class="text-center align-middle">Bagian Wire 2</th>
                                <th class="text-center align-middle">Kumpulan Wire 1</th>
                                <th class="text-center align-middle">Diameter Wire</th>
                                <th class="text-center align-middle">Kumpulan Wire 2</th>
                                <th class="text-center align-middle">Hook Wire</th>
                                <th class="text-center align-middle">Pengunci Hook</th>
                                <th class="text-center align-middle">Mata Sling</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($checksheets as $checksheet)
                                <tr class="align-middle">
                                    <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                    <td class="text-center align-middle">
                                        {{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                    <td class="text-center align-middle">{{ $checksheet->sling_number }}</td>
                                    <td class="text-center align-middle">{{ $checksheet->serabut_wire }}</td>
                                    <td class="text-center align-middle">{{ $checksheet->bagian_wire_1 }}</td>
                                    <td class="text-center align-middle">{{ $checksheet->bagian_wire_2 }}</td>
                                    <td class="text-center align-middle">{{ $checksheet->kumpulan_wire_1 }}</td>
                                    <td class="text-center align-middle">{{ $checksheet->diameter_wire }}</td>
                                    <td class="text-center align-middle">{{ $checksheet->kumpulan_wire_2 }}</td>
                                    <td class="text-center align-middle">{{ $checksheet->hook_wire }}</td>
                                    <td class="text-center align-middle">{{ $checksheet->pengunci_hook }}</td>
                                    <td class="text-center align-middle">{{ $checksheet->mata_sling }}</td>
                                    <td class="text-center align-middle">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a href="{{ route('sling.checksheetwire.show', $checksheet->id) }}"
                                                class="badge bg-info me-2">Info</a>
                                            <a href="{{ route('sling.checksheetwire.edit', $checksheet->id) }}"
                                                class="badge bg-warning me-2">Edit</a>
                                            <form
                                                action="{{ route('sling.checksheetwire.destroy', $checksheet->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge bg-danger border-0"
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet Sling?')">Delete</button>
                                            </form>
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
    @elseif ($sling->type === 'Sling Belt')
        <div class="card">
            <div class="card-body">
                <div class="table-responsive col-lg-12 mt-3">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center align-middle" scope="col">#</th>
                                <th rowspan="2" class="text-center align-middle" scope="col">Tanggal</th>
                                <th rowspan="2" class="text-center align-middle" scope="col">Sling Number</th>
                                <th colspan="9" scope="colgroup" class="text-center">Item Check</th>
                                <th rowspan="2" class="text-center align-middle" scope="col">Aksi</th>
                            </tr>
                            <tr>
                                <th class="text-center align-middle" scope="col">Kelengkapan Tag Sling Belt</th>
                                <th class="text-center align-middle" scope="col">Bagian Pinggir Belt Robek</th>
                                <th class="text-center align-middle" scope="col">Pengecekan Lapisan Belt 1</th>
                                <th class="text-center align-middle" scope="col">Pengecekan Jahitan Belt</th>
                                <th class="text-center align-middle" scope="col">Pengecekan Permukaan Belt</th>
                                <th class="text-center align-middle" scope="col">Pengecekan Lapisan Belt 2</th>
                                <th class="text-center align-middle" scope="col">Pengecekan Aus</th>
                                <th class="text-center align-middle" scope="col">Hook Wire</th>
                                <th class="text-center align-middle" scope="col">Pengunci Hook</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($checksheets as $checksheet)
                                <tr class="align-middle text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                    <td>{{ $checksheet->sling_number }}</td>
                                    <td>{{ $checksheet->kelengkapan_tag_sling_belt }}</td>
                                    <td>{{ $checksheet->bagian_pinggir_belt_robek }}</td>
                                    <td>{{ $checksheet->pengecekan_lapisan_belt_1 }}</td>
                                    <td>{{ $checksheet->pengecekan_jahitan_belt }}</td>
                                    <td>{{ $checksheet->pengecekan_permukaan_belt }}</td>
                                    <td>{{ $checksheet->pengecekan_lapisan_belt_2 }}</td>
                                    <td>{{ $checksheet->pengecekan_aus }}</td>
                                    <td>{{ $checksheet->hook_wire }}</td>
                                    <td>{{ $checksheet->pengunci_hook }}</td>
                                    <td class="text-center align-middle">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a href=""
                                                class="badge bg-info me-2">Info</a>
                                            <a href=""
                                                class="badge bg-warning me-2">Edit</a>
                                            <form
                                                action=""
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge bg-danger border-0"
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet Eyewasher?')">Delete</button>
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
