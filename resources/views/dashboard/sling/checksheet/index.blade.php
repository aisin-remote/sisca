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
                            <th scope="col">Bagian Wire 1</th>
                            <th scope="col">Bagian Wire 2</th>
                            <th scope="col">Kumpulan Wire 1</th>
                            <th scope="col">Diameter Wire</th>
                            <th scope="col">Kumpulan Wire 2</th>
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
                                <td>{{ $checksheet->serabut_wire }}</td>
                                <td>{{ $checksheet->bagian_wire_1 }}</td>
                                <td>{{ $checksheet->bagian_wire_2 }}</td>
                                <td>{{ $checksheet->kumpulan_wire_1 }}</td>
                                <td>{{ $checksheet->diameter_wire }}</td>
                                <td>{{ $checksheet->kumpulan_wire_2 }}</td>
                                <td>{{ $checksheet->hook_wire }}</td>
                                <td>{{ $checksheet->pengunci_hook }}</td>
                                <td>{{ $checksheet->mata_sling }}</td>
                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('sling.checksheetwire.show', $checksheet->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        <a href="{{ route('sling.checksheetwire.edit', $checksheet->id) }}"
                                            class="badge bg-warning me-2">Edit</a>
                                        <form action="{{ route('sling.checksheetwire.destroy', $checksheet->id) }}" method="POST"
                                            class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge bg-danger border-0"
                                                onclick="return confirm('Ingin menghapus Data Check Sheet Sling Wire?')">Delete</button>
                                        </form>
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
                            <th scope="col">Kelengkapan Tag Sling Belt</th>
                            <th scope="col">Bagian Pinggir Robek</th>
                            <th scope="col">Pengecekan Lapisan Belt 1</th>
                            <th scope="col">Pengecekan Jahitan Belt</th>
                            <th scope="col">Pengecekan permukaan belt</th>
                            <th scope="col">Pengecekan lapisan belt 2</th>
                            <th scope="col">Pengecekan Aus</th>
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
                                <td>{{ $checksheet->kelengkapan_tag_sling_belt }}</td>
                                <td>{{ $checksheet->bagian_pinggir_belt_robek }}</td>
                                <td>{{ $checksheet->pengecekan_lapisan_belt_1 }}</td>
                                <td>{{ $checksheet->pengecekan_jahitan_belt }}</td>
                                <td>{{ $checksheet->pengecekan_permukaan_belt }}</td>
                                <td>{{ $checksheet->pengecekan_lapisan_belt_2 }}</td>
                                <td>{{ $checksheet->pengecekan_aus }}</td>
                                <td>{{ $checksheet->hook_wire }}</td>
                                <td>{{ $checksheet->pengunci_hook }}</td>
                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('sling.checksheetbelt.show', $checksheet->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        <a href="{{ route('sling.checksheetbelt.edit', $checksheet->id) }}"
                                            class="badge bg-warning me-2">Edit</a>
                                        <form action="{{ route('sling.checksheetbelt.destroy', $checksheet->id) }}" method="POST"
                                            class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="badge bg-danger border-0"
                                                onclick="return confirm('Ingin menghapus Data Check Sheet Sling Beltr?')">Delete</button>
                                        </form>
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
