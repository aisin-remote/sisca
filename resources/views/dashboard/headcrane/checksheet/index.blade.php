@extends('dashboard.app')
@section('title', 'Data Check Sheet Head Crane')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h3>Data Check Sheet Head Crane</h3>
        <form action="{{ route('headcrane.checksheet.index') }}" method="GET">
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
                            <th scope="col">No Head Crane</th>
                            <th scope="col">Cross Travelling</th>
                            <th scope="col">Long Travelling</th>
                            <th scope="col">Button Up</th>
                            <th scope="col">Button Down</th>
                            <th scope="col">Buttton Push</th>
                            <th scope="col">Wire Rope</th>
                            <th scope="col">Block Hook</th>
                            <th scope="col">Hom</th>
                            <th scope="col">Emergency Stop</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheetheadcrane as $checksheet)
                            <tr class="text-center align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                {{-- <td>{{ strftime('%e %B %Y', strtotime($checksheet->updated_at)) }}</td> --}}
                                <td>{{ $checksheet->npk }}</td>
                                <td>{{ $checksheet->headcrane_number }}</td>

                                @if ($checksheet->cross_travelling === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->cross_travelling }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->cross_travelling }}</td>
                                @endif

                                @if ($checksheet->long_travelling === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->long_travelling }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->long_travelling }}</td>
                                @endif

                                @if ($checksheet->button_up === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->button_up }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->button_up }}</td>
                                @endif

                                @if ($checksheet->button_down === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->button_down }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->button_down }}</td>
                                @endif

                                @if ($checksheet->button_push === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->button_push }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->button_push }}</td>
                                @endif

                                @if ($checksheet->wire_rope === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->wire_rope }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->wire_rope }}</td>
                                @endif

                                @if ($checksheet->block_hook === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->block_hook }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->block_hook }}</td>
                                @endif

                                @if ($checksheet->hom === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->hom }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->hom }}</td>
                                @endif

                                @if ($checksheet->emergency_stop === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->emergency_stop }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->emergency_stop }}</td>
                                @endif

                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('headcrane.checksheetheadcrane.show', $checksheet->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        @can('admin')
                                            <a href="{{ route('headcrane.checksheetheadcrane.edit', $checksheet->id) }}"
                                                class="badge bg-warning me-2">Edit</a>
                                            <form
                                                action="{{ route('headcrane.checksheetheadcrane.destroy', $checksheet->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge bg-danger border-0"
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet Data Head Crane?')">Delete</button>
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
