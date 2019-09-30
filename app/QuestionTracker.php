<?php

namespace App;

use App\Models\Questions\Question;
use Illuminate\Database\Eloquent\Model;

class QuestionTracker extends Model
{
    protected $fillable = ['question_id', 'count', 'month', 'year'];

    public function increaseCounter()
    {
        $this->count++;
        $this->save();
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }


}
