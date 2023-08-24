@extends('dashboard.app')
@section('title', 'Check Sheet APAR Powder')

@section('content')

<div class="container">
    <h1>Check Sheet APAR Powder</h1>
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
            <form action="{{ route('apar.checksheetpowder.update', $checkSheetpowder->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="tanggal_pengecekan" class="form-label">Tanggal Pengecekan</label>
                    <input type="date" class="form-control" id="tanggal_pengecekan" value="{{ $checkSheetpowder->tanggal_pengecekan }}" name="tanggal_pengecekan" required readonly>
                </div>
                <div class="mb-3">
                    <label for="npk" class="form-label">NPK</label>
                    <input type="text" class="form-control" id="npk" name="npk" value="{{ $checkSheetpowder->npk }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="apar_number" class="form-label">Nomor Apar</label>
                    <input type="text" class="form-control" id="apar_number" value="{{ $checkSheetpowder->apar_number }}" name="apar_number" required autofocus readonly>
                </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="pressure" class="form-label">Pressure</label>
                <select class="form-select" id="pressure" name="pressure">
                    <option value="" selected disabled>Select</option>
                    <option value="OK" {{ old('pressure') ?? $checkSheetpowder->pressure == 'OK' ? 'selected' : '' }}>OK</option>
                    <option value="NG" {{ old('pressure') ?? $checkSheetpowder->pressure == 'NG' ? 'selected' : '' }}>NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="hose" class="form-label">Hose</label>
                <select class="form-select" id="hose" name="hose">
                    <option value="" selected disabled>Select</option>
                    <option value="OK" {{ old('hose') ?? $checkSheetpowder->hose == 'OK' ? 'selected' : '' }}>OK</option>
                    <option value="NG" {{ old('pressure') ?? $checkSheetpowder->hose == 'NG' ? 'selected' : '' }}>NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tabung" class="form-label">Tabung</label>
                <select class="form-select" id="tabung" name="tabung">
                    <option value="" selected disabled>Select</option>
                    <option value="OK" {{ old('tabung') ?? $checkSheetpowder->tabung == 'OK' ? 'selected' : '' }}>OK</option>
                    <option value="NG" {{ old('tabung') ?? $checkSheetpowder->tabung == 'NG' ? 'selected' : '' }}>NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="regulator" class="form-label">Regulator</label>
                <select class="form-select" id="regulator" name="regulator">
                    <option value="" selected disabled>Select</option>
                    <option value="OK" {{ old('regulator') ?? $checkSheetpowder->regulator == 'OK' ? 'selected' : '' }}>OK</option>
                    <option value="NG" {{ old('regulator') ?? $checkSheetpowder->regulator == 'NG' ? 'selected' : '' }}>NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="lock_pin" class="form-label">Lock Pin</label>
                <select class="form-select" id="lock_pin" name="lock_pin">
                    <option value="" selected disabled>Select</option>
                    <option value="OK" {{ old('lock_pin') ?? $checkSheetpowder->lock_pin == 'OK' ? 'selected' : '' }}>OK</option>
                    <option value="NG" {{ old('lock_pin') ?? $checkSheetpowder->lock_pin == 'NG' ? 'selected' : '' }}>NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="powder" class="form-label">Powder</label>
                <select class="form-select" id="powder" name="powder">
                    <option value="" selected disabled>Select</option>
                    <option value="OK" {{ old('powder') ?? $checkSheetpowder->powder == 'OK' ? 'selected' : '' }}>OK</option>
                    <option value="NG" {{ old('powder') ?? $checkSheetpowder->powder == 'NG' ? 'selected' : '' }}>NG</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12">
        <p><strong>Catatan:</strong> UNTUK APAR TIPE CO2 METODE PENGECEKAN BERAT TABUNGNYA DILAKUKAN DENGAN CARA DI TIMBANG JIKA BERAT BERKURANG 10 % MAKA APAR DINYATAKAN NG.</p>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12 text-end">
        <button type="submit" class="btn btn-warning">Edit</button>
    </div>
</div>
</form>
</div>

@endsection
