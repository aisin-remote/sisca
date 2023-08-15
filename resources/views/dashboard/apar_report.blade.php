@extends('dashboard.app')
@section('title', 'APAR Report')

@section('content')
<div class="container">
    <!-- <h1>APAR Report</h1>
    <hr> -->
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
    </table>
</div>
@endsection