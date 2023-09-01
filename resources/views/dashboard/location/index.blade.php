@extends('dashboard.app')
@section('title', 'Location')

@section('content')
<div class="d-flex justify-content-between">
    <div class="col-md-3 d-flex justify-content-center align-items-center">
        <img src="{{ asset('foto/lokasi/Keterangan.png') }}" alt="Keterangan Gambar" style="max-width: 100%; height: auto;">
    </div>
    <div class="col-md d-flex justify-content-center align-items-center">
        <div class="zoom-container">
            <img class="zoom-image" src="{{ asset('foto/lokasi/Mapping All Equipment.png') }}" alt="Mapping All Equipment">
        </div>
    </div>
</div>



    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Data Location</h1>
        <a href="/dashboard/location/create" class="btn btn-success"><span data-feather="file-plus"></span>
            Tambah</a>
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
                    <th scope="col">Location Name</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($locations as $location)
                    <tr class="text-center align-middle">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $location->location_name }}</td>
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
                    </tr>
                @empty
                    <td colspan="12">Tidak ada data...</td>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
