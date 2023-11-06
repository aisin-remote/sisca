@extends('dashboard.app')
@section('title', 'Data Check Sheet Safety Belt')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Detail Check Sheet Safety Belt</h1>
        @can('admin')
            <a href="{{ route('safetybelt.checksheetsafetybelt.edit', $checksheet->id) }}" class="btn btn-warning">Edit</a>
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
                        <th>No Safety Belt</th>
                        <td>{{ $checksheet->safetybelt_number }}</td>
                    </tr>
                    <tr>
                        <th>Buckle</th>
                        @if ($checksheet->buckle === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->buckle }}
                            </td>
                        @else
                            <td>{{ $checksheet->buckle }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Buckle</th>
                        <td>{{ $checksheet->catatan_buckle }}</td>
                    </tr>
                    <tr>
                        <th>Photo Buckle</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_buckle) }}" alt="Photo Buckle"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Seams</th>
                        @if ($checksheet->seams === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->seams }}
                            </td>
                        @else
                            <td>{{ $checksheet->seams }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Seams</th>
                        <td>{{ $checksheet->catatan_seams }}</td>
                    </tr>
                    <tr>
                        <th>Photo Seams</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_seams) }}" alt="Photo Seams"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Reel</th>
                        @if ($checksheet->reel === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->reel }}
                            </td>
                        @else
                            <td>{{ $checksheet->reel }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Reel</th>
                        <td>{{ $checksheet->catatan_reel }}</td>
                    </tr>
                    <tr>
                        <th>Photo Reel</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_reel) }}" alt="Photo Reel"
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
                    <tr>
                        <th>Ring</th>
                        @if ($checksheet->ring === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->ring }}
                            </td>
                        @else
                            <td>{{ $checksheet->ring }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Ring</th>
                        <td>{{ $checksheet->catatan_ring }}</td>
                    </tr>
                    <tr>
                        <th>Photo Ring</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_ring) }}" alt="Photo Ring"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Torso Belt</th>
                        @if ($checksheet->torso_belt === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->torso_belt }}
                            </td>
                        @else
                            <td>{{ $checksheet->torso_belt }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Torso Belt</th>
                        <td>{{ $checksheet->catatan_torso_belt }}</td>
                    </tr>
                    <tr>
                        <th>Photo Torso Belt</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_torso_belt) }}" alt="Photo Torso Belt"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Strap</th>
                        @if ($checksheet->strap === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->strap }}
                            </td>
                        @else
                            <td>{{ $checksheet->strap }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Strap</th>
                        <td>{{ $checksheet->catatan_strap }}</td>
                    </tr>
                    <tr>
                        <th>Photo Strap</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_strap) }}" alt="Photo Strap"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Rope</th>
                        @if ($checksheet->rope === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->rope }}
                            </td>
                        @else
                            <td>{{ $checksheet->rope }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Rope</th>
                        <td>{{ $checksheet->catatan_rope }}</td>
                    </tr>
                    <tr>
                        <th>Photo Rope</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_rope) }}" alt="Photo Rope"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Seam Protection Tube</th>
                        @if ($checksheet->seam_protection_tube === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->seam_protection_tube }}
                            </td>
                        @else
                            <td>{{ $checksheet->seam_protection_tube }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Seam Protection Tube</th>
                        <td>{{ $checksheet->catatan_seam_protection_tube }}</td>
                    </tr>
                    <tr>
                        <th>Photo Seam Protection Tube</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_seam_protection_tube) }}"
                                alt="Photo Seam Protection Tube" style="max-width: 250px; max-height: 300px;"
                                class="img-fluid">
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
                </table>
            </div>
        </div>
    </div>
@endsection
