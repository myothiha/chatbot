<?php

namespace App\Http\Controllers;

use App\FbUser;
use App\Models\Answers\Answer;
use App\Models\Answers\Interfaces\AnswerRepositoryInterface;
use App\Models\AnswerTypes\AnswerType;
use App\Models\Questions\Interfaces\QuestionRepositoryInterface;
use App\Models\Questions\Question;
use App\Models\QuestionTypes\QuestionType;
use App\Services\Messenger\ApiConstant;
use App\Services\Messenger\ChatBot;
use App\Services\Messenger\RequestHandlerTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
        Log::debug($request->all());

        $senderId = $this->getSenderId($request);

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
                    $this->response($fbUser->language);
                } else {
                    $this->response($fbUser->language, $payload);
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
//        $fbUser = FbUser::firstOrNew(['psid' => 123123112312]);
//        $this->chatBot->setFbUser($fbUser);

        $answerType = AnswerType::where('answer_id', $questionId)->first();

        $answers = $this->answerRepo->prepare($questionId, $answerType->type, $lang);
        $this->chatBot->reply($answers->toArray(), $answerType->type);

        $questionType = QuestionType::where('question_id', $questionId)->first();

        $questions = $this->questionRepo->prepare($questionId, $questionType->type, $lang);
        $this->chatBot->reply($questions->toArray(), $questionType->type);
    }


}
