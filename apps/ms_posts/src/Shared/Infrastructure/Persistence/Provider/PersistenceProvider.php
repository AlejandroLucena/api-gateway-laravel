<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Persistence\Provider;

use Illuminate\Support\ServiceProvider;
use Modules\Post\Domain\Contract\PostRepository;

class PersistenceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public function boot()
    {
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $models = [
            'Post',
        ];

        foreach ($models as $idx => $model) {
            $this->app->bind("Modules\{$model}\Domain\Contract\{$model}Repository", "Modules\{$model}\Infrastructure\Persistence\Eloquent\Eloquent{$model}Repository");
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            PostRepository::class,
        ];
    }
}
