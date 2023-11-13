@extends('dashboard.app')
@section('title', 'Check Sheet APAR CO2/AF11E')

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
        <div class="alert alert-danger col-lg-12">
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
            <form action="{{ route('apar.checksheetco2.update', $checkSheetco2->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="tanggal_pengecekan" class="form-label">Tanggal Pengecekan</label>
                    <input type="date" class="form-control" id="tanggal_pengecekan" value="{{ $checkSheetco2->tanggal_pengecekan }}" name="tanggal_pengecekan" required readonly>
                </div>
                <div class="mb-3">
                    <label for="npk" class="form-label">NPK</label>
                    <input type="text" class="form-control" id="npk" name="npk" value="{{ $checkSheetco2->npk }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="apar_number" class="form-label">Nomor Apar</label>
                    <input type="text" class="form-control" id="apar_number" value="{{ $checkSheetco2->apar_number }}" name="apar_number" required autofocus readonly>
                </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="pressure" class="form-label">Pressure</label>
                <div class="input-group">
                    <select class="form-select" id="pressure" name="pressure">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('pressure') ?? $checkSheetco2->pressure == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('pressure') ?? $checkSheetco2->pressure == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_pressure"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_pressure" style="display:none;">
                <label for="catatan_pressure" class="form-label">Catatan Pressure</label>
                <textarea class="form-control" name="catatan_pressure" id="catatan_pressure" cols="30" rows="5">{{ old('catatan_pressure') ?? $checkSheetco2->catatan_pressure}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_pressure" class="form-label">Foto Pressure</label>
                <input type="hidden" name="oldImage_pressure" value="{{ $checkSheetco2->photo_pressure }}">
                @if ($checkSheetco2->photo_pressure)
                    <img src="{{ asset('storage/' . $checkSheetco2->photo_pressure) }}" class="photo-pressure-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-pressure-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_pressure" name="photo_pressure" onchange="previewImage('photo_pressure', 'photo-pressure-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="hose" class="form-label">Hose</label>
                <div class="input-group">
                    <select class="form-select" id="hose" name="hose">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('hose') ?? $checkSheetco2->hose == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('hose') ?? $checkSheetco2->hose == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_hose"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_hose" style="display:none;">
                <label for="catatan_hose" class="form-label">Catatan Hose</label>
                <textarea class="form-control" name="catatan_hose" id="catatan_hose" cols="30" rows="5">{{ old('catatan_hose') ?? $checkSheetco2->catatan_hose}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_hose" class="form-label">Foto Hose</label>
                <input type="hidden" name="oldImage_hose" value="{{ $checkSheetco2->photo_hose }}">
                @if ($checkSheetco2->photo_hose)
                    <img src="{{ asset('storage/' . $checkSheetco2->photo_hose) }}" class="photo-hose-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-hose-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_hose" name="photo_hose" onchange="previewImage('photo_hose', 'photo-hose-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="corong" class="form-label">Corong/Nozzle</label>
                <div class="input-group">
                    <select class="form-select" id="corong" name="corong">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('corong') ?? $checkSheetco2->corong == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('corong') ?? $checkSheetco2->corong == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_corong"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_corong" style="display:none;">
                <label for="catatan_corong" class="form-label">Catatan Corong</label>
                <textarea class="form-control" name="catatan_corong" id="catatan_corong" cols="30" rows="5">{{ old('catatan_corong') ?? $checkSheetco2->catatan_corong}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_corong" class="form-label">Foto Corong/Nozzle</label>
                <input type="hidden" name="oldImage_corong" value="{{ $checkSheetco2->photo_corong }}">
                @if ($checkSheetco2->photo_corong)
                    <img src="{{ asset('storage/' . $checkSheetco2->photo_corong) }}" class="photo-corong-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-corong-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_corong" name="photo_corong" onchange="previewImage('photo_corong', 'photo-corong-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="tabung" class="form-label">Tabung</label>
                <div class="input-group">
                    <select class="form-select" id="tabung" name="tabung">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('tabung') ?? $checkSheetco2->tabung == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('tabung') ?? $checkSheetco2->tabung == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_tabung"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_tabung" style="display:none;">
                <label for="catatan_tabung" class="form-label">Catatan Tabung</label>
                <textarea class="form-control" name="catatan_tabung" id="catatan_tabung" cols="30" rows="5">{{ old('catatan_tabung') ?? $checkSheetco2->catatan_tabung}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_tabung" class="form-label">Foto Tabung</label>
                <input type="hidden" name="oldImage_tabung" value="{{ $checkSheetco2->photo_tabung }}">
                @if ($checkSheetco2->photo_tabung)
                    <img src="{{ asset('storage/' . $checkSheetco2->photo_tabung) }}" class="photo-tabung-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-tabung-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_tabung" name="photo_tabung" onchange="previewImage('photo_tabung', 'photo-tabung-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="regulator" class="form-label">Regulator</label>
                <div class="input-group">
                    <select class="form-select" id="regulator" name="regulator">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('regulator') ?? $checkSheetco2->regulator == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('regulator') ?? $checkSheetco2->regulator == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_regulator"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_regulator" style="display:none;">
                <label for="catatan_regulator" class="form-label">Catatan Regulator</label>
                <textarea class="form-control" name="catatan_regulator" id="catatan_regulator" cols="30" rows="5">{{ old('catatan_regulator') ?? $checkSheetco2->catatan_regulator}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_regulator" class="form-label">Foto Regulator</label>
                <input type="hidden" name="oldImage_regulator" value="{{ $checkSheetco2->photo_regulator }}">
                @if ($checkSheetco2->photo_regulator)
                    <img src="{{ asset('storage/' . $checkSheetco2->photo_regulator) }}" class="photo-regulator-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-regulator-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_regulator" name="photo_regulator" onchange="previewImage('photo_regulator', 'photo-regulator-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="lock_pin" class="form-label">Lock Pin</label>
                <div class="input-group">
                    <select class="form-select" id="lock_pin" name="lock_pin">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('lock_pin') ?? $checkSheetco2->lock_pin == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('lock_pin') ?? $checkSheetco2->lock_pin == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_lock_pin"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_lock_pin" style="display:none;">
                <label for="catatan_lock_pin" class="form-label">Catatan Lock Pin</label>
                <textarea class="form-control" name="catatan_lock_pin" id="catatan_lock_pin" cols="30" rows="5">{{ old('catatan_lock_pin') ?? $checkSheetco2->catatan_lock_pin}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_lock_pin" class="form-label">Foto Lock Pin</label>
                <input type="hidden" name="oldImage_lock_pin" value="{{ $checkSheetco2->photo_lock_pin }}">
                @if ($checkSheetco2->photo_lock_pin)
                    <img src="{{ asset('storage/' . $checkSheetco2->photo_lock_pin) }}" class="photo-lock_pin-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-lock_pin-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_lock_pin" name="photo_lock_pin" onchange="previewImage('photo_lock_pin', 'photo-lock_pin-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="berat_tabung" class="form-label">Berat Tabung</label>
                <div class="input-group">
                    <select class="form-select" id="berat_tabung" name="berat_tabung">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('berat_tabung') ?? $checkSheetco2->berat_tabung == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('berat_tabung') ?? $checkSheetco2->berat_tabung == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_berat_tabung"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_berat_tabung" style="display:none;">
                <label for="catatan_berat_tabung" class="form-label">Catatan Berat Tabung</label>
                <textarea class="form-control" name="catatan_berat_tabung" id="catatan_berat_tabung" cols="30" rows="5">{{ old('catatan_berat_tabung') ?? $checkSheetco2->catatan_berat_tabung}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_berat_tabung" class="form-label">Foto Berat Tabung</label>
                <input type="hidden" name="oldImage_berat_tabung" value="{{ $checkSheetco2->photo_berat_tabung }}">
                @if ($checkSheetco2->photo_berat_tabung)
                    <img src="{{ asset('storage/' . $checkSheetco2->photo_berat_tabung) }}" class="photo-berat_tabung-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-berat_tabung-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_berat_tabung" name="photo_berat_tabung" onchange="previewImage('photo_berat_tabung', 'photo-berat_tabung-preview')">
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12">
        <p><strong>Catatan:</strong> UNTUK APAR TIPE CO2 METODE PENGECEKAN BERAT TABUNGNYA DILAKUKAN DENGAN CARA DI TIMBANG JIKA BERAT BERKURANG 10 % MAKA APAR DINYATAKAN NG.</p>
    </div>
</div>
<div class="row mt-2 mb-5">
    <div class="col-md-12 text-end">
        <button type="submit" class="btn btn-warning">Edit</button>
    </div>
</div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil elemen-elemen yang dibutuhkan
        const tambahCatatanButtonPressure = document.getElementById('tambahCatatan_pressure');
        const tambahCatatanButtonHose = document.getElementById('tambahCatatan_hose');
        const tambahCatatanButtonCorong = document.getElementById('tambahCatatan_corong');
        const tambahCatatanButtonTabung = document.getElementById('tambahCatatan_tabung');
        const tambahCatatanButtonRegulator = document.getElementById('tambahCatatan_regulator');
        const tambahCatatanButtonLockPin = document.getElementById('tambahCatatan_lock_pin');
        const tambahCatatanButtonBeratTabung = document.getElementById('tambahCatatan_berat_tabung');

        const catatanFieldPressure = document.getElementById('catatanField_pressure');
        const catatanFieldHose = document.getElementById('catatanField_hose');
        const catatanFieldCorong = document.getElementById('catatanField_corong');
        const catatanFieldTabung = document.getElementById('catatanField_tabung');
        const catatanFieldRegulator = document.getElementById('catatanField_regulator');
        const catatanFieldLockPin = document.getElementById('catatanField_lock_pin');
        const catatanFieldBeratTabung = document.getElementById('catatanField_berat_tabung');

        // Tambahkan event listener untuk button "Tambah Catatan Pressure"
        tambahCatatanButtonPressure.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldPressure.style.display === 'none') {
                catatanFieldPressure.style.display = 'block';
                tambahCatatanButtonPressure.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonPressure.classList.remove('btn-success');
                tambahCatatanButtonPressure.classList.add('btn-danger');
            } else {
                catatanFieldPressure.style.display = 'none';
                tambahCatatanButtonPressure.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonPressure.classList.remove('btn-danger');
                tambahCatatanButtonPressure.classList.add('btn-success');
            }
        });

        // ... Tambahkan event listener untuk tombol-tombol tambah catatan lainnya di sini ...
        tambahCatatanButtonHose.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldHose.style.display === 'none') {
                catatanFieldHose.style.display = 'block';
                tambahCatatanButtonHose.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonHose.classList.remove('btn-success');
                tambahCatatanButtonHose.classList.add('btn-danger');
            } else {
                catatanFieldHose.style.display = 'none';
                tambahCatatanButtonHose.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonHose.classList.remove('btn-danger');
                tambahCatatanButtonHose.classList.add('btn-success');
            }
        });

        tambahCatatanButtonCorong.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldCorong.style.display === 'none') {
                catatanFieldCorong.style.display = 'block';
                tambahCatatanButtonCorong.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonCorong.classList.remove('btn-success');
                tambahCatatanButtonCorong.classList.add('btn-danger');
            } else {
                catatanFieldCorong.style.display = 'none';
                tambahCatatanButtonCorong.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonCorong.classList.remove('btn-danger');
                tambahCatatanButtonCorong.classList.add('btn-success');
            }
        });

        tambahCatatanButtonTabung.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldTabung.style.display === 'none') {
                catatanFieldTabung.style.display = 'block';
                tambahCatatanButtonTabung.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonTabung.classList.remove('btn-success');
                tambahCatatanButtonTabung.classList.add('btn-danger');
            } else {
                catatanFieldTabung.style.display = 'none';
                tambahCatatanButtonTabung.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonTabung.classList.remove('btn-danger');
                tambahCatatanButtonTabung.classList.add('btn-success');
            }
        });

        tambahCatatanButtonRegulator.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldRegulator.style.display === 'none') {
                catatanFieldRegulator.style.display = 'block';
                tambahCatatanButtonRegulator.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonRegulator.classList.remove('btn-success');
                tambahCatatanButtonRegulator.classList.add('btn-danger');
            } else {
                catatanFieldRegulator.style.display = 'none';
                tambahCatatanButtonRegulator.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonRegulator.classList.remove('btn-danger');
                tambahCatatanButtonRegulator.classList.add('btn-success');
            }
        });

        tambahCatatanButtonLockPin.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldLockPin.style.display === 'none') {
                catatanFieldLockPin.style.display = 'block';
                tambahCatatanButtonLockPin.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonLockPin.classList.remove('btn-success');
                tambahCatatanButtonLockPin.classList.add('btn-danger');
            } else {
                catatanFieldLockPin.style.display = 'none';
                tambahCatatanButtonLockPin.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonLockPin.classList.remove('btn-danger');
                tambahCatatanButtonLockPin.classList.add('btn-success');
            }
        });

        tambahCatatanButtonBeratTabung.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldBeratTabung.style.display === 'none') {
                catatanFieldBeratTabung.style.display = 'block';
                tambahCatatanButtonBeratTabung.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonBeratTabung.classList.remove('btn-success');
                tambahCatatanButtonBeratTabung.classList.add('btn-danger');
            } else {
                catatanFieldBeratTabung.style.display = 'none';
                tambahCatatanButtonBeratTabung.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonBeratTabung.classList.remove('btn-danger');
                tambahCatatanButtonBeratTabung.classList.add('btn-success');
            }
        });
    });
</script>

@endsection
