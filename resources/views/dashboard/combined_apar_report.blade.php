@extends('dashboard.app')
@section('title', 'All APAR Report')

@section('content')
<div class="container">
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
                <td>{{ $apar->apar_number }}</td>
                <td>{{ $apar->type }}</td>
                <td>{{ $apar->location_name }}</td>
                @for ($month = 1; $month <= 12; $month++) <td>
                    @php
                    $issueCodes = [];

                    if ($apar->pressure == 'NG') $issueCodes[] = 'a';
                    if ($apar->lock_pin == 'NG') $issueCodes[] = 'b';
                    if ($apar->regulator == 'NG') $issueCodes[] = 'c';
                    if ($apar->tabung == 'NG') $issueCodes[] = 'd';
                    if ($apar->corong == 'NG' && $apar->type === 'co2') $issueCodes[] = 'e';
                    if ($apar->hose == 'NG') $issueCodes[] = 'f';
                    if ($apar->powder == 'NG' && $apar->type === 'powder') $issueCodes[] = 'g';
                    if ($apar->berat_tabung == 'NG' && $apar->type === 'co2') $issueCodes[] = 'h';

                    if (in_array('OK', $issueCodes)) {
                        echo 'OK';
                    } elseif (!empty($issueCodes)) {
                        echo implode('+', $issueCodes);
                    }
                    @endphp
                    </td>
                    @endfor
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
