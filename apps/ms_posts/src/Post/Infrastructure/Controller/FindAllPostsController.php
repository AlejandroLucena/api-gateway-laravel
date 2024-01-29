<?php

declare(strict_types=1);

namespace Modules\Post\Infrastructure\Controller;

use Modules\Post\Application\Query\Find\FindAll\FindAllPostQuery;
use Modules\Shared\Services\Queries\QueryBus;

final class FindAllPostsController
{
    public function __construct(
        private readonly QueryBus $queryBus
    ) {
    }

    public function __invoke(): array
    {
        $resource = $this->queryBus->query(new FindAllPostQuery());

        return $resource;
    }
}
