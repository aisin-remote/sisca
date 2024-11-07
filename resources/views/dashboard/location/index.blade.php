@extends('dashboard.app')
@section('title', 'Location')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Data Location</h1>
        @if (Auth::user()->role === 'MTE' || Auth::user()->role === 'Admin')
            <a href="/dashboard/master/location/create" class="btn btn-success"><span data-feather="file-plus"></span>
                Tambah</a>
        @endif
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-12">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="table-responsive col-lg-12">
        <table class="table table-striped table-sm" id="dtBasicExample">
            <thead>
                <tr class="text-center align-middle">
                    <th scope="col">#</th>
                    <th scope="col">Location Name</th>
                    @if (Auth::user()->role === 'MTE' || Auth::user()->role === 'Admin')
                        <th scope="col">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($locations as $location)
                    <tr class="text-center align-middle">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $location->location_name }}</td>
                        @if (Auth::user()->role === 'MTE' || Auth::user()->role === 'Admin')
                            <td>
                                <div class="d-flex align-items-center justify-content-center">
                                    <form action="{{ route('location.destroy', $location->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="badge bg-danger border-0"
                                            onclick="return confirm('Ingin menghapus Data Location?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <td colspan="12">Tidak ada data...</td>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
