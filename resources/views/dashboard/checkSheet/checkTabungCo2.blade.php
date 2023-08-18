@extends('dashboard.app')
@section('title', 'Check Sheet Tabung CO2')

@section('content')

<div class="container">
    <h1>Check Sheet Tabung CO2</h1>
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
            <form action="" method="POST">
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
                    <input type="text" class="form-control" id="tabung_number" value="" name="tabung_number" required autofocus readonly>
                </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="cover" class="form-label">Cover</label>
                <small class="form-text text-muted">Terdapat cover terpasang pada sisi luar tabung</small>
                <select class="form-select" id="cover" name="cover">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tabung" class="form-label">Tabung</label>
                <small class="form-text text-muted">Tidak berkarat, penyok, bolong, dll</small>
                <select class="form-select" id="tabung" name="tabung">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="lock_pin" class="form-label">Lock Pin</label>
                <small class="form-text text-muted">Terpasang pada regulator & tidak rusak</small>
                <select class="form-select" id="lock_pin" name="lock_pin">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="segel_lock_pin" class="form-label">Segel Lock Pin</label>
                <small class="form-text text-muted">Terpasang & tidak sobek</small>
                <select class="form-select" id="segel_lock_pin" name="segel_lock_pin">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="kebocoran_regulator" class="form-label">Kebocoran regulator tabung</label>
                <small class="form-text text-muted">Tidak ada kebocoran</small>
                <select class="form-select" id="kebocoran_regulator" name="kebocoran_regulator">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="selang" class="form-label">Selang</label>
                <small class="form-text text-muted">Tidak sobek, putus, & berkarat</small>
                <select class="form-select" id="selang" name="selang">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
        </div>
    </div>
    </form>
</div>

@endsection