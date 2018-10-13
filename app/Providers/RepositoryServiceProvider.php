<?php

namespace App\Providers;

use App\Models\Answers\Interfaces\AnswerRepositoryInterface;
use App\Models\Answers\Repositories\AnswerRepository;
use App\Models\Questions\Interfaces\QuestionRepositoryInterface;
use App\Models\Questions\Repositories\QuestionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            QuestionRepositoryInterface::class,
            QuestionRepository::class
        );

        $this->app->bind(
            AnswerRepositoryInterface::class,
            AnswerRepository::class
        );
    }
}
