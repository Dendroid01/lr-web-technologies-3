<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\TestResultRepositoryInterface;
use App\Repositories\EloquentTestResultRepository;
use App\Services\ResultsVerificationInterface;
use App\Services\ResultsVerification;
use App\Services\BlogPostService;
use App\Services\BlogImportService;
use App\Services\CommentService;
use App\Services\UserService;
use App\Services\AdminAuthService;

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

        $this->app->singleton(BlogPostService::class);
        $this->app->singleton(BlogImportService::class);
        $this->app->singleton(CommentService::class);
        $this->app->singleton(UserService::class);
        $this->app->singleton(AdminAuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
