<?php

namespace App\Http\Controllers;

use App\FbUser;
use App\Models\Answers\Interfaces\AnswerRepositoryInterface;
use App\Models\AnswerTypes\AnswerType;
use App\Models\Questions\Interfaces\QuestionRepositoryInterface;
use App\Models\QuestionTypes\QuestionType;
use App\Services\Messenger\ApiConstant;
use App\Services\Messenger\ChatBot;
use App\Services\Messenger\RequestHandlerTrait;
use Illuminate\Http\Request;
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
//        Log::debug($request->all());

        $senderId = $this->getSenderId($request);

        // Checks this is an event from a page subscription
        if ($request->object == 'page') {

            $fbUser = FbUser::firstOrNew(['psid' => $this->getSenderId($request)]);
            $this->chatBot->setFbUser($fbUser);

            if ($payload = $this->getPayload($request)) {
                if ($payload == "start") {
                    $this->chatBot->greetUser();
                    $this->askToChooseLanguage($fbUser);
                } else if ($this->onSelectedLanguage($payload)) {
                    $fbUser->language = $payload;
                    $fbUser->save();
                    $this->response($fbUser->language);
                } else if ($this->isManuallyAsk($payload)) {
                    // Todo ask manually
                    // 1 Open Conversation Mode
                    $fbUser->conversationMode(ApiConstant::CONVERSATION_ON);
                    // 2 Ask User to input his request.
                    $this->chatBot->askUserToInputQuestion();
                } else if (!$this->isManuallyAsk($payload)) {
                    // 1 reply something if user didn't choose to ask manually
                } else {
                    $this->response($fbUser->language, $payload);
                }
            } else if ($message = $this->getTextMessage($request)) {

                $currentLanguage = $this->chatBot->getFbUser()->language;

                if ($fbUser->isConversationOn()) {
                    // 1 check if conversation mode is on.
                    // 2 if yes, save messages to database

                    // 3 if no continue
                } else {
                    $result = $this->questionRepo->search($message, $currentLanguage);

                    if ($result->isEmpty()) {
                        //todo Implement Ask Manually Logic here

                        // 1 . Ask user if he want to ask admin manual Yes or No
                        $this->chatBot->askManually();
                    } else {
                        // 1 . Map Result into gallery view
                        $data = $this->questionRepo->transform($result, ApiConstant::GALLERY, $currentLanguage);
                        // 2 . show result to user
                        $this->chatBot->reply($data->toArray(), ApiConstant::GALLERY);
                    }
                }

            }

            // just to verify web hook
            echo $this->getTextMessage($request);
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

    private function onSelectedLanguage($lang)
    {
        return ($lang == ApiConstant::ZAWGYI || $lang == ApiConstant::MYANMAR3 || $lang == ApiConstant::ENGLISH);
    }

    public function response($lang, $questionId = 0)
    {
        $answerType = AnswerType::where('answer_id', $questionId)->first();

        $answers = $this->answerRepo->prepare($questionId, $answerType->type, $lang);
        $this->chatBot->reply($answers->toArray(), $answerType->type);

        $questionType = QuestionType::where('question_id', $questionId)->first();

        if ($questionType) {
            $questions = $this->questionRepo->prepare($questionId, $questionType->type, $lang);
            $this->chatBot->reply($questions->toArray(), $questionType->type);
        }
    }

    private function isManuallyAsk($payload)
    {
        return $payload == "yes";
    }

    public function test()
    {
        $fbUser = FbUser::firstOrNew(['psid' => '2085756598147281']);
        //        $fbUser->language = 'zg';
        $this->chatBot->setFbUser($fbUser);
//        $fbUser->save();
        $this->chatBot->getFbUser()->conversationMode(ApiConstant::CONVERSATION_OFF);
        $result = $this->questionRepo->search('အလုပ္', 'zg');
        $json = $this->questionRepo->transform($result, ApiConstant::GALLERY, ApiConstant::ZAWGYI);
        dd($json->toArray());
    }


}
