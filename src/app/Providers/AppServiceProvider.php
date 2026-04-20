<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\TestResultRepositoryInterface;
use App\Repositories\EloquentTestResultRepository;
use App\Services\ResultsVerificationInterface;
use App\Services\ResultsVerification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            TestResultRepositoryInterface::class,
            EloquentTestResultRepository::class
        );

        $this->app->bind(
            ResultsVerificationInterface::class,
            ResultsVerification::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
