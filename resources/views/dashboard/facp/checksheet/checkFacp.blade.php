@extends('dashboard.app')
@section('title', 'Check Sheet FACP')

@section('content')

    <div class="container">
        <h1>Check Sheet FACP</h1>
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
                <form action="{{ route('process.checksheet.facp', ['facpNumber' => $facpNumber]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3" style="margin-top: 32px">
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
                        <label for="zona_number" class="form-label">Nomor Zona</label>
                        <input type="text" class="form-control" id="zona_number" value="{{ $facpNumber }}"
                            name="zona_number" required autofocus readonly>
                    </div>
            </div>
            <div class="col-md-6">
                <span>
                    <h5 class="text-center">Smoke Detector</h5>
                </span>
                <div class="mb-3">
                    <label for="ok_smoke_detector" class="form-label">OK</label>
                    <input type="number" min="0" step="1" class="form-control" id="ok_smoke_detector"
                        value="{{ old('ok_smoke_detector') }}" name="ok_smoke_detector" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="ng_smoke_detector" class="form-label">NG</label>
                    <div class="input-group">
                        <input type="number" min="0" step="1" class="form-control" id="ng_smoke_detector"
                            value="{{ old('ng_smoke_detector') }}" name="ng_smoke_detector">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-success custom-rounded-left"
                                id="tambahCatatan_smoke_detector"><i class="bi bi-bookmark-plus"></i></button>
                            <button type="button" class="btn btn-success" id="tambahFoto_smoke_detector"><i
                                    data-feather="camera" style="width: 16px; height: 16px;"></i></button>
                        </div>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_smoke_detector" style="display:none;">
                    <label for="catatan_smoke_detector" class="form-label">Catatan Smoke Detector</label>
                    <textarea class="form-control" name="catatan_smoke_detector" id="catatan_smoke_detector" cols="30" rows="5">{{ old('catatan_smoke_detector') }}</textarea>
                </div>
                <div class="mb-3" id="fotoField_smoke_detector" style="display:none;">
                    <label for="photo_smoke_detector" class="form-label">Foto Smoke Detector</label>
                    <img class="photo-smoke_detector-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_smoke_detector" name="photo_smoke_detector"
                        onchange="previewImage('photo_smoke_detector', 'photo-smoke_detector-preview')">
                </div>

                <hr>

                <span>
                    <h5 class="text-center">Heat Detector</h5>
                </span>
                <div class="mb-3">
                    <label for="ok_heat_detector" class="form-label">OK</label>
                    <input type="number" min="0" step="1" class="form-control" id="ok_heat_detector"
                        value="{{ old('ok_heat_detector') }}" name="ok_heat_detector" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="ng_heat_detector" class="form-label">NG</label>
                    <div class="input-group">
                        <input type="number" min="0" step="1" class="form-control" id="ng_heat_detector"
                            value="{{ old('ng_heat_detector') }}" name="ng_heat_detector">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-success custom-rounded-left"
                                id="tambahCatatan_heat_detector"><i class="bi bi-bookmark-plus"></i></button>
                            <button type="button" class="btn btn-success" id="tambahFoto_heat_detector"><i
                                    data-feather="camera" style="width: 16px; height: 16px;"></i></button>
                        </div>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_heat_detector" style="display:none;">
                    <label for="catatan_heat_detector" class="form-label">Catatan Heat Detector</label>
                    <textarea class="form-control" name="catatan_heat_detector" id="catatan_heat_detector" cols="30"
                        rows="5">{{ old('catatan_heat_detector') }}</textarea>
                </div>
                <div class="mb-3" id="fotoField_heat_detector" style="display:none;">
                    <label for="photo_heat_detector" class="form-label">Foto Heat Detector</label>
                    <img class="photo-heat_detector-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_heat_detector" name="photo_heat_detector"
                        onchange="previewImage('photo_heat_detector', 'photo-heat_detector-preview')">
                </div>

                <hr>

                <span>
                    <h5 class="text-center">Beam Detector</h5>
                </span>
                <div class="mb-3">
                    <label for="ok_beam_detector" class="form-label">OK</label>
                    <input type="number" min="0" step="1" class="form-control" id="ok_beam_detector"
                        value="{{ old('ok_beam_detector') }}" name="ok_beam_detector" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="ng_beam_detector" class="form-label">NG</label>
                    <div class="input-group">
                        <input type="number" min="0" step="1" class="form-control" id="ng_beam_detector"
                            value="{{ old('ng_beam_detector') }}" name="ng_beam_detector">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-success custom-rounded-left"
                                id="tambahCatatan_beam_detector"><i class="bi bi-bookmark-plus"></i></button>
                            <button type="button" class="btn btn-success" id="tambahFoto_beam_detector"><i
                                    data-feather="camera" style="width: 16px; height: 16px;"></i></button>
                        </div>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_beam_detector" style="display:none;">
                    <label for="catatan_beam_detector" class="form-label">Catatan Beam Detector</label>
                    <textarea class="form-control" name="catatan_beam_detector" id="catatan_beam_detector" cols="30"
                        rows="5">{{ old('catatan_beam_detector') }}</textarea>
                </div>
                <div class="mb-3" id="fotoField_beam_detector" style="display:none;">
                    <label for="photo_beam_detector" class="form-label">Foto Beam Detector</label>
                    <img class="photo-beam_detector-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_beam_detector" name="photo_beam_detector"
                        onchange="previewImage('photo_beam_detector', 'photo-beam_detector-preview')">
                </div>

                <hr>

                <span>
                    <h5 class="text-center">Push Button</h5>
                </span>
                <div class="mb-3">
                    <label for="ok_push_button" class="form-label">OK</label>
                    <input type="number" min="0" step="1" class="form-control" id="ok_push_button"
                        value="{{ old('ok_push_button') }}" name="ok_push_button" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="ng_push_button" class="form-label">NG</label>
                    <div class="input-group">
                        <input type="number" min="0" step="1" class="form-control" id="ng_push_button"
                            value="{{ old('ng_push_button') }}" name="ng_push_button">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-success custom-rounded-left"
                                id="tambahCatatan_push_button"><i class="bi bi-bookmark-plus"></i></button>
                            <button type="button" class="btn btn-success" id="tambahFoto_push_button"><i
                                    data-feather="camera" style="width: 16px; height: 16px;"></i></button>
                        </div>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_push_button" style="display:none;">
                    <label for="catatan_push_button" class="form-label">Catatan Push Button</label>
                    <textarea class="form-control" name="catatan_push_button" id="catatan_push_button" cols="30" rows="5">{{ old('catatan_push_button') }}</textarea>
                </div>
                <div class="mb-3" id="fotoField_push_button" style="display:none;">
                    <label for="photo_push_button" class="form-label">Foto Push Button</label>
                    <img class="photo-push_button-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_push_button" name="photo_push_button"
                        onchange="previewImage('photo_push_button', 'photo-push_button-preview')">
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
            const tambahCatatanButtonSmoke_detector = document.getElementById('tambahCatatan_smoke_detector');
            const tambahFotoButtonSmoke_detector = document.getElementById('tambahFoto_smoke_detector');
            const tambahCatatanButtonHeat_detector = document.getElementById('tambahCatatan_heat_detector');
            const tambahFotoButtonHeat_detector = document.getElementById('tambahFoto_heat_detector');
            const tambahCatatanButtonBeam_detector = document.getElementById('tambahCatatan_beam_detector');
            const tambahFotoButtonBeam_detector = document.getElementById('tambahFoto_beam_detector');
            const tambahCatatanButtonPush_button = document.getElementById('tambahCatatan_push_button');
            const tambahFotoButtonPush_button = document.getElementById('tambahFoto_push_button');


            const catatanFieldSmoke_detector = document.getElementById('catatanField_smoke_detector');
            const fotoFieldSmoke_detector = document.getElementById('fotoField_smoke_detector');
            const catatanFieldHeat_detector = document.getElementById('catatanField_heat_detector');
            const fotoFieldHeat_detector = document.getElementById('fotoField_heat_detector');
            const catatanFieldBeam_detector = document.getElementById('catatanField_beam_detector');
            const fotoFieldBeam_detector = document.getElementById('fotoField_beam_detector');
            const catatanFieldPush_button = document.getElementById('catatanField_push_button');
            const fotoFieldPush_button = document.getElementById('fotoField_push_button');



            // ... Tambahkan event listener untuk tombol-tombol tambah catatan lainnya di sini ...
            tambahCatatanButtonSmoke_detector.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldSmoke_detector.style.display === 'none') {
                    catatanFieldSmoke_detector.style.display = 'block';
                    tambahCatatanButtonSmoke_detector.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonSmoke_detector.classList.remove('btn-success');
                    tambahCatatanButtonSmoke_detector.classList.add('btn-danger');
                } else {
                    catatanFieldSmoke_detector.style.display = 'none';
                    tambahCatatanButtonSmoke_detector.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonSmoke_detector.classList.remove('btn-danger');
                    tambahCatatanButtonSmoke_detector.classList.add('btn-success');
                }
            });

            tambahFotoButtonSmoke_detector.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (fotoFieldSmoke_detector.style.display === 'none') {
                    fotoFieldSmoke_detector.style.display = 'block';
                    tambahFotoButtonSmoke_detector.innerHTML =
                        '<i data-feather="camera-off" style="width: 16px; height: 16px;"></i>';
                    feather.replace();
                    tambahFotoButtonSmoke_detector.classList.remove('btn-success');
                    tambahFotoButtonSmoke_detector.classList.add('btn-danger');
                } else {
                    fotoFieldSmoke_detector.style.display = 'none';
                    tambahFotoButtonSmoke_detector.innerHTML =
                        '<i data-feather="camera" style="width: 16px; height: 16px;"></i>';
                    feather.replace();
                    tambahFotoButtonSmoke_detector.classList.remove('btn-danger');
                    tambahFotoButtonSmoke_detector.classList.add('btn-success');
                }
            });

            tambahCatatanButtonHeat_detector.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldHeat_detector.style.display === 'none') {
                    catatanFieldHeat_detector.style.display = 'block';
                    tambahCatatanButtonHeat_detector.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonHeat_detector.classList.remove('btn-success');
                    tambahCatatanButtonHeat_detector.classList.add('btn-danger');
                } else {
                    catatanFieldHeat_detector.style.display = 'none';
                    tambahCatatanButtonHeat_detector.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonHeat_detector.classList.remove('btn-danger');
                    tambahCatatanButtonHeat_detector.classList.add('btn-success');
                }
            });

            tambahFotoButtonHeat_detector.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (fotoFieldHeat_detector.style.display === 'none') {
                    fotoFieldHeat_detector.style.display = 'block';
                    tambahFotoButtonHeat_detector.innerHTML =
                        '<i data-feather="camera-off" style="width: 16px; height: 16px;"></i>';
                    feather.replace();
                    tambahFotoButtonHeat_detector.classList.remove('btn-success');
                    tambahFotoButtonHeat_detector.classList.add('btn-danger');
                } else {
                    fotoFieldHeat_detector.style.display = 'none';
                    tambahFotoButtonHeat_detector.innerHTML =
                        '<i data-feather="camera" style="width: 16px; height: 16px;"></i>';
                    feather.replace();
                    tambahFotoButtonHeat_detector.classList.remove('btn-danger');
                    tambahFotoButtonHeat_detector.classList.add('btn-success');
                }
            });

            tambahCatatanButtonBeam_detector.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldBeam_detector.style.display === 'none') {
                    catatanFieldBeam_detector.style.display = 'block';
                    tambahCatatanButtonBeam_detector.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonBeam_detector.classList.remove('btn-success');
                    tambahCatatanButtonBeam_detector.classList.add('btn-danger');
                } else {
                    catatanFieldBeam_detector.style.display = 'none';
                    tambahCatatanButtonBeam_detector.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonBeam_detector.classList.remove('btn-danger');
                    tambahCatatanButtonBeam_detector.classList.add('btn-success');
                }
            });

            tambahFotoButtonBeam_detector.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (fotoFieldBeam_detector.style.display === 'none') {
                    fotoFieldBeam_detector.style.display = 'block';
                    tambahFotoButtonBeam_detector.innerHTML =
                        '<i data-feather="camera-off" style="width: 16px; height: 16px;"></i>';
                    feather.replace();
                    tambahFotoButtonBeam_detector.classList.remove('btn-success');
                    tambahFotoButtonBeam_detector.classList.add('btn-danger');
                } else {
                    fotoFieldBeam_detector.style.display = 'none';
                    tambahFotoButtonBeam_detector.innerHTML =
                        '<i data-feather="camera" style="width: 16px; height: 16px;"></i>';
                    feather.replace();
                    tambahFotoButtonBeam_detector.classList.remove('btn-danger');
                    tambahFotoButtonBeam_detector.classList.add('btn-success');
                }
            });

            tambahCatatanButtonPush_button.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldPush_button.style.display === 'none') {
                    catatanFieldPush_button.style.display = 'block';
                    tambahCatatanButtonPush_button.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonPush_button.classList.remove('btn-success');
                    tambahCatatanButtonPush_button.classList.add('btn-danger');
                } else {
                    catatanFieldPush_button.style.display = 'none';
                    tambahCatatanButtonPush_button.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonPush_button.classList.remove('btn-danger');
                    tambahCatatanButtonPush_button.classList.add('btn-success');
                }
            });

            tambahFotoButtonPush_button.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (fotoFieldPush_button.style.display === 'none') {
                    fotoFieldPush_button.style.display = 'block';
                    tambahFotoButtonPush_button.innerHTML =
                        '<i data-feather="camera-off" style="width: 16px; height: 16px;"></i>';
                    feather.replace();
                    tambahFotoButtonPush_button.classList.remove('btn-success');
                    tambahFotoButtonPush_button.classList.add('btn-danger');
                } else {
                    fotoFieldPush_button.style.display = 'none';
                    tambahFotoButtonPush_button.innerHTML =
                        '<i data-feather="camera" style="width: 16px; height: 16px;"></i>';
                    feather.replace();
                    tambahFotoButtonPush_button.classList.remove('btn-danger');
                    tambahFotoButtonPush_button.classList.add('btn-success');
                }
            });
        });
    </script>



@endsection
