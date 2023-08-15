@extends('dashboard.app')
@section('title', 'Data Apar')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Tambah Data Apar</h1>
    </div>
    <form action="/dashboard/ukt" method="POST" class="mb-5 col-lg-12" enctype="multipart/form-data">
        @csrf
        <div class="row">
        <div class="mb-3 col-md-6">
            <label for="tag_number" class="form-label">Tag Number</label>
            <input type="text" name="tag_number" id="tag_number" placeholder="Masukkan Tag Number" class="form-control @error('tag_number') is-invalid @enderror" value="{{old('tag_number')}}" required autofocus>
            @error('tag_number')
                <div class="text-danger">{{$message}}</div>
            @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label for="location" class="form-label">Location</label>
            <input type="text" name="location" id="location" placeholder="Masukkan Location" class="form-control @error('location') is-invalid @enderror" value="{{old('location')}}" required>
            @error('location')
                <div class="text-danger">{{$message}}</div>
            @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label for="expired" class="form-label">Expired</label>
            <input type="text" name="expired" id="expired" placeholder="Masukkan Expired" class="form-control @error('expired') is-invalid @enderror" value="{{old('expired')}}" required>
            @error('expired')
                <div class="text-danger">{{$message}}</div>
            @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label for="post" class="form-label">Post</label>
            <input type="text" name="post" id="post" placeholder="Masukkan Post" class="form-control @error('post') is-invalid @enderror" value="{{old('post')}}" required>
            @error('post')
                <div class="text-danger">{{$message}}</div>
            @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label for="type" class="form-label">Type</label>
            <input type="text" name="type" id="type" placeholder="Masukkan Type" class="form-control @error('type') is-invalid @enderror" value="{{old('type')}}" required>
            @error('type')
                <div class="text-danger">{{$message}}</div>
            @enderror
        </div>
    </div>
    <button type="submit" class="btn btn-success">Tambah</button>
    </form>

@endsection
