@extends('dashboard.app')
@section('title', 'Check Sheet Sling')

@section('content')

    <div class="container">
        <h1>Check Sheet Sling</h1>
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
                <form action="{{ route('sling.checksheetwire.update', $checkSheetwire->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="tanggal_pengecekan" class="form-label">Tanggal Pengecekan</label>
                        <input type="date" class="form-control" id="tanggal_pengecekan"
                            value="{{ $checkSheetwire->created_at }}" name="tanggal_pengecekan" required
                            readonly>
                    </div>
                    <div class="mb-3">
                        <label for="npk" class="form-label">NPK</label>
                        <input type="text" class="form-control" id="npk" name="npk"
                            value="{{ $checkSheetwire->npk }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="sling_number" class="form-label">Nomor Sling</label>
                        <input type="text" class="form-control" id="sling_number"
                            value="{{ $checkSheetwire->sling_number }}" name="sling_number" required autofocus
                            readonly>
                    </div>
            </div>


            <div class="col-md-6">
                <div class="mb-3">
                    <label for="serabut_wire" class="form-label">Serabut Wire</label>
                    <div class="input-group">
                        <select class="form-select" id="serabut_wire" name="serabut_wire">
                            <option value="" selected disabled>Select</option>
                            <option value="OK"
                                {{ old('serabut_wire') ?? $checkSheetwire->serabut_wire == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG"
                                {{ old('serabut_wire') ?? $checkSheetwire->serabut_wire == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_serabut_wire"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_serabut_wire" style="display:none;">
                    <label for="catatan_serabut_wire" class="form-label">Catatan Serabut Wire</label>
                    <textarea class="form-control" name="catatan_serabut_wire" id="catatan_serabut_wire" cols="30" rows="5">{{ old('catatan_serabut_wire') ?? $checkSheetwire->catatan_serabut_wire }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_serabut_wire" class="form-label">Foto Serabut Wire</label>
                    <input type="hidden" name="oldImage_serabut_wire" value="{{ $checkSheetwire->photo_serabut_wire }}">
                    @if ($checkSheetwire->photo_serabut_wire)
                        <img src="{{ asset('storage/' . $checkSheetwire->photo_serabut_wire) }}"
                            class="photo-serabut_wire-preview img-fluid mb-3 d-block" style="max-height: 300px">
                    @else
                        <img class="photo-serabut_wire-preview img-fluid mb-3" style="max-height: 300px">
                    @endif

                    <input type="file" class="form-control" id="photo_serabut_wire" name="photo_serabut_wire"
                        onchange="previewImage('photo_serabut_wire', 'photo-serabut_wire-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="bagian_wire_1" class="form-label">Sling Terlilit</label>
                    <div class="input-group">
                        <select class="form-select" id="bagian_wire_1" name="bagian_wire_1">
                            <option value="" selected disabled>Select</option>
                            <option value="OK"
                                {{ old('bagian_wire_1') ?? $checkSheetwire->bagian_wire_1 == 'OK' ? 'selected' : '' }}>
                                OK</option>
                            <option value="NG"
                                {{ old('bagian_wire_1') ?? $checkSheetwire->bagian_wire_1 == 'NG' ? 'selected' : '' }}>
                                NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_bagian_wire_1"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_bagian_wire_1" style="display:none;">
                    <label for="catatan_bagian_wire_1" class="form-label">Catatan Sling Terlilit</label>
                    <textarea class="form-control" name="catatan_bagian_wire_1" id="catatan_bagian_wire_1" cols="30"
                        rows="5">{{ old('catatan_bagian_wire_1') ?? $checkSheetwire->catatan_bagian_wire_1 }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_bagian_wire_1" class="form-label">Foto Sling Terlilit</label>
                    <input type="hidden" name="oldImage_bagian_wire_1"
                        value="{{ $checkSheetwire->photo_bagian_wire_1 }}">
                    @if ($checkSheetwire->photo_bagian_wire_1)
                        <img src="{{ asset('storage/' . $checkSheetwire->photo_bagian_wire_1) }}"
                            class="photo-bagian_wire_1-preview img-fluid mb-3 d-block" style="max-height: 300px">
                    @else
                        <img class="photo-bagian_wire_1-preview img-fluid mb-3" style="max-height: 300px">
                    @endif

                    <input type="file" class="form-control" id="photo_bagian_wire_1" name="photo_bagian_wire_1"
                        onchange="previewImage('photo_bagian_wire_1', 'photo-bagian_wire_1-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="bagian_wire_2" class="form-label">Karat</label>
                    <div class="input-group">
                        <select class="form-select" id="bagian_wire_2" name="bagian_wire_2">
                            <option value="" selected disabled>Select</option>
                            <option value="OK"
                                {{ old('bagian_wire_2') ?? $checkSheetwire->bagian_wire_2 == 'OK' ? 'selected' : '' }}>OK
                            </option>
                            <option value="NG"
                                {{ old('bagian_wire_2') ?? $checkSheetwire->bagian_wire_2 == 'NG' ? 'selected' : '' }}>NG
                            </option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_bagian_wire_2"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_bagian_wire_2" style="display:none;">
                    <label for="catatan_bagian_wire_2" class="form-label">Catatan Karat</label>
                    <textarea class="form-control" name="catatan_bagian_wire_2" id="catatan_bagian_wire_2" cols="30" rows="5">{{ old('catatan_bagian_wire_2') ?? $checkSheetwire->catatan_bagian_wire_2 }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_bagian_wire_2" class="form-label">Foto Karat</label>
                    <input type="hidden" name="oldImage_bagian_wire_2" value="{{ $checkSheetwire->photo_bagian_wire_2 }}">
                    @if ($checkSheetwire->photo_bagian_wire_2)
                        <img src="{{ asset('storage/' . $checkSheetwire->photo_bagian_wire_2) }}"
                            class="photo-bagian_wire_2-preview img-fluid mb-3 d-block" style="max-height: 300px">
                    @else
                        <img class="photo-bagian_wire_2-preview img-fluid mb-3" style="max-height: 300px">
                    @endif

                    <input type="file" class="form-control" id="photo_bagian_wire_2" name="photo_bagian_wire_2"
                        onchange="previewImage('photo_bagian_wire_2', 'photo-bagian_wire_2-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="kumpulan_wire_1" class="form-label">Serabut Keluar</label>
                    <div class="input-group">
                        <select class="form-select" id="kumpulan_wire_1" name="kumpulan_wire_1">
                            <option value="" selected disabled>Select</option>
                            <option value="OK"
                                {{ old('kumpulan_wire_1') ?? $checkSheetwire->kumpulan_wire_1 == 'OK' ? 'selected' : '' }}>OK
                            </option>
                            <option value="NG"
                                {{ old('kumpulan_wire_1') ?? $checkSheetwire->kumpulan_wire_1 == 'NG' ? 'selected' : '' }}>NG
                            </option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_kumpulan_wire_1"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_kumpulan_wire_1" style="display:none;">
                    <label for="catatan_kumpulan_wire_1" class="form-label">Catatan Serabut Keluar</label>
                    <textarea class="form-control" name="catatan_kumpulan_wire_1" id="catatan_kumpulan_wire_1" cols="30" rows="5">{{ old('catatan_kumpulan_wire_1') ?? $checkSheetwire->catatan_kumpulan_wire_1 }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_kumpulan_wire_1" class="form-label">Foto Serabut Keluar</label>
                    <input type="hidden" name="oldImage_kumpulan_wire_1" value="{{ $checkSheetwire->photo_kumpulan_wire_1 }}">
                    @if ($checkSheetwire->photo_kumpulan_wire_1)
                        <img src="{{ asset('storage/' . $checkSheetwire->photo_kumpulan_wire_1) }}"
                            class="photo-kumpulan_wire_1-preview img-fluid mb-3 d-block" style="max-height: 300px">
                    @else
                        <img class="photo-kumpulan_wire_1-preview img-fluid mb-3" style="max-height: 300px">
                    @endif

                    <input type="file" class="form-control" id="photo_kumpulan_wire_1" name="photo_kumpulan_wire_1"
                        onchange="previewImage('photo_kumpulan_wire_1', 'photo-kumpulan_wire_1-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="diameter_wire" class="form-label">Diameter Wire</label>
                    <div class="input-group">
                        <select class="form-select" id="diameter_wire" name="diameter_wire">
                            <option value="" selected disabled>Select</option>
                            <option value="OK"
                                {{ old('diameter_wire') ?? $checkSheetwire->diameter_wire == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG"
                                {{ old('diameter_wire') ?? $checkSheetwire->diameter_wire == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_diameter_wire"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_diameter_wire" style="display:none;">
                    <label for="catatan_diameter_wire" class="form-label">Catatan Diameter Wire</label>
                    <textarea class="form-control" name="catatan_diameter_wire" id="catatan_diameter_wire" cols="30" rows="5">{{ old('catatan_diameter_wire') ?? $checkSheetwire->catatan_diameter_wire }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_diameter_wire" class="form-label">Foto Diameter Wire</label>
                    <input type="hidden" name="oldImage_diameter_wire" value="{{ $checkSheetwire->photo_diameter_wire }}">
                    @if ($checkSheetwire->photo_diameter_wire)
                        <img src="{{ asset('storage/' . $checkSheetwire->photo_diameter_wire) }}"
                            class="photo-diameter_wire-preview img-fluid mb-3 d-block" style="max-height: 300px">
                    @else
                        <img class="photo-diameter_wire-preview img-fluid mb-3" style="max-height: 300px">
                    @endif

                    <input type="file" class="form-control" id="photo_diameter_wire" name="photo_diameter_wire"
                        onchange="previewImage('photo_diameter_wire', 'photo-diameter_wire-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="kumpulan_wire_2" class="form-label">Wire Longgar</label>
                    <div class="input-group">
                        <select class="form-select" id="kumpulan_wire_2" name="kumpulan_wire_2">
                            <option value="" selected disabled>Select</option>
                            <option value="OK"
                                {{ old('kumpulan_wire_2') ?? $checkSheetwire->kumpulan_wire_2 == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG"
                                {{ old('kumpulan_wire_2') ?? $checkSheetwire->kumpulan_wire_2 == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_kumpulan_wire_2"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_kumpulan_wire_2" style="display:none;">
                    <label for="catatan_kumpulan_wire_2" class="form-label">Catatan Wire Longgar</label>
                    <textarea class="form-control" name="catatan_kumpulan_wire_2" id="catatan_kumpulan_wire_2" cols="30" rows="5">{{ old('catatan_kumpulan_wire_2') ?? $checkSheetwire->catatan_kumpulan_wire_2 }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_kumpulan_wire_2" class="form-label">Foto Wire Longgar</label>
                    <input type="hidden" name="oldImage_kumpulan_wire_2" value="{{ $checkSheetwire->photo_kumpulan_wire_2 }}">
                    @if ($checkSheetwire->photo_kumpulan_wire_2)
                        <img src="{{ asset('storage/' . $checkSheetwire->photo_kumpulan_wire_2) }}"
                            class="photo-kumpulan_wire_2-preview img-fluid mb-3 d-block" style="max-height: 300px">
                    @else
                        <img class="photo-kumpulan_wire_2-preview img-fluid mb-3" style="max-height: 300px">
                    @endif

                    <input type="file" class="form-control" id="photo_kumpulan_wire_2" name="photo_kumpulan_wire_2"
                        onchange="previewImage('photo_kumpulan_wire_2', 'photo-kumpulan_wire_2-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="hook_wire" class="form-label">Hook Wire</label>
                    <div class="input-group">
                        <select class="form-select" id="hook_wire" name="hook_wire">
                            <option value="" selected disabled>Select</option>
                            <option value="OK"
                                {{ old('hook_wire') ?? $checkSheetwire->hook_wire == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG"
                                {{ old('hook_wire') ?? $checkSheetwire->hook_wire == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_hook_wire"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_hook_wire" style="display:none;">
                    <label for="catatan_hook_wire" class="form-label">Catatan Hook Wire</label>
                    <textarea class="form-control" name="catatan_hook_wire" id="catatan_hook_wire" cols="30" rows="5">{{ old('catatan_hook_wire') ?? $checkSheetwire->catatan_hook_wire }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_hook_wire" class="form-label">Foto Hook Wire</label>
                    <input type="hidden" name="oldImage_hook_wire" value="{{ $checkSheetwire->photo_hook_wire }}">
                    @if ($checkSheetwire->photo_hook_wire)
                        <img src="{{ asset('storage/' . $checkSheetwire->photo_hook_wire) }}"
                            class="photo-hook_wire-preview img-fluid mb-3 d-block" style="max-height: 300px">
                    @else
                        <img class="photo-hook_wire-preview img-fluid mb-3" style="max-height: 300px">
                    @endif

                    <input type="file" class="form-control" id="photo_hook_wire" name="photo_hook_wire"
                        onchange="previewImage('photo_hook_wire', 'photo-hook_wire-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="pengunci_hook" class="form-label">Pengunci Hook</label>
                    <div class="input-group">
                        <select class="form-select" id="pengunci_hook" name="pengunci_hook">
                            <option value="" selected disabled>Select</option>
                            <option value="OK"
                                {{ old('pengunci_hook') ?? $checkSheetwire->pengunci_hook == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG"
                                {{ old('pengunci_hook') ?? $checkSheetwire->pengunci_hook == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_pengunci_hook"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_pengunci_hook" style="display:none;">
                    <label for="catatan_pengunci_hook" class="form-label">Catatan Pengunci Hook</label>
                    <textarea class="form-control" name="catatan_pengunci_hook" id="catatan_pengunci_hook" cols="30" rows="5">{{ old('catatan_pengunci_hook') ?? $checkSheetwire->catatan_pengunci_hook }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_pengunci_hook" class="form-label">Foto Pengunci Hook</label>
                    <input type="hidden" name="oldImage_pengunci_hook" value="{{ $checkSheetwire->photo_pengunci_hook }}">
                    @if ($checkSheetwire->photo_pengunci_hook)
                        <img src="{{ asset('storage/' . $checkSheetwire->photo_pengunci_hook) }}"
                            class="photo-pengunci_hook-preview img-fluid mb-3 d-block" style="max-height: 300px">
                    @else
                        <img class="photo-pengunci_hook-preview img-fluid mb-3" style="max-height: 300px">
                    @endif

                    <input type="file" class="form-control" id="photo_pengunci_hook" name="photo_pengunci_hook"
                        onchange="previewImage('photo_pengunci_hook', 'photo-pengunci_hook-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="mata_sling" class="form-label">Mata Sling</label>
                    <div class="input-group">
                        <select class="form-select" id="mata_sling" name="mata_sling">
                            <option value="" selected disabled>Select</option>
                            <option value="OK"
                                {{ old('mata_sling') ?? $checkSheetwire->mata_sling == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG"
                                {{ old('mata_sling') ?? $checkSheetwire->mata_sling == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_mata_sling"><i
                                class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_mata_sling" style="display:none;">
                    <label for="catatan_mata_sling" class="form-label">Catatan Mata Sling</label>
                    <textarea class="form-control" name="catatan_mata_sling" id="catatan_mata_sling" cols="30" rows="5">{{ old('catatan_mata_sling') ?? $checkSheetwire->catatan_mata_sling }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_mata_sling" class="form-label">Foto Mata Sling</label>
                    <input type="hidden" name="oldImage_mata_sling" value="{{ $checkSheetwire->photo_mata_sling }}">
                    @if ($checkSheetwire->photo_mata_sling)
                        <img src="{{ asset('storage/' . $checkSheetwire->photo_mata_sling) }}"
                            class="photo-mata_sling-preview img-fluid mb-3 d-block" style="max-height: 300px">
                    @else
                        <img class="photo-mata_sling-preview img-fluid mb-3" style="max-height: 300px">
                    @endif

                    <input type="file" class="form-control" id="photo_mata_sling" name="photo_mata_sling"
                        onchange="previewImage('photo_mata_sling', 'photo-mata_sling-preview')">
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
            const tambahCatatanButtonSerabut_wire = document.getElementById('tambahCatatan_serabut_wire');
            const tambahCatatanButtonBagian_wire_1 = document.getElementById('tambahCatatan_bagian_wire_1');
            const tambahCatatanButtonBagian_wire_2 = document.getElementById('tambahCatatan_bagian_wire_2');
            const tambahCatatanButtonKumpulan_wire_1 = document.getElementById('tambahCatatan_kumpulan_wire_1');
            const tambahCatatanButtonDiameter_wire = document.getElementById('tambahCatatan_diameter_wire');
            const tambahCatatanButtonKumpulan_wire_2 = document.getElementById('tambahCatatan_kumpulan_wire_2');
            const tambahCatatanButtonHook_wire = document.getElementById('tambahCatatan_hook_wire');
            const tambahCatatanButtonPengunci_hook = document.getElementById('tambahCatatan_pengunci_hook');
            const tambahCatatanButtonMata_sling = document.getElementById('tambahCatatan_mata_sling');




            const catatanFieldSerabut_wire = document.getElementById('catatanField_serabut_wire');
            const catatanFieldBagian_wire_1 = document.getElementById('catatanField_bagian_wire_1');
            const catatanFieldBagian_wire_2 = document.getElementById('catatanField_bagian_wire_2');
            const catatanFieldKumpulan_wire_1 = document.getElementById('catatanField_kumpulan_wire_1');
            const catatanFieldDiameter_wire = document.getElementById('catatanField_diameter_wire');
            const catatanFieldKumpulan_wire_2 = document.getElementById('catatanField_kumpulan_wire_2');
            const catatanFieldHook_wire = document.getElementById('catatanField_hook_wire');
            const catatanFieldPengunci_hook = document.getElementById('catatanField_pengunci_hook');
            const catatanFieldMata_sling = document.getElementById('catatanField_mata_sling');





            // Tambahkan event listener untuk button "Tambah Catatan Serabut_wire"
            tambahCatatanButtonSerabut_wire.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldSerabut_wire.style.display === 'none') {
                    catatanFieldSerabut_wire.style.display = 'block';
                    tambahCatatanButtonSerabut_wire.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonSerabut_wire.classList.remove('btn-success');
                    tambahCatatanButtonSerabut_wire.classList.add('btn-danger');
                } else {
                    catatanFieldSerabut_wire.style.display = 'none';
                    tambahCatatanButtonSerabut_wire.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonSerabut_wire.classList.remove('btn-danger');
                    tambahCatatanButtonSerabut_wire.classList.add('btn-success');
                }
            });

            // ... Tambahkan event listener untuk tombol-tombol tambah catatan lainnya di sini ...
            tambahCatatanButtonBagian_wire_1.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldBagian_wire_1.style.display === 'none') {
                    catatanFieldBagian_wire_1.style.display = 'block';
                    tambahCatatanButtonBagian_wire_1.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonBagian_wire_1.classList.remove('btn-success');
                    tambahCatatanButtonBagian_wire_1.classList.add('btn-danger');
                } else {
                    catatanFieldBagian_wire_1.style.display = 'none';
                    tambahCatatanButtonBagian_wire_1.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonBagian_wire_1.classList.remove('btn-danger');
                    tambahCatatanButtonBagian_wire_1.classList.add('btn-success');
                }
            });

            tambahCatatanButtonBagian_wire_2.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldBagian_wire_2.style.display === 'none') {
                    catatanFieldBagian_wire_2.style.display = 'block';
                    tambahCatatanButtonBagian_wire_2.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonBagian_wire_2.classList.remove('btn-success');
                    tambahCatatanButtonBagian_wire_2.classList.add('btn-danger');
                } else {
                    catatanFieldBagian_wire_2.style.display = 'none';
                    tambahCatatanButtonBagian_wire_2.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonBagian_wire_2.classList.remove('btn-danger');
                    tambahCatatanButtonBagian_wire_2.classList.add('btn-success');
                }
            });

            tambahCatatanButtonKumpulan_wire_1.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldKumpulan_wire_1.style.display === 'none') {
                    catatanFieldKumpulan_wire_1.style.display = 'block';
                    tambahCatatanButtonKumpulan_wire_1.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonKumpulan_wire_1.classList.remove('btn-success');
                    tambahCatatanButtonKumpulan_wire_1.classList.add('btn-danger');
                } else {
                    catatanFieldKumpulan_wire_1.style.display = 'none';
                    tambahCatatanButtonKumpulan_wire_1.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonKumpulan_wire_1.classList.remove('btn-danger');
                    tambahCatatanButtonKumpulan_wire_1.classList.add('btn-success');
                }
            });

            tambahCatatanButtonDiameter_wire.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldDiameter_wire.style.display === 'none') {
                    catatanFieldDiameter_wire.style.display = 'block';
                    tambahCatatanButtonDiameter_wire.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonDiameter_wire.classList.remove('btn-success');
                    tambahCatatanButtonDiameter_wire.classList.add('btn-danger');
                } else {
                    catatanFieldDiameter_wire.style.display = 'none';
                    tambahCatatanButtonDiameter_wire.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonDiameter_wire.classList.remove('btn-danger');
                    tambahCatatanButtonDiameter_wire.classList.add('btn-success');
                }
            });

            tambahCatatanButtonKumpulan_wire_2.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldKumpulan_wire_2.style.display === 'none') {
                    catatanFieldKumpulan_wire_2.style.display = 'block';
                    tambahCatatanButtonKumpulan_wire_2.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonKumpulan_wire_2.classList.remove('btn-success');
                    tambahCatatanButtonKumpulan_wire_2.classList.add('btn-danger');
                } else {
                    catatanFieldKumpulan_wire_2.style.display = 'none';
                    tambahCatatanButtonKumpulan_wire_2.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonKumpulan_wire_2.classList.remove('btn-danger');
                    tambahCatatanButtonKumpulan_wire_2.classList.add('btn-success');
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

            tambahCatatanButtonMata_sling.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldMata_sling.style.display === 'none') {
                    catatanFieldMata_sling.style.display = 'block';
                    tambahCatatanButtonMata_sling.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonMata_sling.classList.remove('btn-success');
                    tambahCatatanButtonMata_sling.classList.add('btn-danger');
                } else {
                    catatanFieldMata_sling.style.display = 'none';
                    tambahCatatanButtonMata_sling.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonMata_sling.classList.remove('btn-danger');
                    tambahCatatanButtonMata_sling.classList.add('btn-success');
                }
            });
        });
    </script>

@endsection
