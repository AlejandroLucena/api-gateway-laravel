<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\Service\Provider;

use Illuminate\Support\ServiceProvider;
use Modules\Post\Domain\Contract\PostRepository;
use Modules\Post\Infrastructure\Persistence\Eloquent\EloquentPostRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(PostRepository::class, EloquentPostRepository::class);
    }
}
