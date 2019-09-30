<?php
/**
 * Created by PhpStorm.
 * User: Myo Thiha
 * Date: 9/19/2019
 * Time: 11:07 AM
 */

namespace App\Services\AnalyticsReport;


use App\Models\Questions\Question;
use App\QuestionTracker;
use Carbon\Carbon;

class QuestionAnalyticsTracker
{
    private $questionTracker;

    /**
     * QuestionAnalyticsReport constructor.
     * @param $questionTracker
     */
    private function __construct($questionTracker)
    {
        $this->questionTracker = $questionTracker;
    }

    public static function createFrom($question_id) {
        $questionTracker = QuestionTracker::firstOrCreate([
            'question_id' => $question_id,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year
        ]);

        return new QuestionAnalyticsTracker($questionTracker);
    }

    public function increaseClickCounter()
    {
        $this->questionTracker->increaseCounter();
    }
}