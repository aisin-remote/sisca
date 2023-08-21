@extends('dashboard.app')
@section('title', 'Check Sheet Eyewasher Chemical Storage')

@section('content')

<div class="container">
    <h1>Check Sheet Eyewasher Chemical Storage</h1>
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
                    <label for="eyewasher_number" class="form-label">Nomor Eyewasher</label>
                    <input type="text" class="form-control" id="eyewasher_number" value="" name="eyewasher_number" required autofocus readonly>
                </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="pijakan" class="form-label">Pijakan</label>
                <small class="form-text text-muted">Pijakan berfungsi, tidak berkarat dan dalam kondisi baik</small>
                <select class="form-select" id="pijakan" name="pijakan">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pipa_saluran_air" class="form-label">Pipa Saluran Air</label>
                <small class="form-text text-muted">Pipa saluran air berfungsi dan tidak rusak</small>
                <select class="form-select" id="pipa_saluran_air" name="pipa_saluran_air">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="wastafel" class="form-label">Wastafel</label>
                <small class="form-text text-muted">Wastafel tidak ada penyokan dan tidak ada karat</small>
                <select class="form-select" id="wastafel" name="wastafel">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="kran_air" class="form-label">Kran Air</label>
                <small class="form-text text-muted">Kran berfungsi dan tidak ada karat</small>
                <select class="form-select" id="kran_air" name="kran_air">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tuas" class="form-label">Tuas</label>
                <small class="form-text text-muted">Tuas berfungsi dan tidak berkarat</small>
                <select class="form-select" id="tuas" name="tuas">
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