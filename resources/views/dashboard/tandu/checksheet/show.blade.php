@extends('dashboard.app')
@section('title', 'Data Check Sheet Tandu')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Detail Check Sheet Tandu</h1>
        @can('admin')
            <a href="{{ route('tandu.checksheettandu.edit', $checksheet->id) }}" class="btn btn-warning">Edit</a>
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
                        <th>No Tandu</th>
                        <td>{{ $checksheet->tandu_number }}</td>
                    </tr>
                    <tr>
                        <th>Location Nitrogen</th>
                        <td>{{ $checksheet->tandus->locations->location_name }}</td>
                    </tr>
                    <tr>
                        <th>Kunci Pintu</th>
                        @if ($checksheet->kunci_pintu === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->kunci_pintu }}
                            </td>
                        @else
                            <td>{{ $checksheet->kunci_pintu }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Kunci Pintu</th>
                        @if ($checksheet->catatan_kunci_pintu === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->catatan_kunci_pintu }}
                            </td>
                        @else
                            <td>{{ $checksheet->catatan_kunci_pintu }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Photo Kunci Pintu</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_kunci_pintu) }}" alt="Photo Kunci Pintu"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Pintu</th>
                        @if ($checksheet->pintu === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->pintu }}
                            </td>
                        @else
                            <td>{{ $checksheet->pintu }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Pintu</th>
                        <td>{{ $checksheet->catatan_pintu }}</td>
                    </tr>
                    <tr>
                        <th>Photo Pintu</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_pintu) }}" alt="Photo Pintu"
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
                            <img src="{{ asset('storage/' . $checksheet->photo_sign) }}" alt="Photo Sign"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Hand Grip</th>
                        @if ($checksheet->hand_grip === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->hand_grip }}
                            </td>
                        @else
                            <td>{{ $checksheet->hand_grip }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Hand Grip</th>
                        <td>{{ $checksheet->catatan_hand_grip }}</td>
                    </tr>
                    <tr>
                        <th>Photo Hand Grip</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_hand_grip) }}" alt="Photo Hand Grip"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Body</th>
                        @if ($checksheet->body === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->body }}
                            </td>
                        @else
                            <td>{{ $checksheet->body }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Body</th>
                        <td>{{ $checksheet->catatan_body }}</td>
                    </tr>
                    <tr>
                        <th>Photo Body</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_body) }}" alt="Photo Body"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Engsel</th>
                        @if ($checksheet->engsel === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->engsel }}
                            </td>
                        @else
                            <td>{{ $checksheet->engsel }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Engsel</th>
                        <td>{{ $checksheet->catatan_engsel }}</td>
                    </tr>
                    <tr>
                        <th>Photo Engsel</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_engsel) }}" alt="Photo Engsel"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Kaki</th>
                        @if ($checksheet->kaki === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->kaki }}
                            </td>
                        @else
                            <td>{{ $checksheet->kaki }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Kaki</th>
                        <td>{{ $checksheet->catatan_kaki }}</td>
                    </tr>
                    <tr>
                        <th>Photo Kaki</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_kaki) }}" alt="Photo Kaki"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Belt</th>
                        @if ($checksheet->belt === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->belt }}
                            </td>
                        @else
                            <td>{{ $checksheet->belt }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Belt</th>
                        <td>{{ $checksheet->catatan_belt }}</td>
                    </tr>
                    <tr>
                        <th>Photo Belt</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_belt) }}" alt="Photo Belt"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Rangka</th>
                        @if ($checksheet->rangka === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->rangka }}
                            </td>
                        @else
                            <td>{{ $checksheet->rangka }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Rangka</th>
                        <td>{{ $checksheet->catatan_rangka }}</td>
                    </tr>
                    <tr>
                        <th>Photo Rangka</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_rangka) }}" alt="Photo Rangka"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
