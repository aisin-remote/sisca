@extends('dashboard.app')
@section('title', 'Data Sling')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Data Sling</h1>
        @can('admin')
            <a href="/dashboard/master/sling/create" class="btn btn-success"><span data-feather="file-plus"></span> Tambah</a>
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
                    <th scope="col">No Sling</th>
                    <th scope="col">SWL</th>
                    <th scope="col">Area</th>
                    <th scope="col">Plant</th>
                    <th scope="col">Type</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($slings as $sling)
                    <tr class="text-center align-middle">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $sling->no_sling }}</td>
                        <td>{{ $sling->swl }} Ton</td>
                        <td>{{ $sling->locations->location_name }}</td>
                        <td>{{ $sling->plant }}</td>
                        <td>{{ $sling->type }}</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                <a href="{{ route('sling.show', $sling->id) }}" class="badge bg-info me-2">Info</a>
                                @can('admin')
                                    <a href="{{ route('sling.edit', $sling->id) }}" class="badge bg-warning me-2">Edit</a>
                                    <form action="{{ route('sling.destroy', $sling->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="badge bg-danger border-0"
                                            onclick="return confirm('Ingin menghapus Data Sling?')">Delete</button>
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
