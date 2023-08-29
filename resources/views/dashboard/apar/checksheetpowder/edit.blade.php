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
            <form action="{{ route('apar.checksheetpowder.update', $checkSheetpowder->id) }}" method="POST" enctype="multipart/form-data">
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
                <label for="photo_pressure" class="form-label">Foto Pressure</label>
                <input type="hidden" name="oldImage_pressure" value="{{ $checkSheetpowder->photo_pressure }}">
                @if ($checkSheetpowder->photo_pressure)
                    <img src="{{ asset('storage/' . $checkSheetpowder->photo_pressure) }}" class="photo-pressure-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-pressure-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_pressure" name="photo_pressure" onchange="previewImage('photo_pressure', 'photo-pressure-preview')">
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
                <label for="photo_hose" class="form-label">Foto Hose</label>
                <input type="hidden" name="oldImage_hose" value="{{ $checkSheetpowder->photo_hose }}">
                @if ($checkSheetpowder->photo_hose)
                    <img src="{{ asset('storage/' . $checkSheetpowder->photo_hose) }}" class="photo-hose-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-hose-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_hose" name="photo_hose" onchange="previewImage('photo_hose', 'photo-hose-preview')">
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
                <label for="photo_tabung" class="form-label">Foto Tabung</label>
                <input type="hidden" name="oldImage_tabung" value="{{ $checkSheetpowder->photo_tabung }}">
                @if ($checkSheetpowder->photo_tabung)
                    <img src="{{ asset('storage/' . $checkSheetpowder->photo_tabung) }}" class="photo-tabung-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-tabung-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_tabung" name="photo_tabung" onchange="previewImage('photo_tabung', 'photo-tabung-preview')">
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
                <label for="photo_regulator" class="form-label">Foto Regulator</label>
                <input type="hidden" name="oldImage_regulator" value="{{ $checkSheetpowder->photo_regulator }}">
                @if ($checkSheetpowder->photo_regulator)
                    <img src="{{ asset('storage/' . $checkSheetpowder->photo_regulator) }}" class="photo-regulator-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-regulator-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_regulator" name="photo_regulator" onchange="previewImage('photo_regulator', 'photo-regulator-preview')">
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
                <label for="photo_lock_pin" class="form-label">Foto Lock Pin</label>
                <input type="hidden" name="oldImage_lock_pin" value="{{ $checkSheetpowder->photo_lock_pin }}">
                @if ($checkSheetpowder->photo_lock_pin)
                    <img src="{{ asset('storage/' . $checkSheetpowder->photo_lock_pin) }}" class="photo-lock_pin-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-lock_pin-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_lock_pin" name="photo_lock_pin" onchange="previewImage('photo_lock_pin', 'photo-lock_pin-preview')">
            </div>
            <div class="mb-3">
                <label for="powder" class="form-label">Powder</label>
                <select class="form-select" id="powder" name="powder">
                    <option value="" selected disabled>Select</option>
                    <option value="OK" {{ old('powder') ?? $checkSheetpowder->powder == 'OK' ? 'selected' : '' }}>OK</option>
                    <option value="NG" {{ old('powder') ?? $checkSheetpowder->powder == 'NG' ? 'selected' : '' }}>NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="photo_powder" class="form-label">Foto Powder</label>
                <input type="hidden" name="oldImage_powder" value="{{ $checkSheetpowder->photo_powder }}">
                @if ($checkSheetpowder->photo_powder)
                    <img src="{{ asset('storage/' . $checkSheetpowder->photo_powder) }}" class="photo-powder-preview img-fluid mb-3 d-block" style="max-height: 300px">
                @else
                    <img class="photo-powder-preview img-fluid mb-3" style="max-height: 300px">
                @endif

                <input type="file" class="form-control" id="photo_powder" name="photo_powder" onchange="previewImage('photo_powder', 'photo-powder-preview')">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ old('description') ?? $checkSheetpowder->description}}</textarea>
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
