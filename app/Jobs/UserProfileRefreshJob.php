<?php

namespace App\Jobs;

use App\FbUser;
use App\Services\Messenger\ChatBot;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class UserProfileRefreshJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fbUser;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(FbUser $fbUser)
    {
        $this->fbUser = $fbUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->fbUser;
        $lastUpdate = $user->updated_at->diff(now())->days;

        try {
            if( $lastUpdate > 10)
            {
                $chatbot = new ChatBot();
                $chatbot->setFbUser($user);
                $chatbot->getProfile();
            }
        } catch (\Exception $e) {
            Log::error("Profile Refresher Error" . $e->getMessage());
        }
    }
}
