@extends('dashboard.app')
@section('title', 'Data Check Sheet Sling')

@section('content')
    @if ($checksheet->slings->type === 'Sling Wire')
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
            <h1>Detail Check Sheet Sling</h1>
            <a href="{{ route('sling.checksheetwire.edit', $checksheet->id) }}" class="btn btn-warning">Edit</a>
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
                            <th>Sling Number</th>
                            <td>{{ $checksheet->sling_number }}</td>
                        </tr>
                        <tr>
                            <th>Location Sling</th>
                            <td>{{ $checksheet->slings->locations->location_name }}</td>
                        </tr>
                        <tr>
                            <th>Plant</th>
                            <td>{{ $checksheet->slings->plant }}</td>
                        </tr>
                        <tr>
                            <th>Serabut Wire</th>
                            <td>{{ $checksheet->serabut_wire }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Serabut Wire</th>
                            <td>{{ $checksheet->catatan_serabut_wire }}</td>
                        </tr>
                        <tr>
                            <th>Photo Serabut Wire</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_serabut_wire) }}" alt="Photo Serabut Wire"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Bagian Wire 1</th>
                            <td>{{ $checksheet->bagian_wire_1 }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Bagian Wire 1</th>
                            <td>{{ $checksheet->catatan_bagian_wire_1 }}</td>
                        </tr>
                        <tr>
                            <th>Photo Bagian Wire 1</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_bagian_wire_1) }}" alt="Photo Bagian Wire 1"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Bagian Wire 2</th>
                            <td>{{ $checksheet->bagian_wire_2 }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Bagian Wire 2</th>
                            <td>{{ $checksheet->catatan_bagian_wire_2 }}</td>
                        </tr>
                        <tr>
                            <th>Photo Bagian Wire 2</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_bagian_wire_2) }}" alt="Photo Bagian Wire 2"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Kumpulan Wire 1</th>
                            <td>{{ $checksheet->kumpulan_wire_1 }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Kumpulan Wire 1</th>
                            <td>{{ $checksheet->catatan_kumpulan_wire_1 }}</td>
                        </tr>
                        <tr>
                            <th>Photo Kumpulan Wire 1</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_kumpulan_wire_1) }}" alt="Photo Kumpulan Wire 1"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Diameter Wire</th>
                            <td>{{ $checksheet->diameter_wire }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Diameter Wire</th>
                            <td>{{ $checksheet->catatan_diameter_wire }}</td>
                        </tr>
                        <tr>
                            <th>Photo Diameter Wire</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_diameter_wire) }}" alt="Photo Diameter Wire"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Kumpulan Wire 2</th>
                            <td>{{ $checksheet->kumpulan_wire_2 }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Kumpulan Wire 2</th>
                            <td>{{ $checksheet->catatan_kumpulan_wire_2 }}</td>
                        </tr>
                        <tr>
                            <th>Photo Kumpulan Wire 2</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_kumpulan_wire_2) }}" alt="Photo Kumpulan Wire 2"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>

                        <tr>
                            <th>Hook Wire</th>
                            <td>{{ $checksheet->hook_wire }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Hook Wire</th>
                            <td>{{ $checksheet->catatan_hook_wire }}</td>
                        </tr>
                        <tr>
                            <th>Photo Hook Wire</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_hook_wire) }}" alt="Photo Hook Wire"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>

                        <tr>
                            <th>Pengunci Hook</th>
                            <td>{{ $checksheet->mata_sling }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Pengunci Hook</th>
                            <td>{{ $checksheet->catatan_mata_sling }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pengunci Hook</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pengunci_hook) }}" alt="Photo Pengunci Hook"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>


                        <tr>
                            <th>Mata Sling</th>
                            <td>{{ $checksheet->mata_sling }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Mata Sling</th>
                            <td>{{ $checksheet->catatan_mata_sling }}</td>
                        </tr>
                        <tr>
                            <th>Photo Mata Sling</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_mata_sling) }}" alt="Photo Mata Sling"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @elseif ($checksheet->slings->type === 'Eyewasher')
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
            <h1>Detail Check Sheet Eyewasher</h1>
            <a href="{{ route('eyewasher.checksheeteyewasher.edit', $checksheet->id) }}" class="btn btn-warning">Edit</a>
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
                            <td>{{ $checksheet->pijakan }}</td>
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
                            <td>{{ $checksheet->pipa_saluran_air }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Pipa Saluran Air</th>
                            <td>{{ $checksheet->catatan_pipa_saluran_air }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pipa Saluran Air</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pipa_saluran_air) }}" alt="Photo Pipa Saluran Air"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Wastafel</th>
                            <td>{{ $checksheet->wastafel }}</td>
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
                            <td>{{ $checksheet->kran_air }}</td>
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
                            <td>{{ $checksheet->tuas }}</td>
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
