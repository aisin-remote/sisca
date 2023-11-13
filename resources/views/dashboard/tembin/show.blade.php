@extends('dashboard.app')
@section('title', 'Data Tembin')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Info Tembin</h1>
        @can('admin')
            <a href="{{ route('tembin.edit', $tembin->id) }}" class="btn btn-warning">Edit</a>
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
                <div class="h6 col-3">No Equip</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $tembin->no_equip }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Location</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $tembin->locations->location_name }}</div>
            </div>
        </div>
    </div>
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Riwayat Check Sheet Tembin</h1>
        <div class="form-group">
            <form action="{{ route('tembin.show', $tembin->id) }}" method="GET">
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
    <form action="{{ route('export.checksheetstembin.jimbi') }}" method="POST" class="col-md-6 mb-3">
        @method('POST')
        @csrf
        <div class="form-group mb-3">
            <label for="tahun">Download Checksheet Tembin</label>
            <select name="tahun" id="tahun" class="form-control" required>
                @for ($year = $firstYear; $year <= $lastYear; $year++)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
            <!-- Tambahkan input hidden untuk no_tabung -->
            <input type="hidden" name="tembin_number" value="{{ $tembin->no_equip }}">
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
                            <th rowspan="2" scope="col" class="text-center align-middle">No Equip</th>
                            <th colspan="6" scope="colgroup" class="text-center">Item Check</th>
                            <th rowspan="2" scope="col" class="text-center align-middle">Aksi</th>
                        </tr>
                        <tr>
                            <th class="text-center align-middle">Master Link</th>
                            <th class="text-center align-middle">Body Tembin</th>
                            <th class="text-center align-middle">Mur & Baut</th>
                            <th class="text-center align-middle">Shackle</th>
                            <th class="text-center align-middle">Hook Atas</th>
                            <th class="text-center align-middle">Pengunci Hook Atas</th>
                            <th class="text-center align-middle">Mata Chain</th>
                            <th class="text-center align-middle">Chain</th>
                            <th class="text-center align-middle">Hook Bawah</th>
                            <th class="text-center align-middle">Pengunci Hook Bawah</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheets as $checksheet)
                            <tr class="align-middle">
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="text-center align-middle">
                                    {{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                <td class="text-center align-middle">{{ $checksheet->tembin_number }}</td>

                                @if ($checksheet->master_link === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->master_link }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->master_link }}</td>
                                @endif

                                @if ($checksheet->body_tembin === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->body_tembin }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->body_tembin }}</td>
                                @endif

                                @if ($checksheet->mur_baut === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->mur_baut }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->mur_baut }}</td>
                                @endif

                                @if ($checksheet->shackle === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->shackle }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->shackle }}</td>
                                @endif

                                @if ($checksheet->hook_atas === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->hook_atas }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->hook_atas }}</td>
                                @endif

                                @if ($checksheet->pengunci_hook_atas === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->pengunci_hook_atas }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->pengunci_hook_atas }}</td>
                                @endif

                                @if ($checksheet->mata_chain === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->mata_chain }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->mata_chain }}</td>
                                @endif

                                @if ($checksheet->chain === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->chain }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->chain }}</td>
                                @endif

                                @if ($checksheet->hook_bawah === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->hook_bawah }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->hook_bawah }}</td>
                                @endif

                                @if ($checksheet->pengunci_hook_bawah === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->pengunci_hook_bawah }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->pengunci_hook_bawah }}</td>
                                @endif

                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('tembin.checksheettembin.show', $checksheet->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        @can('admin')
                                            <a href="{{ route('tembin.checksheettembin.edit', $checksheet->id) }}"
                                                class="badge bg-warning me-2">Edit</a>
                                            <form action="{{ route('tembin.checksheettembin.destroy', $checksheet->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge bg-danger border-0"
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet Tembin?')">Delete</button>
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
