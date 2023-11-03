@extends('dashboard.app')
@section('title', 'Data Check Sheet Co2')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h3>Data Check Sheet Co2</h3>
        <form action="{{ route('co2.checksheet.index') }}" method="GET">
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
                <table class="table table-striped table-sm" id="dtBasicExample1">
                    <thead>
                        <tr class="text-center align-middle">
                            <th scope="col">#</th>
                            <th scope="col">Tanggal Pengecekan</th>
                            <th scope="col">NPK</th>
                            <th scope="col">No Tabung</th>
                            <th scope="col">Location Co2</th>
                            <th scope="col">Cover</th>
                            <th scope="col">Tabung</th>
                            <th scope="col">Lock Pin</th>
                            <th scope="col">Segel Lock Pin</th>
                            <th scope="col">Kebocoran Regulator Tabung</th>
                            <th scope="col">Selang</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheettabungco2 as $checksheet)
                            <tr class="text-center align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                {{-- <td>{{ strftime('%e %B %Y', strtotime($checksheet->updated_at)) }}</td> --}}
                                <td>{{ $checksheet->npk }}</td>
                                <td>{{ $checksheet->tabung_number }}</td>
                                <td>{{ $checksheet->co2s->locations->location_name }}</td>

                                @if ($checksheet->cover === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->cover }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->cover }}</td>
                                @endif

                                @if ($checksheet->tabung === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->tabung }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->tabung }}</td>
                                @endif

                                @if ($checksheet->lock_pin === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->lock_pin }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->lock_pin }}</td>
                                @endif

                                @if ($checksheet->segel_lock_pin === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->segel_lock_pin }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->segel_lock_pin }}</td>
                                @endif

                                @if ($checksheet->kebocoran_regulator_tabung === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->kebocoran_regulator_tabung }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->kebocoran_regulator_tabung }}</td>
                                @endif

                                @if ($checksheet->selang === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->selang }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->selang }}</td>
                                @endif

                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('co2.checksheetco2.show', $checksheet->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        @can('admin')
                                            <a href="{{ route('co2.checksheetco2.edit', $checksheet->id) }}"
                                                class="badge bg-warning me-2">Edit</a>
                                            <form action="{{ route('co2.checksheetco2.destroy', $checksheet->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge bg-danger border-0"
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet Co2?')">Delete</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <td colspan="15">Tidak ada data...</td>
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
