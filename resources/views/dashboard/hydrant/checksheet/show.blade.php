@extends('dashboard.app')
@section('title', 'Data Check Sheet Hydrant')

@section('content')
    @if ($checksheet->hydrants->type === 'Outdoor')
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
            <h1>Detail Check Sheet Outdoor</h1>
            @can('admin')
                <a href="{{ route('hydrant.checksheetoutdoor.edit', $checksheet->id) }}" class="btn btn-warning">Edit</a>
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
                            <th>Hydrant Number</th>
                            <td>{{ $checksheet->hydrant_number }}</td>
                        </tr>
                        <tr>
                            <th>Location Hydrant</th>
                            <td>{{ $checksheet->hydrants->locations->location_name }}</td>
                        </tr>
                        <tr>
                            <th>Pintu Hydrant</th>
                            @if ($checksheet->pintu === 'NG')
                                <td class="text-danger fw-bolder">{{ $checksheet->pintu }}</td>
                            @else
                                <td>{{ $checksheet->pintu }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Pintu Hydrant</th>
                            <td>{{ $checksheet->catatan_pintu }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pintu Hydrant</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pintu) }}" alt="Photo Pintu Hydrant"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Nozzle</th>
                            @if ($checksheet->nozzle === 'NG')
                                <td class="text-danger fw-bolder">{{ $checksheet->nozzle }}</td>
                            @else
                                <td>{{ $checksheet->nozzle }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Nozzle</th>
                            <td>{{ $checksheet->catatan_nozzle }}</td>
                        </tr>
                        <tr>
                            <th>Photo Nozzle</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_nozzle) }}" alt="Photo Nozzle"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
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
                        <tr>
                            <th>Tuas Pilar</th>
                            @if ($checksheet->tuas === 'NG')
                                <td class="text-danger fw-bolder">{{ $checksheet->tuas }}</td>
                            @else
                                <td>{{ $checksheet->tuas }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Tuas Pilar</th>
                            <td>{{ $checksheet->catatan_tuas }}</td>
                        </tr>
                        <tr>
                            <th>Photo Tuas Pilar</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_tuas) }}" alt="Photo Tuas Pilar"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Pilar</th>
                            @if ($checksheet->pilar === 'NG')
                                <td class="text-danger fw-bolder">{{ $checksheet->pilar }}</td>
                            @else
                                <td>{{ $checksheet->pilar }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Pilar</th>
                            <td>{{ $checksheet->catatan_pilar }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pilar</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pilar) }}" alt="Photo Pilar"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Penutup Pilar</th>
                            @if ($checksheet->penutup === 'NG')
                                <td class="text-danger fw-bolder">{{ $checksheet->penutup }}</td>
                            @else
                                <td>{{ $checksheet->penutup }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Penutup Pilar</th>
                            <td>{{ $checksheet->catatan_penutup }}</td>
                        </tr>
                        <tr>
                            <th>Photo Penutup Pilar</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_penutup) }}" alt="Photo Penutup Pilar"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Rantai Penutup Pilar</th>
                            @if ($checksheet->rantai === 'NG')
                                <td class="text-danger fw-bolder">{{ $checksheet->rantai }}</td>
                            @else
                                <td>{{ $checksheet->rantai }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Rantai Penutup Pilar</th>
                            <td>{{ $checksheet->catatan_rantai }}</td>
                        </tr>
                        <tr>
                            <th>Photo Rantai Penutup Pilar</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_rantai) }}"
                                    alt="Photo Rantai Penutup Pilar" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Kopling/Kupla</th>
                            @if ($checksheet->kupla === 'NG')
                                <td class="text-danger fw-bolder">{{ $checksheet->kupla }}</td>
                            @else
                                <td>{{ $checksheet->kupla }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Kopling/Kupla</th>
                            <td>{{ $checksheet->catatan_kupla }}</td>
                        </tr>
                        <tr>
                            <th>Photo Kopling/Kupla</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_kupla) }}" alt="Photo Kopling/Kupla"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @elseif ($checksheet->hydrants->type === 'Indoor')
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
            <h1>Detail Check Sheet Hydrant Indoor</h1>
            @can('admin')
                <a href="{{ route('hydrant.checksheetindoor.edit', $checksheet->id) }}" class="btn btn-warning">Edit</a>
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
                            <th>Hydrant Number</th>
                            <td>{{ $checksheet->hydrant_number }}</td>
                        </tr>
                        <tr>
                            <th>Location Apar</th>
                            <td>{{ $checksheet->hydrants->locations->location_name }}</td>
                        </tr>
                        <tr>
                            <th>Pintu Hydrant</th>
                            @if ($checksheet->pintu === 'NG')
                                <td class="text-danger fw-bolder">{{ $checksheet->pintu }}</td>
                            @else
                                <td>{{ $checksheet->pintu }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Pintu Hydrant</th>
                            <td>{{ $checksheet->catatan_pintu }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pintu Hydrant</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pintu) }}" alt="Photo Pintu Hydrant"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Lampu</th>
                            @if ($checksheet->lampu === 'NG')
                                <td class="text-danger fw-bolder">{{ $checksheet->lampu }}</td>
                            @else
                                <td>{{ $checksheet->lampu }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Lampu</th>
                            <td>{{ $checksheet->catatan_lampu }}</td>
                        </tr>
                        <tr>
                            <th>Photo Lampu</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_lampu) }}" alt="Photo Lampu"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Tombol Emergency</th>
                            @if ($checksheet->emergency === 'NG')
                                <td class="text-danger fw-bolder">{{ $checksheet->emergency }}</td>
                            @else
                                <td>{{ $checksheet->emergency }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Tombol Emergency</th>
                            <td>{{ $checksheet->catatan_emergency }}</td>
                        </tr>
                        <tr>
                            <th>Photo Tombol Emergency</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_emergency) }}"
                                    alt="Photo Tombol Emergency" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Nozzle</th>
                            @if ($checksheet->nozzle === 'NG')
                                <td class="text-danger fw-bolder">{{ $checksheet->nozzle }}</td>
                            @else
                                <td>{{ $checksheet->nozzle }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Nozzle</th>
                            <td>{{ $checksheet->catatan_nozzle }}</td>
                        </tr>
                        <tr>
                            <th>Photo Nozzle</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_nozzle) }}" alt="Photo Nozzle"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
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
                        <tr>
                            <th>Valve</th>
                            @if ($checksheet->valve === 'NG')
                                <td class="text-danger fw-bolder">{{ $checksheet->valve }}</td>
                            @else
                                <td>{{ $checksheet->valve }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Valve</th>
                            <td>{{ $checksheet->catatan_valve }}</td>
                        </tr>
                        <tr>
                            <th>Photo Valve</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_valve) }}" alt="Photo Valve"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Coupling/Sambungan</th>
                            @if ($checksheet->coupling === 'NG')
                                <td class="text-danger fw-bolder">{{ $checksheet->coupling }}</td>
                            @else
                                <td>{{ $checksheet->coupling }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Coupling/Sambungan</th>
                            <td>{{ $checksheet->catatan_coupling }}</td>
                        </tr>
                        <tr>
                            <th>Photo Coupling/Sambungan</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_coupling) }}"
                                    alt="Photo Coupling/Sambungan" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Pressure</th>
                            @if ($checksheet->pressure === 'NG')
                                <td class="text-danger fw-bolder">{{ $checksheet->pressure }}</td>
                            @else
                                <td>{{ $checksheet->pressure }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Pressure</th>
                            <td>{{ $checksheet->catatan_pressure }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pressure</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pressure) }}" alt="Photo Pressure"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Kopling/Kupla</th>
                            @if ($checksheet->kupla === 'NG')
                                <td class="text-danger fw-bolder">{{ $checksheet->kupla }}</td>
                            @else
                                <td>{{ $checksheet->kupla }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Kopling/Kupla</th>
                            <td>{{ $checksheet->catatan_kupla }}</td>
                        </tr>
                        <tr>
                            <th>Photo Kopling/Kupla</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_kupla) }}" alt="Photo Kopling/Kupla"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
