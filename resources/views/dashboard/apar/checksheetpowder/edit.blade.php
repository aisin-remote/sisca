@extends('dashboard.app')
@section('title', 'Check Sheet APAR Powder')

@section('content')

<div class="container">
    <h1>Check Sheet APAR Powder</h1>
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
            <form action="{{ route('apar.checksheetpowder.update', $checkSheetpowder->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="tanggal_pengecekan" class="form-label">Tanggal Pengecekan</label>
                    <input type="date" class="form-control" id="tanggal_pengecekan" value="{{ $checkSheetpowder->tanggal_pengecekan }}" name="tanggal_pengecekan" required readonly>
                </div>
                <div class="mb-3">
                    <label for="npk" class="form-label">NPK</label>
                    <input type="text" class="form-control" id="npk" name="npk" value="{{ $checkSheetpowder->npk }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="apar_number" class="form-label">Nomor Apar</label>
                    <input type="text" class="form-control" id="apar_number" value="{{ $checkSheetpowder->apar_number }}" name="apar_number" required autofocus readonly>
                </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="pressure" class="form-label">Pressure</label>
                <div class="input-group">
                    <select class="form-select" id="pressure" name="pressure">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('pressure') ?? $checkSheetpowder->pressure == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('pressure') ?? $checkSheetpowder->pressure == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_pressure"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_pressure" style="display:none;">
                <label for="catatan_pressure" class="form-label">Catatan Pressure</label>
                <textarea class="form-control" name="catatan_pressure" id="catatan_pressure" cols="30" rows="5">{{ old('catatan_pressure') ?? $checkSheetpowder->catatan_pressure}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_pressure" class="form-label">Foto Pressure</label>
                <input type="hidden" name="oldImage_pressure" value="{{ $checkSheetpowder->photo_pressure }}">
                @if ($checkSheetpowder->photo_pressure)
                    <img src="{{ asset('storage/' . $checkSheetpowder->photo_pressure) }}" class="photo-pressure-preview img-fluid mb-3 d-block" style="max-height: 300px">
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
                        <option value="OK" {{ old('hose') ?? $checkSheetpowder->hose == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('hose') ?? $checkSheetpowder->hose == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_hose"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_hose" style="display:none;">
                <label for="catatan_hose" class="form-label">Catatan Hose</label>
                <textarea class="form-control" name="catatan_hose" id="catatan_hose" cols="30" rows="5">{{ old('catatan_hose') ?? $checkSheetpowder->catatan_hose}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_hose" class="form-label">Foto Hose</label>
                <input type="hidden" name="oldImage_hose" value="{{ $checkSheetpowder->photo_hose }}">
                @if ($checkSheetpowder->photo_hose)
                    <img src="{{ asset('storage/' . $checkSheetpowder->photo_hose) }}" class="photo-hose-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-hose-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_hose" name="photo_hose" onchange="previewImage('photo_hose', 'photo-hose-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="tabung" class="form-label">Tabung</label>
                <div class="input-group">
                    <select class="form-select" id="tabung" name="tabung">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('tabung') ?? $checkSheetpowder->tabung == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('tabung') ?? $checkSheetpowder->tabung == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_tabung"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_tabung" style="display:none;">
                <label for="catatan_tabung" class="form-label">Catatan Tabung</label>
                <textarea class="form-control" name="catatan_tabung" id="catatan_tabung" cols="30" rows="5">{{ old('catatan_tabung') ?? $checkSheetpowder->catatan_tabung}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_tabung" class="form-label">Foto Tabung</label>
                <input type="hidden" name="oldImage_tabung" value="{{ $checkSheetpowder->photo_tabung }}">
                @if ($checkSheetpowder->photo_tabung)
                    <img src="{{ asset('storage/' . $checkSheetpowder->photo_tabung) }}" class="photo-tabung-preview img-fluid mb-3 d-block" style="max-height: 300px">
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
                        <option value="OK" {{ old('regulator') ?? $checkSheetpowder->regulator == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('regulator') ?? $checkSheetpowder->regulator == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_regulator"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_regulator" style="display:none;">
                <label for="catatan_regulator" class="form-label">Catatan Regulator</label>
                <textarea class="form-control" name="catatan_regulator" id="catatan_regulator" cols="30" rows="5">{{ old('catatan_regulator') ?? $checkSheetpowder->catatan_regulator}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_regulator" class="form-label">Foto Regulator</label>
                <input type="hidden" name="oldImage_regulator" value="{{ $checkSheetpowder->photo_regulator }}">
                @if ($checkSheetpowder->photo_regulator)
                    <img src="{{ asset('storage/' . $checkSheetpowder->photo_regulator) }}" class="photo-regulator-preview img-fluid mb-3 d-block" style="max-height: 300px">
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
                        <option value="OK" {{ old('lock_pin') ?? $checkSheetpowder->lock_pin == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('lock_pin') ?? $checkSheetpowder->lock_pin == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_lock_pin"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_lock_pin" style="display:none;">
                <label for="catatan_lock_pin" class="form-label">Catatan Lock Pin</label>
                <textarea class="form-control" name="catatan_lock_pin" id="catatan_lock_pin" cols="30" rows="5">{{ old('catatan_lock_pin') ?? $checkSheetpowder->catatan_lock_pin}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_lock_pin" class="form-label">Foto Lock Pin</label>
                <input type="hidden" name="oldImage_lock_pin" value="{{ $checkSheetpowder->photo_lock_pin }}">
                @if ($checkSheetpowder->photo_lock_pin)
                    <img src="{{ asset('storage/' . $checkSheetpowder->photo_lock_pin) }}" class="photo-lock_pin-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-lock_pin-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_lock_pin" name="photo_lock_pin" onchange="previewImage('photo_lock_pin', 'photo-lock_pin-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="powder" class="form-label">Powder</label>
                <div class="input-group">
                    <select class="form-select" id="powder" name="powder">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('powder') ?? $checkSheetpowder->powder == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('powder') ?? $checkSheetpowder->powder == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_powder"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_powder" style="display:none;">
                <label for="catatan_powder" class="form-label">Catatan Powder</label>
                <textarea class="form-control" name="catatan_powder" id="catatan_powder" cols="30" rows="5">{{ old('catatan_powder') ?? $checkSheetpowder->catatan_powder}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_powder" class="form-label">Foto Berat Tabung</label>
                <input type="hidden" name="oldImage_powder" value="{{ $checkSheetpowder->photo_powder }}">
                @if ($checkSheetpowder->photo_powder)
                    <img src="{{ asset('storage/' . $checkSheetpowder->photo_powder) }}" class="photo-powder-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-powder-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_powder" name="photo_powder" onchange="previewImage('photo_powder', 'photo-powder-preview')">
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
        const tambahCatatanButtonTabung = document.getElementById('tambahCatatan_tabung');
        const tambahCatatanButtonRegulator = document.getElementById('tambahCatatan_regulator');
        const tambahCatatanButtonLockPin = document.getElementById('tambahCatatan_lock_pin');
        const tambahCatatanButtonPowder = document.getElementById('tambahCatatan_powder');

        const catatanFieldPressure = document.getElementById('catatanField_pressure');
        const catatanFieldHose = document.getElementById('catatanField_hose');
        const catatanFieldTabung = document.getElementById('catatanField_tabung');
        const catatanFieldRegulator = document.getElementById('catatanField_regulator');
        const catatanFieldLockPin = document.getElementById('catatanField_lock_pin');
        const catatanFieldPowder = document.getElementById('catatanField_powder');

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

        tambahCatatanButtonPowder.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldPowder.style.display === 'none') {
                catatanFieldPowder.style.display = 'block';
                tambahCatatanButtonPowder.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonPowder.classList.remove('btn-success');
                tambahCatatanButtonPowder.classList.add('btn-danger');
            } else {
                catatanFieldPowder.style.display = 'none';
                tambahCatatanButtonPowder.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonPowder.classList.remove('btn-danger');
                tambahCatatanButtonPowder.classList.add('btn-success');
            }
        });
    });
</script>
@endsection
