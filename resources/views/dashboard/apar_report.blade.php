@extends('dashboard.app')
@section('title', 'APAR Report')

@section('content')
<div class="container">
    <div>
        <form class="form-inline" method="GET" action="{{ route('apar.report') }}">
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

    <h3>APAR CO2 Report</h3>
    <div class="table-responsive">
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
            @php
            $co2Summarized = [];
            foreach ($co2IssueCodesWithLocation as $issueCode) {
            $aparNumber = $issueCode->apar_number;
            if (!isset($co2Summarized[$aparNumber])) {
            $co2Summarized[$aparNumber] = [
            'location_name' => $issueCode->location_name,
            'months' => array_fill(1, 12, []),
            ];
            }

            foreach ($co2IssueCodes[$aparNumber]['months'] as $month => $codes) {
            foreach ($codes as $code) {
            if (!in_array($code, $co2Summarized[$aparNumber]['months'][$month])) {
            $co2Summarized[$aparNumber]['months'][$month][] = $code;
            }
            }
            }
            }
            @endphp

            @foreach ($co2Summarized as $aparNumber => $data)
            <tr>
                <td>{{ $aparNumber }}</td>
                <td>{{ $data['location_name'] }}</td>
                @for ($month = 1; $month <= 12; $month++) <td>
                    @php
                    $issueCodes = $data['months'][$month];
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


    <br>
    <hr>

    <h3>APAR Powder Report</h3>
    <div class="table-responsive">
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
            @php
            $powderSummarized = [];
            foreach ($powderIssueCodesWithLocation as $issueCode) {
            $aparNumber = $issueCode->apar_number;
            if (!isset($powderSummarized[$aparNumber])) {
            $powderSummarized[$aparNumber] = [
            'location_name' => $issueCode->location_name,
            'months' => array_fill(1, 12, []),
            ];
            }

            foreach ($powderIssueCodes[$aparNumber]['months'] as $month => $codes) {
            foreach ($codes as $code) {
            if (!in_array($code, $powderSummarized[$aparNumber]['months'][$month])) {
            $powderSummarized[$aparNumber]['months'][$month][] = $code;
            }
            }
            }
            }
            @endphp

            @foreach ($powderSummarized as $aparNumber => $data)
            <tr>
                <td>{{ $aparNumber }}</td>
                <td>{{ $data['location_name'] }}</td>
                @for ($month = 1; $month <= 12; $month++) <td>
                    @php
                    $issueCodes = $data['months'][$month];
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

    <br>
    <hr>

    <div>
        <h4>Catatan:</h4>
        <ul class="list-unstyled d-flex">
            <li><strong>'a':</strong> Pressure </li>
            <li class="mx-4"><strong>'b':</strong> Lock Pin</li>
            <li><strong>'c':</strong> Regulator</li>
            <li class="mx-4"><strong>'d':</strong> Tabung</li>
            <li><strong>'e':</strong> Corong</li>
            <li class="mx-4"><strong>'f':</strong> Hose</li>
            <li><strong>'g':</strong> Kadar Konsentrat</li>
            <li class="mx-4"><strong>'h':</strong> Berat</li>
            <li><strong>'a+b':</strong> Isi Ulang</li>
        </ul>
    </div>
</div>
@endsection
