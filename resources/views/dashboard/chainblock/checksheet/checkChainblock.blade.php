@extends('dashboard.app')
@section('title', 'Check Sheet Chain Block')

@section('content')

    <div class="container">
        <h1>Check Sheet Chain Block</h1>
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
                <form action="{{ route('process.checksheet.chainblock', ['chainblockNumber' => $chainblockNumber]) }}" method="POST"
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
                        <label for="chainblock_number" class="form-label">Nomor Chain Block</label>
                        <input type="text" class="form-control" id="chainblock_number" value="{{ $chainblockNumber }}"
                            name="chainblock_number" required autofocus readonly>
                    </div>
            </div>
            <div class="col-md-6">


                <div class="mb-3">
                    <label for="geared_trolley" class="form-label">Geared Trolley</label>
                    <div class="input-group">
                        <select class="form-select" id="geared_trolley" name="geared_trolley" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('geared_trolley') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('geared_trolley') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_geared_trolley"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_geared_trolley" style="display:none;">
                    <label for="catatan_geared_trolley" class="form-label">Catatan Geared Trolley</label>
                    <textarea class="form-control" name="catatan_geared_trolley" id="catatan_geared_trolley" cols="30" rows="5">{{ old('catatan_geared_trolley') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_geared_trolley" class="form-label">Foto Geared Trolley</label>
                    <img class="photo-geared_trolley-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_geared_trolley" name="photo_geared_trolley" required
                        onchange="previewImage('photo_geared_trolley', 'photo-geared_trolley-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="chain_geared_trolley_1" class="form-label">Gerakan Halus</label>
                    <div class="input-group">
                        <select class="form-select" id="chain_geared_trolley_1" name="chain_geared_trolley_1" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('chain_geared_trolley_1') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('chain_geared_trolley_1') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_chain_geared_trolley_1"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_chain_geared_trolley_1" style="display:none;">
                    <label for="catatan_chain_geared_trolley_1" class="form-label">Catatan Gerakan Halus</label>
                    <textarea class="form-control" name="catatan_chain_geared_trolley_1" id="catatan_chain_geared_trolley_1" cols="30" rows="5">{{ old('catatan_chain_geared_trolley_1') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_chain_geared_trolley_1" class="form-label">Foto Gerakan Halus</label>
                    <img class="photo-chain_geared_trolley_1-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_chain_geared_trolley_1" name="photo_chain_geared_trolley_1" required
                        onchange="previewImage('photo_chain_geared_trolley_1', 'photo-chain_geared_trolley_1-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="chain_geared_trolley_2" class="form-label">Chain Geared Trolley 2</label>
                    <div class="input-group">
                        <select class="form-select" id="chain_geared_trolley_2" name="chain_geared_trolley_2" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('chain_geared_trolley_2') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('chain_geared_trolley_2') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_chain_geared_trolley_2"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_chain_geared_trolley_2" style="display:none;">
                    <label for="catatan_chain_geared_trolley_2" class="form-label">Catatan Chain Geared Trolley 2</label>
                    <textarea class="form-control" name="catatan_chain_geared_trolley_2" id="catatan_chain_geared_trolley_2" cols="30" rows="5">{{ old('catatan_chain_geared_trolley_2') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_chain_geared_trolley_2" class="form-label">Foto Chain Geared Trolley 2</label>
                    <img class="photo-chain_geared_trolley_2-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_chain_geared_trolley_2" name="photo_chain_geared_trolley_2" required
                        onchange="previewImage('photo_chain_geared_trolley_2', 'photo-chain_geared_trolley_2-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="hooking_geared_trolly" class="form-label">Hooking Geared Trolly</label>
                    <div class="input-group">
                        <select class="form-select" id="hooking_geared_trolly" name="hooking_geared_trolly" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('hooking_geared_trolly') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('hooking_geared_trolly') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_hooking_geared_trolly"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_hooking_geared_trolly" style="display:none;">
                    <label for="catatan_hooking_geared_trolly" class="form-label">Catatan Hooking Geared Trolly</label>
                    <textarea class="form-control" name="catatan_hooking_geared_trolly" id="catatan_hooking_geared_trolly" cols="30" rows="5">{{ old('catatan_hooking_geared_trolly') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_hooking_geared_trolly" class="form-label">Foto Hooking Geared Trolly</label>
                    <img class="photo-hooking_geared_trolly-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_hooking_geared_trolly" name="photo_hooking_geared_trolly" required
                        onchange="previewImage('photo_hooking_geared_trolly', 'photo-hooking_geared_trolly-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="latch_hook_atas" class="form-label">Latch Hook Atas</label>
                    <div class="input-group">
                        <select class="form-select" id="latch_hook_atas" name="latch_hook_atas" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('latch_hook_atas') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('latch_hook_atas') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_latch_hook_atas"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_latch_hook_atas" style="display:none;">
                    <label for="catatan_latch_hook_atas" class="form-label">Catatan Latch Hook Atas</label>
                    <textarea class="form-control" name="catatan_latch_hook_atas" id="catatan_latch_hook_atas" cols="30" rows="5">{{ old('catatan_latch_hook_atas') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_latch_hook_atas" class="form-label">Foto Latch Hook Atas</label>
                    <img class="photo-latch_hook_atas-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_latch_hook_atas" name="photo_latch_hook_atas" required
                        onchange="previewImage('photo_latch_hook_atas', 'photo-latch_hook_atas-preview')">
                </div>

                <hr>

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

                <hr>

                <div class="mb-3">
                    <label for="hand_chain" class="form-label">Hand Chain</label>
                    <div class="input-group">
                        <select class="form-select" id="hand_chain" name="hand_chain" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('hand_chain') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('hand_chain') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_hand_chain"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_hand_chain" style="display:none;">
                    <label for="catatan_hand_chain" class="form-label">Catatan Hand Chain</label>
                    <textarea class="form-control" name="catatan_hand_chain" id="catatan_hand_chain" cols="30" rows="5">{{ old('catatan_hand_chain') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_hand_chain" class="form-label">Foto Hand Chain</label>
                    <img class="photo-hand_chain-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_hand_chain" name="photo_hand_chain" required
                        onchange="previewImage('photo_hand_chain', 'photo-hand_chain-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="load_chain" class="form-label">Load Chain</label>
                    <div class="input-group">
                        <select class="form-select" id="load_chain" name="load_chain" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('load_chain') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('load_chain') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_load_chain"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_load_chain" style="display:none;">
                    <label for="catatan_load_chain" class="form-label">Catatan Load Chain</label>
                    <textarea class="form-control" name="catatan_load_chain" id="catatan_load_chain" cols="30" rows="5">{{ old('catatan_load_chain') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_load_chain" class="form-label">Foto Load Chain</label>
                    <img class="photo-load_chain-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_load_chain" name="photo_load_chain" required
                        onchange="previewImage('photo_load_chain', 'photo-load_chain-preview')">
                </div>

                <hr>

                <div class="mb-3">
                    <label for="latch_hook_bawah" class="form-label">Latch Hook Bawah</label>
                    <div class="input-group">
                        <select class="form-select" id="latch_hook_bawah" name="latch_hook_bawah" required>
                            <option value="" selected disabled>Select</option>
                            <option value="OK" {{ old('latch_hook_bawah') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('latch_hook_bawah') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                        <button type="button" class="btn btn-success" id="tambahCatatan_latch_hook_bawah"><i class="bi bi-bookmark-plus"></i></button>
                    </div>
                </div>
                <div class="mb-3 mt-3" id="catatanField_latch_hook_bawah" style="display:none;">
                    <label for="catatan_latch_hook_bawah" class="form-label">Catatan Latch Hook Bawah</label>
                    <textarea class="form-control" name="catatan_latch_hook_bawah" id="catatan_latch_hook_bawah" cols="30" rows="5">{{ old('catatan_latch_hook_bawah') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="photo_latch_hook_bawah" class="form-label">Foto Latch Hook Bawah</label>
                    <img class="photo-latch_hook_bawah-preview img-fluid mb-3" style="max-height: 300px">
                    <input type="file" class="form-control" id="photo_latch_hook_bawah" name="photo_latch_hook_bawah" required
                        onchange="previewImage('photo_latch_hook_bawah', 'photo-latch_hook_bawah-preview')">
                </div>

                <hr>

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
            const tambahCatatanButtonGeared_trolley = document.getElementById('tambahCatatan_geared_trolley');
            const tambahCatatanButtonChain_geared_trollery_1 = document.getElementById('tambahCatatan_chain_geared_trolley_1');
            const tambahCatatanButtonChain_geared_trolley_2 = document.getElementById('tambahCatatan_chain_geared_trolley_2');
            const tambahCatatanButtonHooking_geared_trolly = document.getElementById('tambahCatatan_hooking_geared_trolly');
            const tambahCatatanButtonLatch_hook_atas = document.getElementById('tambahCatatan_latch_hook_atas');
            const tambahCatatanButtonHook_atas = document.getElementById('tambahCatatan_hook_atas');
            const tambahCatatanButtonHand_chain = document.getElementById('tambahCatatan_hand_chain');
            const tambahCatatanButtonLoad_chain = document.getElementById('tambahCatatan_load_chain');
            const tambahCatatanButtonLatch_hook_bawah = document.getElementById('tambahCatatan_latch_hook_bawah');
            const tambahCatatanButtonHook_bawah = document.getElementById('tambahCatatan_hook_bawah');



            const catatanFieldGeared_trolley = document.getElementById('catatanField_geared_trolley');
            const catatanFieldChain_geared_trollery_1 = document.getElementById('catatanField_chain_geared_trolley_1');
            const catatanFieldChain_geared_trolley_2 = document.getElementById('catatanField_chain_geared_trolley_2');
            const catatanFieldHooking_geared_trolly = document.getElementById('catatanField_hooking_geared_trolly');
            const catatanFieldLatch_hook_atas = document.getElementById('catatanField_latch_hook_atas');
            const catatanFieldHook_atas = document.getElementById('catatanField_hook_atas');
            const catatanFieldHand_chain = document.getElementById('catatanField_hand_chain');
            const catatanFieldLoad_chain = document.getElementById('catatanField_load_chain');
            const catatanFieldLatch_hook_bawah = document.getElementById('catatanField_latch_hook_bawah');
            const catatanFieldHook_bawah = document.getElementById('catatanField_hook_bawah');




            // Tambahkan event listener untuk button "Tambah Catatan Geared_trolley"
            tambahCatatanButtonGeared_trolley.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldGeared_trolley.style.display === 'none') {
                    catatanFieldGeared_trolley.style.display = 'block';
                    tambahCatatanButtonGeared_trolley.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonGeared_trolley.classList.remove('btn-success');
                    tambahCatatanButtonGeared_trolley.classList.add('btn-danger');
                } else {
                    catatanFieldGeared_trolley.style.display = 'none';
                    tambahCatatanButtonGeared_trolley.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonGeared_trolley.classList.remove('btn-danger');
                    tambahCatatanButtonGeared_trolley.classList.add('btn-success');
                }
            });

            // ... Tambahkan event listener untuk tombol-tombol tambah catatan lainnya di sini ...
            tambahCatatanButtonChain_geared_trollery_1.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldChain_geared_trollery_1.style.display === 'none') {
                    catatanFieldChain_geared_trollery_1.style.display = 'block';
                    tambahCatatanButtonChain_geared_trollery_1.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonChain_geared_trollery_1.classList.remove('btn-success');
                    tambahCatatanButtonChain_geared_trollery_1.classList.add('btn-danger');
                } else {
                    catatanFieldChain_geared_trollery_1.style.display = 'none';
                    tambahCatatanButtonChain_geared_trollery_1.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonChain_geared_trollery_1.classList.remove('btn-danger');
                    tambahCatatanButtonChain_geared_trollery_1.classList.add('btn-success');
                }
            });

            tambahCatatanButtonChain_geared_trolley_2.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldChain_geared_trolley_2.style.display === 'none') {
                    catatanFieldChain_geared_trolley_2.style.display = 'block';
                    tambahCatatanButtonChain_geared_trolley_2.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonChain_geared_trolley_2.classList.remove('btn-success');
                    tambahCatatanButtonChain_geared_trolley_2.classList.add('btn-danger');
                } else {
                    catatanFieldChain_geared_trolley_2.style.display = 'none';
                    tambahCatatanButtonChain_geared_trolley_2.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonChain_geared_trolley_2.classList.remove('btn-danger');
                    tambahCatatanButtonChain_geared_trolley_2.classList.add('btn-success');
                }
            });

            tambahCatatanButtonHooking_geared_trolly.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldHooking_geared_trolly.style.display === 'none') {
                    catatanFieldHooking_geared_trolly.style.display = 'block';
                    tambahCatatanButtonHooking_geared_trolly.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonHooking_geared_trolly.classList.remove('btn-success');
                    tambahCatatanButtonHooking_geared_trolly.classList.add('btn-danger');
                } else {
                    catatanFieldHooking_geared_trolly.style.display = 'none';
                    tambahCatatanButtonHooking_geared_trolly.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonHooking_geared_trolly.classList.remove('btn-danger');
                    tambahCatatanButtonHooking_geared_trolly.classList.add('btn-success');
                }
            });

            tambahCatatanButtonLatch_hook_atas.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldLatch_hook_atas.style.display === 'none') {
                    catatanFieldLatch_hook_atas.style.display = 'block';
                    tambahCatatanButtonLatch_hook_atas.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonLatch_hook_atas.classList.remove('btn-success');
                    tambahCatatanButtonLatch_hook_atas.classList.add('btn-danger');
                } else {
                    catatanFieldLatch_hook_atas.style.display = 'none';
                    tambahCatatanButtonLatch_hook_atas.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonLatch_hook_atas.classList.remove('btn-danger');
                    tambahCatatanButtonLatch_hook_atas.classList.add('btn-success');
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

            tambahCatatanButtonHand_chain.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldHand_chain.style.display === 'none') {
                    catatanFieldHand_chain.style.display = 'block';
                    tambahCatatanButtonHand_chain.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonHand_chain.classList.remove('btn-success');
                    tambahCatatanButtonHand_chain.classList.add('btn-danger');
                } else {
                    catatanFieldHand_chain.style.display = 'none';
                    tambahCatatanButtonHand_chain.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonHand_chain.classList.remove('btn-danger');
                    tambahCatatanButtonHand_chain.classList.add('btn-success');
                }
            });

            tambahCatatanButtonLoad_chain.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldLoad_chain.style.display === 'none') {
                    catatanFieldLoad_chain.style.display = 'block';
                    tambahCatatanButtonLoad_chain.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonLoad_chain.classList.remove('btn-success');
                    tambahCatatanButtonLoad_chain.classList.add('btn-danger');
                } else {
                    catatanFieldLoad_chain.style.display = 'none';
                    tambahCatatanButtonLoad_chain.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonLoad_chain.classList.remove('btn-danger');
                    tambahCatatanButtonLoad_chain.classList.add('btn-success');
                }
            });

            tambahCatatanButtonLatch_hook_bawah.addEventListener('click', function() {
                // Toggle tampilan field catatan ketika tombol diklik
                if (catatanFieldLatch_hook_bawah.style.display === 'none') {
                    catatanFieldLatch_hook_bawah.style.display = 'block';
                    tambahCatatanButtonLatch_hook_bawah.innerHTML = '<i class="bi bi-bookmark-x"></i>';
                    tambahCatatanButtonLatch_hook_bawah.classList.remove('btn-success');
                    tambahCatatanButtonLatch_hook_bawah.classList.add('btn-danger');
                } else {
                    catatanFieldLatch_hook_bawah.style.display = 'none';
                    tambahCatatanButtonLatch_hook_bawah.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
                    tambahCatatanButtonLatch_hook_bawah.classList.remove('btn-danger');
                    tambahCatatanButtonLatch_hook_bawah.classList.add('btn-success');
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

        });
    </script>



@endsection
