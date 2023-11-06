@extends('dashboard.app')
@section('title', 'Data Check Sheet Sling')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h3>Data Check Sheet Sling Wire</h3>
        <form action="{{ route('sling.checksheet.index') }}" method="GET">
            <label for="tanggal_filter">Filter Tanggal:</label>
            <div class="input-group">
                <input type="date" name="tanggal_filter" class="form-control" id="tanggal_filter">
                <button class="btn btn-success" id="filterButton">Filter</button>
            </div>
        </form>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-12">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="table-responsive col-lg-12">
                <table class="table table-striped table-sm" id="dtBasicExample1">
                    <thead>
                        <tr class="text-center align-middle">
                            <th scope="col">#</th>
                            <th scope="col">Tanggal Pengecekan</th>
                            {{-- <th scope="col">Terakhir Update</th> --}}
                            <th scope="col">NPK</th>
                            <th scope="col">No Sling</th>
                            <th scope="col">Type</th>
                            <th scope="col">SWL</th>
                            <th scope="col">Location Sling</th>
                            <th scope="col">Plant</th>
                            <th scope="col">Serabut Wire</th>
                            <th scope="col">Sling Terlilit</th>
                            <th scope="col">Karat</th>
                            <th scope="col">Serabut Keluar</th>
                            <th scope="col">Diameter Wire</th>
                            <th scope="col">Wire Longgar</th>
                            <th scope="col">Hook Wire</th>
                            <th scope="col">Pengunci Hook</th>
                            <th scope="col">Mata Sling</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheetwire as $checksheet)
                            <tr class="text-center align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                {{-- <td>{{ strftime('%e %B %Y', strtotime($checksheet->updated_at)) }}</td> --}}
                                <td>{{ $checksheet->npk }}</td>
                                <td>{{ $checksheet->sling_number }}</td>
                                <td>{{ $checksheet->slings->type }}</td>
                                <td>{{ $checksheet->slings->swl }}</td>
                                <td>{{ $checksheet->slings->locations->location_name }}</td>
                                <td>{{ $checksheet->slings->plant }}</td>

                                @if ($checksheet->serabut_wire === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->serabut_wire }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->serabut_wire }}</td>
                                @endif

                                @if ($checksheet->bagian_wire_1 === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->bagian_wire_1 }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->bagian_wire_1 }}</td>
                                @endif

                                @if ($checksheet->bagian_wire_2 === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->bagian_wire_2 }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->bagian_wire_2 }}</td>
                                @endif

                                @if ($checksheet->kumpulan_wire_1 === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->kumpulan_wire_1 }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->kumpulan_wire_1 }}</td>
                                @endif

                                @if ($checksheet->diameter_wire === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->diameter_wire }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->diameter_wire }}</td>
                                @endif

                                @if ($checksheet->kumpulan_wire_2 === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->kumpulan_wire_2 }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->kumpulan_wire_2 }}</td>
                                @endif

                                @if ($checksheet->hook_wire === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->hook_wire }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->hook_wire }}</td>
                                @endif

                                @if ($checksheet->pengunci_hook === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->pengunci_hook }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->pengunci_hook }}</td>
                                @endif

                                @if ($checksheet->mata_sling === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->mata_sling }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->mata_sling }}</td>
                                @endif

                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('sling.checksheetwire.show', $checksheet->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        @can('admin')
                                            <a href="{{ route('sling.checksheetwire.edit', $checksheet->id) }}"
                                                class="badge bg-warning me-2">Edit</a>
                                            <form action="{{ route('sling.checksheetwire.destroy', $checksheet->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge bg-danger border-0"
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet Sling Wire?')">Delete</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <td colspan="19">Tidak ada data...</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-5 pb-2 mb-3 border-bottom col-lg-12">
        <h3>Data Check Sheet Sling Belt</h3>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-12">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="table-responsive col-lg-12">
                <table class="table table-striped table-sm" id="dtBasicExample2">
                    <thead>
                        <tr class="text-center align-middle">
                            <th scope="col">#</th>
                            <th scope="col">Tanggal Pengecekan</th>
                            {{-- <th scope="col">Terakhir Update</th> --}}
                            <th scope="col">NPK</th>
                            <th scope="col">No Sling</th>
                            <th scope="col">Type</th>
                            <th scope="col">SWL</th>
                            <th scope="col">Location Sling</th>
                            <th scope="col">Plant</th>
                            <th scope="col">Tag Sling Belt</th>
                            <th scope="col">Belt Robek</th>
                            <th scope="col">Belt Kusut</th>
                            <th scope="col">Jahitan Belt</th>
                            <th scope="col">Belt Menipis</th>
                            <th scope="col">Belt Scratch</th>
                            <th scope="col">Belt Aus</th>
                            <th scope="col">Hook Wire</th>
                            <th scope="col">Pengunci Hook</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheetbelt as $checksheet)
                            <tr class="text-center align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                {{-- <td>{{ strftime('%e %B %Y', strtotime($checksheet->updated_at)) }}</td> --}}
                                <td>{{ $checksheet->npk }}</td>
                                <td>{{ $checksheet->sling_number }}</td>
                                <td>{{ $checksheet->slings->type }}</td>
                                <td>{{ $checksheet->slings->swl }}</td>
                                <td>{{ $checksheet->slings->locations->location_name }}</td>
                                <td>{{ $checksheet->slings->plant }}</td>

                                @if ($checksheet->kelengkapan_tag_sling_belt === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->kelengkapan_tag_sling_belt }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->kelengkapan_tag_sling_belt }}</td>
                                @endif

                                @if ($checksheet->bagian_pinggir_belt_robek === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->bagian_pinggir_belt_robek }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->bagian_pinggir_belt_robek }}</td>
                                @endif

                                @if ($checksheet->pengecekan_lapisan_belt_1 === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->pengecekan_lapisan_belt_1 }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->pengecekan_lapisan_belt_1 }}</td>
                                @endif

                                @if ($checksheet->pengecekan_jahitan_belt === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->pengecekan_jahitan_belt }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->pengecekan_jahitan_belt }}</td>
                                @endif

                                @if ($checksheet->pengecekan_permukaan_belt === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->pengecekan_permukaan_belt }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->pengecekan_permukaan_belt }}</td>
                                @endif

                                @if ($checksheet->pengecekan_lapisan_belt_2 === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->pengecekan_lapisan_belt_2 }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->pengecekan_lapisan_belt_2 }}</td>
                                @endif

                                @if ($checksheet->pengecekan_aus === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->pengecekan_aus }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->pengecekan_aus }}</td>
                                @endif

                                @if ($checksheet->hook_wire === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->hook_wire }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->hook_wire }}</td>
                                @endif

                                @if ($checksheet->pengunci_hook === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->pengunci_hook }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->pengunci_hook }}</td>
                                @endif

                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('sling.checksheetbelt.show', $checksheet->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        @can('admin')
                                            <a href="{{ route('sling.checksheetbelt.edit', $checksheet->id) }}"
                                                class="badge bg-warning me-2">Edit</a>
                                            <form action="{{ route('sling.checksheetbelt.destroy', $checksheet->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge bg-danger border-0"
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet Sling Beltr?')">Delete</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <td colspan="13">Tidak ada data...</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var table1 = $('#dtBasicExample1').DataTable();
            var table2 = $('#dtBasicExample2').DataTable();
        });
    </script>
@endsection
