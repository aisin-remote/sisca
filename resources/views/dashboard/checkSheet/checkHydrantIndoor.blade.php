@extends('dashboard.app')
@section('title', 'Check Sheet Hydrant Indoor')

@section('content')

<div class="container">
    <h1>Check Sheet Hydrant Indoor</h1>
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
            <form action="{{ route('process.checksheet.hydrantindoor') }}" method="POST">
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
                <label for="lampu" class="form-label">Lampu</label>
                <small class="form-text text-muted">(Lampu menyala)</small>
                <select class="form-select" id="lampu" name="lampu">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="emergency" class="form-label">Tombol Emergency</label>
                <small class="form-text text-muted">(Tombol emergency tidak rusak)</small>
                <select class="form-select" id="emergency" name="emergency">
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
                <label for="valve" class="form-label">Valve</label>
                <small class="form-text text-muted">(Valve tidak rusak/berkarat)</small>
                <select class="form-select" id="valve" name="valve">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="coupling" class="form-label">Coupling/Sambungan</label>
                <small class="form-text text-muted">(Coupling terpasang & tidak berkarat)</small>
                <select class="form-select" id="coupling" name="coupling">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pressure" class="form-label">Pressure</label>
                <small class="form-text text-muted">(Pressure antara 4-7 Bar)</small>
                <select class="form-select" id="pressure" name="pressure">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="kupla" class="form-label">Selang dan Kopling</label>
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