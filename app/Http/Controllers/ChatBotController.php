<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\FbUser;
use App\Jobs\ProcessAllFbUsersJob;
use App\Jobs\TimeOutMessageProcessor;
use App\Models\Answers\Interfaces\AnswerRepositoryInterface;
use App\Models\AnswerTypes\AnswerType;
use App\Models\Questions\Interfaces\QuestionRepositoryInterface;
use App\Models\Questions\Question;
use App\Models\Questions\Repositories\QuestionRepository;
use App\Models\QuestionTypes\QuestionType;
use App\Services\Messenger\ApiConstant;
use App\Services\Messenger\ChatBot;
use App\Services\Messenger\RequestHandlerTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request as UriRequest;

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
         //Log::debug($request->all());

//        dd($request);

        $senderId = $this->getSenderId($request);

        // Checks this is an event from a page subscription
        if ($request->object == 'page' AND json_encode($senderId)!='null' AND $senderId!=422359484916418) {

            $fbUser = FbUser::firstOrNew(['psid' => $senderId]);

            $this->chatBot->setFbUser($fbUser);

            $this->setUserActive();

            if ($payload = $this->getPayload($request)) {

                /*$this->chatBot->senderAction('mark_seen');
                $this->chatBot->senderAction('typing_on');
                sleep(1);*/

                Log::debug($payload);

                if ($payload == "start") {
                    return $this->askToChooseLanguage($fbUser);
                } else if ($this->onSelectedLanguage($payload)) {
                    $fbUser->language = $payload;
                    $fbUser->save();
                    $this->chatBot->greetUser();
                    return $this->response($fbUser->language);
                }

                /*
                 * Disable Ask Manually Feature
                 * */
                /*else if ($this->isManuallyAsk($payload)) {
                    // Todo ask manually
                    // 1 Open Conversation Mode
                    $fbUser->conversationMode(ApiConstant::CONVERSATION_ON);
                    $fbUser->seenMode(ApiConstant::NOT_SEEN);
                    // 2 Ask User to input his request.
                    $this->chatBot->askUserToInputQuestion();
                } else if ( $this->isNotManuallyAsk($payload) ) {
                    $this->chatBot->reply(["Thank you. Ask another question."], ApiConstant::TEXT);
                    $this->response($fbUser->language); // Response Top Question.
                }*/
                else {
                    return $this->response($fbUser->language, $payload);
                }
            }

            /*
             * Todo Disable Search Feature. Do nothing if text message receive
             * */
            /*else if ($message = $this->getTextMessage($request)) {

                $currentLanguage = $this->chatBot->getFbUser()->language;

                // 1 check if conversation mode is on.
                if ($fbUser->isConversationOn()) {

                    // 2 if yes, save messages to database
                    $conversation = new Conversation(['message' => $message]);
                    $fbUser->conversations()->save($conversation);

                    //3 Turn off Conversation Mode
                    $fbUser->conversationMode(ApiConstant::CONVERSATION_OFF);
                    $this->chatBot->recordMessage();
                } else {
                    $result = $this->questionRepo->search($message, $currentLanguage);

                    if ($result->isEmpty()) {
                        // 1 . Ask user if he want to ask admin manual Yes or No
                        $this->chatBot->resultNotFound();
                    } else {
                        //Reply a message result have been found
                        $this->chatBot->resultFound();
                        // 1 . Map Result into gallery view
                        $data = $this->questionRepo->transform($result, ApiConstant::GALLERY, $currentLanguage);
                        // 2 . show result to user
                        $this->chatBot->reply($data->toArray(), ApiConstant::GALLERY);
                    }
                }
            }*/

            // To verify web hook
            echo $this->getTextMessage($request) ?? '';
        }
    }

    public function response($lang, $questionId = 0)
    {
        $response = [];

        $answerType = AnswerType::where('answer_id', $questionId)->first();

        if ($answerType) {
            $answers = $this->answerRepo->prepare($questionId, $answerType->type, $lang);
            $response[] = $this->chatBot->reply($answers->toArray(), $answerType->type);
        }

        $questionType = QuestionType::where('question_id', $questionId)->first();

        if ($questionType) {
            $questions = $this->questionRepo->prepare($questionId, $questionType->type, $lang);

            if($questions->isEmpty()){
                $this->endQuestion($questionId);
            } else {
                /*
                 * Remove Ask Admin Button from Top Question
                 * */
                /*if($this->isTopQuestion($questionId))
                {
                    $askManually = $this->askManuallyButton();
                    $questions->push($askManually);
                }*/
                $response[] = $this->chatBot->reply($questions->toArray(), $questionType->type);
            }
        } else {
            $this->endQuestion($questionId);
        }

        return $response;
    }

    private function endQuestion($questionId)
    {
        $prevId = $this->questionRepo->getPreviousQuestion($questionId, 3);
        $this->chatBot->endMessage($prevId);
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

        return $this->chatBot->postBackButton($buttons, "Choose Language.");
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

    private function setUserActive()
    {
        $this->chatBot->getFbUser()->setTimeout(FbUser::TIMEOUT_FALSE);
        $this->chatBot->getFbUser()->active_at = Carbon::now();
        $this->chatBot->getFbUser()->save();
    }

    public function test()
    {
        ProcessAllFbUsersJob::dispatch();
        /*FbUser::chunk(200, function($users) {
            foreach($users as $user) {
                $lastUpdate = $user->updated_at->diff(now())->days;

                    try {
                        if( $lastUpdate > 10)
                        {
                            $chatbot = new ChatBot();
                            $chatbot->setFbUser($user);
                            $chatbot->getProfile();
                        }
                    } catch (\Exception $e) {
                        Log::error($e->getMessage());
                        continue;
                    }
            }
        });*/
        /*$fbUser = FbUser::firstOrNew(['psid' => '1889983827706459']);

//        dd($fbUser->conversations);
        $fbUser->language = 'zg';
        $this->chatBot->setFbUser($fbUser);
        $fbUser->save();

//        $this->response($fbUser->language, 28);

        $this->response('zg', 0);
        dd('hi');
        $this->chatBot->resultNotFound();
        $this->chatBot->resultFound();
        $this->chatBot->recordMessage();

//        $this->chatBot->reply(['hi hello how are you'], ApiConstant::TEXT);
//        dd($this->chatBot->getFbUser()->toArray());

        $conversation = new Conversation(['message' => 'I am moe lone. I need help.']);

//        $fbUser->conversations()->save($conversation);

//        dd($fbUser->conversations);

        $this->chatBot->getFbUser()->conversationMode(ApiConstant::CONVERSATION_OFF);
        $result = $this->questionRepo->search('အလုပ္', 'zg');
        $json = $this->questionRepo->transform($result, ApiConstant::GALLERY, ApiConstant::ZAWGYI);*/
//        dd($json->toArray());
    }




}
