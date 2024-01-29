<?php

declare(strict_types=1);

namespace Modules\Post\Infrastructure\Controller;

use Modules\Post\Application\Query\Find\FindById\FindPostByIdQuery;
use Modules\Shared\Services\Queries\QueryBus;

final class FindPostByIdController
{
    public function __construct(
        private readonly QueryBus $queryBus
    ) {
    }

    public function __invoke(string $id): array
    {
        $resource = $this->queryBus->query(new FindPostByIdQuery($id));

        return $resource;
    }
}
