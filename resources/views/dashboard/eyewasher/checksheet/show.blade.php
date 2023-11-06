@extends('dashboard.app')
@section('title', 'Data Check Sheet Hydrant')

@section('content')
    @if ($checksheet->eyewashers->type === 'Shower')
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
            <h1>Detail Check Sheet Eyewasher</h1>
            @can('admin')
                <a href="{{ route('eyewasher.checksheetshower.edit', $checksheet->id) }}" class="btn btn-warning">Edit</a>
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
                            <td>{{ $checksheet->eyewasher_number }}</td>
                        </tr>
                        <tr>
                            <th>Location Eyewasher</th>
                            <td>{{ $checksheet->eyewashers->locations->location_name }}</td>
                        </tr>
                        <tr>
                            <th>Plant</th>
                            <td>{{ $checksheet->eyewashers->plant }}</td>
                        </tr>
                        <tr>
                            <th>Instalation Base</th>
                            @if ($checksheet->instalation_base === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->instalation_base }}
                                </td>
                            @else
                                <td>{{ $checksheet->instalation_base }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Instalation Base</th>
                            <td>{{ $checksheet->catatan_instalation_base }}</td>
                        </tr>
                        <tr>
                            <th>Photo Instalation Base</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_instalation_base) }}"
                                    alt="Photo Instalation Base" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Pipa Saluran Air</th>
                            @if ($checksheet->pipa_saluran_air === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->pipa_saluran_air }}
                                </td>
                            @else
                                <td>{{ $checksheet->pipa_saluran_air }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Pipa Saluran Air</th>
                            <td>{{ $checksheet->catatan_pipa_saluran_air }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pipa Saluran Air</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pipa_saluran_air) }}"
                                    alt="Photo Pipa Saluran Air" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Wastafel Eye Wash</th>
                            @if ($checksheet->wastafel_eye_wash === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->wastafel_eye_wash }}
                                </td>
                            @else
                                <td>{{ $checksheet->wastafel_eye_wash }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Wastafel Eye Wash</th>
                            <td>{{ $checksheet->catatan_wastafel_eye_wash }}</td>
                        </tr>
                        <tr>
                            <th>Photo Wastafel Eye Wash</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_wastafel_eye_wash) }}"
                                    alt="Photo Wastafel Eye Wash" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Kran Eye Wash</th>
                            @if ($checksheet->kran_eye_wash === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->kran_eye_wash }}
                                </td>
                            @else
                                <td>{{ $checksheet->kran_eye_wash }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Kran Eye Wash</th>
                            <td>{{ $checksheet->catatan_kran_eye_wash }}</td>
                        </tr>
                        <tr>
                            <th>Photo Kran Eye Wash</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_kran_eye_wash) }}"
                                    alt="Photo Kran Eye Wash" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Tuas Eye Wash</th>
                            @if ($checksheet->tuas_eye_wash === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->tuas_eye_wash }}
                                </td>
                            @else
                                <td>{{ $checksheet->tuas_eye_wash }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Tuas Eye Wash</th>
                            <td>{{ $checksheet->catatan_tuas_eye_wash }}</td>
                        </tr>
                        <tr>
                            <th>Photo Tuas Eye Wash</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_tuas_eye_wash) }}"
                                    alt="Photo Tuas Eye Wash" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Tuas Shower</th>
                            @if ($checksheet->tuas_shower === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->tuas_shower }}
                                </td>
                            @else
                                <td>{{ $checksheet->tuas_shower }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Tuas Shower</th>
                            <td>{{ $checksheet->catatan_tuas_shower }}</td>
                        </tr>
                        <tr>
                            <th>Photo Tuas Shower</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_tuas_shower) }}" alt="Photo Tuas Shower"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Sign</th>
                            @if ($checksheet->sign === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->sign }}
                                </td>
                            @else
                                <td>{{ $checksheet->sign }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Sign</th>
                            <td>{{ $checksheet->catatan_sign }}</td>
                        </tr>
                        <tr>
                            <th>Photo Sign</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_sign) }}"
                                    alt="Photo Rantai Penutup Pilar" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Shower Head</th>
                            @if ($checksheet->shower_head === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->shower_head }}
                                </td>
                            @else
                                <td>{{ $checksheet->shower_head }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Shower Head</th>
                            <td>{{ $checksheet->catatan_shower_head }}</td>
                        </tr>
                        <tr>
                            <th>Photo Shower Head</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_shower_head) }}" alt="Photo Shower Head"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @elseif ($checksheet->eyewashers->type === 'Eyewasher')
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
            <h1>Detail Check Sheet Eyewasher</h1>
            @can('admin')
                <a href="{{ route('eyewasher.checksheeteyewasher.edit', $checksheet->id) }}" class="btn btn-warning">Edit</a>
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
                            <th>Eyewasher Number</th>
                            <td>{{ $checksheet->eyewasher_number }}</td>
                        </tr>
                        <tr>
                            <th>Location Eyewasher</th>
                            <td>{{ $checksheet->eyewashers->locations->location_name }}</td>
                        </tr>
                        <tr>
                            <th>Plant</th>
                            <td>{{ $checksheet->eyewashers->plant }}</td>
                        </tr>
                        <tr>
                            <th>Pijakan</th>
                            @if ($checksheet->pijakan === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->pijakan }}
                                </td>
                            @else
                                <td>{{ $checksheet->pijakan }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Pijakan</th>
                            <td>{{ $checksheet->catatan_pijakan }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pijakan</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pijakan) }}" alt="Photo Pijakan"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Pipa Saluran Air</th>
                            @if ($checksheet->pipa_saluran_air === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->pipa_saluran_air }}
                                </td>
                            @else
                                <td>{{ $checksheet->pipa_saluran_air }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Pipa Saluran Air</th>
                            <td>{{ $checksheet->catatan_pipa_saluran_air }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pipa Saluran Air</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pipa_saluran_air) }}"
                                    alt="Photo Pipa Saluran Air" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Wastafel</th>
                            @if ($checksheet->wastafel === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->wastafel }}
                                </td>
                            @else
                                <td>{{ $checksheet->wastafel }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Wastafel</th>
                            <td>{{ $checksheet->catatan_wastafel }}</td>
                        </tr>
                        <tr>
                            <th>Photo Wastafel</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_wastafel) }}" alt="Photo Wastafel"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Kran Air</th>
                            @if ($checksheet->kran_air === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->kran_air }}
                                </td>
                            @else
                                <td>{{ $checksheet->kran_air }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Kran Air</th>
                            <td>{{ $checksheet->catatan_kran_air }}</td>
                        </tr>
                        <tr>
                            <th>Photo Kran Air</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_kran_air) }}" alt="Photo Kran Air"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Tuas</th>
                            @if ($checksheet->tuas === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->tuas }}
                                </td>
                            @else
                                <td>{{ $checksheet->tuas }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Tuas</th>
                            <td>{{ $checksheet->catatan_tuas }}</td>
                        </tr>
                        <tr>
                            <th>Photo Tuas</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_tuas) }}" alt="Photo Tuas"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
