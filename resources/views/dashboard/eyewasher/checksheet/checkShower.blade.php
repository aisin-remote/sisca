@extends('dashboard.app')
@section('title', 'Check Sheet Eyewasher Shower')

@section('content')

    <div class="container">
        <h1>Check Sheet Eyewasher Shower</h1>
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
                <form action="{{ route('process.checksheet.shower', ['eyewasherNumber' => $eyewasherNumber]) }}" method="POST"
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
                        <label for="eyewasher_number" class="form-label">Nomor eyewasher</label>
                        <input type="text" class="form-control" id="eyewasher_number" value="{{ $eyewasherNumber }}"
                            name="eyewasher_number" required autofocus readonly>
                    </div>
            </div>
            <div class="col-md-6">


                <div class="mb-3">
                    <label for="instalation_base" class="form-label">Instalation Base</label>
                    <div class="input-group">
                        <select class="form-select" id="instalation_base" name="instalation_base" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('instalation_base') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('instalation_base') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_instalation_base"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_instalation_base" style="display:none;">
                    <label for="catatan_instalation_base" class="form-label">Catatan Instalation Base</label>
                    <textarea class="form-control" name="catatan_instalation_base" id="catatan_instalation_base" cols="30" rows="5">{{ old('catatan_instalation_base') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_instalation_base" class="form-label">Foto Instalation Base</label>
                    <img class="photo-instalation_base-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_instalation_base" name="photo_instalation_base" required
                        onchange="previewImage('photo_instalation_base', 'photo-instalation_base-preview')">
                </div>


                <div class="mb-3">
                    <label for="pipa_saluran_air" class="form-label">Pipa Saluran Air</label>
                    <div class="input-group">
                        <select class="form-select" id="pipa_saluran_air" name="pipa_saluran_air" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('pipa_saluran_air') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('pipa_saluran_air') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_pipa_saluran_air"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_pipa_saluran_air" style="display:none;">
                    <label for="catatan_pipa_saluran_air" class="form-label">Catatan Pipa saluran Air</label>
                    <textarea class="form-control" name="catatan_pipa_saluran_air" id="catatan_pipa_saluran_air" cols="30" rows="5">{{ old('catatan_pipa_saluran_air') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_pipa_saluran_air" class="form-label">Foto Pipa Saluran Air</label>
                    <img class="photo-pipa_saluran_air-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_pipa_saluran_air" name="photo_pipa_saluran_air" required
                        onchange="previewImage('photo_pipa_saluran_air', 'photo-pipa_saluran_air-preview')">
                </div>


                <div class="mb-3">
                    <label for="wastafel_eye_wash" class="form-label">Wastafel Eye Wash</label>
                    <div class="input-group">
                        <select class="form-select" id="wastafel_eye_wash" name="wastafel_eye_wash" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('wastafel_eye_wash') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('wastafel_eye_wash') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_wastafel_eye_wash"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_wastafel_eye_wash" style="display:none;">
                    <label for="catatan_wastafel_eye_wash" class="form-label">Catatan Wastafel Eye Wash</label>
                    <textarea class="form-control" name="catatan_wastafel_eye_wash" id="catatan_wastafel_eye_wash" cols="30" rows="5">{{ old('catatan_wastafel_eye_wash') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_wastafel_eye_wash" class="form-label">Foto Wastafel Eye Wash</label>
                    <img class="photo-wastafel_eye_wash-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_wastafel_eye_wash" name="photo_wastafel_eye_wash" required
                        onchange="previewImage('photo_wastafel_eye_wash', 'photo-wastafel_eye_wash-preview')">
                </div>


                <div class="mb-3">
                    <label for="kran_eye_wash" class="form-label">Kran Eye Wash</label>
                    <div class="input-group">
                        <select class="form-select" id="kran_eye_wash" name="kran_eye_wash" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('kran_eye_wash') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('kran_eye_wash') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_kran_eye_wash"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_kran_eye_wash" style="display:none;">
                    <label for="catatan_kran_eye_wash" class="form-label">Catatan Kran Eye Wash</label>
                    <textarea class="form-control" name="catatan_kran_eye_wash" id="catatan_kran_eye_wash" cols="30" rows="5">{{ old('catatan_kran_eye_wash') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_kran_eye_wash" class="form-label">Foto Kran Eye Wash</label>
                    <img class="photo-kran_eye_wash-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_kran_eye_wash" name="photo_kran_eye_wash" required
                        onchange="previewImage('photo_kran_eye_wash', 'photo-kran_eye_wash-preview')">
                </div>


                <div class="mb-3">
                    <label for="tuas_shower" class="form-label">Tuas Shower</label>
                    <div class="input-group">
                        <select class="form-select" id="tuas_shower" name="tuas_shower" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('tuas_shower') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('tuas_shower') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_tuas_shower"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_tuas_shower" style="display:none;">
                    <label for="catatan_tuas_shower" class="form-label">Catatan Tuas Shower</label>
                    <textarea class="form-control" name="catatan_tuas_shower" id="catatan_tuas_shower" cols="30" rows="5">{{ old('catatan_tuas_shower') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_tuas_shower" class="form-label">Foto Tuas Shower</label>
                    <img class="photo-tuas_shower-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_tuas_shower" name="photo_tuas_shower" required
                        onchange="previewImage('photo_tuas_shower', 'photo-tuas_shower-preview')">
                </div>


                <div class="mb-3">
                    <label for="sign" class="form-label">Sign</label>
                    <div class="input-group">
                        <select class="form-select" id="sign" name="sign" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('sign') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('sign') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_sign"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_sign" style="display:none;">
                    <label for="catatan_sign" class="form-label">Catatan Sign</label>
                    <textarea class="form-control" name="catatan_sign" id="catatan_sign" cols="30" rows="5">{{ old('catatan_sign') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_sign" class="form-label">Foto Sign</label>
                    <img class="photo-sign-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_sign" name="photo_sign" required
                        onchange="previewImage('photo_sign', 'photo-sign-preview')">
                </div>


                <div class="mb-3">
                    <label for="shower_head" class="form-label">Shower Head</label>
                    <div class="input-group">
                        <select class="form-select" id="shower_head" name="shower_head" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('shower_head') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('shower_head') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_shower_head"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_shower_head" style="display:none;">
                    <label for="catatan_shower_head" class="form-label">Catatan Shower Head</label>
                    <textarea class="form-control" name="catatan_shower_head" id="catatan_shower_head" cols="30" rows="5">{{ old('catatan_shower_head') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_shower_head" class="form-label">Foto Shower Head</label>
                    <img class="photo-shower_head-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_shower_head" name="photo_shower_head" required
                        onchange="previewImage('photo_shower_head', 'photo-shower_head-preview')">
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
            const tambahCatatanButtonPijakan = document.getElementById('tambahCatatan_pijakan');
            const tambahCatatanButtonPipa_saluran_air = document.getElementById('tambahCatatan_pipa_saluran_air');
            const tambahCatatanButtonWastafel = document.getElementById('tambahCatatan_wastafel');
            const tambahCatatanButtonKran_air = document.getElementById('tambahCatatan_kran_air');
            const tambahCatatanButtonTuas = document.getElementById('tambahCatatan_tuas');


            const catatanFieldPijakan = document.getElementById('catatanField_pijakan');
            const catatanFieldPipa_saluran_air = document.getElementById('catatanField_pipa_saluran_air');
            const catatanFieldWastafel = document.getElementById('catatanField_wastafel');
            const catatanFieldKran_air = document.getElementById('catatanField_kran_air');
            const catatanFieldTuas = document.getElementById('catatanField_tuas');


            // Tambahkan event listener untuk button "Tambah Catatan Pijakan"
            tambahCatatanButtonPijakan.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldPijakan.style.display === 'none') {
                    catatanFieldPijakan.style.display = 'block';
                    tambahCatatanButtonPijakan.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonPijakan.classList.remove('btn-success');
                    tambahCatatanButtonPijakan.classList.add('btn-danger');
                } else {
                    catatanFieldPijakan.style.display = 'none';
                    tambahCatatanButtonPijakan.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonPijakan.classList.remove('btn-danger');
                    tambahCatatanButtonPijakan.classList.add('btn-success');
                }
            });

            // ... Tambahkan event listener untuk tombol-tombol tambah catatan lainnya di sini ...
            tambahCatatanButtonPipa_saluran_air.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldPipa_saluran_air.style.display === 'none') {
                    catatanFieldPipa_saluran_air.style.display = 'block';
                    tambahCatatanButtonPipa_saluran_air.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonPipa_saluran_air.classList.remove('btn-success');
                    tambahCatatanButtonPipa_saluran_air.classList.add('btn-danger');
                } else {
                    catatanFieldPipa_saluran_air.style.display = 'none';
                    tambahCatatanButtonPipa_saluran_air.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonPipa_saluran_air.classList.remove('btn-danger');
                    tambahCatatanButtonPipa_saluran_air.classList.add('btn-success');
                }
            });

            tambahCatatanButtonWastafel.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldWastafel.style.display === 'none') {
                    catatanFieldWastafel.style.display = 'block';
                    tambahCatatanButtonWastafel.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonWastafel.classList.remove('btn-success');
                    tambahCatatanButtonWastafel.classList.add('btn-danger');
                } else {
                    catatanFieldWastafel.style.display = 'none';
                    tambahCatatanButtonWastafel.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonWastafel.classList.remove('btn-danger');
                    tambahCatatanButtonWastafel.classList.add('btn-success');
                }
            });

            tambahCatatanButtonKran_air.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldKran_air.style.display === 'none') {
                    catatanFieldKran_air.style.display = 'block';
                    tambahCatatanButtonKran_air.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonKran_air.classList.remove('btn-success');
                    tambahCatatanButtonKran_air.classList.add('btn-danger');
                } else {
                    catatanFieldKran_air.style.display = 'none';
                    tambahCatatanButtonKran_air.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonKran_air.classList.remove('btn-danger');
                    tambahCatatanButtonKran_air.classList.add('btn-success');
                }
            });

            tambahCatatanButtonTuas.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldTuas.style.display === 'none') {
                    catatanFieldTuas.style.display = 'block';
                    tambahCatatanButtonTuas.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonTuas.classList.remove('btn-success');
                    tambahCatatanButtonTuas.classList.add('btn-danger');
                } else {
                    catatanFieldTuas.style.display = 'none';
                    tambahCatatanButtonTuas.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonTuas.classList.remove('btn-danger');
                    tambahCatatanButtonTuas.classList.add('btn-success');
                }
            });
        });
    </script>



@endsection
