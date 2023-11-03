@extends('dashboard.app')
@section('title', 'Data Check Sheet Co2')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Detail Check Sheet Co2</h1>
        @can('admin')
            <a href="{{ route('co2.checksheetco2.edit', $checksheet->id) }}" class="btn btn-warning">Edit</a>
        @endcan
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
                        <th>No Tabung</th>
                        <td>{{ $checksheet->tabung_number }}</td>
                    </tr>
                    <tr>
                        <th>Location Nitrogen</th>
                        <td>{{ $checksheet->co2s->locations->location_name }}</td>
                    </tr>
                    <tr>
                        <th>Cover</th>
                        @if ($checksheet->cover === 'NG')
                            <td class="text-danger fw-bolder">{{ $checksheet->cover }}</td>
                        @else
                            <td>{{ $checksheet->cover }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Cover</th>
                        <td>{{ $checksheet->catatan_cover }}</td>
                    </tr>
                    <tr>
                        <th>Photo Cover</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_cover) }}" alt="Photo Cover"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Tabung</th>
                        @if ($checksheet->tabung === 'NG')
                            <td class="text-danger fw-bolder">{{ $checksheet->tabung }}</td>
                        @else
                            <td>{{ $checksheet->tabung }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Tabung</th>
                        <td>{{ $checksheet->catatan_tabung }}</td>
                    </tr>
                    <tr>
                        <th>Photo Tabung</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_tabung) }}" alt="Photo Tabung"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Lock Pin</th>
                        @if ($checksheet->lock_pin === 'NG')
                            <td class="text-danger fw-bolder">{{ $checksheet->lock_pin }}</td>
                        @else
                            <td>{{ $checksheet->lock_pin }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Lock Pin</th>
                        <td>{{ $checksheet->catatan_lock_pin }}</td>
                    </tr>
                    <tr>
                        <th>Photo Lock Pin</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_lock_pin) }}" alt="Photo Lock Pin"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Segel Lock Pin</th>
                        @if ($checksheet->segel_lock_pin === 'NG')
                            <td class="text-danger fw-bolder">{{ $checksheet->segel_lock_pin }}</td>
                        @else
                            <td>{{ $checksheet->segel_lock_pin }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Segel Lock Pin</th>
                        <td>{{ $checksheet->catatan_segel_lock_pin }}</td>
                    </tr>
                    <tr>
                        <th>Photo Segel Lock Pin</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_segel_lock_pin) }}"
                                alt="Photo Segel Lock Pin" style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Kebocoran Regulator Tabung</th>
                        @if ($checksheet->kebocoran_regulator_tabung === 'NG')
                            <td class="text-danger fw-bolder">{{ $checksheet->kebocoran_regulator_tabung }}</td>
                        @else
                            <td>{{ $checksheet->kebocoran_regulator_tabung }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Kebocoran Regulator Tabung</th>
                        <td>{{ $checksheet->catatan_kebocoran_regulator_tabung }}</td>
                    </tr>
                    <tr>
                        <th>Photo Kebocoran Regulator Tabung</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_kebocoran_regulator_tabung) }}"
                                alt="Photo Kebocoran Regulator Tabung" style="max-width: 250px; max-height: 300px;"
                                class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Selang</th>
                        @if ($checksheet->selang === 'NG')
                            <td class="text-danger fw-bolder">{{ $checksheet->selang }}</td>
                        @else
                            <td>{{ $checksheet->selang }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Selang</th>
                        <td>{{ $checksheet->catatan_selang }}</td>
                    </tr>
                    <tr>
                        <th>Photo Selang</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_selang) }}" alt="Photo Selang"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
