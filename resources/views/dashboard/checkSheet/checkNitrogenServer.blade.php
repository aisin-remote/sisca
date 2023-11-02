@extends('dashboard.app')
@section('title', 'Check Sheet Nitrogen Ruang Server')

@section('content')

<div class="container">
    <h1>Check Sheet Nitrogen Ruang Server</h1>
    <hr>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('process.checksheet.nitrogen.server') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="tanggal_pengecekan" class="form-label">Tanggal Pengecekan</label>
                    <input type="date" class="form-control" id="tanggal_pengecekan" name="tanggal_pengecekan" required readonly>
                </div>
                <div class="mb-3">
                    <label for="npk" class="form-label">NPK</label>
                    <input type="text" class="form-control" id="npk" name="npk" value="{{ auth()->user()->npk }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="tabung_number" class="form-label">Nomor Tabung</label>
                    <input type="text" class="form-control" id="tabung_number" name="tabung_number" required autofocus>
                </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="operasional" class="form-label">Indikator System Power</label>
                <small class="form-text text-muted">Lampu Led menyala pada posisi "System Power"</small>
                <select class="form-select" id="operasional" name="operasional">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="selector_mode" class="form-label">Selector Mode Automatic</label>
                <small class="form-text text-muted">Kunci dalam posisi "Automatic"</small>
                <select class="form-select" id="selector_mode" name="selector_mode">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pintu_tabung" class="form-label">Pintu tabung</label>
                <small class="form-text text-muted">Pintu tidak seret / macet saat dibuka</small>
                <select class="form-select" id="pintu_tabung" name="pintu_tabung">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pressure_pilot" class="form-label">Pressure Tabung Pilot nitrogen</label>
                <small class="form-text text-muted">Tidak ada kebocoran & Pressure menunjukan angka 9-10 Mpa</small>
                <select class="form-select" id="pressure_pilot" name="pressure_pilot">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pressure_no1" class="form-label">Pressure tabung Nitrogen No 1</label>
                <small class="form-text text-muted">Tidak ada kebocoran & Pressure menunjukan angka 23-30 Mpa</small>
                <select class="form-select" id="pressure_no1" name="pressure_no1">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pressure_no2" class="form-label">Pressure tabung Nitrogen No 2</label>
                <small class="form-text text-muted">Tidak ada kebocoran & Pressure menunjukan angka 23-30 Mpa</small>
                <select class="form-select" id="pressure_no2" name="pressure_no2">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pressure_no3" class="form-label">Pressure tabung Nitrogen No 3</label>
                <small class="form-text text-muted">Tidak ada kebocoran & Pressure menunjukan angka 23-30 Mpa</small>
                <select class="form-select" id="pressure_no3" name="pressure_no3">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pressure_no4" class="form-label">Pressure tabung Nitrogen No 4</label>
                <small class="form-text text-muted">Tidak ada kebocoran & Pressure menunjukan angka 23-30 Mpa</small>
                <select class="form-select" id="pressure_no4" name="pressure_no4">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pressure_no5" class="form-label">Pressure tabung Nitrogen No 5</label>
                <small class="form-text text-muted">Tidak ada kebocoran & Pressure menunjukan angka 23-30 Mpa</small>
                <select class="form-select" id="pressure_no5" name="pressure_no5">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 text-end">
            <button type="submit" class="btn btn-primary">Kirim</button>
        </div>
    </div>
    </form>
</div>

@endsection
