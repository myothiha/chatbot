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

    protected $client;
    private $fbUser;

    public $greeting = [
        ApiConstant::MYANMAR3 => "ဟိုင်း “%username” မယ်ရွှေ့ပြောင်းမှ ကြိုဆိုပါတယ်။",
        ApiConstant::ZAWGYI => "ဟိုင္း “%username” မယ္ေရႊ႕ေျပာင္းမွ ၾကိဳဆိုပါတယ္။",
        ApiConstant::ENGLISH => "Hi \"%username\" Welcome to Miss Migration."
    ];

    public $askUserInput = [
        ApiConstant::MYANMAR3 => "မေးမြန်းလိုသော အကြောင်းအရာအား အပြည့်အစုံ ရေးသားပေးပါ။ \nသင့်ကိုယ်ရေးကိုယ်တာအချက်အလက်များသည် အလွန်အရေးကြီးတယ်ဆိုတာ သတိပြုပါ။ သင့်တွင် ထုတ်ဖော်ပြောခြင်း ပြု၊ မပြုမှာ သင်၏ အခွင့်အရေးဖြစ်သည်။ (ထိန်ချန်ထားပိုင်ခွင့်လည်း ရှိသည်။) \nသင့်ပုဂ္ဂိုလ်ရေးရာကိစ္စကို ကျွန်ုပ်တို့ အလေးထားပါသည်။ \nအကယ်၍ သင်၏ ပုဂ္ဂိုလ်ရေးရာကို ပြောပြရန်အတွက် အဆင်မပြေပါက ကျွန်ုပ်တို့ကို အသိပေးပါ။ ကျွန်ုပ်တို့သည် သင်၏ပုဂ္ဂိုလ်ရေးရာအချက်အလက်များကို သင့်ခွင့်ပြုချက်မပါဘဲ ထုတ်ဖော်ပြောကြားသွားမည် မဟုတ်ပါ။",

        ApiConstant::ZAWGYI => "ေမးျမန္းလိုေသာ အေၾကာင္းအရာအား အျပည့္အစုံ ေရးသားေပးပါ။ \nသင့္ကိုယ္ေရးကိုယ္တာအခ်က္အလက္မ်ားသည္ အလြန္အေရးႀကီးတယ္ဆိုတာ သတိျပဳပါ။ သင့္တြင္ ထုတ္ေဖာ္ေျပာျခင္း ျပဳ၊ မျပဳမွာ သင္၏ အခြင့္အေရးျဖစ္သည္။ (ထိန္ခ်န္ထားပိုင္ခြင့္လည္း ရွိသည္။) \nသင့္ပုဂၢိဳလ္ေရးရာကိစၥကို ကြၽန္ုပ္တို႔ အေလးထားပါသည္။ \nအကယ္၍ သင္၏ ပုဂၢိဳလ္ေရးရာကို ေျပာျပရန္အတြက္ အဆင္မေျပပါက ကြၽန္ုပ္တို႔ကို အသိေပးပါ။ ကြၽန္ုပ္တို႔သည္ သင္၏ပုဂၢိဳလ္ေရးရာအခ်က္အလက္မ်ားကို သင့္ခြင့္ျပဳခ်က္မပါဘဲ ထုတ္ေဖာ္ေျပာၾကားသြားမည္ မဟုတ္ပါ။",

        ApiConstant::ENGLISH => "Ask Your Question Now. \nRemember, your personal information is very important! You have the right not to disclose it. \n We respect your right to privacy. \nIf you feel uncomfortable telling us your private information, let us know. We would never disclose your personal information to anyone without your consent."
    ];

    private $askAdminManually = [
        ApiConstant::MYANMAR3 => [
            'button' => "မေးမည်",
            'message' => "Adminသို့ မေးခွန်းမေးမည်။"
        ],
        ApiConstant::ZAWGYI => [
            'button' => "ေမးမည္",
            'message' => "Adminသို႔ ေမးခြန္းေမးမည္။"
        ],
        ApiConstant::ENGLISH => [
            'button' => "Ask",
            'message' => "Ask Question to Admin"
        ],
    ];

    private $endMessage = [
        ApiConstant::MYANMAR3 => [
            'message' => 'အခြားမေးခွန်းမေးမည်။',
            'topQuestion' => "အစက ပြန်မေးမယ်",
            'prevQuestion' => "နောက်ဆုံးမေးခွန်း"
        ],
        ApiConstant::ZAWGYI => [
            'message' => 'အျခားေမးခြန္းေမးမည္။',
            'topQuestion' => "အစက ျပန္ေမးမယ္",
            'prevQuestion' => "ေနာက္ဆုံးေမးခြန္း"
        ],
        ApiConstant::ENGLISH => [
            'message' => 'Ask another question.',
            'topQuestion' => "Questions from start.",
            'prevQuestion' => "Previous question."
        ],
    ];

    private $resultNotFoundMessage = [
        ApiConstant::MYANMAR3 => [
            'yes' => "မေးမည်။",
            'no' => 'မမေးလိုပါ။',
            'message' => [
                "သင်ပေးပို့တဲ့ စကားလုံးနဲ့ သက်ဆိုင်တဲ့ အကြောင်းအရာကို မတွေ့ရှိပါ။",
                "မေးခွန်းအား အပြည့်အစုံရေးသားပြီး မေးမြန်းလိုပါသလား။"
            ],
        ],
        ApiConstant::ZAWGYI => [
            'yes' => "ေမးမည္။",
            'no' => 'မေမးလိုပါ။',
            'message' => [
                "သင္ေပးပို႔တဲ့ စကားလုံးနဲ႔ သက္ဆိုင္တဲ့ အေၾကာင္းအရာကို မေတြ႕ရွိပါ။",
                "ေမးခြန္းအား အျပည့္အစုံေရးသားၿပီး ေမးျမန္းလိုပါသလား။",
            ],
        ],
        ApiConstant::ENGLISH => [
            'yes' => 'Yes',
            'no' => 'no',
            'message' => [
                'Content not found.',
                'Do you want to write and submit a question for review?',
            ],
        ],
    ];

    public $resultFoundMessage = [
        ApiConstant::MYANMAR3 => "သင်ပေးပို့တဲ့ စကားလုံးနဲ့ သက်ဆိုင်တဲ့ အကြောင်းအရာတွေကတော့",
        ApiConstant::ZAWGYI => "သင္ေပးပို႔တဲ့ စကားလုံးနဲ႔ သက္ဆိုင္တဲ့ အေၾကာင္းအရာေတြကေတာ့",
        ApiConstant::ENGLISH => "These might be what you are looking for -",
    ];

    public $recordMessage = [
        ApiConstant::MYANMAR3 => [
            "သင့်မေးခွန်းကို ကျွန်မ မှတ်သားထားပြီဖြစ်တဲ့အတွက် အမြန်ဆုံးအကြောင်းပြန်ပေးမှာဖြစ်ပါတယ်။",
            "ကောင်းသောနေ့လေး ဖြစ်ပါစေ။"
        ],
        ApiConstant::ZAWGYI => [
            "သင့္ေမးခြန္းကို ကြၽန္မ မွတ္သားထားၿပီျဖစ္တဲ့အတြက္ အျမန္ဆုံးအေၾကာင္းျပန္ေပးမွာျဖစ္ပါတယ္။",
            "ေကာင္းေသာေန႔ေလး ျဖစ္ပါေစ။"
        ],
        ApiConstant::ENGLISH => [
            "Your question has been duly noted. I will  provide an answer as soon as possible.",
            "Have a good day."
        ],
    ];

    public $timeout = [
        ApiConstant::MYANMAR3 => "မင်္ဂလာပါ။ %username မယ်ရွှေ့ပြောင်းကို လာရောက်အသုံးပြုတဲ့အတွက် ကျေးဇူးတင်ပါတယ်။ လူကြီမင်းလည်း ကျွန်မ “မယ်ရွှေ့ပြောင်း” နဲ့ စကားပြောရတာ အဆင်ပြေခဲ့မယ်လို့ ယုံကြည်ပါတယ်။ သတင်းအချက်အလက်များကို ထပ်မံရှာဖွေလိုလျှင် မယ်ရွှေ့ပြောင်းသို့ ထပ်မံပြန်လာပြီး မေးမြန်းနိုင်ပါသည်။ ",
        ApiConstant::ZAWGYI => "မဂၤလာပါ။ %username မယ္ေရႊ႕ေျပာင္းကို လာေရာက္အသံုးျပဳတဲ့အတြက္ ေက်းဇူးတင္ပါတယ္။ လူႀကီမင္းလည္း ကၽြန္မ “မယ္ေရႊ႕ေျပာင္း” နဲ႔ စကားေျပာရတာ အဆင္ေျပခဲ့မယ္လို႔ ယံုၾကည္ပါတယ္။ သတင္းအခ်က္အလက္မ်ားကို ထပ္မံရွာေဖြလိုလွ်င္ မယ္ေရႊ႕ေျပာင္းသို႔ ထပ္မံျပန္လာၿပီး ေမးျမန္းႏိုင္ပါသည္။ ",
        ApiConstant::ENGLISH => "Hello %username. Thank you for using Miss Migration! It was great talking to you. Come back and message me again if you would like to find more information."
    ];

    public function __construct()
    {
        $this->client = new GuzzleHttp(ApiConstant::BASE_URL);
    }

    public function creativeMessage($message, $type = "text")
    {
        if ($type == "video") {
            $message = [
                "attachment" => [
                    "type" => "template",
                    "payload" => [
                        "template_type" => "media",
                        "elements" => [
                            [
                                "media_type" => "video",
                                "url" => "{$message}"
                            ]
                        ]
                    ]
                ]
            ];
        } else {
            $message = [
                "text" => $message
            ];
        }

        $data = [
            'query' => [
                'access_token' => ApiConstant::ACCESS_TOKEN,
            ],
            "json" => [
                'messages' => [
                    $message
                ],
            ]
        ];

//        dd(json_encode($data));

        $response = $this->client->request('POST', ApiConstant::CREATIVE, $data);

        return json_decode($response->getBody()->getContents());
    }

    public function broadcastMessage($message, $type="text", $notiType = "REGULAR")
    {
        $creativeId = $this->creativeMessage($message, $type)->message_creative_id;

        $this->client->request('POST', ApiConstant::BROADCAST, [
            'query' => [
                'access_token' => ApiConstant::ACCESS_TOKEN,
            ],
            "json" => [
                'message_creative_id' => $creativeId,
                'notification_type' => $notiType,
                'messaging_type' => "MESSAGE_TAG",
                "tag" => "NON_PROMOTIONAL_SUBSCRIPTION",
            ]
        ]);
    }

    public function getGreetingText()
    {
        $text = $this->greeting[$this->fbUser->language];
        return str_replace("%username", $this->fbUser->name, $text);
    }

    public function getTimeoutText()
    {
        $text = $this->timeout[$this->fbUser->language];
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

    public function getFbUser(): FbUser
    {
        return $this->fbUser;
    }

    public function reply(Array $message, $type, $text = null)
    {
        $response = [];

        switch ($type) {
            case ApiConstant::TEXT :
                $response = $this->text($message);
                break;
            case ApiConstant::QUICK_REPLY :
                $response = $this->quickReply($message, $text);
                break;
            case ApiConstant::BUTTON :
                $response = $this->multiplePostBack($message);
                break;
            case ApiConstant::IMAGE :
                $response = $this->image($message);
                break;
            case ApiConstant::GALLERY :
                $response = $this->gallery($message);
                break;
        }

        return $response;
    }

    public function greetUser()
    {
        $this->text([$this->getGreetingText()]);
    }

    public function sentTimeOutMessage()
    {
        $this->asyncText([$this->getTimeoutText()]);
        $this->fbUser->setTimeout(FbUser::TIMEOUT_TRUE);
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
