@extends('dashboard.app')
@section('title', 'Data Check Sheet Tandu')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h3>Data Check Sheet Tandu</h3>
        <form action="{{ route('tandu.checksheet.index') }}" method="GET">
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
                            <th scope="col">No Tandu</th>
                            <th scope="col">Area</th>
                            <th scope="col">Kunci Pintu</th>
                            <th scope="col">Pintu</th>
                            <th scope="col">Sign</th>
                            <th scope="col">Hand Grip</th>
                            <th scope="col">Body</th>
                            <th scope="col">Engsel</th>
                            <th scope="col">Kaki</th>
                            <th scope="col">Belt</th>
                            <th scope="col">Rangka</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheettandu as $checksheet)
                            <tr class="text-center align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                {{-- <td>{{ strftime('%e %B %Y', strtotime($checksheet->updated_at)) }}</td> --}}
                                <td>{{ $checksheet->npk }}</td>
                                <td>{{ $checksheet->tandu_number }}</td>
                                <td>{{ $checksheet->tandus->locations->location_name }}</td>
                                <td>{{ $checksheet->kunci_pintu }}</td>
                                <td>{{ $checksheet->pintu }}</td>
                                <td>{{ $checksheet->sign }}</td>
                                <td>{{ $checksheet->hand_grip }}</td>
                                <td>{{ $checksheet->body }}</td>
                                <td>{{ $checksheet->engsel }}</td>
                                <td>{{ $checksheet->kaki }}</td>
                                <td>{{ $checksheet->belt }}</td>
                                <td>{{ $checksheet->rangka }}</td>
                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('tandu.checksheettandu.show', $checksheet->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        <a href="{{ route('tandu.checksheettandu.edit', $checksheet->id) }}"
                                            class="badge bg-warning me-2">Edit</a>
                                        <form action="{{ route('tandu.checksheettandu.destroy', $checksheet->id) }}" method="POST"
                                            class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge bg-danger border-0"
                                                onclick="return confirm('Ingin menghapus Data Check Sheet Tandu?')">Delete</button>
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
