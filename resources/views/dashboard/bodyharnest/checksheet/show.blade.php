@extends('dashboard.app')
@section('title', 'Data Check Sheet Body Harnest')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Detail Check Sheet Body Harnest</h1>
        @can('admin')
            <a href="{{ route('bodyharnest.checksheetbodyharnest.edit', $checksheet->id) }}" class="btn btn-warning">Edit</a>
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
                        <th>No Body Harnest</th>
                        <td>{{ $checksheet->bodyharnest_number }}</td>
                    </tr>
                    <tr>
                        <th>Shoulder Straps</th>
                        @if ($checksheet->shoulder_straps === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->shoulder_straps }}
                            </td>
                        @else
                            <td>{{ $checksheet->shoulder_straps }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Shoulder Straps</th>
                        <td>{{ $checksheet->catatan_shoulder_straps }}</td>
                    </tr>
                    <tr>
                        <th>Photo Shoulder Straps</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_shoulder_straps) }}"
                                alt="Photo Shoulder Straps" style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Hook</th>
                        @if ($checksheet->hook === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->hook }}
                            </td>
                        @else
                            <td>{{ $checksheet->hook }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Hook</th>
                        <td>{{ $checksheet->catatan_hook }}</td>
                    </tr>
                    <tr>
                        <th>Photo Hook</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_hook) }}" alt="Photo Hook"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Buckles Waist</th>
                        @if ($checksheet->buckles_waist === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->buckles_waist }}
                            </td>
                        @else
                            <td>{{ $checksheet->buckles_waist }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Buckles Waist</th>
                        <td>{{ $checksheet->catatan_buckles_waist }}</td>
                    </tr>
                    <tr>
                        <th>Photo Buckles Waist</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_buckles_waist) }}" alt="Photo Buckles Waist"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Buckles Chest</th>
                        @if ($checksheet->buckles_chest === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->buckles_chest }}
                            </td>
                        @else
                            <td>{{ $checksheet->buckles_chest }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Buckles Chest</th>
                        <td>{{ $checksheet->catatan_buckles_chest }}</td>
                    </tr>
                    <tr>
                        <th>Photo Buckles Chest</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_buckles_chest) }}" alt="Photo Buckles Chest"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Leg Straps</th>
                        @if ($checksheet->leg_straps === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->leg_straps }}
                            </td>
                        @else
                            <td>{{ $checksheet->leg_straps }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Leg Straps</th>
                        <td>{{ $checksheet->catatan_leg_straps }}</td>
                    </tr>
                    <tr>
                        <th>Photo Leg Straps</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_leg_straps) }}" alt="Photo Leg Straps"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Buckles Leg</th>
                        @if ($checksheet->buckles_leg === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->buckles_leg }}
                            </td>
                        @else
                            <td>{{ $checksheet->buckles_leg }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Buckles Leg</th>
                        <td>{{ $checksheet->catatan_buckles_leg }}</td>
                    </tr>
                    <tr>
                        <th>Photo Buckles Leg</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_buckles_leg) }}" alt="Photo Buckles Leg"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Back D-Ring</th>
                        @if ($checksheet->back_d_ring === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->back_d_ring }}
                            </td>
                        @else
                            <td>{{ $checksheet->back_d_ring }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Back D-Ring</th>
                        <td>{{ $checksheet->catatan_back_d_ring }}</td>
                    </tr>
                    <tr>
                        <th>Photo Back D-Ring</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_back_d_ring) }}" alt="Photo Back D-Ring"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Carabiner</th>
                        @if ($checksheet->carabiner === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->carabiner }}
                            </td>
                        @else
                            <td>{{ $checksheet->carabiner }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Carabiner</th>
                        <td>{{ $checksheet->catatan_carabiner }}</td>
                    </tr>
                    <tr>
                        <th>Photo Carabiner</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_carabiner) }}" alt="Photo Carabiner"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Straps / Rope</th>
                        @if ($checksheet->straps_rope === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->straps_rope }}
                            </td>
                        @else
                            <td>{{ $checksheet->straps_rope }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Straps / Rope</th>
                        <td>{{ $checksheet->catatan_straps_rope }}</td>
                    </tr>
                    <tr>
                        <th>Photo Straps / Rope</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_straps_rope) }}" alt="Photo Straps / Rope"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Shock Absorber</th>
                        @if ($checksheet->shock_absorber === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->shock_absorber }}
                            </td>
                        @else
                            <td>{{ $checksheet->shock_absorber }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Shock Absorber</th>
                        <td>{{ $checksheet->catatan_shock_absorber }}</td>
                    </tr>
                    <tr>
                        <th>Photo Shock Absorber</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_shock_absorber) }}"
                                alt="Photo Shock Absorber" style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
