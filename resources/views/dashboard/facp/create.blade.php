@extends('dashboard.app')
@section('title', 'Data FACP')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Tambah Data FACP</h1>
    </div>
    <form action="/dashboard/master/facp" method="POST" class="mb-5 col-lg-12" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="zona" class="form-label">Zona</label>
                <input type="text" step="1" name="zona" id="zona" placeholder="Masukkan Zona"
                    class="form-control @error('zona') is-invalid @enderror" value="{{ old('zona') }}" required
                    autofocus>
                @error('zona')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label for="nomor_adress" class="form-label">Nomor Adress</label>
                <input type="number" name="nomor_adress" id="nomor_adress" placeholder="Masukkan Nomor Adress"
                    class="form-control @error('nomor_adress') is-invalid @enderror" value="{{ old('nomor_adress') }}">
                @error('nomor_adress')
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
