@extends('dashboard.app')
@section('title', 'Check Sheet APAR CO2')

@section('content')

<div class="container">
    <h1>Check Sheet APAR CO2</h1>
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
            <form action="/checksheetpowder" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="tanggal_pengecekan" class="form-label">Tanggal Pengecekan</label>
                    <input type="date" class="form-control" id="tanggal_pengecekan" name="tanggal_pengecekan" required>
                </div>
                <div class="mb-3">
                    <label for="npk" class="form-label">NPK</label>
                    <input type="text" class="form-control" id="npk" name="npk" value="{{ auth()->user()->npk }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="apar_number" class="form-label">Nomor Apar</label>
                    <input type="text" class="form-control" id="apar_number" name="apar_number" required>
                </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="pressure" class="form-label">Pressure</label>
                <select class="form-select" id="pressure" name="pressure">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="hose" class="form-label">Hose</label>
                <select class="form-select" id="hose" name="hose">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tabung" class="form-label">Tabung</label>
                <select class="form-select" id="tabung" name="tabung">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="regulator" class="form-label">Regulator</label>
                <select class="form-select" id="regulator" name="regulator">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="lock_pin" class="form-label">Lock Pin</label>
                <select class="form-select" id="lock_pin" name="lock_pin">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="powder" class="form-label">Kadar Konsentrat (Powder)</label>
                <select class="form-select" id="powder" name="powder">
                    <option value="" selected disabled>Select</option>
                    <option value="OK">OK</option>
                    <option value="NG">NG</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12">
        <p><strong>Catatan:</strong> PENGECEKAN ISI JIKA OK TERDENGAR SUARA SERBUK JATUH JIKA NG SUARA SEPERTI BENTURAN.</p>
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