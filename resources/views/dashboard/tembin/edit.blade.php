@extends('dashboard.app')
@section('title', 'Data Tembin')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Edit Data Tembin</h1>
    </div>
    <form action="{{ route('tembin.update', $tembin->id) }}" method="POST" class="mb-5 col-lg-12" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="no_equip" class="form-label">No Equip</label>
                <input type="text" name="no_equip" id="no_equip" placeholder="Masukkan No Equip"
                    class="form-control @error('no_equip') is-invalid @enderror" value="{{ old('no_equip') ?? $tembin->no_equip}}" readonly>
                @error('no_equip')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label for="location_id" class="form-label">Location</label>
                <select name="location_id" id="location_id" class="form-control @error('location_id') is-invalid @enderror">
                    <option selected disabled>Pilih Location</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" {{ old('location_id') ?? $tembin->location_id == $location->id ? 'selected' : '' }}>
                            {{ $location->location_name }}</option>
                    @endforeach
                </select>
                @error('location_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-warning">Edit</button>
    </form>

@endsection
