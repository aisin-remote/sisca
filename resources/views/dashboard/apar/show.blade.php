@extends('dashboard.app')
@section('title', 'Data Apar')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Info Apar</h1>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-12">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="card col-lg-6 mb-4">
        <div class="card-body">
            <div class="row">
                <div class="h6 col-3">Nama</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{$apar->tag_number}}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Location</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{$apar->locations->location_name}}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Expired</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{$apar->expired}}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Post</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{$apar->post}}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Type</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{$apar->type}}</div>
            </div>
        </div>
    </div>
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Riwayat Check Sheet Apar</h1>
    </div>
@endsection
