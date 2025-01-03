@extends('dashboard.app')
@section('title', 'Data Location Hydrant')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Data Location HeadCrane</h1>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-12">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="row justify-content-center"> <!-- Mengatur container di tengah -->
        <div class="col-md-11 mb-4">
            <div class="card">
                <div class="card-body text-center"> <!-- Mengatur card-title di tengah -->
                    <h3 class="card-title point-of-view">Mapping Headcrane Demag Unit</h3>
                    <!-- Tambahan informasi lainnya jika perlu -->
                </div>
                <figure class="zoom mb-0 mt-0" onmousemove="zoom(event)"
                    style="background-image: url('/foto/lokasi-headcrane/headcrane demag unit.jpeg');">
                    <img class="img-fluid" style="max-height: 80vh;"
                        src="/foto/lokasi-headcrane/headcrane demag unit.jpeg" />
                </figure>
                <div class="card-body text-center"> <!-- Mengatur card-title di tengah -->
                    <h3 class="card-title point-of-view">Mapping Headcrane Demag Body</h3>
                    <!-- Tambahan informasi lainnya jika perlu -->
                </div>
                <figure class="zoom mb-0 mt-0" onmousemove="zoom(event)"
                    style="background-image: url('/foto/lokasi-headcrane/headcrane demag body.jpeg');">
                    <img class="img-fluid" style="max-height: 80vh;"
                        src="/foto/lokasi-headcrane/headcrane demag body.jpeg" />
                </figure>
                <div class="card-body text-center"> <!-- Mengatur card-title di tengah -->
                    <h3 class="card-title point-of-view">Mapping Headcrane Demag WWT</h3>
                    <!-- Tambahan informasi lainnya jika perlu -->
                </div>
                <figure class="zoom mb-0 mt-0" onmousemove="zoom(event)"
                    style="background-image: url('/foto/lokasi-headcrane/headcrane demag wwt.jpeg');">
                    <img class="img-fluid" style="max-height: 80vh;"
                        src="/foto/lokasi-headcrane/headcrane demag wwt.jpeg" />
                </figure>
            </div>
        </div>
    </div>
@endsection
