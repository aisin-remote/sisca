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
                    <label for="chain_block_number" class="form-label">Nomor Chain Block</label>
                    <input type="text" class="form-control" id="chain_block_number" value="" name="chain_block_number" required autofocus readonly>
                </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="geared_trolley" class="form-label">Geared Trolley</label>
                <small class="form-text text-muted">Gerakan geared trolly saat berpindah halus</small>
                <select class="form-select" id="geared_trolley" name="geared_trolley">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="chain_geared_trolley_1" class="form-label">Chain Geared Trolley</label>
                <small class="form-text text-muted">Gerakan rantai Geared Trolly halus</small>
                <select class="form-select" id="chain_geared_trolley_1" name="chain_geared_trolley_1">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="chain_geared_trolley_2" class="form-label">Chain Geared Trolley</label>
                <small class="form-text text-muted">Tidak ada yang retak, patah, atau bengkok</small>
                <select class="form-select" id="chain_geared_trolley_2" name="chain_geared_trolley_2">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="hooking_geared_trolley" class="form-label">Hooking Geared Trolley</label>
                <small class="form-text text-muted">Tidak retak, patah, atau bengkok</small>
                <select class="form-select" id="hooking_geared_trolley" name="hooking_geared_trolley">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="latch_hook_atas" class="form-label">Latch Hook Atas</label>
                <small class="form-text text-muted">Terpasang dan tidak rusak</small>
                <select class="form-select" id="latch_hook_atas" name="latch_hook_atas">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="hook_atas" class="form-label">Hook Atas</label>
                <small class="form-text text-muted">Tidak terjadi perubahan bentuk (deformasi)</small>
                <select class="form-select" id="hook_atas" name="hook_atas">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="hand_chain" class="form-label">Hand Chain</label>
                <small class="form-text text-muted">Tidak ada yang retak, patah, atau bengkok</small>
                <select class="form-select" id="hand_chain" name="hand_chain">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="load_chain" class="form-label">Load Chain</label>
                <small class="form-text text-muted">Tidak ada yang retak, patah, atau bengkok</small>
                <select class="form-select" id="load_chain" name="load_chain">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="latch_hook_bawah" class="form-label">Latch Hook Bawah</label>
                <small class="form-text text-muted">Terpasang dan tidak rusak</small>
                <select class="form-select" id="latch_hook_bawah" name="latch_hook_bawah">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="hook_bawah" class="form-label">Hook Bawah</label>
                <small class="form-text text-muted">Tidak terjadi perubahan bentuk (deformasi)</small>
                <select class="form-select" id="hook_bawah" name="hook_bawah">
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