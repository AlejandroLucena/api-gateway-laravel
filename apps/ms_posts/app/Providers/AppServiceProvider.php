<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Post\Domain\Contract\PostRepository;
use Modules\Post\Infrastructure\Persistence\Eloquent\EloquentPostRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PostRepository::class, EloquentPostRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
