<?php

namespace App\Http\Controllers;

use App\QuestionTracker;
use App\Services\AnalyticsReport\QuestionAnalyticsReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ButtonAnalyticsController extends Controller
{
    public function index(Request $request, QuestionAnalyticsReport $questionAnalyticsReport)
    {

        $month = $request->month ?? Carbon::now()->month;
        $year = $request->year ?? Carbon::now()->year;

        $trackers = $questionAnalyticsReport->setDateFilter($month, $year)->getTrackerReports();

        return view('admin.button_analytics.index', [
            'trackers' => $trackers,
            'month_filter' => $month,
            'year_filter' => $year
        ]);
    }

    public function exportToExcel(Request $request, QuestionAnalyticsReport $questionAnalyticsReport)
    {
        $month = $request->month ?? Carbon::now()->month;
        $year = $request->year ?? Carbon::now()->year;

        $report = $questionAnalyticsReport->setDateFilter($month, $year);

        return Excel::download($report, 'invoices.xlsx');
    }
}
