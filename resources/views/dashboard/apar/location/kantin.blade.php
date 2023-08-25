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
        <div class="row justify-content-center"> <!-- Mengatur container di tengah -->
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body text-center"> <!-- Mengatur card-title di tengah -->
                        <h3 class="card-title point-of-view">Mapping Apar Kantin</h3>
                        <!-- Tambahan informasi lainnya jika perlu -->
                    </div>
                    <img src="/foto/lokasi-apar/Mapping APAR Kantin.png" class="card-img-top" alt="Apar Kantin">
                </div>
            </div>
        </div>

@endsection
