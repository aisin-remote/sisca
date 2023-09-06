@extends('dashboard.app')
@section('title', 'Data Tandu')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Tambah Data Tandu</h1>
    </div>
    <form action="/dashboard/master/tandu" method="POST" class="mb-5 col-lg-12" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="no_tandu" class="form-label">No Tandu</label>
                <input type="text" name="no_tandu" id="no_tandu" placeholder="Masukkan No Tandu"
                    class="form-control @error('no_tandu') is-invalid @enderror" value="{{ old('no_tandu') }}" required
                    autofocus>
                @error('no_tandu')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label for="location_id" class="form-label">Area</label>
                <select name="location_id" id="location_id" class="form-control @error('location_id') is-invalid @enderror">
                    <option selected disabled>Pilih Area</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                            {{ $location->location_name }}</option>
                    @endforeach
                </select>
                @error('location_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-success">Tambah</button>
    </form>

@endsection
