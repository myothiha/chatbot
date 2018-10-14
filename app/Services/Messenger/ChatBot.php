<?php
/**
 * Created by PhpStorm.
 * User: myothiha
 * Date: 10/8/2018
 * Time: 4:17 PM
 */

namespace App\Services\Messenger;

use App\Models\Answers\Answer;
use App\Models\Questions\Question;
use App\Network\HttpClient\GuzzleHttp;

class ChatBot
{

    use ResponseHandlerTrait;

    private $client;

    public function __construct()
    {
        $this->client = new GuzzleHttp(ApiConstant::BASE_URL);
    }

    public function replyAnswer(Answer $answers, $type)
    {
        switch ($type) {
            case ApiConstant::TEXT :
                $this->text($answers);
                break;
            case ApiConstant::QUICK_REPLY :
                $this->quickReply($answers);
                break;
            case ApiConstant::BUTTON :
                $this->button($answers);
                break;
            case ApiConstant::IMAGE :
                $this->image($answers);
                break;
            case ApiConstant::GALLERY :
                $this->gallery($answers);
                break;
        }
    }

    public function replyQuestion(Question $questions, $questionType)
    {

    }
}
