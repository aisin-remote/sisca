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
                            @foreach (['visual_check', 'cross_travelling', 'long_travelling', 'button_up', 'button_down', 'button_push', 'wire_rope', 'block_hook', 'hom', 'emergency_stop'] as $item)
                                <th scope="col">{{ ucfirst(str_replace('_', ' ', $item)) }}</th>
                            @endforeach
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupedChecksheet as $checkSheetId => $itemsByItemCheck)
                            <tr class="text-center align-middle">
                                <td>{{ $loop->iteration }}</td>
                                @php
                                    $firstItem = collect($itemsByItemCheck)->first(); // Mengambil item pertama
                                    $tanggalPengecekan = $firstItem['items']->first()->tanggal_pengecekan ?? '-';
                                    $npk = $firstItem['items']->first()->npk ?? '-';
                                    $noHeadcrane = $firstItem['items']->first()->no_headcrane ?? '-';
                                @endphp
                                <td>{{ $tanggalPengecekan }}</td>
                                <td>{{ $npk }}</td>
                                <td>{{ $noHeadcrane }}</td>

                                <!-- Perulangan untuk item -->
                                @foreach ($itemsByItemCheck as $item)
                                    <td class="text-center">
                                        @php
                                            $countOk = $item['countOk'] ?? 0; // Mengambil jumlah OK
                                            $total = $item['total'] ?? 0; // Mengambil jumlah total
                                        @endphp
                                        {{ $countOk }} / {{ $total }}
                                    </td>
                                @endforeach

                                <td class="text-center align-middle">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('headcrane.checksheetheadcrane.show', ['id' => $checkSheetId]) }}"
                                            class="badge bg-info me-2">Info</a>
                                        @if (Auth::user()->role === 'MTE' || Auth::user()->role === 'Admin')
                                            <a href="{{ route('headcrane.checksheetheadcrane.edit', ['id' => $checkSheetId]) }}"
                                                class="badge bg-warning me-2">Edit</a>
                                            <form
                                                action="{{ route('headcrane.checksheetheadcrane.destroy', ['id' => $checkSheetId]) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge bg-danger border-0"
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet Data Head Crane?')">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach


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
