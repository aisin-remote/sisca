@extends('dashboard.app')
@section('title', 'Data Check Sheet Tembin')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h3>Data Check Sheet Tembin</h3>
        <form action="{{ route('tembin.checksheet.index') }}" method="GET">
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
                            <th scope="col">No Equip</th>
                            <th scope="col">Master Link</th>
                            <th scope="col">Body Tembin</th>
                            <th scope="col">Mur & Baut</th>
                            <th scope="col">Shackle</th>
                            <th scope="col">Hook Atas</th>
                            <th scope="col">Pengunci Hook Atas</th>
                            <th scope="col">Mata Chain</th>
                            <th scope="col">Chain</th>
                            <th scope="col">Hook Bawah</th>
                            <th scope="col">Pengunci Hook Bawah</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checksheettembin as $checksheet)
                            <tr class="text-center align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ strftime('%e %B %Y', strtotime($checksheet->tanggal_pengecekan)) }}</td>
                                {{-- <td>{{ strftime('%e %B %Y', strtotime($checksheet->updated_at)) }}</td> --}}
                                <td>{{ $checksheet->npk }}</td>
                                <td>{{ $checksheet->tembin_number }}</td>

                                @if ($checksheet->master_link === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->master_link }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->master_link }}</td>
                                @endif

                                @if ($checksheet->body_tembin === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->body_tembin }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->body_tembin }}</td>
                                @endif

                                @if ($checksheet->mur_baut === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->mur_baut }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->mur_baut }}</td>
                                @endif

                                @if ($checksheet->shackle === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->shackle }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->shackle }}</td>
                                @endif

                                @if ($checksheet->hook_atas === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->hook_atas }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->hook_atas }}</td>
                                @endif

                                @if ($checksheet->pengunci_hook_atas === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->pengunci_hook_atas }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->pengunci_hook_atas }}</td>
                                @endif

                                @if ($checksheet->mata_chain === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->mata_chain }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->mata_chain }}</td>
                                @endif

                                @if ($checksheet->chain === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->chain }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->chain }}</td>
                                @endif

                                @if ($checksheet->hook_bawah === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->hook_bawah }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->hook_bawah }}</td>
                                @endif

                                @if ($checksheet->pengunci_hook_bawah === 'NG')
                                    <td class="text-danger fw-bolder">
                                        {{ $checksheet->pengunci_hook_bawah }}
                                    </td>
                                @else
                                    <td>{{ $checksheet->pengunci_hook_bawah }}</td>
                                @endif

                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('tembin.checksheettembin.show', $checksheet->id) }}"
                                            class="badge bg-info me-2">Info</a>
                                        @can('admin')
                                            <a href="{{ route('tembin.checksheettembin.edit', $checksheet->id) }}"
                                                class="badge bg-warning me-2">Edit</a>
                                            <form action="{{ route('tembin.checksheettembin.destroy', $checksheet->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge bg-danger border-0"
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet Tembin?')">Delete</button>
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
