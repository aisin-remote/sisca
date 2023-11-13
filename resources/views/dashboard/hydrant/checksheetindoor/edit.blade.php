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
            <form action="{{ route('hydrant.checksheetindoor.update', $checkSheetindoor->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="tanggal_pengecekan" class="form-label">Tanggal Pengecekan</label>
                    <input type="date" class="form-control" id="tanggal_pengecekan" value="{{ $checkSheetindoor->tanggal_pengecekan }}" name="tanggal_pengecekan" required readonly>
                </div>
                <div class="mb-3">
                    <label for="npk" class="form-label">NPK</label>
                    <input type="text" class="form-control" id="npk" name="npk" value="{{ $checkSheetindoor->npk }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="hydrant_number" class="form-label">Nomor Hydrant</label>
                    <input type="text" class="form-control" id="hydrant_number" value="{{ $checkSheetindoor->hydrant_number }}" name="hydrant_number" required autofocus readonly>
                </div>
        </div>


        <div class="col-md-6">
            <div class="mb-3">
                <label for="pintu" class="form-label">Pintu</label>
                <div class="input-group">
                    <select class="form-select" id="pintu" name="pintu">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('pintu') ?? $checkSheetindoor->pintu == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('pintu') ?? $checkSheetindoor->pintu == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_pintu"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_pintu" style="display:none;">
                <label for="catatan_pintu" class="form-label">Catatan Pintu</label>
                <textarea class="form-control" name="catatan_pintu" id="catatan_pintu" cols="30" rows="5">{{ old('catatan_pintu') ?? $checkSheetindoor->catatan_pintu}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_pintu" class="form-label">Foto Pintu</label>
                <input type="hidden" name="oldImage_pintu" value="{{ $checkSheetindoor->photo_pintu }}">
                @if ($checkSheetindoor->photo_pintu)
                    <img src="{{ asset('storage/' . $checkSheetindoor->photo_pintu) }}" class="photo-pintu-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-pintu-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_pintu" name="photo_pintu" onchange="previewImage('photo_pintu', 'photo-pintu-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="lampu" class="form-label">Lampu</label>
                <div class="input-group">
                    <select class="form-select" id="lampu" name="lampu">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('lampu') ?? $checkSheetindoor->lampu == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('lampu') ?? $checkSheetindoor->lampu == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_lampu"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_lampu" style="display:none;">
                <label for="catatan_lampu" class="form-label">Catatan Lampu</label>
                <textarea class="form-control" name="catatan_lampu" id="catatan_lampu" cols="30" rows="5">{{ old('catatan_lampu') ?? $checkSheetindoor->catatan_lampu}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_lampu" class="form-label">Foto Lampu</label>
                <input type="hidden" name="oldImage_lampu" value="{{ $checkSheetindoor->photo_lampu }}">
                @if ($checkSheetindoor->photo_lampu)
                    <img src="{{ asset('storage/' . $checkSheetindoor->photo_lampu) }}" class="photo-lampu-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-lampu-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_lampu" name="photo_lampu" onchange="previewImage('photo_lampu', 'photo-lampu-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="emergency" class="form-label">Tombol Emergency</label>
                <div class="input-group">
                    <select class="form-select" id="emergency" name="emergency">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('emergency') ?? $checkSheetindoor->emergency == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('emergency') ?? $checkSheetindoor->emergency == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_emergency"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_emergency" style="display:none;">
                <label for="catatan_emergency" class="form-label">Catatan emergency</label>
                <textarea class="form-control" name="catatan_emergency" id="catatan_emergency" cols="30" rows="5">{{ old('catatan_emergency') ?? $checkSheetindoor->catatan_emergency}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_emergency" class="form-label">Foto Emergency</label>
                <input type="hidden" name="oldImage_emergency" value="{{ $checkSheetindoor->photo_emergency }}">
                @if ($checkSheetindoor->photo_emergency)
                    <img src="{{ asset('storage/' . $checkSheetindoor->photo_emergency) }}" class="photo-emergency-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-emergency-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_emergency" name="photo_emergency" onchange="previewImage('photo_emergency', 'photo-emergency-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="nozzle" class="form-label">Nozzle</label>
                <div class="input-group">
                    <select class="form-select" id="nozzle" name="nozzle">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('nozzle') ?? $checkSheetindoor->nozzle == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('nozzle') ?? $checkSheetindoor->nozzle == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_nozzle"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_nozzle" style="display:none;">
                <label for="catatan_nozzle" class="form-label">Catatan Nozzle</label>
                <textarea class="form-control" name="catatan_nozzle" id="catatan_nozzle" cols="30" rows="5">{{ old('catatan_nozzle') ?? $checkSheetindoor->catatan_nozzle}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_nozzle" class="form-label">Foto Nozzle</label>
                <input type="hidden" name="oldImage_nozzle" value="{{ $checkSheetindoor->photo_nozzle }}">
                @if ($checkSheetindoor->photo_nozzle)
                    <img src="{{ asset('storage/' . $checkSheetindoor->photo_nozzle) }}" class="photo-nozzle-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-nozzle-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_nozzle" name="photo_nozzle" onchange="previewImage('photo_nozzle', 'photo-nozzle-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="selang" class="form-label">Selang</label>
                <div class="input-group">
                    <select class="form-select" id="selang" name="selang">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('selang') ?? $checkSheetindoor->selang == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('selang') ?? $checkSheetindoor->selang == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_selang"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_selang" style="display:none;">
                <label for="catatan_selang" class="form-label">Catatan Selang</label>
                <textarea class="form-control" name="catatan_selang" id="catatan_selang" cols="30" rows="5">{{ old('catatan_selang') ?? $checkSheetindoor->catatan_selang}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_selang" class="form-label">Foto Selang</label>
                <input type="hidden" name="oldImage_selang" value="{{ $checkSheetindoor->photo_selang }}">
                @if ($checkSheetindoor->photo_selang)
                    <img src="{{ asset('storage/' . $checkSheetindoor->photo_selang) }}" class="photo-selang-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-selang-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_selang" name="photo_selang" onchange="previewImage('photo_selang', 'photo-selang-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="valve" class="form-label">Valve</label>
                <div class="input-group">
                    <select class="form-select" id="valve" name="valve">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('valve') ?? $checkSheetindoor->valve == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('valve') ?? $checkSheetindoor->valve == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_valve"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_valve" style="display:none;">
                <label for="catatan_valve" class="form-label">Catatan Valve</label>
                <textarea class="form-control" name="catatan_valve" id="catatan_valve" cols="30" rows="5">{{ old('catatan_valve') ?? $checkSheetindoor->catatan_valve}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_valve" class="form-label">Foto Valve</label>
                <input type="hidden" name="oldImage_valve" value="{{ $checkSheetindoor->photo_valve }}">
                @if ($checkSheetindoor->photo_valve)
                    <img src="{{ asset('storage/' . $checkSheetindoor->photo_valve) }}" class="photo-valve-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-valve-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_valve" name="photo_valve" onchange="previewImage('photo_valve', 'photo-valve-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="coupling" class="form-label">Coupling/Sambungan</label>
                <div class="input-group">
                    <select class="form-select" id="coupling" name="coupling">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('coupling') ?? $checkSheetindoor->coupling == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('coupling') ?? $checkSheetindoor->coupling == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_coupling"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_coupling" style="display:none;">
                <label for="catatan_coupling" class="form-label">Catatan Coupling/Sambungan</label>
                <textarea class="form-control" name="catatan_coupling" id="catatan_coupling" cols="30" rows="5">{{ old('catatan_coupling') ?? $checkSheetindoor->catatan_coupling}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_coupling" class="form-label">Foto Coupling/Sambungan</label>
                <input type="hidden" name="oldImage_coupling" value="{{ $checkSheetindoor->photo_coupling }}">
                @if ($checkSheetindoor->photo_coupling)
                    <img src="{{ asset('storage/' . $checkSheetindoor->photo_coupling) }}" class="photo-coupling-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-coupling-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_coupling" name="photo_coupling" onchange="previewImage('photo_coupling', 'photo-coupling-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="pressure" class="form-label">Pressure</label>
                <div class="input-group">
                    <select class="form-select" id="pressure" name="pressure">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('pressure') ?? $checkSheetindoor->pressure == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('pressure') ?? $checkSheetindoor->pressure == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_pressure"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_pressure" style="display:none;">
                <label for="catatan_pressure" class="form-label">Catatan Pressure</label>
                <textarea class="form-control" name="catatan_pressure" id="catatan_pressure" cols="30" rows="5">{{ old('catatan_pressure') ?? $checkSheetindoor->catatan_pressure}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_pressure" class="form-label">Foto Pressure</label>
                <input type="hidden" name="oldImage_pressure" value="{{ $checkSheetindoor->photo_pressure }}">
                @if ($checkSheetindoor->photo_pressure)
                    <img src="{{ asset('storage/' . $checkSheetindoor->photo_pressure) }}" class="photo-pressure-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-pressure-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_pressure" name="photo_pressure" onchange="previewImage('photo_pressure', 'photo-pressure-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="kupla" class="form-label">Kopling/Kupla</label>
                <div class="input-group">
                    <select class="form-select" id="kupla" name="kupla">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('kupla') ?? $checkSheetindoor->kupla == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('kupla') ?? $checkSheetindoor->kupla == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_kupla"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_kupla" style="display:none;">
                <label for="catatan_kupla" class="form-label">Catatan Kopling/Kupla</label>
                <textarea class="form-control" name="catatan_kupla" id="catatan_kupla" cols="30" rows="5">{{ old('catatan_kupla') ?? $checkSheetindoor->catatan_kupla}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_kupla" class="form-label">Foto Kopling/Kupla</label>
                <input type="hidden" name="oldImage_kupla" value="{{ $checkSheetindoor->photo_kupla }}">
                @if ($checkSheetindoor->photo_kupla)
                    <img src="{{ asset('storage/' . $checkSheetindoor->photo_kupla) }}" class="photo-kupla-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-kupla-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_kupla" name="photo_kupla" onchange="previewImage('photo_kupla', 'photo-kupla-preview')">
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12">
        <p><strong>Catatan:</strong> Jika ada abnormal yang ditemukan segera laporkan ke atasan</p>
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
        const tambahCatatanButtonPintu = document.getElementById('tambahCatatan_pintu');
        const tambahCatatanButtonLampu = document.getElementById('tambahCatatan_lampu');
        const tambahCatatanButtonEmergency = document.getElementById('tambahCatatan_emergency');
        const tambahCatatanButtonNozzle = document.getElementById('tambahCatatan_nozzle');
        const tambahCatatanButtonSelang = document.getElementById('tambahCatatan_selang');
        const tambahCatatanButtonValve = document.getElementById('tambahCatatan_valve');
        const tambahCatatanButtonCoupling = document.getElementById('tambahCatatan_coupling');
        const tambahCatatanButtonPressure = document.getElementById('tambahCatatan_pressure');
        const tambahCatatanButtonKupla = document.getElementById('tambahCatatan_kupla');

        const catatanFieldPintu = document.getElementById('catatanField_pintu');
        const catatanFieldLampu = document.getElementById('catatanField_lampu');
        const catatanFieldEmergency = document.getElementById('catatanField_emergency');
        const catatanFieldNozzle = document.getElementById('catatanField_nozzle');
        const catatanFieldSelang = document.getElementById('catatanField_selang');
        const catatanFieldValve = document.getElementById('catatanField_valve');
        const catatanFieldCoupling = document.getElementById('catatanField_coupling');
        const catatanFieldPressure = document.getElementById('catatanField_pressure');
        const catatanFieldKupla = document.getElementById('catatanField_kupla');


        // Tambahkan event listener untuk button "Tambah Catatan Pintu"
        tambahCatatanButtonPintu.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldPintu.style.display === 'none') {
                catatanFieldPintu.style.display = 'block';
                tambahCatatanButtonPintu.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonPintu.classList.remove('btn-success');
                tambahCatatanButtonPintu.classList.add('btn-danger');
            } else {
                catatanFieldPintu.style.display = 'none';
                tambahCatatanButtonPintu.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonPintu.classList.remove('btn-danger');
                tambahCatatanButtonPintu.classList.add('btn-success');
            }
        });

        // ... Tambahkan event listener untuk tombol-tombol tambah catatan lainnya di sini ...
        tambahCatatanButtonLampu.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldLampu.style.display === 'none') {
                catatanFieldLampu.style.display = 'block';
                tambahCatatanButtonLampu.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonLampu.classList.remove('btn-success');
                tambahCatatanButtonLampu.classList.add('btn-danger');
            } else {
                catatanFieldLampu.style.display = 'none';
                tambahCatatanButtonLampu.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonLampu.classList.remove('btn-danger');
                tambahCatatanButtonLampu.classList.add('btn-success');
            }
        });

        tambahCatatanButtonEmergency.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldEmergency.style.display === 'none') {
                catatanFieldEmergency.style.display = 'block';
                tambahCatatanButtonEmergency.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonEmergency.classList.remove('btn-success');
                tambahCatatanButtonEmergency.classList.add('btn-danger');
            } else {
                catatanFieldEmergency.style.display = 'none';
                tambahCatatanButtonEmergency.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonEmergency.classList.remove('btn-danger');
                tambahCatatanButtonEmergency.classList.add('btn-success');
            }
        });

        tambahCatatanButtonNozzle.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldNozzle.style.display === 'none') {
                catatanFieldNozzle.style.display = 'block';
                tambahCatatanButtonNozzle.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonNozzle.classList.remove('btn-success');
                tambahCatatanButtonNozzle.classList.add('btn-danger');
            } else {
                catatanFieldNozzle.style.display = 'none';
                tambahCatatanButtonNozzle.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonNozzle.classList.remove('btn-danger');
                tambahCatatanButtonNozzle.classList.add('btn-success');
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

        tambahCatatanButtonValve.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldValve.style.display === 'none') {
                catatanFieldValve.style.display = 'block';
                tambahCatatanButtonValve.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonValve.classList.remove('btn-success');
                tambahCatatanButtonValve.classList.add('btn-danger');
            } else {
                catatanFieldValve.style.display = 'none';
                tambahCatatanButtonValve.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonValve.classList.remove('btn-danger');
                tambahCatatanButtonValve.classList.add('btn-success');
            }
        });

        tambahCatatanButtonCoupling.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldCoupling.style.display === 'none') {
                catatanFieldCoupling.style.display = 'block';
                tambahCatatanButtonCoupling.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonCoupling.classList.remove('btn-success');
                tambahCatatanButtonCoupling.classList.add('btn-danger');
            } else {
                catatanFieldCoupling.style.display = 'none';
                tambahCatatanButtonCoupling.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonCoupling.classList.remove('btn-danger');
                tambahCatatanButtonCoupling.classList.add('btn-success');
            }
        });

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

        tambahCatatanButtonKupla.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldKupla.style.display === 'none') {
                catatanFieldKupla.style.display = 'block';
                tambahCatatanButtonKupla.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonKupla.classList.remove('btn-success');
                tambahCatatanButtonKupla.classList.add('btn-danger');
            } else {
                catatanFieldKupla.style.display = 'none';
                tambahCatatanButtonKupla.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonKupla.classList.remove('btn-danger');
                tambahCatatanButtonKupla.classList.add('btn-success');
            }
        });
    });
</script>

@endsection
