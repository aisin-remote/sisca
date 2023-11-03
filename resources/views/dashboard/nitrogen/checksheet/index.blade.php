@extends('dashboard.app')
@section('title', 'Data Check Sheet Nitrogen')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h3>Data Check Sheet Nitrogen</h3>
        <form action="{{ route('nitrogen.checksheet.index') }}" method="GET">
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
                            <th scope="col">Location Nitrogen</th>
                            <th scope="col">Indikator System Power</th>
                            <th scope="col">Selector Mode Automatic</th>
                            <th scope="col">Pintu Tabung</th>
                            <th scope="col">Pressure Tabung Pilot Nitrogen</th>
                            <th scope="col">Pressure Tabung Nitrogen No 1</th>
                            <th scope="col">Pressure Tabung Nitrogen No 2</th>
                            <th scope="col">Pressure Tabung Nitrogen No 3</th>
                            <th scope="col">Pressure Tabung Nitrogen No 4</th>
                            <th scope="col">Pressure Tabung Nitrogen No 5</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheetnitrogen as $checksheet)
                            <tr class="text-center align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                {{-- <td>{{ strftime('%e %B %Y', strtotime($checksheet->updated_at)) }}</td> --}}
                                <td>{{ $checksheet->npk }}</td>
                                <td>{{ $checksheet->tabung_number }}</td>
                                <td>{{ $checksheet->nitrogens->locations->location_name }}</td>

                                @if ($checksheet->operasional === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->operasional }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->operasional }}</td>
                                @endif

                                @if ($checksheet->selector_mode === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->selector_mode }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->selector_mode }}</td>
                                @endif

                                @if ($checksheet->pintu_tabung === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->pintu_tabung }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->pintu_tabung }}</td>
                                @endif

                                @if ($checksheet->pressure_pilot === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->pressure_pilot }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->pressure_pilot }}</td>
                                @endif

                                @if ($checksheet->pressure_no1 === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->pressure_no1 }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->pressure_no1 }}</td>
                                @endif

                                @if ($checksheet->pressure_no2 === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->pressure_no2 }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->pressure_no2 }}</td>
                                @endif

                                @if ($checksheet->pressure_no3 === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->pressure_no3 }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->pressure_no3 }}</td>
                                @endif

                                @if ($checksheet->pressure_no4 === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->pressure_no4 }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->pressure_no4 }}</td>
                                @endif

                                @if ($checksheet->pressure_no5 === 'NG')
                                    <td class="text-danger fw-bolder">{{ $checksheet->pressure_no5 }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->pressure_no5 }}</td>
                                @endif

                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('nitrogen.checksheetnitrogen.show', $checksheet->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        @can('admin')
                                            <a href="{{ route('nitrogen.checksheetnitrogen.edit', $checksheet->id) }}"
                                                class="badge bg-warning me-2">Edit</a>
                                            <form action="{{ route('nitrogen.checksheetnitrogen.destroy', $checksheet->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge bg-danger border-0"
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet Nitrogen?')">Delete</button>
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
