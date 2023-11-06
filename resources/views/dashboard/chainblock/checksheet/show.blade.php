@extends('dashboard.app')
@section('title', 'Data Check Sheet Chain Block')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Detail Check Sheet Chain Block</h1>
        @can('admin')
            <a href="{{ route('chainblock.checksheetchainblock.edit', $checksheet->id) }}" class="btn btn-warning">Edit</a>
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
                        <th>No Chain Block</th>
                        <td>{{ $checksheet->chainblock_number }}</td>
                    </tr>
                    <tr>
                        <th>Geared Trolley</th>
                        @if ($checksheet->geared_trolley === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->geared_trolley }}
                            </td>
                        @else
                            <td>{{ $checksheet->geared_trolley }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Geared Trolley</th>
                        <td>{{ $checksheet->catatan_geared_trolley }}</td>
                    </tr>
                    <tr>
                        <th>Photo Geared Trolley</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_geared_trolley) }}"
                                alt="Photo Geared Trolley" style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Gerakan Halus</th>
                        @if ($checksheet->chain_geared_trolley_1 === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->chain_geared_trolley_1 }}
                            </td>
                        @else
                            <td>{{ $checksheet->chain_geared_trolley_1 }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Gerakan Halus</th>
                        <td>{{ $checksheet->catatan_chain_geared_trolley_1 }}</td>
                    </tr>
                    <tr>
                        <th>Photo Gerakan Halus</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_chain_geared_trolley_1) }}"
                                alt="Photo Gerakan Halus" style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Chain Geared Trolley 2</th>
                        @if ($checksheet->chain_geared_trolley_2 === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->chain_geared_trolley_2 }}
                            </td>
                        @else
                            <td>{{ $checksheet->chain_geared_trolley_2 }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Chain Geared Trolley 2</th>
                        <td>{{ $checksheet->catatan_chain_geared_trolley_2 }}</td>
                    </tr>
                    <tr>
                        <th>Photo Chain Geared Trolley 2</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_chain_geared_trolley_2) }}"
                                alt="Photo Chain Geared Trolley 2" style="max-width: 250px; max-height: 300px;"
                                class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Hooking Geared Trolly</th>
                        @if ($checksheet->hooking_geared_trolly === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->hooking_geared_trolly }}
                            </td>
                        @else
                            <td>{{ $checksheet->hooking_geared_trolly }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Hooking Geared Trolly</th>
                        <td>{{ $checksheet->catatan_hooking_geared_trolly }}</td>
                    </tr>
                    <tr>
                        <th>Photo Hooking Geared Trolly</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_hooking_geared_trolly) }}"
                                alt="Photo Hooking Geared Trolly" style="max-width: 250px; max-height: 300px;"
                                class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Latch Hook Atas</th>
                        @if ($checksheet->latch_hook_atas === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->latch_hook_atas }}
                            </td>
                        @else
                            <td>{{ $checksheet->latch_hook_atas }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Latch Hook Atas</th>
                        <td>{{ $checksheet->catatan_latch_hook_atas }}</td>
                    </tr>
                    <tr>
                        <th>Photo Latch Hook Atas</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_latch_hook_atas) }}"
                                alt="Photo Latch Hook Atas" style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Hook Atas</th>
                        @if ($checksheet->hook_atas === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->hook_atas }}
                            </td>
                        @else
                            <td>{{ $checksheet->hook_atas }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Hook Atas</th>
                        <td>{{ $checksheet->catatan_hook_atas }}</td>
                    </tr>
                    <tr>
                        <th>Photo Hook Atas</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_hook_atas) }}" alt="Photo Hook Atas"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Hand Chain</th>
                        @if ($checksheet->hand_chain === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->hand_chain }}
                            </td>
                        @else
                            <td>{{ $checksheet->hand_chain }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Hand Chain</th>
                        <td>{{ $checksheet->catatan_hand_chain }}</td>
                    </tr>
                    <tr>
                        <th>Photo Hand Chain</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_hand_chain) }}" alt="Photo Hand Chain"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Load Chain</th>
                        @if ($checksheet->load_chain === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->load_chain }}
                            </td>
                        @else
                            <td>{{ $checksheet->load_chain }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Load Chain</th>
                        <td>{{ $checksheet->catatan_load_chain }}</td>
                    </tr>
                    <tr>
                        <th>Photo Load Chain</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_load_chain) }}" alt="Photo Load Chain"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Latch Hook Bawah</th>
                        @if ($checksheet->latch_hook_bawah === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->latch_hook_bawah }}
                            </td>
                        @else
                            <td>{{ $checksheet->latch_hook_bawah }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Latch Hook Bawah</th>
                        <td>{{ $checksheet->catatan_latch_hook_bawah }}</td>
                    </tr>
                    <tr>
                        <th>Photo Latch Hook Bawah</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_latch_hook_bawah) }}"
                                alt="Photo Latch Hook Bawah" style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                    <tr>
                        <th>Hook Bawah</th>
                        @if ($checksheet->hook_bawah === 'NG')
                            <td class="text-danger fw-bolder">
                                {{ $checksheet->hook_bawah }}
                            </td>
                        @else
                            <td>{{ $checksheet->hook_bawah }}</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Catatan Hook Bawah</th>
                        <td>{{ $checksheet->catatan_hook_bawah }}</td>
                    </tr>
                    <tr>
                        <th>Photo Hook Bawah</th>
                        <td>
                            <img src="{{ asset('storage/' . $checksheet->photo_hook_bawah) }}" alt="Photo Hook Bawah"
                                style="max-width: 250px; max-height: 300px;" class="img-fluid">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
