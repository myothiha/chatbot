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
        ApiConstant::MYANMAR3   => "ဟိုင်း “%username” မယ်ရွှေ့ပြောင်းမှ ကြိုဆိုပါတယ်။",
        ApiConstant::ZAWGYI     => "ဟိုင္း “%username” မယ္ေရႊ႕ေျပာင္းမွ ၾကိဳဆိုပါတယ္။",
        ApiConstant::ENGLISH    => "Hi \"%username\" Welcome to Miss Migration."
    ];

    public $askUserInput = [
        ApiConstant::MYANMAR3   => "မေးမြန်းလိုသော အကြောင်းအရာအား အပြည့်အစုံ ရေးသားပေးပါ",
        ApiConstant::ZAWGYI     => "ေမးျမန္းလိုေသာ အေၾကာင္းအရာအား အျပည့္အစုံ ေရးသားေပးပါ",
        ApiConstant::ENGLISH    => "Ask your question now."
    ];

    private $askAdminManually = [
        ApiConstant::MYANMAR3   => [
            'button'    => "မေးမည်",
            'message'   => "Adminသို့ မေးခွန်းမေးမည်။"
        ],
        ApiConstant::ZAWGYI     => [
            'button'    => "ေမးမည္",
            'message'   => "Adminသို႔ ေမးခြန္းေမးမည္။"
        ],
        ApiConstant::ENGLISH    => [
            'button'    => "Ask",
            'message'   => "Ask Question to Admin"
        ],
    ];

    private $endMessage = [
        ApiConstant::MYANMAR3   => [
            'message'        => 'အခြားမေးခွန်းမေးမည်။',
            'topQuestion'    => "အစက ပြန်မေးမယ်",
            'prevQuestion'   => "နောက်ဆုံးမေးခွန်း"
        ],
        ApiConstant::ZAWGYI     => [
            'message'        => 'အျခားေမးခြန္းေမးမည္။',
            'topQuestion'    => "အစက ျပန္ေမးမယ္",
            'prevQuestion'   => "ေနာက္ဆုံးေမးခြန္း"
        ],
        ApiConstant::ENGLISH    => [
            'message'        => 'Ask another question.',
            'topQuestion'    => "Questions from start.",
            'prevQuestion'   => "Previous question."
        ],
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

    public function getUserInputText()
    {
        return $this->askUserInput[$this->fbUser->language];
    }

    public function getAskAdminMenus()
    {
        return $this->askAdminManually[$this->fbUser->language];
    }

    public function getEndMessage()
    {
        return $this->endMessage[$this->fbUser->language];
    }

    public function setFbUser(FbUser $fbUser)
    {
        $this->fbUser = $fbUser;
        $fbUser->firstName ?? $this->getProfile();
    }

    public function getFbUser()
    {
        return $this->fbUser;
    }

    public function reply(Array $message, $type, $text=null)
    {
        switch ($type) {
            case ApiConstant::TEXT :
                $response = $this->text($message);
                break;
            case ApiConstant::QUICK_REPLY :
                $this->quickReply($message, $text);
                break;
            case ApiConstant::BUTTON :
                $this->multiplePostBack($message);
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

    public function askUserToInputQuestion()
    {
        $this->text([$this->getUserInputText()]);
    }

    public function askManually()
    {
        $buttons = [
            [
                "type" => "postback",
                "title" => "Yes",
                "payload" => "yes",
            ],
            [
                "type" => "postback",
                "title" => "No",
                "payload" => "no",
            ],
        ];

        $this->postBackButton($buttons, "Do you Want to ask admin manually ? ");
    }

    public function endMessage($prevQuestionId)
    {
        $message = $this->getEndMessage();

        $buttons = [
            [
                "type" => "postback",
                "title" => $message["topQuestion"],
                "payload" => $this->fbUser->language,
            ],
            [
                "type" => "postback",
                "title" => $message["prevQuestion"],
                "payload" => $prevQuestionId,
            ],
        ];

        $this->postBackButton($buttons, $message["message"]);
    }

}
