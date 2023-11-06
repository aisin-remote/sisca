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
                            @if ($checksheet->serabut_wire === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->serabut_wire }}
                                </td>
                            @else
                                <td>{{ $checksheet->serabut_wire }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Serabut Wire</th>
                            <td>{{ $checksheet->catatan_serabut_wire }}</td>
                        </tr>
                        <tr>
                            <th>Photo Serabut Wire</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_serabut_wire) }}"
                                    alt="Photo Serabut Wire" style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Sling Terlilit</th>
                            @if ($checksheet->bagian_wire_1 === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->bagian_wire_1 }}
                                </td>
                            @else
                                <td>{{ $checksheet->bagian_wire_1 }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Sling Terlilit</th>
                            <td>{{ $checksheet->catatan_bagian_wire_1 }}</td>
                        </tr>
                        <tr>
                            <th>Photo Sling Terlilit</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_bagian_wire_1) }}"
                                    alt="Photo Sling Terlilit" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Karat</th>
                            @if ($checksheet->bagian_wire_2 === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->bagian_wire_2 }}
                                </td>
                            @else
                                <td>{{ $checksheet->bagian_wire_2 }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Karat</th>
                            <td>{{ $checksheet->catatan_bagian_wire_2 }}</td>
                        </tr>
                        <tr>
                            <th>Photo Karat</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_bagian_wire_2) }}" alt="Photo Karat"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Serabut Keluar</th>
                            @if ($checksheet->kumpulan_wire_1 === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->kumpulan_wire_1 }}
                                </td>
                            @else
                                <td>{{ $checksheet->kumpulan_wire_1 }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Serabut Keluar</th>
                            <td>{{ $checksheet->catatan_kumpulan_wire_1 }}</td>
                        </tr>
                        <tr>
                            <th>Photo Serabut Keluar</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_kumpulan_wire_1) }}"
                                    alt="Photo Serabut Keluar" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Diameter Wire</th>
                            @if ($checksheet->diameter_wire === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->diameter_wire }}
                                </td>
                            @else
                                <td>{{ $checksheet->diameter_wire }}</td>
                            @endif
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
                            <th>Wire Longgar</th>
                            @if ($checksheet->kumpulan_wire_2 === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->kumpulan_wire_2 }}
                                </td>
                            @else
                                <td>{{ $checksheet->kumpulan_wire_2 }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Wire Longgar</th>
                            <td>{{ $checksheet->catatan_kumpulan_wire_2 }}</td>
                        </tr>
                        <tr>
                            <th>Photo Wire Longgar</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_kumpulan_wire_2) }}"
                                    alt="Photo Wire Longgar" style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>

                        <tr>
                            <th>Hook Wire</th>
                            @if ($checksheet->hook_wire === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->hook_wire }}
                                </td>
                            @else
                                <td>{{ $checksheet->hook_wire }}</td>
                            @endif
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
                            @if ($checksheet->pengunci_hook === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->pengunci_hook }}
                                </td>
                            @else
                                <td>{{ $checksheet->pengunci_hook }}</td>
                            @endif
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


                        <tr>
                            <th>Mata Sling</th>
                            @if ($checksheet->mata_sling === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->mata_sling }}
                                </td>
                            @else
                                <td>{{ $checksheet->mata_sling }}</td>
                            @endif
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
                            <th>Tag Sling Belt</th>
                            @if ($checksheet->kelengkapan_tag_sling_belt === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->kelengkapan_tag_sling_belt }}
                                </td>
                            @else
                                <td>{{ $checksheet->kelengkapan_tag_sling_belt }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Tag Sling Belt</th>
                            <td>{{ $checksheet->catatan_kelengkapan_tag_sling_belt }}</td>
                        </tr>
                        <tr>
                            <th>Photo Tag Sling Belt</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_kelengkapan_tag_sling_belt) }}"
                                    alt="Photo Tag Sling Belt" style="max-width: 250px; max-height: 300px;"
                                    class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Belt Robek</th>
                            @if ($checksheet->bagian_pinggir_belt_robek === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->bagian_pinggir_belt_robek }}
                                </td>
                            @else
                                <td>{{ $checksheet->bagian_pinggir_belt_robek }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Belt Robek</th>
                            <td>{{ $checksheet->catatan_bagian_pinggir_belt_robek }}</td>
                        </tr>
                        <tr>
                            <th>Photo Belt Robek</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_bagian_pinggir_belt_robek) }}"
                                    alt="Photo Belt Robek" style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Belt Kusut</th>
                            @if ($checksheet->pengecekan_lapisan_belt_1 === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->pengecekan_lapisan_belt_1 }}
                                </td>
                            @else
                                <td>{{ $checksheet->pengecekan_lapisan_belt_1 }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Belt Kusut</th>
                            <td>{{ $checksheet->catatan_pengecekan_lapisan_belt_1 }}</td>
                        </tr>
                        <tr>
                            <th>Photo Belt Kusut</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pengecekan_lapisan_belt_1) }}"
                                    alt="Photo Belt Kusut" style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Jahitan Belt</th>
                            @if ($checksheet->pengecekan_jahitan_belt === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->pengecekan_jahitan_belt }}
                                </td>
                            @else
                                <td>{{ $checksheet->pengecekan_jahitan_belt }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Jahitan Belt</th>
                            <td>{{ $checksheet->catatan_pengecekan_jahitan_belt }}</td>
                        </tr>
                        <tr>
                            <th>Photo Jahitan Belt</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pengecekan_jahitan_belt) }}"
                                    alt="Photo Jahitan Belt" style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <th>Belt Menipis</th>
                            @if ($checksheet->pengecekan_permukaan_belt === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->pengecekan_permukaan_belt }}
                                </td>
                            @else
                                <td>{{ $checksheet->pengecekan_permukaan_belt }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Belt Menipis</th>
                            <td>{{ $checksheet->catatan_pengecekan_permukaan_belt }}</td>
                        </tr>
                        <tr>
                            <th>Photo Belt Menipis</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pengecekan_permukaan_belt) }}"
                                    alt="Photo Belt Menipis" style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>

                        <tr>
                            <th>Belt Scratch</th>
                            @if ($checksheet->pengecekan_lapisan_belt_2 === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->pengecekan_lapisan_belt_2 }}
                                </td>
                            @else
                                <td>{{ $checksheet->pengecekan_lapisan_belt_2 }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Belt Scratch</th>
                            <td>{{ $checksheet->catatan_pengecekan_lapisan_belt_2 }}</td>
                        </tr>
                        <tr>
                            <th>Photo Belt Scratch</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pengecekan_lapisan_belt_2) }}"
                                    alt="Photo Belt Scratch" style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>

                        <tr>
                            <th>Belt Aus</th>
                            @if ($checksheet->pengecekan_aus === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->pengecekan_aus }}
                                </td>
                            @else
                                <td>{{ $checksheet->pengecekan_aus }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Catatan Belt Aus</th>
                            <td>{{ $checksheet->catatan_pengecekan_aus }}</td>
                        </tr>
                        <tr>
                            <th>Photo Belt Aus</th>
                            <td>
                                <img src="{{ asset('storage/' . $checksheet->photo_pengecekan_aus) }}" alt="Photo Belt Aus"
                                    style="max-width: 250px; max-height: 300px;" class="img-fluid">
                            </td>
                        </tr>

                        <tr>
                            <th>Hook Wire</th>
                            @if ($checksheet->hook_wire === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->hook_wire }}
                                </td>
                            @else
                                <td>{{ $checksheet->hook_wire }}</td>
                            @endif
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
                            @if ($checksheet->pengunci_hook === 'NG')
                                <td class="text-danger fw-bolder">
                                    {{ $checksheet->pengunci_hook }}
                                </td>
                            @else
                                <td>{{ $checksheet->pengunci_hook }}</td>
                            @endif
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
