<?php

declare(strict_types=1);

namespace Modules\Post\Application\Query\Find\FindBySlug;

use Modules\Shared\Services\Queries\Query;

class FindPostBySlugQuery extends Query
{
    public function __construct(
        private readonly string $slug,
    ) {
    }

    public function slug(): string
    {
        return $this->slug;
    }
}
