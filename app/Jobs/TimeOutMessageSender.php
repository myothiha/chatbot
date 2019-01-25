<?php

namespace App\Jobs;

use App\FbUser;
use App\Services\Messenger\ChatBot;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TimeOutMessageSender implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fbUser;

    /**
     * Create a new job instance.
     *
     * @param FbUser $fbUser
     */
    public function __construct(FbUser $fbUser)
    {
        $this->fbUser = $fbUser;
    }

    /**
     * Execute the job.
     *
     * @param ChatBot $chatBot
     * @return void
     */
    public function handle(ChatBot $chatBot)
    {
        $chatBot->setFbUser($this->fbUser);
        $chatBot->sentTimeOutMessage();
    }
}
