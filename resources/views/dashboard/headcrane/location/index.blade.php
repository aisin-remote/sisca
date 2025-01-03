@extends('dashboard.app')
@section('title', 'Data Location HeadCrane')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-8">
        <h1>Data Location HeadCrane</h1>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-12">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="row d-flex flex-wrap">
        <div class="col-md-4 mb-3">
            <div class="card text-center p-3 card-as-button"
                onclick="window.location.href='/dashboard/location/headcrane/demag'">
                Demag
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center p-3 card-as-button"
                onclick="window.location.href='/dashboard/location/headcrane/kito'">
                Kito
            </div>
        </div>
    </div>

@endsection
