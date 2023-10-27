@extends('dashboard.app')
@section('title', 'Data Check Sheet Sling')

@section('content')
    @if ($checksheet->slings->type === 'Sling Wire')
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
            <h1>Detail Check Sheet Sling</h1>
            @can('admin')
                <a href="{{ route('sling.checksheetwire.edit', $checksheet->id) }}" class="btn btn-warning">Edit</a>
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
                            <th>Sling Number</th>
                            <td>{{ $checksheet->sling_number }}</td>
                        </tr>
                        <tr>
                            <th>Type</th>
                            <td>{{ $checksheet->slings->type }}</td>
                        </tr>
                        <tr>
                            <th>SWL</th>
                            <td>{{ $checksheet->slings->swl }} Ton</td>
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
                                <img src="{{ asset('storage/' . $checksheet->photo_bagian_wire_1) }}"
                                    alt="Photo Bagian Wire 1" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
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
                                <img src="{{ asset('storage/' . $checksheet->photo_bagian_wire_2) }}"
                                    alt="Photo Bagian Wire 2" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
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
                                <img src="{{ asset('storage/' . $checksheet->photo_kumpulan_wire_1) }}"
                                    alt="Photo Kumpulan Wire 1" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
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
                                <img src="{{ asset('storage/' . $checksheet->photo_diameter_wire) }}"
                                    alt="Photo Diameter Wire" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
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
                                <img src="{{ asset('storage/' . $checksheet->photo_kumpulan_wire_2) }}"
                                    alt="Photo Kumpulan Wire 2" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
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
                                <img src="{{ asset('storage/' . $checksheet->photo_pengunci_hook) }}"
                                    alt="Photo Pengunci Hook" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
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
    @elseif ($checksheet->slings->type === 'Sling Belt')
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
            <h1>Detail Check Sheet Sling</h1>
            @can('admin')
                <a href="{{ route('sling.checksheetbelt.edit', $checksheet->id) }}" class="btn btn-warning">Edit</a>
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
                            <th>Sling Number</th>
                            <td>{{ $checksheet->sling_number }}</td>
                        </tr>
                        <tr>
                            <th>Type</th>
                            <td>{{ $checksheet->slings->type }}</td>
                        </tr>
                        <tr>
                            <th>SWL</th>
                            <td>{{ $checksheet->slings->swl }} Ton</td>
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
                            <th>Kelengkapan TagSling Belt</th>
                            <td>{{ $checksheet->kelengkapan_tag_sling_belt }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Kelengkapan TagSling Belt</th>
                            <td>{{ $checksheet->catatan_kelengkapan_tag_sling_belt }}</td>
                        </tr>
                        <tr>
                            <th>Photo Kelengkapan TagSling Belt</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_kelengkapan_tag_sling_belt) }}"
                                    alt="Photo Kelengkapan Tag Sling Belt" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Bagian Pinggir Belt Robek</th>
                            <td>{{ $checksheet->bagian_pinggir_belt_robek }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Bagian Pinggir Belt Robek</th>
                            <td>{{ $checksheet->catatan_bagian_pinggir_belt_robek }}</td>
                        </tr>
                        <tr>
                            <th>Photo Bagian Pinggir Belt Robek</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_bagian_pinggir_belt_robek) }}"
                                    alt="Photo Bagian Pinggir Belt Robek" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Pengecekan Lapisan Belt 1</th>
                            <td>{{ $checksheet->pengecekan_lapisan_belt_1 }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Pengecekan Lapisan Belt 1</th>
                            <td>{{ $checksheet->catatan_pengecekan_lapisan_belt_1 }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pengecekan Lapisan Belt 1</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pengecekan_lapisan_belt_1) }}"
                                    alt="Photo Pengecekan Lapisan Belt 1" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Pengecekan Jahitan Belt</th>
                            <td>{{ $checksheet->pengecekan_jahitan_belt }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Pengecekan Jahitan Belt</th>
                            <td>{{ $checksheet->catatan_pengecekan_jahitan_belt }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pengecekan Jahitan Belt</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pengecekan_jahitan_belt) }}"
                                    alt="Photo Pengecekan Jahitan Belt" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Pengecekan Permukaan Belt</th>
                            <td>{{ $checksheet->pengecekan_permukaan_belt }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Pengecekan Permukaan Belt</th>
                            <td>{{ $checksheet->catatan_pengecekan_permukaan_belt }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pengecekan Permukaan Belt</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pengecekan_permukaan_belt) }}"
                                    alt="Photo Pengecekan Permukaan Belt" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
                            </td>
                        </tr>

                        <tr>
                            <th>Pengecekan Lapisan Belt 2</th>
                            <td>{{ $checksheet->pengecekan_lapisan_belt_2 }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Pengecekan Lapisan Belt 2</th>
                            <td>{{ $checksheet->catatan_pengecekan_lapisan_belt_2 }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pengecekan Lapisan Belt 2</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pengecekan_lapisan_belt_2) }}"
                                    alt="Photo Pengecekan Lapisan Belt 2" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
                            </td>
                        </tr>

                        <tr>
                            <th>Pengecekan Aus</th>
                            <td>{{ $checksheet->pengecekan_aus }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Pengecekan Aus</th>
                            <td>{{ $checksheet->catatan_pengecekan_aus }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pengecekan Aus</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pengecekan_aus) }}"
                                    alt="Photo Pengecekan Aus" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
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
                            <td>{{ $checksheet->pengunci_hook }}</td>
                        </tr>
                        <tr>
                            <th>Catatan Pengunci Hook</th>
                            <td>{{ $checksheet->catatan_pengunci_hook }}</td>
                        </tr>
                        <tr>
                            <th>Photo Pengunci Hook</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pengunci_hook) }}"
                                    alt="Photo Pengunci Hook" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
