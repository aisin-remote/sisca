@extends('dashboard.app')
@section('title', 'Data Chain Block')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Data Chain Block</h1>
        <a href="/dashboard/chainblock/data-chainblock/create" class="btn btn-success"><span data-feather="file-plus"></span> Tambah</a>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-12">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="table-responsive col-lg-12">
        <table class="table table-striped table-sm">
            <thead>
                <tr class="text-center align-middle">
                    <th scope="col">#</th>
                    <th scope="col">No Chain Block</th>
                    <th scope="col">Location</th>
                    <th scope="col">Handling Detail</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($chainblocks as $chainblock)
                    <tr class="text-center align-middle">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $chainblock->no_chainblock }}</td>
                        <td>{{ $chainblock->locations->location_name }}</td>
                        <td>{{ $chainblock->handling_detail }}</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                            <form action="{{ route('data-chainblock.destroy', $chainblock->id) }}" method="POST">
                                <a href="{{ route('data-chainblock.edit', $chainblock->id) }}" class="badge bg-warning">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="badge bg-danger border-0"
                                    onclick="return confirm('Ingin menghapus Data Chain Block?')">Delete</button>
                            </form>
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
