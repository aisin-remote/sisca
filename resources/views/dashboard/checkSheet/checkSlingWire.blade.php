@extends('dashboard.app')
@section('title', 'Check Sheet Nitrogen Sling Wire')

@section('content')

<div class="container">
    <h1>Check Sheet Nitrogen Sling Wire</h1>
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
                    <label for="sling_number" class="form-label">Nomor Sling</label>
                    <input type="text" class="form-control" id="sling_number" value="" name="sling_number" required autofocus readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="serabut_wire" class="form-label">Serabut Wire</label>
                    <small class="form-text text-muted">Tidak ada wire putus lebih dari 6 wire di setiap strand yang berbeda atau 3 wire yang putus di satu strand</small>
                    <select class="form-select" id="serabut_wire" name="serabut_wire">
                        <option value="" selected disabled>Select</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="bagian_wire_1" class="form-label">Sling Terlilit</label>
                    <small class="form-text text-muted">Tidak ada wire yang terlilit</small>
                    <select class="form-select" id="bagian_wire_1" name="bagian_wire_1">
                        <option value="" selected disabled>Select</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="bagian_wire_2" class="form-label">Bagian Wire</label>
                    <small class="form-text text-muted">Tidak ada karat pada wire rope</small>
                    <select class="form-select" id="bagian_wire_2" name="bagian_wire_2">
                        <option value="" selected disabled>Select</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="kumpulan_wire" class="form-label">Kumpulan Wire</label>
                    <small class="form-text text-muted">Tidak ada serabut kawat yang keluar</small>
                    <select class="form-select" id="kumpulan_wire" name="kumpulan_wire">
                        <option value="" selected disabled>Select</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="diameter_wire" class="form-label">Diameter Wire</label>
                    <small class="form-text text-muted">Diameter wire tidak mengalami penyusutan. Maksimum penyusutan >7 % dari aslinya</small>
                    <select class="form-select" id="diameter_wire" name="diameter_wire">
                        <option value="" selected disabled>Select</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="kumpulan_wire_2" class="form-label">Kumpulan Wire</label>
                    <small class="form-text text-muted">Struktur wire tidak mengalami kelonggaran</small>
                    <select class="form-select" id="kumpulan_wire_2" name="kumpulan_wire_2">
                        <option value="" selected disabled>Select</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="hook_wire" class="form-label">Hook Wire</label>
                    <small class="form-text text-muted">Hook wire rope tidak mengalami deformasi (kerenggangan)</small>
                    <select class="form-select" id="hook_wire" name="hook_wire">
                        <option value="" selected disabled>Select</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="pengunci_hook" class="form-label">Pengunci Hook (Latch)</label>
                    <small class="form-text text-muted">Pengunci hook tetap terpasang & berfungsi dengan benar</small>
                    <select class="form-select" id="pengunci_hook" name="pengunci_hook">
                        <option value="" selected disabled>Select</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="mata_sling" class="form-label">Mata Sling</label>
                    <small class="form-text text-muted">Tidak ada perubahan bentuk (deformasi)</small>
                    <select class="form-select" id="mata_sling" name="mata_sling">
                        <option value="" selected disabled>Select</option>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
