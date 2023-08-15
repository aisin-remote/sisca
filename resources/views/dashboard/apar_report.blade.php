@extends('dashboard.app')
@section('title', 'APAR Report')

@section('content')
<div class="container">
    <div>
        <h4>Catatan:</h4>
        <ul class="list-unstyled d-flex">
            <li><strong>'a':</strong> Pressure /li>
            <li class="mx-4"><strong>'b':</strong> Lock Pin</li>
            <li><strong>'c':</strong> Regulator</li>
            <li class="mx-4"><strong>'d':</strong> Tabung</li>
            <li><strong>'e':</strong> Corong</li>
            <li class="mx-4"><strong>'f':</strong> Hose</li>
            <li><strong>'g':</strong> Powder</li>
            <li class="mx-4"><strong>'h':</strong> Berat Tabung</li>
            <li><strong>'a+b':</strong> Isi Ulang</li>
        </ul>
    </div>

    <br>
    <hr>
    <h3>APAR CO2 Report</h3>
    <table class="text-center table table-striped">
        <thead class="align-middle">
            <tr>
                <th rowspan="2">Tag Number</th>
                <th rowspan="2">Location</th>
                <th colspan="12">Month</th>
            </tr>
            <tr>
                @for ($month = 1; $month <= 12; $month++) <th>{{ $month }}</th>
                    @endfor
            </tr>
        </thead>
        <tbody>
            @foreach ($co2IssueCodes as $aparNumber => $issueCode)
            <tr>
                <td>{{ $aparNumber }}</td>
                <td></td>
                @for ($month = 1; $month <= 12; $month++) <td>
                    @php
                    $issueCodeValue = $issueCode['months'][$month] ?? ''; // Get issue code for this month
                    if (is_array($issueCodeValue)) {
                    echo implode('+', $issueCodeValue);
                    } else {
                    echo $issueCodeValue;
                    }
                    @endphp
                    </td>
                    @endfor
            </tr>
            @endforeach
        </tbody>
    </table>

    <br>
    <hr>

    <h3>APAR Powder Report</h3>
    <table class="text-center table table-striped">
        <thead class="align-middle">
            <tr>
                <th rowspan="2">Tag Number</th>
                <th rowspan="2">Location</th>
                <th colspan="12">Month</th>
            </tr>
            <tr>
                @for ($month = 1; $month <= 12; $month++) <th>{{ $month }}</th>
                    @endfor
            </tr>
        </thead>
        <tbody>
            @foreach ($powderIssueCodes as $aparNumber => $issueCode)
            <tr>
                <td>{{ $aparNumber }}</td>
                <td></td>
                @for ($month = 1; $month <= 12; $month++) <td>
                    @php
                    $issueCodeValue = $issueCode['months'][$month] ?? ''; // Get issue code for this month
                    if (is_array($issueCodeValue)) {
                    echo implode('+', $issueCodeValue);
                    } else {
                    echo $issueCodeValue;
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