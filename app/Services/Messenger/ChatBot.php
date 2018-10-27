<?php
/**
 * Created by PhpStorm.
 * User: myothiha
 * Date: 10/8/2018
 * Time: 4:17 PM
 */

namespace App\Services\Messenger;

use App\FbUser;
use App\Network\HttpClient\GuzzleHttp;

class ChatBot
{

    use ResponseHandlerTrait;

    private $client;
    private $fbUser;

    public $greeting = [
        ApiConstant::MYANMAR3   => "မင်္ဂလာပါ %username Miss Migration မှကြိုဆိုပါတယ်။ မေးမြန်းလိုသော အကြောင်းအရာကို ရွေးချယ်ပေးပါ",
        ApiConstant::ZAWGYI     => "မဂၤလာပါ %username Miss Migration မွႀကိဳဆိုပါတယ္။ ေမးျမန္းလိုေသာ အေၾကာင္းအရာကို ေရြးခ်ယ္ေပးပါ",
        ApiConstant::ENGLISH    => "Hi %username. Welcome to Miss Migration. Please select your questions."
    ];

    public function __construct()
    {
        $this->client = new GuzzleHttp(ApiConstant::BASE_URL);
    }


    public function getGreetingText()
    {
        $text = $this->greeting[$this->fbUser->language];
        return str_replace("%username", $this->fbUser->name, $text);
    }

    public function setFbUser(FbUser $fbUser)
    {
        $this->fbUser = $fbUser;
        $this->getProfile();
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

    public function greetUser()
    {
        $this->text([$this->getGreetingText()]);
    }
}
