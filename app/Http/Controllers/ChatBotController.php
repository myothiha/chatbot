<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\FbUser;
use App\Models\Answers\Interfaces\AnswerRepositoryInterface;
use App\Models\AnswerTypes\AnswerType;
use App\Models\Questions\Interfaces\QuestionRepositoryInterface;
use App\Models\QuestionTypes\QuestionType;
use App\Services\Messenger\ApiConstant;
use App\Services\Messenger\ChatBot;
use App\Services\Messenger\RequestHandlerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as UriRequest;
use Illuminate\Support\Facades\Log;

class ChatBotController extends Controller
{

    use RequestHandlerTrait;

    private $chatBot;
    private $questionRepo;
    private $answerRepo;



    public function __construct(ChatBot $chatBot, QuestionRepositoryInterface $questionRepository, AnswerRepositoryInterface $answerRepository)
    {
        $this->chatBot = $chatBot;
        $this->questionRepo = $questionRepository;
        $this->answerRepo = $answerRepository;
    }

    public function verify(Request $request)
    {
        // Your verify token. Should be a random string.
        $VERIFY_TOKEN = "test_token";

        // Parse the query params
        $mode = $request->hub_mode;
        $token = $request->hub_verify_token;
        $challenge = $request->hub_challenge;

        // Checks if a token and mode is in the query string of the request
        if ($mode && $token) {
            // Checks the mode and token sent is correct
            if ($mode == "subscribe" && $token == $VERIFY_TOKEN) {
                // Responds with the challenge token from the request
                echo $challenge;
            }
        }
    }

    public function handle(Request $request)
    {
        // Log::debug($request->all());

        $senderId = $this->getSenderId($request);
        
    
        Log::debug(var_dump($senderId==null));

        // Checks this is an event from a page subscription
        if ($request->object == 'page') {

            $fbUser = FbUser::firstOrNew(['psid' => $this->getSenderId($request)]);

            $this->chatBot->setFbUser($fbUser);

            if ($payload = $this->getPayload($request)) {
                if ($payload == "start") {
                    $this->askToChooseLanguage($fbUser);
                } else if ($this->onSelectedLanguage($payload)) {
                    $fbUser->language = $payload;
                    $fbUser->save();
                    $this->chatBot->greetUser();
                    $this->response($fbUser->language);
                } else if ($this->isManuallyAsk($payload)) {
                    // Todo ask manually
                    // 1 Open Conversation Mode
                    $fbUser->conversationMode(ApiConstant::CONVERSATION_ON);
                    $fbUser->seenMode(ApiConstant::NOT_SEEN);
                    // 2 Ask User to input his request.
                    $this->chatBot->askUserToInputQuestion();
                } else if ( $this->isNotManuallyAsk($payload) ) {

                    $this->chatBot->reply(["Thank you"], ApiConstant::TEXT);

                } else {
                    $this->response($fbUser->language, $payload);
                }
            } else if ($message = $this->getTextMessage($request)) {

                $currentLanguage = $this->chatBot->getFbUser()->language;

                // 1 check if conversation mode is on.
                if ($fbUser->isConversationOn()) {

                    // 2 if yes, save messages to database
                    $conversation = new Conversation(['message' => $message]);
                    $fbUser->conversations()->save($conversation);

                    //3 Turn off Conversation Mode
                    $fbUser->conversationMode(ApiConstant::CONVERSATION_OFF);
                } else {
                    $result = $this->questionRepo->search($message, $currentLanguage);

                    if ($result->isEmpty()) {
                        // 1 . Ask user if he want to ask admin manual Yes or No
                        $this->chatBot->askManually();
                    } else {
                        // 1 . Map Result into gallery view
                        $data = $this->questionRepo->transform($result, ApiConstant::GALLERY, $currentLanguage);
                        // 2 . show result to user
                        $this->chatBot->reply($data->toArray(), ApiConstant::GALLERY);
                    }
                }
            } else {

            }

            // just to verify web hook
            echo $this->getTextMessage($request) ?? '';
        }
    }

    private function askToChooseLanguage(FbUser $fbUser)
    {
        $buttons = [
            [
                "type" => "postback",
                "title" => "ျမန္မာ (ေဇာ္ဂ်ီ)",
                "payload" => ApiConstant::ZAWGYI,
            ],
            [
                "type" => "postback",
                "title" => "မြန်မာ (ယူနီကုဒ်)",
                "payload" => ApiConstant::MYANMAR3,
            ],
            [
                "type" => "postback",
                "title" => "English",
                "payload" => ApiConstant::ENGLISH,
            ],
        ];

        $this->chatBot->postBackButton($buttons, "Choose Language.");
    }

    private function askManuallyButton()
    {
        $data= $this->chatBot->getAskAdminMenus();
        return [
            "title" => $data["message"],
            "image_url" => UriRequest::root() . '/uploads/ask_admin.jpg',
            "subtitle" => "",
            "buttons" => [
                [
                    "type" => "postback",
                    "title" => $data["button"],
                    "payload" => 'yes',
                ]
            ]
        ];
    }

    private function onSelectedLanguage($lang)
    {
        return ($lang == ApiConstant::ZAWGYI || $lang == ApiConstant::MYANMAR3 || $lang == ApiConstant::ENGLISH);
    }

    public function response($lang, $questionId = 0)
    {
        $answerType = AnswerType::where('answer_id', $questionId)->first();

        if ($answerType) {
            $answers = $this->answerRepo->prepare($questionId, $answerType->type, $lang);
            $this->chatBot->reply($answers->toArray(), $answerType->type);
        }

        $questionType = QuestionType::where('question_id', $questionId)->first();

        if ($questionType) {
            $questions = $this->questionRepo->prepare($questionId, $questionType->type, $lang);

            if($this->isTopQuestion($questionId))
            {
                $askManually = $this->askManuallyButton();
                $questions->push($askManually);
            }
            
//            dd($questions->all());

            $this->chatBot->reply($questions->toArray(), $questionType->type);
        }
    }

    private function isTopQuestion($questionId)
    {
        return $questionId==0;
    }

    private function isManuallyAsk($payload)
    {
        return $payload == "yes";
    }

    private function isNotManuallyAsk($payload)
    {
        return $payload == "no";
    }

    public function test()
    {
        $fbUser = FbUser::firstOrNew(['psid' => '1509536415814995']);

//        dd($fbUser->conversations);
        $fbUser->language = 'zg';
        $this->chatBot->setFbUser($fbUser);
        $fbUser->save();

        $this->response($fbUser->language, 0);
//        $this->chatBot->reply(['hi hello how are you'], ApiConstant::TEXT);
//        dd($this->chatBot->getFbUser()->toArray());

        $conversation = new Conversation(['message' => 'I am moe lone. I need help.']);

//        $fbUser->conversations()->save($conversation);

//        dd($fbUser->conversations);

        $this->chatBot->getFbUser()->conversationMode(ApiConstant::CONVERSATION_OFF);
        $result = $this->questionRepo->search('အလုပ္', 'zg');
        $json = $this->questionRepo->transform($result, ApiConstant::GALLERY, ApiConstant::ZAWGYI);
//        dd($json->toArray());
    }




}
