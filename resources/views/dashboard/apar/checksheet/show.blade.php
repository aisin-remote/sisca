@extends('dashboard.app')
@section('title', 'Data Check Sheet Apar')

@section('content')
    @if ($checksheet->apars->type === 'powder')
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
            <h1>Detail Check Sheet Powder</h1>
            <a href="{{ route('apar.checksheetpowder.edit', $checksheet->id) }}" class="btn btn-warning">Edit</a>
        </div>
        <div class="card col-md-12">
            <div class="card-body">
                <div class="table-responsive col-md-12">
                    <table class="table table-striped table-sm">
                        <tr>
                            <th width='40%'>Tanggal Pengecekan</th>
                            <td>{{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diupdate</th>
                            <td>{{ strftime('%e %B %Y', strtotime($checksheet->updated_at)) }}</td>
                        </tr>
                        <tr>
                            <th>NPK</th>
                            <td>{{ $checksheet->npk }}</td>
                        </tr>
                        <tr>
                            <th>APAR Number</th>
                            <td>{{ $checksheet->apar_number }}</td>
                        </tr>
                        <tr>
                            <th>Location Apar</th>
                            <td>{{ $checksheet->apars->locations->location_name }}</td>
                        </tr>
                        <tr>
                            <th>Pressure</th>
                            <td>{{ $checksheet->pressure }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Pressure</th>
                            <td>{{ $checksheet->catatan_pressure }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pressure</th>
                            <td>
                                <img src="{{ asset('storage/app/' . $checksheet->photo_pressure) }}" alt="Photo Powder"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Hose</th>
                            <td>{{ $checksheet->hose }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Hose</th>
                            <td>{{ $checksheet->catatan_hose }}</td>
                        </tr>
                        <tr>
                            <th>Photo Hose</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_hose) }}" alt="Photo Powder"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Tabung</th>
                            <td>{{ $checksheet->tabung }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Tabung</th>
                            <td>{{ $checksheet->catatan_tabung }}</td>
                        </tr>
                        <tr>
                            <th>Photo Tabung</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_tabung) }}" alt="Photo Powder"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Regulator</th>
                            <td>{{ $checksheet->regulator }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Regulator</th>
                            <td>{{ $checksheet->catatan_regulator }}</td>
                        </tr>
                        <tr>
                            <th>Photo Regulator</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_regulator) }}" alt="Photo Powder"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Lock Pin</th>
                            <td>{{ $checksheet->lock_pin }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Lock Pin</th>
                            <td>{{ $checksheet->catatan_lock_pin }}</td>
                        </tr>
                        <tr>
                            <th>Photo Lock Pin</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_lock_pin) }}" alt="Photo Powder"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Powder</th>
                            <td>{{ $checksheet->powder }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Powder</th>
                            <td>{{ $checksheet->catatan_powder }}</td>
                        </tr>
                        <tr>
                            <th>Photo Powder</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_powder) }}" alt="Photo Powder"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @elseif ($checksheet->apars->type === 'co2' || $checksheet->apars->type === 'af11e')
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
            <h1>Detail Check Sheet Co2/AF11E</h1>
            <a href="{{ route('apar.checksheetco2.edit', $checksheet->id) }}" class="btn btn-warning">Edit</a>
        </div>
        <div class="card col-md-12">
            <div class="card-body">
                <div class="table-responsive col-md-12">
                    <table class="table table-striped table-sm">
                        <tr>
                            <th width='40%'>Tanggal Pengecekan</th>
                            <td>{{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diupdate</th>
                            <td>{{ strftime('%e %B %Y', strtotime($checksheet->updated_at)) }}</td>
                        </tr>
                        <tr>
                            <th>NPK</th>
                            <td>{{ $checksheet->npk }}</td>
                        </tr>
                        <tr>
                            <th>APAR Number</th>
                            <td>{{ $checksheet->apar_number }}</td>
                        </tr>
                        <tr>
                            <th>Location Apar</th>
                            <td>{{ $checksheet->apars->locations->location_name }}</td>
                        </tr>
                        <tr>
                            <th>Pressure</th>
                            <td>{{ $checksheet->pressure }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Pressure</th>
                            <td>{{ $checksheet->catatan_pressure }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pressure</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pressure) }}" alt="Photo Powder"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Hose</th>
                            <td>{{ $checksheet->hose }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Hose</th>
                            <td>{{ $checksheet->catatan_hose }}</td>
                        </tr>
                        <tr>
                            <th>Photo Hose</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_hose) }}" alt="Photo Powder"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Corong</th>
                            <td>{{ $checksheet->corong }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Corong</th>
                            <td>{{ $checksheet->catatan_corong }}</td>
                        </tr>
                        <tr>
                            <th>Photo Corong</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_corong) }}" alt="Photo Powder"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Tabung</th>
                            <td>{{ $checksheet->tabung }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Tabung</th>
                            <td>{{ $checksheet->catatan_tabung }}</td>
                        </tr>
                        <tr>
                            <th>Photo Tabung</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_tabung) }}" alt="Photo Powder"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Regulator</th>
                            <td>{{ $checksheet->regulator }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Regulator</th>
                            <td>{{ $checksheet->catatan_regulator }}</td>
                        </tr>
                        <tr>
                            <th>Photo Regulator</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_regulator) }}" alt="Photo Powder"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Lock Pin</th>
                            <td>{{ $checksheet->lock_pin }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Lock Pin</th>
                            <td>{{ $checksheet->catatan_lock_pin }}</td>
                        </tr>
                        <tr>
                            <th>Photo Lock Pin</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_lock_pin) }}" alt="Photo Powder"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Berat Tabung</th>
                            <td>{{ $checksheet->berat_tabung }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Berat Tabung</th>
                            <td>{{ $checksheet->catatan_berat_tabung }}</td>
                        </tr>
                        <tr>
                            <th>Photo Berat Tabung</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_berat_tabung) }}" alt="Photo Powder"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
