@extends('dashboard.app')
@section('title', 'Data Location Apar')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Data Location Apar</h1>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-12">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="row d-flex flex-wrap">
        <div class="col-md-4 mb-3">
            <div class="card text-center p-3 card-as-button" onclick="window.location.href='/dashboard/location/apar/body'">
                <p class="card-text">Body</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center p-3 card-as-button" onclick="window.location.href='/dashboard/location/apar/kantin'">
                <p class="card-text">Kantin</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center p-3 card-as-button" onclick="window.location.href='/dashboard/location/apar/loker-pos'">
                <p class="card-text">Locker & Pos</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center p-3 card-as-button" onclick="window.location.href='/dashboard/location/apar/main-station'">
                <p class="card-text">Main Station</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center p-3 card-as-button" onclick="window.location.href='/dashboard/location/apar/masjid'">
                <p class="card-text">Masjid</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center p-3 card-as-button" onclick="window.location.href='/dashboard/location/apar/office'">
                <p class="card-text">Office</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center p-3 card-as-button" onclick="window.location.href='/dashboard/location/apar/pump-room'">
                <p class="card-text">Pump Room</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center p-3 card-as-button" onclick="window.location.href='/dashboard/location/apar/storage-chemical'">
                <p class="card-text">Storage Chemical</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center p-3 card-as-button" onclick="window.location.href='/dashboard/location/apar/unit'">
                <p class="card-text">Unit</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center p-3 card-as-button" onclick="window.location.href='/dashboard/location/apar/wwt'">
                <p class="card-text">WWT</p>
            </div>
        </div>
    </div>
@endsection
