@extends('dashboard.app')
@section('title', 'Check Sheet Safety Belt')

@section('content')

    <div class="container">
        <h1>Check Sheet Safety Belt</h1>
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

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('headcrane.checksheetheadcrane.update', $checkSheetheadcrane->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="tanggal_pengecekan" class="form-label">Tanggal Pengecekan</label>
                        <input type="date" class="form-control" id="tanggal_pengecekan"
                            value="{{ $checkSheetheadcrane->tanggal_pengecekan }}" name="tanggal_pengecekan" required
                            readonly>
                    </div>
                    <div class="mb-3">
                        <label for="npk" class="form-label">NPK</label>
                        <input type="text" class="form-control" id="npk" name="npk"
                            value="{{ $checkSheetheadcrane->npk }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="headcrane_number" class="form-label">Nomor Safety Belt</label>
                        <input type="text" class="form-control" id="headcrane_number"
                            value="{{ $checkSheetheadcrane->headcrane_number }}" name="headcrane_number" required autofocus
                            readonly>
                    </div>
            </div>


            <div class="col-md-6">
                <div class="mb-3">
                    <label for="cross_travelling" class="form-label">Cross Travelling</label>
                    <div class="input-group">
                        <select class="form-select" id="cross_travelling" name="cross_travelling">
                            <option value="" selected disabled>Select</option>
                            <option value="OK"
                                {{ old('cross_travelling') ?? $checkSheetheadcrane->cross_travelling == 'OK' ? 'selected' : '' }}>
                                OK</option>
                            <option value="NG"
                                {{ old('cross_travelling') ?? $checkSheetheadcrane->cross_travelling == 'NG' ? 'selected' : '' }}>
                                NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_cross_travelling"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_cross_travelling" style="display:none;">
                    <label for="catatan_cross_travelling" class="form-label">Catatan Cross Travelling</label>
                    <textarea class="form-control" name="catatan_cross_travelling" id="catatan_cross_travelling" cols="30"
                        rows="5">{{ old('catatan_cross_travelling') ?? $checkSheetheadcrane->catatan_cross_travelling }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_cross_travelling" class="form-label">Foto cross_travelling</label>
                    <input type="hidden" name="oldImage_cross_travelling"
                        value="{{ $checkSheetheadcrane->photo_cross_travelling }}">
                    @if ($checkSheetheadcrane->photo_cross_travelling)
                        <img src="{{ asset('storage/' . $checkSheetheadcrane->photo_cross_travelling) }}"
                            class="photo-cross_travelling-preview img-fluid mb-3 d-block" style="max-height: 300px">
                    @else
                        <img class="photo-cross_travelling-preview img-fluid mb-3" style="max-height: 300px">
                    @endif

                    <input type="file" class="form-control" id="photo_cross_travelling" name="photo_cross_travelling"
                        onchange="previewImage('photo_cross_travelling', 'photo-cross_travelling-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="long_travelling" class="form-label">Long Travelling</label>
                    <div class="input-group">
                        <select class="form-select" id="long_travelling" name="long_travelling">
                            <option value="" selected disabled>Select</option>
                            <option value="OK"
                                {{ old('long_travelling') ?? $checkSheetheadcrane->long_travelling == 'OK' ? 'selected' : '' }}>
                                OK</option>
                            <option value="NG"
                                {{ old('long_travelling') ?? $checkSheetheadcrane->long_travelling == 'NG' ? 'selected' : '' }}>
                                NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_long_travelling"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_long_travelling" style="display:none;">
                    <label for="catatan_long_travelling" class="form-label">Catatan Long Travelling</label>
                    <textarea class="form-control" name="catatan_long_travelling" id="catatan_long_travelling" cols="30"
                        rows="5">{{ old('catatan_long_travelling') ?? $checkSheetheadcrane->catatan_long_travelling }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_long_travelling" class="form-label">Foto Long Travelling</label>
                    <input type="hidden" name="oldImage_long_travelling"
                        value="{{ $checkSheetheadcrane->photo_long_travelling }}">
                    @if ($checkSheetheadcrane->photo_long_travelling)
                        <img src="{{ asset('storage/' . $checkSheetheadcrane->photo_long_travelling) }}"
                            class="photo-long_travelling-preview img-fluid mb-3 d-block" style="max-height: 300px">
                    @else
                        <img class="photo-long_travelling-preview img-fluid mb-3" style="max-height: 300px">
                    @endif

                    <input type="file" class="form-control" id="photo_long_travelling" name="photo_long_travelling"
                        onchange="previewImage('photo_long_travelling', 'photo-long_travelling-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="button_up" class="form-label">Button Up</label>
                    <div class="input-group">
                        <select class="form-select" id="button_up" name="button_up">
                            <option value="" selected disabled>Select</option>
                            <option value="OK"
                                {{ old('button_up') ?? $checkSheetheadcrane->button_up == 'OK' ? 'selected' : '' }}>OK
                            </option>
                            <option value="NG"
                                {{ old('button_up') ?? $checkSheetheadcrane->button_up == 'NG' ? 'selected' : '' }}>NG
                            </option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_button_up"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_button_up" style="display:none;">
                    <label for="catatan_button_up" class="form-label">Catatan Button Up</label>
                    <textarea class="form-control" name="catatan_button_up" id="catatan_button_up" cols="30" rows="5">{{ old('catatan_button_up') ?? $checkSheetheadcrane->catatan_button_up }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_button_up" class="form-label">Foto button_up</label>
                    <input type="hidden" name="oldImage_button_up" value="{{ $checkSheetheadcrane->photo_button_up }}">
                    @if ($checkSheetheadcrane->photo_button_up)
                        <img src="{{ asset('storage/' . $checkSheetheadcrane->photo_button_up) }}"
                            class="photo-button_up-preview img-fluid mb-3 d-block" style="max-height: 300px">
                    @else
                        <img class="photo-button_up-preview img-fluid mb-3" style="max-height: 300px">
                    @endif

                    <input type="file" class="form-control" id="photo_button_up" name="photo_button_up"
                        onchange="previewImage('photo_button_up', 'photo-button_up-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="button_down" class="form-label">Button Down</label>
                    <div class="input-group">
                        <select class="form-select" id="button_down" name="button_down">
                            <option value="" selected disabled>Select</option>
                            <option value="OK"
                                {{ old('button_down') ?? $checkSheetheadcrane->button_down == 'OK' ? 'selected' : '' }}>OK
                            </option>
                            <option value="NG"
                                {{ old('button_down') ?? $checkSheetheadcrane->button_down == 'NG' ? 'selected' : '' }}>NG
                            </option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_button_down"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_button_down" style="display:none;">
                    <label for="catatan_button_down" class="form-label">Catatan Button Down</label>
                    <textarea class="form-control" name="catatan_button_down" id="catatan_button_down" cols="30" rows="5">{{ old('catatan_button_down') ?? $checkSheetheadcrane->catatan_button_down }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_button_down" class="form-label">Foto Button Down</label>
                    <input type="hidden" name="oldImage_button_down"
                        value="{{ $checkSheetheadcrane->photo_button_down }}">
                    @if ($checkSheetheadcrane->photo_button_down)
                        <img src="{{ asset('storage/' . $checkSheetheadcrane->photo_button_down) }}"
                            class="photo-button_down-preview img-fluid mb-3 d-block" style="max-height: 300px">
                    @else
                        <img class="photo-button_down-preview img-fluid mb-3" style="max-height: 300px">
                    @endif

                    <input type="file" class="form-control" id="photo_button_down" name="photo_button_down"
                        onchange="previewImage('photo_button_down', 'photo-button_down-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="button_push" class="form-label">Button Push</label>
                    <div class="input-group">
                        <select class="form-select" id="button_push" name="button_push">
                            <option value="" selected disabled>Select</option>
                            <option value="OK"
                                {{ old('button_push') ?? $checkSheetheadcrane->button_push == 'OK' ? 'selected' : '' }}>OK
                            </option>
                            <option value="NG"
                                {{ old('button_push') ?? $checkSheetheadcrane->button_push == 'NG' ? 'selected' : '' }}>NG
                            </option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_button_push"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_button_push" style="display:none;">
                    <label for="catatan_button_push" class="form-label">Catatan button Push</label>
                    <textarea class="form-control" name="catatan_button_push" id="catatan_button_push" cols="30" rows="5">{{ old('catatan_button_push') ?? $checkSheetheadcrane->catatan_button_push }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_button_push" class="form-label">Foto Button Push</label>
                    <input type="hidden" name="oldImage_button_push"
                        value="{{ $checkSheetheadcrane->photo_button_push }}">
                    @if ($checkSheetheadcrane->photo_button_push)
                        <img src="{{ asset('storage/' . $checkSheetheadcrane->photo_button_push) }}"
                            class="photo-button_push-preview img-fluid mb-3 d-block" style="max-height: 300px">
                    @else
                        <img class="photo-button_push-preview img-fluid mb-3" style="max-height: 300px">
                    @endif

                    <input type="file" class="form-control" id="photo_button_push" name="photo_button_push"
                        onchange="previewImage('photo_button_push', 'photo-button_push-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="wire_rope" class="form-label">Wire Rope</label>
                    <div class="input-group">
                        <select class="form-select" id="wire_rope" name="wire_rope">
                            <option value="" selected disabled>Select</option>
                            <option value="OK"
                                {{ old('wire_rope') ?? $checkSheetheadcrane->wire_rope == 'OK' ? 'selected' : '' }}>OK
                            </option>
                            <option value="NG"
                                {{ old('wire_rope') ?? $checkSheetheadcrane->wire_rope == 'NG' ? 'selected' : '' }}>NG
                            </option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_wire_rope"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_wire_rope" style="display:none;">
                    <label for="catatan_wire_rope" class="form-label">Catatan Wire Rope</label>
                    <textarea class="form-control" name="catatan_wire_rope" id="catatan_wire_rope" cols="30" rows="5">{{ old('catatan_wire_rope') ?? $checkSheetheadcrane->catatan_wire_rope }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_wire_rope" class="form-label">Foto Wire Rope</label>
                    <input type="hidden" name="oldImage_wire_rope" value="{{ $checkSheetheadcrane->photo_wire_rope }}">
                    @if ($checkSheetheadcrane->photo_wire_rope)
                        <img src="{{ asset('storage/' . $checkSheetheadcrane->photo_wire_rope) }}"
                            class="photo-wire_rope-preview img-fluid mb-3 d-block" style="max-height: 300px">
                    @else
                        <img class="photo-wire_rope-preview img-fluid mb-3" style="max-height: 300px">
                    @endif

                    <input type="file" class="form-control" id="photo_wire_rope" name="photo_wire_rope"
                        onchange="previewImage('photo_wire_rope', 'photo-wire_rope-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="block_hook" class="form-label">Block Hook</label>
                    <div class="input-group">
                        <select class="form-select" id="block_hook" name="block_hook">
                            <option value="" selected disabled>Select</option>
                            <option value="OK"
                                {{ old('block_hook') ?? $checkSheetheadcrane->block_hook == 'OK' ? 'selected' : '' }}>OK
                            </option>
                            <option value="NG"
                                {{ old('block_hook') ?? $checkSheetheadcrane->block_hook == 'NG' ? 'selected' : '' }}>NG
                            </option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_block_hook"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_block_hook" style="display:none;">
                    <label for="catatan_block_hook" class="form-label">Catatan Block Hook</label>
                    <textarea class="form-control" name="catatan_block_hook" id="catatan_block_hook" cols="30" rows="5">{{ old('catatan_block_hook') ?? $checkSheetheadcrane->catatan_block_hook }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_block_hook" class="form-label">Foto Block Hook</label>
                    <input type="hidden" name="oldImage_block_hook"
                        value="{{ $checkSheetheadcrane->photo_block_hook }}">
                    @if ($checkSheetheadcrane->photo_block_hook)
                        <img src="{{ asset('storage/' . $checkSheetheadcrane->photo_block_hook) }}"
                            class="photo-block_hook-preview img-fluid mb-3 d-block" style="max-height: 300px">
                    @else
                        <img class="photo-block_hook-preview img-fluid mb-3" style="max-height: 300px">
                    @endif

                    <input type="file" class="form-control" id="photo_block_hook" name="photo_block_hook"
                        onchange="previewImage('photo_block_hook', 'photo-block_hook-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="hom" class="form-label">Hom</label>
                    <div class="input-group">
                        <select class="form-select" id="hom" name="hom">
                            <option value="" selected disabled>Select</option>
                            <option value="OK"
                                {{ old('hom') ?? $checkSheetheadcrane->hom == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG"
                                {{ old('hom') ?? $checkSheetheadcrane->hom == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_hom"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_hom" style="display:none;">
                    <label for="catatan_hom" class="form-label">Catatan Hom</label>
                    <textarea class="form-control" name="catatan_hom" id="catatan_hom" cols="30" rows="5">{{ old('catatan_hom') ?? $checkSheetheadcrane->catatan_hom }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_hom" class="form-label">Foto Hom</label>
                    <input type="hidden" name="oldImage_hom" value="{{ $checkSheetheadcrane->photo_hom }}">
                    @if ($checkSheetheadcrane->photo_hom)
                        <img src="{{ asset('storage/' . $checkSheetheadcrane->photo_hom) }}"
                            class="photo-hom-preview img-fluid mb-3 d-block" style="max-height: 300px">
                    @else
                        <img class="photo-hom-preview img-fluid mb-3" style="max-height: 300px">
                    @endif

                    <input type="file" class="form-control" id="photo_hom" name="photo_hom"
                        onchange="previewImage('photo_hom', 'photo-hom-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="emergency_stop" class="form-label">Emergency Stop</label>
                    <div class="input-group">
                        <select class="form-select" id="emergency_stop" name="emergency_stop">
                            <option value="" selected disabled>Select</option>
                            <option value="OK"
                                {{ old('emergency_stop') ?? $checkSheetheadcrane->emergency_stop == 'OK' ? 'selected' : '' }}>
                                OK</option>
                            <option value="NG"
                                {{ old('emergency_stop') ?? $checkSheetheadcrane->emergency_stop == 'NG' ? 'selected' : '' }}>
                                NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_emergency_stop"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_emergency_stop" style="display:none;">
                    <label for="catatan_emergency_stop" class="form-label">Catatan Emergency Stop</label>
                    <textarea class="form-control" name="catatan_emergency_stop" id="catatan_emergency_stop" cols="30"
                        rows="5">{{ old('catatan_emergency_stop') ?? $checkSheetheadcrane->catatan_emergency_stop }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_emergency_stop" class="form-label">Foto Emergency Stop</label>
                    <input type="hidden" name="oldImage_emergency_stop"
                        value="{{ $checkSheetheadcrane->photo_emergency_stop }}">
                    @if ($checkSheetheadcrane->photo_emergency_stop)
                        <img src="{{ asset('storage/' . $checkSheetheadcrane->photo_emergency_stop) }}"
                            class="photo-emergency_stop-preview img-fluid mb-3 d-block" style="max-height: 300px">
                    @else
                        <img class="photo-emergency_stop-preview img-fluid mb-3" style="max-height: 300px">
                    @endif

                    <input type="file" class="form-control" id="photo_emergency_stop" name="photo_emergency_stop"
                        onchange="previewImage('photo_emergency_stop', 'photo-emergency_stop-preview')">
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
            <button type="submit" class="btn btn-warning">Edit</button>
        </div>
    </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil elemen-elemen yang dibutuhkan
            const tambahCatatanButtonBuckle = document.getElementById('tambahCatatan_buckle');
            const tambahCatatanButtonSeams = document.getElementById('tambahCatatan_seams');
            const tambahCatatanButtonReel = document.getElementById('tambahCatatan_reel');
            const tambahCatatanButtonShock_absorber = document.getElementById('tambahCatatan_shock_absorber');
            const tambahCatatanButtonRing = document.getElementById('tambahCatatan_ring');
            const tambahCatatanButtonTorsobelt = document.getElementById('tambahCatatan_torso_belt');
            const tambahCatatanButtonStrap = document.getElementById('tambahCatatan_strap');
            const tambahCatatanButtonRope = document.getElementById('tambahCatatan_rope');
            const tambahCatatanButtonSeam_protection_tube = document.getElementById(
                'tambahCatatan_seam_protection_tube');
            const tambahCatatanButtonHook = document.getElementById('tambahCatatan_hook');



            const catatanFieldBuckle = document.getElementById('catatanField_buckle');
            const catatanFieldSeams = document.getElementById('catatanField_seams');
            const catatanFieldReel = document.getElementById('catatanField_reel');
            const catatanFieldShock_absorber = document.getElementById('catatanField_shock_absorber');
            const catatanFieldRing = document.getElementById('catatanField_ring');
            const catatanFieldTorsobelt = document.getElementById('catatanField_torso_belt');
            const catatanFieldStrap = document.getElementById('catatanField_strap');
            const catatanFieldRope = document.getElementById('catatanField_rope');
            const catatanFieldSeam_protection_tube = document.getElementById('catatanField_seam_protection_tube');
            const catatanFieldHook = document.getElementById('catatanField_hook');



            // Tambahkan event listener untuk button "Tambah Catatan Buckle"
            tambahCatatanButtonBuckle.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldBuckle.style.display === 'none') {
                    catatanFieldBuckle.style.display = 'block';
                    tambahCatatanButtonBuckle.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonBuckle.classList.remove('btn-success');
                    tambahCatatanButtonBuckle.classList.add('btn-danger');
                } else {
                    catatanFieldBuckle.style.display = 'none';
                    tambahCatatanButtonBuckle.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonBuckle.classList.remove('btn-danger');
                    tambahCatatanButtonBuckle.classList.add('btn-success');
                }
            });

            // ... Tambahkan event listener untuk tombol-tombol tambah catatan lainnya di sini ...
            tambahCatatanButtonSeams.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldSeams.style.display === 'none') {
                    catatanFieldSeams.style.display = 'block';
                    tambahCatatanButtonSeams.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonSeams.classList.remove('btn-success');
                    tambahCatatanButtonSeams.classList.add('btn-danger');
                } else {
                    catatanFieldSeams.style.display = 'none';
                    tambahCatatanButtonSeams.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonSeams.classList.remove('btn-danger');
                    tambahCatatanButtonSeams.classList.add('btn-success');
                }
            });

            tambahCatatanButtonReel.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldReel.style.display === 'none') {
                    catatanFieldReel.style.display = 'block';
                    tambahCatatanButtonReel.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonReel.classList.remove('btn-success');
                    tambahCatatanButtonReel.classList.add('btn-danger');
                } else {
                    catatanFieldReel.style.display = 'none';
                    tambahCatatanButtonReel.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonReel.classList.remove('btn-danger');
                    tambahCatatanButtonReel.classList.add('btn-success');
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

            tambahCatatanButtonRing.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldRing.style.display === 'none') {
                    catatanFieldRing.style.display = 'block';
                    tambahCatatanButtonRing.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonRing.classList.remove('btn-success');
                    tambahCatatanButtonRing.classList.add('btn-danger');
                } else {
                    catatanFieldRing.style.display = 'none';
                    tambahCatatanButtonRing.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonRing.classList.remove('btn-danger');
                    tambahCatatanButtonRing.classList.add('btn-success');
                }
            });

            tambahCatatanButtonTorsobelt.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldTorsobelt.style.display === 'none') {
                    catatanFieldTorsobelt.style.display = 'block';
                    tambahCatatanButtonTorsobelt.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonTorsobelt.classList.remove('btn-success');
                    tambahCatatanButtonTorsobelt.classList.add('btn-danger');
                } else {
                    catatanFieldTorsobelt.style.display = 'none';
                    tambahCatatanButtonTorsobelt.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonTorsobelt.classList.remove('btn-danger');
                    tambahCatatanButtonTorsobelt.classList.add('btn-success');
                }
            });

            tambahCatatanButtonStrap.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldStrap.style.display === 'none') {
                    catatanFieldStrap.style.display = 'block';
                    tambahCatatanButtonStrap.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonStrap.classList.remove('btn-success');
                    tambahCatatanButtonStrap.classList.add('btn-danger');
                } else {
                    catatanFieldStrap.style.display = 'none';
                    tambahCatatanButtonStrap.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonStrap.classList.remove('btn-danger');
                    tambahCatatanButtonStrap.classList.add('btn-success');
                }
            });

            tambahCatatanButtonRope.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldRope.style.display === 'none') {
                    catatanFieldRope.style.display = 'block';
                    tambahCatatanButtonRope.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonRope.classList.remove('btn-success');
                    tambahCatatanButtonRope.classList.add('btn-danger');
                } else {
                    catatanFieldRope.style.display = 'none';
                    tambahCatatanButtonRope.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonRope.classList.remove('btn-danger');
                    tambahCatatanButtonRope.classList.add('btn-success');
                }
            });

            tambahCatatanButtonSeam_protection_tube.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldSeam_protection_tube.style.display === 'none') {
                    catatanFieldSeam_protection_tube.style.display = 'block';
                    tambahCatatanButtonSeam_protection_tube.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonSeam_protection_tube.classList.remove('btn-success');
                    tambahCatatanButtonSeam_protection_tube.classList.add('btn-danger');
                } else {
                    catatanFieldSeam_protection_tube.style.display = 'none';
                    tambahCatatanButtonSeam_protection_tube.innerHTML =
                        '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonSeam_protection_tube.classList.remove('btn-danger');
                    tambahCatatanButtonSeam_protection_tube.classList.add('btn-success');
                }
            });

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

        });
    </script>

@endsection
