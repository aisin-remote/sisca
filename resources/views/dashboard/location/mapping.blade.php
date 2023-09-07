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
    <div class="container">
        <div class="left">
          <!-- Gambar Keterangan (30% lebar) -->
          <img src="\foto\lokasi\Keterangan.png" alt="Gambar Keterangan" class="keterangan-img">
        </div>
        <div class="right zoom-container">
          <!-- All Mapping (70% lebar) -->
          <img src="\foto\lokasi\Mapping All Equipment.png" alt="All Mapping Equipment" class="zoom-image mapping-img">
        </div>
      </div>

@endsection
