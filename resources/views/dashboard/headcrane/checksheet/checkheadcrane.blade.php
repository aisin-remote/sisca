@extends('dashboard.app')
@section('title', 'Check Sheet Head Crane')

@section('content')

    <div class="container">
        <h1>Check Sheet Head Crane</h1>
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
                <form action="{{ route('process.checksheet.headcrane', ['headcraneNumber' => $headcraneNumber]) }}"
                    method="POST" enctype="multipart/form-data">
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
                        <label for="headcrane_number" class="form-label">Nomor Head Crane</label>
                        <input type="text" class="form-control" id="headcrane_number" value="{{ $headcraneNumber }}"
                            name="headcrane_number" required autofocus readonly>
                    </div>
            </div>
            <div class="col-md-6">


                <div class="mb-3">
                    <label for="cross_travelling" class="form-label">Cross Travelling</label>
                    <div class="input-group">
                        <select class="form-select" id="cross_travelling" name="cross_travelling" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('cross_travelling') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('cross_travelling') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_cross_travelling"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_cross_travelling" style="display:none;">
                    <label for="catatan_cross_travelling" class="form-label">Catatan Cross travelling</label>
                    <textarea class="form-control" name="catatan_cross_travelling" id="catatan_cross_travelling" cols="30"
                        rows="5">{{ old('catatan_cross_travelling') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_cross_travelling" class="form-label">Foto Cross Travelling</label>
                    <img class="photo-cross_travelling-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_cross_travelling" name="photo_cross_travelling"
                        required onchange="previewImage('photo_cross_travelling', 'photo-cross_travelling-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="long_travelling" class="form-label">Long Travelling</label>
                    <div class="input-group">
                        <select class="form-select" id="long_travelling" name="long_travelling" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('long_travelling') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('long_travelling') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_long_travelling"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_long_travelling" style="display:none;">
                    <label for="catatan_long_travelling" class="form-label">Catatan Long Travelling</label>
                    <textarea class="form-control" name="catatan_long_travelling" id="catatan_long_travelling" cols="30"
                        rows="5">{{ old('catatan_long_travelling') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_long_travelling" class="form-label">Foto Long Travelling</label>
                    <img class="photo-long_travelling-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_long_travelling" name="photo_long_travelling"
                        required onchange="previewImage('photo_long_travelling', 'photo-long_travelling-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="button_up" class="form-label">Button Up</label>
                    <div class="input-group">
                        <select class="form-select" id="button_up" name="button_up" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('button_up') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('button_up') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_button_up"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_button_up" style="display:none;">
                    <label for="catatan_button_up" class="form-label">Catatan Button Up</label>
                    <textarea class="form-control" name="catatan_button_up" id="catatan_button_up" cols="30" rows="5">{{ old('catatan_button_up') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_button_up" class="form-label">Foto Button Up</label>
                    <img class="photo-button_up-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_button_up" name="photo_button_up" required
                        onchange="previewImage('photo_button_up', 'photo-button_up-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="button_down" class="form-label">Button Down</label>
                    <div class="input-group">
                        <select class="form-select" id="button_down" name="button_down" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('button_down') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('button_down') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_button_down"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_button_down" style="display:none;">
                    <label for="catatan_button_down" class="form-label">Catatan Button Down</label>
                    <textarea class="form-control" name="catatan_button_down" id="catatan_button_down" cols="30" rows="5">{{ old('catatan_button_down') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_button_down" class="form-label">Foto Button Down</label>
                    <img class="photo-button_down-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_button_down" name="photo_button_down" required
                        onchange="previewImage('photo_button_down', 'photo-button_down-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="button_push" class="form-label">Buttton Push</label>
                    <div class="input-group">
                        <select class="form-select" id="button_push" name="button_push" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('button_push') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('button_push') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_button_push"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_button_push" style="display:none;">Button Push</label>
                    <textarea class="form-control" name="catatan_button_push" id="catatan_button_push" cols="30" rows="5">{{ old('catatan_button_push') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_button_push" class="form-label">Foto Button Push</label>
                    <img class="photo-button_push-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_button_push" name="photo_button_push" required
                        onchange="previewImage('photo_button_push', 'photo-button_push-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="wire_rope" class="form-label">Wire Rope</label>
                    <div class="input-group">
                        <select class="form-select" id="wire_rope" name="wire_rope" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('wire_rope') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('wire_rope') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_wire_rope"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_wire_rope" style="display:none;">
                    <label for="catatan_wire_rope" class="form-label">Catatan Wire Rope</label>
                    <textarea class="form-control" name="catatan_wire_rope" id="catatan_wire_rope" cols="30" rows="5">{{ old('catatan_wire_rope') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_wire_rope" class="form-label">Foto Wire Rope</label>
                    <img class="photo-wire_rope-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_wire_rope" name="photo_wire_rope" required
                        onchange="previewImage('photo_wire_rope', 'photo-wire_rope-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="block_hook" class="form-label">Block Hook</label>
                    <div class="input-group">
                        <select class="form-select" id="block_hook" name="block_hook" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('block_hook') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('block_hook') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_block_hook"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_block_hook" style="display:none;">
                    <label for="catatan_block_hook" class="form-label">Catatan Block Hook</label>
                    <textarea class="form-control" name="catatan_block_hook" id="catatan_block_hook" cols="30" rows="5">{{ old('catatan_block_hook') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_block_hook" class="form-label">Foto Block Hook</label>
                    <img class="photo-block_hook-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_block_hook" name="photo_block_hook" required
                        onchange="previewImage('photo_block_hook', 'photo-block_hook-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="hom" class="form-label">Hom</label>
                    <div class="input-group">
                        <select class="form-select" id="hom" name="hom" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('hom') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('hom') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_hom"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_hom" style="display:none;">
                    <label for="catatan_hom" class="form-label">Catatan Hom</label>
                    <textarea class="form-control" name="catatan_hom" id="catatan_hom" cols="30" rows="5">{{ old('catatan_hom') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_hom" class="form-label">Foto Hom</label>
                    <img class="photo-hom-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_hom" name="photo_hom" required
                        onchange="previewImage('photo_hom', 'photo-hom-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="emergency_stop" class="form-label">Emergency Stop</label>
                    <div class="input-group">
                        <select class="form-select" id="emergency_stop" name="emergency_stop" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('emergency_stop') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('emergency_stop') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_emergency_stop"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_emergency_stop" style="display:none;">
                    <label for="catatan_emergency_stop" class="form-label">Catatan Emergency Stop</label>
                    <textarea class="form-control" name="catatan_emergency_stop" id="catatan_emergency_stop" cols="30"
                        rows="5">{{ old('catatan_emergency_stop') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_emergency_stop" class="form-label">Foto Emergency Stop</label>
                    <img class="photo-emergency_stop-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_emergency_stop" name="photo_emergency_stop"
                        required onchange="previewImage('photo_emergency_stop', 'photo-emergency_stop-preview')">
                </div>

                <hr>

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
            const tambahCatatanButtonCrossTravelling = document.getElementById('tambahCatatan_cross_travelling');
            const tambahCatatanLongTravelling = document.getElementById('tambahCatatan_long_travelling');
            const tambahCatatanButtonButtonUp = document.getElementById('tambahCatatan_button_up');
            const tambahCatatanButtonButtonDown = document.getElementById('tambahCatatan_button_down');
            const tambahCatatanButtonButtonPush = document.getElementById('tambahCatatan_button_push');
            const tambahCatatanButtonWireRope = document.getElementById('tambahCatatan_wire_rope');
            const tambahCatatanButtonBlockHook = document.getElementById('tambahCatatan_block_hook');
            const tambahCatatanButtonHom = document.getElementById('tambahCatatan_hom');
            const tambahCatatanButtonEmergencyStop = document.getElementById(
                'tambahCatatan_emergency_stop');



            const catatanFieldCrossTravelling = document.getElementById('catatanField_cross_travelling');
            const catatanFieldLongTravelling = document.getElementById('catatanField_long_travelling');
            const catatanFieldButtonUp = document.getElementById('catatanField_button_up');
            const catatanFieldButtonDown = document.getElementById('catatanField_button_down');
            const catatanFieldButtonPush = document.getElementById('catatanField_button_push');
            const catatanFieldWireRope = document.getElementById('catatanField_wire_rope');
            const catatanFieldBlockHook = document.getElementById('catatanField_block_hook');
            const catatanFieldHom = document.getElementById('catatanField_hom');
            const catatanFieldEmergencyStop = document.getElementById('catatanField_emergency_stop');



            // Tambahkan event listener untuk button "Tambah Catatan Buckle"
            tambahCatatanButtonCrossTravelling.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldCrosstambahCatatanButtonCrossTravelling.style.display === 'none') {
                    catatanFieldCrosstambahCatatanButtonCrossTravelling.style.display = 'block';
                    tambahCatatanButtonCrossTravelling.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonCrossTravelling.classList.remove('btn-success');
                    tambahCatatanButtonCrossTravelling.classList.add('btn-danger');
                } else {
                    catatanFieldCrosstambahCatatanButtonCrossTravelling.style.display = 'none';
                    tambahCatatanButtonCrossTravelling.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonCrossTravelling.classList.remove('btn-danger');
                    tambahCatatanButtonCrossTravelling.classList.add('btn-success');
                }
            });

            // ... Tambahkan event listener untuk tombol-tombol tambah catatan lainnya di sini ...
            tambahCatatanButtonLongTravelling.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldLongTravelling.style.display === 'none') {
                    catatanFieldLongTravelling.style.display = 'block';
                    tambahCatatanButtonLongTravelling.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonLongTravelling.classList.remove('btn-success');
                    tambahCatatanButtonLongTravelling.classList.add('btn-danger');
                } else {
                    catatanFieldLongTravelling.style.display = 'none';
                    tambahCatatanButtonLongTravelling.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonLongTravelling.classList.remove('btn-danger');
                    tambahCatatanButtonLongTravelling.classList.add('btn-success');
                }
            });

            tambahCatatanButtonButtonUp.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldButambahCatatanButtonButtonUp.style.display === 'none') {
                    catatanFieldButambahCatatanButtonButtonUp.style.display = 'block';
                    tambahCatatanButtonButtonUp.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonButtonUp.classList.remove('btn-success');
                    tambahCatatanButtonButtonUp.classList.add('btn-danger');
                } else {
                    catatanFieldButambahCatatanButtonButtonUp.style.display = 'none';
                    tambahCatatanButtonButtonUp.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonButtonUp.classList.remove('btn-danger');
                    tambahCatatanButtonButtonUp.classList.add('btn-success');
                }
            });

            tambahCatatanButtonButtonDown.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldtambahCatatanButtonButtonDown.style.display === 'none') {
                    catatanFieldtambahCatatanButtonButtonDown.style.display = 'block';
                    tambahCatatanButtonButtonDown.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonButtonDown.classList.remove('btn-success');
                    tambahCatatanButtonButtonDown.classList.add('btn-danger');
                } else {
                    catatanFieldtambahCatatanButtonButtonDown.style.display = 'none';
                    tambahCatatanButtonButtonDown.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonButtonDown.classList.remove('btn-danger');
                    tambahCatatanButtonButtonDown.classList.add('btn-success');
                }
            });

            tambahCatatanButtonButtonPush.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldBtambahCatatanButtonButtonPush.style.display === 'none') {
                    catatanFieldBtambahCatatanButtonButtonPush.style.display = 'block';
                    tambahCatatanButtonButtonPush.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonButtonPush.classList.remove('btn-success');
                    tambahCatatanButtonButtonPush.classList.add('btn-danger');
                } else {
                    catatanFieldBtambahCatatanButtonButtonPush.style.display = 'none';
                    tambahCatatanButtonButtonPush.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonButtonPush.classList.remove('btn-danger');
                    tambahCatatanButtonButtonPush.classList.add('btn-success');
                }
            });

            tambahCatatanButtonWireRope.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldWirtambahCatatanButtonWireRope.style.display === 'none') {
                    catatanFieldWirtambahCatatanButtonWireRope.style.display = 'block';
                    tambahCatatanButtonWireRope.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonWireRope.classList.remove('btn-success');
                    tambahCatatanButtonWireRope.classList.add('btn-danger');
                } else {
                    catatanFieldWirtambahCatatanButtonWireRope.style.display = 'none';
                    tambahCatatanButtonWireRope.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonWireRope.classList.remove('btn-danger');
                    tambahCatatanButtonWireRope.classList.add('btn-success');
                }
            });

            tambahCatatanButtonBlockHook.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldBltambahCatatanButtonBlockHook.style.display === 'none') {
                    catatanFieldBltambahCatatanButtonBlockHook.style.display = 'block';
                    tambahCatatanButtonBlockHook.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonBlockHook.classList.remove('btn-success');
                    tambahCatatanButtonBlockHook.classList.add('btn-danger');
                } else {
                    catatanFieldBltambahCatatanButtonBlockHook.style.display = 'none';
                    tambahCatatanButtonBlockHook.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonBlockHook.classList.remove('btn-danger');
                    tambahCatatanButtonBlockHook.classList.add('btn-success');
                }
            });

            tambahCatatanButtonHom.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldHtambahCatatanButtonHom.style.display === 'none') {
                    catatanFieldHtambahCatatanButtonHom.style.display = 'block';
                    tambahCatatanButtonHom.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonHom.classList.remove('btn-success');
                    tambahCatatanButtonHom.classList.add('btn-danger');
                } else {
                    catatanFieldHtambahCatatanButtonHom.style.display = 'none';
                    tambahCatatanButtonHom.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonHom.classList.remove('btn-danger');
                    tambahCatatanButtonHom.classList.add('btn-success');
                }
            });

            tambahCatatanButtonEmergencyStop.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldEtambahCatatanButtonEmergencyStop.style.display === 'none') {
                    catatanFieldEtambahCatatanButtonEmergencyStop.style.display = 'block';
                    tambahCatatanButtonEmergencyStop.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonEmergencyStop.classList.remove('btn-success');
                    tambahCatatanButtonEmergencyStop.classList.add('btn-danger');
                } else {
                    catatanFieldEtambahCatatanButtonEmergencyStop.style.display = 'none';
                    tambahCatatanButtonEmergencyStop.innerHTML =
                        '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonEmergencyStop.classList.remove('btn-danger');
                    tambahCatatanButtonEmergencyStop.classList.add('btn-success');
                }
            });
        });
    </script>



@endsection
