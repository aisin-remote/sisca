@extends('dashboard.app')
@section('title', 'All APAR Report')

@section('content')
<div class="container">
    <div>
        <form class="form-inline" method="GET" action="{{ route('apar.report.all') }}">
            <div class="input-group mb-3">
                <label class="input-group-text" for="selected_year">Pilih Tahun:</label>
                <select class="form-select" name="selected_year" id="selected_year">
                    <option value="select" selected disabled>Select</option>
                    @php
                    $currentYear = date('Y');
                    for ($year = $currentYear - 5; $year <= $currentYear; $year++) { echo "<option value=\" $year\">$year</option>";
                        }
                        @endphp
                </select>
            </div>
            <button type="submit" class="btn btn-info ml-2">Tampilkan</button>
        </form>

        @if(request()->has('selected_year'))
        <p class="mt-2">Data untuk tahun {{ request('selected_year') }}</p>
        @endif
    </div>

    <br>
    <hr>

    <h3>All APAR Report</h3>
    <table class="text-center table table-striped">
        <thead class="align-middle">
            <tr>
                <th rowspan="2">Tag Number</th>
                <th rowspan="2">Type</th>
                <th rowspan="2">Location</th>
                <th colspan="12">Month</th>
            </tr>
            <tr>
                @for ($month = 1; $month <= 12; $month++) <th>{{ $month }}</th>
                    @endfor
            </tr>
        </thead>
        <tbody>
            @foreach ($aparData as $apar)
            <tr>
                <td>{{ $apar['apar_number'] }}</td>
                <td>{{ $apar['type'] }}</td>
                <td>{{ $apar['location_name'] }}</td>
                @for ($month = 1; $month <= 12; $month++) <td>
                    @if (isset($apar['months'][$month]))
                    @if (in_array('OK', $apar['months'][$month]))
                    <span class="badge bg-success">OK</span>
                    @else
                    @php
                    $issueCodes = implode('+', $apar['months'][$month]);
                    @endphp
                    <span class="badge bg-danger">{{ $issueCodes }}</span>
                    @endif
                    @endif
                    </td>
                    @endfor
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection