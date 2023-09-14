@extends('dashboard.app')
@section('title', 'Check Sheet Hydrant Outdoor')

@section('content')

<div class="container">
    <h1>Check Sheet Hydrant Outdoor</h1>
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
            <form action="{{ route('process.checksheet.outdoor') }}" method="POST">
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
                    <label for="hydrant_number" class="form-label">Nomor Hydrant</label>
                    <input type="text" class="form-control" id="hydrant_number" name="hydrant_number" required autofocus>
                </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="pintu" class="form-label">Pintu Hydrant</label>
                <small class="form-text text-muted">(Pintu hydrant dapat terbuka/tidak macet)</small>
                <select class="form-select" id="pintu" name="pintu">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="nozzle" class="form-label">Nozzle</label>
                <small class="form-text text-muted">(Nozzle tidak berkarat/rusak/patah)</small>
                <select class="form-select" id="nozzle" name="nozzle">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="selang" class="form-label">Selang</label>
                <small class="form-text text-muted">(Selang tidak putus/sobek/rusak)</small>
                <select class="form-select" id="selang" name="selang">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tuas" class="form-label">Tuas Pilar</label>
                <small class="form-text text-muted">(Tuas ada & tidak rusak/berkarat)</small>
                <select class="form-select" id="tuas" name="tuas">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pilar" class="form-label">Pilar</label>
                <small class="form-text text-muted">(Pilar tidak rusak, tidak ada yang bocor dan tidak berkarat)</small>
                <select class="form-select" id="pilar" name="pilar">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="penutup" class="form-label">Penutup Pilar</label>
                <small class="form-text text-muted">(Penutup pilar kiri & kanan terpasang)</small>
                <select class="form-select" id="penutup" name="penutup">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="rantai" class="form-label">Rantai Penutup Pilar</label>
                <small class="form-text text-muted">(Rantai penutup pilar tidak putus)</small>
                <select class="form-select" id="rantai" name="rantai">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="kupla" class="form-label">Selang dan Pilar</label>
                <small class="form-text text-muted">(Tidak rusak dan pastikan terhubung dengan kuat)</small>
                <select class="form-select" id="kupla" name="kupla">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
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
