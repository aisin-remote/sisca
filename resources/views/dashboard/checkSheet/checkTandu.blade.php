@extends('dashboard.app')
@section('title', 'Check Sheet Station & Equipment Tandu')

@section('content')

<div class="container">
    <h1>Check Sheet Station & Equipment Tandu</h1>
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
                    <label for="number" class="form-label">Nomor</label>
                    <input type="text" class="form-control" id="number" value="" name="number" required autofocus readonly>
                </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="kunci_pintu" class="form-label">Kunci Pintu</label>
                <small class="form-text text-muted">Terkunci saat tertutup</small>
                <select class="form-select" id="kunci_pintu" name="kunci_pintu">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pintu" class="form-label">Pintu</label>
                <small class="form-text text-muted">Tidak rusak & dapat dibuka</small>
                <select class="form-select" id="pintu" name="pintu">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="sign" class="form-label">Sign</label>
                <small class="form-text text-muted">Terpasang di atas box tandu</small>
                <select class="form-select" id="sign" name="sign">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="hand_grip" class="form-label">Hand Grip</label>
                <small class="form-text text-muted">Terpasang & tidak rusak</small>
                <select class="form-select" id="hand_grip" name="hand_grip">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="body" class="form-label">Body</label>
                <small class="form-text text-muted">Tidak rusak & tidak sobek</small>
                <select class="form-select" id="body" name="body">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="engsel" class="form-label">Engsel</label>
                <small class="form-text text-muted">Tidak patah & berfungsi</small>
                <select class="form-select" id="engsel" name="engsel">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="kaki" class="form-label">Kaki</label>
                <small class="form-text text-muted">Tidak patah</small>
                <select class="form-select" id="kaki" name="kaki">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="belt" class="form-label">Belt</label>
                <small class="form-text text-muted">Terpasang & tidak sobek</small>
                <select class="form-select" id="belt" name="belt">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="rangka" class="form-label">Rangka</label>
                <small class="form-text text-muted">Tidak ada bagian yang patah</small>
                <select class="form-select" id="rangka" name="rangka">
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