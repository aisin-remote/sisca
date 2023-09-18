@extends('dashboard.app')
@section('title', 'Data Check Sheet Nitrogen')

@section('content')
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
            <h1>Detail Check Sheet Nitrogen</h1>
            <a href="{{ route('nitrogen.checksheetnitrogen.edit', $checksheet->id) }}" class="btn btn-warning">Edit</a>
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
                            <td>{{ $checksheet->nitrogens->locations->location_name }}</td>
                        </tr>
                        <tr>
                            <th>Sistem Operasional</th>
                            <td>{{ $checksheet->operasional }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Sistem Operasional</th>
                            <td>{{ $checksheet->catatan_operasional }}</td>
                        </tr>
                        <tr>
                            <th>Photo Sistem Operasional</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_operasional) }}" alt="Photo Operasional"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Selector Mode</th>
                            <td>{{ $checksheet->selector_mode }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Selector Mode</th>
                            <td>{{ $checksheet->catatan_selector_mode }}</td>
                        </tr>
                        <tr>
                            <th>Photo Selector Mode</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_selector_mode) }}" alt="Photo Selector Mode"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Pintu Tabung</th>
                            <td>{{ $checksheet->pintu_tabung }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Pintu Tabung</th>
                            <td>{{ $checksheet->catatan_pintu_tabung }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pintu Tabung</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pintu_tabung) }}" alt="Photo Pintu Tabung"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Pressure Tabung Pilot Nitrogen</th>
                            <td>{{ $checksheet->pressure_pilot }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Tabung Pilot Nitrogen</th>
                            <td>{{ $checksheet->catatan_pressure_pilot }}</td>
                        </tr>
                        <tr>
                            <th>Photo Tabung Pilot Nitrogen</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pressure_pilot) }}" alt="Photo Pressure Pilot"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Pressure Tabung Nitrogen No 1</th>
                            <td>{{ $checksheet->pressure_no1 }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Pressure Tabung Nitrogen No 1</th>
                            <td>{{ $checksheet->catatan_pressure_no1 }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pressure Tabung Nitrogen No 1</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pressure_no1) }}" alt="Photo Pressure No 1"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Pressure Tabung Nitrogen No 2</th>
                            <td>{{ $checksheet->pressure_no2 }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Pressure Tabung Nitrogen No 2</th>
                            <td>{{ $checksheet->catatan_pressure_no2 }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pressure Tabung Nitrogen No 2</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pressure_no2) }}" alt="Photo Pressure No 2"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Pressure Tabung Nitrogen No 3</th>
                            <td>{{ $checksheet->pressure_no3 }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Pressure Tabung Nitrogen No 3</th>
                            <td>{{ $checksheet->catatan_pressure_no3 }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pressure Tabung Nitrogen No 3</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pressure_no3) }}" alt="Photo Pressure No 3"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Pressure Tabung Nitrogen No 4</th>
                            <td>{{ $checksheet->pressure_no4 }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Pressure Tabung Nitrogen No 4</th>
                            <td>{{ $checksheet->catatan_pressure_no4 }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pressure Tabung Nitrogen No 4</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pressure_no4) }}" alt="Photo Pressure No 4"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Pressure Tabung Nitrogen No 5</th>
                            <td>{{ $checksheet->pressure_no5 }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Pressure Tabung Nitrogen No 5</th>
                            <td>{{ $checksheet->catatan_pressure_no5 }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pressure Tabung Nitrogen No 5</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pressure_no5) }}" alt="Photo Pressure No 5"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
@endsection
