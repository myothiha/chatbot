<?php
/**
 * Created by PhpStorm.
 * User: myothiha
 * Date: 10/8/2018
 * Time: 4:17 PM
 */

namespace App\Services\Messenger;

use App\FbUser;
use App\Models\Answers\Answer;
use App\Models\Questions\Question;
use App\Network\HttpClient\GuzzleHttp;

class ChatBot
{

    use ResponseHandlerTrait;

    private $client;
    private $fbUser;

    public function __construct()
    {
        $this->client = new GuzzleHttp(ApiConstant::BASE_URL);
    }

    public function setFbUser(FbUser $fbUser)
    {
        $this->fbUser = $fbUser;
    }

    public function reply(Array $message, $type, $text=null)
    {
        switch ($type) {
            case ApiConstant::TEXT :
                $this->text($message);
                break;
            case ApiConstant::QUICK_REPLY :
                $this->quickReply($message, $text);
                break;
            case ApiConstant::BUTTON :
                $this->postBackButton($message, $text);
                break;
            case ApiConstant::IMAGE :
                $this->image($message);
                break;
            case ApiConstant::GALLERY :
                $this->gallery($message);
                break;
        }
    }
}
