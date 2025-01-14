@extends('dashboard.app')
@section('title', 'Data Head Crane')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Info Head Crane</h1>
        @if (Auth::user()->role === 'MTE' || Auth::user()->role === 'Admin')
            <a href="{{ route('head-crane.edit', $headcrane->id) }}" class="btn btn-warning">Edit</a>
        @endif
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
                <div class="h6 col-3">No Head Crane</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $headcrane->headcrane->no_headcrane }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Area</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $headcrane->headcrane->locations->location_name }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Plant</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $headcrane->headcrane->plant }}</div>
            </div>
        </div>
    </div>
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Riwayat Check Sheet Head Crane</h1>
        <div class="form-group">
            <form action="{{ route('head-crane.show', $headcrane->id) }}" method="GET">
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
    <form action="{{ route('export.checksheetsheadcrane') }}" method="POST" class="col-md-6 mb-3">
        @method('POST')
        @csrf
        <div class="form-group mb-3">
            <label for="tahun">Download Checksheet Head Crane</label>
            <select name="tahun" id="tahun" class="form-control" required>
                @for ($year = $firstYear; $year <= $lastYear; $year++)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
            <!-- Tambahkan input hidden untuk no_tabung -->
            <input type="hidden" name="headcrane_number" value="{{ $headcrane->no_headcrane }}">
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
            <div class="table-responsive col-md-12 px-3 py-3">
                <table class="table table-striped table-sm" id="dtBasicExample">
                    <thead>
                        <tr>
                            <th rowspan="2" scope="col" class="text-center align-middle">#</th>
                            <th rowspan="2" scope="col" class="text-center align-middle">Tanggal</th>
                            <th rowspan="2" scope="col" class="text-center align-middle">No Head Crane</th>
                            <th colspan="10" scope="colgroup" class="text-center">Item Check</th>
                            <th rowspan="2" scope="col" class="text-center align-middle">Aksi</th>
                        </tr>
                        <tr>
                            @foreach (['Visual Check', 'cross_traveling', 'long_traveling', 'button_up', 'button_down', 'button_push', 'wire_rope', 'block_hook', 'hom', 'emergency_stop'] as $item)
                                <th scope="col" class="text-center">{{ ucfirst(str_replace('_', ' ', $item)) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupedByCheckSheetId as $checkSheet)
                            <tr class="align-middle">
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="text-center align-middle">
                                    {{ \Carbon\Carbon::parse($headcrane->tanggal_pengecekan)->format('d F Y') }}
                                </td>
                                <td class="text-center align-middle">{{ $headcrane->headcrane->no_headcrane }}</td>
                                @foreach (['Visual Check', 'Cross Traveling', 'Long Traveling', 'Up Direction', 'Down Direction', 'Pendant Hoist', 'Wire Rope / Chain', 'Block Hook', 'Horn', 'Emergency Stop'] as $item)
                                    <td class="text-center">
                                        @if (isset($checkSheet['groupedByItemCheck'][$item]))
                                            {{ $checkSheet['groupedByItemCheck'][$item]['OK'] }} /
                                            {{ $checkSheet['groupedByItemCheck'][$item]['total'] }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endforeach
                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('headcrane.checksheetheadcrane.show', $headcrane->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        @if (Auth::user()->role === 'MTE' || Auth::user()->role === 'Admin')
                                            <a href="{{ route('headcrane.checksheetheadcrane.edit', $headcrane->id) }}"
                                                class="badge bg-warning me-2">Edit</a>
                                            <form
                                                action="{{ route('headcrane.checksheetheadcrane.destroy', $headcrane->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge bg-danger border-0"
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet Head Crane?')">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
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
