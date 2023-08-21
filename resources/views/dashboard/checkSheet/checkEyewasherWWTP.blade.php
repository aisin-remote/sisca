@extends('dashboard.app')
@section('title', 'Check Sheet Eyewasher WWTP')

@section('content')

<div class="container">
    <h1>Check Sheet Eyewasher WWTP</h1>
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
                    <label for="instalation_base" class="form-label">Instalation Base</label>
                    <small class="form-text text-muted">Terpasang dengan kuat, dan tidak berkarat</small>
                    <select class="form-select" id="instalation_base" name="instalation_base">
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
                    <label for="wastafel_eye_wash" class="form-label">Wastafel Eye Wash</label>
                    <small class="form-text text-muted">Wastafel tidak ada penyokan dan tidak ada karat</small>
                    <select class="form-select" id="wastafel_eye_wash" name="wastafel_eye_wash">
                        <option value="" selected disabled>Select</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tuas_eye_wash" class="form-label">Tuas Eye Wash</label>
                    <small class="form-text text-muted">Kran berfungsi dan tidak ada karat</small>
                    <select class="form-select" id="tuas_eye_wash" name="tuas_eye_wash">
                        <option value="" selected disabled>Select</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="kran_eye_wash" class="form-label">Kran Eye Wash</label>
                    <small class="form-text text-muted">Tuas berfungsi dan tidak berkarat</small>
                    <select class="form-select" id="kran_eye_wash" name="kran_eye_wash">
                        <option value="" selected disabled>Select</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tuas_shower" class="form-label">Tuas Shower</label>
                    <small class="form-text text-muted">Tuas berfungsi dan tidak berkarat</small>
                    <select class="form-select" id="tuas_shower" name="tuas_shower">
                        <option value="" selected disabled>Select</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="sign" class="form-label">Sign</label>
                    <small class="form-text text-muted">Pastikan terlihat jelas dan tidak rusak</small>
                    <select class="form-select" id="sign" name="sign">
                        <option value="" selected disabled>Select</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="shower_head" class="form-label">Shower Head</label>
                    <small class="form-text text-muted">Berfungsi dengan baik dan tidak berkarat</small>
                    <select class="form-select" id="shower_head" name="shower_head">
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
