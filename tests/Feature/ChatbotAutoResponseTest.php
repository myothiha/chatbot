<?php

namespace Tests\Feature;

use App\Models\Answers\Answer;
use App\Models\Answers\Repositories\AnswerRepository;
use App\Models\Questions\Question;
use App\Models\Questions\Repositories\QuestionRepository;
use App\Services\Messenger\ApiConstant;
use App\Services\Messenger\Utils\Testing\Requests\TestPostBackRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatbotAutoResponseTest extends TestCase
{

    private $postBackRequest;
    private $answerRepo;
    private $questionRepo;

    protected function setUp()
    {
        parent::setUp();
        $this->postBackRequest = new TestPostBackRequest();
        $this->answerRepo = new AnswerRepository(new Answer());
        $this->questionRepo = new QuestionRepository(new Question());
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_getting_start_chatbot()
    {
        $postBackRequest = $this->postBackRequest->getRequestArray('start');
        $response = $this->json('post', '/api/webhook', $postBackRequest);
        $response->assertStatus(200)
            ->assertSee("Choose Language.")
            ->assertSee(ApiConstant::ZAWGYI)
            ->assertSee(ApiConstant::MYANMAR3)
            ->assertSee(ApiConstant::ENGLISH);
    }

    public function test_choose_language()
    {
        $postBackRequest = $this->postBackRequest->getRequestArray('en');

        $answers = $this->answerRepo->getVisibleAnswers()->get();
        $questions = $this->questionRepo->getVisibleQuestions()->get();

        $response = $this->json('post', '/api/webhook', $postBackRequest);

        $response->assertStatus(200);

        foreach ($answers as $answer) {
            $response->assertSee(json_decode($answer->message_en));
        }

        foreach ($questions as $question) {
            $response->assertSee(json_decode($question->message_en));
        }
    }

    public function test_all_question_and_replies()
    {
        $subQuestions = Question::visible()->get();

        foreach ($subQuestions as $question) {
            $answers = $this->answerRepo->getVisibleAnswers($question->id)->get();
            $subQuestions = $this->questionRepo->getVisibleQuestions($question->id)->get();

            if ($subQuestions->isEmpty()) {
                continue;
            }

            $postBackRequest = $this->postBackRequest->getRequestArray($question->id);
            $response = $this->json('post', '/api/webhook', $postBackRequest);

            $response->assertStatus(200);

            foreach ($answers as $answer) {
                $response->assertSee(json_decode($answer->message_en));
            }

            foreach ($subQuestions as $subQuestion) {
                $response->assertSee(json_decode($subQuestion->message_en));
            }
        }
    }
}
