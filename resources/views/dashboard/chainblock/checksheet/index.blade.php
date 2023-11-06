@extends('dashboard.app')
@section('title', 'Data Check Sheet Chain Block')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h3>Data Check Sheet Chain Block</h3>
        <form action="{{ route('chainblock.checksheet.index') }}" method="GET">
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
                            <th scope="col">NPK</th>
                            <th scope="col">No Chain Block</th>
                            <th scope="col">Geared Trolley</th>
                            <th scope="col">Gerakan Halus</th>
                            <th scope="col">Chain Geared Trolley 2</th>
                            <th scope="col">Hooking Geared Trolly</th>
                            <th scope="col">Latch Hook Atas</th>
                            <th scope="col">Hook Atas</th>
                            <th scope="col">Hand Chain</th>
                            <th scope="col">Load Chain</th>
                            <th scope="col">Latch Hook Bawah</th>
                            <th scope="col">Hook Bawah</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheetchainblock as $checksheet)
                            <tr class="text-center align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                {{-- <td>{{ strftime('%e %B %Y', strtotime($checksheet->updated_at)) }}</td> --}}
                                <td>{{ $checksheet->npk }}</td>
                                <td>{{ $checksheet->chainblock_number }}</td>

                                @if ($checksheet->geared_trolley === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->geared_trolley }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->geared_trolley }}</td>
                                @endif

                                @if ($checksheet->chain_geared_trolley_1 === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->chain_geared_trolley_1 }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->chain_geared_trolley_1 }}</td>
                                @endif

                                @if ($checksheet->chain_geared_trolley_2 === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->chain_geared_trolley_2 }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->chain_geared_trolley_2 }}</td>
                                @endif

                                @if ($checksheet->hooking_geared_trolly === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->hooking_geared_trolly }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->hooking_geared_trolly }}</td>
                                @endif

                                @if ($checksheet->latch_hook_atas === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->latch_hook_atas }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->latch_hook_atas }}</td>
                                @endif

                                @if ($checksheet->hook_atas === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->hook_atas }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->hook_atas }}</td>
                                @endif

                                @if ($checksheet->hand_chain === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->hand_chain }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->hand_chain }}</td>
                                @endif

                                @if ($checksheet->load_chain === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->load_chain }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->load_chain }}</td>
                                @endif

                                @if ($checksheet->latch_hook_bawah === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->latch_hook_bawah }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->latch_hook_bawah }}</td>
                                @endif

                                @if ($checksheet->hook_bawah === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->hook_bawah }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->hook_bawah }}</td>
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
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet Chain Block?')">Delete</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <td colspan="15">Tidak ada data...</td>
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
