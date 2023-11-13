@extends('dashboard.app')
@section('title', 'Data Chain Block')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Info Chain Block</h1>
        @can('admin')
            <a href="{{ route('chain-block.edit', $chainblock->id) }}" class="btn btn-warning">Edit</a>
        @endcan
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-12">
            {{ session()->get('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger col-lg-12">
            {{ session()->get('error') }}
        </div>
    @endif
    <div class="card col-lg-6 mb-4">
        <div class="card-body">
            <div class="row">
                <div class="h6 col-3">No Chain Block</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $chainblock->no_chainblock }}</div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="h6 col-3">Location</div>
                <div class="col-2">:</div>
                <div class="col-6 text-muted">{{ $chainblock->locations->location_name }}</div>
            </div>
        </div>
    </div>
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Riwayat Check Sheet Chain Block</h1>
        <div class="form-group">
            <form action="{{ route('chain-block.show', $chainblock->id) }}" method="GET">
                <label for="tahun_filter">Filter Tahun:</label>
                <div class="input-group">
                    <select name="tahun_filter" id="tahun_filter" class="form-control">
                        @for ($year = $firstYear; $year <= $lastYear; $year++)
                            <option value="{{ $year }}" {{ request('tahun_filter') == $year ? 'selected' : '' }}>
                                {{ $year }}</option>
                        @endfor
                    </select>
                    <button class="btn btn-success" id="filterButton">Filter</button>
                </div>
            </form>
        </div>

    </div>
    <form action="{{ route('export.checksheets.chainblock') }}" method="POST" class="col-md-6 mb-3">
        @method('POST')
        @csrf
        <div class="form-group mb-3">
            <label for="tahun">Download Checksheet Chain Block</label>
            <select name="tahun" id="tahun" class="form-control" required>
                @for ($year = $firstYear; $year <= $lastYear; $year++)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
            <!-- Tambahkan input hidden untuk no_tabung -->
            <input type="hidden" name="chainblock_number" value="{{ $chainblock->no_chainblock }}">
        </div>
        <button type="submit" class="btn btn-primary"><i class="bi bi-download"></i> | Download</button>
    </form>

    @if (session()->has('success1'))
        <div class="mt-2 alert alert-success col-lg-12">
            {{ session()->get('success1') }}
        </div>
    @endif
    <div class="card">
        <div class="card-table">
            <div class="table-responsive col-lg-12 mt-3">
                <table class="table table-striped table-sm" id="dtBasicExample">
                    <thead>
                        <tr>
                            <th rowspan="2" scope="col" class="text-center align-middle">#</th>
                            <th rowspan="2" scope="col" class="text-center align-middle">Tanggal</th>
                            <th rowspan="2" scope="col" class="text-center align-middle">No Chain Block</th>
                            <th colspan="10" scope="colgroup" class="text-center">Item Check</th>
                            <th rowspan="2" scope="col" class="text-center align-middle">Aksi</th>
                        </tr>
                        <tr>
                            <th class="text-center align-middle">Geared Trolley</th>
                            <th class="text-center align-middle">Gerakan Halus</th>
                            <th class="text-center align-middle">Chain Geared Trolley 2</th>
                            <th class="text-center align-middle">Hooking Geared Trolly</th>
                            <th class="text-center align-middle">Latch Hook Atas</th>
                            <th class="text-center align-middle">Hook Atas</th>
                            <th class="text-center align-middle">Hand Chain</th>
                            <th class="text-center align-middle">Load Chain</th>
                            <th class="text-center align-middle">Latch Hook Bawah</th>
                            <th class="text-center align-middle">Hook Bawah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheets as $checksheet)
                            <tr class="align-middle">
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="text-center align-middle">
                                    {{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                <td class="text-center align-middle">{{ $checksheet->chainblock_number }}</td>

                                @if ($checksheet->geared_trolley === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->geared_trolley }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->geared_trolley }}</td>
                                @endif

                                @if ($checksheet->chain_geared_trolley_1 === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->chain_geared_trolley_1 }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->chain_geared_trolley_1 }}</td>
                                @endif

                                @if ($checksheet->chain_geared_trolley_2 === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->chain_geared_trolley_2 }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->chain_geared_trolley_2 }}</td>
                                @endif

                                @if ($checksheet->hooking_geared_trolly === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->hooking_geared_trolly }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->hooking_geared_trolly }}</td>
                                @endif

                                @if ($checksheet->latch_hook_atas === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->latch_hook_atas }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->latch_hook_atas }}</td>
                                @endif

                                @if ($checksheet->hook_atas === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->hook_atas }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->hook_atas }}</td>
                                @endif

                                @if ($checksheet->hand_chain === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->hand_chain }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->hand_chain }}</td>
                                @endif

                                @if ($checksheet->load_chain === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->load_chain }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->load_chain }}</td>
                                @endif

                                @if ($checksheet->latch_hook_bawah === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->latch_hook_bawah }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->latch_hook_bawah }}</td>
                                @endif

                                @if ($checksheet->hook_bawah === 'NG')
                                    <td class="text-danger fw-bolder text-center align-middle">
                                        {{ $checksheet->hook_bawah }}
                                    </td>
                                @else
                                    <td class="text-center align-middle">{{ $checksheet->hook_bawah }}</td>
                                @endif

                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('chainblock.checksheetchainblock.show', $checksheet->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        @can('admin')
                                            <a href="{{ route('chainblock.checksheetchainblock.edit', $checksheet->id) }}"
                                                class="badge bg-warning me-2">Edit</a>
                                            <form
                                                action="{{ route('chainblock.checksheetchainblock.destroy', $checksheet->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge bg-danger border-0"
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet Tandu?')">Delete</button>
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
        document.getElementById('filterButton').addEventListener('click', function() {
            var selectedDate = document.getElementById('filterDate').value;
            // Lakukan sesuatu dengan tanggal yang dipilih, misalnya memicu filter
            console.log('Tanggal yang dipilih:', selectedDate);
        });
    </script>

@endsection
