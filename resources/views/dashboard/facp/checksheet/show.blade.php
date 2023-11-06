@extends('dashboard.app')
@section('title', 'Data Check Sheet FACP')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Detail Check Sheet FACP</h1>
        @can('admin')
            <a href="{{ route('facp.checksheetfacp.edit', $checksheet->id) }}" class="btn btn-warning">Edit</a>
        @endcan
    </div>
    <div class="card col-md-12">
        <div class="card-body">
            <div class="table-responsive col-md-12">
                <table class="table table-striped table-sm">
                    <tr>
                        <th width='40%'>Tanggal Pengecekan</th>
                        <td>{{ strftime('%e %B %Y', strtotime($checksheet->created_at)) }}</td>
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
                        <th>No Zona</th>
                        <td>{{ $checksheet->zona_number }}</td>
                    </tr>

                    <tr>
                        <th>Jumlah Smoke Detector (OK)</th>
                        <td>{{ $checksheet->ok_smoke_detector }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Smoke Detector (NG)</th>
                        @if ($checksheet->ng_smoke_detector != '0')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->ng_smoke_detector }}
                            </td>
                        @else
                            <td>{{ $checksheet->ng_smoke_detector }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Total Smoke Detector (OK+NG)</th>
                        <td>{{ $checksheet->ok_smoke_detector + $checksheet->ng_smoke_detector }}</td>
                    </tr>
                    <tr>
                        <th>Catatan Smoke Detector</th>
                        <td>{{ $checksheet->catatan_smoke_detector }}</td>
                    </tr>

                    @if ($checksheet->photo_smoke_detector)
                        <tr>
                            <th>Photo Smoke Detector</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_smoke_detector) }}"
                                    alt="Photo Smoke Detector" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <th>Jumlah Heat Detector (OK)</th>
                        <td>{{ $checksheet->ok_heat_detector }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Heat Detector (NG)</th>
                        @if ($checksheet->ng_heat_detector != '0')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->ng_heat_detector }}
                            </td>
                        @else
                            <td>{{ $checksheet->ng_heat_detector }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Total Heat Detector (OK+NG)</th>
                        <td>{{ $checksheet->ok_heat_detector + $checksheet->ng_heat_detector }}</td>
                    </tr>
                    <tr>
                        <th>Catatan Heat Detector</th>
                        <td>{{ $checksheet->catatan_heat_detector }}</td>
                    </tr>

                    @if ($checksheet->photo_heat_detector)
                        <tr>
                            <th>Photo Heat Detector</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_heat_detector) }}"
                                    alt="Photo Heat Detector" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <th>Jumlah Beam Detector (OK)</th>
                        <td>{{ $checksheet->ok_beam_detector }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Beam Detector (NG)</th>
                        @if ($checksheet->ng_beam_detector != '0')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->ng_beam_detector }}
                            </td>
                        @else
                            <td>{{ $checksheet->ng_beam_detector }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Total Beam Detector (OK+NG)</th>
                        <td>{{ $checksheet->ok_beam_detector + $checksheet->ng_beam_detector }}</td>
                    </tr>
                    <tr>
                        <th>Catatan Beam Detector</th>
                        <td>{{ $checksheet->catatan_beam_detector }}</td>
                    </tr>

                    @if ($checksheet->photo_beam_detector)
                        <tr>
                            <th>Photo Beam Detector</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_beam_detector) }}"
                                    alt="Photo Beam Detector" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <th>Jumlah Push Button (OK)</th>
                        <td>{{ $checksheet->ok_push_button }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Push Button (NG)</th>
                        @if ($checksheet->ng_push_button != '0')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->ng_push_button }}
                            </td>
                        @else
                            <td>{{ $checksheet->ng_push_button }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Total Push Button (OK+NG)</th>
                        <td>{{ $checksheet->ok_push_button + $checksheet->ng_push_button }}</td>
                    </tr>
                    <tr>
                        <th>Catatan Push Button</th>
                        <td>{{ $checksheet->catatan_push_button }}</td>
                    </tr>

                    @if ($checksheet->photo_push_button)
                        <tr>
                            <th>Photo Push Button</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_push_button) }}" alt="Photo Push Button"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
@endsection
