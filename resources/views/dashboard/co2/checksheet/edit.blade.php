@extends('dashboard.app')
@section('title', 'Check Sheet Co2')

@section('content')

<div class="container">
    <h1>Check Sheet Co2</h1>
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
            <form action="{{ route('co2.checksheetco2.update', $checkSheettabungco2->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="tanggal_pengecekan" class="form-label">Tanggal Pengecekan</label>
                    <input type="date" class="form-control" id="tanggal_pengecekan" value="{{ $checkSheettabungco2->tanggal_pengecekan }}" name="tanggal_pengecekan" required readonly>
                </div>
                <div class="mb-3">
                    <label for="npk" class="form-label">NPK</label>
                    <input type="text" class="form-control" id="npk" name="npk" value="{{ $checkSheettabungco2->npk }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="tabung_number" class="form-label">Nomor Tabung</label>
                    <input type="text" class="form-control" id="tabung_number" value="{{ $checkSheettabungco2->tabung_number }}" name="tabung_number" required autofocus readonly>
                </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="cover" class="form-label">Cover</label>
                <div class="input-group">
                    <select class="form-select" id="cover" name="cover">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('cover') ?? $checkSheettabungco2->cover == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('cover') ?? $checkSheettabungco2->cover == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_cover"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_cover" style="display:none;">
                <label for="catatan_cover" class="form-label">Catatan Cover</label>
                <textarea class="form-control" name="catatan_cover" id="catatan_cover" cols="30" rows="5">{{ old('catatan_cover') ?? $checkSheettabungco2->catatan_cover}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_cover" class="form-label">Foto Cover</label>
                <input type="hidden" name="oldImage_cover" value="{{ $checkSheettabungco2->photo_cover }}">
                @if ($checkSheettabungco2->photo_cover)
                    <img src="{{ asset('storage/' . $checkSheettabungco2->photo_cover) }}" class="photo-cover-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-cover-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_cover" name="photo_cover" onchange="previewImage('photo_cover', 'photo-cover-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="tabung" class="form-label">Tabung</label>
                <div class="input-group">
                    <select class="form-select" id="tabung" name="tabung">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('tabung') ?? $checkSheettabungco2->tabung == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('tabung') ?? $checkSheettabungco2->tabung == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_tabung"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_tabung" style="display:none;">
                <label for="catatan_tabung" class="form-label">Catatan Tabung</label>
                <textarea class="form-control" name="catatan_tabung" id="catatan_tabung" cols="30" rows="5">{{ old('catatan_tabung') ?? $checkSheettabungco2->catatan_tabung}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_tabung" class="form-label">Foto Tabung</label>
                <input type="hidden" name="oldImage_tabung" value="{{ $checkSheettabungco2->photo_tabung }}">
                @if ($checkSheettabungco2->photo_tabung)
                    <img src="{{ asset('storage/' . $checkSheettabungco2->photo_tabung) }}" class="photo-tabung-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-tabung-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_tabung" name="photo_tabung" onchange="previewImage('photo_tabung', 'photo-tabung-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="lock_pin" class="form-label">Lock Pin</label>
                <div class="input-group">
                    <select class="form-select" id="lock_pin" name="lock_pin">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('lock_pin') ?? $checkSheettabungco2->lock_pin == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('lock_pin') ?? $checkSheettabungco2->lock_pin == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_lock_pin"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_lock_pin" style="display:none;">
                <label for="catatan_lock_pin" class="form-label">Catatan Lock Pin</label>
                <textarea class="form-control" name="catatan_lock_pin" id="catatan_lock_pin" cols="30" rows="5">{{ old('catatan_lock_pin') ?? $checkSheettabungco2->catatan_lock_pin}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_lock_pin" class="form-label">Foto Lock Pin</label>
                <input type="hidden" name="oldImage_lock_pin" value="{{ $checkSheettabungco2->photo_lock_pin }}">
                @if ($checkSheettabungco2->photo_lock_pin)
                    <img src="{{ asset('storage/' . $checkSheettabungco2->photo_lock_pin) }}" class="photo-lock_pin-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-lock_pin-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_lock_pin" name="photo_lock_pin" onchange="previewImage('photo_lock_pin', 'photo-lock_pin-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="segel_lock_pin" class="form-label">Segel Lock Pin</label>
                <div class="input-group">
                    <select class="form-select" id="segel_lock_pin" name="segel_lock_pin">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('segel_lock_pin') ?? $checkSheettabungco2->segel_lock_pin == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('segel_lock_pin') ?? $checkSheettabungco2->segel_lock_pin == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_segel_lock_pin"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_segel_lock_pin" style="display:none;">
                <label for="catatan_segel_lock_pin" class="form-label">Catatan Segel Lock Pin</label>
                <textarea class="form-control" name="catatan_segel_lock_pin" id="catatan_segel_lock_pin" cols="30" rows="5">{{ old('catatan_segel_lock_pin') ?? $checkSheettabungco2->catatan_segel_lock_pin}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_segel_lock_pin" class="form-label">Foto Segel Lock Pin</label>
                <input type="hidden" name="oldImage_segel_lock_pin" value="{{ $checkSheettabungco2->photo_segel_lock_pin }}">
                @if ($checkSheettabungco2->photo_segel_lock_pin)
                    <img src="{{ asset('storage/' . $checkSheettabungco2->photo_segel_lock_pin) }}" class="photo-segel_lock_pin-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-segel_lock_pin-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_segel_lock_pin" name="photo_segel_lock_pin" onchange="previewImage('photo_segel_lock_pin', 'photo-segel_lock_pin-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="kebocoran_regulator_tabung" class="form-label">Kebocoran Regulator Tabung</label>
                <div class="input-group">
                    <select class="form-select" id="kebocoran_regulator_tabung" name="kebocoran_regulator_tabung">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('kebocoran_regulator_tabung') ?? $checkSheettabungco2->kebocoran_regulator_tabung == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('kebocoran_regulator_tabung') ?? $checkSheettabungco2->kebocoran_regulator_tabung == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_kebocoran_regulator_tabung"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_kebocoran_regulator_tabung" style="display:none;">
                <label for="catatan_kebocoran_regulator_tabung" class="form-label">Catatan Kebocoran Regulator Tabung</label>
                <textarea class="form-control" name="catatan_kebocoran_regulator_tabung" id="catatan_kebocoran_regulator_tabung" cols="30" rows="5">{{ old('catatan_kebocoran_regulator_tabung') ?? $checkSheettabungco2->catatan_kebocoran_regulator_tabung}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_kebocoran_regulator_tabung" class="form-label">Foto Kebocoran Regulator Tabung</label>
                <input type="hidden" name="oldImage_kebocoran_regulator_tabung" value="{{ $checkSheettabungco2->photo_kebocoran_regulator_tabung }}">
                @if ($checkSheettabungco2->photo_kebocoran_regulator_tabung)
                    <img src="{{ asset('storage/' . $checkSheettabungco2->photo_kebocoran_regulator_tabung) }}" class="photo-kebocoran_regulator_tabung-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-kebocoran_regulator_tabung-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_kebocoran_regulator_tabung" name="photo_kebocoran_regulator_tabung" onchange="previewImage('photo_kebocoran_regulator_tabung', 'photo-kebocoran_regulator_tabung-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="selang" class="form-label">Selang</label>
                <div class="input-group">
                    <select class="form-select" id="selang" name="selang">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('selang') ?? $checkSheettabungco2->selang == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('selang') ?? $checkSheettabungco2->selang == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_selang"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_selang" style="display:none;">
                <label for="catatan_selang" class="form-label">Catatan Selang</label>
                <textarea class="form-control" name="catatan_selang" id="catatan_selang" cols="30" rows="5">{{ old('catatan_selang') ?? $checkSheettabungco2->catatan_selang}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_selang" class="form-label">Foto Selang</label>
                <input type="hidden" name="oldImage_selang" value="{{ $checkSheettabungco2->photo_selang }}">
                @if ($checkSheettabungco2->photo_selang)
                    <img src="{{ asset('storage/' . $checkSheettabungco2->photo_selang) }}" class="photo-selang-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-selang-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_selang" name="photo_selang" onchange="previewImage('photo_selang', 'photo-selang-preview')">
            </div>

        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12">
        <p><strong>Catatan:</strong> Jika ada abnormal yang ditemukan segera laporkan ke atasan.</p>
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
        const tambahCatatanButtonCover = document.getElementById('tambahCatatan_cover');
        const tambahCatatanButtonTabung = document.getElementById('tambahCatatan_tabung');
        const tambahCatatanButtonLock_pin = document.getElementById('tambahCatatan_lock_pin');
        const tambahCatatanButtonSegel_lock_pin = document.getElementById('tambahCatatan_segel_lock_pin');
        const tambahCatatanButtonKebocoran_regulator_tabung = document.getElementById('tambahCatatan_kebocoran_regulator_tabung');
        const tambahCatatanButtonSelang = document.getElementById('tambahCatatan_selang');


        const catatanFieldCover = document.getElementById('catatanField_cover');
        const catatanFieldTabung = document.getElementById('catatanField_tabung');
        const catatanFieldLock_pin = document.getElementById('catatanField_lock_pin');
        const catatanFieldSegel_lock_pin = document.getElementById('catatanField_segel_lock_pin');
        const catatanFieldKebocoran_regulator_tabung = document.getElementById('catatanField_kebocoran_regulator_tabung');
        const catatanFieldSelang = document.getElementById('catatanField_selang');


        // Tambahkan event listener untuk button "Tambah Catatan Cover"
        tambahCatatanButtonCover.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldCover.style.display === 'none') {
                catatanFieldCover.style.display = 'block';
                tambahCatatanButtonCover.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonCover.classList.remove('btn-success');
                tambahCatatanButtonCover.classList.add('btn-danger');
            } else {
                catatanFieldCover.style.display = 'none';
                tambahCatatanButtonCover.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonCover.classList.remove('btn-danger');
                tambahCatatanButtonCover.classList.add('btn-success');
            }
        });

        // ... Tambahkan event listener untuk tombol-tombol tambah catatan lainnya di sini ...
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

        tambahCatatanButtonLock_pin.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldLock_pin.style.display === 'none') {
                catatanFieldLock_pin.style.display = 'block';
                tambahCatatanButtonLock_pin.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonLock_pin.classList.remove('btn-success');
                tambahCatatanButtonLock_pin.classList.add('btn-danger');
            } else {
                catatanFieldLock_pin.style.display = 'none';
                tambahCatatanButtonLock_pin.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonLock_pin.classList.remove('btn-danger');
                tambahCatatanButtonLock_pin.classList.add('btn-success');
            }
        });

        tambahCatatanButtonSegel_lock_pin.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldSegel_lock_pin.style.display === 'none') {
                catatanFieldSegel_lock_pin.style.display = 'block';
                tambahCatatanButtonSegel_lock_pin.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonSegel_lock_pin.classList.remove('btn-success');
                tambahCatatanButtonSegel_lock_pin.classList.add('btn-danger');
            } else {
                catatanFieldSegel_lock_pin.style.display = 'none';
                tambahCatatanButtonSegel_lock_pin.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonSegel_lock_pin.classList.remove('btn-danger');
                tambahCatatanButtonSegel_lock_pin.classList.add('btn-success');
            }
        });

        tambahCatatanButtonKebocoran_regulator_tabung.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldKebocoran_regulator_tabung.style.display === 'none') {
                catatanFieldKebocoran_regulator_tabung.style.display = 'block';
                tambahCatatanButtonKebocoran_regulator_tabung.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonKebocoran_regulator_tabung.classList.remove('btn-success');
                tambahCatatanButtonKebocoran_regulator_tabung.classList.add('btn-danger');
            } else {
                catatanFieldKebocoran_regulator_tabung.style.display = 'none';
                tambahCatatanButtonKebocoran_regulator_tabung.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonKebocoran_regulator_tabung.classList.remove('btn-danger');
                tambahCatatanButtonKebocoran_regulator_tabung.classList.add('btn-success');
            }
        });

        tambahCatatanButtonSelang.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldSelang.style.display === 'none') {
                catatanFieldSelang.style.display = 'block';
                tambahCatatanButtonSelang.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonSelang.classList.remove('btn-success');
                tambahCatatanButtonSelang.classList.add('btn-danger');
            } else {
                catatanFieldSelang.style.display = 'none';
                tambahCatatanButtonSelang.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonSelang.classList.remove('btn-danger');
                tambahCatatanButtonSelang.classList.add('btn-success');
            }
        });
    });
</script>

@endsection
