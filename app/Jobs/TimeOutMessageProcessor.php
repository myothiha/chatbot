<?php

namespace App\Jobs;

use App\FbUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TimeOutMessageProcessor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ChatBot $chatBot)
    {
        Log::debug('TimeOutMessage Processing');
        $fbUsers = FbUser::active()->get();

        $fbUsers->each(function ($item, $key) use ($chatBot) {
            if ( $item->isTimeout() ) {
                $chatBot->setFbUser($item);
                $chatBot->sentTimeOutMessage();
            }
        });
    }
}
