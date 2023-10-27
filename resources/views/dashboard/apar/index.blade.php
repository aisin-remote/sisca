@extends('dashboard.app')
@section('title', 'Data Apar')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Data Apar</h1>
        @can('admin')
            <a href="/dashboard/master/apar/create" class="btn btn-success"><span data-feather="file-plus"></span> Tambah</a>
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
                    <th scope="col">Tag Number</th>
                    <th scope="col">Location</th>
                    <th scope="col">Expired</th>
                    <th scope="col">Post</th>
                    <th scope="col">Type</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($apars as $apar)
                    <tr class="text-center align-middle">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $apar->tag_number }}</td>
                        <td>{{ $apar->locations->location_name }}</td>
                        <td>{{ strftime('%e %B %Y', strtotime($apar->expired)) }}</td>
                        <td>{{ $apar->post }}</td>
                        <td>{{ $apar->type }}</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                <a href="{{ route('apar.show', $apar->id) }}" class="badge bg-info me-2">Info</a>
                                @can('admin')
                                    <a href="{{ route('apar.edit', $apar->id) }}" class="badge bg-warning me-2">Edit</a>
                                    <form action="{{ route('apar.destroy', $apar->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="badge bg-danger border-0"
                                            onclick="return confirm('Ingin menghapus Data Apar?')">Delete</button>
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
