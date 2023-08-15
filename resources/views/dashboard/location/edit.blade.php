@extends('dashboard.app')
@section('title', 'Data Location')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
    <h1>Edit Data Location</h1>
</div>
<form action="{{ route('data_location.update', $location->id) }}" method="POST" class="mb-5 col-lg-12" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
    <div class="mb-3 col-md-6">
        <label for="location_name" class="form-label">Location Name</label>
        <input type="text" name="location_name" id="location_name" placeholder="Masukkan Location Name" class="form-control @error('location_name') is-invalid @enderror" value="{{old('location_name') ?? $location->location_name}}" required autofocus>
        @error('location_name')
            <div class="text-danger">{{$message}}</div>
        @enderror
    </div>
</div>
<button type="submit" class="btn btn-success">Tambah</button>
</form>

@endsection
