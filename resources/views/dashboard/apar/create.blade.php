@extends('dashboard.app')
@section('title', 'Data Apar')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Tambah Data Apar</h1>
    </div>
    <form action="/dashboard/master/apar" method="POST" class="mb-5 col-lg-12" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="tag_number" class="form-label">Tag Number</label>
                <input type="text" name="tag_number" id="tag_number" placeholder="Masukkan Tag Number"
                    class="form-control @error('tag_number') is-invalid @enderror" value="{{ old('tag_number') }}" required
                    autofocus>
                @error('tag_number')
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
                <label class="form-label" for="expired">Expired</label>
                <input type="date" name="expired" id="expired" class="form-control @error('expired') is-invalid @enderror"
                    value="{{ old('expired') }}">
                @error('expired')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label for="post" class="form-label">Post</label>
                <input type="text" name="post" id="post" placeholder="Masukkan Post"
                    class="form-control @error('post') is-invalid @enderror" value="{{ old('post') }}">
                @error('post')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label" for="type">Type</label>
                <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                    <option selected disabled>Pilih Type</option>
                    <option value="powder" {{ old('type') == 'powder' ? 'selected' : '' }}>Powder</option>
                    <option value="co2" {{ old('type') == 'co2' ? 'selected' : '' }}>CO2</option>
                    <option value="af11e" {{ old('type') == 'af11e' ? 'selected' : '' }}>AF11E</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Tambah</button>
    </form>

@endsection
