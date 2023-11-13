@extends('dashboard.app')
@section('title', 'Data FACP')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Edit Data FACP</h1>
    </div>
    <form action="{{ route('data-facp.update', $facp->id) }}" method="POST" class="mb-5 col-lg-12" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="zona" class="form-label">Zona</label>
                <input type="text" name="zona" id="zona" placeholder="Masukkan Zona"
                    class="form-control @error('zona') is-invalid @enderror" value="{{ old('zona') ?? $facp->zona}}" readonly>
                @error('zona')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3 col-md-6">
                <label for="location_id" class="form-label">Area</label>
                <select name="location_id" id="location_id" class="form-control @error('location_id') is-invalid @enderror">
                    <option selected disabled>Pilih Area</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" {{ old('location_id') ?? $facp->location_id == $location->id ? 'selected' : '' }}>
                            {{ $location->location_name }}</option>
                    @endforeach
                </select>
                @error('location_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label for="nomor_adress" class="form-label">No Adress</label>
                <input type="text" name="nomor_adress" id="nomor_adress" placeholder="Masukkan No Adress"
                    class="form-control @error('nomor_adress') is-invalid @enderror" value="{{ old('nomor_adress') ?? $facp->nomor_adress}}">
                @error('nomor_adress')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-warning">Edit</button>
    </form>

@endsection
