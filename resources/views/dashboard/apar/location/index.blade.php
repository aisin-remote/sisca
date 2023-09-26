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
                Body
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center p-3 card-as-button" onclick="window.location.href='/dashboard/location/apar/kantin'">
                Kantin
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center p-3 card-as-button" onclick="window.location.href='/dashboard/location/apar/loker-pos'">
                Locker & Pose
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center p-3 card-as-button" onclick="window.location.href='/dashboard/location/apar/main-station'">
                Main Station
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center p-3 card-as-button" onclick="window.location.href='/dashboard/location/apar/masjid'">
                Masjid
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center p-3 card-as-button" onclick="window.location.href='/dashboard/location/apar/office'">
                Office
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center p-3 card-as-button" onclick="window.location.href='/dashboard/location/apar/pump-room'">
                Pump Room
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center p-3 card-as-button" onclick="window.location.href='/dashboard/location/apar/storage-chemical'">
                Storage Chemical
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center p-3 card-as-button" onclick="window.location.href='/dashboard/location/apar/unit'">
                Unit
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center p-3 card-as-button" onclick="window.location.href='/dashboard/location/apar/wwt'">
                WWT
            </div>
        </div>
    </div>
@endsection
