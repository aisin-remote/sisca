@extends('dashboard.app')
@section('title', 'Check Sheet Nitrogen Sling Belt')

@section('content')

<div class="container">
    <h1>Check Sheet Nitrogen Sling Belt</h1>
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
                <label for="kelengkapan_tag_sling_belt" class="form-label">Tag Sling Belt</label>
                <small class="form-text text-muted">Tag pada belt tidak hilang / tidak terbaca</small>
                <select class="form-select" id="kelengkapan_tag_sling_belt" name="kelengkapan_tag_sling_belt">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="bagian_pinggir_belt_robek" class="form-label">Belt Robek</label>
                <small class="form-text text-muted">Tidak ada bekas cutting yang mencolok / bagian belt yang robek</small>
                <select class="form-select" id="bagian_pinggir_belt_robek" name="bagian_pinggir_belt_robek">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pengecekan_lapisan_belt_1" class="form-label">Belt Kusut</label>
                <small class="form-text text-muted">Belt tidak tertusuk benda tajam yang menyebabkan lubang atau longgarnya lapisan belt</small>
                <select class="form-select" id="pengecekan_lapisan_belt_1" name="pengecekan_lapisan_belt_1">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pengecekan_jahitan_belt" class="form-label">Jahitan Belt</label>
                <small class="form-text text-muted">Mata jahitan belt tidak menipis atau jahitan keluar dari jalur</small>
                <select class="form-select" id="pengecekan_jahitan_belt" name="pengecekan_jahitan_belt">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pengecekan_permukaan_belt" class="form-label">Belt Menipis</label>
                <small class="form-text text-muted">Belt tidak teriris atau tergores sehingga menyebabkan belt menipis</small>
                <select class="form-select" id="pengecekan_permukaan_belt" name="pengecekan_permukaan_belt">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pengecekan_lapisan_belt_2" class="form-label">Belt Scratch</label>
                <small class="form-text text-muted">Lapisan belt tidak terkikis / scratch sehingga belt menipis</small>
                <select class="form-select" id="pengecekan_lapisan_belt_2" name="pengecekan_lapisan_belt_2">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pengecekan_aus" class="form-label">Belt Aus</label>
                <small class="form-text text-muted">Anyaman pada lapisan belt tidak rusak</small>
                <select class="form-select" id="pengecekan_aus" name="pengecekan_aus">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="hook_wire" class="form-label">Hook Wire</label>
                <small class="form-text text-muted">Bagian hook tidak mengalami deformasi (kerenggangan)</small>
                <select class="form-select" id="hook_wire" name="hook_wire">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pengunci_hook" class="form-label">Pengunci Hook / Safety Latch</label>
                <small class="form-text text-muted">Pengunci hook tetap terpasang berfungsi dengan benar</small>
                <select class="form-select" id="pengunci_hook" name="pengunci_hook">
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
