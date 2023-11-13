@extends('dashboard.app')
@section('title', 'Check Sheet Sling Belt')

@section('content')

    <div class="container">
        <h1>Check Sheet Sling Belt</h1>
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
                <form action="{{ route('process.checksheet.belt', ['slingNumber' => $slingNumber]) }}" method="POST"
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
                        <label for="sling_number" class="form-label">Nomor Sling</label>
                        <input type="text" class="form-control" id="sling_number" value="{{ $slingNumber }}"
                            name="sling_number" required autofocus readonly>
                    </div>
            </div>
            <div class="col-md-6">


                <div class="mb-3">
                    <label for="kelengkapan_tag_sling_belt" class="form-label">Tag Sling Belt</label>
                    <div class="input-group">
                        <select class="form-select" id="kelengkapan_tag_sling_belt" name="kelengkapan_tag_sling_belt" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('kelengkapan_tag_sling_belt') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('kelengkapan_tag_sling_belt') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_kelengkapan_tag_sling_belt"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_kelengkapan_tag_sling_belt" style="display:none;">
                    <label for="catatan_kelengkapan_tag_sling_belt" class="form-label">Catatan Tag Sling Belt</label>
                    <textarea class="form-control" name="catatan_kelengkapan_tag_sling_belt" id="catatan_kelengkapan_tag_sling_belt" cols="30" rows="5">{{ old('catatan_kelengkapan_tag_sling_belt') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_kelengkapan_tag_sling_belt" class="form-label">Foto Tag Sling Belt</label>
                    <img class="photo-kelengkapan_tag_sling_belt-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_kelengkapan_tag_sling_belt" name="photo_kelengkapan_tag_sling_belt" required
                        onchange="previewImage('photo_kelengkapan_tag_sling_belt', 'photo-kelengkapan_tag_sling_belt-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="bagian_pinggir_belt_robek" class="form-label">Belt Robek</label>
                    <div class="input-group">
                        <select class="form-select" id="bagian_pinggir_belt_robek" name="bagian_pinggir_belt_robek" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('bagian_pinggir_belt_robek') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('bagian_pinggir_belt_robek') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_bagian_pinggir_belt_robek"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_bagian_pinggir_belt_robek" style="display:none;">
                    <label for="catatan_bagian_pinggir_belt_robek" class="form-label">Catatan Belt Robek</label>
                    <textarea class="form-control" name="catatan_bagian_pinggir_belt_robek" id="catatan_bagian_pinggir_belt_robek" cols="30" rows="5">{{ old('catatan_bagian_pinggir_belt_robek') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_bagian_pinggir_belt_robek" class="form-label">Foto Belt Robek</label>
                    <img class="photo-bagian_pinggir_belt_robek-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_bagian_pinggir_belt_robek" name="photo_bagian_pinggir_belt_robek" required
                        onchange="previewImage('photo_bagian_pinggir_belt_robek', 'photo-bagian_pinggir_belt_robek-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="pengecekan_lapisan_belt_1" class="form-label">Belt Kusut</label>
                    <div class="input-group">
                        <select class="form-select" id="pengecekan_lapisan_belt_1" name="pengecekan_lapisan_belt_1" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('pengecekan_lapisan_belt_1') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('pengecekan_lapisan_belt_1') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_pengecekan_lapisan_belt_1"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_pengecekan_lapisan_belt_1" style="display:none;">
                    <label for="catatan_pengecekan_lapisan_belt_1" class="form-label">Catatan Belt Kusut</label>
                    <textarea class="form-control" name="catatan_pengecekan_lapisan_belt_1" id="catatan_pengecekan_lapisan_belt_1" cols="30" rows="5">{{ old('catatan_pengecekan_lapisan_belt_1') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_pengecekan_lapisan_belt_1" class="form-label">Foto Belt Kusut</label>
                    <img class="photo-pengecekan_lapisan_belt_1-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_pengecekan_lapisan_belt_1" name="photo_pengecekan_lapisan_belt_1" required
                        onchange="previewImage('photo_pengecekan_lapisan_belt_1', 'photo-pengecekan_lapisan_belt_1-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="pengecekan_jahitan_belt" class="form-label">Jahitan Belt</label>
                    <div class="input-group">
                        <select class="form-select" id="pengecekan_jahitan_belt" name="pengecekan_jahitan_belt" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('pengecekan_jahitan_belt') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('pengecekan_jahitan_belt') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_pengecekan_jahitan_belt"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_pengecekan_jahitan_belt" style="display:none;">
                    <label for="catatan_pengecekan_jahitan_belt" class="form-label">Catatan Jahitan Belt</label>
                    <textarea class="form-control" name="catatan_pengecekan_jahitan_belt" id="catatan_pengecekan_jahitan_belt" cols="30" rows="5">{{ old('catatan_pengecekan_jahitan_belt') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_pengecekan_jahitan_belt" class="form-label">Foto Jahitan Belt</label>
                    <img class="photo-pengecekan_jahitan_belt-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_pengecekan_jahitan_belt" name="photo_pengecekan_jahitan_belt" required
                        onchange="previewImage('photo_pengecekan_jahitan_belt', 'photo-pengecekan_jahitan_belt-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="pengecekan_permukaan_belt" class="form-label">Belt Menipis</label>
                    <div class="input-group">
                        <select class="form-select" id="pengecekan_permukaan_belt" name="pengecekan_permukaan_belt" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('pengecekan_permukaan_belt') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('pengecekan_permukaan_belt') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_pengecekan_permukaan_belt"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_pengecekan_permukaan_belt" style="display:none;">
                    <label for="catatan_pengecekan_permukaan_belt" class="form-label">Catatan Belt Menipis</label>
                    <textarea class="form-control" name="catatan_pengecekan_permukaan_belt" id="catatan_pengecekan_permukaan_belt" cols="30" rows="5">{{ old('catatan_pengecekan_permukaan_belt') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_pengecekan_permukaan_belt" class="form-label">Foto Belt Menipis</label>
                    <img class="photo-pengecekan_permukaan_belt-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_pengecekan_permukaan_belt" name="photo_pengecekan_permukaan_belt" required
                        onchange="previewImage('photo_pengecekan_permukaan_belt', 'photo-pengecekan_permukaan_belt-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="pengecekan_lapisan_belt_2" class="form-label">Belt Scratch</label>
                    <div class="input-group">
                        <select class="form-select" id="pengecekan_lapisan_belt_2" name="pengecekan_lapisan_belt_2" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('pengecekan_lapisan_belt_2') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('pengecekan_lapisan_belt_2') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_pengecekan_lapisan_belt_2"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_pengecekan_lapisan_belt_2" style="display:none;">
                    <label for="catatan_pengecekan_lapisan_belt_2" class="form-label">Catatan Belt Scratch</label>
                    <textarea class="form-control" name="catatan_pengecekan_lapisan_belt_2" id="catatan_pengecekan_lapisan_belt_2" cols="30" rows="5">{{ old('catatan_pengecekan_lapisan_belt_2') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_pengecekan_lapisan_belt_2" class="form-label">Foto Belt Scratch</label>
                    <img class="photo-pengecekan_lapisan_belt_2-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_pengecekan_lapisan_belt_2" name="photo_pengecekan_lapisan_belt_2" required
                        onchange="previewImage('photo_pengecekan_lapisan_belt_2', 'photo-pengecekan_lapisan_belt_2-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="pengecekan_aus" class="form-label">Belt Aus</label>
                    <div class="input-group">
                        <select class="form-select" id="pengecekan_aus" name="pengecekan_aus" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('pengecekan_aus') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('pengecekan_aus') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_pengecekan_aus"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_pengecekan_aus" style="display:none;">
                    <label for="catatan_pengecekan_aus" class="form-label">Catatan Belt Aus</label>
                    <textarea class="form-control" name="catatan_pengecekan_aus" id="catatan_pengecekan_aus" cols="30" rows="5">{{ old('catatan_pengecekan_aus') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_pengecekan_aus" class="form-label">Foto Belt Aus</label>
                    <img class="photo-pengecekan_aus-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_pengecekan_aus" name="photo_pengecekan_aus" required
                        onchange="previewImage('photo_pengecekan_aus', 'photo-pengecekan_aus-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="hook_wire" class="form-label">Hook Wire</label>
                    <div class="input-group">
                        <select class="form-select" id="hook_wire" name="hook_wire" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('hook_wire') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('hook_wire') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_hook_wire"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_hook_wire" style="display:none;">
                    <label for="catatan_hook_wire" class="form-label">Catatan Hook Wire</label>
                    <textarea class="form-control" name="catatan_hook_wire" id="catatan_hook_wire" cols="30" rows="5">{{ old('catatan_hook_wire') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_hook_wire" class="form-label">Foto Hook Wire</label>
                    <img class="photo-hook_wire-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_hook_wire" name="photo_hook_wire" required
                        onchange="previewImage('photo_hook_wire', 'photo-hook_wire-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="pengunci_hook" class="form-label">Pengunci Hook</label>
                    <div class="input-group">
                        <select class="form-select" id="pengunci_hook" name="pengunci_hook" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('pengunci_hook') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('pengunci_hook') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_pengunci_hook"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_pengunci_hook" style="display:none;">
                    <label for="catatan_pengunci_hook" class="form-label">Catatan Pengunci Hook</label>
                    <textarea class="form-control" name="catatan_pengunci_hook" id="catatan_pengunci_hook" cols="30" rows="5">{{ old('catatan_pengunci_hook') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_pengunci_hook" class="form-label">Foto Pengunci Hook</label>
                    <img class="photo-pengunci_hook-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_pengunci_hook" name="photo_pengunci_hook" required
                        onchange="previewImage('photo_pengunci_hook', 'photo-pengunci_hook-preview')">
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
            const tambahCatatanButtonKelengkapan_tag_sling_belt = document.getElementById('tambahCatatan_kelengkapan_tag_sling_belt');
            const tambahCatatanButtonBagian_pinggir_belt_robek = document.getElementById('tambahCatatan_bagian_pinggir_belt_robek');
            const tambahCatatanButtonPengecekan_lapisan_belt_1 = document.getElementById('tambahCatatan_pengecekan_lapisan_belt_1');
            const tambahCatatanButtonPengecekan_jahitan_belt = document.getElementById('tambahCatatan_pengecekan_jahitan_belt');
            const tambahCatatanButtonPengecekan_permukaan_belt = document.getElementById('tambahCatatan_pengecekan_permukaan_belt');
            const tambahCatatanButtonPengecekan_lapisan_belt_2 = document.getElementById('tambahCatatan_pengecekan_lapisan_belt_2');
            const tambahCatatanButtonPengecekan_aus = document.getElementById('tambahCatatan_pengecekan_aus');
            const tambahCatatanButtonHook_wire = document.getElementById('tambahCatatan_hook_wire');
            const tambahCatatanButtonPengunci_hook = document.getElementById('tambahCatatan_pengunci_hook');




            const catatanFieldKelengkapan_tag_sling_belt = document.getElementById('catatanField_kelengkapan_tag_sling_belt');
            const catatanFieldBagian_pinggir_belt_robek = document.getElementById('catatanField_bagian_pinggir_belt_robek');
            const catatanFieldPengecekan_lapisan_belt_1 = document.getElementById('catatanField_pengecekan_lapisan_belt_1');
            const catatanFieldPengecekan_jahitan_belt = document.getElementById('catatanField_pengecekan_jahitan_belt');
            const catatanFieldPengecekan_permukaan_belt = document.getElementById('catatanField_pengecekan_permukaan_belt');
            const catatanFieldPengecekan_lapisan_belt_2 = document.getElementById('catatanField_pengecekan_lapisan_belt_2');
            const catatanFieldPengecekan_aus = document.getElementById('catatanField_pengecekan_aus');
            const catatanFieldHook_wire = document.getElementById('catatanField_hook_wire');
            const catatanFieldPengunci_hook = document.getElementById('catatanField_pengunci_hook');





            // Tambahkan event listener untuk button "Tambah Catatan Kelengkapan_tag_sling_belt"
            tambahCatatanButtonKelengkapan_tag_sling_belt.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldKelengkapan_tag_sling_belt.style.display === 'none') {
                    catatanFieldKelengkapan_tag_sling_belt.style.display = 'block';
                    tambahCatatanButtonKelengkapan_tag_sling_belt.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonKelengkapan_tag_sling_belt.classList.remove('btn-success');
                    tambahCatatanButtonKelengkapan_tag_sling_belt.classList.add('btn-danger');
                } else {
                    catatanFieldKelengkapan_tag_sling_belt.style.display = 'none';
                    tambahCatatanButtonKelengkapan_tag_sling_belt.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonKelengkapan_tag_sling_belt.classList.remove('btn-danger');
                    tambahCatatanButtonKelengkapan_tag_sling_belt.classList.add('btn-success');
                }
            });

            // ... Tambahkan event listener untuk tombol-tombol tambah catatan lainnya di sini ...
            tambahCatatanButtonBagian_pinggir_belt_robek.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldBagian_pinggir_belt_robek.style.display === 'none') {
                    catatanFieldBagian_pinggir_belt_robek.style.display = 'block';
                    tambahCatatanButtonBagian_pinggir_belt_robek.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonBagian_pinggir_belt_robek.classList.remove('btn-success');
                    tambahCatatanButtonBagian_pinggir_belt_robek.classList.add('btn-danger');
                } else {
                    catatanFieldBagian_pinggir_belt_robek.style.display = 'none';
                    tambahCatatanButtonBagian_pinggir_belt_robek.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonBagian_pinggir_belt_robek.classList.remove('btn-danger');
                    tambahCatatanButtonBagian_pinggir_belt_robek.classList.add('btn-success');
                }
            });

            tambahCatatanButtonPengecekan_lapisan_belt_1.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldPengecekan_lapisan_belt_1.style.display === 'none') {
                    catatanFieldPengecekan_lapisan_belt_1.style.display = 'block';
                    tambahCatatanButtonPengecekan_lapisan_belt_1.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonPengecekan_lapisan_belt_1.classList.remove('btn-success');
                    tambahCatatanButtonPengecekan_lapisan_belt_1.classList.add('btn-danger');
                } else {
                    catatanFieldPengecekan_lapisan_belt_1.style.display = 'none';
                    tambahCatatanButtonPengecekan_lapisan_belt_1.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonPengecekan_lapisan_belt_1.classList.remove('btn-danger');
                    tambahCatatanButtonPengecekan_lapisan_belt_1.classList.add('btn-success');
                }
            });

            tambahCatatanButtonPengecekan_jahitan_belt.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldPengecekan_jahitan_belt.style.display === 'none') {
                    catatanFieldPengecekan_jahitan_belt.style.display = 'block';
                    tambahCatatanButtonPengecekan_jahitan_belt.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonPengecekan_jahitan_belt.classList.remove('btn-success');
                    tambahCatatanButtonPengecekan_jahitan_belt.classList.add('btn-danger');
                } else {
                    catatanFieldPengecekan_jahitan_belt.style.display = 'none';
                    tambahCatatanButtonPengecekan_jahitan_belt.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonPengecekan_jahitan_belt.classList.remove('btn-danger');
                    tambahCatatanButtonPengecekan_jahitan_belt.classList.add('btn-success');
                }
            });

            tambahCatatanButtonPengecekan_permukaan_belt.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldPengecekan_permukaan_belt.style.display === 'none') {
                    catatanFieldPengecekan_permukaan_belt.style.display = 'block';
                    tambahCatatanButtonPengecekan_permukaan_belt.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonPengecekan_permukaan_belt.classList.remove('btn-success');
                    tambahCatatanButtonPengecekan_permukaan_belt.classList.add('btn-danger');
                } else {
                    catatanFieldPengecekan_permukaan_belt.style.display = 'none';
                    tambahCatatanButtonPengecekan_permukaan_belt.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonPengecekan_permukaan_belt.classList.remove('btn-danger');
                    tambahCatatanButtonPengecekan_permukaan_belt.classList.add('btn-success');
                }
            });

            tambahCatatanButtonPengecekan_lapisan_belt_2.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldPengecekan_lapisan_belt_2.style.display === 'none') {
                    catatanFieldPengecekan_lapisan_belt_2.style.display = 'block';
                    tambahCatatanButtonPengecekan_lapisan_belt_2.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonPengecekan_lapisan_belt_2.classList.remove('btn-success');
                    tambahCatatanButtonPengecekan_lapisan_belt_2.classList.add('btn-danger');
                } else {
                    catatanFieldPengecekan_lapisan_belt_2.style.display = 'none';
                    tambahCatatanButtonPengecekan_lapisan_belt_2.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonPengecekan_lapisan_belt_2.classList.remove('btn-danger');
                    tambahCatatanButtonPengecekan_lapisan_belt_2.classList.add('btn-success');
                }
            });

            tambahCatatanButtonPengecekan_aus.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldPengecekan_aus.style.display === 'none') {
                    catatanFieldPengecekan_aus.style.display = 'block';
                    tambahCatatanButtonPengecekan_aus.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonPengecekan_aus.classList.remove('btn-success');
                    tambahCatatanButtonPengecekan_aus.classList.add('btn-danger');
                } else {
                    catatanFieldPengecekan_aus.style.display = 'none';
                    tambahCatatanButtonPengecekan_aus.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonPengecekan_aus.classList.remove('btn-danger');
                    tambahCatatanButtonPengecekan_aus.classList.add('btn-success');
                }
            });

            tambahCatatanButtonHook_wire.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldHook_wire.style.display === 'none') {
                    catatanFieldHook_wire.style.display = 'block';
                    tambahCatatanButtonHook_wire.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonHook_wire.classList.remove('btn-success');
                    tambahCatatanButtonHook_wire.classList.add('btn-danger');
                } else {
                    catatanFieldHook_wire.style.display = 'none';
                    tambahCatatanButtonHook_wire.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonHook_wire.classList.remove('btn-danger');
                    tambahCatatanButtonHook_wire.classList.add('btn-success');
                }
            });

            tambahCatatanButtonPengunci_hook.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldPengunci_hook.style.display === 'none') {
                    catatanFieldPengunci_hook.style.display = 'block';
                    tambahCatatanButtonPengunci_hook.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonPengunci_hook.classList.remove('btn-success');
                    tambahCatatanButtonPengunci_hook.classList.add('btn-danger');
                } else {
                    catatanFieldPengunci_hook.style.display = 'none';
                    tambahCatatanButtonPengunci_hook.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonPengunci_hook.classList.remove('btn-danger');
                    tambahCatatanButtonPengunci_hook.classList.add('btn-success');
                }
            });
        });
    </script>



@endsection
