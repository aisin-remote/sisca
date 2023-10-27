@extends('dashboard.app')
@section('title', 'Data Safety Belt')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Data Safety Belt</h1>
        @can('admin')
            <a href="/dashboard/master/safety-belt/create" class="btn btn-success"><span data-feather="file-plus"></span> Tambah</a>
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
                    <th scope="col">No Safety Belt</th>
                    <th scope="col">Area</th>
                    <th scope="col">Plant</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($safetybelts as $safetybelt)
                    <tr class="text-center align-middle">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $safetybelt->no_safetybelt }}</td>
                        <td>{{ $safetybelt->locations->location_name }}</td>
                        <td>{{ $safetybelt->plant }}</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                <a href="{{ route('safety-belt.show', $safetybelt->id) }}" class="badge bg-info me-2">Info</a>
                                @can('admin')
                                    <a href="{{ route('safety-belt.edit', $safetybelt->id) }}" class="badge bg-warning me-2">Edit</a>
                                    <form action="{{ route('safety-belt.destroy', $safetybelt->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="badge bg-danger border-0"
                                            onclick="return confirm('Ingin menghapus Data Safety Belt?')">Delete</button>
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
