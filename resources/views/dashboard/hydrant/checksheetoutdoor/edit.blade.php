@extends('dashboard.app')
@section('title', 'Check Sheet Hydrant Outdoor')

@section('content')

<div class="container">
    <h1>Check Sheet Hydrant Outdoor</h1>
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

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('hydrant.checksheetoutdoor.update', $checkSheetoutdoor->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="tanggal_pengecekan" class="form-label">Tanggal Pengecekan</label>
                    <input type="date" class="form-control" id="tanggal_pengecekan" value="{{ $checkSheetoutdoor->tanggal_pengecekan }}" name="tanggal_pengecekan" required readonly>
                </div>
                <div class="mb-3">
                    <label for="npk" class="form-label">NPK</label>
                    <input type="text" class="form-control" id="npk" name="npk" value="{{ $checkSheetoutdoor->npk }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="hydrant_number" class="form-label">Nomor Hydrant</label>
                    <input type="text" class="form-control" id="hydrant_number" value="{{ $checkSheetoutdoor->hydrant_number }}" name="hydrant_number" required autofocus readonly>
                </div>
        </div>


        <div class="col-md-6">
            <div class="mb-3">
                <label for="pintu" class="form-label">Pintu</label>
                <div class="input-group">
                    <select class="form-select" id="pintu" name="pintu">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('pintu') ?? $checkSheetoutdoor->pintu == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('pintu') ?? $checkSheetoutdoor->pintu == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_pintu"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_pintu" style="display:none;">
                <label for="catatan_pintu" class="form-label">Catatan Pintu</label>
                <textarea class="form-control" name="catatan_pintu" id="catatan_pintu" cols="30" rows="5">{{ old('catatan_pintu') ?? $checkSheetoutdoor->catatan_pintu}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_pintu" class="form-label">Foto Pintu</label>
                <input type="hidden" name="oldImage_pintu" value="{{ $checkSheetoutdoor->photo_pintu }}">
                @if ($checkSheetoutdoor->photo_pintu)
                    <img src="{{ asset('storage/' . $checkSheetoutdoor->photo_pintu) }}" class="photo-pintu-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-pintu-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_pintu" name="photo_pintu" onchange="previewImage('photo_pintu', 'photo-pintu-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="nozzle" class="form-label">Nozzle</label>
                <div class="input-group">
                    <select class="form-select" id="nozzle" name="nozzle">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('nozzle') ?? $checkSheetoutdoor->nozzle == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('nozzle') ?? $checkSheetoutdoor->nozzle == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_nozzle"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_nozzle" style="display:none;">
                <label for="catatan_nozzle" class="form-label">Catatan Nozzle</label>
                <textarea class="form-control" name="catatan_nozzle" id="catatan_nozzle" cols="30" rows="5">{{ old('catatan_nozzle') ?? $checkSheetoutdoor->catatan_nozzle}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_nozzle" class="form-label">Foto Nozzle</label>
                <input type="hidden" name="oldImage_nozzle" value="{{ $checkSheetoutdoor->photo_nozzle }}">
                @if ($checkSheetoutdoor->photo_nozzle)
                    <img src="{{ asset('storage/' . $checkSheetoutdoor->photo_nozzle) }}" class="photo-nozzle-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-nozzle-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_nozzle" name="photo_nozzle" onchange="previewImage('photo_nozzle', 'photo-nozzle-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="selang" class="form-label">Selang</label>
                <div class="input-group">
                    <select class="form-select" id="selang" name="selang">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('selang') ?? $checkSheetoutdoor->selang == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('selang') ?? $checkSheetoutdoor->selang == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_selang"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_selang" style="display:none;">
                <label for="catatan_selang" class="form-label">Catatan Selang</label>
                <textarea class="form-control" name="catatan_selang" id="catatan_selang" cols="30" rows="5">{{ old('catatan_selang') ?? $checkSheetoutdoor->catatan_selang}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_selang" class="form-label">Foto Selang</label>
                <input type="hidden" name="oldImage_selang" value="{{ $checkSheetoutdoor->photo_selang }}">
                @if ($checkSheetoutdoor->photo_selang)
                    <img src="{{ asset('storage/' . $checkSheetoutdoor->photo_selang) }}" class="photo-selang-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-selang-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_selang" name="photo_selang" onchange="previewImage('photo_selang', 'photo-selang-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="tuas" class="form-label">Tuas Pilar</label>
                <div class="input-group">
                    <select class="form-select" id="tuas" name="tuas">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('tuas') ?? $checkSheetoutdoor->tuas == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('tuas') ?? $checkSheetoutdoor->tuas == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_tuas"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_tuas" style="display:none;">
                <label for="catatan_tuas" class="form-label">Catatan Tuas Pilar</label>
                <textarea class="form-control" name="catatan_tuas" id="catatan_tuas" cols="30" rows="5">{{ old('catatan_tuas') ?? $checkSheetoutdoor->catatan_tuas}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_tuas" class="form-label">Foto Tuas Pilar</label>
                <input type="hidden" name="oldImage_tuas" value="{{ $checkSheetoutdoor->photo_tuas }}">
                @if ($checkSheetoutdoor->photo_tuas)
                    <img src="{{ asset('storage/' . $checkSheetoutdoor->photo_tuas) }}" class="photo-tuas-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-tuas-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_tuas" name="photo_tuas" onchange="previewImage('photo_tuas', 'photo-tuas-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="pilar" class="form-label">Pilar</label>
                <div class="input-group">
                    <select class="form-select" id="pilar" name="pilar">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('pilar') ?? $checkSheetoutdoor->pilar == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('pilar') ?? $checkSheetoutdoor->pilar == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_pilar"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_pilar" style="display:none;">
                <label for="catatan_pilar" class="form-label">Catatan Pilar</label>
                <textarea class="form-control" name="catatan_pilar" id="catatan_pilar" cols="30" rows="5">{{ old('catatan_pilar') ?? $checkSheetoutdoor->catatan_pilar}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_pilar" class="form-label">Foto Pilar</label>
                <input type="hidden" name="oldImage_pilar" value="{{ $checkSheetoutdoor->photo_pilar }}">
                @if ($checkSheetoutdoor->photo_pilar)
                    <img src="{{ asset('storage/' . $checkSheetoutdoor->photo_pilar) }}" class="photo-pilar-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-pilar-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_pilar" name="photo_pilar" onchange="previewImage('photo_pilar', 'photo-pilar-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="penutup" class="form-label">Penutup Pilar</label>
                <div class="input-group">
                    <select class="form-select" id="penutup" name="penutup">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('penutup') ?? $checkSheetoutdoor->penutup == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('penutup') ?? $checkSheetoutdoor->penutup == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_penutup"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_penutup" style="display:none;">
                <label for="catatan_penutup" class="form-label">Catatan Penutup Pilar</label>
                <textarea class="form-control" name="catatan_penutup" id="catatan_penutup" cols="30" rows="5">{{ old('catatan_penutup') ?? $checkSheetoutdoor->catatan_penutup}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_penutup" class="form-label">Foto Penutup Pilar</label>
                <input type="hidden" name="oldImage_penutup" value="{{ $checkSheetoutdoor->photo_penutup }}">
                @if ($checkSheetoutdoor->photo_penutup)
                    <img src="{{ asset('storage/' . $checkSheetoutdoor->photo_penutup) }}" class="photo-penutup-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-penutup-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_penutup" name="photo_penutup" onchange="previewImage('photo_penutup', 'photo-penutup-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="rantai" class="form-label">Rantai Penutup Pilar</label>
                <div class="input-group">
                    <select class="form-select" id="rantai" name="rantai">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('rantai') ?? $checkSheetoutdoor->rantai == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('rantai') ?? $checkSheetoutdoor->rantai == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_rantai"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_rantai" style="display:none;">
                <label for="catatan_rantai" class="form-label">Catatan Rantai Penutup Pilar</label>
                <textarea class="form-control" name="catatan_rantai" id="catatan_rantai" cols="30" rows="5">{{ old('catatan_rantai') ?? $checkSheetoutdoor->catatan_rantai}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_rantai" class="form-label">Foto Rantai Penutup Pilar</label>
                <input type="hidden" name="oldImage_rantai" value="{{ $checkSheetoutdoor->photo_rantai }}">
                @if ($checkSheetoutdoor->photo_rantai)
                    <img src="{{ asset('storage/' . $checkSheetoutdoor->photo_rantai) }}" class="photo-rantai-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-rantai-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_rantai" name="photo_rantai" onchange="previewImage('photo_rantai', 'photo-rantai-preview')">
            </div>

            <hr>

            <div class="mb-3">
                <label for="kupla" class="form-label">Kopling/Kupla</label>
                <div class="input-group">
                    <select class="form-select" id="kupla" name="kupla">
                        <option value="" selected disabled>Select</option>
                        <option value="OK" {{ old('kupla') ?? $checkSheetoutdoor->kupla == 'OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ old('kupla') ?? $checkSheetoutdoor->kupla == 'NG' ? 'selected' : '' }}>NG</option>
                    </select>
                    <button type="button" class="btn btn-success" id="tambahCatatan_kupla"><i class="bi bi-bookmark-plus"></i></button>
                </div>
            </div>
            <div class="mb-3 mt-3" id="catatanField_kupla" style="display:none;">
                <label for="catatan_kupla" class="form-label">Catatan Kopling/Kupla</label>
                <textarea class="form-control" name="catatan_kupla" id="catatan_kupla" cols="30" rows="5">{{ old('catatan_kupla') ?? $checkSheetoutdoor->catatan_kupla}}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo_kupla" class="form-label">Foto Kopling/Kupla</label>
                <input type="hidden" name="oldImage_kupla" value="{{ $checkSheetoutdoor->photo_kupla }}">
                @if ($checkSheetoutdoor->photo_kupla)
                    <img src="{{ asset('storage/' . $checkSheetoutdoor->photo_kupla) }}" class="photo-kupla-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-kupla-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_kupla" name="photo_kupla" onchange="previewImage('photo_kupla', 'photo-kupla-preview')">
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12">
        <p><strong>Catatan:</strong> Jika ada abnormal yang ditemukan segera laporkan ke atasan</p>
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
        const tambahCatatanButtonPintu = document.getElementById('tambahCatatan_pintu');
        const tambahCatatanButtonNozzle = document.getElementById('tambahCatatan_nozzle');
        const tambahCatatanButtonSelang = document.getElementById('tambahCatatan_selang');
        const tambahCatatanButtonTuas = document.getElementById('tambahCatatan_tuas');
        const tambahCatatanButtonPilar = document.getElementById('tambahCatatan_pilar');
        const tambahCatatanButtonPenutup = document.getElementById('tambahCatatan_penutup');
        const tambahCatatanButtonRantai = document.getElementById('tambahCatatan_rantai');
        const tambahCatatanButtonKupla = document.getElementById('tambahCatatan_kupla');

        const catatanFieldPintu = document.getElementById('catatanField_pintu');
        const catatanFieldNozzle = document.getElementById('catatanField_nozzle');
        const catatanFieldSelang = document.getElementById('catatanField_selang');
        const catatanFieldTuas = document.getElementById('catatanField_tuas');
        const catatanFieldPilar = document.getElementById('catatanField_pilar');
        const catatanFieldPenutup = document.getElementById('catatanField_penutup');
        const catatanFieldRantai = document.getElementById('catatanField_rantai');
        const catatanFieldKupla = document.getElementById('catatanField_kupla');


        // Tambahkan event listener untuk button "Tambah Catatan Pintu"
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

        // ... Tambahkan event listener untuk tombol-tombol tambah catatan lainnya di sini ...
        tambahCatatanButtonNozzle.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldNozzle.style.display === 'none') {
                catatanFieldNozzle.style.display = 'block';
                tambahCatatanButtonNozzle.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonNozzle.classList.remove('btn-success');
                tambahCatatanButtonNozzle.classList.add('btn-danger');
            } else {
                catatanFieldNozzle.style.display = 'none';
                tambahCatatanButtonNozzle.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonNozzle.classList.remove('btn-danger');
                tambahCatatanButtonNozzle.classList.add('btn-success');
            }
        });

        tambahCatatanButtonSelang.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldSelang.style.display === 'none') {
                catatanFieldSelang.style.display = 'block';
                tambahCatatanButtonSelang.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonSelang.classList.remove('btn-success');
                tambahCatatanButtonSelang.classList.add('btn-danger');
            } else {
                catatanFieldSelang.style.display = 'none';
                tambahCatatanButtonSelang.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonSelang.classList.remove('btn-danger');
                tambahCatatanButtonSelang.classList.add('btn-success');
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

        tambahCatatanButtonPilar.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldPilar.style.display === 'none') {
                catatanFieldPilar.style.display = 'block';
                tambahCatatanButtonPilar.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonPilar.classList.remove('btn-success');
                tambahCatatanButtonPilar.classList.add('btn-danger');
            } else {
                catatanFieldPilar.style.display = 'none';
                tambahCatatanButtonPilar.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonPilar.classList.remove('btn-danger');
                tambahCatatanButtonPilar.classList.add('btn-success');
            }
        });

        tambahCatatanButtonPenutup.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldPenutup.style.display === 'none') {
                catatanFieldPenutup.style.display = 'block';
                tambahCatatanButtonPenutup.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonPenutup.classList.remove('btn-success');
                tambahCatatanButtonPenutup.classList.add('btn-danger');
            } else {
                catatanFieldPenutup.style.display = 'none';
                tambahCatatanButtonPenutup.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonPenutup.classList.remove('btn-danger');
                tambahCatatanButtonPenutup.classList.add('btn-success');
            }
        });

        tambahCatatanButtonRantai.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldRantai.style.display === 'none') {
                catatanFieldRantai.style.display = 'block';
                tambahCatatanButtonRantai.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonRantai.classList.remove('btn-success');
                tambahCatatanButtonRantai.classList.add('btn-danger');
            } else {
                catatanFieldPenutup.style.display = 'none';
                tambahCatatanButtonPenutup.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonPenutup.classList.remove('btn-danger');
                tambahCatatanButtonPenutup.classList.add('btn-success');
            }
        });

        tambahCatatanButtonKupla.addEventListener('click', function() {
            // Toggle tampilan field catatan ketika tombol diklik
            if (catatanFieldKupla.style.display === 'none') {
                catatanFieldKupla.style.display = 'block';
                tambahCatatanButtonKupla.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                tambahCatatanButtonKupla.classList.remove('btn-success');
                tambahCatatanButtonKupla.classList.add('btn-danger');
            } else {
                catatanFieldKupla.style.display = 'none';
                tambahCatatanButtonKupla.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                tambahCatatanButtonKupla.classList.remove('btn-danger');
                tambahCatatanButtonKupla.classList.add('btn-success');
            }
        });
    });
</script>

@endsection
