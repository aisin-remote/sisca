@extends('dashboard.app')
@section('title', 'Data Body Harnest')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Edit Data Body Harnest</h1>
    </div>
    <form action="{{ route('body-harnest.update', $bodyharnest->id) }}" method="POST" class="mb-5 col-lg-12" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="no_bodyharnest" class="form-label">No Body Harnest</label>
                <input type="text" name="no_bodyharnest" id="no_bodyharnest" placeholder="Masukkan No Body Harnest"
                    class="form-control @error('no_bodyharnest') is-invalid @enderror" value="{{ old('no_bodyharnest') ?? $bodyharnest->no_bodyharnest}}" readonly>
                @error('no_bodyharnest')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label for="tinggi" class="form-label">Tinggi</label>
                <input type="number" step="1" name="tinggi" id="tinggi" placeholder="Masukkan Tinggi"
                    class="form-control @error('tinggi') is-invalid @enderror" value="{{ old('tinggi') ?? $bodyharnest->tinggi}}">
                @error('tinggi')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label for="location_id" class="form-label">Area</label>
                <select name="location_id" id="location_id" class="form-control @error('location_id') is-invalid @enderror">
                    <option selected disabled>Pilih Area</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" {{ old('location_id') ?? $bodyharnest->location_id == $location->id ? 'selected' : '' }}>
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
                    class="form-control @error('plant') is-invalid @enderror" value="{{ old('plant') ?? $bodyharnest->plant}}">
                @error('plant')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-warning">Edit</button>
    </form>

@endsection
