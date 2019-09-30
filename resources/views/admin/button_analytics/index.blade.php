@extends('admin.layouts.app')

@section('title', 'Analytics Report')

@section('heading', 'Analytics')

@section('subheading', 'Report')

<!-- Breadcrumb Section -->
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            Index
        </li>
        <li class="breadcrumb-item">
            <a href="{{ action('ButtonAnalyticsController@index') }}"><b>Button Analytics</b></a>
        </li>
    </ol>
@endsection

@section('content')

    <!-- Content Section -->

    <!-- Analytics List -->
    <div class="row mb-4">

        <form class="form-inline mb-4"  method="GET">
            <div class="form-group mb-2 mr-1">
                <label for="month" class="sr-only">Month</label>
                <select class="form-control" id="month" name="month">
                    @foreach( range(1, 12) as $month)
                        <option value="{{ $month }}"
                                {{ ($month == ($month_filter ?? \Carbon\Carbon::now()->month) ) ? 'selected' : '' }}>
                            {{ $month }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-2 mr-1">
                <label for="year" class="sr-only">Year</label>
                <select class="form-control" id="year" name="year">
                    @php
                        $startYear = 2018;
                        $endYear = \Carbon\Carbon::now()->year + 10;
                    @endphp
                    @foreach( range($startYear, $endYear) as $year)
                        <option value="{{ $year }}"
                                {{ ( $year == ($year_filter ?? \Carbon\Carbon::now()->year)) ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mb-2 mr-2" formaction="{{ action('ButtonAnalyticsController@index') }}">Generate</button>
            <button type="submit" class="btn btn-info mb-2" formaction="{{ action('ButtonAnalyticsController@exportToExcel') }}">Export Excel</button>
        </form>

        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Message</th>
                <th scope="col">Button</th>
                <th scope="col">Count</th>
            </tr>
            </thead>
            <tbody>
            @foreach($trackers as $index => $tracker)
                <tr>
                    <th scope="row">{{ ++$index }}</th>
                    <td><p>{{ $tracker->question->message_en }}</p></td>
                    <td><p>{{ $tracker->question->button_en ?? 'No Btn' }}</p></td>
                    <td><p>{{ $tracker->count }}</p></td>
                </tr>

            @endforeach
            </tbody>
        </table>
    </div>
@endsection
