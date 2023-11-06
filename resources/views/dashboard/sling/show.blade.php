@extends('dashboard.app')
@section('title', 'Data Sling')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Info Sling</h1>
        @can('admin')
            <a href="{{ route('sling.edit', $sling->id) }}" class="btn btn-warning">Edit</a>
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
                <div class="col-6 text-muted">{{ $sling->no_sling }}</div>
            </div>

            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">SWL</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $sling->swl }} Ton</div>
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
        <form action="{{ route('export.checksheetswire') }}" method="POST" class="col-md-6 mb-3">
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
        <form action="{{ route('export.checksheetsbelt') }}" method="POST" class="col-md-6 mb-3">
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
                    <table class="table table-striped table-sm" id="dtBasicExample">
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
                                <th class="text-center align-middle">Sling Terlilit</th>
                                <th class="text-center align-middle">Karat</th>
                                <th class="text-center align-middle">Serabut Keluar</th>
                                <th class="text-center align-middle">Diameter Wire</th>
                                <th class="text-center align-middle">Wire Longgar</th>
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
                                        {{ strftime('%e %B %Y', strtotime($checksheet->created_at)) }}</td>
                                    <td class="text-center align-middle">{{ $checksheet->sling_number }}</td>

                                    @if ($checksheet->serabut_wire === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->serabut_wire }}
                                        </td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->serabut_wire }}
                                        </td>
                                    @endif

                                    @if ($checksheet->bagian_wire_1 === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->bagian_wire_1 }}
                                        </td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->bagian_wire_1 }}
                                        </td>
                                    @endif

                                    @if ($checksheet->bagian_wire_2 === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->bagian_wire_2 }}
                                        </td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->bagian_wire_2 }}
                                        </td>
                                    @endif

                                    @if ($checksheet->kumpulan_wire_1 === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->kumpulan_wire_1 }}
                                        </td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->kumpulan_wire_1 }}
                                        </td>
                                    @endif

                                    @if ($checksheet->diameter_wire === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->diameter_wire }}
                                        </td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->diameter_wire }}
                                        </td>
                                    @endif

                                    @if ($checksheet->kumpulan_wire_2 === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->kumpulan_wire_2 }}
                                        </td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->kumpulan_wire_2 }}
                                        </td>
                                    @endif

                                    @if ($checksheet->hook_wire === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->hook_wire }}
                                        </td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->hook_wire }}
                                        </td>
                                    @endif

                                    @if ($checksheet->pengunci_hook === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->pengunci_hook }}
                                        </td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->pengunci_hook }}
                                        </td>
                                    @endif

                                    @if ($checksheet->mata_sling === 'NG')
                                        <td class="text-danger fw-bolder text-center align-middle">
                                            {{ $checksheet->mata_sling }}
                                        </td>
                                    @else
                                        <td class="text-center align-middle">{{ $checksheet->mata_sling }}
                                        </td>
                                    @endif

                                    <td class="text-center align-middle">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a href="{{ route('sling.checksheetwire.show', $checksheet->id) }}"
                                                class="badge bg-info me-2">Info</a>
                                            @can('admin')
                                                <a href="{{ route('sling.checksheetwire.edit', $checksheet->id) }}"
                                                    class="badge bg-warning me-2">Edit</a>
                                                <form action="{{ route('sling.checksheetwire.destroy', $checksheet->id) }}"
                                                    method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="badge bg-danger border-0"
                                                        onclick="return confirm('Ingin menghapus Data Check Sheet Sling?')">Delete</button>
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
    @elseif ($sling->type === 'Sling Belt')
        <div class="card">
            <div class="card-body">
                <div class="table-responsive col-lg-12 mt-3">
                    <table class="table table-striped table-sm" id="dtBasicExample">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center align-middle" scope="col">#</th>
                                <th rowspan="2" class="text-center align-middle" scope="col">Tanggal</th>
                                <th rowspan="2" class="text-center align-middle" scope="col">Sling Number</th>
                                <th colspan="9" scope="colgroup" class="text-center">Item Check</th>
                                <th rowspan="2" class="text-center align-middle" scope="col">Aksi</th>
                            </tr>
                            <tr>
                                <th class="text-center align-middle" scope="col">Tag Sling Belt</th>
                                <th class="text-center align-middle" scope="col">Belt Robek</th>
                                <th class="text-center align-middle" scope="col">Belt Kusut</th>
                                <th class="text-center align-middle" scope="col">Jahitan Belt</th>
                                <th class="text-center align-middle" scope="col">Belt Menipis</th>
                                <th class="text-center align-middle" scope="col">Belt Scratch</th>
                                <th class="text-center align-middle" scope="col">Belt Aus</th>
                                <th class="text-center align-middle" scope="col">Hook Wire</th>
                                <th class="text-center align-middle" scope="col">Pengunci Hook</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($checksheets as $checksheet)
                                <tr class="align-middle text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ strftime('%e %B %Y', strtotime($checksheet->created_at)) }}</td>
                                    <td>{{ $checksheet->sling_number }}</td>

                                    @if ($checksheet->kelengkapan_tag_sling_belt === 'NG')
                                        <td class="text-danger fw-bolder">
                                            {{ $checksheet->kelengkapan_tag_sling_belt }}
                                        </td>
                                    @else
                                        <td>{{ $checksheet->kelengkapan_tag_sling_belt }}
                                        </td>
                                    @endif

                                    @if ($checksheet->bagian_pinggir_belt_robek === 'NG')
                                        <td class="text-danger fw-bolder">
                                            {{ $checksheet->bagian_pinggir_belt_robek }}
                                        </td>
                                    @else
                                        <td>{{ $checksheet->bagian_pinggir_belt_robek }}
                                        </td>
                                    @endif

                                    @if ($checksheet->pengecekan_lapisan_belt_1 === 'NG')
                                        <td class="text-danger fw-bolder">
                                            {{ $checksheet->pengecekan_lapisan_belt_1 }}
                                        </td>
                                    @else
                                        <td>{{ $checksheet->pengecekan_lapisan_belt_1 }}
                                        </td>
                                    @endif

                                    @if ($checksheet->pengecekan_jahitan_belt === 'NG')
                                        <td class="text-danger fw-bolder">
                                            {{ $checksheet->pengecekan_jahitan_belt }}
                                        </td>
                                    @else
                                        <td>{{ $checksheet->pengecekan_jahitan_belt }}
                                        </td>
                                    @endif

                                    @if ($checksheet->pengecekan_permukaan_belt === 'NG')
                                        <td class="text-danger fw-bolder">
                                            {{ $checksheet->pengecekan_permukaan_belt }}
                                        </td>
                                    @else
                                        <td>{{ $checksheet->pengecekan_permukaan_belt }}
                                        </td>
                                    @endif

                                    @if ($checksheet->pengecekan_lapisan_belt_2 === 'NG')
                                        <td class="text-danger fw-bolder">
                                            {{ $checksheet->pengecekan_lapisan_belt_2 }}
                                        </td>
                                    @else
                                        <td>{{ $checksheet->pengecekan_lapisan_belt_2 }}
                                        </td>
                                    @endif

                                    @if ($checksheet->pengecekan_aus === 'NG')
                                        <td class="text-danger fw-bolder">
                                            {{ $checksheet->pengecekan_aus }}
                                        </td>
                                    @else
                                        <td>{{ $checksheet->pengecekan_aus }}
                                        </td>
                                    @endif

                                    @if ($checksheet->hook_wire === 'NG')
                                        <td class="text-danger fw-bolder">
                                            {{ $checksheet->hook_wire }}
                                        </td>
                                    @else
                                        <td>{{ $checksheet->hook_wire }}
                                        </td>
                                    @endif

                                    @if ($checksheet->pengunci_hook === 'NG')
                                        <td class="text-danger fw-bolder">
                                            {{ $checksheet->pengunci_hook }}
                                        </td>
                                    @else
                                        <td>{{ $checksheet->pengunci_hook }}
                                        </td>
                                    @endif

                                    <td class="text-center align-middle">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a href="{{ route('sling.checksheetbelt.show', $checksheet->id) }}"
                                                class="badge bg-info me-2">Info</a>
                                            @can('admin')
                                                <a href="{{ route('sling.checksheetbelt.edit', $checksheet->id) }}"
                                                    class="badge bg-warning me-2">Edit</a>
                                                <form action="{{ route('sling.checksheetbelt.destroy', $checksheet->id) }}"
                                                    method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="badge bg-danger border-0"
                                                        onclick="return confirm('Ingin menghapus Data Check Sheet Sling?')">Delete</button>
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
