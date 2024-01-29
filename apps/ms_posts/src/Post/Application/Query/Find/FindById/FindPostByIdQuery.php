<?php

declare(strict_types=1);

namespace Modules\Post\Application\Query\Find\FindById;

use Modules\Shared\Services\Queries\Query;

/**
 * Summary of FindPostByIdQuery
 */
class FindPostByIdQuery extends Query
{
    public function __construct(
        private readonly string $id
    ) {
    }

    /**
     * Summary of id
     */
    public function id(): string
    {
        return $this->id;
    }
}
