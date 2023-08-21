@extends('dashboard.app')
@section('title', 'Check Sheet Tembin Monthly')

@section('content')

<div class="container">
    <h1>Check Sheet Tembin Monthly</h1>
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

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <form action="" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="tanggal_pengecekan" class="form-label">Tanggal Pengecekan</label>
                    <input type="date" class="form-control" id="tanggal_pengecekan" name="tanggal_pengecekan" required readonly>
                </div>
                <div class="mb-3">
                    <label for="npk" class="form-label">NPK</label>
                    <input type="text" class="form-control" id="npk" name="npk" value="{{ auth()->user()->npk }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="tembin_number" class="form-label">Nomor Tembin</label>
                    <input type="text" class="form-control" id="tembin_number" value="" name="tembin_number" required autofocus readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="master_link" class="form-label">Master Link</label>
                    <small class="form-text text-muted">Tidak ada kerusakan, bengkok, retak, dan pecah<br>Tidak ada keretakan pada titik tumpu</small>
                    <select class="form-select" id="master_link" name="master_link">
                        <option value="" selected disabled>Select</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="body_tembin" class="form-label">Body Tembin</label>
                    <small class="form-text text-muted">Tidak ada kerusakan, bengkok, retak, dan pecah</small>
                    <select class="form-select" id="body_tembin" name="body_tembin">
                        <option value="" selected disabled>Select</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="mur_baut" class="form-label">Mur & Baut</label>
                    <small class="form-text text-muted">Tidak ada kerusakan, retak, dan marking sesuai (tidak bergeser)</small>
                    <select class="form-select" id="mur_baut" name="mur_baut">
                        <option value="" selected disabled>Select</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="shackle" class="form-label">Shackle</label>
                    <small class="form-text text-muted">Tidak ada kerusakan, aus, dan retak</small>
                    <select class="form-select" id="shackle" name="shackle">
                        <option value="" selected disabled>Select</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="hook_atas" class="form-label">Hook Atas</label>
                    <small class="form-text text-muted">Tidak terjadi deformasi (perubahan bentuk)<br>Tidak ada keretakan pada titik tumpu</small>
                    <select class="form-select" id="hook_atas" name="hook_atas">
                        <option value="" selected disabled>Select</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="pengunci_hook_atas" class="form-label">Pengunci Hook Atas</label>
                    <small class="form-text text-muted">Pengunci masih berfungsi dan tidak terjadi kerusakan</small>
                    <select class="form-select" id="pengunci_hook_atas" name="pengunci_hook_atas">
                        <option value="" selected disabled>Select</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="mata_chain" class="form-label">Mata Chain</label>
                    <small class="form-text text-muted">Tidak terjadi retak & patah<br>Panjang mata chain 64 mm (+2 mm) pada setiap chain hook</small>
                    <select class="form-select" id="mata_chain" name="mata_chain">
                        <option value="" selected disabled>Select</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="hook_bawah" class="form-label">Hook Bawah</label>
                    <small class="form-text text-muted">Tidak terjadi deformasi (perubahan bentuk)<br>Tidak ada keretakan pada titik tumpu</small>
                    <select class="form-select" id="hook_bawah" name="hook_bawah">
                        <option value="" selected disabled>Select</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="pengunci_hook_bawah" class="form-label">Pengunci Hook Bawah</label>
                    <small class="form-text text-muted">Pengunci masih berfungsi dan tidak terjadi kerusakan</small>
                    <select class="form-select" id="pengunci_hook_bawah" name="pengunci_hook_bawah">
                        <option value="" selected disabled>Select</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12 text-end">
                <button type="submit" class="btn btn-primary">Kirim</button>
            </div>
        </div>
    </form>
</div>

@endsection
