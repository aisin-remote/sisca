@extends('dashboard.app')
@section('title', 'Check Sheet Nitrogen Hoist Crane')

@section('content')

<div class="container">
    <h1>Check Sheet Nitrogen Hoist Crane</h1>
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
                    <label for="crane_number" class="form-label">Nomor Crane</label>
                    <input type="text" class="form-control" id="crane_number" value="" name="crane_number" required autofocus readonly>
                </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="pendant_repair" class="form-label">Pendant</label>
                <small class="form-text text-muted">Tidak sedang dilakukan perbaikan</small>
                <select class="form-select" id="pendant_repair" name="pendant_repair">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pendant_physical" class="form-label">Pendant</label>
                <small class="form-text text-muted">Tidak ada kerusakan fisik pendant (tombol, cover, dll)</small>
                <select class="form-select" id="pendant_physical" name="pendant_physical">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="cross_traversing_1" class="form-label">Cross Traversing</label>
                <small class="form-text text-muted">Cek apakah arah tujuannya benar</small>
                <select class="form-select" id="cross_traversing_1" name="cross_traversing_1">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="cross_traversing_2" class="form-label">Cross Traversing</label>
                <small class="form-text text-muted">Cek apakah ada kelainan suara sewaktu menjalankan</small>
                <select class="form-select" id="cross_traversing_2" name="cross_traversing_2">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="cross_traversing_3" class="form-label">Cross Traversing</label>
                <small class="form-text text-muted">Cek apakah hoist bergerak lancar, dan apakah rem berfungsi</small>
                <select class="form-select" id="cross_traversing_3" name="cross_traversing_3">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="cross_traversing_4" class="form-label">Cross Traversing</label>
                <small class="form-text text-muted">Cek apakah ada kelainan dari kelokan dan guncangan</small>
                <select class="form-select" id="cross_traversing_4" name="cross_traversing_4">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="cross_traversing_5" class="form-label">Cross Traversing</label>
                <small class="form-text text-muted">Cek apakah limit switch berfungsi dengan baik</small>
                <select class="form-select" id="cross_traversing_5" name="cross_traversing_5">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="cross_traversing_6" class="form-label">Cross Traversing</label>
                <small class="form-text text-muted">Cek apakah speed hoist melambat sebelum mentok ke ujung</small>
                <select class="form-select" id="cross_traversing_6" name="cross_traversing_6">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="long_traveling_1" class="form-label">Long Traveling</label>
                <small class="form-text text-muted">Cek apakah arah tujuannya benar</small>
                <select class="form-select" id="long_traveling_1" name="long_traveling_1">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="long_traveling_2" class="form-label">Long Traveling</label>
                <small class="form-text text-muted">Cek apakah ada kelainan suara sewaktu menjalankan</small>
                <select class="form-select" id="long_traveling_2" name="long_traveling_2">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="long_traveling_3" class="form-label">Long Traveling</label>
                <small class="form-text text-muted">Cek apakah hoist bergerak lancar, dan apakah rem berfungsi efektif.</small>
                <select class="form-select" id="long_traveling_3" name="long_traveling_3">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="long_traveling_4" class="form-label">Long Traveling</label>
                <small class="form-text text-muted">Cek apakah ada kelainan dari kelokan dan guncangan</small>
                <select class="form-select" id="long_traveling_4" name="long_traveling_4">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="long_traveling_5" class="form-label">Long Traveling</label>
                <small class="form-text text-muted">Cek apakah limit switch berfungsi dengan baik</small>
                <select class="form-select" id="long_traveling_5" name="long_traveling_5">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="long_traveling_6" class="form-label">Long Traveling</label>
                <small class="form-text text-muted">Cek apakah speed hoist melambat sebelum mentok ke ujung</small>
                <select class="form-select" id="long_traveling_6" name="long_traveling_6">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="up_1" class="form-label">Up</label>
                <small class="form-text text-muted">Cek apakah pergerakannya benar.</small>
                <select class="form-select" id="up_1" name="up_1">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="up_2" class="form-label">Up</label>
                <small class="form-text text-muted">Cek apakah ada kelainan suara sewaktu menjalankan</small>
                <select class="form-select" id="up_2" name="up_2">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="up_3" class="form-label">Up</label>
                <small class="form-text text-muted">Cek apakah hoist bergerak lancar,dan apakah rem berfungsi efektif.</small>
                <select class="form-select" id="up_3" name="up_3">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="up_4" class="form-label">Up</label>
                <small class="form-text text-muted">Pastikan Jarak Hoist Saat Stop Di atas Minimal ( 70cm )</small>
                <select class="form-select" id="up_4" name="up_4">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="down_1" class="form-label">Down</label>
                <small class="form-text text-muted">Cek apakah pergerakannya benar.</small>
                <select class="form-select" id="down_1" name="down_1">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="down_2" class="form-label">Down</label>
                <small class="form-text text-muted">Cek apakah ada kelainan suara sewaktu menjalankan</small>
                <select class="form-select" id="down_2" name="down_2">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="down_3" class="form-label">Down</label>
                <small class="form-text text-muted">Cek apakah hoist bergerak lancar,dan apakah rem berfungsi efektif.</small>
                <select class="form-select" id="down_3" name="down_3">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="down_4" class="form-label">Down</label>
                <small class="form-text text-muted">Jarak Hoist Saat Stop Di Bawah Min 30cm dari lantai ( DEMAG )</small>
                <select class="form-select" id="down_4" name="down_4">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="push_button_1" class="form-label">Push Botton</label>
                <small class="form-text text-muted">Cek apakah ada kelainan pada Push Botton</small>
                <select class="form-select" id="push_button_1" name="push_button_1">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="push_button_2" class="form-label">Push Botton</label>
                <small class="form-text text-muted">Cek apakah ada kelainan pada kabel Push Botton</small>
                <select class="form-select" id="push_button_2" name="push_button_2">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <!-- Lanjutkan dengan bagian Wire Rope/Tali Kawat Baja, Block Hook, dan lainnya sesuai dengan data yang telah diberikan -->
            <div class="mb-3">
                <label for="wire_rope_1" class="form-label">Wire Rope/Tali Kawat Baja</label>
                <small class="form-text text-muted">Cek dari kondisi aus, perubahan bentuk dan kerusakan</small>
                <select class="form-select" id="wire_rope_1" name="wire_rope_1">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="wire_rope_2" class="form-label">Wire Rope/Tali Kawat Baja</label>
                <small class="form-text text-muted">Cek apakah pelumasannya layak</small>
                <select class="form-select" id="wire_rope_2" name="wire_rope_2">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="wire_rope_3" class="form-label">Wire Rope/Tali Kawat Baja</label>
                <small class="form-text text-muted">Cek apakah ada karat</small>
                <select class="form-select" id="wire_rope_3" name="wire_rope_3">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="block_hook_1" class="form-label">Block Hook</label>
                <small class="form-text text-muted">Cek apakah ada aus dan kondisi terbuka pada hook bawah</small>
                <select class="form-select" id="block_hook_1" name="block_hook_1">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="block_hook_2" class="form-label">Block Hook</label>
                <small class="form-text text-muted">Cek apakah hook berputar dengan lancar</small>
                <select class="form-select" id="block_hook_2" name="block_hook_2">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="block_hook_3" class="form-label">Block Hook</label>
                <small class="form-text text-muted">Cek sheave dari abnormal dan aus</small>
                <select class="form-select" id="block_hook_3" name="block_hook_3">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="emergency_stop" class="form-label">Emergency Stop</label>
                <small class="form-text text-muted">Berfungsi dengan baik</small>
                <select class="form-select" id="emergency_stop" name="emergency_stop">
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