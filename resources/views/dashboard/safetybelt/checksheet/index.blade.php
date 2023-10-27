@extends('dashboard.app')
@section('title', 'Data Check Sheet Safety Bet')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h3>Data Check Sheet Safety Belt</h3>
        <form action="{{ route('safetybelt.checksheet.index') }}" method="GET">
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
                            <th scope="col">No Safety Belt</th>
                            <th scope="col">Buckle</th>
                            <th scope="col">Seams</th>
                            <th scope="col">Reel</th>
                            <th scope="col">Shock_absorber</th>
                            <th scope="col">Ring</th>
                            <th scope="col">Torso Belt</th>
                            <th scope="col">Strap</th>
                            <th scope="col">Rope</th>
                            <th scope="col">Seam Protection Tube</th>
                            <th scope="col">Hook</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheetsafetybelt as $checksheet)
                            <tr class="text-center align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                {{-- <td>{{ strftime('%e %B %Y', strtotime($checksheet->updated_at)) }}</td> --}}
                                <td>{{ $checksheet->npk }}</td>
                                <td>{{ $checksheet->safetybelt_number }}</td>
                                <td>{{ $checksheet->buckle }}</td>
                                <td>{{ $checksheet->seams }}</td>
                                <td>{{ $checksheet->reel }}</td>
                                <td>{{ $checksheet->shock_absorber }}</td>
                                <td>{{ $checksheet->ring }}</td>
                                <td>{{ $checksheet->torso_belt }}</td>
                                <td>{{ $checksheet->strap }}</td>
                                <td>{{ $checksheet->rope }}</td>
                                <td>{{ $checksheet->seam_protection_tube }}</td>
                                <td>{{ $checksheet->hook }}</td>
                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('safetybelt.checksheetsafetybelt.show', $checksheet->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        @can('admin')
                                            <a href="{{ route('safetybelt.checksheetsafetybelt.edit', $checksheet->id) }}"
                                                class="badge bg-warning me-2">Edit</a>
                                            <form
                                                action="{{ route('safetybelt.checksheetsafetybelt.destroy', $checksheet->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge bg-danger border-0"
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet Data Harnest?')">Delete</button>
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
