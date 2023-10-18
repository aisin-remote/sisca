@extends('dashboard.app')
@section('title', 'Data Safety Belt')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Info Safety Belt</h1>
        <a href="{{ route('safety-belt.edit', $safetybelt->id) }}" class="btn btn-warning">Edit</a>
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
                <div class="h6 col-3">No Safety Belt</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $safetybelt->no_safetybelt }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Area</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $safetybelt->locations->location_name }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Plant</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $safetybelt->plant }}</div>
            </div>
        </div>
    </div>
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Riwayat Check Sheet Safety Belt</h1>
        <div class="form-group">
            <form action="{{ route('safety-belt.show', $safetybelt->id) }}" method="GET">
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
    <form action="{{ route('export.checksheetssafetybelt') }}" method="POST" class="col-md-6 mb-3">
        @method('POST')
        @csrf
        <div class="form-group mb-3">
            <label for="tahun">Download Checksheet Safety Belt</label>
            <select name="tahun" id="tahun" class="form-control" required>
                @for ($year = $firstYear; $year <= $lastYear; $year++)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
            <!-- Tambahkan input hidden untuk no_tabung -->
            <input type="hidden" name="safetybelt_number" value="{{ $safetybelt->no_safetybelt }}">
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
                            <th rowspan="2" scope="col" class="text-center align-middle">No Safety Belt</th>
                            <th colspan="10" scope="colgroup" class="text-center">Item Check</th>
                            <th rowspan="2" scope="col" class="text-center align-middle">Aksi</th>
                        </tr>
                        <tr>
                            <th class="text-center align-middle">Buckle</th>
                            <th class="text-center align-middle">Seams</th>
                            <th class="text-center align-middle">Reel</th>
                            <th class="text-center align-middle">Shock Absorber</th>
                            <th class="text-center align-middle">Ring</th>
                            <th class="text-center align-middle">Torso Belt</th>
                            <th class="text-center align-middle">Strap</th>
                            <th class="text-center align-middle">Rope</th>
                            <th class="text-center align-middle">Seam Protection Tube</th>
                            <th class="text-center align-middle">Hook</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheets as $checksheet)
                            <tr class="align-middle">
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="text-center align-middle">
                                    {{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                <td class="text-center align-middle">{{ $checksheet->safetybelt_number }}</td>
                                <td class="text-center align-middle">{{ $checksheet->buckle }}</td>
                                <td class="text-center align-middle">{{ $checksheet->seams }}</td>
                                <td class="text-center align-middle">{{ $checksheet->reel }}</td>
                                <td class="text-center align-middle">{{ $checksheet->shock_absorber }}</td>
                                <td class="text-center align-middle">{{ $checksheet->ring }}</td>
                                <td class="text-center align-middle">{{ $checksheet->torso_belt }}</td>
                                <td class="text-center align-middle">{{ $checksheet->strap }}</td>
                                <td class="text-center align-middle">{{ $checksheet->rope }}</td>
                                <td class="text-center align-middle">{{ $checksheet->seam_protection_tube }}</td>
                                <td class="text-center align-middle">{{ $checksheet->hook }}</td>
                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('safetybelt.checksheetsafetybelt.show', $checksheet->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        <a href="{{ route('safetybelt.checksheetsafetybelt.edit', $checksheet->id) }}"
                                            class="badge bg-warning me-2">Edit</a>
                                        <form action="{{ route('safetybelt.checksheetsafetybelt.destroy', $checksheet->id) }}"
                                            method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge bg-danger border-0"
                                                onclick="return confirm('Ingin menghapus Data Check Sheet Safety Belt?')">Delete</button>
                                        </form>
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
