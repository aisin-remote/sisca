@extends('dashboard.app')
@section('title', 'Data Check Sheet Apar')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h3>Data Check Sheet Apar Co2/AF11E</h3>
        {{-- <form action="{{ route('export.checksheetsco2') }}" method="POST">
            @method('POST')
            @csrf
            <button type="submit" class="btn btn-primary">Export to Excel</button>
        </form> --}}
        <form action="{{ route('checksheet.index') }}" method="GET">
            <label for="tanggal_filter">Filter Tanggal:</label>
            <div class="input-group">
                <input type="date" name="tanggal_filter" class="form-control" id="tanggal_filter">
                <button class="btn btn-success" id="filterButton">Filter</button>
            </div>
        </form>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-12">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="table-responsive col-lg-12">
                <table class="table table-striped table-sm" id="dtBasicExample2">
                    <thead>
                        <tr class="text-center align-middle">
                            <th scope="col">#</th>
                            <th scope="col">Tanggal Pengecekan</th>
                            {{-- <th scope="col">Terakhir Update</th> --}}
                            <th scope="col">NPK</th>
                            <th scope="col">Apar Number</th>
                            <th scope="col">Location Apar</th>
                            <th scope="col">Pressure</th>
                            <th scope="col">Hose</th>
                            <th scope="col">Corong</th>
                            <th scope="col">Tabung</th>
                            <th scope="col">Regulator</th>
                            <th scope="col">Lock Pin</th>
                            <th scope="col">Berat Tabung</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheetco2 as $checksheet)
                            <tr class="text-center align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                {{-- <td>{{ strftime('%e %B %Y', strtotime($checksheet->updated_at)) }}</td> --}}
                                <td>{{ $checksheet->npk }}</td>
                                <td>{{ $checksheet->apar_number }}</td>
                                <td>
                                    {{ $checksheet->apars->locations->location_name ?? 'Tidak ada lokasi' }}
                                </td>

                                @if ($checksheet->pressure === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->pressure }}</td>
                                @else
                                    <td>{{ $checksheet->pressure }}</td>
                                @endif

                                @if ($checksheet->hose === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->hose }}</td>
                                @else
                                    <td>{{ $checksheet->hose }}</td>
                                @endif

                                @if ($checksheet->corong === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->corong }}</td>
                                @else
                                    <td>{{ $checksheet->corong }}</td>
                                @endif

                                @if ($checksheet->tabung === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->tabung }}</td>
                                @else
                                    <td>{{ $checksheet->tabung }}</td>
                                @endif

                                @if ($checksheet->regulator === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->regulator }}</td>
                                @else
                                    <td>{{ $checksheet->regulator }}</td>
                                @endif

                                @if ($checksheet->lock_pin === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->lock_pin }}</td>
                                @else
                                    <td>{{ $checksheet->lock_pin }}</td>
                                @endif

                                @if ($checksheet->berat_tabung === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->berat_tabung }}</td>
                                @else
                                    <td>{{ $checksheet->berat_tabung }}</td>
                                @endif

                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('apar.checksheetco2.show', $checksheet->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        @can('admin')
                                            <a href="{{ route('apar.checksheetco2.edit', $checksheet->id) }}"
                                                class="badge bg-warning me-2">Edit</a>
                                            <form action="{{ route('apar.checksheetco2.destroy', $checksheet->id) }}"
                                                method="POST" class="delete-form">
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
                            <td colspan="13">Tidak ada data...</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-5 pb-2 mb-3 border-bottom col-lg-12">
        <h3>Data Check Sheet Apar Powder</h3>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-12">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="table-responsive col-lg-12">
                <table class="table table-striped table-sm" id="dtBasicExample">
                    <thead>
                        <tr class="text-center align-middle">
                            <th scope="col">#</th>
                            <th scope="col">Tanggal Pengecekan</th>
                            {{-- <th scope="col">Terakhir Update</th> --}}
                            <th scope="col">NPK</th>
                            <th scope="col">Apar Number</th>
                            <th scope="col">Location Apar</th>
                            <th scope="col">Pressure</th>
                            <th scope="col">Hose</th>
                            <th scope="col">Tabung</th>
                            <th scope="col">Regulator</th>
                            <th scope="col">Lock Pin</th>
                            <th scope="col">Powder</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheetpowder as $checksheet)
                            <tr class="text-center align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                {{-- <td>{{ strftime('%e %B %Y', strtotime($checksheet->updated_at)) }}</td> --}}
                                <td>{{ $checksheet->npk }}</td>
                                <td>{{ $checksheet->apar_number }}</td>
                                <td>
                                    {{ $checksheet->apars->locations->location_name ?? 'Tidak ada lokasi' }}
                                </td>

                                @if ($checksheet->pressure === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->pressure }}</td>
                                @else
                                    <td>{{ $checksheet->pressure }}</td>
                                @endif

                                @if ($checksheet->hose === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->hose }}</td>
                                @else
                                    <td>{{ $checksheet->hose }}</td>
                                @endif

                                @if ($checksheet->tabung === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->tabung }}</td>
                                @else
                                    <td>{{ $checksheet->tabung }}</td>
                                @endif

                                @if ($checksheet->regulator === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->regulator }}</td>
                                @else
                                    <td>{{ $checksheet->regulator }}</td>
                                @endif

                                @if ($checksheet->lock_pin === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->lock_pin }}</td>
                                @else
                                    <td>{{ $checksheet->lock_pin }}</td>
                                @endif

                                @if ($checksheet->powder === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->powder }}</td>
                                @else
                                    <td>{{ $checksheet->powder }}</td>
                                @endif

                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('apar.checksheetpowder.show', $checksheet->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        @can('admin')
                                            <a href="{{ route('apar.checksheetpowder.edit', $checksheet->id) }}"
                                                class="badge bg-warning me-2">Edit</a>
                                            <form action="{{ route('apar.checksheetpowder.destroy', $checksheet->id) }}"
                                                method="POST" class="delete-form">
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
                            <td colspan="13">Tidak ada data...</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table1 = $('#dtBasicExample1').DataTable();
            var table2 = $('#dtBasicExample2').DataTable();
        });
    </script>
@endsection
