@extends('dashboard.app')
@section('title', 'Data Check Sheet Tembin')

@section('content')
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
            <h1>Detail Check Sheet Tembin</h1>
            <a href="{{ route('tembin.checksheettembin.edit', $checksheet->id) }}" class="btn btn-warning">Edit</a>
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
                            <th>No Equip</th>
                            <td>{{ $checksheet->tembin_number }}</td>
                        </tr>
                        <tr>
                            <th>Master Link</th>
                            <td>{{ $checksheet->master_link }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Master Link</th>
                            <td>{{ $checksheet->catatan_master_link }}</td>
                        </tr>
                        <tr>
                            <th>Photo Master Link</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_master_link) }}" alt="Photo Master Link"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Body Tembin</th>
                            <td>{{ $checksheet->body_tembin }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Body Tembin</th>
                            <td>{{ $checksheet->catatan_body_tembin }}</td>
                        </tr>
                        <tr>
                            <th>Photo Body Tembin</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_body_tembin) }}" alt="Photo Body Tembin"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Mur & Baut</th>
                            <td>{{ $checksheet->mur_baut }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Mur & Baut</th>
                            <td>{{ $checksheet->catatan_mur_baut }}</td>
                        </tr>
                        <tr>
                            <th>Photo Mur & Baut</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_mur_baut) }}" alt="Photo Mur & Baut"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Shackle</th>
                            <td>{{ $checksheet->shackle }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Shackle</th>
                            <td>{{ $checksheet->catatan_shackle }}</td>
                        </tr>
                        <tr>
                            <th>Photo Shackle</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_shackle) }}" alt="Photo Shackle"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Hook Atas</th>
                            <td>{{ $checksheet->hook_atas }}</td>
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
                            <th>Pengunci Hook Atas</th>
                            <td>{{ $checksheet->pengunci_hook_atas }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Pengunci Hook Atas</th>
                            <td>{{ $checksheet->catatan_pengunci_hook_atas }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pengunci Hook Atas</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pengunci_hook_atas) }}" alt="Photo Pengunci Hook Atas"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Mata Chain</th>
                            <td>{{ $checksheet->mata_chain }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Mata Chain</th>
                            <td>{{ $checksheet->catatan_mata_chain }}</td>
                        </tr>
                        <tr>
                            <th>Photo Mata Chain</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_mata_chain) }}" alt="Photo Mata Chain"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Chain</th>
                            <td>{{ $checksheet->chain }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Chain</th>
                            <td>{{ $checksheet->catatan_chain }}</td>
                        </tr>
                        <tr>
                            <th>Photo Chain</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_chain) }}" alt="Photo Chain"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Hook Bawah</th>
                            <td>{{ $checksheet->hook_bawah }}</td>
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
                        <tr>
                            <th>Pengunci Hook Bawah</th>
                            <td>{{ $checksheet->pengunci_hook_bawah }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Pengunci Hook Bawah</th>
                            <td>{{ $checksheet->catatan_pengunci_hook_bawah }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pengunci Hook Bawah</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pengunci_hook_bawah) }}" alt="Photo Pengunci Hook Bawah"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
@endsection
