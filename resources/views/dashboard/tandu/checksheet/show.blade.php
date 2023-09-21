@extends('dashboard.app')
@section('title', 'Data Check Sheet Tandu')

@section('content')
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
            <h1>Detail Check Sheet Tandu</h1>
            <a href="{{ route('co2.checksheetco2.edit', $checksheet->id) }}" class="btn btn-warning">Edit</a>
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
                            <td>{{ $checksheet->tandu_number }}</td>
                        </tr>
                        <tr>
                            <th>Location Nitrogen</th>
                            <td>{{ $checksheet->tandus->locations->location_name }}</td>
                        </tr>
                        <tr>
                            <th>Kunci Pintu</th>
                            <td>{{ $checksheet->kunci_pintu }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Kunci Pintu</th>
                            <td>{{ $checksheet->catatan_kunci_pintu }}</td>
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
                            <td>{{ $checksheet->pintu }}</td>
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
                            <td>{{ $checksheet->sign }}</td>
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
                            <td>{{ $checksheet->hand_grip }}</td>
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
                            <td>{{ $checksheet->body }}</td>
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
                            <td>{{ $checksheet->engsel }}</td>
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
                            <td>{{ $checksheet->kaki }}</td>
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
                            <td>{{ $checksheet->belt }}</td>
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
                            <td>{{ $checksheet->rangka }}</td>
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
