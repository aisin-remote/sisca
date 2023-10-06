@extends('dashboard.app')
@section('title', 'Data Sling')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Tambah Data Sling</h1>
    </div>
    <form action="/dashboard/master/sling" method="POST" class="mb-5 col-lg-12" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="no_sling" class="form-label">No Sling</label>
                <input type="text" name="no_sling" id="no_sling" placeholder="Masukkan No Sling"
                    class="form-control @error('no_sling') is-invalid @enderror" value="{{ old('no_sling') }}" required
                    autofocus>
                @error('no_sling')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label for="swl" class="form-label">SWL(Ton)</label>
                <input type="number" step="0.01" name="swl" id="swl" placeholder="Masukkan SWL"
                    class="form-control @error('swl') is-invalid @enderror" value="{{ old('swl') }}">
                @error('swl')
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
            <div class="mb-3 col-md-6">
                <label for="plant" class="form-label">Plant</label>
                <input type="text" name="plant" id="plant" placeholder="Masukkan Plant"
                    class="form-control @error('plant') is-invalid @enderror" value="{{ old('plant') }}">
                @error('plant')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label" for="type">Type</label>
                <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                    <option selected disabled>Pilih Type</option>
                    <option value="Sling Wire" {{ old('type') == 'Sling Wire' ? 'selected' : '' }}>Sling Wire</option>
                    <option value="Sling Belt" {{ old('type') == 'Sling Belt' ? 'selected' : '' }}>Sling Belt</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Tambah</button>
    </form>

@endsection
