@extends('dashboard.app')
@section('title', 'Data Head Crane')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Edit Data Head Crane</h1>
    </div>
    <form action="{{ route('head-crane.update', $headcrane->id) }}" method="POST" class="mb-5 col-lg-12">
        @csrf
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="no_headcrane" class="form-label">No Head Crane</label>
                <input type="text" name="no_headcrane" id="no_headcrane" placeholder="Masukkan No Head Crane"
                    class="form-control @error('no_headcrane') is-invalid @enderror"
                    value="{{ old('no_headcrane') ?? $headcrane->no_headcrane }}" readonly>
                @error('no_headcrane')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3 col-md-6">
                <label for="location_id" class="form-label">Area</label>
                <select name="location_id" id="location_id" class="form-control @error('location_id') is-invalid @enderror">
                    <option selected disabled>Pilih Area</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}"
                            {{ old('location_id') ?? $headcrane->location_id == $location->id ? 'selected' : '' }}>
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
                    class="form-control @error('plant') is-invalid @enderror"
                    value="{{ old('plant') ?? $headcrane->plant }}">
                @error('plant')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-warning">Edit</button>
    </form>

@endsection
