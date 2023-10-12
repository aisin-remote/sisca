@extends('dashboard.app')
@section('title', 'Data Chain Block')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Tambah Data Chain Block</h1>
    </div>
    <form action="/dashboard/master/chain-block" method="POST" class="mb-5 col-lg-12" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="no_chainblock" class="form-label">No Chain Block</label>
                <input type="text" name="no_chainblock" id="no_chainblock" placeholder="Masukkan No Chain Block"
                    class="form-control @error('no_chainblock') is-invalid @enderror" value="{{ old('no_chainblock') }}"
                    required autofocus>
                @error('no_chainblock')
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
                <label for="handling_detail" class="form-label">Handling Detail</label>
                <input type="text" name="handling_detail" id="handling_detail" placeholder="Masukkan Handling Detail"
                    class="form-control @error('handling_detail') is-invalid @enderror" value="{{ old('handling_detail') }}"
                    required>
                @error('handling_detail')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-success">Tambah</button>
    </form>

@endsection
