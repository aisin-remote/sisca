@extends('dashboard.app')
@section('title', 'Location Equipment')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Data Location All Equipment</h1>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-12">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="containere">
        <div class="left">
          <!-- Gambar Keterangan (30% lebar) -->
          <img src="\foto\lokasi\Keterangan.png" alt="Gambar Keterangan" class="keterangan-img">
        </div>
        <figure class="zoom mb-0 mt-0" onmousemove="zoom(event)" style="background-image: url('/foto/lokasi/Mapping All Equipment.jpg');">
            <img class="img-fluid" style="max-height: 80vh;" src="/foto/lokasi/Mapping All Equipment.jpg"/>
          </figure>
      </div>

@endsection
