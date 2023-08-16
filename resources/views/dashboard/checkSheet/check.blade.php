@extends('dashboard.app')
@section('title', 'Check Sheet')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Check Sheet Apar</h1>
    </div>
    @if (session()->has('error'))
        <div class="alert alert-success col-lg-12">
            {{ session()->get('error') }}
        </div>
    @endif
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-12">
            {{ session()->get('success') }}
        </div>
    @endif
    <form action="{{ route('process.form') }}" method="POST" class="mb-5 col-lg-12" enctype="multipart/form-data">
        @csrf
        <div class="row">
        <div class="mb-3 col-md-6">
            <label for="tag_number" class="form-label">Tag Number</label>
            <input type="text" name="tag_number" id="tag_number" placeholder="Masukkan Tag Number" class="form-control @error('tag_number') is-invalid @enderror" value="{{old('tag_number')}}" required autofocus>
            @error('tag_number')
                <div class="text-danger">{{$message}}</div>
            @enderror
        </div>
    </div>
    <button type="submit" class="btn btn-success">Check</button>
    </form>

@endsection
