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
                <form action="{{ route('process.checksheet.safetybelt', ['safetybeltNumber' => $safetybeltNumber]) }}" method="POST"
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
                        <label for="safetybelt_number" class="form-label">Nomor Safety Belt</label>
                        <input type="text" class="form-control" id="safetybelt_number" value="{{ $safetybeltNumber }}"
                            name="safetybelt_number" required autofocus readonly>
                    </div>
            </div>
            <div class="col-md-6">


                <div class="mb-3">
                    <label for="buckle" class="form-label">Buckle</label>
                    <div class="input-group">
                        <select class="form-select" id="buckle" name="buckle" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('buckle') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('buckle') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_buckle"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_buckle" style="display:none;">
                    <label for="catatan_buckle" class="form-label">Catatan Buckle</label>
                    <textarea class="form-control" name="catatan_buckle" id="catatan_buckle" cols="30" rows="5">{{ old('catatan_buckle') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_buckle" class="form-label">Foto Buckle</label>
                    <img class="photo-buckle-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_buckle" name="photo_buckle" required
                        onchange="previewImage('photo_buckle', 'photo-buckle-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="seams" class="form-label">Seams</label>
                    <div class="input-group">
                        <select class="form-select" id="seams" name="seams" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('seams') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('seams') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_seams"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_seams" style="display:none;">
                    <label for="catatan_seams" class="form-label">Catatan Seams</label>
                    <textarea class="form-control" name="catatan_seams" id="catatan_seams" cols="30" rows="5">{{ old('catatan_seams') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_seams" class="form-label">Foto Seams</label>
                    <img class="photo-seams-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_seams" name="photo_seams" required
                        onchange="previewImage('photo_seams', 'photo-seams-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="reel" class="form-label">Reel</label>
                    <div class="input-group">
                        <select class="form-select" id="reel" name="reel" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('reel') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('reel') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_reel"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_reel" style="display:none;">
                    <label for="catatan_reel" class="form-label">Catatan Reel</label>
                    <textarea class="form-control" name="catatan_reel" id="catatan_reel" cols="30" rows="5">{{ old('catatan_reel') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_reel" class="form-label">Foto Reel</label>
                    <img class="photo-reel-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_reel" name="photo_reel" required
                        onchange="previewImage('photo_reel', 'photo-reel-preview')">
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

                <hr>

                <div class="mb-3">
                    <label for="ring" class="form-label">Ring</label>
                    <div class="input-group">
                        <select class="form-select" id="ring" name="ring" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('ring') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('ring') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_ring"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_ring" style="display:none;">
                    <label for="catatan_ring" class="form-label">Catatan Ring</label>
                    <textarea class="form-control" name="catatan_ring" id="catatan_ring" cols="30" rows="5">{{ old('catatan_ring') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_ring" class="form-label">Foto Ring</label>
                    <img class="photo-ring-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_ring" name="photo_ring" required
                        onchange="previewImage('photo_ring', 'photo-ring-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="torso_belt" class="form-label">Torso Belt</label>
                    <div class="input-group">
                        <select class="form-select" id="torso_belt" name="torso_belt" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('torso_belt') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('torso_belt') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_torso_belt"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_torso_belt" style="display:none;">
                    <label for="catatan_torso_belt" class="form-label">Catatan Torso Belt</label>
                    <textarea class="form-control" name="catatan_torso_belt" id="catatan_torso_belt" cols="30" rows="5">{{ old('catatan_torso_belt') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_torso_belt" class="form-label">Foto Torso Belt</label>
                    <img class="photo-torso_belt-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_torso_belt" name="photo_torso_belt" required
                        onchange="previewImage('photo_torso_belt', 'photo-torso_belt-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="strap" class="form-label">Strap</label>
                    <div class="input-group">
                        <select class="form-select" id="strap" name="strap" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('strap') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('strap') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_strap"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_strap" style="display:none;">
                    <label for="catatan_strap" class="form-label">Catatan Strap</label>
                    <textarea class="form-control" name="catatan_strap" id="catatan_strap" cols="30" rows="5">{{ old('catatan_strap') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_strap" class="form-label">Foto Strap</label>
                    <img class="photo-strap-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_strap" name="photo_strap" required
                        onchange="previewImage('photo_strap', 'photo-strap-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="rope" class="form-label">Rope</label>
                    <div class="input-group">
                        <select class="form-select" id="rope" name="rope" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('rope') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('rope') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_rope"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_rope" style="display:none;">
                    <label for="catatan_rope" class="form-label">Catatan Rope</label>
                    <textarea class="form-control" name="catatan_rope" id="catatan_rope" cols="30" rows="5">{{ old('catatan_rope') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_rope" class="form-label">Foto Rope</label>
                    <img class="photo-rope-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_rope" name="photo_rope" required
                        onchange="previewImage('photo_rope', 'photo-rope-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="seam_protection_tube" class="form-label">Seam Protection Tube</label>
                    <div class="input-group">
                        <select class="form-select" id="seam_protection_tube" name="seam_protection_tube" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('seam_protection_tube') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('seam_protection_tube') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_seam_protection_tube"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_seam_protection_tube" style="display:none;">
                    <label for="catatan_seam_protection_tube" class="form-label">Catatan Seam Protection Tube</label>
                    <textarea class="form-control" name="catatan_seam_protection_tube" id="catatan_seam_protection_tube" cols="30" rows="5">{{ old('catatan_seam_protection_tube') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_seam_protection_tube" class="form-label">Foto Seam Protection Tube</label>
                    <img class="photo-seam_protection_tube-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_seam_protection_tube" name="photo_seam_protection_tube" required
                        onchange="previewImage('photo_seam_protection_tube', 'photo-seam_protection_tube-preview')">
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
            const tambahCatatanButtonBuckle = document.getElementById('tambahCatatan_buckle');
            const tambahCatatanButtonSeams = document.getElementById('tambahCatatan_seams');
            const tambahCatatanButtonReel = document.getElementById('tambahCatatan_reel');
            const tambahCatatanButtonShock_absorber = document.getElementById('tambahCatatan_shock_absorber');
            const tambahCatatanButtonRing = document.getElementById('tambahCatatan_ring');
            const tambahCatatanButtonTorsobelt = document.getElementById('tambahCatatan_torso_belt');
            const tambahCatatanButtonStrap = document.getElementById('tambahCatatan_strap');
            const tambahCatatanButtonRope = document.getElementById('tambahCatatan_rope');
            const tambahCatatanButtonSeam_protection_tube = document.getElementById('tambahCatatan_seam_protection_tube');
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
                    tambahCatatanButtonSeam_protection_tube.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
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
