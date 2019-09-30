<?php
/**
 * Created by PhpStorm.
 * User: Myo Thiha
 * Date: 9/19/2019
 * Time: 12:37 PM
 */

namespace App\Services\AnalyticsReport;


use App\QuestionTracker;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class QuestionAnalyticsReport implements FromCollection
{
    private $trackers;
    private $month;
    private $year;

    /**
     * QuestionAnalyticsReport constructor.
     * @param $month
     * @param $year
     * @return QuestionAnalyticsReport
     */
    public function setDateFilter($month = null, $year = null)
    {
        $this->month = $month ?? Carbon::now()->month;
        $this->year = $year ?? Carbon::now()->year;
        $this->trackers = QuestionTracker::where(['month' => $this->month, 'year' => $this->year])->with('question');
        return $this;
    }


    public function getTrackerReports(): Collection
    {
        return $this->trackers->get();
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return $this->exportExcel();
    }

    public function exportExcel()
    {

        //Add Column Heading to Header
        $data = [
            [
                $this->getReportTitle()
            ],
            [
                'Button',
                'Message',
                'Count'
            ]
        ];

        // Add data by fetching from database
        $data[] = $this->getTrackerReports()->map(function ($item, $index) {
            return [
                $item->question->button_en,
                $item->question->message_en,
                $item->count,
            ];
        });

        return collect($data);
    }

    public function getReportTitle()
    {
        return "Button Analytics Report For " . numberToMonth($this->month) . " - " . $this->year;
    }
}
