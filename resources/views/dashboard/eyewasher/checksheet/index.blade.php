@extends('dashboard.app')
@section('title', 'Data Check Sheet Eyewasher')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h3>Data Check Sheet Eye Washer</h3>
        <form action="{{ route('eyewasher.checksheet.index') }}" method="GET">
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
                            {{-- <th scope="col">Terakhir Update</th> --}}
                            <th scope="col">NPK</th>
                            <th scope="col">No Eye Washer</th>
                            <th scope="col">Location Eye Washer</th>
                            <th scope="col">Plant</th>
                            <th scope="col">Pijakan</th>
                            <th scope="col">Pipa Saluran Air</th>
                            <th scope="col">Wastafel</th>
                            <th scope="col">Kran Air</th>
                            <th scope="col">Tuas</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheeteyewasher as $checksheet)
                            <tr class="text-center align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                {{-- <td>{{ strftime('%e %B %Y', strtotime($checksheet->updated_at)) }}</td> --}}
                                <td>{{ $checksheet->npk }}</td>
                                <td>{{ $checksheet->eyewasher_number }}</td>
                                <td>{{ $checksheet->eyewashers->locations->location_name }}</td>
                                <td>{{ $checksheet->eyewashers->plant }}</td>
                                <td>{{ $checksheet->pijakan }}</td>
                                <td>{{ $checksheet->pipa_saluran_air }}</td>
                                <td>{{ $checksheet->wastafel }}</td>
                                <td>{{ $checksheet->kran_air }}</td>
                                <td>{{ $checksheet->tuas }}</td>
                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('eyewasher.checksheeteyewasher.show', $checksheet->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        <a href="{{ route('eyewasher.checksheeteyewasher.edit', $checksheet->id) }}"
                                            class="badge bg-warning me-2">Edit</a>
                                        <form action="{{ route('eyewasher.checksheeteyewasher.destroy', $checksheet->id) }}" method="POST"
                                            class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge bg-danger border-0"
                                                onclick="return confirm('Ingin menghapus Data Check Sheet Eye Washer?')">Delete</button>
                                        </form>
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
        <h3>Data Check Sheet Eye Washer + Shower</h3>
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
                            <th scope="col">No Eye Washer</th>
                            <th scope="col">Location Eye Washer</th>
                            <th scope="col">Plant</th>
                            <th scope="col">Instalation Base</th>
                            <th scope="col">Pipa Saluran Air</th>
                            <th scope="col">Wastafel Eye Wash</th>
                            <th scope="col">Tuas Eye Wash</th>
                            <th scope="col">Kran Eye Wash</th>
                            <th scope="col">Tuas Shower</th>
                            <th scope="col">Sign</th>
                            <th scope="col">Shower Head</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheetshower as $checksheet)
                            <tr class="text-center align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                {{-- <td>{{ strftime('%e %B %Y', strtotime($checksheet->updated_at)) }}</td> --}}
                                <td>{{ $checksheet->npk }}</td>
                                <td>{{ $checksheet->eyewasher_number }}</td>
                                <td>{{ $checksheet->eyewashers->locations->location_name }}</td>
                                <td>{{ $checksheet->eyewashers->plant }}</td>
                                <td>{{ $checksheet->instalation_base }}</td>
                                <td>{{ $checksheet->pipa_saluran_air }}</td>
                                <td>{{ $checksheet->wastafel_eye_wash }}</td>
                                <td>{{ $checksheet->tuas_eye_wash }}</td>
                                <td>{{ $checksheet->kran_eye_wash }}</td>
                                <td>{{ $checksheet->tuas_shower }}</td>
                                <td>{{ $checksheet->sign }}</td>
                                <td>{{ $checksheet->shower_head }}</td>
                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('eyewasher.checksheetshower.show', $checksheet->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        <a href="{{ route('eyewasher.checksheetshower.edit', $checksheet->id) }}"
                                            class="badge bg-warning me-2">Edit</a>
                                        <form action="{{ route('eyewasher.checksheetshower.destroy', $checksheet->id) }}" method="POST"
                                            class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge bg-danger border-0"
                                                onclick="return confirm('Ingin menghapus Data Check Sheet Eyewasher + Shower?')">Delete</button>
                                        </form>
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
