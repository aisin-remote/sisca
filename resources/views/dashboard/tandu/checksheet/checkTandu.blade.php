@extends('dashboard.app')
@section('title', 'Check Sheet Tandu')

@section('content')

    <div class="container">
        <h1>Check Sheet Tandu</h1>
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
                <form action="{{ route('process.checksheet.tandu', ['tanduNumber' => $tanduNumber]) }}" method="POST"
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
                        <label for="tandu_number" class="form-label">Nomor Tandu</label>
                        <input type="text" class="form-control" id="tandu_number" value="{{ $tanduNumber }}"
                            name="tandu_number" required autofocus readonly>
                    </div>
            </div>
            <div class="col-md-6">


                <div class="mb-3">
                    <label for="kunci_pintu" class="form-label">Kunci Pintu</label>
                    <div class="input-group">
                        <select class="form-select" id="kunci_pintu" name="kunci_pintu" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('kunci_pintu') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('kunci_pintu') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_kunci_pintu"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_kunci_pintu" style="display:none;">
                    <label for="catatan_kunci_pintu" class="form-label">Catatan Kunci Pintu</label>
                    <textarea class="form-control" name="catatan_kunci_pintu" id="catatan_kunci_pintu" cols="30" rows="5">{{ old('catatan_kunci_pintu') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_kunci_pintu" class="form-label">Foto Kunci Pintu</label>
                    <img class="photo-kunci_pintu-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_kunci_pintu" name="photo_kunci_pintu" required
                        onchange="previewImage('photo_kunci_pintu', 'photo-kunci_pintu-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="pintu" class="form-label">Pintu</label>
                    <div class="input-group">
                        <select class="form-select" id="pintu" name="pintu" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('pintu') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('pintu') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_pintu"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_pintu" style="display:none;">
                    <label for="catatan_pintu" class="form-label">Catatan Pintu</label>
                    <textarea class="form-control" name="catatan_pintu" id="catatan_pintu" cols="30" rows="5">{{ old('catatan_pintu') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_pintu" class="form-label">Foto Pintu</label>
                    <img class="photo-pintu-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_pintu" name="photo_pintu" required
                        onchange="previewImage('photo_pintu', 'photo-pintu-preview')">
                </div>

                <hr>

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

                <hr>

                <div class="mb-3">
                    <label for="hand_grip" class="form-label">Hand Grip</label>
                    <div class="input-group">
                        <select class="form-select" id="hand_grip" name="hand_grip" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('hand_grip') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('hand_grip') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_hand_grip"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_hand_grip" style="display:none;">
                    <label for="catatan_hand_grip" class="form-label">Catatan Hand Grip</label>
                    <textarea class="form-control" name="catatan_hand_grip" id="catatan_hand_grip" cols="30" rows="5">{{ old('catatan_hand_grip') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_hand_grip" class="form-label">Foto Hand Grip</label>
                    <img class="photo-hand_grip-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_hand_grip" name="photo_hand_grip" required
                        onchange="previewImage('photo_hand_grip', 'photo-hand_grip-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="body" class="form-label">Body</label>
                    <div class="input-group">
                        <select class="form-select" id="body" name="body" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('body') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('body') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_body"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_body" style="display:none;">
                    <label for="catatan_body" class="form-label">Catatan Body</label>
                    <textarea class="form-control" name="catatan_body" id="catatan_body" cols="30" rows="5">{{ old('catatan_body') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_body" class="form-label">Foto Body</label>
                    <img class="photo-body-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_body" name="photo_body" required
                        onchange="previewImage('photo_body', 'photo-body-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="engsel" class="form-label">Engsel</label>
                    <div class="input-group">
                        <select class="form-select" id="engsel" name="engsel" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('engsel') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('engsel') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_engsel"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_engsel" style="display:none;">
                    <label for="catatan_engsel" class="form-label">Catatan Engsel</label>
                    <textarea class="form-control" name="catatan_engsel" id="catatan_engsel" cols="30" rows="5">{{ old('catatan_engsel') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_engsel" class="form-label">Foto Engsel</label>
                    <img class="photo-engsel-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_engsel" name="photo_engsel" required
                        onchange="previewImage('photo_engsel', 'photo-engsel-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="kaki" class="form-label">Kaki</label>
                    <div class="input-group">
                        <select class="form-select" id="kaki" name="kaki" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('kaki') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('kaki') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_kaki"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_kaki" style="display:none;">
                    <label for="catatan_kaki" class="form-label">Catatan Kaki</label>
                    <textarea class="form-control" name="catatan_kaki" id="catatan_kaki" cols="30" rows="5">{{ old('catatan_kaki') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_kaki" class="form-label">Foto Kaki</label>
                    <img class="photo-kaki-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_kaki" name="photo_kaki" required
                        onchange="previewImage('photo_kaki', 'photo-kaki-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="belt" class="form-label">Belt</label>
                    <div class="input-group">
                        <select class="form-select" id="belt" name="belt" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('belt') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('belt') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_belt"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_belt" style="display:none;">
                    <label for="catatan_belt" class="form-label">Catatan Belt</label>
                    <textarea class="form-control" name="catatan_belt" id="catatan_belt" cols="30" rows="5">{{ old('catatan_belt') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_belt" class="form-label">Foto Belt</label>
                    <img class="photo-belt-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_belt" name="photo_belt" required
                        onchange="previewImage('photo_belt', 'photo-belt-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="rangka" class="form-label">Rangka</label>
                    <div class="input-group">
                        <select class="form-select" id="rangka" name="rangka" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('rangka') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('rangka') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_rangka"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_rangka" style="display:none;">
                    <label for="catatan_rangka" class="form-label">Catatan Rangka</label>
                    <textarea class="form-control" name="catatan_rangka" id="catatan_rangka" cols="30" rows="5">{{ old('catatan_rangka') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_rangka" class="form-label">Foto Rangka</label>
                    <img class="photo-rangka-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_rangka" name="photo_rangka" required
                        onchange="previewImage('photo_rangka', 'photo-rangka-preview')">
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
            const tambahCatatanButtonKunci_pintu = document.getElementById('tambahCatatan_kunci_pintu');
            const tambahCatatanButtonPintu = document.getElementById('tambahCatatan_pintu');
            const tambahCatatanButtonSign = document.getElementById('tambahCatatan_sign');
            const tambahCatatanButtonHand_grip = document.getElementById('tambahCatatan_hand_grip');
            const tambahCatatanButtonBody = document.getElementById('tambahCatatan_body');
            const tambahCatatanButtonEngsel = document.getElementById('tambahCatatan_engsel');
            const tambahCatatanButtonKaki = document.getElementById('tambahCatatan_kaki');
            const tambahCatatanButtonBelt = document.getElementById('tambahCatatan_belt');
            const tambahCatatanButtonRangka = document.getElementById('tambahCatatan_rangka');



            const catatanFieldKunci_pintu = document.getElementById('catatanField_kunci_pintu');
            const catatanFieldPintu = document.getElementById('catatanField_pintu');
            const catatanFieldSign = document.getElementById('catatanField_sign');
            const catatanFieldHand_grip = document.getElementById('catatanField_hand_grip');
            const catatanFieldBody = document.getElementById('catatanField_body');
            const catatanFieldEngsel = document.getElementById('catatanField_engsel');
            const catatanFieldKaki = document.getElementById('catatanField_kaki');
            const catatanFieldBelt = document.getElementById('catatanField_belt');
            const catatanFieldRangka = document.getElementById('catatanField_rangka');



            // Tambahkan event listener untuk button "Tambah Catatan Kunci_pintu"
            tambahCatatanButtonKunci_pintu.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldKunci_pintu.style.display === 'none') {
                    catatanFieldKunci_pintu.style.display = 'block';
                    tambahCatatanButtonKunci_pintu.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonKunci_pintu.classList.remove('btn-success');
                    tambahCatatanButtonKunci_pintu.classList.add('btn-danger');
                } else {
                    catatanFieldKunci_pintu.style.display = 'none';
                    tambahCatatanButtonKunci_pintu.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonKunci_pintu.classList.remove('btn-danger');
                    tambahCatatanButtonKunci_pintu.classList.add('btn-success');
                }
            });

            // ... Tambahkan event listener untuk tombol-tombol tambah catatan lainnya di sini ...
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

            tambahCatatanButtonSign.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldSign.style.display === 'none') {
                    catatanFieldSign.style.display = 'block';
                    tambahCatatanButtonSign.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonSign.classList.remove('btn-success');
                    tambahCatatanButtonSign.classList.add('btn-danger');
                } else {
                    catatanFieldSign.style.display = 'none';
                    tambahCatatanButtonSign.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonSign.classList.remove('btn-danger');
                    tambahCatatanButtonSign.classList.add('btn-success');
                }
            });

            tambahCatatanButtonHand_grip.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldHand_grip.style.display === 'none') {
                    catatanFieldHand_grip.style.display = 'block';
                    tambahCatatanButtonHand_grip.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonHand_grip.classList.remove('btn-success');
                    tambahCatatanButtonHand_grip.classList.add('btn-danger');
                } else {
                    catatanFieldHand_grip.style.display = 'none';
                    tambahCatatanButtonHand_grip.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonHand_grip.classList.remove('btn-danger');
                    tambahCatatanButtonHand_grip.classList.add('btn-success');
                }
            });

            tambahCatatanButtonBody.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldBody.style.display === 'none') {
                    catatanFieldBody.style.display = 'block';
                    tambahCatatanButtonBody.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonBody.classList.remove('btn-success');
                    tambahCatatanButtonBody.classList.add('btn-danger');
                } else {
                    catatanFieldBody.style.display = 'none';
                    tambahCatatanButtonBody.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonBody.classList.remove('btn-danger');
                    tambahCatatanButtonBody.classList.add('btn-success');
                }
            });

            tambahCatatanButtonEngsel.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldEngsel.style.display === 'none') {
                    catatanFieldEngsel.style.display = 'block';
                    tambahCatatanButtonEngsel.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonEngsel.classList.remove('btn-success');
                    tambahCatatanButtonEngsel.classList.add('btn-danger');
                } else {
                    catatanFieldEngsel.style.display = 'none';
                    tambahCatatanButtonEngsel.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonEngsel.classList.remove('btn-danger');
                    tambahCatatanButtonEngsel.classList.add('btn-success');
                }
            });

            tambahCatatanButtonKaki.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldKaki.style.display === 'none') {
                    catatanFieldKaki.style.display = 'block';
                    tambahCatatanButtonKaki.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonKaki.classList.remove('btn-success');
                    tambahCatatanButtonKaki.classList.add('btn-danger');
                } else {
                    catatanFieldKaki.style.display = 'none';
                    tambahCatatanButtonKaki.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonKaki.classList.remove('btn-danger');
                    tambahCatatanButtonKaki.classList.add('btn-success');
                }
            });

            tambahCatatanButtonBelt.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldBelt.style.display === 'none') {
                    catatanFieldBelt.style.display = 'block';
                    tambahCatatanButtonBelt.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonBelt.classList.remove('btn-success');
                    tambahCatatanButtonBelt.classList.add('btn-danger');
                } else {
                    catatanFieldBelt.style.display = 'none';
                    tambahCatatanButtonBelt.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonBelt.classList.remove('btn-danger');
                    tambahCatatanButtonBelt.classList.add('btn-success');
                }
            });

            tambahCatatanButtonRangka.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldRangka.style.display === 'none') {
                    catatanFieldRangka.style.display = 'block';
                    tambahCatatanButtonRangka.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonRangka.classList.remove('btn-success');
                    tambahCatatanButtonRangka.classList.add('btn-danger');
                } else {
                    catatanFieldRangka.style.display = 'none';
                    tambahCatatanButtonRangka.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonRangka.classList.remove('btn-danger');
                    tambahCatatanButtonRangka.classList.add('btn-success');
                }
            });

        });
    </script>



@endsection
