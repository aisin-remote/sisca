@extends('dashboard.app')
@section('title', 'Check Sheet Body Harnest')

@section('content')

    <div class="container">
        <h1>Check Sheet Body Harnest</h1>
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
                <form action="{{ route('process.checksheet.bodyharnest', ['bodyharnestNumber' => $bodyharnestNumber]) }}" method="POST"
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
                        <label for="bodyharnest_number" class="form-label">Nomor Body Hernest</label>
                        <input type="text" class="form-control" id="bodyharnest_number" value="{{ $bodyharnestNumber }}"
                            name="bodyharnest_number" required autofocus readonly>
                    </div>
            </div>
            <div class="col-md-6">


                <div class="mb-3">
                    <label for="shoulder_straps" class="form-label">Shoulder Straps</label>
                    <div class="input-group">
                        <select class="form-select" id="shoulder_straps" name="shoulder_straps" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('shoulder_straps') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('shoulder_straps') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_shoulder_straps"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_shoulder_straps" style="display:none;">
                    <label for="catatan_shoulder_straps" class="form-label">Catatan Shoulder Straps</label>
                    <textarea class="form-control" name="catatan_shoulder_straps" id="catatan_shoulder_straps" cols="30" rows="5">{{ old('catatan_shoulder_straps') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_shoulder_straps" class="form-label">Foto Shoulder Straps</label>
                    <img class="photo-shoulder_straps-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_shoulder_straps" name="photo_shoulder_straps" required
                        onchange="previewImage('photo_shoulder_straps', 'photo-shoulder_straps-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="hook" class="form-label">Hook</label>
                    <div class="input-group">
                        <select class="form-select" id="hook" name="hook" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('hook') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('hook') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_hook"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_hook" style="display:none;">
                    <label for="catatan_hook" class="form-label">Catatan Hook</label>
                    <textarea class="form-control" name="catatan_hook" id="catatan_hook" cols="30" rows="5">{{ old('catatan_hook') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_hook" class="form-label">Foto Hook</label>
                    <img class="photo-hook-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_hook" name="photo_hook" required
                        onchange="previewImage('photo_hook', 'photo-hook-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="buckles_waist" class="form-label">Buckles Waist</label>
                    <div class="input-group">
                        <select class="form-select" id="buckles_waist" name="buckles_waist" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('buckles_waist') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('buckles_waist') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_buckles_waist"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_buckles_waist" style="display:none;">
                    <label for="catatan_buckles_waist" class="form-label">Catatan Buckles Waist</label>
                    <textarea class="form-control" name="catatan_buckles_waist" id="catatan_buckles_waist" cols="30" rows="5">{{ old('catatan_buckles_waist') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_buckles_waist" class="form-label">Foto Buckles Waist</label>
                    <img class="photo-buckles_waist-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_buckles_waist" name="photo_buckles_waist" required
                        onchange="previewImage('photo_buckles_waist', 'photo-buckles_waist-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="buckles_chest" class="form-label">Buckles Chest</label>
                    <div class="input-group">
                        <select class="form-select" id="buckles_chest" name="buckles_chest" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('buckles_chest') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('buckles_chest') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_buckles_chest"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_buckles_chest" style="display:none;">
                    <label for="catatan_buckles_chest" class="form-label">Catatan Buckles Chest</label>
                    <textarea class="form-control" name="catatan_buckles_chest" id="catatan_buckles_chest" cols="30" rows="5">{{ old('catatan_buckles_chest') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_buckles_chest" class="form-label">Foto Buckles Chest</label>
                    <img class="photo-buckles_chest-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_buckles_chest" name="photo_buckles_chest" required
                        onchange="previewImage('photo_buckles_chest', 'photo-buckles_chest-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="leg_straps" class="form-label">Leg Straps</label>
                    <div class="input-group">
                        <select class="form-select" id="leg_straps" name="leg_straps" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('leg_straps') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('leg_straps') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_leg_straps"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_leg_straps" style="display:none;">
                    <label for="catatan_leg_straps" class="form-label">Catatan Leg Straps</label>
                    <textarea class="form-control" name="catatan_leg_straps" id="catatan_leg_straps" cols="30" rows="5">{{ old('catatan_leg_straps') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_leg_straps" class="form-label">Foto Leg Straps</label>
                    <img class="photo-leg_straps-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_leg_straps" name="photo_leg_straps" required
                        onchange="previewImage('photo_leg_straps', 'photo-leg_straps-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="buckles_leg" class="form-label">Buckles Leg</label>
                    <div class="input-group">
                        <select class="form-select" id="buckles_leg" name="buckles_leg" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('buckles_leg') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('buckles_leg') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_buckles_leg"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_buckles_leg" style="display:none;">
                    <label for="catatan_buckles_leg" class="form-label">Catatan Buckles Leg</label>
                    <textarea class="form-control" name="catatan_buckles_leg" id="catatan_buckles_leg" cols="30" rows="5">{{ old('catatan_buckles_leg') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_buckles_leg" class="form-label">Foto Buckles Leg</label>
                    <img class="photo-buckles_leg-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_buckles_leg" name="photo_buckles_leg" required
                        onchange="previewImage('photo_buckles_leg', 'photo-buckles_leg-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="back_d_ring" class="form-label">Back D-Ring</label>
                    <div class="input-group">
                        <select class="form-select" id="back_d_ring" name="back_d_ring" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('back_d_ring') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('back_d_ring') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_back_d_ring"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_back_d_ring" style="display:none;">
                    <label for="catatan_back_d_ring" class="form-label">Catatan Back D-Ring</label>
                    <textarea class="form-control" name="catatan_back_d_ring" id="catatan_back_d_ring" cols="30" rows="5">{{ old('catatan_back_d_ring') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_back_d_ring" class="form-label">Foto Back D-Ring</label>
                    <img class="photo-back_d_ring-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_back_d_ring" name="photo_back_d_ring" required
                        onchange="previewImage('photo_back_d_ring', 'photo-back_d_ring-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="carabiner" class="form-label">Carabiner</label>
                    <div class="input-group">
                        <select class="form-select" id="carabiner" name="carabiner" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('carabiner') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('carabiner') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_carabiner"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_carabiner" style="display:none;">
                    <label for="catatan_carabiner" class="form-label">Catatan Carabiner</label>
                    <textarea class="form-control" name="catatan_carabiner" id="catatan_carabiner" cols="30" rows="5">{{ old('catatan_carabiner') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_carabiner" class="form-label">Foto Carabiner</label>
                    <img class="photo-carabiner-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_carabiner" name="photo_carabiner" required
                        onchange="previewImage('photo_carabiner', 'photo-carabiner-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="straps_rope" class="form-label">Straps / Rope</label>
                    <div class="input-group">
                        <select class="form-select" id="straps_rope" name="straps_rope" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('straps_rope') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('straps_rope') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_straps_rope"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_straps_rope" style="display:none;">
                    <label for="catatan_straps_rope" class="form-label">Catatan Straps / Rope</label>
                    <textarea class="form-control" name="catatan_straps_rope" id="catatan_straps_rope" cols="30" rows="5">{{ old('catatan_straps_rope') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_straps_rope" class="form-label">Foto Straps / Rope</label>
                    <img class="photo-straps_rope-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_straps_rope" name="photo_straps_rope" required
                        onchange="previewImage('photo_straps_rope', 'photo-straps_rope-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="shock_absorber" class="form-label">Shock Absorber</label>
                    <div class="input-group">
                        <select class="form-select" id="shock_absorber" name="shock_absorber" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('shock_absorber') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('shock_absorber') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_shock_absorber"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_shock_absorber" style="display:none;">
                    <label for="catatan_shock_absorber" class="form-label">Catatan Shock Absorber</label>
                    <textarea class="form-control" name="catatan_shock_absorber" id="catatan_shock_absorber" cols="30" rows="5">{{ old('catatan_shock_absorber') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_shock_absorber" class="form-label">Foto Shock Absorber</label>
                    <img class="photo-shock_absorber-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_shock_absorber" name="photo_shock_absorber" required
                        onchange="previewImage('photo_shock_absorber', 'photo-shock_absorber-preview')">
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
            const tambahCatatanButtonShoulder_straps = document.getElementById('tambahCatatan_shoulder_straps');
            const tambahCatatanButtonHook = document.getElementById('tambahCatatan_hook');
            const tambahCatatanButtonBuckles_waist = document.getElementById('tambahCatatan_buckles_waist');
            const tambahCatatanButtonBuckles_chest = document.getElementById('tambahCatatan_buckles_chest');
            const tambahCatatanButtonLeg_straps = document.getElementById('tambahCatatan_leg_straps');
            const tambahCatatanButtonBuckles_leg = document.getElementById('tambahCatatan_buckles_leg');
            const tambahCatatanButtonBack_d_ring = document.getElementById('tambahCatatan_back_d_ring');
            const tambahCatatanButtonCarabiner = document.getElementById('tambahCatatan_carabiner');
            const tambahCatatanButtonStraps_rope = document.getElementById('tambahCatatan_straps_rope');
            const tambahCatatanButtonShock_absorber = document.getElementById('tambahCatatan_shock_absorber');



            const catatanFieldShoulder_straps = document.getElementById('catatanField_shoulder_straps');
            const catatanFieldHook = document.getElementById('catatanField_hook');
            const catatanFieldBuckles_waist = document.getElementById('catatanField_buckles_waist');
            const catatanFieldBuckles_chest = document.getElementById('catatanField_buckles_chest');
            const catatanFieldLeg_straps = document.getElementById('catatanField_leg_straps');
            const catatanFieldBuckles_leg = document.getElementById('catatanField_buckles_leg');
            const catatanFieldBack_d_ring = document.getElementById('catatanField_back_d_ring');
            const catatanFieldCarabiner = document.getElementById('catatanField_carabiner');
            const catatanFieldStraps_rope = document.getElementById('catatanField_straps_rope');
            const catatanFieldShock_absorber = document.getElementById('catatanField_shock_absorber');



            // Tambahkan event listener untuk button "Tambah Catatan Shoulder_straps"
            tambahCatatanButtonShoulder_straps.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldShoulder_straps.style.display === 'none') {
                    catatanFieldShoulder_straps.style.display = 'block';
                    tambahCatatanButtonShoulder_straps.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonShoulder_straps.classList.remove('btn-success');
                    tambahCatatanButtonShoulder_straps.classList.add('btn-danger');
                } else {
                    catatanFieldShoulder_straps.style.display = 'none';
                    tambahCatatanButtonShoulder_straps.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonShoulder_straps.classList.remove('btn-danger');
                    tambahCatatanButtonShoulder_straps.classList.add('btn-success');
                }
            });

            // ... Tambahkan event listener untuk tombol-tombol tambah catatan lainnya di sini ...
            tambahCatatanButtonHook.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldHook.style.display === 'none') {
                    catatanFieldHook.style.display = 'block';
                    tambahCatatanButtonHook.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonHook.classList.remove('btn-success');
                    tambahCatatanButtonHook.classList.add('btn-danger');
                } else {
                    catatanFieldHook.style.display = 'none';
                    tambahCatatanButtonHook.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonHook.classList.remove('btn-danger');
                    tambahCatatanButtonHook.classList.add('btn-success');
                }
            });

            tambahCatatanButtonBuckles_waist.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldBuckles_waist.style.display === 'none') {
                    catatanFieldBuckles_waist.style.display = 'block';
                    tambahCatatanButtonBuckles_waist.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonBuckles_waist.classList.remove('btn-success');
                    tambahCatatanButtonBuckles_waist.classList.add('btn-danger');
                } else {
                    catatanFieldBuckles_waist.style.display = 'none';
                    tambahCatatanButtonBuckles_waist.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonBuckles_waist.classList.remove('btn-danger');
                    tambahCatatanButtonBuckles_waist.classList.add('btn-success');
                }
            });

            tambahCatatanButtonBuckles_chest.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldBuckles_chest.style.display === 'none') {
                    catatanFieldBuckles_chest.style.display = 'block';
                    tambahCatatanButtonBuckles_chest.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonBuckles_chest.classList.remove('btn-success');
                    tambahCatatanButtonBuckles_chest.classList.add('btn-danger');
                } else {
                    catatanFieldBuckles_chest.style.display = 'none';
                    tambahCatatanButtonBuckles_chest.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonBuckles_chest.classList.remove('btn-danger');
                    tambahCatatanButtonBuckles_chest.classList.add('btn-success');
                }
            });

            tambahCatatanButtonLeg_straps.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldLeg_straps.style.display === 'none') {
                    catatanFieldLeg_straps.style.display = 'block';
                    tambahCatatanButtonLeg_straps.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonLeg_straps.classList.remove('btn-success');
                    tambahCatatanButtonLeg_straps.classList.add('btn-danger');
                } else {
                    catatanFieldLeg_straps.style.display = 'none';
                    tambahCatatanButtonLeg_straps.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonLeg_straps.classList.remove('btn-danger');
                    tambahCatatanButtonLeg_straps.classList.add('btn-success');
                }
            });

            tambahCatatanButtonBuckles_leg.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldBuckles_leg.style.display === 'none') {
                    catatanFieldBuckles_leg.style.display = 'block';
                    tambahCatatanButtonBuckles_leg.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonBuckles_leg.classList.remove('btn-success');
                    tambahCatatanButtonBuckles_leg.classList.add('btn-danger');
                } else {
                    catatanFieldBuckles_leg.style.display = 'none';
                    tambahCatatanButtonBuckles_leg.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonBuckles_leg.classList.remove('btn-danger');
                    tambahCatatanButtonBuckles_leg.classList.add('btn-success');
                }
            });

            tambahCatatanButtonBack_d_ring.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldBack_d_ring.style.display === 'none') {
                    catatanFieldBack_d_ring.style.display = 'block';
                    tambahCatatanButtonBack_d_ring.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonBack_d_ring.classList.remove('btn-success');
                    tambahCatatanButtonBack_d_ring.classList.add('btn-danger');
                } else {
                    catatanFieldBack_d_ring.style.display = 'none';
                    tambahCatatanButtonBack_d_ring.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonBack_d_ring.classList.remove('btn-danger');
                    tambahCatatanButtonBack_d_ring.classList.add('btn-success');
                }
            });

            tambahCatatanButtonCarabiner.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldCarabiner.style.display === 'none') {
                    catatanFieldCarabiner.style.display = 'block';
                    tambahCatatanButtonCarabiner.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonCarabiner.classList.remove('btn-success');
                    tambahCatatanButtonCarabiner.classList.add('btn-danger');
                } else {
                    catatanFieldCarabiner.style.display = 'none';
                    tambahCatatanButtonCarabiner.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonCarabiner.classList.remove('btn-danger');
                    tambahCatatanButtonCarabiner.classList.add('btn-success');
                }
            });

            tambahCatatanButtonStraps_rope.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldStraps_rope.style.display === 'none') {
                    catatanFieldStraps_rope.style.display = 'block';
                    tambahCatatanButtonStraps_rope.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonStraps_rope.classList.remove('btn-success');
                    tambahCatatanButtonStraps_rope.classList.add('btn-danger');
                } else {
                    catatanFieldStraps_rope.style.display = 'none';
                    tambahCatatanButtonStraps_rope.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonStraps_rope.classList.remove('btn-danger');
                    tambahCatatanButtonStraps_rope.classList.add('btn-success');
                }
            });

            tambahCatatanButtonShock_absorber.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldShock_absorber.style.display === 'none') {
                    catatanFieldShock_absorber.style.display = 'block';
                    tambahCatatanButtonShock_absorber.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonShock_absorber.classList.remove('btn-success');
                    tambahCatatanButtonShock_absorber.classList.add('btn-danger');
                } else {
                    catatanFieldShock_absorber.style.display = 'none';
                    tambahCatatanButtonShock_absorber.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonShock_absorber.classList.remove('btn-danger');
                    tambahCatatanButtonShock_absorber.classList.add('btn-success');
                }
            });

        });
    </script>



@endsection
