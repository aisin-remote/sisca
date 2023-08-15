@extends('dashboard.app')
@section('title', 'Data Location')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Data Location</h1>
        <a href="/dashboard/apar/data_location/create" class="btn btn-success"><span data-feather="file-plus"></span> Tambah</a>
    </div>
    <div class="table-responsive col-lg-12">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Location Name</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($locations as $location)
            <tr class="align-middle">
              <td>{{ $loop->iteration }}</td>
              <td>{{ $location->location_name }}</td>
              <td>
                <form action="/" method="POST">
                    <a href="/" class="badge text-bg-danger"><span data-feather="edit"></span></a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="badge bg-danger border-0" onclick="return confirm('Ingin menghapus Data UKT Mahasiswa?')"><span data-feather="x-circle"></span></button>
                </form>
              </td>
            </tr>
            @empty
                <td colspan="12">Tidak ada data...</td>
            @endforelse
          </tbody>
        </table>
      </div>
@endsection
