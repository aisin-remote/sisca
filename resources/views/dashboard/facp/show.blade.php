@extends('dashboard.app')
@section('title', 'Data Facp')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Info Facp</h1>
        @can('admin')
            <a href="{{ route('facp.edit', $facp->id) }}" class="btn btn-warning">Edit</a>
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
                <div class="h6 col-3">Zona</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $facp->zona }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Area</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $facp->locations->location_name }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">No Adress</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $facp->nomor_adress }}</div>
            </div>
        </div>
    </div>
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Riwayat Check Sheet Facp</h1>
        <div class="form-group">
            <form action="{{ route('facp.show', $facp->id) }}" method="GET">
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
    {{-- <form action="{{ route('export.checksheetsfacp') }}" method="POST" class="col-md-6 mb-3">
        @method('POST')
        @csrf
        <div class="form-group mb-3">
            <label for="tahun">Download Checksheet Facp</label>
            <select name="tahun" id="tahun" class="form-control" required>
                @for ($year = $firstYear; $year <= $lastYear; $year++)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
            <!-- Tambahkan input hidden untuk no_tabung -->
            <input type="hidden" name="zona_number" value="{{ $facp->zona }}">
        </div>
        <button type="submit" class="btn btn-primary"><i class="bi bi-download"></i> | Download</button>
    </form> --}}

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
                            <th rowspan="3" scope="col" class="text-center align-middle">#</th>
                            <th rowspan="3" scope="col" class="text-center align-middle">Tanggal</th>
                            <th rowspan="3" scope="col" class="text-center align-middle">Zona</th>
                            <th colspan="12" scope="colgroup" class="text-center">Item Check</th>
                            <th rowspan="3" scope="col" class="text-center align-middle">Aksi</th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-center align-middle">Smoke Detector</th>
                            <th colspan="3" class="text-center align-middle">Heat Detector</th>
                            <th colspan="3" class="text-center align-middle">Beam Detector</th>
                            <th colspan="3" class="text-center align-middle">Push Button</th>
                        </tr>
                        <tr>
                            <th class="text-center align-middle">Total</th>
                            <th class="text-center align-middle">OK</th>
                            <th class="text-center align-middle">NG</th>
                            <th class="text-center align-middle">Total</th>
                            <th class="text-center align-middle">OK</th>
                            <th class="text-center align-middle">NG</th>
                            <th class="text-center align-middle">Total</th>
                            <th class="text-center align-middle">OK</th>
                            <th class="text-center align-middle">NG</th>
                            <th class="text-center align-middle">Total</th>
                            <th class="text-center align-middle">OK</th>
                            <th class="text-center align-middle">NG</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheets as $checksheet)
                            <tr class="align-middle">
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="text-center align-middle">
                                    {{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                <td class="text-center align-middle">{{ $checksheet->zona_number }}</td>
                                <td class="text-center align-middle">
                                    {{ intval($checksheet->ok_smoke_detector) + intval($checksheet->ng_smoke_detector) }}
                                </td>
                                <td class="text-center align-middle">{{ $checksheet->ok_smoke_detector }}</td>
                                @if ($checksheet->ng_smoke_detector != '0')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->ng_smoke_detector }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->ng_smoke_detector }}</td>
                                @endif



                                <td class="text-center align-middle">
                                    {{ intval($checksheet->ok_heat_detector) + intval($checksheet->ng_heat_detector) }}
                                </td>
                                <td class="text-center align-middle">{{ $checksheet->ok_heat_detector }}</td>
                                @if ($checksheet->ng_heat_detector != '0')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->ng_heat_detector }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->ng_heat_detector }}</td>
                                @endif



                                <td class="text-center align-middle">
                                    {{ intval($checksheet->ok_beam_detector) + intval($checksheet->ng_beam_detector) }}
                                </td>
                                <td class="text-center align-middle">{{ $checksheet->ok_beam_detector }}</td>
                                @if ($checksheet->ng_beam_detector != '0')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->ng_beam_detector }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->ng_beam_detector }}</td>
                                @endif



                                <td class="text-center align-middle">
                                    {{ intval($checksheet->ok_push_button) + intval($checksheet->ng_push_button) }}
                                </td>
                                <td class="text-center align-middle">{{ $checksheet->ok_push_button }}</td>
                                @if ($checksheet->ng_push_button != '0')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->ng_push_button }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->ng_push_button }}</td>
                                @endif



                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('facp.checksheetfacp.show', $checksheet->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        @can('admin')
                                            <a href="{{ route('facp.checksheetfacp.edit', $checksheet->id) }}"
                                                class="badge bg-warning me-2">Edit</a>
                                            <form action="{{ route('facp.checksheetfacp.destroy', $checksheet->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge bg-danger border-0"
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet Facp?')">Delete</button>
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
