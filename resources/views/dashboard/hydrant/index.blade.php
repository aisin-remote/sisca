@extends('dashboard.app')
@section('title', 'Data Hydrant')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Data Hydrant</h1>
        @can('admin')
            <a href="/dashboard/master/hydrant/create" class="btn btn-success"><span data-feather="file-plus"></span> Tambah</a>
        @endcan
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
                    <th scope="col">No Hydrant</th>
                    <th scope="col">Location</th>
                    <th scope="col">Zona</th>
                    <th scope="col">Type</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($hydrants as $hydrant)
                    <tr class="text-center align-middle">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $hydrant->no_hydrant }}</td>
                        <td>{{ $hydrant->locations->location_name }}</td>
                        <td>{{ $hydrant->zona }}</td>
                        <td>{{ $hydrant->type }}</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                <a href="{{ route('hydrant.show', $hydrant->id) }}" class="badge bg-info me-2">Info</a>
                                @can('admin')
                                    <a href="{{ route('hydrant.edit', $hydrant->id) }}" class="badge bg-warning me-2">Edit</a>
                                    <form action="{{ route('hydrant.destroy', $hydrant->id) }}" method="POST"
                                        class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="badge bg-danger border-0"
                                            onclick="return confirm('Ingin menghapus Data Hydrant?')">Delete</button>
                                    </form>
                                @endcan
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
