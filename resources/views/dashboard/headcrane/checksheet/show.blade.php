@extends('dashboard.app')
@section('title', 'Data Check Sheet Head Crane')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h1>Detail Check Sheet Head Crane</h1>
        @if (Auth::user()->role === 'MTE' || Auth::user()->role === 'Admin')
            <a href="{{ route('headcrane.checksheetheadcrane.edit', ['id' => $checksheetItems->first()->check_sheet_id]) }}"
                class="btn btn-warning">Edit</a>
        @endif
    </div>

    <div class="card col-md-12">
        <div class="card-body">
            <div class="table-responsive col-md-12">
                <table class="table table-striped table-sm">
                    <tr>
                        <th width='40%'>Tanggal Pengecekan</th>
                        <td>{{ strftime('%e %B %Y', strtotime($checksheetItems->first()->checkSheet->tanggal_pengecekan ?? '')) }}
                        </td>
                    </tr>
                    <tr>
                        <th>Terakhir Diupdate</th>
                        <td>{{ strftime('%e %B %Y', strtotime($checksheetItems->first()->checkSheet->updated_at ?? '')) }}
                    </tr>
                    <tr>
                        <th>NPK</th>
                        <td>{{ $checksheetItems->first()->checkSheet->npk ?? '' }}
                    </tr>
                    <tr>
                        <th>No Head Crane</th>
                        <td>{{ $checksheetItems->first()->checkSheet->headcrane->no_headcrane ?? '' }}</td>
                    </tr>
                    @foreach ($checksheetItems as $item)
                        <tr>
                            <th>{{ $item->itemCheck->item_check }} - {{ $item->itemCheck->prosedur }}</th>
                            <td>{{ $item->check }}</td> <!-- Status check (e.g., Passed, Failed) -->
                        </tr>
                        <tr>
                            <th>Catatan</th>
                            <td>{{ $item->catatan }}</td> <!-- Catatan -->
                        </tr>
                        <tr>
                            <th>Foto</th>
                            <td>
                                <img src="{{ asset('storage/' . $item->photo) }}" alt="Photo" class="img-fluid"
                                    style="max-width: 250px;">
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
