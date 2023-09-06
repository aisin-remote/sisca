@extends('dashboard.app')
@section('title', 'Data Hydrant')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Tambah Data Hydrant</h1>
    </div>
    <form action="/dashboard/master/hydrant" method="POST" class="mb-5 col-lg-12" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="no_hydrant" class="form-label">No Hydrant</label>
                <input type="text" name="no_hydrant" id="no_hydrant" placeholder="Masukkan No Hydrant"
                    class="form-control @error('no_hydrant') is-invalid @enderror" value="{{ old('no_hydrant') }}" required
                    autofocus>
                @error('no_hydrant')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label for="location_id" class="form-label">Location</label>
                <select name="location_id" id="location_id" class="form-control @error('location_id') is-invalid @enderror">
                    <option selected disabled>Pilih Location</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                            {{ $location->location_name }}</option>
                    @endforeach
                </select>
                @error('location_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label for="zona" class="form-label">Zona</label>
                <input type="text" name="zona" id="zona" placeholder="Masukkan Zona"
                    class="form-control @error('zona') is-invalid @enderror" value="{{ old('zona') }}">
                @error('zona')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label" for="type">Type</label>
                <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                    <option selected disabled>Pilih Type</option>
                    <option value="Indoor" {{ old('type') == 'Indoor' ? 'selected' : '' }}>Indoor</option>
                    <option value="Outdoor" {{ old('type') == 'Outdoor' ? 'selected' : '' }}>Outdoor</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Tambah</button>
    </form>

@endsection
