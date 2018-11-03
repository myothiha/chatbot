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

    private $resultNotFoundMessage = [
        ApiConstant::MYANMAR3   => [
            'yes'       => "မေးမည်။",
            'no'        => 'မမေးလိုပါ။',
            'message'   => [
                "သင်ပေးပို့တဲ့ စကားလုံးနဲ့ သက်ဆိုင်တဲ့ အကြောင်းအရာကို မတွေ့ရှိပါ။",
                "မေးခွန်းအား အပြည့်အစုံရေးသားပြီး မေးမြန်းလိုပါသလား။"
            ],
        ],
        ApiConstant::ZAWGYI     => [
            'yes'    => "ေမးမည္။",
            'no'        => 'မေမးလိုပါ။',
            'message'   => [
                "သင္ေပးပို႔တဲ့ စကားလုံးနဲ႔ သက္ဆိုင္တဲ့ အေၾကာင္းအရာကို မေတြ႕ရွိပါ။",
                "ေမးခြန္းအား အျပည့္အစုံေရးသားၿပီး ေမးျမန္းလိုပါသလား။",
            ],
        ],
        ApiConstant::ENGLISH    => [
            'yes'       => 'Yes',
            'no'        => 'no',
            'message'   => 'Content not found.',
            'Do you want to write and submit a question for review?',
        ],
    ];

    public $resultFoundMessage = [
        ApiConstant::MYANMAR3   => "သင်ပေးပို့တဲ့ စကားလုံးနဲ့ သက်ဆိုင်တဲ့ အကြောင်းအရာတွေကတော့",
        ApiConstant::ZAWGYI     => "သင္ေပးပို႔တဲ့ စကားလုံးနဲ႔ သက္ဆိုင္တဲ့ အေၾကာင္းအရာေတြကေတာ့",
        ApiConstant::ENGLISH    => "These might be what you are looking for -",
    ];

    public $recordMessage = [
        ApiConstant::MYANMAR3   => [
            "သင့်မေးခွန်းကို ကျွန်မ မှတ်သားထားပြီဖြစ်တဲ့အတွက် အမြန်ဆုံးအကြောင်းပြန်ပေးမှာဖြစ်ပါတယ်။",
            "ကောင်းသောနေ့လေး ဖြစ်ပါစေ။"
        ],
        ApiConstant::ZAWGYI     => [
            "သင့္ေမးခြန္းကို ကြၽန္မ မွတ္သားထားၿပီျဖစ္တဲ့အတြက္ အျမန္ဆုံးအေၾကာင္းျပန္ေပးမွာျဖစ္ပါတယ္။",
            "ေကာင္းေသာေန႔ေလး ျဖစ္ပါေစ။"
        ],
        ApiConstant::ENGLISH    => [
            "Your question has been duly noted. I will  provide an answer as soon as possible.",
            "Have a good day."
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

    public function getRecordMessage()
    {
        return $this->recordMessage[$this->fbUser->language];
    }

    public function getUserInputText()
    {
        return $this->askUserInput[$this->fbUser->language];
    }

    public function getAskAdminMenus()
    {
        return $this->askAdminManually[$this->fbUser->language];
    }

    public function getResultNotFoundMessage()
    {
        return $this->resultNotFoundMessage[$this->fbUser->language];
    }

    public function getResultFoundMessage()
    {
        return $this->resultFoundMessage[$this->fbUser->language];
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

    public function resultNotFound()
    {
        $message = $this->getResultNotFoundMessage();
        $buttons = [
            [
                "type" => "postback",
                "title" => $message['yes'],
                "payload" => "yes",
            ],
            [
                "type" => "postback",
                "title" => $message['no'],
                "payload" => "no",
            ],
        ];

        $message1 = $message["message"][0];

        $this->reply([$message1], ApiConstant::TEXT);

        $this->postBackButton($buttons, $message["message"][1]);
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

    public function resultFound()
    {
        $this->reply([$this->getResultFoundMessage()], ApiConstant::TEXT);
    }

    public function recordMessage()
    {
        $this->reply($this->getRecordMessage(), ApiConstant::TEXT);
    }

}
