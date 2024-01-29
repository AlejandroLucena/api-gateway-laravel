<?php

declare(strict_types=1);

namespace Modules\Post\Infrastructure\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Post\Application\Query\Find\FindBySlug\FindPostBySlugQuery;
use Modules\Shared\Services\Queries\QueryBus;

final class FindPostBySlugController
{
    public function __construct(
        private readonly QueryBus $queryBus
    ) {
    }

    /**
     * Undocumented function
     */
    public function __invoke(Request $request): array
    {
        $title = (string) $request->input('title');

        $slug = $request->input('slug') ? (string) $request->input('slug') : (string) Str::slug($title);

        $resource = $this->queryBus->query(new FindPostBySlugQuery($slug));

        return $resource;
    }
}
