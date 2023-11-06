@extends('dashboard.app')
@section('title', 'Data Check Sheet FACP')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h3>Data Check Sheet FACP</h3>
        <form action="{{ route('facp.checksheet.index') }}" method="GET">
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
                            <th scope="col">No Zona</th>
                            <th scope="col">Smoke Detector</th>
                            <th scope="col">Heat Detector</th>
                            <th scope="col">Beam Detector</th>
                            <th scope="col">Push Button</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheetfacp as $checksheet)
                            <tr class="text-center align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ strftime('%e %B %Y', strtotime($checksheet->created_at)) }}</td>
                                {{-- <td>{{ strftime('%e %B %Y', strtotime($checksheet->updated_at)) }}</td> --}}
                                <td>{{ $checksheet->npk }}</td>
                                <td>{{ $checksheet->zona_number }}</td>

                                @if ($checksheet->ng_smoke_detector != '0')
                                    <td class="text-danger fw-bolder">
                                        NG
                                    </td>
                                @else
                                    <td>OK</td>
                                @endif

                                @if ($checksheet->ng_heat_detector != '0')
                                    <td class="text-danger fw-bolder">
                                        NG
                                    </td>
                                @else
                                    <td>OK</td>
                                @endif

                                @if ($checksheet->ng_beam_detector != '0')
                                    <td class="text-danger fw-bolder">
                                        NG
                                    </td>
                                @else
                                    <td>OK</td>
                                @endif

                                @if ($checksheet->ng_push_button != '0')
                                    <td class="text-danger fw-bolder">
                                        NG
                                    </td>
                                @else
                                    <td>OK</td>
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
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet FACP?')">Delete</button>
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
