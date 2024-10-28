@extends('dashboard.app')
@section('title', 'Data Check Sheet Head Crane')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Detail Check Sheet Head Crane</h1>
        @can('admin')
            <a href="{{ route('headcrane.checksheetheadcrane.edit', $checksheet->id) }}" class="btn btn-warning">Edit</a>
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
                        <th>No Head Crane</th>
                        <td>{{ $checksheet->headcrane_number }}</td>
                    </tr>
                    <tr>
                        <th>Cross Travelling</th>
                        @if ($checksheet->cross_travelling === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->cross_travelling }}
                            </td>
                        @else
                            <td>{{ $checksheet->cross_travelling }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Cross Travelling</th>
                        <td>{{ $checksheet->catatan_cross_travelling }}</td>
                    </tr>
                    <tr>
                        <th>Photo Cross Travelling</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_cross_travelling) }}"
                                alt="Photo Cross Travelling" style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Long Travelling</th>
                        @if ($checksheet->long_travelling === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->long_travelling }}
                            </td>
                        @else
                            <td>{{ $checksheet->long_travelling }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Long Travelling</th>
                        <td>{{ $checksheet->catatan_long_travelling }}</td>
                    </tr>
                    <tr>
                        <th>Photo Long Travelling</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_long_travelling) }}"
                                alt="Photo Long Travelling" style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Button Up</th>
                        @if ($checksheet->button_up === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->button_up }}
                            </td>
                        @else
                            <td>{{ $checksheet->button_up }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Button Up</th>
                        <td>{{ $checksheet->catatan_button_up }}</td>
                    </tr>
                    <tr>
                        <th>Photo Button Up</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_button_up) }}" alt="Photo Button Up"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Butoon Down</th>
                        @if ($checksheet->button_down === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->button_down }}
                            </td>
                        @else
                            <td>{{ $checksheet->button_down }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Button Down</th>
                        <td>{{ $checksheet->catatan_button_down }}</td>
                    </tr>
                    <tr>
                        <th>Photo Button Down</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_button_down) }}" alt="Photo Button Down"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Button Push</th>
                        @if ($checksheet->button_push === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->button_push }}
                            </td>
                        @else
                            <td>{{ $checksheet->button_push }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Button Push</th>
                        <td>{{ $checksheet->catatan_button_push }}</td>
                    </tr>
                    <tr>
                        <th>Photo button_push</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_button_push) }}" alt="Photo Button Push"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Wire Rope</th>
                        @if ($checksheet->wire_rope === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->wire_rope }}
                            </td>
                        @else
                            <td>{{ $checksheet->wire_rope }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Wire Rope</th>
                        <td>{{ $checksheet->catatan_wire_rope }}</td>
                    </tr>
                    <tr>
                        <th>Photo Wire Rope</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_wire_rope) }}" alt="Photo Wire Rope"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>block_hook</th>
                        @if ($checksheet->block_hook === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->block_hook }}
                            </td>
                        @else
                            <td>{{ $checksheet->block_hook }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Block Hook</th>
                        <td>{{ $checksheet->catatan_block_hook }}</td>
                    </tr>
                    <tr>
                        <th>Photo Block Hook</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_block_hook) }}" alt="Photo Block Hook"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Hom</th>
                        @if ($checksheet->hom === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->hom }}
                            </td>
                        @else
                            <td>{{ $checksheet->hom }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Hom</th>
                        <td>{{ $checksheet->catatan_hom }}</td>
                    </tr>
                    <tr>
                        <th>Photo Hom</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_hom) }}" alt="Photo Hom"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Emergency Stop</th>
                        @if ($checksheet->emergency_stop === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->emergency_stop }}
                            </td>
                        @else
                            <td>{{ $checksheet->emergency_stop }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Emergency Stop</th>
                        <td>{{ $checksheet->catatan_emergency_stop }}</td>
                    </tr>
                    <tr>
                        <th>Photo Emergency Stop</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_emergency_stop) }}"
                                alt="Photo Emergency Stop" style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
