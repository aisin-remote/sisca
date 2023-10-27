@extends('dashboard.app')
@section('title', 'Check Sheet')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Check Sheet Sling</h1>
    </div>
    @if (session()->has('error'))
        <div class="alert alert-danger col-lg-6">
            {{ session()->get('error') }}
        </div>
    @endif
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-12">
            {{ session()->get('success') }}
        </div>
    @endif
    <form action="{{ route('sling.process.form') }}" method="POST" class="mb-5 col-lg-12" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="sling_number" class="form-label">No Sling</label>
                <input type="text" name="sling_number" id="sling_number" placeholder="Masukkan No sling"
                    class="form-control @error('sling_number') is-invalid @enderror" value="{{ old('sling_number') }}"
                    required autofocus>
                @error('sling_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-success">Check</button>
    </form>
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h5>Check Sheet Terbaru</h5>
        <a href="/dashboard/sling/checksheet/all-check-sheet" class="btn-link text-primary"
            style="text-decoration: underline;">
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
                            <th scope="col">Nomor Sling</th>
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
                                <td>{{ $checkSheet->sling_number }}</td>
                                <td>{{ $checkSheet->slings->type }}</td>
                                @if ($checkSheet->slings->type === 'Sling Wire')
                                    <td class="text-center align-middle">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a href="{{ route('sling.checksheetwire.show', $checkSheet->id) }}"
                                                class="badge bg-info me-2">Info</a>
                                            @can('admin')
                                                <a href="{{ route('sling.checksheetwire.edit', $checkSheet->id) }}"
                                                    class="badge bg-warning me-2">Edit</a>
                                                <form action="{{ route('sling.checksheetwire.destroy', $checkSheet->id) }}"
                                                    method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="badge bg-danger border-0"
                                                        onclick="return confirm('Ingin menghapus Data Check Sheet Sling?')">Delete</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                @elseif ($checkSheet->slings->type === 'Sling Belt')
                                    <td class="text-center align-middle">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a href="{{ route('sling.checksheetbelt.show', $checkSheet->id) }}"
                                                class="badge bg-info me-2">Info</a>
                                            @can('admin')
                                                <a href="{{ route('sling.checksheetbelt.edit', $checkSheet->id) }}"
                                                    class="badge bg-warning me-2">Edit</a>
                                                <form action="{{ route('sling.checksheetbelt.destroy', $checkSheet->id) }}"
                                                    method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="badge bg-danger border-0"
                                                        onclick="return confirm('Ingin menghapus Data Check Sheet Sling?')">Delete</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                @else
                                    <p>Type dari Sling tidak ditemukan</p>
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
