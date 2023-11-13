@extends('dashboard.app')
@section('title', 'Check Sheet Nitrogen')

@section('content')

    <div class="container">
        <h1>Check Sheet Nitrogen</h1>
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

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('process.checksheet.nitrogen', ['tabungNumber' => $tabungNumber]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="tanggal_pengecekan" class="form-label">Tanggal Pengecekan</label>
                        <input type="date" class="form-control" id="tanggal_pengecekan" name="tanggal_pengecekan"
                            required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="npk" class="form-label">NPK</label>
                        <input type="text" class="form-control" id="npk" name="npk"
                            value="{{ auth()->user()->npk }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="tabung_number" class="form-label">Nomor Tabung tabung</label>
                        <input type="text" class="form-control" id="tabung_number" value="{{ $tabungNumber }}"
                            name="tabung_number" required autofocus readonly>
                    </div>
            </div>
            <div class="col-md-6">


                <div class="mb-3">
                    <label for="operasional" class="form-label">Indikator System Power</label>
                    <div class="input-group">
                        <select class="form-select" id="operasional" name="operasional" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('operasional') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('operasional') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_operasional"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_operasional" style="display:none;">
                    <label for="catatan_operasional" class="form-label">Catatan Indikator System Power</label>
                    <textarea class="form-control" name="catatan_operasional" id="catatan_operasional" cols="30" rows="5">{{ old('catatan_operasional') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_operasional" class="form-label">Foto operasional</label>
                    <img class="photo-operasional-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_operasional" name="photo_operasional" required
                        onchange="previewImage('photo_operasional', 'photo-operasional-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="selector_mode" class="form-label">Selector Mode Automatic</label>
                    <div class="input-group">
                        <select class="form-select" id="selector_mode" name="selector_mode" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('selector_mode') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('selector_mode') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_selector_mode"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_selector_mode" style="display:none;">
                    <label for="catatan_selector_mode" class="form-label">Catatan Selector Mode Automatic</label>
                    <textarea class="form-control" name="catatan_selector_mode" id="catatan_selector_mode" cols="30" rows="5">{{ old('catatan_selector_mode') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_selector_mode" class="form-label">Foto Selector Mode Automatic</label>
                    <img class="photo-selector_mode-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_selector_mode" name="photo_selector_mode" required
                        onchange="previewImage('photo_selector_mode', 'photo-selector_mode-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="pintu_tabung" class="form-label">Pintu Tabung</label>
                    <div class="input-group">
                        <select class="form-select" id="pintu_tabung" name="pintu_tabung" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('pintu_tabung') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('pintu_tabung') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_pintu_tabung"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_pintu_tabung" style="display:none;">
                    <label for="catatan_pintu_tabung" class="form-label">Catatan Pintu Tabung</label>
                    <textarea class="form-control" name="catatan_pintu_tabung" id="catatan_pintu_tabung" cols="30" rows="5">{{ old('catatan_pintu_tabung') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_pintu_tabung" class="form-label">Foto Pintu Tabung</label>
                    <img class="photo-pintu_tabung-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_pintu_tabung" name="photo_pintu_tabung" required
                        onchange="previewImage('photo_pintu_tabung', 'photo-pintu_tabung-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="pressure_pilot" class="form-label">Pressure Tabung Pilot Nitrogen</label>
                    <div class="input-group">
                        <select class="form-select" id="pressure_pilot" name="pressure_pilot" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('pressure_pilot') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('pressure_pilot') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_pressure_pilot"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_pressure_pilot" style="display:none;">
                    <label for="catatan_pressure_pilot" class="form-label">Catatan Pressure Tabung Pilot Nitrogen</label>
                    <textarea class="form-control" name="catatan_pressure_pilot" id="catatan_pressure_pilot" cols="30" rows="5">{{ old('catatan_pressure_pilot') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_pressure_pilot" class="form-label">Foto Pressure Tabung Pilot Nitrogen</label>
                    <img class="photo-pressure_pilot-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_pressure_pilot" name="photo_pressure_pilot" required
                        onchange="previewImage('photo_pressure_pilot', 'photo-pressure_pilot-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="pressure_no1" class="form-label">Pressure Tabung Nitrogen No 1</label>
                    <div class="input-group">
                        <select class="form-select" id="pressure_no1" name="pressure_no1" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('pressure_no1') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('pressure_no1') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_pressure_no1"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_pressure_no1" style="display:none;">
                    <label for="catatan_pressure_no1" class="form-label">Catatan Pressure Tabung Nitrogen No 1</label>
                    <textarea class="form-control" name="catatan_pressure_no1" id="catatan_pressure_no1" cols="30" rows="5">{{ old('catatan_pressure_no1') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_pressure_no1" class="form-label">Foto Pressure Tabung Nitrogen No 1</label>
                    <img class="photo-pressure_no1-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_pressure_no1" name="photo_pressure_no1" required
                        onchange="previewImage('photo_pressure_no1', 'photo-pressure_no1-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="pressure_no2" class="form-label">Pressure Tabung Nitrogen No 2</label>
                    <div class="input-group">
                        <select class="form-select" id="pressure_no2" name="pressure_no2" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('pressure_no2') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('pressure_no2') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_pressure_no2"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_pressure_no2" style="display:none;">
                    <label for="catatan_pressure_no2" class="form-label">Catatan Pressure Tabung Nitrogen No 2</label>
                    <textarea class="form-control" name="catatan_pressure_no2" id="catatan_pressure_no2" cols="30" rows="5">{{ old('catatan_pressure_no2') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_pressure_no2" class="form-label">Foto Pressure Tabung Nitrogen No 2</label>
                    <img class="photo-pressure_no2-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_pressure_no2" name="photo_pressure_no2" required
                        onchange="previewImage('photo_pressure_no2', 'photo-pressure_no2-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="pressure_no3" class="form-label">Pressure Tabung Nitrogen No 3</label>
                    <div class="input-group">
                        <select class="form-select" id="pressure_no3" name="pressure_no3" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('pressure_no3') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('pressure_no3') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_pressure_no3"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                    <div class="mb-3 mt-3" id="catatanField_pressure_no3" style="display:none;">
                        <label for="catatan_pressure_no3" class="form-label">Catatan Pressure Tabung Nitrogen No 3</label>
                        <textarea class="form-control" name="catatan_pressure_no3" id="catatan_pressure_no3" cols="30" rows="5">{{ old('catatan_pressure_no3') }}</textarea>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="photo_pressure_no3" class="form-label">Foto Pressure Tabung Nitrogen No 3</label>
                    <img class="photo-pressure_no3-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_pressure_no3" name="photo_pressure_no3"
                        required onchange="previewImage('photo_pressure_no3', 'photo-pressure_no3-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="pressure_no4" class="form-label">Pressure Tabung Nitrogen No 4</label>
                    <div class="input-group">
                        <select class="form-select" id="pressure_no4" name="pressure_no4" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('pressure_no4') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('pressure_no4') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_pressure_no4"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                    <div class="mb-3 mt-3" id="catatanField_pressure_no4" style="display:none;">
                        <label for="catatan_pressure_no4" class="form-label">Catatan Pressure Tabung Nitrogen No 4</label>
                        <textarea class="form-control" name="catatan_pressure_no4" id="catatan_pressure_no4" cols="30" rows="5">{{ old('catatan_pressure_no4') }}</textarea>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="photo_pressure_no4" class="form-label">Foto Pressure Tabung Nitrogen No 4</label>
                    <img class="photo-pressure_no4-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_pressure_no4" name="photo_pressure_no4"
                        required onchange="previewImage('photo_pressure_no4', 'photo-pressure_no4-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="pressure_no5" class="form-label">Pressure Tabung Nitrogen No 5</label>
                    <div class="input-group">
                        <select class="form-select" id="pressure_no5" name="pressure_no5" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('pressure_no5') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('pressure_no5') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_pressure_no5"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                    <div class="mb-3 mt-3" id="catatanField_pressure_no5" style="display:none;">
                        <label for="catatan_pressure_no5" class="form-label">Catatan Pressure Tabung Nitrogen No 5</label>
                        <textarea class="form-control" name="catatan_pressure_no5" id="catatan_pressure_no5" cols="30" rows="5">{{ old('catatan_pressure_no5') }}</textarea>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="photo_pressure_no5" class="form-label">Foto Pressure Tabung Nitrogen No 5</label>
                    <img class="photo-pressure_no5-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_pressure_no5" name="photo_pressure_no5"
                        required onchange="previewImage('photo_pressure_no5', 'photo-pressure_no5-preview')">
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
            <button type="submit" class="btn btn-primary">Kirim</button>
        </div>
    </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil elemen-elemen yang dibutuhkan
            const tambahCatatanButtonOperasional = document.getElementById('tambahCatatan_operasional');
            const tambahCatatanButtonSelector_mode = document.getElementById('tambahCatatan_selector_mode');
            const tambahCatatanButtonPintu_tabung = document.getElementById('tambahCatatan_pintu_tabung');
            const tambahCatatanButtonPressure_pilot = document.getElementById('tambahCatatan_pressure_pilot');
            const tambahCatatanButtonPressure_no1 = document.getElementById('tambahCatatan_pressure_no1');
            const tambahCatatanButtonPressure_no2 = document.getElementById('tambahCatatan_pressure_no2');
            const tambahCatatanButtonPressure_no3 = document.getElementById('tambahCatatan_pressure_no3');
            const tambahCatatanButtonPressure_no4 = document.getElementById('tambahCatatan_pressure_no4');
            const tambahCatatanButtonPressure_no5 = document.getElementById('tambahCatatan_pressure_no5');

            const catatanFieldOperasional = document.getElementById('catatanField_operasional');
            const catatanFieldSelector_mode = document.getElementById('catatanField_selector_mode');
            const catatanFieldPintu_tabung = document.getElementById('catatanField_pintu_tabung');
            const catatanFieldPressure_pilot = document.getElementById('catatanField_pressure_pilot');
            const catatanFieldPressure_no1 = document.getElementById('catatanField_pressure_no1');
            const catatanFieldPressure_no2 = document.getElementById('catatanField_pressure_no2');
            const catatanFieldPressure_no3 = document.getElementById('catatanField_pressure_no3');
            const catatanFieldPressure_no4 = document.getElementById('catatanField_pressure_no4');
            const catatanFieldPressure_no5 = document.getElementById('catatanField_pressure_no5');


            // Tambahkan event listener untuk button "Tambah Catatan Operasional"
            tambahCatatanButtonOperasional.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldOperasional.style.display === 'none') {
                    catatanFieldOperasional.style.display = 'block';
                    tambahCatatanButtonOperasional.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonOperasional.classList.remove('btn-success');
                    tambahCatatanButtonOperasional.classList.add('btn-danger');
                } else {
                    catatanFieldOperasional.style.display = 'none';
                    tambahCatatanButtonOperasional.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonOperasional.classList.remove('btn-danger');
                    tambahCatatanButtonOperasional.classList.add('btn-success');
                }
            });

            // ... Tambahkan event listener untuk tombol-tombol tambah catatan lainnya di sini ...
            tambahCatatanButtonSelector_mode.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldSelector_mode.style.display === 'none') {
                    catatanFieldSelector_mode.style.display = 'block';
                    tambahCatatanButtonSelector_mode.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonSelector_mode.classList.remove('btn-success');
                    tambahCatatanButtonSelector_mode.classList.add('btn-danger');
                } else {
                    catatanFieldSelector_mode.style.display = 'none';
                    tambahCatatanButtonSelector_mode.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonSelector_mode.classList.remove('btn-danger');
                    tambahCatatanButtonSelector_mode.classList.add('btn-success');
                }
            });

            tambahCatatanButtonPintu_tabung.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldPintu_tabung.style.display === 'none') {
                    catatanFieldPintu_tabung.style.display = 'block';
                    tambahCatatanButtonPintu_tabung.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonPintu_tabung.classList.remove('btn-success');
                    tambahCatatanButtonPintu_tabung.classList.add('btn-danger');
                } else {
                    catatanFieldPintu_tabung.style.display = 'none';
                    tambahCatatanButtonPintu_tabung.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonPintu_tabung.classList.remove('btn-danger');
                    tambahCatatanButtonPintu_tabung.classList.add('btn-success');
                }
            });

            tambahCatatanButtonPressure_pilot.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldPressure_pilot.style.display === 'none') {
                    catatanFieldPressure_pilot.style.display = 'block';
                    tambahCatatanButtonPressure_pilot.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonPressure_pilot.classList.remove('btn-success');
                    tambahCatatanButtonPressure_pilot.classList.add('btn-danger');
                } else {
                    catatanFieldPressure_pilot.style.display = 'none';
                    tambahCatatanButtonPressure_pilot.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonPressure_pilot.classList.remove('btn-danger');
                    tambahCatatanButtonPressure_pilot.classList.add('btn-success');
                }
            });

            tambahCatatanButtonPressure_no1.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldPressure_no1.style.display === 'none') {
                    catatanFieldPressure_no1.style.display = 'block';
                    tambahCatatanButtonPressure_no1.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonPressure_no1.classList.remove('btn-success');
                    tambahCatatanButtonPressure_no1.classList.add('btn-danger');
                } else {
                    catatanFieldPressure_no1.style.display = 'none';
                    tambahCatatanButtonPressure_no1.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonPressure_no1.classList.remove('btn-danger');
                    tambahCatatanButtonPressure_no1.classList.add('btn-success');
                }
            });

            tambahCatatanButtonPressure_no2.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldPressure_no2.style.display === 'none') {
                    catatanFieldPressure_no2.style.display = 'block';
                    tambahCatatanButtonPressure_no2.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonPressure_no2.classList.remove('btn-success');
                    tambahCatatanButtonPressure_no2.classList.add('btn-danger');
                } else {
                    catatanFieldPressure_no2.style.display = 'none';
                    tambahCatatanButtonPressure_no2.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonPressure_no2.classList.remove('btn-danger');
                    tambahCatatanButtonPressure_no2.classList.add('btn-success');
                }
            });

            tambahCatatanButtonPressure_no3.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldPressure_no3.style.display === 'none') {
                    catatanFieldPressure_no3.style.display = 'block';
                    tambahCatatanButtonPressure_no3.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonPressure_no3.classList.remove('btn-success');
                    tambahCatatanButtonPressure_no3.classList.add('btn-danger');
                } else {
                    catatanFieldPressure_no3.style.display = 'none';
                    tambahCatatanButtonPressure_no3.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonPressure_no3.classList.remove('btn-danger');
                    tambahCatatanButtonPressure_no3.classList.add('btn-success');
                }
            });

            tambahCatatanButtonPressure_no4.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldPressure_no4.style.display === 'none') {
                    catatanFieldPressure_no4.style.display = 'block';
                    tambahCatatanButtonPressure_no4.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonPressure_no4.classList.remove('btn-success');
                    tambahCatatanButtonPressure_no4.classList.add('btn-danger');
                } else {
                    catatanFieldPressure_no4.style.display = 'none';
                    tambahCatatanButtonPressure_no4.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonPressure_no4.classList.remove('btn-danger');
                    tambahCatatanButtonPressure_no4.classList.add('btn-success');
                }
            });

            tambahCatatanButtonPressure_no5.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldPressure_no5.style.display === 'none') {
                    catatanFieldPressure_no5.style.display = 'block';
                    tambahCatatanButtonPressure_no5.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonPressure_no5.classList.remove('btn-success');
                    tambahCatatanButtonPressure_no5.classList.add('btn-danger');
                } else {
                    catatanFieldPressure_no5.style.display = 'none';
                    tambahCatatanButtonPressure_no5.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonPressure_no5.classList.remove('btn-danger');
                    tambahCatatanButtonPressure_no5.classList.add('btn-success');
                }
            });
        });
    </script>



@endsection
