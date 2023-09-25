@extends('dashboard.app')
@section('title', 'Check Sheet')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Check Sheet Eyewasher</h1>
    </div>
    @if (session()->has('error'))
        <div class="alert alert-success col-lg-6">
            {{ session()->get('error') }}
        </div>
    @endif
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-12">
            {{ session()->get('success') }}
        </div>
    @endif
    <form action="{{ route('eyewasher.process.form') }}" method="POST" class="mb-5 col-lg-12" enctype="multipart/form-data">
        @csrf
        <div class="row">
        <div class="mb-3 col-md-6">
            <label for="eyewasher_number" class="form-label">No Eyewasher</label>
            <input type="text" name="eyewasher_number" id="eyewasher_number" placeholder="Masukkan No eyewasher" class="form-control @error('eyewasher_number') is-invalid @enderror" value="{{old('eyewasher_number')}}" required autofocus>
            @error('eyewasher_number')
                <div class="text-danger">{{$message}}</div>
            @enderror
        </div>
    </div>
    <button type="submit" class="btn btn-success">Check</button>
    </form>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h5>Check Sheet Terbaru</h5>
        <a href="/dashboard/hydrant/checksheet/all-check-sheet" class="btn-link text-primary" style="text-decoration: underline;">
            Semua Check Sheet
        </a>
    </div>
    @if (session()->has('success1'))
        <div class="alert alert-success col-lg-12">
            {{ session()->get('success1') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="table-responsive col-lg-12">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr class="text-center align-middle">
                            <th scope="col">#</th>
                            <th scope="col">Tanggal Pengecekan</th>
                            <th scope="col">Terakhir Update</th>
                            <th scope="col">NPK</th>
                            <th scope="col">Nomor Eyewasher</th>
                            <th scope="col">Type</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($combinedLatestCheckSheets as $index => $checkSheet)
                            <tr class="text-center align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $checkSheet->created_at->format('d F Y') }}</td>
                                <td>{{ $checkSheet->updated_at->format('d F Y') }}</td>
                                <td>{{ $checkSheet->npk }}</td>
                                <td>{{ $checkSheet->eyewasher_number }}</td>
                                <td>{{ $checkSheet->eyewashers->type }}</td>
                                @if ($checkSheet->eyewashers->type === 'Eyewasher')
                                    <td class="text-center align-middle">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a href="{{ route('eyewasher.checksheeteyewasher.show', $checkSheet->id) }}" class="badge bg-info me-2">Info</a>
                                            <a href="{{ route('eyewasher.checksheeteyewasher.edit', $checkSheet->id) }}"
                                                class="badge bg-warning me-2">Edit</a>
                                            <form action="{{ route('hydrant.checksheetindoor.destroy', $checkSheet->id) }}" method="POST"
                                                class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge bg-danger border-0"
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet Eyewasher?')">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                @elseif ($checkSheet->hydrants->type === 'Shower')
                                    <td class="text-center align-middle">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a href="{{ route('hydrant.checksheetoutdoor.show', $checkSheet->id) }}" class="badge bg-info me-2">Info</a>
                                            <a href="{{ route('hydrant.checksheetoutdoor.edit', $checkSheet->id) }}"
                                                class="badge bg-warning me-2">Edit</a>
                                            <form action="{{ route('hydrant.checksheetoutdoor.destroy', $checkSheet->id) }}" method="POST"
                                                class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge bg-danger border-0"
                                                    onclick="return confirm('Ingin menghapus Data Check Sheet Eyewasher?')">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                @else
                                    <p>Type dari Eyewasher tidak ditemukan</p>
                                @endif
                            </tr>
                        @empty
                            <td colspan="12">Tidak ada data...</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection