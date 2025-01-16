@extends('dashboard.app')
@section('title', 'Data Head Crane')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Data Head Crane</h1>
        @if (Auth::user()->role === 'MTE' || Auth::user()->role === 'Admin')
            <a href="/dashboard/master/head-crane/create" class="btn btn-success"><span data-feather="file-plus"></span>
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
                    <th scope="col">No Head Crane</th>
                    <th scope="col">Lokasi</th>
                    <th scope="col">Plant</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($head_crane as $data)
                    <tr class="text-center align-middle">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->no_headcrane }}</td>
                        <td>{{ $data->locations->location_name }}</td>
                        <td>{{ $data->plant }}</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">

                                <a href="{{ route('head-crane.show', $data->id) }}" class="badge bg-info me-2">Info</a>
                                @if (Auth::user()->role === 'MTE' || Auth::user()->role === 'Admin')
                                    <a href="{{ route('head-crane.edit', $data->id) }}"
                                        class="badge bg-warning me-2">Edit</a>
                                    <form action="{{ route('head-crane.destroy', $data->id) }}" method="POST"
                                        class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="badge bg-danger border-0"
                                            onclick="return confirm('Ingin menghapus Data Head Crane?')">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <td colspan="12">Tidak ada data...</td>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
