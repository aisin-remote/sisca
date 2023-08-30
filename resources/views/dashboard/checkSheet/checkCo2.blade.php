@extends('dashboard.app')
@section('title', 'Check Sheet APAR CO2')

@section('content')

<div class="container">
    <h1>Check Sheet APAR CO2/AF11E</h1>
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
    @if (session()->has('error'))
        <div class="alert alert-success col-lg-12">
            {{ session()->get('error') }}
        </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('process.checksheet.co2', ['tagNumber' => $tagNumber]) }}" method="POST" enctype="multipart/form-data">
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
                    <label for="apar_number" class="form-label">Nomor Apar</label>
                    <input type="text" class="form-control" id="apar_number" value="{{ $tagNumber }}" name="apar_number" required autofocus readonly>
                </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="pressure" class="form-label">Pressure</label>
                <select class="form-select" id="pressure" name="pressure" required>
                    <option value="" selected disabled>Select</option>
                    <option value="OK" {{ old('pressure') == 'OK' ? 'selected' : '' }}>OK</option>
                    <option value="NG" {{ old('pressure') == 'NG' ? 'selected' : '' }}>NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="photo_pressure" class="form-label">Foto Pressure</label>
                <img class="photo-pressure-preview img-fluid mb-3" style="max-height: 300px">
                <input type="file" class="form-control" id="photo_pressure" name="photo_pressure" required onchange="previewImage('photo_pressure', 'photo-pressure-preview')">
            </div>

            <div class="mb-3">
                <label for="hose" class="form-label">Hose</label>
                <select class="form-select" id="hose" name="hose" required>
                    <option value="" selected disabled>Select</option>
                    <option value="OK" {{ old('hose') == 'OK' ? 'selected' : '' }}>OK</option>
                    <option value="NG" {{ old('hose') == 'NG' ? 'selected' : '' }}>NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="photo_hose" class="form-label">Foto Hose</label>
                <img class="photo-hose-preview img-fluid mb-3" style="max-height: 300px">
                <input type="file" class="form-control" id="photo_hose" name="photo_hose" required onchange="previewImage('photo_hose', 'photo-hose-preview')">
            </div>
            <div class="mb-3">
                <label for="corong" class="form-label">Corong/Nozzle</label>
                <select class="form-select" id="corong" name="corong" required>
                    <option value="" selected disabled>Select</option>
                    <option value="OK" {{ old('corong') == 'OK' ? 'selected' : '' }}>OK</option>
                    <option value="NG" {{ old('corong') == 'NG' ? 'selected' : '' }}>NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="photo_corong" class="form-label">Foto Corong/Nozzle</label>
                <img class="photo-corong-preview img-fluid mb-3" style="max-height: 300px">
                <input type="file" class="form-control" id="photo_corong" name="photo_corong" required onchange="previewImage('photo_corong', 'photo-corong-preview')">
            </div>
            <div class="mb-3">
                <label for="tabung" class="form-label">Tabung</label>
                <select class="form-select" id="tabung" name="tabung" required>
                    <option value="" selected disabled>Select</option>
                    <option value="OK" {{ old('tabung') == 'OK' ? 'selected' : '' }}>OK</option>
                    <option value="NG" {{ old('tabung') == 'NG' ? 'selected' : '' }}>NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="photo_tabung" class="form-label">Foto Tabung</label>
                <img class="photo-tabung-preview img-fluid mb-3" style="max-height: 300px">
                <input type="file" class="form-control" id="photo_tabung" name="photo_tabung" required onchange="previewImage('photo_tabung', 'photo-tabung-preview')">
            </div>
            <div class="mb-3">
                <label for="regulator" class="form-label">Regulator</label>
                <select class="form-select" id="regulator" name="regulator" required>
                    <option value="" selected disabled>Select</option>
                    <option value="OK" {{ old('regulator') == 'OK' ? 'selected' : '' }}>OK</option>
                    <option value="NG" {{ old('regulator') == 'NG' ? 'selected' : '' }}>NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="photo_regulator" class="form-label">Foto Regulator</label>
                <img class="photo-regulator-preview img-fluid mb-3" style="max-height: 300px">
                <input type="file" class="form-control" id="photo_regulator" name="photo_regulator" required onchange="previewImage('photo_regulator', 'photo-regulator-preview')">
            </div>
            <div class="mb-3">
                <label for="lock_pin" class="form-label">Lock Pin</label>
                <select class="form-select" id="lock_pin" name="lock_pin" required>
                    <option value="" selected disabled>Select</option>
                    <option value="OK" {{ old('lock_pin') == 'OK' ? 'selected' : '' }}>OK</option>
                    <option value="NG" {{ old('lock_pin') == 'NG' ? 'selected' : '' }}>NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="photo_lock_pin" class="form-label">Foto Lock Pin</label>
                <img class="photo-lock_pin-preview img-fluid mb-3" style="max-height: 300px">
                <input type="file" class="form-control" id="photo_lock_pin" name="photo_lock_pin" required onchange="previewImage('photo_lock_pin', 'photo-lock_pin-preview')">
            </div>
            <div class="mb-3">
                <label for="berat_tabung" class="form-label">Berat Tabung</label>
                <select class="form-select" id="berat_tabung" name="berat_tabung" required>
                    <option value="" selected disabled>Select</option>
                    <option value="OK" {{ old('berat_tabung') == 'OK' ? 'selected' : '' }}>OK</option>
                    <option value="NG" {{ old('berat_tabung') == 'NG' ? 'selected' : '' }}>NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="photo_berat_tabung" class="form-label">Foto Berat Tabung</label>
                <img class="photo-berat_tabung-preview img-fluid mb-3" style="max-height: 300px">
                <input type="file" class="form-control" id="photo_berat_tabung" name="photo_berat_tabung" required onchange="previewImage('photo_berat_tabung', 'photo-berat_tabung-preview')">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ old('description')}}</textarea>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12">
        <p><strong>Catatan:</strong> UNTUK APAR TIPE CO2 METODE PENGECEKAN BERAT TABUNGNYA DILAKUKAN DENGAN CARA DI TIMBANG JIKA BERAT BERKURANG 10 % MAKA APAR DINYATAKAN NG.</p>
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
