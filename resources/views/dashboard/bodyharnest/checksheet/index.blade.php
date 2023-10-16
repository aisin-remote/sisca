@extends('dashboard.app')
@section('title', 'Data Check Sheet Body Harnest')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h3>Data Check Sheet Body Harnest</h3>
        <form action="{{ route('bodyharnest.checksheet.index') }}" method="GET">
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
                            <th scope="col">No Body Harnest</th>
                            <th scope="col">Shoulder Straps</th>
                            <th scope="col">Hook</th>
                            <th scope="col">Buckles Waist</th>
                            <th scope="col">Buckles Chest</th>
                            <th scope="col">Leg Straps</th>
                            <th scope="col">Buckles Leg</th>
                            <th scope="col">Back D-Ring</th>
                            <th scope="col">Carabiner</th>
                            <th scope="col">Straps / Rope</th>
                            <th scope="col">Shock Absorber</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheetbodyharnest as $checksheet)
                            <tr class="text-center align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                {{-- <td>{{ strftime('%e %B %Y', strtotime($checksheet->updated_at)) }}</td> --}}
                                <td>{{ $checksheet->npk }}</td>
                                <td>{{ $checksheet->bodyharnest_number }}</td>
                                <td>{{ $checksheet->shoulder_straps }}</td>
                                <td>{{ $checksheet->hook }}</td>
                                <td>{{ $checksheet->buckles_waist }}</td>
                                <td>{{ $checksheet->buckles_chest }}</td>
                                <td>{{ $checksheet->leg_straps }}</td>
                                <td>{{ $checksheet->buckles_leg }}</td>
                                <td>{{ $checksheet->back_d_ring }}</td>
                                <td>{{ $checksheet->carabiner }}</td>
                                <td>{{ $checksheet->straps_rope }}</td>
                                <td>{{ $checksheet->shock_absorber }}</td>
                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('bodyharnest.checksheetbodyharnest.show', $checksheet->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        <a href="{{ route('bodyharnest.checksheetbodyharnest.edit', $checksheet->id) }}"
                                            class="badge bg-warning me-2">Edit</a>
                                        <form action="{{ route('bodyharnest.checksheetbodyharnest.destroy', $checksheet->id) }}" method="POST"
                                            class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge bg-danger border-0"
                                                onclick="return confirm('Ingin menghapus Data Check Sheet Data Harnest?')">Delete</button>
                                        </form>
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
