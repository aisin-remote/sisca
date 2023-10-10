@extends('dashboard.app')
@section('title', 'Check Sheet Tembin')

@section('content')

    <div class="container">
        <h1>Check Sheet Tembin</h1>
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
                <form action="{{ route('process.checksheet.tembin', ['tembinNumber' => $tembinNumber]) }}" method="POST"
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
                        <label for="tembin_number" class="form-label">Nomor Equip</label>
                        <input type="text" class="form-control" id="tembin_number" value="{{ $tembinNumber }}"
                            name="tembin_number" required autofocus readonly>
                    </div>
            </div>
            <div class="col-md-6">


                <div class="mb-3">
                    <label for="master_link" class="form-label">Master Link</label>
                    <div class="input-group">
                        <select class="form-select" id="master_link" name="master_link" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('master_link') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('master_link') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_master_link"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_master_link" style="display:none;">
                    <label for="catatan_master_link" class="form-label">Catatan Master Link</label>
                    <textarea class="form-control" name="catatan_master_link" id="catatan_master_link" cols="30" rows="5">{{ old('catatan_master_link') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_master_link" class="form-label">Foto Master Link</label>
                    <img class="photo-master_link-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_master_link" name="photo_master_link" required
                        onchange="previewImage('photo_master_link', 'photo-master_link-preview')">
                </div>


                <div class="mb-3">
                    <label for="body_tembin" class="form-label">Body  Tembin</label>
                    <div class="input-group">
                        <select class="form-select" id="body_tembin" name="body_tembin" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('body_tembin') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('body_tembin') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_body_tembin"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_body_tembin" style="display:none;">
                    <label for="catatan_body_tembin" class="form-label">Catatan Body  Tembin</label>
                    <textarea class="form-control" name="catatan_body_tembin" id="catatan_body_tembin" cols="30" rows="5">{{ old('catatan_body_tembin') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_body_tembin" class="form-label">Foto Body  Tembin</label>
                    <img class="photo-body_tembin-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_body_tembin" name="photo_body_tembin" required
                        onchange="previewImage('photo_body_tembin', 'photo-body_tembin-preview')">
                </div>


                <div class="mb-3">
                    <label for="mur_baut" class="form-label">Mur & Baut</label>
                    <div class="input-group">
                        <select class="form-select" id="mur_baut" name="mur_baut" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('mur_baut') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('mur_baut') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_mur_baut"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_mur_baut" style="display:none;">
                    <label for="catatan_mur_baut" class="form-label">Catatan Mur & Baut</label>
                    <textarea class="form-control" name="catatan_mur_baut" id="catatan_mur_baut" cols="30" rows="5">{{ old('catatan_mur_baut') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_mur_baut" class="form-label">Foto Mur & Baut</label>
                    <img class="photo-mur_baut-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_mur_baut" name="photo_mur_baut" required
                        onchange="previewImage('photo_mur_baut', 'photo-mur_baut-preview')">
                </div>


                <div class="mb-3">
                    <label for="shackle" class="form-label">Shackle</label>
                    <div class="input-group">
                        <select class="form-select" id="shackle" name="shackle" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('shackle') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('shackle') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_shackle"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_shackle" style="display:none;">
                    <label for="catatan_shackle" class="form-label">Catatan Shackle</label>
                    <textarea class="form-control" name="catatan_shackle" id="catatan_shackle" cols="30" rows="5">{{ old('catatan_shackle') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_shackle" class="form-label">Foto Shackle</label>
                    <img class="photo-shackle-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_shackle" name="photo_shackle" required
                        onchange="previewImage('photo_shackle', 'photo-shackle-preview')">
                </div>


                <div class="mb-3">
                    <label for="hook_atas" class="form-label">Hook Atas</label>
                    <div class="input-group">
                        <select class="form-select" id="hook_atas" name="hook_atas" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('hook_atas') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('hook_atas') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_hook_atas"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_hook_atas" style="display:none;">
                    <label for="catatan_hook_atas" class="form-label">Catatan Hook Atas</label>
                    <textarea class="form-control" name="catatan_hook_atas" id="catatan_hook_atas" cols="30" rows="5">{{ old('catatan_hook_atas') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_hook_atas" class="form-label">Foto Hook Atas</label>
                    <img class="photo-hook_atas-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_hook_atas" name="photo_hook_atas" required
                        onchange="previewImage('photo_hook_atas', 'photo-hook_atas-preview')">
                </div>


                <div class="mb-3">
                    <label for="pengunci_hook_atas" class="form-label">Pengunci Hook Atas</label>
                    <div class="input-group">
                        <select class="form-select" id="pengunci_hook_atas" name="pengunci_hook_atas" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('pengunci_hook_atas') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('pengunci_hook_atas') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_pengunci_hook_atas"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_pengunci_hook_atas" style="display:none;">
                    <label for="catatan_pengunci_hook_atas" class="form-label">Catatan Pengunci Hook Atas</label>
                    <textarea class="form-control" name="catatan_pengunci_hook_atas" id="catatan_pengunci_hook_atas" cols="30" rows="5">{{ old('catatan_pengunci_hook_atas') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_pengunci_hook_atas" class="form-label">Foto Pengunci Hook Atas</label>
                    <img class="photo-pengunci_hook_atas-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_pengunci_hook_atas" name="photo_pengunci_hook_atas" required
                        onchange="previewImage('photo_pengunci_hook_atas', 'photo-pengunci_hook_atas-preview')">
                </div>


                <div class="mb-3">
                    <label for="mata_chain" class="form-label">Mata Chain</label>
                    <div class="input-group">
                        <select class="form-select" id="mata_chain" name="mata_chain" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('mata_chain') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('mata_chain') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_mata_chain"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_mata_chain" style="display:none;">
                    <label for="catatan_mata_chain" class="form-label">Catatan Mata Chain</label>
                    <textarea class="form-control" name="catatan_mata_chain" id="catatan_mata_chain" cols="30" rows="5">{{ old('catatan_mata_chain') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_mata_chain" class="form-label">Foto Mata Chain</label>
                    <img class="photo-mata_chain-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_mata_chain" name="photo_mata_chain" required
                        onchange="previewImage('photo_mata_chain', 'photo-mata_chain-preview')">
                </div>


                <div class="mb-3">
                    <label for="hook_bawah" class="form-label">Hook Bawah</label>
                    <div class="input-group">
                        <select class="form-select" id="hook_bawah" name="hook_bawah" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('hook_bawah') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('hook_bawah') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_hook_bawah"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_hook_bawah" style="display:none;">
                    <label for="catatan_hook_bawah" class="form-label">Catatan Hook Bawah</label>
                    <textarea class="form-control" name="catatan_hook_bawah" id="catatan_hook_bawah" cols="30" rows="5">{{ old('catatan_hook_bawah') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_hook_bawah" class="form-label">Foto Hook Bawah</label>
                    <img class="photo-hook_bawah-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_hook_bawah" name="photo_hook_bawah" required
                        onchange="previewImage('photo_hook_bawah', 'photo-hook_bawah-preview')">
                </div>


                <div class="mb-3">
                    <label for="pengunci_hook_bawah" class="form-label">Pengunci Hook Bawah</label>
                    <div class="input-group">
                        <select class="form-select" id="pengunci_hook_bawah" name="pengunci_hook_bawah" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('pengunci_hook_bawah') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('pengunci_hook_bawah') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_pengunci_hook_bawah"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_pengunci_hook_bawah" style="display:none;">
                    <label for="catatan_pengunci_hook_bawah" class="form-label">Catatan Pengunci Hook Bawah</label>
                    <textarea class="form-control" name="catatan_pengunci_hook_bawah" id="catatan_pengunci_hook_bawah" cols="30" rows="5">{{ old('catatan_pengunci_hook_bawah') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_pengunci_hook_bawah" class="form-label">Foto Pengunci Hook Bawah</label>
                    <img class="photo-pengunci_hook_bawah-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_pengunci_hook_bawah" name="photo_pengunci_hook_bawah" required
                        onchange="previewImage('photo_pengunci_hook_bawah', 'photo-pengunci_hook_bawah-preview')">
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
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil elemen-elemen yang dibutuhkan
            const tambahCatatanButtonMaster_link = document.getElementById('tambahCatatan_master_link');
            const tambahCatatanButtonBody_tembin = document.getElementById('tambahCatatan_body_tembin');
            const tambahCatatanButtonMur_baut = document.getElementById('tambahCatatan_mur_baut');
            const tambahCatatanButtonShackle = document.getElementById('tambahCatatan_shackle');
            const tambahCatatanButtonHook_atas = document.getElementById('tambahCatatan_hook_atas');
            const tambahCatatanButtonPengunci_hook_atas = document.getElementById('tambahCatatan_pengunci_hook_atas');
            const tambahCatatanButtonMata_chain = document.getElementById('tambahCatatan_mata_chain');
            const tambahCatatanButtonHook_bawah = document.getElementById('tambahCatatan_hook_bawah');
            const tambahCatatanButtonPengunci_hook_bawah = document.getElementById('tambahCatatan_pengunci_hook_bawah');



            const catatanFieldMaster_link = document.getElementById('catatanField_master_link');
            const catatanFieldBody_tembin = document.getElementById('catatanField_body_tembin');
            const catatanFieldMur_baut = document.getElementById('catatanField_mur_baut');
            const catatanFieldShackle = document.getElementById('catatanField_shackle');
            const catatanFieldHook_atas = document.getElementById('catatanField_hook_atas');
            const catatanFieldPengunci_hook_atas = document.getElementById('catatanField_pengunci_hook_atas');
            const catatanFieldMata_chain = document.getElementById('catatanField_mata_chain');
            const catatanFieldHook_bawah = document.getElementById('catatanField_hook_bawah');
            const catatanFieldPengunci_hook_bawah = document.getElementById('catatanField_pengunci_hook_bawah');



            // Tambahkan event listener untuk button "Tambah Catatan Master_link"
            tambahCatatanButtonMaster_link.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldMaster_link.style.display === 'none') {
                    catatanFieldMaster_link.style.display = 'block';
                    tambahCatatanButtonMaster_link.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonMaster_link.classList.remove('btn-success');
                    tambahCatatanButtonMaster_link.classList.add('btn-danger');
                } else {
                    catatanFieldMaster_link.style.display = 'none';
                    tambahCatatanButtonMaster_link.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonMaster_link.classList.remove('btn-danger');
                    tambahCatatanButtonMaster_link.classList.add('btn-success');
                }
            });

            // ... Tambahkan event listener untuk tombol-tombol tambah catatan lainnya di sini ...
            tambahCatatanButtonBody_tembin.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldBody_tembin.style.display === 'none') {
                    catatanFieldBody_tembin.style.display = 'block';
                    tambahCatatanButtonBody_tembin.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonBody_tembin.classList.remove('btn-success');
                    tambahCatatanButtonBody_tembin.classList.add('btn-danger');
                } else {
                    catatanFieldBody_tembin.style.display = 'none';
                    tambahCatatanButtonBody_tembin.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonBody_tembin.classList.remove('btn-danger');
                    tambahCatatanButtonBody_tembin.classList.add('btn-success');
                }
            });

            tambahCatatanButtonMur_baut.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldMur_baut.style.display === 'none') {
                    catatanFieldMur_baut.style.display = 'block';
                    tambahCatatanButtonMur_baut.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonMur_baut.classList.remove('btn-success');
                    tambahCatatanButtonMur_baut.classList.add('btn-danger');
                } else {
                    catatanFieldMur_baut.style.display = 'none';
                    tambahCatatanButtonMur_baut.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonMur_baut.classList.remove('btn-danger');
                    tambahCatatanButtonMur_baut.classList.add('btn-success');
                }
            });

            tambahCatatanButtonShackle.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldShackle.style.display === 'none') {
                    catatanFieldShackle.style.display = 'block';
                    tambahCatatanButtonShackle.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonShackle.classList.remove('btn-success');
                    tambahCatatanButtonShackle.classList.add('btn-danger');
                } else {
                    catatanFieldShackle.style.display = 'none';
                    tambahCatatanButtonShackle.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonShackle.classList.remove('btn-danger');
                    tambahCatatanButtonShackle.classList.add('btn-success');
                }
            });

            tambahCatatanButtonHook_atas.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldHook_atas.style.display === 'none') {
                    catatanFieldHook_atas.style.display = 'block';
                    tambahCatatanButtonHook_atas.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonHook_atas.classList.remove('btn-success');
                    tambahCatatanButtonHook_atas.classList.add('btn-danger');
                } else {
                    catatanFieldHook_atas.style.display = 'none';
                    tambahCatatanButtonHook_atas.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonHook_atas.classList.remove('btn-danger');
                    tambahCatatanButtonHook_atas.classList.add('btn-success');
                }
            });

            tambahCatatanButtonPengunci_hook_atas.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldPengunci_hook_atas.style.display === 'none') {
                    catatanFieldPengunci_hook_atas.style.display = 'block';
                    tambahCatatanButtonPengunci_hook_atas.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonPengunci_hook_atas.classList.remove('btn-success');
                    tambahCatatanButtonPengunci_hook_atas.classList.add('btn-danger');
                } else {
                    catatanFieldPengunci_hook_atas.style.display = 'none';
                    tambahCatatanButtonPengunci_hook_atas.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonPengunci_hook_atas.classList.remove('btn-danger');
                    tambahCatatanButtonPengunci_hook_atas.classList.add('btn-success');
                }
            });

            tambahCatatanButtonMata_chain.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldMata_chain.style.display === 'none') {
                    catatanFieldMata_chain.style.display = 'block';
                    tambahCatatanButtonMata_chain.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonMata_chain.classList.remove('btn-success');
                    tambahCatatanButtonMata_chain.classList.add('btn-danger');
                } else {
                    catatanFieldMata_chain.style.display = 'none';
                    tambahCatatanButtonMata_chain.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonMata_chain.classList.remove('btn-danger');
                    tambahCatatanButtonMata_chain.classList.add('btn-success');
                }
            });

            tambahCatatanButtonHook_bawah.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldHook_bawah.style.display === 'none') {
                    catatanFieldHook_bawah.style.display = 'block';
                    tambahCatatanButtonHook_bawah.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonHook_bawah.classList.remove('btn-success');
                    tambahCatatanButtonHook_bawah.classList.add('btn-danger');
                } else {
                    catatanFieldHook_bawah.style.display = 'none';
                    tambahCatatanButtonHook_bawah.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonHook_bawah.classList.remove('btn-danger');
                    tambahCatatanButtonHook_bawah.classList.add('btn-success');
                }
            });

            tambahCatatanButtonPengunci_hook_bawah.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldPengunci_hook_bawah.style.display === 'none') {
                    catatanFieldPengunci_hook_bawah.style.display = 'block';
                    tambahCatatanButtonPengunci_hook_bawah.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonPengunci_hook_bawah.classList.remove('btn-success');
                    tambahCatatanButtonPengunci_hook_bawah.classList.add('btn-danger');
                } else {
                    catatanFieldPengunci_hook_bawah.style.display = 'none';
                    tambahCatatanButtonPengunci_hook_bawah.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonPengunci_hook_bawah.classList.remove('btn-danger');
                    tambahCatatanButtonPengunci_hook_bawah.classList.add('btn-success');
                }
            });

        });
    </script>



@endsection
